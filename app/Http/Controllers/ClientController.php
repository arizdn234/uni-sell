<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function dashboard()
    {
        // Fetch top-selling products
        $topSellingProducts = DB::table('order_items')
            ->select('products.id', 'products.name', 'products.price', 'products.image_url')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('SUM(order_items.quantity) as total_sales')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.image_url')
            ->orderBy('total_sales', 'desc')
            ->take(8)
            ->get();

        // Fetch best products per category with category names
        $bestProductsPerCategory = Product::with('category')
            ->select('category_id', 'name', 'price', 'image_url')
            ->get()
            ->groupBy('category_id')
            ->map(function ($products) {
                return $products->sortByDesc('price')->take(8);
            });

        // Get category names
        $categories = Category::pluck('name', 'id')->toArray();

        return view('user.dashboard', [
            'topSellingProducts' => $topSellingProducts,
            'bestProductsPerCategory' => $bestProductsPerCategory,
            'categories' => $categories
        ]);
    }

    public function dashboardNoLogin()
    {
        // Fetch top-selling products
        $topSellingProducts = DB::table('order_items')
            ->select('products.id', 'products.name', 'products.price', 'products.image_url')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('SUM(order_items.quantity) as total_sales')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.image_url')
            ->orderBy('total_sales', 'desc')
            ->take(8)
            ->get();

        // Fetch best products per category with category names
        $bestProductsPerCategory = Product::with('category')
            ->select('category_id', 'name', 'price', 'image_url')
            ->get()
            ->groupBy('category_id')
            ->map(function ($products) {
                return $products->sortByDesc('price')->take(8);
            });

        // Get category names
        $categories = Category::pluck('name', 'id')->toArray();

        return view('user.dashboard', [
            'topSellingProducts' => $topSellingProducts,
            'bestProductsPerCategory' => $bestProductsPerCategory,
            'categories' => $categories
        ]);
    }
}

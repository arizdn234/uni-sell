<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
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
        $bestProductsPerCategory = DB::table('products')
            ->select('id', 'category_id', 'name', 'price', 'image_url')
            ->get()
            ->groupBy('category_id')
            ->map(function ($products) {
                return $products->take(8);
            });

        // Get category names
        $categories = Category::pluck('name', 'id')->toArray();

        return view('user.dashboard', [
            'topSellingProducts' => $topSellingProducts,
            'bestProductsPerCategory' => $bestProductsPerCategory,
            'categories' => $categories
        ]);
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
                              ->where('id', '!=', $product->id)
                              ->take(4)
                              ->get();

        $product = Product::with('reviews.user', 'category')->findOrFail($id);
        $averageRating = $product->reviews->avg('rating');
                              
        return view('user/product-detail', compact('product', 'averageRating', 'relatedProducts'));
    }

    public function checkout(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Please select at least one item to proceed to checkout.');
        }

        $cart = Cart::with('items.product')->find(session('cart_id'));

        if (!$cart) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        $selectedItems = $cart->items->whereIn('id', $selectedItems);

        $total = $selectedItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.checkout', compact('selectedItems', 'total'));
    }

    public function showCheckout()
    {
        $cart = Cart::with('items.product')->find(session('cart_id'));

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        $total = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.checkout', ['selectedItems' => $cart->items, 'total' => $total]);
    }
    
    public function promo()
    {
        return view('user.promo');
    }

    public function newArrivals()
    {
        return view('user.new');
    }
}

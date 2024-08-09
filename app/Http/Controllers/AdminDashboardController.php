<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Helpers\CurrencyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch review data for charts
        $reviewStats = Review::selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->all();

        // Fetch order data for charts
        $ordersPerMonth = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->all();

        // Fill missing months with zero orders
        $monthlyOrders = array_fill(1, 12, 0);
        foreach ($ordersPerMonth as $month => $count) {
            $monthlyOrders[$month] = $count;
        }

        // Fetch total counts for statistics
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalReviews = Review::count();

        // Calculate total revenue
        $totalRevenue = Order::select(DB::raw('SUM(CAST(REPLACE(total_amount, ",", "") AS DECIMAL(20,2))) as total_revenue'))
            ->pluck('total_revenue')
            ->first() ?? 0;

        // Find the top product by revenue
        $topProduct = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity * price) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->first();

        $topProductRevenue = $topProduct ? $topProduct->total_revenue : 0;
        $topProductId = $topProduct ? $topProduct->product_id : null;

        // Calculate top 10 products by revenue
        $topProducts = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity * price) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->take(10)
            ->get()
            ->pluck('total_revenue', 'product_id')
            ->all();

        $topProductNames = Product::whereIn('id', array_keys($topProducts))
            ->pluck('name', 'id')
            ->all();

        // Calculate average order value
        $averageOrderValue = Order::select(DB::raw('AVG(CAST(REPLACE(total_amount, ",", "") AS DECIMAL(20,2))) as average_order_value'))
            ->pluck('average_order_value')
            ->first() ?? 0;

        // Calculate most popular products
        $mostPopularProducts = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get()
            ->pluck('total_quantity', 'product_id')
            ->all();

        $mostPopularProductNames = Product::whereIn('id', array_keys($mostPopularProducts))
            ->pluck('name', 'id')
            ->all();

        // Calculate average review rating
        $averageRating = Review::avg('rating') ?? 0;

        // Orders by status, sorted by count in descending order
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->orderByDesc('count')
            ->pluck('count', 'status')
            ->all();

        // Revenue by category, sorted by total revenue in descending order
        $revenueByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'))
            ->groupBy('categories.name')
            ->orderByDesc('total_revenue')
            ->pluck('total_revenue', 'category_name')
            ->all();

        // Prepare data for charts and statistics
        $data = [
            'reviewStats' => $reviewStats,
            'monthlyOrders' => $monthlyOrders,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers,
            'totalReviews' => $totalReviews,
            'totalRevenue' => CurrencyHelper::formatCurrency($totalRevenue),
            'topProductRevenue' => CurrencyHelper::formatCurrency($topProductRevenue),
            'topProductId' => $topProductId,
            'averageOrderValue' => CurrencyHelper::formatCurrency($averageOrderValue),
            'mostPopularProducts' => $mostPopularProducts,
            'mostPopularProductNames' => $mostPopularProductNames,
            'averageRating' => $averageRating,
            'ordersByStatus' => $ordersByStatus,
            'revenueByCategory' => $revenueByCategory,
            'topProducts' => $topProducts,
            'topProductNames' => $topProductNames,
        ];

        return view('admin.dashboard', $data);
    }
}

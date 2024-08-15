<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Review;
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
        $product = Product::with('reviews.user', 'category')->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->take(4)
                                ->get();

        $averageRating = $product->reviews->avg('rating');
        $reviews = $product->reviews()->take(5)->get();
        $totalReviews = $product->reviews->count();

        return view('user.product-detail', compact('product', 'averageRating', 'relatedProducts', 'reviews', 'totalReviews'));
    }

    public function loadMoreReviews($id)
    {
        $page = request()->get('page', 1);
        $reviews = Review::where('product_id', $id)
                        ->with('user')
                        ->skip(($page - 1) * 5)
                        ->take(5)
                        ->get();

        return response()->json([
            'reviews' => $reviews->map(function($review) {
                return [
                    'user' => [
                        'name' => $review->user->name,
                    ],
                    'created_at' => $review->created_at->diffForHumans(),
                    'comment' => $review->comment,
                    'rating' => $review->rating,
                ];
            })
        ]);
    }

    public function processCheckout(Request $request)
    {
        $selectedItemIds = $request->input('selected_items', []);

        $order = auth()->user()->orders()->create([
            'shipping_address' => $request->input('shipping_address'), 
            'total_amount' => $request->input('total_amount'), 
            'address' => $request->input('address'),
            'payment_method' => $request->input('payment_method'),
        ]);

        foreach (auth()->user()->cart->items()->whereIn('id', $selectedItemIds)->get() as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            $item->delete();
        }

        return redirect()->route('user.cart')
                        ->with('success', 'Order placed successfully!');
    }

    public function checkoutPage(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        $quantities = $request->input('quantities', []);

        $cartItems = collect();
        $total = 0;

        foreach ($selectedItems as $itemId) {
            $item = CartItem::find($itemId);

            if ($item) {
                $quantity = $quantities[$itemId] ?? 1;
                $item->quantity = $quantity;
                $item->subtotal = $item->product->price * $quantity;
                $cartItems->push($item);
                $total += $item->subtotal;
            }
        }

        return view('user.checkout', compact('cartItems', 'total'));
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

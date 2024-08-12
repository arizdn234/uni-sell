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

    public function cart(Request $request)
    {
        $user = $request->user();

        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        $total = 0;
        if ($cart) {
            $total = $cart->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });
        }

        return view('user.cart', compact('cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = $request->user();
        $productId = $request->input('product_id');

        // Find or create the cart for the user
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Check if the product is already in the cart
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $productId)
                        ->first();

        if ($item) {
            // If the product is already in the cart, increase the quantity
            $item->increment('quantity');
        } else {
            // Otherwise, add a new item to the cart
            $product = Product::find($productId);
            $cart->items()->create([
                'product_id' => $productId,
                'price' => $product->price,
                'quantity' => 1,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Product added to cart!']);
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

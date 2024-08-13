<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('cart', 'product')->get();
        return response()->json($cartItems);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $userId = auth()->id(); 

        try {
            
            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            
            $cartItem = CartItem::where('cart_id', $cart->id)
                                ->where('product_id', $productId)
                                ->first();

            if ($cartItem) {
                
                $cartItem->increment('quantity', $quantity);
            } else {
                
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Product added to cart']);
        } catch (\Exception $e) {
            
            return response()->json(['success' => false, 'message' => 'Failed to add product to cart']);
        }
    }

    public function show(CartItem $cartItem)
    {
        $cartItem->load('cart', 'product');
        return response()->json($cartItem);
    }

    public function update(Request $request, $itemId)
    {
        $quantity = $request->input('quantity');
        $cart = auth()->user()->cart;
        $cartItem = $cart->items()->where('id', $itemId)->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Item not found in cart.']);
        }

        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Invalid quantity.']);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        $itemTotal = $cartItem->product->price * $cartItem->quantity;

        $cartTotal = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'item_total' => $itemTotal,
            'cart_total' => $cartTotal,
            'message' => 'Item updated successfully'
        ]);
    }

    public function destroy($itemId)
    {
        $cart = auth()->user()->cart;
        $cartItem = $cart->items()->where('id', $itemId)->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Item not found in cart.']);
        }

        $cartItem->delete();

        $cartTotal = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'cart_total' => $cartTotal,
            'message' => 'Item removed successfully.'
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

    private function calculateCartTotal()
    {
        return CartItem::with('product')
            ->get()
            ->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
    }
}

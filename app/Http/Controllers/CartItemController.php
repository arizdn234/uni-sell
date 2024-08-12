<?php

namespace App\Http\Controllers;

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
        $validatedData = $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::create($validatedData);

        return response()->json($cartItem, 201);
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
        $cartItem->quantity = $quantity;
        $cartItem->save();

        $cartTotal = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'item_total' => $cartItem->price * $cartItem->quantity,
            'cart_total' => $cartTotal,
            'message' => 'Item updated successfully'
        ]);
    }

    public function destroy($itemId)
    {
        $cartItem = CartItem::find($itemId);

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart item deleted successfully.',
            'cart_total' => $this->calculateCartTotal()
        ]);
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

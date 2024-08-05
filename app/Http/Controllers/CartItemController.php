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

    public function update(Request $request, CartItem $cartItem)
    {
        $validatedData = $request->validate([
            'cart_id' => 'exists:carts,id',
            'product_id' => 'exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        $cartItem->update($validatedData);

        return response()->json($cartItem);
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json(['message' => 'Cart item deleted successfully']);
    }
}

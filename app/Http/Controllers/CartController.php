<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('user', 'items.product')->get();
        return response()->json($carts);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cart = Cart::create($validatedData);

        return response()->json($cart, 201);
    }

    public function show(Cart $cart)
    {
        $cart->load('user', 'items.product');
        return response()->json($cart);
    }

    public function update(Request $request, Cart $cart)
    {
        $validatedData = $request->validate([
            'user_id' => 'exists:users,id',
        ]);

        $cart->update($validatedData);

        return response()->json($cart);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully']);
    }
}

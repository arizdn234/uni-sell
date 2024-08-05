<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shipping::with('order')->get();
        return response()->json($shippings);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'shipping_method' => 'required|string',
            'tracking_number' => 'required|string',
            'status' => 'required|string',
        ]);

        $shipping = Shipping::create($validatedData);

        return response()->json($shipping, 201);
    }

    public function show(Shipping $shipping)
    {
        $shipping->load('order');
        return response()->json($shipping);
    }

    public function update(Request $request, Shipping $shipping)
    {
        $validatedData = $request->validate([
            'order_id' => 'exists:orders,id',
            'shipping_method' => 'string',
            'tracking_number' => 'string',
            'status' => 'string',
        ]);

        $shipping->update($validatedData);

        return response()->json($shipping);
    }

    public function destroy(Shipping $shipping)
    {
        $shipping->delete();

        return response()->json(['message' => 'Shipping deleted successfully']);
    }
}

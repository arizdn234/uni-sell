<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with('order', 'product')->get();
        return response()->json($orderItems);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderItem = OrderItem::create($validatedData);

        return response()->json($orderItem, 201);
    }

    public function show(OrderItem $orderItem)
    {
        $orderItem->load('order', 'product');
        return response()->json($orderItem);
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $validatedData = $request->validate([
            'order_id' => 'exists:orders,id',
            'product_id' => 'exists:products,id',
            'quantity' => 'integer|min:1',
            'price' => 'numeric|min:0',
        ]);

        $orderItem->update($validatedData);

        return response()->json($orderItem);
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return response()->json(['message' => 'Order item deleted successfully']);
    }
}

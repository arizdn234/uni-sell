<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::query()->with('user');

        // Searching functionality
        if ($search = $request->get('search')) {
            $query->where('order_number', 'like', "%{$search}%")
                ->orWhere('customer_name', 'like', "%{$search}%");
        }

        // Sorting functionality
        switch ($request->get('sort')) {
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'total_asc':
                $query->orderBy('total_amount', 'asc');
                break;
            case 'total_desc':
                $query->orderBy('total_amount', 'desc');
                break;
        }

        // Get the paginated orders
        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string',
            'payment_method' => 'required|string',
            'shipping_address' => 'required|string',
        ]);

        $order = Order::create($validatedData);

        return response()->json($order, 201);
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'payment', 'shipping');
        return response()->json($order);
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'user_id' => 'exists:users,id',
            'total_amount' => 'numeric|min:0',
            'status' => 'string',
            'payment_method' => 'string',
            'shipping_address' => 'string',
        ]);

        $order->update($validatedData);

        return response()->json($order);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}

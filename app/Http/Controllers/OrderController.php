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
            $query->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  });
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
    public function show($id)
    {
        $order = Order::query()->with('user')->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string|max:255',
            'shipping_address' => 'required|string',
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'payment_method' => $request->input('payment_method'),
            'shipping_address' => $request->input('shipping_address'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
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

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Order deleted successfully']);
        }

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}

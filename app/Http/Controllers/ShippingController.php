<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Models\Order;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');

        $query = Shipping::query();

        // Search functionality
        if ($search) {
            $query->where('tracking_number', 'like', '%' . $search . '%');
        }

        // Sorting functionality
        switch ($sort) {
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $shippings = $query->paginate(10);

        return view('admin.shippings.index', compact('shippings'));
    }

    public function create()
    {
        $orders = Order::all();
        return view('admin.shippings.create', compact('orders'));
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

        return redirect()->route('shippings.index')->with('success', 'Shipping created successfully.');
    }

    public function show(Shipping $shipping)
    {
        $shipping->load('order');
        return view('admin.shippings.show', compact('shipping'));
    }

    public function edit(Shipping $shipping)
    {
        return view('admin.shippings.edit', compact('shipping'));
    }

    // Update the specified shipping in storage
    public function update(Request $request, Shipping $shipping)
    {
        $request->validate([
            'shipping_method' => 'required|string',
            'status' => 'required|string|in:shipped,arrived,processed',
        ]);

        $shipping->update($request->all());

        return redirect()->route('shippings.index')->with('success', 'Shipping updated successfully.');
    }

    // Remove the specified shipping from storage
    public function destroy(Shipping $shipping)
    {
        $shipping->delete();

        return redirect()->route('shippings.index')->with('success', 'Shipping deleted successfully.');
    }
}

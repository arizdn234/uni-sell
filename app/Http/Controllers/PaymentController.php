<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::query();

        if ($request->filled('search')) {
            $query->where('amount', 'like', '%' . $request->search . '%')
                  ->orWhere('payment_method', 'like', '%' . $request->search . '%')
                  ->orWhere('status', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort')) {
            $sortOptions = [
                'amount_asc' => ['amount', 'asc'],
                'amount_desc' => ['amount', 'desc'],
                'date_asc' => ['created_at', 'asc'],
                'date_desc' => ['created_at', 'desc'],
            ];

            if (array_key_exists($request->sort, $sortOptions)) {
                $query->orderBy($sortOptions[$request->sort][0], $sortOptions[$request->sort][1]);
            }
        }

        $payments = $query->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('order')->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }

    public function create()
    {
        $orders = Order::all();

        return view('admin.payments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|in:pending,completed,failed',
        ]);

        Payment::create($request->all());

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);

        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);

        $payment = Payment::findOrFail($id);

        $payment->update([
            'payment_method' => $request->input('payment_method'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}

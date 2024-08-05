<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')->get();
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);

        $payment = Payment::create($validatedData);

        return response()->json($payment, 201);
    }

    public function show(Payment $payment)
    {
        $payment->load('order');
        return response()->json($payment);
    }

    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'order_id' => 'exists:orders,id',
            'amount' => 'numeric|min:0',
            'payment_method' => 'string',
            'status' => 'string',
        ]);

        $payment->update($validatedData);

        return response()->json($payment);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully']);
    }
}

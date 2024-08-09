@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add New Payment') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <!-- Payment Form -->
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="order_id" class="block text-sm font-medium text-gray-300">Order ID</label>
                    <select name="order_id" id="order_id" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                        <!-- Options will be populated dynamically based on your orders -->
                        @foreach ($orders as $order)
                            <option value="{{ $order->id }}">{{ $order->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-300">Amount</label>
                    <input type="number" name="amount" id="amount" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                </div>

                <div class="flex flex-col">
                    <label for="payment_method" class="text-sm font-medium text-gray-300">Payment Method</label>
                    <select id="payment_method" name="payment_method" class="mt-1 p-2 rounded bg-gray-700 text-gray-300">
                        <option value="credit_card">Credit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                        <option value="cash_on_delivery">Cash on Delivery</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                    <select name="status" id="status" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                    Add Payment
                </button>
                <a href="{{ route('payments.index') }}" class="ml-3 bg-gray-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Back to Payments</a>
            </form>
        </div>
    </div>
@endsection

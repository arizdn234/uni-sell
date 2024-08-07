@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit Order') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <div class="flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-300">Edit Order Information</h3>
                </div>

                <form method="POST" action="{{ route('orders.update', $order->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Customer Name (readonly) -->
                    <div class="flex flex-col">
                        <label for="customer_name" class="text-sm font-medium text-gray-300">Customer Name</label>
                        <input type="text" id="customer_name" value="{{ $order->user->name ?? 'N/A' }}" class="mt-1 p-2 rounded bg-gray-700 text-gray-300" readonly>
                    </div>

                    <!-- Total Amount (readonly) -->
                    <div class="flex flex-col">
                        <label for="total_amount" class="text-sm font-medium text-gray-300">Total Amount</label>
                        <input type="text" id="total_amount" value="Rp. {{ number_format((float)str_replace(',', '', $order->total_amount), 2) }}" class="mt-1 p-2 rounded bg-gray-700 text-gray-300" readonly>
                    </div>

                    <!-- Payment Method -->
                    <div class="flex flex-col">
                        <label for="payment_method" class="text-sm font-medium text-gray-300">Payment Method</label>
                        <select id="payment_method" name="payment_method" class="mt-1 p-2 rounded bg-gray-700 text-gray-300">
                            <option value="credit_card" {{ $order->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="bank_transfer" {{ $order->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="paypal" {{ $order->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="cash_on_delivery" {{ $order->payment_method == 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                        </select>
                    </div>

                    <!-- Shipping Address -->
                    <div class="flex flex-col">
                        <label for="shipping_address" class="text-sm font-medium text-gray-300">Shipping Address</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" class="mt-1 p-2 rounded bg-gray-700 text-gray-300">{{ $order->shipping_address }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="flex flex-col">
                        <label for="status" class="text-sm font-medium text-gray-300">Status</label>
                        <select id="status" name="status" class="mt-1 p-2 rounded bg-gray-700 text-gray-300">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    
                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                            Save Changes
                        </button>
                        <a href="{{ route('orders.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

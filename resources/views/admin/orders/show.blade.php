@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Order Details') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <div class="flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-300">Order Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Customer Name:</h4>
                        <p class="text-gray-200">{{ $order->user->name ?? 'N/A' }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Total Amount:</h4>
                        <p class="text-gray-200">Rp. {{ number_format((float)str_replace(',', '', $order->total_amount), 2) }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Payment Method:</h4>
                        <p class="text-gray-200">{{ $order->payment_method }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Shipping Address:</h4>
                        <p class="text-gray-200">{{ $order->shipping_address }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Status:</h4>
                        <p class="text-gray-200">{{ $order->status }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Created At:</h4>
                        <p class="text-gray-200">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Updated At:</h4>
                        <p class="text-gray-200">{{ $order->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-300">Order Items</h3>
                    <table class="min-w-full divide-y divide-gray-700 mt-4">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Sub-total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @foreach ($order->items as $index => $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $item->product->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">Rp. {{ number_format((float)$item->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">Rp. {{ number_format((float)$item->quantity * $item->price, 2) }}</td>
                                </tr>
                            @endforeach
                            <!-- Total Amount -->
                            <tr class="bg-gray-700">
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-right font-medium text-gray-300">Total:</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-300 font-medium">Rp. {{ number_format($order->items->sum(fn($item) => $item->quantity * $item->price), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('orders.index') }}" class="bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">Back to Orders</a>
                </div>
            </div>
        </div>
    </div>
@endsection

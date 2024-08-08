@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Cart Details') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <div class="flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-300">Cart Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">User Name:</h4>
                        <p class="text-gray-200">{{ $cart->user->name ?? 'N/A' }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Total Items:</h4>
                        <p class="text-gray-200">{{ $cart->items->count() }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Created At:</h4>
                        <p class="text-yellow-500">{{ $cart->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Updated At:</h4>
                        <p class="text-yellow-500">{{ $cart->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-300">Cart Items</h3>
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
                            @php
                                $totalAmount = 0;
                            @endphp
                            @foreach ($cart->items as $index => $item)
                                @php
                                    $subTotal = $item->quantity * $item->product->price;
                                    $totalAmount += $subTotal;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $item->product->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-orange-500">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sky-500">Rp. {{ number_format((float)$item->product->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sky-500">Rp. {{ number_format($subTotal, 2) }}</td>
                                </tr>
                            @endforeach
                            <!-- Total Amount -->
                            <tr class="bg-gray-700">
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-right font-medium text-green-600">Total:</td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-600 font-medium">Rp. {{ number_format($totalAmount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('carts.index') }}" class="bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">Back to Carts</a>
                    <a href="{{ route('carts.edit', $cart->id) }}" class="bg-amber-600 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded">Edit Cart</a>
                </div>
            </div>
        </div>
    </div>
@endsection

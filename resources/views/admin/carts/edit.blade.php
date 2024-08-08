@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit Cart') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <div class="flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-300">Edit Cart Information</h3>
                </div>

                <form method="POST" action="{{ route('carts.update', $cart->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- User Name (readonly) -->
                    <div class="flex flex-col">
                        <label for="user_name" class="text-sm font-medium text-gray-300">User Name</label>
                        <input type="text" id="user_name" value="{{ $cart->user->name ?? 'N/A' }}" class="mt-1 p-2 rounded bg-gray-700 text-gray-300" readonly>
                    </div>

                    <!-- Cart Items -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-300">Cart Items</h4>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                            <input type="number" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}"
                                                   class="w-16 px-2 py-1 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
                                                   min="1">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-300">Rp. {{ number_format((float)$item->product->price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-300">Rp. {{ number_format($subTotal, 2) }}</td>
                                    </tr>
                                @endforeach
                                <!-- Total Amount -->
                                <tr class="bg-gray-700">
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-right font-medium text-gray-300">Total:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300 font-medium">Rp. {{ number_format($totalAmount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                            Save Changes
                        </button>
                        <a href="{{ route('carts.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

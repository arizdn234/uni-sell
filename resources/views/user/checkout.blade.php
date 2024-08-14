{{-- resources/views/checkout/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Review your selected items and proceed to payment.") }}
                </div>
            </div>

            <!-- Selected Items for Checkout -->
            <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($selectedItems->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">No items selected for checkout.</p>
                    @else
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Product
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Sub-total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectedItems as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="w-8 h-8 rounded-full object-cover" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                                        {{ $item->product->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                                {{ $item->quantity }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                                Rp {{ number_format($item->product->price, 2, ',', '.') }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                                Rp {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Total Price -->
                        <div class="flex justify-end mt-6">
                            <div class="text-right">
                                <p class="pb-7 text-xl font-semibold text-gray-900 dark:text-gray-200">
                                    Total: Rp {{ number_format($total, 2, ',', '.') }}
                                </p>
                                <a href="{{ route('cart.index') }}" class="mr-3 bg-amber-500 text-white py-2 px-4 rounded hover:bg-amber-600 transition mt-4">
                                    Back to Cart
                                </a>
                                <a href="{{ route('payment') }}" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition mt-4">
                                    Proceed to Payment
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

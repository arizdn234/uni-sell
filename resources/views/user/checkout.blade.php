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
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <!-- Display Cart Items -->
                        <h3 class="text-2xl font-bold mb-4">Order Summary</h3>
                        @foreach($cartItems as $item)
                            <div class="mb-4">
                                <input class="hidden" type="checkbox" name="selected_items[]" value="{{ $item->id }}" checked>
                                <p>{{ $item->product->name }} x {{ $item->quantity }} item.</p>
                                <p class="text-2l font-bold text-emerald-300">Rp. {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}</p>
                            </div>

                            
                        @endforeach

                        <!-- Total Price -->
                        <h4>Total: 
                            <span class="text-2l font-bold text-emerald-300">
                                Rp. {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2, ',', '.') }}
                            </span>
                        </h4>

                        <!-- Address -->
                        <div class="mt-4">
                            <label for="shipping_address" class="block text-gray-700 dark:text-gray-100">Address</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" class="rounded form-input mt-1 block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-300 border-none" required></textarea>
                        </div>

                        <!-- Shipping Method -->
                        <div class="mt-4">
                            <label for="shipping_method" class="block text-sm font-medium text-gray-300">Shipping Method</label>
                            <select id="shipping_method" name="shipping_method" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300">
                                <option value="standard">Standard</option>
                                <option value="express">Express</option>
                            </select>
                        </div>

                        <!-- Payment Method -->
                        <div class="mt-4">
                            <label for="payment_method" class="block text-gray-700 dark:text-gray-100">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="rounded form-select mt-1 block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-300 border-none" required>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>

                        <!-- Track number -->
                        <input type="hidden" name="tracking_number" id="tracking_number" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>

                        <!-- Total Amount -->
                        <input type="hidden" name="total_amount" id="total_amount" value="{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2, '.', ',') }}" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>

                        <!-- Place Order Button -->
                        <div class="mt-6">
                            <a href="{{ route('user.cart') }}">
                                <button type="button" class="mr-1 bg-amber-500 text-white py-2 px-4 rounded hover:bg-amber-600 transition">Back to Cart</button>
                            </a>
                            <button type="submit" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function generateTrackingNumber() {
                var timestamp = new Date().getTime();

                var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
                var randomString = '';
                for (var i = 0; i < 6; i++) {
                    randomString += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                return 'TRK-' + timestamp + '-' + randomString;
            }
            var trackingNumber = generateTrackingNumber();
            document.getElementById('tracking_number').value = trackingNumber;
        });
    </script>
    
</x-app-layout>

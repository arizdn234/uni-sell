@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add New Shipping') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <!-- Shipping Form -->
            <form action="{{ route('shippings.store') }}" method="POST">
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
                    <label for="shipping_method" class="block text-sm font-medium text-gray-300">Shipping Method</label>
                    <select id="shipping_method" name="shipping_method" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300">
                        <option value="standard">Standard</option>
                        <option value="express">Express</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="tracking_number" class="block text-sm font-medium text-gray-300">Tracking Number</label>
                    <div class="flex">
                        <input type="text" name="tracking_number" id="tracking_number" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                        <button type="button" id="generate_tracking_number" class="ml-2 bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">
                            Generate
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                    <select name="status" id="status" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                        <option value="processed">Processed</option>
                        <option value="shipped">Shipped</option>
                        <option value="arrived">Arrived</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                    Add Shipping
                </button>
                <a href="{{ route('shippings.index') }}" class="ml-3 bg-gray-600 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">Back to Shippings</a>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('generate_tracking_number').addEventListener('click', function() {
                var trackingNumber = generateTrackingNumber();
                document.getElementById('tracking_number').value = trackingNumber;
            });

            function generateTrackingNumber() {
                var timestamp = new Date().getTime();

                var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
                var randomString = '';
                for (var i = 0; i < 6; i++) {
                    randomString += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                return 'TRK-' + timestamp + '-' + randomString;
            }
        });
    </script>
@endsection

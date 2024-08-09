@extends('layouts.admin')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Shipping</h1>

        <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('shippings.update', $shipping) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        Order ID: <strong class="text-amber-700 dark:text-amber-300">{{ $shipping->order_id }}</strong>
                    </div>

                    <div class="mb-4">
                        <label for="shipping_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shipping Method</label>
                        <select id="shipping_method" name="shipping_method" class="w-full mt-1 p-2 rounded bg-gray-700 text-gray-300">
                            <option value="standard" {{ $shipping->shipping_method == 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="express" {{ $shipping->shipping_method == 'express' ? 'selected' : '' }}>Express</option>
                        </select>
                        @error('shipping_method')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tracking_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking Number</label>
                        <input id="tracking_number" name="tracking_number" type="text" value="{{ old('tracking_number', $shipping->tracking_number) }}" class="w-full mt-1 p-2 rounded bg-gray-700 text-gray-300" readonly>
                        @error('tracking_number')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status" class="w-full mt-1 p-2 rounded bg-gray-700 text-gray-300">
                            <option value="shipped" {{ $shipping->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="arrived" {{ $shipping->status == 'arrived' ? 'selected' : '' }}>Arrived</option>
                            <option value="processed" {{ $shipping->status == 'processed' ? 'selected' : '' }}>Processed</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                            Save Changes
                        </button>
                        <a href="{{ route('shippings.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Shipping Details') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <div class="flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-300">Shipping Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Order ID:</h4>
                        <p class="text-amber-300">{{ $shipping->order_id }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Shipping Method:</h4>
                        <p class="text-gray-200">{{ $shipping->shipping_method }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Tracking Number:</h4>
                        <p class="text-gray-200">{{ $shipping->tracking_number }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Status:</h4>
                        <p class="
                            @if($shipping->status === 'arrived')
                                text-green-500
                            @elseif($shipping->status === 'shipped')
                                text-teal-500
                            @else
                                text-amber-500
                            @endif">
                            {{ ucfirst($shipping->status) }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Order Details:</h4>
                        <p class="text-sky-400">
                            @if($shipping->order)
                                User ID: {{ $shipping->order->user_id ?? 'N/A' }} <br>
                                Order Total: Rp. {{ $shipping->order->total_amount ?? 0 }}
                            @else
                                No Order Details Available
                            @endif
                        </p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Created At:</h4>
                        <p class="text-sky-500">{{ $shipping->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Updated At:</h4>
                        <p class="text-sky-500">{{ $shipping->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('shippings.index') }}" class="bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">Back to Shippings</a>
                    <a href="{{ route('shippings.edit', $shipping->id) }}" class="bg-amber-600 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded">Edit Shipping</a>
                </div>
            </div>
        </div>
    </div>
@endsection

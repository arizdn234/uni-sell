@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Product Details') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <div class="flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-300">Product Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Image URL:</h4>
                        <p class="text-gray-200">{{ $product->image_url ?? 'N/A' }}</p>
                        <img src="{{ $product->image_url ?? 'N/A' }}" alt="">
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Name:</h4>
                        <p class="text-gray-200">{{ $product->name }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Description:</h4>
                        <p class="text-gray-200">{{ $product->description }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Price:</h4>
                        <p class="text-gray-200">Rp. {{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Stock:</h4>
                        <p class="text-gray-200">{{ $product->stock }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Category:</h4>
                        <p class="text-gray-200">{{ $product->category->name ?? 'N/A' }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Created At:</h4>
                        <p class="text-orange-500">{{ $product->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Updated At:</h4>
                        <p class="text-orange-500">{{ $product->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">Back to Products</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="bg-amber-600 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded">Edit Product</a>
                </div>
            </div>
        </div>
    </div>
@endsection

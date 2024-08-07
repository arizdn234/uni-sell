@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add New Product') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <!-- Product Form -->
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-300">Product Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                    <textarea name="description" id="description" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-300">Price</label>
                    <input type="number" name="price" id="price" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-300">Stock</label>
                    <input type="number" name="stock" id="stock" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-300">Category</label>
                    <select name="category_id" id="category_id" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                        <!-- Options will be populated dynamically based on your categories -->
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="image_url" class="block text-sm font-medium text-gray-300">Image URL</label>
                    <input type="text" name="image_url" id="image_url" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300">
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                    Add Product
                </button>
                <a href="{{ route('products.index') }}" class="ml-3 bg-gray-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Back to Products</a>
            </form>
        </div>
    </div>
@endsection

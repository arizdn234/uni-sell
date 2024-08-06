<!-- resources/views/admin/products/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Product</h1>

        <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('admin.products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-white">
                        @error('name')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-white">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-white">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                        <input type="text" name="price" id="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-white">
                        @error('price')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                        <input type="text" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-white">
                        @error('stock')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image URL</label>
                        <input type="text" name="image_url" id="image_url" value="{{ old('image_url', $product->image_url) }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-white">
                        @error('image_url')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Changes
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

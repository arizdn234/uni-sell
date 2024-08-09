@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add New Review') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <!-- Review Form -->
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-300">User</label>
                    <select name="user_id" id="user_id" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                        <!-- Options will be populated dynamically based on your users -->
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="product_id" class="block text-sm font-medium text-gray-300">Product</label>
                    <select name="product_id" id="product_id" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                        <!-- Options will be populated dynamically based on your products -->
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-300">Rating</label>
                    <select name="rating" id="rating" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                        <option value="1">1 - Poor</option>
                        <option value="2">2 - Fair</option>
                        <option value="3">3 - Good</option>
                        <option value="4">4 - Very Good</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-300">Comment</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required></textarea>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                    Add Review
                </button>
                <a href="{{ route('reviews.index') }}" class="ml-3 bg-gray-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Back to Reviews</a>
            </form>
        </div>
    </div>
@endsection

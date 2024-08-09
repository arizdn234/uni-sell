<!-- resources/views/reviews/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Review</h1>

        <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('reviews.update', $review) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product</label>
                        <select id="product_id" name="product_id" class="w-full mt-1 p-2 rounded bg-gray-700 text-gray-300" required>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ $review->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">User</label>
                        <select id="user_id" name="user_id" class="w-full mt-1 p-2 rounded bg-gray-700 text-gray-300" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $review->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
                        <select id="rating" name="rating" class="w-full mt-1 p-2 rounded bg-gray-700 text-gray-300" required>
                            <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1 - Poor</option>
                            <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2 - Fair</option>
                            <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3 - Good</option>
                            <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4 - Very Good</option>
                            <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5 - Excellent</option>
                        </select>
                        @error('rating')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comment</label>
                        <textarea name="comment" id="comment" rows="4" class="w-full mt-1 p-2 rounded bg-gray-700 text-gray-300" required>{{ $review->comment }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                            Save Changes
                        </button>
                        <a href="{{ route('reviews.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

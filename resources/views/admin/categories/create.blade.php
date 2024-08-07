@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add New Category') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <!-- Category Form -->
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-300">Category Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="parent_id" class="block text-sm font-medium text-gray-300">Parent Category</label>
                    <select name="parent_id" id="parent_id" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-gray-300">
                        <option value="">Parent Category</option>
                        @foreach ($categories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                    Add Category
                </button>
                <a href="{{ route('categories.index') }}" class="ml-3 bg-gray-600 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">Back to Categories</a>
            </form>
        </div>
    </div>
@endsection

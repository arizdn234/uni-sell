@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Products') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <!-- Content goes here -->
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Reviews</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach ($products as $index => $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $products->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $product->reviews->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="ml-2 text-yellow-500 hover:text-yellow-700">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this item?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

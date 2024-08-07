@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Products') }}
    </h2>
@endsection

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <div class="flex space-x-4">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('products.index') }}" class="flex items-center">
                <input type="text" name="search" placeholder="Search Products" value="{{ request('search') }}"
                    class="px-4 py-2 rounded border-gray-600 bg-gray-800 text-white focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                <button type="submit" class="ml-2 bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded">
                    Search
                </button>
            </form>

            <!-- Sorting Dropdown -->
            <form method="GET" action="{{ route('products.index') }}" class="flex items-center">
                <select name="sort" onchange="this.form.submit()"
                    class="px-4 py-2 rounded border-gray-600 bg-gray-800 text-white focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <option value="">Sort By</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </form>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('products.create') }}" class="bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded">
                Add New Product
            </a>
            <a href="{{ route('products.index') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">
                Show All
            </a>
            <a class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2 px-4 rounded">
                Export to XLSX
            </a>
        </div>
    </div>

    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">         
            
            <!-- Content goes here -->
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach ($products as $index => $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $products->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $product->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">Rp. {{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                <a href="{{ route('products.show', $product->id) }}" class="text-teal-500 hover:text-teal-700">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="ml-2 text-amber-500 hover:text-amber-700">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-rose-500 hover:text-rose-700" onclick="return confirm('Are you sure you want to delete this item?');">
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

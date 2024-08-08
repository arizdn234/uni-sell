@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Carts') }}
    </h2>
@endsection

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <div class="flex space-x-4">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('carts.index') }}" class="flex items-center">
                <input type="text" name="search" placeholder="Search Carts" value="{{ request('search') }}"
                    class="px-4 py-2 rounded border-gray-600 bg-gray-800 text-white focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                <button type="submit" class="ml-2 bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded">
                    Search
                </button>
            </form>

            <a href="{{ route('carts.index') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">
                Show All
            </a>
        </div>

        <div class="flex space-x-4">
            <!-- Sorting Dropdown -->
            <form method="GET" action="{{ route('carts.index') }}" class="flex items-center">
                <select name="sort" onchange="this.form.submit()"
                    class="px-4 py-2 rounded border-gray-600 bg-gray-800 text-white focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <option value="">Sort By</option>
                    <option value="user_name_asc" {{ request('sort') == 'user_name_asc' ? 'selected' : '' }}>User Name: A-Z</option>
                    <option value="user_name_desc" {{ request('sort') == 'user_name_desc' ? 'selected' : '' }}>User Name: Z-A</option>
                    <option value="total_items_asc" {{ request('sort') == 'total_items_asc' ? 'selected' : '' }}>Total Items: Low to High</option>
                    <option value="total_items_desc" {{ request('sort') == 'total_items_desc' ? 'selected' : '' }}>Total Items: High to Low</option>
                </select>
            </form>
        </div>
    </div>

    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">         
            <!-- Content goes here -->
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total product in Cart</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach ($carts as $index => $cart)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $carts->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $cart->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $cart->items->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                <a href="{{ route('carts.show', $cart->id) }}" class="text-teal-500 hover:text-teal-700">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('carts.edit', $cart->id) }}" class="ml-2 text-amber-500 hover:text-amber-700">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Are you sure you want to delete this cart?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700">
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
                {{ $carts->links() }}
            </div>
        </div>
    </div>
@endsection

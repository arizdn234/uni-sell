@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Shippings') }}
    </h2>
@endsection

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <div class="flex space-x-4">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('shippings.index') }}" class="flex items-center">
                <input type="text" name="search" placeholder="Search Shippings" value="{{ request('search') }}"
                    class="px-4 py-2 rounded border-gray-600 bg-gray-800 text-white focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                <button type="submit" class="ml-2 bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded">
                    Search
                </button>
            </form>

            <a href="{{ route('shippings.index') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">
                Show All
            </a>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('shippings.create') }}" class="bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded">
                Add New Shipping
            </a>
            
            <!-- Sorting Dropdown -->
            <form method="GET" action="{{ route('shippings.index') }}" class="flex items-center">
                <select name="sort" onchange="this.form.submit()"
                    class="px-4 py-2 rounded border-gray-600 bg-gray-800 text-white focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <option value="">Sort By</option>
                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date: Oldest First</option>
                    <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date: Newest First</option>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tracking Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Shipping Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach ($shippings as $index => $shipping)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $shippings->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $shipping->tracking_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $shipping->shipping_method }}</td>
                            <td class="px-6 py-4 whitespace-nowrap 
                                @if($shipping->status === 'arrived')
                                    text-green-500
                                @elseif($shipping->status === 'shipped')
                                    text-teal-500
                                @else
                                    text-amber-500
                                @endif">
                                {{ ucfirst($shipping->status) }}
                            </td>
                            <td title="{{ $shipping->created_at }}" class="px-6 py-4 whitespace-nowrap text-sky-500">{{ $shipping->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                <a href="{{ route('shippings.show', $shipping->id) }}" class="text-teal-500 hover:text-teal-700">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('shippings.edit', $shipping->id) }}" class="ml-2 text-amber-500 hover:text-amber-700">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('shippings.destroy', $shipping->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-rose-500 hover:text-rose-700" onclick="return confirm('Are you sure you want to delete this shipping?');">
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
                {{ $shippings->links() }}
            </div>
        </div>
    </div>
@endsection

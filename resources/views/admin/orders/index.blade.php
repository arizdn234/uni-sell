@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Orders') }}
    </h2>
@endsection

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <div class="flex space-x-4">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('orders.index') }}" class="flex items-center">
                <input type="text" name="search" placeholder="Search Orders" value="{{ request('search') }}"
                    class="px-4 py-2 rounded border-gray-600 bg-gray-800 text-white focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                <button type="submit" class="ml-2 bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded">
                    Search
                </button>
            </form>

            <a href="{{ route('orders.index') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">
                Show All
            </a>
        </div>

        <div class="flex space-x-4">
            <!-- Sorting Dropdown -->
            <form method="GET" action="{{ route('orders.index') }}" class="flex items-center">
                <select name="sort" onchange="this.form.submit()"
                    class="px-4 py-2 rounded border-gray-600 bg-gray-800 text-white focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <option value="">Sort By</option>
                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date: Oldest First</option>
                    <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date: Newest First</option>
                    <option value="total_asc" {{ request('sort') == 'total_asc' ? 'selected' : '' }}>Total: Low to High</option>
                    <option value="total_desc" {{ request('sort') == 'total_desc' ? 'selected' : '' }}>Total: High to Low</option>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Customer Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $orders->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-500">
                                Rp. {{ number_format((float)str_replace(',', '', $order->total_amount), 2) }}
                            </td>                            
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $order->payment_method }}</td>
                            <td class="px-6 py-4 whitespace-nowrap
                                @if($order->status === 'completed')
                                    text-green-500
                                @elseif($order->status === 'cancelled')
                                    text-red-500
                                @elseif($order->status === 'pending' || $order->status === 'processing')
                                    text-amber-500
                                @else
                                    text-gray-300
                                @endif">
                                {{ ucfirst($order->status) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                <a href="{{ route('orders.show', $order->id) }}" class="text-teal-500 hover:text-teal-700">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('orders.edit', $order->id) }}" class="ml-2 text-amber-500 hover:text-amber-700">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-rose-500 hover:text-rose-700" onclick="return confirm('Are you sure you want to delete this order?');">
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
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('User Details') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <div class="flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-300">User Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Name:</h4>
                        <p class="text-gray-200">{{ $user->name }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Email:</h4>
                        <p class="text-gray-200">{{ $user->email }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Email Verified:</h4>
                        <p class="text-gray-200
                            @if($user->email_verified_at)
                                text-green-500
                            @else
                                text-red-500
                            @endif">
                            @if($user->email_verified_at)
                                Verified {{ $user->email_verified_at->diffForHumans() }}
                            @else
                                Not Verified
                            @endif
                        </p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Created At:</h4>
                        <p class="text-orange-500">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="p-4 bg-gray-700 rounded-lg shadow-md">
                        <h4 class="text-sm font-medium text-gray-300">Updated At:</h4>
                        <p class="text-orange-500">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('users.index') }}" class="bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded">Back to Users</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="bg-amber-600 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded">Edit User</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit User') }}
    </h2>
@endsection

@section('content')
    <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-100">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full px-3 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full px-3 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    <small class="text-gray-500">Leave blank to keep the current password</small>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full px-3 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="email_verified_at" class="block text-sm font-medium text-gray-300">Email Verification</label>
                    <div class="flex items-center">
                        <input type="text" id="email_verified_at" name="email_verified_at" value="{{ old('email_verified_at', optional($user->email_verified_at)->format('Y-m-d H:i:s')) }}" class="mt-1 block w-full px-3 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm" readonly>
                        <button type="button" class="ml-2 bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded" onclick="verifyNow()">
                            Verify Now!
                        </button>
                        <button type="button" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteVerification()">
                            Delete Verification!
                        </button>
                    </div>
                    @error('email_verified_at')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                        Save Changes
                    </button>
                    <a href="{{ route('users.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function verifyNow() {
            if (confirm('Are you sure you want to mark this email as verified?')) {
                document.getElementById('email_verified_at').value = new Date().toISOString().slice(0, 19).replace('T', ' ');
            }
        }
    
        function deleteVerification() {
            if (confirm('Are you sure you want to delete the email verification?')) {
                document.getElementById('email_verified_at').value = ''; // Set to empty string
            }
        }
    </script>
@endsection

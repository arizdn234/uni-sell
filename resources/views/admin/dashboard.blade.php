@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __("You're logged in as admin!") }}
    </div>
@endsection

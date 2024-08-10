<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center ">
                    <a href="{{ route('user.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                        <i class="fas fa-tachometer-alt text-gray-800 dark:text-gray-200"></i>
                        <p class="mx-2">{{ __('Dashboard') }}</p>
                    </x-nav-link>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        <p class="mx-2">{{ __('Login') }}</p>
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>

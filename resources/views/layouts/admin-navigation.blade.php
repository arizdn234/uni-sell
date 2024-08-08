<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    {{-- <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.product')">
                        {{ __('Products') }}
                    </x-nav-link> --}}

                    <!-- Manage Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>Manage</div>
        
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
        
                            <x-slot name="content">
                                <x-dropdown-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                                    {{ __('Products') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                    {{ __('Categories') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                                    {{ __('Orders') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('carts.index')" :active="request()->routeIs('carts.*')">
                                    {{ __('Carts') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('payments.index')" :active="request()->routeIs('payments.*')">
                                    {{ __('Payments') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('reviews.index')" :active="request()->routeIs('reviews.*')">
                                    {{ __('Reviews') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('shippings.index')" :active="request()->routeIs('shippings.*')">
                                    {{ __('Shipping') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                                    {{ __('Users') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.23 7.21c-.3.3-.3.78 0 1.06l4.5 4.5c.3.3.77.3 1.06 0l4.5-4.5c.3-.3.3-.78 0-1.06a.75.75 0 00-1.06 0L10 10.94 6.29 7.21a.75.75 0 00-1.06 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>

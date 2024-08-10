<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Discover our top picks and bestsellers!") }}
                </div>
            </div>

            <!-- Swiper Banner -->
            <div class="relative mt-12">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Promotional Banners</h3>
                <div class="swiper-container overflow-hidden">
                    <div class="swiper-wrapper">
                        <!-- Example Banners -->
                        <div class="swiper-slide">
                            <div class="bg-gray-200 dark:bg-gray-600 rounded-lg overflow-hidden shadow-md">
                                <img src="https://via.placeholder.com/2140x1280.png/0022bb?text=Summer+Sale!" alt="Banner 1" class="w-full h-48 object-cover">
                                <div class="p-4 text-center">
                                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200">Summer Sale!</h4>
                                    <p class="text-gray-600 dark:text-gray-400">Up to 50% off on selected items</p>
                                    <a href="{{ route('promo.page') }}" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition mt-4 inline-block">
                                        Shop Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-gray-200 dark:bg-gray-600 rounded-lg overflow-hidden shadow-md">
                                <img src="https://via.placeholder.com/2140x1280.png/0022bb?text=New+Arrivals!" alt="Banner 2" class="w-full h-48 object-cover">
                                <div class="p-4 text-center">
                                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200">New Arrivals!</h4>
                                    <p class="text-gray-600 dark:text-gray-400">Check out the latest trends</p>
                                    <a href="{{ route('new.arrivals') }}" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition mt-4 inline-block">
                                        Explore Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-gray-200 dark:bg-gray-600 rounded-lg overflow-hidden shadow-md">
                                <img src="https://via.placeholder.com/2140x1280.png/0022bb?text=Summer+Sale!" alt="Banner 1" class="w-full h-48 object-cover">
                                <div class="p-4 text-center">
                                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200">Summer Sale!</h4>
                                    <p class="text-gray-600 dark:text-gray-400">Up to 50% off on selected items</p>
                                    <a href="{{ route('promo.page') }}" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition mt-4 inline-block">
                                        Shop Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-gray-200 dark:bg-gray-600 rounded-lg overflow-hidden shadow-md">
                                <img src="https://via.placeholder.com/2140x1280.png/0022bb?text=New+Arrivals!" alt="Banner 2" class="w-full h-48 object-cover">
                                <div class="p-4 text-center">
                                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200">New Arrivals!</h4>
                                    <p class="text-gray-600 dark:text-gray-400">Check out the latest trends</p>
                                    <a href="{{ route('new.arrivals') }}" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition mt-4 inline-block">
                                        Explore Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Add more banners as needed -->
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- Top Selling Products Grid -->
            <div class="mt-8">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Top Selling Products</h3>
                <div class="relative mt-4">
                    <div class="flex overflow-x-auto space-x-4 pb-4">
                        @foreach ($topSellingProducts as $product)
                            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-700 flex-shrink-0 w-64">
                                <img class="w-full h-36 object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                <div class="p-4">
                                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $product->name }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                                    <div class="mt-4 flex space-x-2">
                                        <button class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition">
                                            Add to Cart
                                        </button>
                                        <button class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Best Products per Category Grid -->
            <div class="mt-12">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Best Products Per Category</h3>
                @foreach ($bestProductsPerCategory as $categoryId => $products)
                    <div class="mt-8">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $categories[$categoryId] ?? 'Unknown Category' }}</h4>
                        <div class="relative mt-4">
                            <div class="flex overflow-x-auto space-x-4 pb-4">
                                @foreach ($products as $product)
                                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-700 flex-shrink-0 w-64">
                                        <img class="w-full h-36 object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                        <div class="p-4">
                                            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $product->name }}</h3>
                                            <p class="text-gray-600 dark:text-gray-400 mt-2">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                                            <div class="mt-4 flex space-x-2">
                                                <button class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition">
                                                    Add to Cart
                                                </button>
                                                <button class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition">
                                                    Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Swiper Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var swiper = new Swiper('.swiper-container', {
                loop: true,
                autoplay: {
                    delay: 6000,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                slidesPerView: 'auto',
                spaceBetween: 10,
            });
        });
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
        <style>
            #toast-container {
                padding: 1rem;
                border-radius: 0.375rem;
                visibility: hidden;
                opacity: 0;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            #toast-container.show {
                visibility: visible;
                opacity: 1;
            }

        </style>
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
                    <div class="flex overflow-x-auto space-x-4 p-4">
                        @foreach ($topSellingProducts as $product)
                            <div class="z-10 bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-700 flex-shrink-0 w-64">
                                <img class="w-full h-36 object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                <div class="p-4">
                                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $product->name }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                                    <div class="mt-4 flex space-x-2">
                                        <button class="add-to-cart bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition" data-product-id="{{ $product->id }}">
                                            Add to Cart
                                        </button>
                                        <button class="see-detail bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition" data-product-id="{{ $product->id }}">
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
                            <div class="flex overflow-x-auto space-x-4 p-4">
                                @foreach ($products as $product)
                                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-700 flex-shrink-0 w-64">
                                        <img class="w-full h-36 object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                        <div class="p-4">
                                            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $product->name }}</h3>
                                            <p class="text-gray-600 dark:text-gray-400 mt-2">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                                            <div class="mt-4 flex space-x-2">
                                                <button class="add-to-cart bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition" data-product-id="{{ $product->id }}">
                                                    Add to Cart
                                                </button>
                                                <button class="see-detail bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition" data-product-id="{{ $product->id }}">
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

            // Handle Add to Cart Button Click
            function setupAddToCartButtons() {
                document.querySelectorAll('.add-to-cart').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const productId = this.dataset.productId;

                        fetch('/cart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ product_id: productId, quantity: 1 })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Product added to cart');
                            } else {
                                showToast(data.message, 'error');
                            }
                        })
                        .catch(error => {
                            showToast('Failed to add product to cart', 'error');
                        });
                    });
                });
            }

            setupAddToCartButtons();

            // Handle See Detail Button Click
            function setupSeeDetailButtons() {
                document.querySelectorAll('.see-detail').forEach(function (button) {
                    button.addEventListener('click', function () {
                        console.log("See detail button clicked");

                        const productId = this.dataset.productId;
                        window.location.href = `/product/${productId}`;
                    });
                });
            }

            setupSeeDetailButtons();

            // Function to Show Toast
            function showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toast-container');

                const toast = document.createElement('div');
                toast.className = `bg-${type === 'success' ? 'green' : 'red'}-500 text-white p-3 rounded`;
                toast.textContent = message;

                toastContainer.appendChild(toast);

                if (!toastContainer.classList.contains('show')) {
                    toastContainer.classList.add('show');
                }

                setTimeout(() => {
                    toast.remove();

                    if (toastContainer.children.length === 0) {
                        toastContainer.classList.remove('show');
                    }
                }, 3000);
            }

        });
    </script>

    <!-- Toast Container -->
    <div id="toast-container" class="z-10 fixed bottom-0 right-0 p-4 space-y-2 bg-black bg-opacity-50"></div>
</x-app-layout>

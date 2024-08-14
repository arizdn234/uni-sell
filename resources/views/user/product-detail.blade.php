<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Details') }}
        </h2>
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
                    <!-- Product Details -->
                    <div class="flex flex-wrap">
                        <!-- Product Images -->
                        <div class="w-full lg:w-1/2 p-4">
                            <div class="relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg shadow-md">
                            </div>
                        </div>
                        <!-- Product Information -->
                        <div class="w-full lg:w-1/2 p-4">
                            <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</h1>

                            <!-- Menambahkan Rata-rata Rating -->
                            @if ($product->reviews->isNotEmpty())
                            <div class="mt-2">
                                <span class="text-yellow-500">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= floor($averageRating) ? '' : ' text-gray-300' }}"></i>
                                    @endfor
                                </span>
                                <span class="text-gray-600 dark:text-gray-400 ml-2">
                                    {{ number_format($averageRating, 1) }} / 5 dari {{ $product->reviews->count() }} ulasan
                                </span>
                            </div>
                        @endif
                            
                            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $product->description }}</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-4">
                                Rp {{ number_format($product->price, 2, ',', '.') }}
                            </p>
                            <p class="text-md text-gray-700 dark:text-gray-300 mt-4">
                                <strong>Category:</strong> {{ $product->category->name }}
                            </p>
                            
                            <!-- Add to Cart Button -->
                            <div class="mt-6">
                                <div class="flex items-center">
                                    <p class="mr-2 text-gray-600 dark:text-gray-400">Quantity:</p>
                                    <button type="button" class="text-gray-600 dark:text-gray-300 quantity-change" data-action="decrease">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="text" name="quantity" value="1" min="1" class="w-12 border rounded py-1 text-gray-900 text-center mx-2 quantity-input" readonly>
                                    <button type="button" class="text-gray-600 dark:text-gray-300 quantity-change" data-action="increase">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <button type="submit" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition mt-4 add-to-cart" data-product-id="{{ $product->id }}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reviews and Related Products -->
                    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <!-- Product Reviews -->
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Reviews</h2>
                            @if ($totalReviews == 0)
                                <p class="text-gray-600 dark:text-gray-400">No reviews yet.</p>
                            @else
                                <div class="mt-4 space-y-4" id="reviews-container">
                                    @foreach ($reviews as $review)
                                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                                            <div class="flex items-center mb-2">
                                                <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $review->user->name }}
                                                </div>
                                                <div class="ml-2 text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $review->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <p class="text-gray-800 dark:text-gray-200">{{ $review->comment }}</p>
                                            <div class="mt-2">
                                                <span class="text-yellow-500">
                                                    @for ($i = 1; $i <= $review->rating; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                    @for ($i = $review->rating + 1; $i <= 5; $i++)
                                                        <i class="fas fa-star text-gray-300"></i>
                                                    @endfor
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($totalReviews > 5)
                                    <button id="load-more-reviews" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition mt-4">
                                        Load More Reviews
                                    </button>
                                @endif
                            @endif
                        </div>

                        <!-- Related Products -->
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Related Products</h2>
                            <div class="mt-4 space-y-4">
                                @foreach ($relatedProducts as $relatedProduct)
                                    <div class="flex items-center border border-gray-200 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                                        <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" class="w-16 h-16 object-cover rounded-lg">
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $relatedProduct->name }}</h3>
                                            <p class="text-md font-bold text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($relatedProduct->price, 2, ',', '.') }}
                                            </p>
                                            <a href="{{ route('product.detail', $relatedProduct->id) }}" class="text-teal-500 hover:underline">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle quantity change buttons
            document.querySelectorAll('.quantity-change').forEach(button => {
                button.addEventListener('click', function () {
                    const action = this.dataset.action;
                    const quantityInput = this.parentElement.querySelector('.quantity-input');
                    let quantity = parseInt(quantityInput.value);

                    if (action === 'increase') {
                        quantity++;
                    } else if (action === 'decrease' && quantity > 1) {
                        quantity--;
                    }

                    quantityInput.value = quantity;
                });
            });

            // Handle Add to Cart Button Click
            function setupAddToCartButtons() {
                document.querySelector('.add-to-cart').addEventListener('click', function () {
                    const productId = this.dataset.productId;
                    const quantityInput = this.parentElement.querySelector('.quantity-input');
                    let quantityValue = parseInt(quantityInput.value);                    

                    fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ product_id: productId, quantity: quantityValue })
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
            }

            setupAddToCartButtons();

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

            let currentPage = 1;
            const reviewsContainer = document.getElementById('reviews-container');
            const loadMoreButton = document.getElementById('load-more-reviews');

            if (loadMoreButton) {
                loadMoreButton.addEventListener('click', function () {
                    currentPage++;

                    fetch(`/product/{{ $product->id }}/reviews?page=${currentPage}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            
                            data.reviews.forEach(review => {
                                const reviewElement = document.createElement('div');
                                reviewElement.classList.add('border', 'border-gray-200', 'rounded-lg', 'p-4', 'bg-gray-50', 'dark:bg-gray-700');
                                reviewElement.innerHTML = `
                                    <div class="flex items-center mb-2">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">${review.user.name}</div>
                                        <div class="ml-2 text-gray-600 dark:text-gray-400 text-sm">${review.created_at}</div>
                                    </div>
                                    <p class="text-gray-800 dark:text-gray-200">${review.comment}</p>
                                    <div class="mt-2">
                                        <span class="text-yellow-500">
                                            ${'<i class="fas fa-star"></i>'.repeat(review.rating)}
                                            ${'<i class="fas fa-star text-gray-300"></i>'.repeat(5 - review.rating)}
                                        </span>
                                    </div>
                                `;
                                reviewsContainer.appendChild(reviewElement);
                            });

                            if (data.reviews.length < 5) {
                                loadMoreButton.remove();
                            }
                        })
                        .catch(error => {
                            showToast('Failed to load more reviews', 'error');
                        });
                });
            }
        });
    </script>

    <!-- Toast Container -->
    <div id="toast-container" class="z-10 fixed bottom-0 right-0 p-4 space-y-2 bg-black bg-opacity-50"></div>

</x-app-layout>

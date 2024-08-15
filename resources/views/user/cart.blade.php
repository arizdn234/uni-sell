{{-- resources/views/cart/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Review your selected items before proceeding to checkout.") }}
                </div>
            </div>

            <!-- Shopping Cart Items -->
            <form action="{{ route('checkout.page') }}" method="POST">
                @csrf
                <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @if (!isset($cart) || $cart->items->isEmpty())
                            <p class="text-gray-600 dark:text-gray-400">Your cart is currently empty.</p>
                        @else
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 w-1 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                            Select
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                            Sub-total
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    @foreach ($cart->items as $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700" data-item-id="{{ $item->id }}">
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="select-item" data-item-id="{{ $item->id }}">
                                                </div>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <img class="w-8 h-8 rounded-full object-cover" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                                            {{ $item->product->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                                <div class="flex items-center">
                                                    <button type="button" class="text-gray-600 dark:text-gray-300 quantity-change" data-action="decrease">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1" class="w-12 border rounded py-1 text-center quantity-input mx-2" readonly>
                                                    <button type="button" class="text-gray-600 dark:text-gray-300 quantity-change" data-action="increase">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                                <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                                    Rp {{ number_format($item->product->price, 2, ',', '.') }}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                                <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap item-total">
                                                    Rp {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white dark:bg-gray-800 text-sm">
                                                <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-600 dark:hover:text-red-900 remove-item">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Total Price and Checkout -->
                            <div class="flex justify-end mt-6">
                                <div class="text-right">
                                    <p class="pb-7 text-xl font-semibold text-gray-900 dark:text-gray-200">
                                        Total: <span id="cart-total">{{ number_format($total, 2, ',', '.') }}</span>
                                    </p>
                                    <button onclick="history.back()" class="mr-1 bg-amber-500 text-white py-2 px-4 rounded hover:bg-amber-600 transition mt-4">
                                        Back
                                    </button>
                                    <button type="submit" class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition mt-4">
                                        Proceed to Checkout
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartItems = document.getElementById('cart-items');
            
            // Handle quantity change buttons
            cartItems.addEventListener('click', function (event) {
                if (event.target.classList.contains('quantity-change') || event.target.closest('.quantity-change')) {
                    const button = event.target.closest('.quantity-change');
                    const row = button.closest('tr');
                    const itemId = row.dataset.itemId;
                    const quantityInput = row.querySelector('.quantity-input');
                    let quantity = parseInt(quantityInput.value);

                    if (button.dataset.action === 'increase') {
                        quantity++;
                    } else if (button.dataset.action === 'decrease' && quantity > 1) {
                        quantity--;
                    }

                    quantityInput.value = quantity;

                    updateCartItem(itemId, quantity);
                }
            });

            // Handle item selection
            cartItems.addEventListener('change', function (event) {
                if (event.target.classList.contains('select-item')) {
                    updateCartTotal();
                }
            });

            // Handle remove item button
            cartItems.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-item') || event.target.closest('.remove-item')) {
                    const row = event.target.closest('tr');
                    const itemId = row.dataset.itemId;

                    if (confirm('Are you sure you want to remove this item from your cart?')) {
                        fetch(`/cart/remove/${itemId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                row.remove();
                                updateCartTotal();
                                showToast(data.message);
                            } else {
                                showToast(data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('An error occurred while removing the item.', 'error');
                        });
                    }
                }
            });

            // Function to update cart item quantity
            function updateCartItem(itemId, quantity) {
                fetch(`/cart/update/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`tr[data-item-id="${itemId}"]`);
                        if (row) {
                            row.querySelector('.item-total').textContent = `${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.item_total).replace(/\D00(?=\D*$)/, ',00')}`;
                        }
                        updateCartTotal();
                        showToast(data.message);
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while updating the item.', 'error');
                });
            }

            // Function to update total based on selected items
            function updateCartTotal() {
                let total = 0;
                const selectedItems = document.querySelectorAll('.select-item:checked');
                selectedItems.forEach(item => {
                    const row = item.closest('tr');
                    const itemTotal = parseFloat(row.querySelector('.item-total').textContent.replace(/[^\d,-]/g, '').replace(',', '.'));
                    total += itemTotal;
                });
                document.getElementById('cart-total').textContent = `${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total).replace(/\D00(?=\D*$)/, ',00')}`;
            }

            // Function to show toast
            function showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toast-container');
                const toast = document.createElement('div');

                if (type === 'success') {
                    toast.className = 'bg-green-500 text-white p-3 rounded';
                } else {
                    toast.className = 'bg-red-500 text-white p-3 rounded';
                }

                toast.textContent = message;

                toastContainer.appendChild(toast);
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }

        });
    </script>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-0 right-0 p-4 space-y-2"></div>
</x-app-layout>

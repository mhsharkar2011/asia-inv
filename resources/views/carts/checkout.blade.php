@extends('layouts.app')

@section('title', 'Checkout - Asia Enterprise')

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                                <span class="text-white font-bold">1</span>
                            </div>
                            <span class="ml-2 text-sm font-medium text-blue-600">Cart</span>
                        </div>
                        <div class="mx-4 h-0.5 w-8 bg-blue-600"></div>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                                <span class="text-white font-bold">2</span>
                            </div>
                            <span class="ml-2 text-sm font-medium text-blue-600">Checkout</span>
                        </div>
                        <div class="mx-4 h-0.5 w-8 bg-gray-300"></div>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 font-bold">3</span>
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Complete</span>
                        </div>
                    </div>
                    <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        ← Back to Cart
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Customer Information</h2>

                        <form action="{{ route('cart.process-checkout') }}" method="POST" id="checkout-form">
                            @csrf

                            <div class="space-y-6">
                                <!-- Customer Name -->
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name *
                                    </label>
                                    <input type="text" id="customer_name" name="customer_name"
                                        value="{{ old('customer_name', Auth::user()->name ?? '') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Enter your full name">
                                    @error('customer_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Contact Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address *
                                        </label>
                                        <input type="email" id="customer_email" name="customer_email"
                                            value="{{ old('customer_email', Auth::user()->email ?? '') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="your@email.com">
                                        @error('customer_email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number *
                                        </label>
                                        <input type="tel" id="customer_phone" name="customer_phone"
                                            value="{{ old('customer_phone') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="+880 1XXX-XXXXXX">
                                        @error('customer_phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Shipping Address -->
                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Shipping Address *
                                    </label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Enter your complete shipping address">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <label class="relative flex cursor-pointer">
                                            <input type="radio" name="payment_method" value="cash"
                                                {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }}
                                                class="sr-only peer">
                                            <div
                                                class="w-full p-4 border-2 border-gray-300 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                                <div class="flex items-center">
                                                    <div
                                                        class="h-5 w-5 rounded-full border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center mr-3">
                                                        <div class="h-2 w-2 rounded-full bg-white"></div>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">Cash on Delivery</div>
                                                        <div class="text-sm text-gray-500">Pay when you receive</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="relative flex cursor-pointer">
                                            <input type="radio" name="payment_method" value="card"
                                                {{ old('payment_method') == 'card' ? 'checked' : '' }}
                                                class="sr-only peer">
                                            <div
                                                class="w-full p-4 border-2 border-gray-300 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                                <div class="flex items-center">
                                                    <div
                                                        class="h-5 w-5 rounded-full border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center mr-3">
                                                        <div class="h-2 w-2 rounded-full bg-white"></div>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">Credit/Debit Card</div>
                                                        <div class="text-sm text-gray-500">Pay with card</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="relative flex cursor-pointer">
                                            <input type="radio" name="payment_method" value="online"
                                                {{ old('payment_method') == 'online' ? 'checked' : '' }}
                                                class="sr-only peer">
                                            <div
                                                class="w-full p-4 border-2 border-gray-300 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                                <div class="flex items-center">
                                                    <div
                                                        class="h-5 w-5 rounded-full border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center mr-3">
                                                        <div class="h-2 w-2 rounded-full bg-white"></div>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">Online Payment</div>
                                                        <div class="text-sm text-gray-500">bKash, Nagad, etc.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @error('payment_method')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Order Notes -->
                                <div>
                                    <label for="order_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Order Notes (Optional)
                                    </label>
                                    <textarea id="order_notes" name="order_notes" rows="2"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Any special instructions for your order">{{ old('order_notes') }}</textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>

                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2">
                            @foreach ($cart as $productId => $item)
                                @php
                                    $product = App\Models\Inventory\Product::find($productId);
                                @endphp
                                <div class="flex items-center">
                                    <div class="h-16 w-16 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
                                        @if ($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                📦
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</h4>
                                        <div class="flex items-center justify-between mt-1">
                                            <span class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</span>
                                            <span
                                                class="text-sm font-medium">৳{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-3 border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">৳{{ number_format($subtotal, 2) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium">৳{{ number_format($tax, 2) }}</span>
                            </div>

                            <div class="flex justify-between border-t border-gray-200 pt-3">
                                <span class="text-lg font-bold text-gray-900">Total</span>
                                <span class="text-lg font-bold text-gray-900">৳{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mt-6">
                            <label class="flex items-start">
                                <input type="checkbox" id="terms" name="terms" required
                                    class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 mt-1">
                                <span class="ml-2 text-sm text-gray-600">
                                    I agree to the
                                    <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a>
                                    and
                                    <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                                </span>
                            </label>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" form="checkout-form" id="place-order-btn"
                            class="mt-6 w-full inline-flex items-center justify-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transform transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Place Order
                        </button>

                        <!-- Security Info -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                100% Secure Checkout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function validateCheckout() {
            const terms = document.getElementById('terms');
            if (!terms.checked) {
                alert('Please agree to the Terms and Conditions');
                return false;
            }

            // Get form element
            const form = document.getElementById('checkout-form');

            // Add terms checkbox value to form data
            const termsInput = document.createElement('input');
            termsInput.type = 'hidden';
            termsInput.name = 'terms';
            termsInput.value = '1';
            form.appendChild(termsInput);

            // Show loading state
            const button = document.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = `
            <svg class="animate-spin w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Processing...
        `;
            button.disabled = true;

            // Submit the form
            form.submit();
            return true;
        }

        // Add event listener to the button
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.addEventListener('click', function(e) {
                    // Prevent default form submission
                    e.preventDefault();
                    validateCheckout();
                });
            }

            // Also handle form submission via Enter key
            const form = document.getElementById('checkout-form');
            form.addEventListener('submit', function(e) {
                // Validate terms before submitting
                const terms = document.getElementById('terms');
                if (!terms.checked) {
                    e.preventDefault();
                    alert('Please agree to the Terms and Conditions');
                    return false;
                }
                return true;
            });
        });

        function placeOrder() {
            // Validate terms
            const terms = document.getElementById('terms');
            if (!terms.checked) {
                alert('Please agree to the Terms and Conditions');
                terms.focus();
                return false;
            }

            // Get the form
            const form = document.getElementById('checkout-form');

            // Add terms to form data if not already there
            if (!form.querySelector('input[name="terms"]')) {
                const termsInput = document.createElement('input');
                termsInput.type = 'hidden';
                termsInput.name = 'terms';
                termsInput.value = '1';
                form.appendChild(termsInput);
            }

            // Show loading state
            const button = document.getElementById('place-order-btn');
            const originalText = button.innerHTML;
            button.innerHTML = `
            <svg class="animate-spin w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Processing...
        `;
            button.disabled = true;

            // Submit the form
            form.submit();
        }

        // Also allow Enter key to submit form
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkout-form');

            form.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && e.target.type !== 'textarea') {
                    e.preventDefault();
                    placeOrder();
                }
            });
        });
    </script>
@endpush

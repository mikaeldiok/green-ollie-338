@extends('frontend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@section('content')
    <x-frontend.header-block :title="__($module_title)">
        <p class="mb-8 leading-relaxed">
            The list of Food {{ __($module_name) }}.
        </p>
    </x-frontend.header-block>

    <section class="bg-white p-6 text-gray-600 dark:bg-gray-700 sm:p-20" x-data="cart()">
        <h2 class="text-center text-2xl font-semibold mb-6">{{ __('Popular Dishes') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="sm:col-span-2 grid grid-cols-4 gap-6">
                @foreach ($foods as $food)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img class="w-full h-48 object-cover" src="{{ $food->image }}" alt="{{ $food->name }}">
                        <div class="p-4 text-center">
                            <h3 class="text-xl font-semibold mb-2">{{ $food->name }}</h3>
                            <div class="text-lg font-semibold text-gray-900 mb-2" x-text="formatCurrency({{ $food->price }})"></div>
                            <div x-data="{ quantity: 0, added: false }" class="flex items-center justify-center">
                                <button 
                                    x-show="!added"
                                    @click="added = true; quantity = 1; addToCart({ id: {{ $food->id }}, name: '{{ $food->name }}', price: {{ $food->price }} })"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-600">
                                    Add To Cart
                                </button>
                                <div x-show="added" class="flex items-center space-x-2">
                                    <button 
                                        @click="quantity--; if(quantity <= 0) { added = false; quantity = 0; removeFromCart({ id: {{ $food->id }} }); } else { updateCart({ id: {{ $food->id }}, quantity: quantity }); }" 
                                        class="bg-gray-300 text-gray-700 px-3 py-1 rounded-lg">
                                        -
                                    </button>
                                    <span x-text="quantity" class="text-lg font-semibold"></span>
                                    <button 
                                        @click="quantity++; updateCart({ id: {{ $food->id }}, quantity: quantity })" 
                                        class="bg-gray-300 text-gray-700 px-3 py-1 rounded-lg">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-between max-h-128">
                <div class="overflow-y-auto">
                    <h3 class="text-xl font-semibold mb-4">{{ __('Your Cart') }}</h3>
                    <template x-for="item in cartItems" :key="item.id">
                        <div class="flex justify-between mb-2">
                            <span x-text="`${item.quantity}x ${item.name}`"></span>
                            <span x-text="formatCurrency(item.price * item.quantity)"></span>
                        </div>
                    </template>
                </div>
                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between mb-2">
                        <span>{{ __('Total') }}</span>
                        <span x-text="formatCurrency(totalPrice)"></span>
                    </div>
                    <button @click="openCheckoutModal" class="bg-green-500 text-white px-4 py-2 rounded-lg w-full">{{ __('Checkout') }}</button>
                </div>
            </div>
        </div>
        <div class="flex justify-center w-full mt-3">
            {{ $foods->links() }}
        </div>
    </section>

    <!-- Checkout Modal -->
    <div x-data="{ isCheckoutModalOpen: true }" x-show="isCheckoutModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
        <div class="bg-white p-6 rounded-lg max-w-lg w-full">
            <h3 class="text-xl font-semibold mb-4">{{ __('Checkout') }}</h3>
            <div class="mb-4">
                <label for="atas_nama" class="block text-gray-700">{{ __('Atas Nama') }}</label>
                <input id="atas_nama" type="text" x-model="checkoutDetails.atas_nama" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="customer" class="block text-gray-700">{{ __('Customer') }}</label>
                <input id="customer" type="text" x-model="checkoutDetails.customer" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="order" class="block text-gray-700">{{ __('Order') }}</label>
                <input id="order" type="text" x-model="checkoutDetails.order" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="flex justify-end space-x-4">
                <button @click="isCheckoutModalOpen = false" class="bg-gray-500 text-white px-4 py-2 rounded">{{ __('Cancel') }}</button>
                <button @click="printReceipt" class="bg-green-500 text-white px-4 py-2 rounded">{{ __('Print Receipt') }}</button>
            </div>
        </div>
    </div>

    <script>
        function cart() {
            return {
                cartItems: [],
                checkoutDetails: {
                    atas_nama: '',
                    customer: '',
                    order: ''
                },
                get totalPrice() {
                    return this.cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
                },
                addToCart(item) {
                    const existingItem = this.cartItems.find(i => i.id === item.id);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        this.cartItems.push({ ...item, quantity: 1 });
                    }
                },
                updateCart(item) {
                    const existingItem = this.cartItems.find(i => i.id === item.id);
                    if (existingItem) {
                        existingItem.quantity = item.quantity;
                    }
                },
                removeFromCart(item) {
                    this.cartItems = this.cartItems.filter(i => i.id !== item.id);
                },
                formatCurrency(amount) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(amount);
                },
                printReceipt() {
                    console.log('Printing receipt with details:', this.checkoutDetails);
                }
            };
        }
    </script>
@endsection

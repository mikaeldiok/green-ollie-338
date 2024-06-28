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
    <div id="checkout-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('Checkout') }}
                    </h3>
                    <button type="button" @click="closeCheckoutModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="mb-4">
                        <label for="atas_nama" class="block text-gray-700">{{ __('Atas Nama') }}</label>
                        <input id="atas_nama" type="text" x-model="checkoutDetails.atas_nama" class="w-full p-2 border border-gray-300 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="order" class="block text-gray-700">{{ __('Order') }}</label>
                        <input id="order" type="text" x-model="checkoutDetails.order" class="w-full p-2 border border-gray-300 rounded">
                    </div>
                </div>
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button @click="closeCheckoutModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">{{ __('Cancel') }}</button>
                    <button @click="printReceipt" type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Print Receipt') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cart() {
            return {
                cartItems: [],
                isCheckoutModalOpen: false,
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
                openCheckoutModal() {
                    console.log('Opening Checkout Modal');
                    this.isCheckoutModalOpen = true;
                    document.getElementById('checkout-modal').classList.remove('hidden');
                },
                closeCheckoutModal() {
                    console.log('Closing Checkout Modal');
                    this.isCheckoutModalOpen = false;
                    document.getElementById('checkout-modal').classList.add('hidden');
                },
                printReceipt() {
                    console.log('Printing receipt with details:', this.checkoutDetails);
                    this.closeCheckoutModal();
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('cart', cart);
        });
    </script>
@endsection

@extends('frontend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@section('content')
    <x-frontend.header-block :title="__('Pesan Disini')">
        <p class="mb-4 leading-relaxed">
            Silakan masukkan pesanan anda di bawah ini
        </p>
    </x-frontend.header-block>

    <section class="bg-white p-6 text-gray-600 dark:bg-gray-700 sm:p-20" x-data="cart()" x-init="init()">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="sm:col-span-2 grid grid-cols-2 sm:grid-cols-4 gap-6">
                @foreach ($foods as $food)
                    <div class="relative bg-white rounded-lg shadow-md overflow-hidden">
                        <img class="w-full h-48 object-cover" src="{{ $food->image }}" alt="{{ $food->name }}">
                        <div class="p-4 text-center">
                            <h3 class="text-m font-semibold mb-2">{{ $food->name }}</h3>
                            <div class="text-s font-semibold text-gray-900 mb-10" x-text="formatCurrency({{ $food->price }})"></div>
                            <div x-data="{ quantity: 0, added: false }" class="flex items-center justify-center">
                                <button
                                    x-show="!added"
                                    @click="added = true; quantity = 1; addToCart({ id: {{ $food->id }}, name: '{{ $food->name }}', price: {{ $food->price }} })"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-600 absolute bottom-0 left-0 w-full">
                                    Add To Cart
                                </button>
                                <div x-show="added" class="flex items-center space-x-2 mt-5">
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
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="bg-green-500 text-white px-4 py-2 rounded-lg w-full" type="button">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
        <div class="flex justify-center w-full mt-3">
            {{ $foods->links() }}
        </div>
    </section>

    <!-- Checkout Modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 bottom-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('Checkout') }}
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="mb-4">
                        <label for="atas_nama" class="block text-gray-700">{{ __('Atas Nama') }}</label>
                        <input id="atas_nama" type="text" x-model="checkoutDetails.atas_nama" class="w-full p-2 border border-gray-300 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="number" class="block text-gray-700">{{ __('Phone') }}</label>
                        <input id="number" type="text" x-model="checkoutDetails.number" class="w-full p-2 border border-gray-300 rounded">
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'in_place';
                            $field_label = "Order";
                            $field_placeholder = "-- Select an option --";
                            $required = "required";
                            $select_options = [
                                '1' => 'Ditempat',
                                '0' => 'Take Away',
                            ];
                            ?>
                            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
                            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["x-model" => "checkoutDetails.in_place", "$required"]) }}
                        </div>
                    </div>
                </div>
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" data-modal-hide="authentication-modal">
                        Cancel
                    </button>
                    <button id="submit-order-button" type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Selesai Order</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('Success') }}
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="success-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Transaction Success') }}</p>
                    <p>{{ __('Please show this message to the cashier.') }}</p>
                    <p>{{ __('Invoice: ') }}<span id="invoice-number"></span></p>
                </div>
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="success-modal-ok-button" type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function cart() {
        return {
            cartItems: [],
            isCheckoutModalOpen: false,
            checkoutDetails: {
                atas_nama: '',
                number: '',
                in_place: ''
            },
            successInvoice: '',
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
                document.getElementById('authentication-modal').classList.remove('hidden');
            },
            closeCheckoutModal() {
                console.log('Closing Checkout Modal');
                this.isCheckoutModalOpen = false;
                document.getElementById('authentication-modal').classList.add('hidden');
            },
            submitOrder() {
                if (this.isSubmitting) return;  // Check if already submitting
                this.isSubmitting = true;  // Flag to indicate submission in progress

                this.checkoutDetails.atas_nama = document.getElementById('atas_nama').value;
                this.checkoutDetails.number = document.getElementById('number').value;
                this.checkoutDetails.in_place = document.querySelector('select[name="in_place"]').value;
                console.log(this.checkoutDetails); // Debugging line to see the input values

                const orderData = {
                    atas_nama: this.checkoutDetails.atas_nama,
                    number: this.checkoutDetails.number,
                    in_place: this.checkoutDetails.in_place,
                    total_price: this.totalPrice,
                    food: this.cartItems.map(item => ({
                        id: item.id,
                        food_name: item.name,
                        quantity: item.quantity,
                        price: item.price
                    }))
                };

                console.log(orderData); // Debugging line to see the order data
                axios.post('/transactions/order', orderData)
                    .then(response => {
                        console.log('Order submitted successfully:', response.data);
                        document.getElementById('invoice-number').textContent = response.data.Invoice;
                        this.successInvoice = response.data.Invoice;
                        this.showSuccessModal();
                        // Handle successful order submission (e.g., show a success message)
                    })
                    .catch(error => {
                        console.error('Error submitting order:', error);
                        // Handle error (e.g., show an error message)
                    })
                    .finally(() => {
                        this.isSubmitting = false;  // Reset the flag
                    });
            },
            showSuccessModal() {
                document.getElementById('authentication-modal').classList.add('hidden');
                document.getElementById('success-modal').classList.remove('hidden');
            },
            clearCartAndForm() {
                this.cartItems = [];
                this.checkoutDetails = {
                    atas_nama: '',
                    number: '',
                    in_place: ''
                };

                location.reload();
            },
            init() {
                document.getElementById('submit-order-button').addEventListener('click', this.submitOrder.bind(this));

                document.getElementById('success-modal-ok-button').addEventListener('click', this.clearCartAndForm.bind(this));

                // Add event listener for close button in success modal
                document.querySelectorAll('[data-modal-hide="success-modal"]').forEach((btn) => {
                    btn.addEventListener('click', this.clearCartAndForm.bind(this));
                });
            }
        };
    }
</script>

@endsection

@extends('frontend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@section('content')
    <x-frontend.header-block :title="__($module_title)">
        <p class="mb-8 leading-relaxed">
            The list of nngents {{ __($module_name) }}.
        </p>
    </x-frontend.header-block>

    <section class="bg-white p-6 text-gray-600 dark:bg-gray-700 sm:p-20">
        <h2 class="text-center text-2xl font-semibold mb-6">{{ __('Popular Dishes') }}</h2>
        <div class="grid grid-cols-2 gap-6 sm:grid-cols-3">
            @foreach ($$module_name as $$module_name_singular)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img class="w-full h-48 object-cover" src="{{ $$module_name_singular->image_url }}" alt="{{ $$module_name_singular->name }}">
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-semibold mb-2">{{ $$module_name_singular->name }}</h3>
                        <div class="text-lg font-semibold text-gray-900 mb-2">${{ $$module_name_singular->price }}</div>
                        <div class="text-yellow-500 mb-2 flex justify-center">
                            @for ($i = 0; $i < 5; $i++)
                                <span class="fa fa-star{{ $i < $$module_name_singular->rating ? '' : '-o' }}"></span>
                            @endfor
                        </div>
                        <div x-data="{ quantity: 0, added: false }" class="flex items-center justify-center">
                            <button 
                                x-show="!added"
                                @click="added = true; quantity = 1"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-600">
                                Add To Cart
                            </button>
                            <div x-show="added" class="flex items-center space-x-2">
                                <button 
                                    @click="quantity--; if(quantity <= 0) { added = false; quantity = 0; }" 
                                    class="bg-gray-300 text-gray-700 px-3 py-1 rounded-lg">
                                    -
                                </button>
                                <span x-text="quantity" class="text-lg font-semibold"></span>
                                <button 
                                    @click="quantity++" 
                                    class="bg-gray-300 text-gray-700 px-3 py-1 rounded-lg">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex justify-center w-full mt-3">
            {{ $$module_name->links() }}
        </div>
    </section>
@endsection

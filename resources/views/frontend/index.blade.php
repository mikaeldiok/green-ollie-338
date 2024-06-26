@extends('frontend.layouts.app')

@section('title')
    {{ app_name() }}
@endsection

@section('content')
    <section class="bg-white dark:bg-gray-800">
        <div class="mx-auto max-w-screen-xl px-4 py-5 text-center sm:px-12">
            <h1 class="mb-6 text-4xl font-extrabold leading-none tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                Kedai Nasi Bakar Selera
            </h1>
            <p class="mb-10 text-lg font-normal text-gray-500 dark:text-gray-400 sm:px-16 sm:text-2xl xl:px-48">
                Pusat menu nasi bakar paling original
            </p>

            @include('frontend.includes.messages')
        </div>
    </section>

    @php
        $pastelColors = [
            '#ffb3ba', '#ffdfba', '#ffffba', '#baffc9', '#bae1ff',
            '#e6e6fa', '#ffd700', '#e9967a', '#faebd7', '#ffb6c1'
        ];
    @endphp

    <section class="text-gray-600 dark:bg-gray-700 dark:text-gray-400">
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <!-- Carousel inner container -->
            <div class="relative overflow-hidden rounded-lg h-56 md:h-96">
                <!-- Loop through each slider menu item -->
                @foreach($slider_menu as $index => $item)
                    @php
                        $bgColor = $pastelColors[$index % count($pastelColors)];
                    @endphp
                    <div class="hidden duration-700 ease-in-out absolute inset-0 transition-all transform" style="background-color: {{ $bgColor }};" data-carousel-item>
                        <div class="flex items-center h-full px-4 md:px-12">
                            <div class="w-2/3 px-10">
                                <h2 class="text-4xl font-bold">{{ $item->name }}</h2>
                                <p class="mt-4 text-lg">{{ $item->description }}</p>
                            </div>
                            <div class="w-1/3">
                                <img src="{{ asset($item->image) }}" class="rounded-lg shadow-lg" alt="{{ $item->title }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                <!-- Navigation dots -->
                @foreach($slider_menu as $index => $item)
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}" data-carousel-slide-to="{{ $index }}"></button>
                @endforeach
            </div>

            <!-- Previous button -->
            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>

            <!-- Next button -->
            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </section>

    <section class="py-20 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div id="menu-container" class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                @foreach($menu as $index => $item)
                    <div class="menu-item flex items-center justify-between space-x-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md" data-index="{{ $index }}">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($item->image) }}" class="h-24 w-24 rounded-full object-cover" alt="{{ $item->name }}">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $item->name }}</h2>
                                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $item->description }}</p>
                            </div>
                        </div>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $item->price }}</p>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <button id="load-more" class="px-5 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    Load More
                </button>
            </div>
        </div>
    </section>


@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.querySelector('[data-carousel]');
        const items = carousel.querySelectorAll('[data-carousel-item]');
        const prevButton = carousel.querySelector('[data-carousel-prev]');
        const nextButton = carousel.querySelector('[data-carousel-next]');
        const dots = carousel.querySelectorAll('[data-carousel-slide-to]');

        let currentIndex = 0;

        function showSlide(index) {
            items.forEach((item, i) => {
                item.classList.toggle('hidden', i !== index);
            });
            dots.forEach((dot, i) => {
                dot.setAttribute('aria-current', i === index ? 'true' : 'false');
            });
        }

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            showSlide(currentIndex);
        });

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % items.length;
            showSlide(currentIndex);
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                showSlide(currentIndex);
            });
        });

        showSlide(currentIndex);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.menu-item');
        const loadMoreButton = document.getElementById('load-more');
        let visibleItems = 6;

        function showItems(count) {
            items.forEach((item, index) => {
                if (index < count) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        }

        loadMoreButton.addEventListener('click', function () {
            visibleItems += 6;
            showItems(visibleItems);

            // Hide button if all items are visible
            if (visibleItems >= items.length) {
                loadMoreButton.classList.add('hidden');
            }
        });

        // Initial display
        showItems(visibleItems);
    });
</script>
@endpush

<nav class="border-2 border-gray-200 bg-white shadow-md dark:border-gray-700 dark:bg-gray-900">
    <div class="mx-auto flex max-w-screen-xl flex-wrap items-center justify-between p-4">
        <a class="flex items-center space-x-3 rtl:space-x-reverse" href="/">
            <img class="h-9" src="{{ asset('img/logo-with-text.jpg') }}" alt="{{ app_name() }} Logo" />
        </a>
        <div class="flex items-center justify-end space-x-1 rtl:space-x-reverse md:order-2 md:space-x-0">
            <button
                class="rounded-lg p-2.5 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                id="theme-toggle" type="button">
                <svg class="hidden h-5 w-5" id="theme-toggle-dark-icon" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg class="hidden h-5 w-5" id="theme-toggle-light-icon" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Dropdown:language-dropdown-menu -->
            <div class="z-50 my-4 hidden list-none divide-y divide-gray-100 rounded-lg bg-white text-base shadow dark:bg-gray-700"
                id="language-dropdown-menu">
                <ul class="py-2 font-medium" role="none">
                    @foreach (config('app.available_locales') as $locale_code => $locale_name)
                        <li>
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                href="{{ route('language.switch', $locale_code) }}" role="menuitem">
                                <div class="inline-flex items-center">
                                    {{ $locale_name }}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @guest
                <a class="inline-flex cursor-pointer items-center justify-center rounded px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white"
                    href="{{ route('login') }}">
                    <svg class="icon icon-tabler icons-tabler-outline icon-tabler-login me-2"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                        <path d="M21 12h-13l3 -3" />
                        <path d="M11 15l-3 -3" />
                    </svg>
                    <span class="ms-2 hidden sm:block">
                        {{ __('Login') }}
                    </span>
                </a>
            @endguest

            @auth
                <button
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white"
                    data-dropdown-toggle="user-dropdown-menu" type="button">
                    <img class="h-9 rounded-md" src="{{ asset(Auth::user()->avatar) }}" alt="">
                    <span class="ms-2 hidden sm:block">
                        {{ Auth::user()->last_name }}
                    </span>
                </button>
                <!-- Dropdown:user-dropdown-menu -->
                <div class="z-50 my-4 hidden list-none divide-y divide-gray-100 rounded-lg bg-white text-base shadow dark:bg-gray-700"
                    id="user-dropdown-menu">
                    <ul class="py-2 font-medium" role="none">
                        @can('view_backend')
                            <li class="border-b-2 border-gray-200">
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    href="{{ route('backend.dashboard') }}" role="menuitem">
                                    <div class="inline-flex items-center">
                                        <svg class="icon icon-tabler icons-tabler-outline icon-tabler-layout-dashboard me-2"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                                            <path
                                                d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                                            <path
                                                d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                                            <path
                                                d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                                        </svg>
                                        {{ __('Admin Dashboard') }}
                                    </div>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    href="{{ route('logout') }}" role="menuitem"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="inline-flex items-center">
                                        <svg class="icon icon-tabler icons-tabler-outline icon-tabler-logout me-2"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                            <path d="M9 12h12l-3 -3" />
                                            <path d="M18 15l3 -3" />
                                        </svg>
                                        {{ __('Logout') }}
                                    </div>
                                </a>
                            </li>
                            <form id="logout-form" style="display: none;" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </div>
                @endauth
                <button
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 md:hidden"
                    data-collapse-toggle="navbar-language" type="button" aria-controls="navbar-language"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>

            <div class="hidden w-full items-center justify-between md:order-1 md:flex md:w-auto" id="navbar-language">
                <ul
                    class="mt-4 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-4 font-medium rtl:space-x-reverse dark:border-gray-700 dark:bg-gray-800 md:mt-0 md:flex-row md:space-x-8 md:border-0 md:bg-white md:p-0 md:dark:bg-gray-900">
                    <x-frontend.nav-item :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-frontend.nav-item>
                    <x-frontend.nav-item :href="route('frontend.transactions.index')" :active="request()->routeIs('frontend.transactions.*')">
                        {{ __('Order') }}
                    </x-frontend.nav-item>
                </ul>
            </div>

        </div>
    </nav>

<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = window.pageYOffset > 50"
     :class="{ 'bg-white/95 backdrop-blur-md shadow-lg': scrolled, 'bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600': !scrolled }"
     class="fixed w-full top-0 z-50 transition-all duration-300 border-b border-white/20">
    
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo with Animation -->
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-all duration-300 group-hover:rotate-6">
                                <x-application-logo class="block h-6 w-auto fill-current text-white" />
                            </div>
                            <div class="absolute -inset-1 bg-white/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="hidden md:block">
                            <h2 :class="scrolled ? 'text-gray-800' : 'text-white'" class="font-bold text-xl transition-colors duration-300">
                                Irvana Buah
                            </h2>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links with Icons -->
                <div class="hidden lg:flex lg:items-center lg:space-x-2 lg:ml-10">
                    <!-- Dashboard Link - Updated Icon -->
                    <a href="{{ route('dashboard') }}" 
                       class="group relative px-4 py-2 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : '' }}"
                       :class="scrolled ? 'hover:bg-gray-100 text-gray-700 hover:text-gray-900' : 'hover:bg-white/20 text-white/80 hover:text-white'">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10l7-7 7 7M5 10v11a1 1 0 001 1h3m10-11v11a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="font-medium">{{ __('Dashboard') }}</span>
                        </div>
                        @if(request()->routeIs('dashboard'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <!-- Products Link - Updated Icon (Fruit/Apple) -->
                    <a href="{{ route('products.index') }}" 
                       class="group relative px-4 py-2 rounded-xl transition-all duration-300 {{ request()->routeIs('products.*') ? 'bg-white/20 text-white' : '' }}"
                       :class="scrolled ? 'hover:bg-gray-100 text-gray-700 hover:text-gray-900' : 'hover:bg-white/20 text-white/80 hover:text-white'">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.1 2 5 5.1 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.9-3.1-7-7-7z M12 11.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.5c0-1.5 1-2.5 2-2.5s1.5 1 1.5 2c0 1-0.5 1.5-1.5 2-1 0.5-2 0-2-1.5z"/>
                            </svg>
                            <span class="font-medium">{{ __('Produk') }}</span>
                        </div>
                        @if(request()->routeIs('products.*'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <!-- Categories Link - Updated Icon (Tag) -->
                    <a href="{{ route('categories.index') }}" 
                       class="group relative px-4 py-2 rounded-xl transition-all duration-300 {{ request()->routeIs('categories.*') ? 'bg-white/20 text-white' : '' }}"
                       :class="scrolled ? 'hover:bg-gray-100 text-gray-700 hover:text-gray-900' : 'hover:bg-white/20 text-white/80 hover:text-white'">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span class="font-medium">{{ __('Kategori') }}</span>
                        </div>
                        @if(request()->routeIs('categories.*'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <!-- Users Link - Updated Icon (Multiple People) -->
                     <a href="{{ route('users.index') }}" 
                    class="group relative px-4 py-2 rounded-xl transition-all duration-300 {{ request()->routeIs('users.*') ? 'bg-white/20 text-white' : '' }}"
                    :class="scrolled ? 'hover:bg-gray-100 text-gray-700 hover:text-gray-900' : 'hover:bg-white/20 text-white/80 hover:text-white'">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197V9a3 3 0 00-6 0v2.5"/>
                            </svg>
                            <span class="font-medium">{{ __('Pengguna') }}</span>
                        </div>
                        @if(request()->routeIs('users.*'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-white rounded-full"></div>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Right Side - User Menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <!-- Notification Bell -->
                <button class="relative p-2 rounded-xl transition-all duration-300 group"
                        :class="scrolled ? 'hover:bg-gray-100 text-gray-600' : 'hover:bg-white/20 text-white/80 hover:text-white'">
                    <svg class="w-6 h-6 transition-transform group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19H6.5A2.5 2.5 0 014 16.5v-9A2.5 2.5 0 016.5 5h11A2.5 2.5 0 0120 7.5v9a2.5 2.5 0 01-2.5 2.5H13"></path>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                </button>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="group flex items-center space-x-3 px-4 py-2 rounded-xl transition-all duration-300"
                                :class="scrolled ? 'hover:bg-gray-100 text-gray-700' : 'hover:bg-white/20 text-white'">
                            <div class="flex items-center space-x-3">
                                <!-- Avatar -->
                                <div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center font-semibold text-white text-sm group-hover:scale-110 transition-transform duration-300">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                                    <div :class="scrolled ? 'text-gray-500' : 'text-white/70'" class="text-xs">{{ Auth::user()->role ?? 'User' }}</div>
                                </div>
                            </div>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-2">
                            <!-- User Info in Dropdown -->
                            <div class="px-4 py-3 border-b border-gray-100 mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center font-semibold text-white">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200 group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>{{ __('Profile') }}</span>
                            </a>

                            <a href="#" class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200 group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Pengaturan</span>
                            </a>

                            <div class="border-t border-gray-100 my-2"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 group">
                                    <svg class="w-5 h-5 text-red-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>{{ __('Log Out') }}</span>
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="p-2 rounded-xl transition-all duration-300 group"
                        :class="scrolled ? 'hover:bg-gray-100 text-gray-600' : 'hover:bg-white/20 text-white'">
                    <svg class="h-6 w-6 transition-transform duration-300" :class="{ 'rotate-90': open }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'opacity-0 rotate-45': open, 'opacity-100 rotate-0': ! open }" class="transition-all duration-300" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'opacity-100 -rotate-45': open, 'opacity-0 rotate-0': ! open }" class="transition-all duration-300 absolute" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="sm:hidden bg-white/95 backdrop-blur-md border-t border-gray-200/50">
        
        <!-- Mobile Navigation Links -->
        <div class="pt-4 pb-3 space-y-1 px-4">
            <!-- Mobile Dashboard Link - Updated Icon -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10l7-7 7 7M5 10v11a1 1 0 001 1h3m10-11v11a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium">{{ __('Dashboard') }}</span>
            </a>

            <!-- Mobile Products Link - Updated Icon -->
            <a href="{{ route('products.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.1 2 5 5.1 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.9-3.1-7-7-7z M12 11.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.5c0-1.5 1-2.5 2-2.5s1.5 1 1.5 2c0 1-0.5 1.5-1.5 2-1 0.5-2 0-2-1.5z"/>
                </svg>
                <span class="font-medium">{{ __('Produk') }}</span>
            </a>

            <!-- Mobile Categories Link - Updated Icon -->
            <a href="{{ route('categories.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span class="font-medium">{{ __('Kategori') }}</span>
            </a>

            <!-- Mobile Users Link - Updated Icon -->
            <a href="{{ route('users.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197V9a3 3 0 00-6 0v2.5"/>
                </svg>
                <span class="font-medium">{{ __('Pengguna') }}</span>
            </a>
        </div>

        <!-- Mobile User Section -->
        <div class="pt-4 pb-1 border-t border-gray-200/50">
            <div class="px-4">
                <div class="flex items-center space-x-3 px-4 py-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center font-semibold text-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-3 px-4 space-y-1">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ __('Profile') }}</span>
                </a>

                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors duration-200">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>{{ __('Log Out') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Spacer for fixed navbar -->
<div class="h-16"></div>
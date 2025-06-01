<footer class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/90 via-purple-600/90 to-blue-600/90"></div>
    <div class="absolute inset-0 backdrop-blur-sm"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
    
    <div class="relative max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Company Logo & Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-all duration-300 group-hover:rotate-6">
                            <x-application-logo class="block h-6 w-auto fill-current text-white" />
                        </div>
                        <div class="absolute -inset-1 bg-white/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold text-white">Irvana Buah</h3>
                </div>
                <p class="text-white/80 text-sm leading-relaxed">
                    Menyediakan buah-buahan segar berkualitas tinggi dengan teknologi modern dan pelayanan terbaik untuk kebutuhan bisnis Anda.
                </p>
            </div>

            <!-- Quick Navigation -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white mb-4">Menu Cepat</h3>
                <div class="space-y-3">
                    <!-- Dashboard Icon - Fixed -->
                    <a href="{{ route('dashboard') }}" 
                       class="group flex items-center space-x-3 text-white/80 hover:text-white transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-white' : '' }}">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10l7-7 7 7M5 10v11a1 1 0 001 1h3m10-11v11a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-sm font-medium">Dashboard</span>
                        @if(request()->routeIs('dashboard'))
                        <div class="w-1 h-1 bg-white rounded-full"></div>
                        @endif
                    </a>
                    
                    <!-- Products Icon - Fixed (Fruit/Apple Icon) -->
                    <a href="{{ route('products.index') }}" 
                       class="group flex items-center space-x-3 text-white/80 hover:text-white transition-all duration-300 {{ request()->routeIs('products.*') ? 'text-white' : '' }}">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.1 2 5 5.1 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.9-3.1-7-7-7z M12 11.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.5c0-1.5 1-2.5 2-2.5s1.5 1 1.5 2c0 1-0.5 1.5-1.5 2-1 0.5-2 0-2-1.5z"/>
                        </svg>
                        <span class="text-sm font-medium">Produk</span>
                        @if(request()->routeIs('products.*'))
                        <div class="w-1 h-1 bg-white rounded-full"></div>
                        @endif
                    </a>
                    
                    <!-- Categories Icon - Fixed (Folder/Tag Icon) -->
                    <a href="{{ route('categories.index') }}" 
                       class="group flex items-center space-x-3 text-white/80 hover:text-white transition-all duration-300 {{ request()->routeIs('categories.*') ? 'text-white' : '' }}">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="text-sm font-medium">Kategori</span>
                        @if(request()->routeIs('categories.*'))
                        <div class="w-1 h-1 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <!-- Users Icon - Fixed (Multiple People Icon) -->
                    <a href="{{ route('users.index') }}" 
                       class="group flex items-center space-x-3 text-white/80 hover:text-white transition-all duration-300 {{ request()->routeIs('users.*') ? 'text-white' : '' }}">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197V9a3 3 0 00-6 0v2.5"/>
                        </svg>
                        <span class="text-sm font-medium">Pengguna</span>
                        @if(request()->routeIs('users.*'))
                        <div class="w-1 h-1 bg-white rounded-full"></div>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Contact & Support -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white mb-4">Kontak & Dukungan</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 text-white/80 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>info@irvanabuah.com</span>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-white/80 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>(021) 1234-5678</span>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-white/80 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Jakarta, Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider with gradient -->
        <div class="relative mb-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/20"></div>
            </div>
        </div>

        <!-- Bottom Copyright Section -->
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <p class="text-sm text-white/80">
                    © {{ date('Y') }} Irvana Buah. All rights reserved.
                </p>
                <div class="hidden md:flex items-center space-x-2">
                    <div class="w-1 h-1 bg-white/40 rounded-full"></div>
                    <span class="text-xs text-white/60">v2.0</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <p class="text-sm text-white/80 flex items-center space-x-2">
                    <span>Dibuat dengan</span>
                    <svg class="w-4 h-4 text-pink-300 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span>untuk bisnis buah-buahan</span>
                </p>
                
                <!-- Social Icons -->
                <div class="hidden md:flex items-center space-x-2">
                    <button class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300 group">
                        <svg class="w-4 h-4 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>
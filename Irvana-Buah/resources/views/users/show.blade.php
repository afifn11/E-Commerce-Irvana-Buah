<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('users.index') }}" 
                   class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
                <div class="w-px h-6 bg-gray-300"></div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Detail Pengguna
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showDeleteModal: false, userToDelete: null, userName: '' }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- User Header Card -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 px-8 py-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                            <p class="text-white/80 text-sm">{{ $user->email }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if ($user->role === 'admin')
                                <span class="bg-red-500/20 backdrop-blur-sm text-red-100 px-4 py-2 rounded-full text-sm font-medium border border-red-500/30">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.11 3.89 23 5 23H11V21H5V19H13V21H11V23H19C20.11 23 21 22.11 21 21V9H21ZM11 7H17V17H7V7H11Z"/>
                                        </svg>
                                        <span>Administrator</span>
                                    </div>
                                </span>
                            @else
                                <span class="bg-green-500/20 backdrop-blur-sm text-green-100 px-4 py-2 rounded-full text-sm font-medium border border-green-500/30">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2A10 10 0 0 0 2 12A10 10 0 0 0 12 22A10 10 0 0 0 22 12A10 10 0 0 0 12 2M7.07 18.28C7.5 17.38 10.12 16.5 12 16.5S16.5 17.38 16.93 18.28C15.57 19.36 13.86 20 12 20S8.43 19.36 7.07 18.28M18.36 16.83C16.93 15.09 13.46 14.5 12 14.5S7.07 15.09 5.64 16.83C4.62 15.5 4 13.82 4 12C4 7.59 7.59 4 12 4S20 7.59 20 12C20 13.82 19.38 15.5 18.36 16.83M12 6C10.06 6 8.5 7.56 8.5 9.5S10.06 13 12 13S15.5 11.44 15.5 9.5S13.94 6 12 6M12 11C11.17 11 10.5 10.33 10.5 9.5S11.17 8 12 8S13.5 8.67 13.5 9.5S12.83 11 12 11Z"/>
                                        </svg>
                                        <span>Pengguna</span>
                                    </div>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- User Avatar Section -->
                        <div class="space-y-4">
                            <div class="relative group">
                                <div class="w-full h-80 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="w-32 h-32 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <span class="text-4xl font-bold text-white">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 font-medium">{{ $user->name }}</p>
                                        <p class="text-gray-400 text-sm mt-1">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="space-y-6">
                            <!-- Email -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-900 font-medium">{{ $user->email }}</span>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-gray-900 font-medium">
                                        {{ $user->phone_number ?? 'Tidak ada nomor telepon' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-4 border border-purple-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Peran</label>
                                <div class="flex items-center space-x-2">
                                    @if($user->role === 'admin')
                                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.11 3.89 23 5 23H11V21H5V19H13V21H11V23H19C20.11 23 21 22.11 21 21V9H21ZM11 7H17V17H7V7H11Z"/>
                                        </svg>
                                        <span class="text-red-600 font-medium">Administrator</span>
                                    @else
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2A10 10 0 0 0 2 12A10 10 0 0 0 12 22A10 10 0 0 0 22 12A10 10 0 0 0 12 2M7.07 18.28C7.5 17.38 10.12 16.5 12 16.5S16.5 17.38 16.93 18.28C15.57 19.36 13.86 20 12 20S8.43 19.36 7.07 18.28M18.36 16.83C16.93 15.09 13.46 14.5 12 14.5S7.07 15.09 5.64 16.83C4.62 15.5 4 13.82 4 12C4 7.59 7.59 4 12 4S20 7.59 20 12C20 13.82 19.38 15.5 18.36 16.83M12 6C10.06 6 8.5 7.56 8.5 9.5S10.06 13 12 13S15.5 11.44 15.5 9.5S13.94 6 12 6M12 11C11.17 11 10.5 10.33 10.5 9.5S11.17 8 12 8S13.5 8.67 13.5 9.5S12.83 11 12 11Z"/>
                                        </svg>
                                        <span class="text-green-600 font-medium">Pengguna</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Terdaftar</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $user->created_at->format('H:i') }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Diupdate</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->updated_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $user->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Card -->
            @if($user->address)
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-4 border-b">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Alamat</span>
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="prose max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $user->address }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <a href="{{ route('users.index') }}"
                       class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Kembali ke Daftar Pengguna</span>
                    </a>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="group flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 text-sm rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="font-medium">Edit Pengguna</span>
                        </a>
                        
                        <form action="{{ route('users.destroy', $user->id) }}"
                              method="POST" class="inline"
                              x-ref="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    x-on:click="
                                        userToDelete = $refs.deleteForm;
                                        userName = '{{ $user->name }}';
                                        showDeleteModal = true;
                                    "
                                    class="group flex items-center space-x-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 text-sm rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span class="font-medium">Hapus Pengguna</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        <div x-show="showDeleteModal" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" 
             style="display: none;">
            <div x-show="showDeleteModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95" 
                 class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
                <div class="p-6 text-center">
                    {{-- Warning Icon --}}
                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.667-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    
                    {{-- Warning Title --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Penghapusan</h3>
                    
                    {{-- Warning Message --}}
                    <p class="text-gray-600 mb-6">
                        Apakah Anda yakin ingin menghapus pengguna <strong x-text="userName"></strong>? 
                        Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data yang terkait dengan pengguna ini.
                    </p>
                    
                    {{-- Action Buttons --}}
                    <div class="flex space-x-3 justify-center">
                        <button x-on:click="showDeleteModal = false" 
                                class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 transition-all duration-300">
                            Batal
                        </button>
                        <button x-on:click="if(userToDelete) userToDelete.submit()" 
                                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
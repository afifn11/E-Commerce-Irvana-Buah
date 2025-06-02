<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    Manajemen Kategori
                </h2>
            </div>
            <a href="{{ route('categories.create') }}"
               class="group flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 text-sm rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="font-medium">Tambah Kategori</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showDeleteModal: false, categoryToDelete: null, categoryName: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Success Modal --}}
            @if (session('success'))
                <x-modal name="success-notification" :show="true" max-width="md">
                    <div class="p-6 text-center">
                        {{-- Success Icon with Animation --}}
                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4 animate-bounce-once">
                            <svg class="w-8 h-8 text-green-600 animate-checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path 
                                    stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    d="M5 13l4 4L19 7"
                                    class="checkmark-path"
                                    stroke-dasharray="24"
                                    stroke-dashoffset="24"
                                ></path>
                            </svg>
                        </div>
                        
                        {{-- Success Title --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-2 animate-fade-in-up">Berhasil!</h3>
                        
                        {{-- Success Message --}}
                        <p class="text-gray-600 mb-6 animate-fade-in-up-delay">{{ session('success') }}</p>
                        
                        {{-- Close Button --}}
                        <button 
                            x-on:click="show = false" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl animate-fade-in-up-delay-2 hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            OK, Mengerti
                        </button>
                    </div>
                </x-modal>
            @endif

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
                            Apakah Anda yakin ingin menghapus kategori <strong x-text="categoryName"></strong>? 
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                        
                        {{-- Action Buttons --}}
                        <div class="flex space-x-3 justify-center">
                            <button 
                                x-on:click="showDeleteModal = false" 
                                class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 transition-all duration-300">
                                Batal
                            </button>
                            <button 
                                x-on:click="if(categoryToDelete) categoryToDelete.submit()" 
                                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                Ya, Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Dengan Gambar</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $categories->whereNotNull('image')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Ditambahkan Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $categories->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Categories Table --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                @if($categories->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada kategori</h3>
                        <p class="mt-2 text-gray-500">Mulai dengan menambahkan kategori baru.</p>
                        <div class="mt-6">
                            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                                Tambah Kategori Pertama
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Gambar
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Slug
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Dibuat
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($categories as $category)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" 
                                                     class="w-12 h-12 object-cover rounded-lg mx-auto">
                                            @else
                                                <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-gray-200 to-gray-300 flex items-center justify-center mx-auto">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">{{ $category->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $category->slug }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            @if($category->description)
                                                {{ Str::limit($category->description, 50) }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <div class="flex flex-col">
                                                <span class="font-medium">{{ $category->created_at->format('d M Y') }}</span>
                                                <span class="text-xs text-gray-500">{{ $category->created_at->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('categories.show', $category) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 transition-colors duration-150"
                                                   title="Lihat Detail">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('categories.edit', $category) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900 transition-colors duration-150"
                                                   title="Edit">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                                            title="Hapus"
                                                            x-on:click="showDeleteModal = true; categoryToDelete = $el.closest('form'); categoryName = '{{ $category->name }}'">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Pagination --}}
            @if($categories->count() > 0)
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $categories->count() }}</span> kategori
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Custom CSS Animations --}}
    <style>
        /* Bounce animation for icon container */
        @keyframes bounce-once {
            0% { 
                transform: scale(0.3) rotate(-10deg);
                opacity: 0;
            }
            50% { 
                transform: scale(1.05) rotate(5deg);
                opacity: 1;
            }
            70% { 
                transform: scale(0.95) rotate(-2deg);
            }
            100% { 
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        /* Checkmark drawing animation */
        @keyframes draw-checkmark {
            0% {
                stroke-dashoffset: 24;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }

        /* Fade in up animations */
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Apply animations */
        .animate-bounce-once {
            animation: bounce-once 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .animate-checkmark .checkmark-path {
            animation: draw-checkmark 0.6s ease-out 0.3s forwards;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out 0.4s both;
        }

        .animate-fade-in-up-delay {
            animation: fade-in-up 0.6s ease-out 0.6s both;
        }

        .animate-fade-in-up-delay-2 {
            animation: fade-in-up 0.6s ease-out 0.8s both;
        }

        /* Pulse effect for background */
        .animate-bounce-once::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background: rgba(34, 197, 94, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: pulse-ring 1s ease-out 0.1s;
        }

        @keyframes pulse-ring {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(2);
                opacity: 0;
            }
        }

        /* Make the icon container relative for positioning */
        .animate-bounce-once {
            position: relative;
        }
    </style>
</x-app-layout>
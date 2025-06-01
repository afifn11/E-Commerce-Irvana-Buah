<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('categories.index') }}" 
                   class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
                <div class="w-px h-6 bg-gray-300"></div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Detail Kategori
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showDeleteModal: false, categoryToDelete: null, categoryName: '' }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Category Header Card -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 px-8 py-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $category->name }}</h1>
                            <p class="text-white/80 text-sm">{{ $category->slug }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-500/20 backdrop-blur-sm text-green-100 px-4 py-2 rounded-full text-sm font-medium border border-green-500/30">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span>Kategori</span>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Category Image Section -->
                        <div class="space-y-4">
                            <div class="relative group">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                        alt="{{ $category->name }}" 
                                        class="w-full h-80 object-cover rounded-2xl shadow-lg group-hover:shadow-2xl transition-all duration-300"
                                        onclick="openImageModal('{{ asset('storage/' . $category->image) }}', '{{ $category->name }}')"
                                        style="cursor: pointer;"
                                        onerror="this.onerror=null; this.src='{{ asset('images/default-category.png') }}'; this.parentElement.querySelector('.error-overlay').style.display='block';">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <!-- Error overlay (hidden by default) -->
                                    <div class="error-overlay absolute inset-0 bg-red-50 rounded-2xl items-center justify-center border-2 border-dashed border-red-300" style="display: none;">
                                        <div class="text-center p-4">
                                            <svg class="w-12 h-12 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <p class="text-red-600 font-medium text-sm">Gambar tidak dapat dimuat</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center border-2 border-dashed border-gray-300">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-gray-500 font-medium">Tidak ada gambar</p>
                                            <p class="text-gray-400 text-sm mt-1">Upload gambar untuk kategori ini</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Image info -->
                            @if($category->image)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Klik gambar untuk memperbesar</span>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Category Details -->
                        <div class="space-y-6">
                            <!-- Category ID -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">ID Kategori</label>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-gray-900 font-medium">#{{ $category->id }}</span>
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">URL Slug</label>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-gray-900 truncate">{{ $category->slug }}</p>
                                        <p class="text-sm text-gray-600">URL permalink</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Dibuat</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $category->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $category->created_at->format('H:i') }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Diupdate</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $category->updated_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $category->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            @if($category->description)
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-4 border-b">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Deskripsi Kategori</span>
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="prose max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $category->description }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <a href="{{ route('categories.index') }}"
                       class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Kembali ke Daftar Kategori</span>
                    </a>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('categories.edit', $category->id) }}"
                           class="group flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 text-sm rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="font-medium">Edit Kategori</span>
                        </a>
                        
                        <!-- Form Delete dengan hidden untuk modal -->
                        <form id="delete-category-form" action="{{ route('categories.destroy', $category->id) }}"
                              method="POST" class="inline" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        
                        <!-- Delete Button yang memicu modal -->
                        <button @click="showDeleteModal = true; categoryToDelete = document.getElementById('delete-category-form'); categoryName = '{{ $category->name }}'" 
                                class="group flex items-center space-x-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 text-sm rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="font-medium">Hapus Kategori</span>
                        </button>
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
                        Apakah Anda yakin ingin menghapus kategori <strong x-text="categoryName"></strong>?
                        <br><span class="text-sm text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan.</span>
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex space-x-3 justify-center">
                        <button @click="showDeleteModal = false" 
                                class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 transition-all duration-300">
                            Batal
                        </button>
                        <button @click="if(categoryToDelete) categoryToDelete.submit()" 
                                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Ya, Hapus Kategori
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal untuk memperbesar gambar --}}
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="max-w-4xl max-h-4xl p-4">
                <div class="relative">
                    <button onclick="closeImageModal()" class="absolute -top-2 -right-2 bg-white rounded-full p-2 text-gray-800 hover:bg-gray-100 z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <img id="modalImage" src="" alt="" class="max-w-full max-h-full rounded-lg shadow-2xl">
                </div>
            </div>
        </div>
    </div>

    <script>
        function openImageModal(src, alt) {
            document.getElementById('modalImage').src = src;
            document.getElementById('modalImage').alt = alt;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
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
                Tambah Kategori Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Card -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 px-8 py-6">
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Tambah Kategori Baru</h1>
                            <p class="text-white/80 text-sm">Isi form di bawah untuk menambahkan kategori baru</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Error Messages --}}
                    @if ($errors->any()))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                            <div class="flex items-center space-x-2 mb-2">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Terjadi kesalahan:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Hidden input untuk image_type -->
                        <input type="hidden" name="image_type" id="image_type" value="file">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Name Field -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700">
                                    Nama Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('name') border-red-500 ring-red-500 @enderror"
                                           placeholder="Masukkan nama kategori"
                                           required>
                                </div>
                                @error('name')
                                    <p class="text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Slug Field -->
                            <div class="space-y-2">
                                <label for="slug" class="block text-sm font-semibold text-gray-700">
                                    Slug <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('slug') border-red-500 ring-red-500 @enderror"
                                           placeholder="Akan dibuat otomatis">
                                </div>
                                @error('slug')
                                    <p class="text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Gambar Kategori
                            </label>
                            
                            {{-- Tab Navigation --}}
                            <div class="flex border-b border-gray-200 mb-4">
                                <button type="button" id="upload-tab" class="px-4 py-2 border-b-2 border-indigo-500 text-indigo-600 font-medium">
                                    Upload File
                                </button>
                                <button type="button" id="url-tab" class="px-4 py-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium ml-4">
                                    URL Gambar
                                </button>
                            </div>

                            {{-- Upload File Tab --}}
                            <div id="upload-content" class="tab-content">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="file" name="image" id="image" accept="image/*"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('image') border-red-500 ring-red-500 @enderror">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Maksimal 2MB. Format: JPEG, PNG, JPG, GIF, WEBP</p>
                                @error('image')
                                    <p class="text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- URL Tab --}}
                            <div id="url-content" class="tab-content hidden">
                                <div class="flex space-x-2">
                                    <div class="relative flex-grow">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                        </div>
                                        <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('image_url') border-red-500 ring-red-500 @enderror"
                                               placeholder="https://example.com/image.jpg">
                                    </div>
                                    <button type="button" id="validate-url" class="px-4 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                                        Validasi
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Masukkan URL gambar yang valid</p>
                                <div id="url-validation-result" class="mt-2"></div>
                                @error('image_url')
                                    <p class="text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700">
                                Deskripsi <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <textarea name="description" id="description" rows="4"
                                          class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none @error('description') border-red-500 ring-red-500 @enderror"
                                          placeholder="Masukkan deskripsi kategori...">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <p class="text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row justify-end items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('categories.index') }}"
                               class="w-full sm:w-auto group flex items-center justify-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200 px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50">
                                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span class="font-medium">Batal</span>
                            </a>
                            <button type="submit"
                                    class="w-full sm:w-auto group flex items-center justify-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="font-medium">Simpan Kategori</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Script untuk tab dan validasi URL -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Tab switching functionality
                    document.getElementById('upload-tab').addEventListener('click', function() {
                        // Set image type
                        document.getElementById('image_type').value = 'file';
                        
                        // Switch tabs
                        document.getElementById('upload-tab').classList.add('border-indigo-500', 'text-indigo-600');
                        document.getElementById('upload-tab').classList.remove('border-transparent', 'text-gray-500');
                        document.getElementById('url-tab').classList.remove('border-indigo-500', 'text-indigo-600');
                        document.getElementById('url-tab').classList.add('border-transparent', 'text-gray-500');
                        
                        // Switch content
                        document.getElementById('upload-content').classList.remove('hidden');
                        document.getElementById('url-content').classList.add('hidden');
                        
                        // Clear URL input and validation
                        document.getElementById('image_url').value = '';
                        document.getElementById('url-validation-result').innerHTML = '';
                    });

                    document.getElementById('url-tab').addEventListener('click', function() {
                        // Set image type
                        document.getElementById('image_type').value = 'url';
                        
                        // Switch tabs
                        document.getElementById('url-tab').classList.add('border-indigo-500', 'text-indigo-600');
                        document.getElementById('url-tab').classList.remove('border-transparent', 'text-gray-500');
                        document.getElementById('upload-tab').classList.remove('border-indigo-500', 'text-indigo-600');
                        document.getElementById('upload-tab').classList.add('border-transparent', 'text-gray-500');
                        
                        // Switch content
                        document.getElementById('url-content').classList.remove('hidden');
                        document.getElementById('upload-content').classList.add('hidden');
                        
                        // Clear file input
                        document.getElementById('image').value = '';
                    });

                    // URL Validation
                    document.getElementById('validate-url').addEventListener('click', function() {
                        const url = document.getElementById('image_url').value;
                        const resultDiv = document.getElementById('url-validation-result');
                        
                        if (!url) {
                            resultDiv.innerHTML = '<p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>Masukkan URL terlebih dahulu</span></p>';
                            return;
                        }
                        
                        // Show loading
                        resultDiv.innerHTML = '<p class="text-sm text-gray-600 flex items-center space-x-1"><svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span>Memvalidasi URL...</span></p>';
                        
                        // Send AJAX request to validate URL
                        fetch('{{ route("categories.validate-image-url") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ url: url })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.valid) {
                                resultDiv.innerHTML = `
                                    <div class="flex items-center space-x-2 p-2 bg-green-50 rounded-lg">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm text-green-600">${data.message}</p>
                                            <p class="text-xs text-gray-500">Type: ${data.content_type}</p>
                                        </div>
                                    </div>
                                `;
                            } else {
                                resultDiv.innerHTML = `
                                    <div class="flex items-center space-x-2 p-2 bg-red-50 rounded-lg">
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-sm text-red-600">${data.message}</p>
                                    </div>
                                `;
                            }
                        })
                        .catch(error => {
                            resultDiv.innerHTML = `
                                <div class="flex items-center space-x-2 p-2 bg-red-50 rounded-lg">
                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm text-red-600">Gagal memvalidasi URL</p>
                                </div>
                            `;
                        });
                    });

                    // Auto-generate slug from name if slug is empty
                    document.getElementById('name').addEventListener('blur', function() {
                        const name = this.value;
                        const slugInput = document.getElementById('slug');
                        
                        if (name && !slugInput.value) {
                            slugInput.value = name.toLowerCase()
                                .replace(/[^\w\s-]/g, '') // Remove non-word chars
                                .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with -
                                .replace(/^-+|-+$/g, ''); // Trim - from start and end
                        }
                    });
                });
            </script>
        </div>
    </div>
</x-app-layout>
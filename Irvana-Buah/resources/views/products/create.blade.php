<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
                <a href="{{ route('products.index') }}" 
                   class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
                <div class="w-px h-6 bg-gray-300"></div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Tambah Produk
                </h2>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug (Opsional)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('slug') border-red-500 @enderror"
                               placeholder="Akan dibuat otomatis jika dikosongkan">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('category_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('price') border-red-500 @enderror"
                                   required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_price" class="block text-sm font-medium text-gray-700">Harga Diskon (Opsional)</label>
                            <input type="number" name="discount_price" id="discount_price" step="0.01" value="{{ old('discount_price') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('discount_price') border-red-500 @enderror">
                            @error('discount_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('stock') border-red-500 @enderror">
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                        
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
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('image') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Maksimal 2MB. Format: JPEG, PNG, JPG, GIF</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- URL Tab --}}
                        <div id="url-content" class="tab-content hidden">
                            <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('image_url') border-red-500 @enderror"
                                   placeholder="https://example.com/image.jpg">
                            <p class="mt-1 text-sm text-gray-500">Masukkan URL gambar yang valid</p>
                            @error('image_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 mb-4">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active') ? 'checked' : '' }}>
                            <span>Aktif</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_featured" value="1" class="rounded" {{ old('is_featured') ? 'checked' : '' }}>
                            <span>Unggulan</span>
                        </label>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('products.index') }}"
                           class="text-gray-600 hover:underline mr-4">Batal</a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.getElementById('upload-tab').addEventListener('click', function() {
            // Switch tabs
            document.getElementById('upload-tab').classList.add('border-indigo-500', 'text-indigo-600');
            document.getElementById('upload-tab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('url-tab').classList.remove('border-indigo-500', 'text-indigo-600');
            document.getElementById('url-tab').classList.add('border-transparent', 'text-gray-500');
            
            // Switch content
            document.getElementById('upload-content').classList.remove('hidden');
            document.getElementById('url-content').classList.add('hidden');
            
            // Clear URL input
            document.getElementById('image_url').value = '';
        });

        document.getElementById('url-tab').addEventListener('click', function() {
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
    </script>
</x-app-layout>
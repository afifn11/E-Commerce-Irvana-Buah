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
                    Edit Kategori
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

                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Kategori</label>
                        
                        {{-- Hidden input untuk image_type --}}
                        <input type="hidden" name="image_type" id="image_type" value="file">
                        
                        {{-- Current Image Preview --}}
                        @if($category->image)
                            <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <img src="{{ filter_var($category->image, FILTER_VALIDATE_URL) ? $category->image : asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-32 h-32 object-cover rounded border">
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ filter_var($category->image, FILTER_VALIDATE_URL) ? 'URL Eksternal' : 'File Lokal' }}
                                </p>
                            </div>
                        @endif
                        
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
                            <p class="mt-1 text-sm text-gray-500">Maksimal 2MB. Format: JPEG, PNG, JPG, GIF, WEBP. Kosongkan jika tidak ingin mengubah gambar.</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- URL Tab --}}
                        <div id="url-content" class="tab-content hidden">
                            <div class="flex space-x-2">
                                <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('image_url') border-red-500 @enderror"
                                       placeholder="https://example.com/image.jpg">
                                <button type="button" id="validate-url" class="mt-1 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                    Validasi
                                </button>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Masukkan URL gambar yang valid</p>
                            <div id="url-validation-result" class="mt-2"></div>
                            @error('image_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('categories.index') }}"
                           class="text-gray-600 hover:underline mr-4">Batal</a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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
                resultDiv.innerHTML = '<p class="text-sm text-red-600">Masukkan URL terlebih dahulu</p>';
                return;
            }
            
            // Show loading
            resultDiv.innerHTML = '<p class="text-sm text-gray-600">Memvalidasi URL...</p>';
            
            // Send AJAX request to validate URL
            fetch('{{ route("categories.validate-image-url") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ url: url })
            })
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    resultDiv.innerHTML = `
                        <div class="flex items-center space-x-2">
                            <div class="w-16 h-16 border rounded overflow-hidden">
                                <img src="${url}" class="w-full h-full object-cover" onerror="this.src='/images/placeholder.png'">
                            </div>
                            <div>
                                <p class="text-sm text-green-600">✓ ${data.message}</p>
                                <p class="text-xs text-gray-500">Type: ${data.content_type}</p>
                            </div>
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `<p class="text-sm text-red-600">✗ ${data.message}</p>`;
                }
            })
            .catch(error => {
                resultDiv.innerHTML = '<p class="text-sm text-red-600">✗ Gagal memvalidasi URL</p>';
            });
        });
    </script>
</x-app-layout>
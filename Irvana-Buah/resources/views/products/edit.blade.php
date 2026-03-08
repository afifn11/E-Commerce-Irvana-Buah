<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.products.index') }}">Produk</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.products.show', $product) }}">{{ Str::limit($product->name, 20) }}</a><span class="breadcrumb-sep">/</span><span>Edit</span></p>
                <h2 class="page-title">Edit Produk</h2>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-ghost btn-sm">← Detail</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-sm">Daftar</a>
            </div>
        </div>
    </x-slot>
    <div class="dashboard-body">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($errors->any())<div class="alert-error mb-5">⚠ @foreach($errors->all() as $e){{ $e }}. @endforeach</div>@endif
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="table-wrap mb-4" style="padding:22px 26px;">
                    <div class="fsh"><div class="fsi blue"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div><h4 class="fst">Informasi Produk</h4></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div><label class="fl">Nama Produk <span class="req">*</span></label><input type="text" name="name" id="prod-name" value="{{ old('name', $product->name) }}" class="fi{{ $errors->has('name') ? ' fie' : '' }}" required>@error('name')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Slug</label><input type="text" name="slug" id="prod-slug" value="{{ old('slug', $product->slug) }}" class="fi"></div>
                        <div><label class="fl">Kategori <span class="req">*</span></label><select name="category_id" class="fi" required><option value="">-- Pilih Kategori --</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach</select></div>
                        <div><label class="fl">Stok (kg)</label><input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="fi" min="0"></div>
                        <div><label class="fl">Harga Normal (Rp) <span class="req">*</span></label><input type="number" name="price" value="{{ old('price', $product->price) }}" class="fi{{ $errors->has('price') ? ' fie' : '' }}" min="0" required>@error('price')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Harga Diskon (Rp)</label><input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="fi" placeholder="Kosongkan jika tidak ada" min="0"></div>
                        <div style="grid-column:1/-1;"><label class="fl">Deskripsi</label><textarea name="description" class="fi" rows="3">{{ old('description', $product->description) }}</textarea></div>
                    </div>
                </div>
                <div class="table-wrap mb-4" style="padding:22px 26px;">
                    <div class="fsh"><div class="fsi green"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div><h4 class="fst">Gambar Produk</h4></div>
                    @if($product->image)
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;padding:12px;background:rgba(255,255,255,.03);border:1px solid var(--glass-border);border-radius:8px;">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid var(--glass-border);" onerror="this.style.display='none'">
                        <div><p style="font-size:.8rem;font-weight:600;color:var(--text-primary);margin:0 0 2px;">Gambar saat ini</p><p style="font-size:.75rem;color:var(--text-muted);margin:0;">Upload baru untuk mengganti</p></div>
                    </div>
                    @endif
                    <input type="hidden" name="image_type" id="image_type" value="file">
                    <div style="display:flex;gap:8px;margin-bottom:16px;"><button type="button" id="tab-upload" onclick="switchTab('upload')" class="tab-btn tab-active">📁 Upload File</button><button type="button" id="tab-url" onclick="switchTab('url')" class="tab-btn">🔗 URL Gambar</button></div>
                    <div id="content-upload"><label class="fl">Ganti dengan File Baru</label><input type="file" name="image" accept="image/*" class="fi" onchange="previewImg(this)"></div>
                    <div id="content-url" style="display:none;"><label class="fl">Ganti dengan URL Baru</label><input type="url" name="image_url" value="{{ old('image_url', filter_var($product->image ?? '', FILTER_VALIDATE_URL) ? $product->image : '') }}" class="fi" placeholder="https://..."></div>
                    <div id="img-preview" style="display:none;margin-top:14px;"><img id="preview-img" style="width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid var(--glass-border);"></div>
                </div>
                <div class="table-wrap mb-5" style="padding:22px 26px;">
                    <div class="fsh"><div class="fsi yellow"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div><h4 class="fst">Pengaturan</h4></div>
                    <div style="display:flex;gap:28px;flex-wrap:wrap;">
                        <label class="tl"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="ti"><span class="tt"></span><span style="font-size:.85rem;font-weight:500;color:var(--text-primary);">Produk Aktif</span></label>
                        <label class="tl"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="ti"><span class="tt"></span><span style="font-size:.85rem;font-weight:500;color:var(--text-primary);">Produk Unggulan</span></label>
                    </div>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-bottom:2rem;">
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @include('_admin_form_styles')
    @push('scripts')
    <script>
    function switchTab(t){const up=t==='upload';document.getElementById('content-upload').style.display=up?'block':'none';document.getElementById('content-url').style.display=up?'none':'block';document.getElementById('image_type').value=t;document.getElementById('tab-upload').className=up?'tab-btn tab-active':'tab-btn';document.getElementById('tab-url').className=up?'tab-btn':'tab-btn tab-active';}
    function previewImg(input){if(input.files&&input.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById('preview-img').src=e.target.result;document.getElementById('img-preview').style.display='block';};r.readAsDataURL(input.files[0]);}}
    </script>
    @endpush
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.categories.index') }}">Kategori</a><span class="breadcrumb-sep">/</span><span>Tambah Baru</span></p>
                <h2 class="page-title">Tambah Kategori Baru</h2>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
        </div>
    </x-slot>
    <div class="dashboard-body">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($errors->any())<div class="alert-error mb-5">⚠ @foreach($errors->all() as $e){{ $e }}. @endforeach</div>@endif
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="image_type" id="image_type" value="file">
                <div class="table-wrap mb-4" style="padding:22px 26px;">
                    <div class="fsh"><div class="fsi blue"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg></div><h4 class="fst">Informasi Kategori</h4></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div><label class="fl">Nama Kategori <span class="req">*</span></label><input type="text" name="name" id="cat-name" value="{{ old('name') }}" class="fi{{ $errors->has('name') ? ' fie' : '' }}" placeholder="Contoh: Buah Tropis" required>@error('name')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Slug</label><input type="text" name="slug" id="cat-slug" value="{{ old('slug') }}" class="fi" placeholder="buah-tropis"></div>
                        <div style="grid-column:1/-1;"><label class="fl">Deskripsi</label><textarea name="description" class="fi" rows="3" placeholder="Deskripsi kategori...">{{ old('description') }}</textarea></div>
                    </div>
                </div>
                <div class="table-wrap mb-5" style="padding:22px 26px;">
                    <div class="fsh"><div class="fsi green"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div><h4 class="fst">Gambar Kategori</h4></div>
                    <div style="display:flex;gap:8px;margin-bottom:16px;"><button type="button" id="tab-upload" onclick="switchTab('upload')" class="tab-btn tab-active">📁 Upload File</button><button type="button" id="tab-url" onclick="switchTab('url')" class="tab-btn">🔗 URL Gambar</button></div>
                    <div id="content-upload"><label class="fl">File Gambar</label><input type="file" name="image" accept="image/*" class="fi" onchange="previewImg(this)">@error('image')<p class="fe">{{ $message }}</p>@enderror</div>
                    <div id="content-url" style="display:none;"><label class="fl">URL Gambar</label><input type="url" name="image_url" value="{{ old('image_url') }}" class="fi" placeholder="https://..."></div>
                    <div id="img-preview" style="display:none;margin-top:14px;"><img id="preview-img" style="width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid var(--glass-border);"></div>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-bottom:2rem;">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
    @include('_admin_form_styles')
    @push('scripts')
    <script>
    document.getElementById('cat-name').addEventListener('input',function(){document.getElementById('cat-slug').value=this.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-').replace(/-+/g,'-');});
    function switchTab(t){const up=t==='upload';document.getElementById('content-upload').style.display=up?'block':'none';document.getElementById('content-url').style.display=up?'none':'block';document.getElementById('image_type').value=t;document.getElementById('tab-upload').className=up?'tab-btn tab-active':'tab-btn';document.getElementById('tab-url').className=up?'tab-btn':'tab-btn tab-active';}
    function previewImg(input){if(input.files&&input.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById('preview-img').src=e.target.result;document.getElementById('img-preview').style.display='block';};r.readAsDataURL(input.files[0]);}}
    </script>
    @endpush
</x-app-layout>
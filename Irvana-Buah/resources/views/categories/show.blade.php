<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.categories.index') }}">Kategori</a><span class="breadcrumb-sep">/</span><span>Detail</span></p>
                <h2 class="page-title">{{ $category->name }}</h2>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-sm">← Daftar</a>
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">Edit</a>
            </div>
        </div>
    </x-slot>
    <div class="dashboard-body" x-data="{ showDel: false, delForm: null, delName: '' }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="table-wrap mb-4" style="padding:0;overflow:hidden;">
                <div style="padding:20px 26px;background:linear-gradient(135deg,rgba(52,211,153,.08),rgba(96,165,250,.06));border-bottom:1px solid var(--glass-border);display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
                    <div>
                        <h2 style="font-size:1.15rem;font-weight:800;color:var(--text-primary);margin:0 0 4px;">{{ $category->name }}</h2>
                        <code style="font-size:.75rem;color:var(--text-muted);background:var(--glass-bg);border:1px solid var(--glass-border);padding:2px 8px;border-radius:4px;">{{ $category->slug }}</code>
                    </div>
                    <span class="badge badge-green">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Kategori
                    </span>
                </div>
                <div style="padding:24px 26px;display:grid;grid-template-columns:180px 1fr;gap:24px;align-items:start;">
                    {{-- Gambar --}}
                    <div>
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                 style="width:180px;height:180px;object-fit:cover;border-radius:12px;border:1px solid var(--glass-border);cursor:pointer;"
                                 onclick="document.getElementById('imgModal').style.display='flex';document.getElementById('imgBig').src=this.src;">
                            <p style="font-size:.7rem;color:var(--text-muted);margin-top:6px;text-align:center;">Klik untuk perbesar</p>
                        @else
                            <div style="width:180px;height:180px;border-radius:12px;border:1px dashed var(--glass-border);display:flex;align-items:center;justify-content:center;background:var(--surface);">
                                <span style="font-size:3rem;font-weight:800;color:var(--accent)">{{ strtoupper(substr($category->name,0,1)) }}</span>
                            </div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;align-content:start;">
                        <div class="detail-card"><div class="detail-label">ID Kategori</div><div class="detail-value">#{{ $category->id }}</div></div>
                        <div class="detail-card"><div class="detail-label">Slug / URL</div><div class="detail-value" style="word-break:break-all;">{{ $category->slug }}</div></div>
                        <div class="detail-card"><div class="detail-label">Dibuat</div><div class="detail-value">{{ $category->created_at->format('d M Y') }}</div><div class="detail-sub">{{ $category->created_at->format('H:i') }} WIB</div></div>
                        <div class="detail-card"><div class="detail-label">Diupdate</div><div class="detail-value">{{ $category->updated_at->format('d M Y') }}</div><div class="detail-sub">{{ $category->updated_at->format('H:i') }} WIB</div></div>
                        @if($category->description)
                        <div class="detail-card" style="grid-column:1/-1;"><div class="detail-label">Deskripsi</div><div style="font-size:.85rem;color:var(--text-secondary);line-height:1.6;margin-top:4px;">{{ $category->description }}</div></div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="table-wrap" style="padding:16px 26px;display:flex;justify-content:space-between;align-items:center;">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-sm">← Kembali ke Daftar</a>
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Edit
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:none;" x-ref="delForm">@csrf @method('DELETE')</form>
                    <button type="button" class="btn btn-danger btn-sm"
                        x-on:click="showDel=true;delForm=$refs.delForm;delName='{{ addslashes($category->name) }}'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Hapus
                    </button>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div x-show="showDel" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;background:rgba(0,0,0,.7);backdrop-filter:blur(4px);">
            <div x-show="showDel" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="delete-modal-box">
                <div style="width:52px;height:52px;background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;color:var(--danger)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.667-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:.5rem;">Hapus Kategori?</h3>
                <p style="font-size:.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">Kategori <strong style="color:var(--text-primary)" x-text="delName"></strong> akan dihapus permanen.</p>
                <div style="display:flex;gap:.75rem;justify-content:center;">
                    <button x-on:click="showDel=false" class="btn btn-ghost">Batal</button>
                    <button x-on:click="if(delForm)delForm.submit()" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>

        {{-- Image Modal --}}
        <div id="imgModal" onclick="this.style.display='none'" style="display:none;position:fixed;inset:0;z-index:60;background:rgba(0,0,0,.85);align-items:center;justify-content:center;cursor:pointer;">
            <img id="imgBig" style="max-width:90vw;max-height:90vh;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.5);">
        </div>
    </div>
    @include('_admin_form_styles')
</x-app-layout>
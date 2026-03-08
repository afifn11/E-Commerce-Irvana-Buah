<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.users.index') }}">Pengguna</a><span class="breadcrumb-sep">/</span><span>Detail</span></p>
                <h2 class="page-title">{{ $user->name }}</h2>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">← Daftar</a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">Edit</a>
            </div>
        </div>
    </x-slot>
    <div class="dashboard-body" x-data="{ showDel: false, delForm: null, delName: '' }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="table-wrap mb-4" style="padding:0;overflow:hidden;">
                <div style="padding:20px 26px;background:linear-gradient(135deg,rgba(96,165,250,.12),rgba(167,139,250,.08));border-bottom:1px solid var(--glass-border);display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:52px;height:52px;background:linear-gradient(135deg,var(--accent),#60a5fa);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="font-size:1.2rem;font-weight:800;color:var(--bg-base)">{{ strtoupper(substr($user->name,0,2)) }}</span>
                        </div>
                        <div>
                            <h2 style="font-size:1.1rem;font-weight:800;color:var(--text-primary);margin:0 0 3px;">{{ $user->name }}</h2>
                            <p style="font-size:.8rem;color:var(--text-muted);margin:0;">{{ $user->email }}</p>
                        </div>
                    </div>
                    @if($user->role === 'admin')<span class="badge badge-red">👑 Administrator</span>@else<span class="badge badge-blue">👤 Pengguna</span>@endif
                </div>
                <div style="padding:24px 26px;display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div class="detail-card"><div class="detail-label">Email</div><div class="detail-value">{{ $user->email }}</div></div>
                    <div class="detail-card"><div class="detail-label">No. Telepon</div><div class="detail-value">{{ $user->phone_number ?? '—' }}</div></div>
                    <div class="detail-card"><div class="detail-label">Peran</div><div class="detail-value">{{ $user->role === 'admin' ? 'Administrator' : 'Pengguna' }}</div></div>
                    <div class="detail-card"><div class="detail-label">Terdaftar</div><div class="detail-value">{{ $user->created_at->format('d M Y') }}</div><div class="detail-sub">{{ $user->created_at->format('H:i') }} WIB</div></div>
                    @if($user->address)
                    <div class="detail-card" style="grid-column:1/-1;"><div class="detail-label">Alamat</div><div style="font-size:.85rem;color:var(--text-secondary);line-height:1.6;margin-top:4px;white-space:pre-wrap;">{{ $user->address }}</div></div>
                    @endif
                </div>
            </div>

            <div class="table-wrap" style="padding:16px 26px;display:flex;justify-content:space-between;align-items:center;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">← Kembali ke Daftar</a>
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Edit
                    </a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:none;" x-ref="delForm">@csrf @method('DELETE')</form>
                    <button type="button" class="btn btn-danger btn-sm"
                        x-on:click="showDel=true;delForm=$refs.delForm;delName='{{ addslashes($user->name) }}'">
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
                <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:.5rem;">Hapus Pengguna?</h3>
                <p style="font-size:.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">Pengguna <strong style="color:var(--text-primary)" x-text="delName"></strong> akan dihapus permanen.</p>
                <div style="display:flex;gap:.75rem;justify-content:center;">
                    <button x-on:click="showDel=false" class="btn btn-ghost">Batal</button>
                    <button x-on:click="if(delForm)delForm.submit()" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
    @include('_admin_form_styles')
</x-app-layout>
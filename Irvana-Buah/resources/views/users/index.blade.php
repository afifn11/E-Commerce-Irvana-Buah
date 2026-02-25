<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><span>Pengguna</span></p>
                <h2 class="page-title">Manajemen Pengguna</h2>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Pengguna
            </a>
        </div>
    </x-slot>

    <div class="dashboard-body" x-data="{ '{' } showDeleteModal: false, itemToDelete: null, itemName: '' { '}' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <x-modal name="success-notification" :show="true" max-width="md">
                    <div style="padding:2rem;text-align:center;">
                        <div style="width:52px;height:52px;background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;color:var(--success)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem;">Berhasil!</h3>
                        <p style="font-size:0.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">{{ session('success') }}</p>
                        <button x-on:click="show = false" class="btn btn-success btn-sm">OK</button>
                    </div>
                </x-modal>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <div class="stat-meta">Total</div>
                    <div class="stat-value">{{ $users->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(248,113,113,0.1);border-color:rgba(248,113,113,0.15);color:var(--danger)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                    <div class="stat-meta">Admin</div>
                    <div class="stat-value">{{ $users->where('role', 'admin')->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(96,165,250,0.1);border-color:rgba(96,165,250,0.15);color:var(--info)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                    <div class="stat-meta">Pengguna</div>
                    <div class="stat-value">{{ $users->where('role', 'user')->count() }}</div>
                </div>
            </div>

            <div class="table-wrap">
                @if($users->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                        <p class="empty-state-title">Belum ada pengguna</p>
                        <p class="empty-state-text">Tambahkan pengguna baru untuk memulai</p>
                    </div>
                @else
                    <table class="table-glass">
                        <thead><tr><th>Pengguna</th><th>Role</th><th>Kontak</th><th>Bergabung</th><th style="text-align:center;">Aksi</th></tr></thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.75rem;">
                                        <div style="width:34px;height:34px;background:linear-gradient(135deg,var(--accent),#60a5fa);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <span style="font-size:0.75rem;font-weight:700;color:var(--bg-base)">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p style="font-size:0.84rem;font-weight:600;color:var(--text-primary)">{{ $user->name }}</p>
                                            <p style="font-size:0.75rem;color:var(--text-muted)">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge badge-red">Admin</span>
                                    @else
                                        <span class="badge badge-blue">User</span>
                                    @endif
                                </td>
                                <td style="font-size:0.82rem;color:var(--text-secondary)">{{ $user->phone_number ?? '—' }}</td>
                                <td style="font-size:0.8rem;color:var(--text-muted)">{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="table-actions" style="justify-content:center;">
                                        <a href="{{ route('users.show', $user) }}" class="table-action-btn view" title="Detail">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="table-action-btn edit" title="Edit">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="table-action-btn delete" title="Hapus"
                                                x-on:click="showDeleteModal = true; itemToDelete = $event.target.closest('form'); itemName = '{{ $user->name }}'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="padding:0.75rem 1.25rem;border-top:1px solid var(--glass-border);">
                        <p class="pagination-info">{{ $users->count() }} pengguna terdaftar</p>
                    </div>
                @endif
            </div>

            {{-- Delete Modal --}}
            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;background:rgba(0,0,0,0.7);backdrop-filter:blur(4px);">
                <div x-show="showDeleteModal" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     style="background:rgba(12,17,24,0.97);border:1px solid var(--glass-border-strong);border-radius:var(--radius-2xl);padding:2rem;max-width:26rem;width:100%;text-align:center;box-shadow:var(--shadow-lg);">
                    <div style="width:52px;height:52px;background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;color:var(--danger)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.667-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem;">Konfirmasi Hapus</h3>
                    <p style="font-size:0.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">
                        <strong style="color:var(--text-primary)" x-text="itemName"></strong> akan dihapus permanen.
                    </p>
                    <div style="display:flex;gap:0.75rem;justify-content:center;">
                        <button x-on:click="showDeleteModal = false" class="btn btn-ghost">Batal</button>
                        <button x-on:click="if(itemToDelete) itemToDelete.submit()" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

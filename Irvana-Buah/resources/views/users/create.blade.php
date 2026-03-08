<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.users.index') }}">Pengguna</a><span class="breadcrumb-sep">/</span><span>Tambah Baru</span></p>
                <h2 class="page-title">Tambah Pengguna Baru</h2>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
        </div>
    </x-slot>
    <div class="dashboard-body">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($errors->any())<div class="alert-error mb-5">⚠ @foreach($errors->all() as $e){{ $e }}. @endforeach</div>@endif
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="table-wrap mb-4" style="padding:22px 26px;">
                    <div class="fsh"><div class="fsi blue"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div><h4 class="fst">Informasi Akun</h4></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div><label class="fl">Nama Lengkap <span class="req">*</span></label><input type="text" name="name" value="{{ old('name') }}" class="fi{{ $errors->has('name') ? ' fie' : '' }}" placeholder="Nama lengkap" required>@error('name')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Email <span class="req">*</span></label><input type="email" name="email" value="{{ old('email') }}" class="fi{{ $errors->has('email') ? ' fie' : '' }}" placeholder="email@example.com" required>@error('email')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Password <span class="req">*</span></label><input type="password" name="password" class="fi{{ $errors->has('password') ? ' fie' : '' }}" placeholder="Min. 8 karakter" required>@error('password')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Konfirmasi Password <span class="req">*</span></label><input type="password" name="password_confirmation" class="fi" placeholder="Ulangi password" required></div>
                        <div><label class="fl">Peran <span class="req">*</span></label><select name="role" class="fi{{ $errors->has('role') ? ' fie' : '' }}" required><option value="">-- Pilih Peran --</option><option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Administrator</option><option value="user" {{ old('role')=='user' ? 'selected' : '' }}>Pengguna</option></select>@error('role')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">No. Telepon</label><input type="text" name="phone_number" value="{{ old('phone_number') }}" class="fi" placeholder="08xxxxxxxxxx"></div>
                        <div style="grid-column:1/-1;"><label class="fl">Alamat</label><textarea name="address" class="fi" rows="3" placeholder="Alamat lengkap...">{{ old('address') }}</textarea></div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-bottom:2rem;">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
    @include('_admin_form_styles')
</x-app-layout>
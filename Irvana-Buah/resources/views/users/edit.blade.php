<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.users.index') }}">Pengguna</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.users.show', $user) }}">{{ Str::limit($user->name, 20) }}</a><span class="breadcrumb-sep">/</span><span>Edit</span></p>
                <h2 class="page-title">Edit Pengguna</h2>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-ghost btn-sm">← Detail</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">Daftar</a>
            </div>
        </div>
    </x-slot>
    <div class="dashboard-body">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($errors->any())<div class="alert-error mb-5">⚠ @foreach($errors->all() as $e){{ $e }}. @endforeach</div>@endif
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf @method('PUT')
                <div class="table-wrap mb-4" style="padding:22px 26px;">
                    <div class="fsh"><div class="fsi blue"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div><h4 class="fst">Informasi Akun</h4></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div><label class="fl">Nama Lengkap <span class="req">*</span></label><input type="text" name="name" value="{{ old('name', $user->name) }}" class="fi{{ $errors->has('name') ? ' fie' : '' }}" required>@error('name')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Email <span class="req">*</span></label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="fi{{ $errors->has('email') ? ' fie' : '' }}" required>@error('email')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Password Baru</label><input type="password" name="password" class="fi{{ $errors->has('password') ? ' fie' : '' }}" placeholder="Kosongkan jika tidak diubah">@error('password')<p class="fe">{{ $message }}</p>@enderror</div>
                        <div><label class="fl">Konfirmasi Password</label><input type="password" name="password_confirmation" class="fi" placeholder="Ulangi password baru"></div>
                        <div><label class="fl">Peran <span class="req">*</span></label><select name="role" class="fi" required><option value="">-- Pilih Peran --</option><option value="admin" {{ old('role',$user->role)=='admin'?'selected':'' }}>Administrator</option><option value="user" {{ old('role',$user->role)=='user'?'selected':'' }}>Pengguna</option></select></div>
                        <div><label class="fl">No. Telepon</label><input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="fi" placeholder="08xxxxxxxxxx"></div>
                        <div style="grid-column:1/-1;"><label class="fl">Alamat</label><textarea name="address" class="fi" rows="3">{{ old('address', $user->address) }}</textarea></div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-bottom:2rem;">
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @include('_admin_form_styles')
</x-app-layout>
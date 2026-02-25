<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:28px;height:28px;color:var(--accent)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="auth-title">Password Baru</h1>
            <p class="auth-subtitle">Masukkan password baru Anda</p>
        </div>
        <div class="auth-body">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" class="form-input" required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="form-error" />
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password Baru</label>
                    <input id="password" type="password" name="password" class="form-input" placeholder="••••••••" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="form-error" />
                </div>
                <div class="form-group" style="margin-bottom:1.5rem;">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="form-error" />
                </div>
                <button type="submit" class="btn btn-primary btn-w-full">Reset Password</button>
            </form>
        </div>
    </div>
</x-guest-layout>

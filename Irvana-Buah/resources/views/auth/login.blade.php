<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo-wrap">
                <x-application-logo class="block h-7 w-auto fill-current" style="color: var(--accent)" />
            </div>
            <h1 class="auth-title">Selamat Datang</h1>
            <p class="auth-subtitle">Masuk ke akun Irvana Buah Anda</p>
        </div>

        <div class="auth-body">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-input" placeholder="nama@email.com" required autofocus autocomplete="username">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="form-error" />
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input id="password" type="password" name="password"
                               class="form-input" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="form-error" />
                </div>

                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                        <input id="remember_me" type="checkbox" name="remember" class="form-checkbox">
                        <span style="font-size:0.82rem; color:var(--text-muted);">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:0.82rem; color:var(--accent); font-weight:600;">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary btn-w-full btn-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Masuk
                </button>
            </form>
        </div>

        @if (Route::has('register'))
        <div class="auth-footer">
            <p class="auth-footer-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>
        @endif
    </div>
</x-guest-layout>

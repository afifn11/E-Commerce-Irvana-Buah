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

            {{-- Social Auth Buttons --}}
            <div class="social-auth-wrap">
                <a href="{{ route('social.redirect', 'google') }}" class="social-btn">
                    <svg viewBox="0 0 24 24" class="social-btn-icon">
                        <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/>
                        <path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/>
                        <path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/>
                        <path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/>
                    </svg>
                    <span>Lanjutkan dengan Google</span>
                </a>
            </div>

            {{-- Divider --}}
            <div class="auth-divider">
                <span>atau masuk dengan email</span>
            </div>

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

    @push('styles')
    <style>
    /* Social Auth Buttons */
    .social-auth-wrap { display: flex; flex-direction: column; gap: 10px; margin-bottom: 1.25rem; }
    .social-btn {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        padding: 0.65rem 1rem;
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--glass-border-strong);
        border-radius: var(--radius-sm);
        color: var(--text-primary);
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s, transform 0.15s;
    }
    .social-btn:hover {
        background: rgba(255,255,255,0.08);
        border-color: rgba(255,255,255,0.2);
        color: var(--text-primary);
        transform: translateY(-1px);
    }
    .social-btn-icon { width: 18px; height: 18px; flex-shrink: 0; }

    /* Divider */
    .auth-divider {
        display: flex; align-items: center; gap: 0.75rem;
        margin-bottom: 1.25rem;
        color: var(--text-muted); font-size: 0.78rem;
    }
    .auth-divider::before, .auth-divider::after {
        content: ''; flex: 1;
        height: 1px; background: var(--glass-border);
    }
    </style>
    @endpush
</x-guest-layout>
<x-guest-layout>
    <div class="auth-card" style="max-width: 30rem;">
        <div class="auth-header">
            <div class="auth-logo-wrap">
                <x-application-logo class="block h-7 w-auto fill-current" style="color: var(--accent)" />
            </div>
            <h1 class="auth-title">Buat Akun Baru</h1>
            <p class="auth-subtitle">Bergabung dengan Irvana Buah hari ini</p>
        </div>

        <div class="auth-body">

            {{-- Social Auth Buttons --}}
            <div class="social-auth-wrap">
                <a href="{{ route('social.redirect', 'google') }}" class="social-btn">
                    <svg viewBox="0 0 24 24" class="social-btn-icon">
                        <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/>
                        <path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/>
                        <path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/>
                        <path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/>
                    </svg>
                    <span>Daftar dengan Google</span>
                </a>
            </div>

            {{-- Divider --}}
            <div class="auth-divider">
                <span>atau daftar dengan email</span>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               class="form-input" placeholder="Nama Anda" required autofocus autocomplete="name">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="form-error" />
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-input" placeholder="nama@email.com" required autocomplete="username">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="form-error" />
                </div>

                <div class="form-group">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}"
                               class="form-input" placeholder="+62 812 3456 7890">
                    </div>
                    <x-input-error :messages="$errors->get('phone_number')" class="form-error" />
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea id="address" name="address" class="form-textarea" placeholder="Alamat lengkap Anda" rows="2">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="form-error" />
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input id="password" type="password" name="password"
                               class="form-input" placeholder="Min. 8 karakter" required autocomplete="new-password">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="form-error" />
                </div>

                <div class="form-group" style="margin-bottom:1.5rem;">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="form-input" placeholder="Ulangi password" required autocomplete="new-password">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="form-error" />
                </div>

                <button type="submit" class="btn btn-primary btn-w-full btn-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Buat Akun
                </button>
            </form>
        </div>

        <div class="auth-footer">
            <p class="auth-footer-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
        </div>
    </div>

    @push('styles')
    <style>
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
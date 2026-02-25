<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:28px;height:28px;color:var(--accent)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle">Masukkan email untuk menerima link reset</p>
        </div>
        <div class="auth-body">
            @if (session('status'))
                <div class="alert alert-success" style="margin-bottom:1.25rem;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group" style="margin-bottom:1.5rem;">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="nama@email.com" required autofocus>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="form-error" />
                </div>
                <button type="submit" class="btn btn-primary btn-w-full">Kirim Link Reset</button>
            </form>
        </div>
        <div class="auth-footer">
            <p class="auth-footer-link"><a href="{{ route('login') }}">← Kembali ke Login</a></p>
        </div>
    </div>
</x-guest-layout>

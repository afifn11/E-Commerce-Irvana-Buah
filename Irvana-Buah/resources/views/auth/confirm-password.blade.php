<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:28px;height:28px;color:var(--accent)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="auth-title">Konfirmasi Password</h1>
            <p class="auth-subtitle">Masukkan password Anda untuk melanjutkan</p>
        </div>
        <div class="auth-body">
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-group" style="margin-bottom:1.5rem;">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input id="password" type="password" name="password" class="form-input" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="form-error" />
                </div>
                <button type="submit" class="btn btn-primary btn-w-full">Konfirmasi</button>
            </form>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:28px;height:28px;color:var(--accent)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                </svg>
            </div>
            <h1 class="auth-title">Verifikasi Email</h1>
            <p class="auth-subtitle">Silakan cek email Anda dan klik link verifikasi</p>
        </div>
        <div class="auth-body">
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" style="margin-bottom:1.25rem;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Link verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-w-full">Kirim Ulang Email Verifikasi</button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-w-full">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

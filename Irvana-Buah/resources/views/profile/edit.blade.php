<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="header-label">Akun</p>
            <h2 class="header-title">Profil Saya</h2>
        </div>
    </x-slot>

    <div class="dashboard-body">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="profile-section">
                <div class="profile-section-header">
                    <h3>Informasi Profil</h3>
                    <p>Perbarui nama dan alamat email akun Anda</p>
                </div>
                <div class="profile-section-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="profile-section">
                <div class="profile-section-header">
                    <h3>Ubah Password</h3>
                    <p>Gunakan password yang kuat dan unik</p>
                </div>
                <div class="profile-section-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="profile-section" style="border-color:rgba(248,113,113,0.15);">
                <div class="profile-section-header" style="border-bottom-color:rgba(248,113,113,0.1);">
                    <h3 style="color:var(--danger)">Hapus Akun</h3>
                    <p>Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <div class="profile-section-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

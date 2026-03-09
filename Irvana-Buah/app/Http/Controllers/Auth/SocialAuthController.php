<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Provider yang didukung.
     */
    protected array $allowedProviders = ['google'];

    /**
     * Redirect ke halaman OAuth provider.
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle callback dari provider setelah user authorize.
     */
    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Login via ' . ucfirst($provider) . ' gagal. Silakan coba lagi.']);
        }

        // Cari user yang sudah terhubung dengan provider ini
        $user = User::where("{$provider}_id", $socialUser->getId())->first();

        if (! $user) {
            // Coba cari berdasarkan email (user sudah punya akun biasa)
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Link akun existing dengan provider ini
                $user->update([
                    "{$provider}_id" => $socialUser->getId(),
                    'avatar'         => $user->avatar ?? $socialUser->getAvatar(),
                ]);
            } else {
                // Buat akun baru
                $user = User::create([
                    'name'           => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                    'email'          => $socialUser->getEmail(),
                    'password'       => null, // tidak punya password, login hanya via OAuth
                    "{$provider}_id" => $socialUser->getId(),
                    'avatar'         => $socialUser->getAvatar(),
                    'role'           => 'user',
                    'email_verified_at' => now(), // email dari OAuth sudah terverifikasi
                ]);
            }
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('home'));
    }

    /**
     * Pastikan provider valid.
     */
    protected function validateProvider(string $provider): void
    {
        if (! in_array($provider, $this->allowedProviders)) {
            abort(404);
        }
    }
}
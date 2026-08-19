<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected array $providers = ['facebook', 'google', 'apple'];

    public function redirect(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, $this->providers), 404);

        return Socialite::driver($provider)
            ->scopes($this->getScopes($provider))
            ->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, $this->providers), 404);

        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                    'password' => Hash::make(Str::random(32)),
                    'avatar' => $socialUser->getAvatar(),
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user, remember: true);

            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Unable to login with ' . ucfirst($provider) . '. Please try again.']);
        }
    }

    protected function getScopes(string $provider): array
    {
        return match ($provider) {
            'facebook' => ['email'],
            'google' => ['email', 'profile'],
            default => [],
        };
    }
}

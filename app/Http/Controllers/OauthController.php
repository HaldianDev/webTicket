<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Exception;

class OauthController extends Controller
{
    public function redirectToProvider()
    {
        // Redirect ke Google OAuth consent screen
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser);

            $user = User::where('gauth_id', $googleUser->id)->first();

            if (!$user) {
                $user = User::create([
                    'name'       => $googleUser->name,
                    'email'      => $googleUser->email,
                    'gauth_id'   => $googleUser->id,
                    'gauth_type' => 'google',
                    'password'   => bcrypt('user@123'),
                    'role'       => 'user',
                ]);
            }

            Auth::login($user);

            if (Auth::check()) {
                Log::info('User logged in via Google: ' . Auth::user()->email);
            } else {
                Log::warning('User NOT logged in after Google callback.');
            }

            return redirect()->intended('/dashboard');

        } catch (Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['oauth' => 'Login Google gagal.']);
        }
    }

}

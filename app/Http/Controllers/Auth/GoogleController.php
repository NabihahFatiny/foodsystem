<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user is trying to use admin email
            if ($googleUser->email === 'admin@gmail.com') {
                return redirect()->route('login.customer')
                    ->with('error', 'Please use regular login for admin access');
            }

            // Log the Google user data for debugging
            Log::info('Google User Data:', [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'id' => $googleUser->id
            ]);

            // First try to find user by google_id
            $user = User::where('google_id', $googleUser->id)->first();

            // If not found by google_id, try by email
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();
            }

            // If user doesn't exist, create new one
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(24)),
                    'email_verified_at' => now(), // Mark email as verified
                ]);
            } else {
                // Update existing user with google_id if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id
                    ]);
                }
            }

            Auth::login($user);

            // Log successful login
            Log::info('User logged in successfully:', ['user_id' => $user->id]);

            return redirect('/dashboard');

        } catch (Exception $e) {
            // Log the error
            Log::error('Google login error: ' . $e->getMessage());

            return redirect()->route('login.customer')
                ->with('error', 'Something went wrong with Google login');
        }
    }
}

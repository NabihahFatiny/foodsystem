<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoginController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function showCustomerLoginForm()
    {
        return view('auth.customer-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('Admin login attempt:', ['email' => $credentials['email']]);

        // Check if admin exists, if not create one
        $admin = User::where('email', 'admin@gmail.com')->first();
        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
            ]);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->email === 'admin@gmail.com') {
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }

            Auth::logout();
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials.',
        ]);
    }

    public function customerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->email !== 'admin@gmail.com') {
                $request->session()->regenerate();
                return redirect('/dashboard');
            }

            Auth::logout();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}

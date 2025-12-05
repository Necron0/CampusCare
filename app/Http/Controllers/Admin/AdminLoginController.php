<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $user = Auth::user();


            if ($user->role !== 'admin') {
                Auth::logout();
                Log::warning('Unauthorized login attempt', [
                    'email' => $request->email,
                    'ip'    => $request->ip(),
                    'role'  => $user->role,
                ]);

                return back()->withErrors(['email' => 'Anda tidak memiliki akses sebagai admin.']);
            }

            Log::info('Admin logged in successfully', [
                'user_id' => $user->id,
                'ip'      => $request->ip(),
            ]);


            return redirect()->intended(route('admin.dashboard'));
        }


        Log::warning('Failed admin login attempt', [
            'email' => $request->email,
            'ip'    => $request->ip(),
        ]);

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses Login Manual
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Coba Login dengan Auth Laravel
        // Auth::attempt otomatis meng-hash password input dan mencocokkan dengan DB
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            
            // 3. Security: Regenerate Session ID (Cegah Session Fixation)
            $request->session()->regenerate();
            
            // 4. Cek Status Aktif User
            if (Auth::user()->is_active == 0) {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun Anda dinonaktifkan. Hubungi Admin.']);
            }

            // 5. Redirect ke Dashboard
            return redirect()->intended('dashboard');
        }

        // 6. Jika Gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
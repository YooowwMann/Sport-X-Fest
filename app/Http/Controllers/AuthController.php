<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau Password salah');
        }

        // Cek apakah user aktif
        if (!Auth::user()->is_active) {
            Auth::logout();
            return back()->with('error', 'Akun kamu dinonaktifkan. Hubungi admin.');
        }

        $request->session()->regenerate();
        ActivityLog::record('login', 'User login: ' . Auth::user()->email);

        // Redirect berdasarkan role
        if (Auth::user()->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/dashboard');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|min:9|max:20|regex:/^[0-9+\-\s]+$/',
            'password' => 'required|min:6|confirmed',
        ], [
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min'      => 'Nomor telepon minimal 9 digit.',
            'phone.regex'    => 'Format nomor telepon tidak valid.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect('/login')->with('success', 'Register berhasil, silakan login');
    }

    public function logout(Request $request)
    {
        ActivityLog::record('logout', 'User logout: ' . Auth::user()->email);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

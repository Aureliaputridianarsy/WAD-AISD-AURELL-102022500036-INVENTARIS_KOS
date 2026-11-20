<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('inventaris.index');
        }

        return view('auth.login');
    }

    /**
     * Memproses percobaan login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('inventaris.index'))
                ->with('flash_success', 'Selamat datang kembali, ' . Auth::user()->name . ' (' . Auth::user()->role_label . ')!');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
            ]);
    }

    /**
     * Menampilkan form pendaftaran (register) pengguna baru.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('inventaris.index');
        }

        return view('auth.register');
    }

    /**
     * Memproses pendaftaran pengguna baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role'     => ['nullable', 'in:penyewa,staff'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Alamat email sudah terdaftar di sistem.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.in'            => 'Pilihan peran tidak valid.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'role'     => $validated['role'] ?? 'penyewa',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('inventaris.index')
            ->with('flash_success', 'Pendaftaran akun berhasil! Selamat datang, ' . $user->name . ' (' . $user->role_label . ')!');
    }

    /**
     * Logout pengguna dan hancurkan sesi aktif.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('flash_success', 'Anda telah berhasil logout.');
    }
}

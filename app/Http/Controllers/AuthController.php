<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Tampilkan halaman login selalu, agar user bisa login role lain (multi-guard) 
        // tanpa harus logout terlebih dahulu untuk keperluan testing.
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Cari user berdasarkan email dan status aktif
        $user = User::where('email', $credentials['email'])
            ->where('status_aktif', 1)
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $guard = $user->role; // 'admin', 'petugas', atau 'owner'

            // Login ke guard spesifik sesuai role
            Auth::guard($guard)->login($user);
            $request->session()->regenerate();

            // Log aktivitas login
            LogAktivitas::create([
                'id_user'         => $user->id_user,
                'aktivitas'       => 'User berhasil login',
                'waktu_aktivitas' => now(),
            ]);

            return $this->redirectBasedOnRole($user->role);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun tidak aktif.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Logout dari semua guard yang mungkin sedang aktif
        foreach (['admin', 'petugas', 'owner'] as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                LogAktivitas::create([
                    'id_user'         => $user->id_user,
                    'aktivitas'       => 'User berhasil logout',
                    'waktu_aktivitas' => now(),
                ]);

                Auth::guard($guard)->logout();
            }
        }

        // Invalidate session sepenuhnya agar bersih dari semua sisa data login
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function redirectBasedOnRole($role)
    {
        return match ($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            'owner'   => redirect()->route('owner.dashboard'),
            default   => redirect('/'),
        };
    }
}

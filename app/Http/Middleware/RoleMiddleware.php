<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Cek guard spesifik sesuai role yang dibutuhkan route.
     * Jika cocok, set user ke default guard agar Auth::user() bekerja di seluruh request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        foreach ($roles as $role) {
            if (Auth::guard($role)->check()) {
                // Set default guard untuk request ini agar Auth::user() konsisten
                Auth::shouldUse($role);
                return $next($request);
            }
        }

        // Tidak ada guard yang cocok → redirect ke login
        return redirect()->route('login');
    }
}

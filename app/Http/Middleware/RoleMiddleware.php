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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $user = Auth::user();

        // Superadmin memiliki akses ke seluruh halaman admin
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Cek apakah role pengguna cocok dengan salah satu role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak memiliki izin akses
        return redirect()->route('dashboard.redirect')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk membuka halaman tersebut.');
    }
}


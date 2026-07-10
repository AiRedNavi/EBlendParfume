<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user saat ini ada di dalam daftar role yang diizinkan
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak punya akses, tendang kembali ke halaman utama atau dashboard masing-masing
        if (Auth::user()->role === 'pelanggan') {
            return redirect()->route('dashboard.pelanggan');
        }

        return redirect()->route('dashboard.admin');
    }
}
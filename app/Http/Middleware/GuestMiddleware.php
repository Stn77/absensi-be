<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login, redirect ke dashboard
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('guru')) {
                return redirect()->route('guru.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }

        // Jika belum login, lanjutkan request
        return $next($request);
    }
}

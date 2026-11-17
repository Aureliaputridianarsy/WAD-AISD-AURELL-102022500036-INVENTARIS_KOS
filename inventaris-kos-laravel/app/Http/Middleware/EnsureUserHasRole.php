<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Menangani request masuk dan memvalidasi apakah pengguna memiliki role yang diizinkan.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! empty($roles) && ! $request->user()->hasRole($roles)) {
            abort(403, 'Akses Ditolak: Peran akun Anda (' . $request->user()->role_label . ') tidak memiliki izin untuk fitur ini.');
        }

        return $next($request);
    }
}

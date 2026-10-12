<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk membatasi akses berdasarkan kolom `role` pada tabel users.
 *
 * Cara pakai di route:
 *   ->middleware('role:admin')              // hanya admin
 *   ->middleware('role:admin,karyawan')     // admin atau karyawan
 *   ->middleware('auth','role:pelanggan')   // harus login + role pelanggan
 */
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diizinkan (dipisah koma di route)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (! $request->user()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Silakan login terlebih dahulu.');
        }

        // Cek apakah role user termasuk salah satu yang diizinkan
        if (! $request->user()->hasRole($roles)) {
            abort(Response::HTTP_FORBIDDEN, 'Akses ditolak: Anda tidak memiliki izin role '.implode(', ', $roles).'.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Melindungi halaman admin: kalau belum login, arahkan ke halaman login.
 * (Sama fungsinya dengan admin/auth.php di versi PHP Native.)
 */
class AdminLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('login')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

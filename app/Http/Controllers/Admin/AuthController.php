<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Login & logout admin. Memakai tabel `admin` yang sudah ada:
 * password disimpan dalam bentuk hash bcrypt dan diperiksa dengan Hash::check
 * (sama seperti password_verify di versi PHP Native).
 */
class AuthController extends Controller
{
    public function form(Request $request)
    {
        if ($request->session()->get('login')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $username = trim((string) $request->input('username', ''));
        $password = (string) $request->input('password', '');

        if ($username === '' || $password === '') {
            return back()->withInput(['username' => $username])->withErrors(['login' => 'Username dan password wajib diisi.']);
        }

        $admin = DB::table('admin')->where('username', $username)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            $request->session()->regenerate();
            $request->session()->put('login', true);
            $request->session()->put('username', $admin->username);

            return redirect()->route('admin.dashboard');
        }

        return back()->withInput(['username' => $username])->withErrors(['login' => 'Username atau password salah!']);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

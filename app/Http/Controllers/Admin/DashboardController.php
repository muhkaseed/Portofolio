<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Semua angka diambil langsung dari database.
        $statistik = [
            ['Skills', DB::table('skill')->count(), 'admin.skill.index', 'code'],
            ['Education', DB::table('education')->count(), 'admin.education.index', 'school'],
            ['Experience', DB::table('experience')->count(), 'admin.experience.index', 'briefcase'],
            ['Projects', DB::table('projects')->count(), 'admin.projects.index', 'folder'],
            ['Certificates', DB::table('certificates')->count(), 'admin.certificates.index', 'award'],
            ['Pesan masuk', DB::table('pesan_kontak')->count(), 'admin.pesan.index', 'mail'],
        ];
        $pesanTerbaru = DB::table('pesan_kontak')->orderByDesc('id')->limit(5)->get();

        return view('admin.dashboard', compact('statistik', 'pesanTerbaru'));
    }
}

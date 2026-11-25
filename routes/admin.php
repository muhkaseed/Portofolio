<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\Admin\PesanController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use Illuminate\Support\Facades\Route;

/*
| Semua alamat admin diawali /admin  (contoh: localhost/admin/login)
| Halaman di dalam group 'admin' hanya bisa dibuka setelah login.
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Login
    Route::get('login', [AuthController::class, 'form'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.proses');

    // Halaman yang wajib login
    Route::middleware('admin')->group(function () {
        Route::redirect('/', '/admin/dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Form tunggal (hanya 1 data)
        Route::get('profil', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::post('profil', [ProfilController::class, 'update'])->name('profil.update');
        Route::get('kontak', [KontakController::class, 'edit'])->name('kontak.edit');
        Route::post('kontak', [KontakController::class, 'update'])->name('kontak.update');

        // CRUD: daftar, tambah, edit, hapus (semua simpan/ubah/hapus pakai POST)
        $crud = [
            'skill' => SkillController::class,
            'education' => EducationController::class,
            'experience' => ExperienceController::class,
            'projects' => ProjectController::class,
            'certificates' => CertificateController::class,
        ];
        foreach ($crud as $slug => $controller) {
            Route::get($slug, [$controller, 'index'])->name("$slug.index");
            Route::get("$slug/tambah", [$controller, 'create'])->name("$slug.create");
            Route::post("$slug/tambah", [$controller, 'store'])->name("$slug.store");
            Route::get("$slug/{id}/edit", [$controller, 'edit'])->whereNumber('id')->name("$slug.edit");
            Route::post("$slug/{id}/edit", [$controller, 'update'])->whereNumber('id')->name("$slug.update");
            Route::post("$slug/{id}/hapus", [$controller, 'destroy'])->whereNumber('id')->name("$slug.destroy");
        }

        // Pesan kontak
        Route::get('pesan', [PesanController::class, 'index'])->name('pesan.index');
        Route::get('pesan/{id}', [PesanController::class, 'show'])->whereNumber('id')->name('pesan.show');
        Route::post('pesan/{id}/hapus', [PesanController::class, 'destroy'])->whereNumber('id')->name('pesan.destroy');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Adminpolres\AdminPolresController;
use App\Http\Controllers\Adminpolsek\AdminPolsekController;
use App\Http\Controllers\Adminpolsek\PolsekUserController;
use App\Http\Controllers\Adminpolsek\PolsekPenjualanController;
use App\Http\Controllers\Adminpolda\AdminPoldaController;
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Superadmin\AkunUserController;
use App\Http\Controllers\Superadmin\AkunPolresController;
use App\Http\Controllers\Superadmin\AkunPolsekController;
use App\Http\Controllers\Superadmin\PolresController;
use App\Http\Controllers\Superadmin\PolsekController;
use App\Http\Controllers\Pimpinan\PimpinanController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\MasyarakatController;
use App\Models\Polsek;
use Illuminate\Http\Request;


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');

    Route::get('/admin', [LoginController::class, 'adminPage'])->name('login.admin');
    Route::post('/admin', [LoginController::class, 'loginAdmin'])->name('login.admin.process');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

    
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::middleware([ 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');

    Route::get('/akun/polres', [AkunPolresController::class, 'index'])->name('akun.polres');
    Route::get('/tambah/akun/polres', [AkunPolresController::class, 'tambahPage'])->name('tambah.akun.polres');
    Route::post('/tambah/akun/polres', [AkunPolresController::class, 'store'])->name('tambah.akun.polres.process');
    Route::get('/edit/akun/polres/{id}', [AkunPolresController::class, 'editPage'])->name('edit.akun.polres');
    Route::put('/edit/akun/polres/{id}', [AkunPolresController::class, 'update'])->name('edit.akun.polres.process');
    Route::delete('/hapus/akun/polres/{id}', [AkunPolresController::class, 'destroy'])->name('hapus.akun.polres');

    Route::get('/akun/polsek', [AkunPolsekController::class, 'index'])->name('akun.polsek');
    Route::get('/tambah/akun/polsek', [AkunPolsekController::class, 'tambahPage'])->name('tambah.akun.polsek');
    Route::post('/tambah/akun/polsek', [AkunPolsekController::class, 'store'])->name('tambah.akun.polsek.process');
    Route::get('/edit/akun/polsek/{id}', [AkunPolsekController::class, 'editPage'])->name('edit.akun.polsek');
    Route::put('/edit/akun/polsek/{id}', [AkunPolsekController::class, 'update'])->name('edit.akun.polsek.process');
    Route::delete('/hapus/akun/polsek/{id}', [AkunPolsekController::class, 'destroy'])->name('hapus.akun.polsek');





    Route::get('/akun/user', [AkunUserController::class, 'index'])->name('akun.user');
    Route::get('/detail/user/{id}', [AkunUserController::class, 'detailUser'])->name('detail.user');
    Route::put('/setujui/user/{id}', [AkunUserController::class, 'setujuiUser'])->name('setujui.user');

    Route::get('/polres', [PolresController::class, 'index'])->name('polres');
    Route::get('/tambah/polres', [PolresController::class, 'tambahPage'])->name('tambah.polres');
    Route::post('/tambah/polres', [PolresController::class, 'store'])->name('tambah.polres.process');
    Route::get('/edit/polres/{id}', [PolresController::class, 'editPage'])->name('edit.polres');
    Route::put('/edit/polres/{id}', [PolresController::class, 'update'])->name('edit.polres.process');
    Route::delete('/hapus/polres/{id}', [PolresController::class, 'destroy'])->name('hapus.polres');

    Route::get('/polsek', [PolsekController::class, 'index'])->name('polsek');
    Route::get('/tambah/polsek', [PolsekController::class, 'tambahPage'])->name('tambah.polsek');
    Route::post('/tambah/polsek', [PolsekController::class, 'store'])->name('tambah.polsek.process');
    Route::get('/edit/polsek/{id}', [PolsekController::class, 'editPage'])->name('edit.polsek');
    Route::put('/edit/polsek/{id}', [PolsekController::class, 'update'])->name('edit.polsek.process');
    Route::delete('/hapus/polsek/{id}', [PolsekController::class, 'destroy'])->name('hapus.polsek');




    Route::get('/ubah/password', [SuperAdminController::class, 'resetPage'])->name('ubah.password');
    Route::post('/ubah/password', [SuperAdminController::class, 'resetProcess'])->name('ubah.password.process');
});

Route::middleware(['role:pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
    Route::get('/dashboard', [PimpinanController::class, 'index'])->name('dashboard');
});

Route::middleware([ 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('update.profile');

    Route::post('/ubah/password', [ProfileController::class, 'updatePassword'])->name('ubah.password');


    Route::get('/masyarakat', [MasyarakatController::class, 'index'])->name('masyarakat');
    Route::get('/tambah/masyarakat', [MasyarakatController::class, 'showPage'])->name('tambah.masyarakat');
    Route::post('/tambah/masyarakat', [MasyarakatController::class, 'store'])->name('tambah.masyarakat.process');
    Route::get('/detail/masyarakat/{id}', [MasyarakatController::class, 'detailPage'])->name('detail.masyarakat');
    Route::delete('/hapus/masyarakat/{id}', [MasyarakatController::class, 'destroy'])->name('hapus.masyarakat.process');
    Route::get('/edit/masyarakat/{id}', [MasyarakatController::class, 'showEdit'])->name('edit.masyarakat');
    Route::put('/edit/masyarakat/{id}', [MasyarakatController::class, 'update'])->name('update.masyarakat.process');


});

Route::middleware(['role:admin polda'])->prefix('adminpolda')->name('admin.polda.')->group(function () {
    Route::get('/dashboard', [AdminPoldaController::class, 'index'])->name('dashboard');
});

Route::middleware(['role:admin polres'])->prefix('adminpolres')->name('admin.polres.')->group(function () {
    Route::get('/dashboard', [AdminPolresController::class, 'index'])->name('dashboard');
});

Route::middleware(['role:admin polsek'])->prefix('adminpolsek')->name('admin.polsek.')->group(function () {
    Route::get('/dashboard', [AdminPolsekController::class, 'index'])->name('dashboard');
    // Akun User
    Route::get('/akun-user', [PolsekUserController::class, 'index'])->name('akun.user');
    Route::get('/akun-user/{id}', [PolsekUserController::class, 'detail'])->name('detail.user');

    Route::get('/polsekpenjualan', [PolsekPenjualanController::class, 'index'])->name('polsekpenjualan');
    Route::get('/polsekpenjualan/{id}', [PolsekPenjualanController::class, 'detail'])->name('detailpolsekpenjualan');

    // Tambahkan edit & update
    Route::get('/polsekpenjualan/{id}/edit', [PolsekPenjualanController::class, 'edit'])->name('edit.masyarakat');
    Route::put('/polsekpenjualan/{id}', [PolsekPenjualanController::class, 'update'])->name('update.masyarakat');
});

Route::prefix('api')->middleware('api')->group(function () {
    Route::get('/polsek/search', function (Request $request) {
        $search = $request->input('q');
    
        $polseks = Polsek::with('polres')
            ->where('nama', 'like', "%{$search}%")
            ->orWhereHas('polres', function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->limit(20)
            ->get();
    
        // Ambil polres unik
        $polresList = $polseks
            ->pluck('polres')
            ->unique('id')
            ->map(function ($polres) {
                return [
                    'id' => 'polres|' . $polres->id, // prefix supaya aman
                    'text' => $polres->nama,
                    'type' => 'polres',
                    'polres_id' => $polres->id,
                    'polsek_id' => null
                ];
            })
            ->values();
    
        // Ambil polsek
        $polsekList = $polseks
            ->map(function ($polsek) {
                return [
                    'id' => 'polsek|' . $polsek->id,
                    'text' => $polsek->polres->nama . ' - ' . $polsek->nama,
                    'type' => 'polsek',
                    'polres_id' => $polsek->polres_id,
                    'polsek_id' => $polsek->id
                ];
            })
            ->values();
    
        // Hasil untuk Select2 (dengan grup)
        $result = [
            [
                'text' => 'Polres',
                'children' => $polresList
            ],
            [
                'text' => 'Polsek',
                'children' => $polsekList
            ]
        ];
    
        return response()->json($result);
    })->name('api.polsek.search');
    
});

Route::prefix('api')->middleware('api')->group(function () {
    Route::get('/polsek/search/lagi', function (Request $request) {
        $search = $request->input('q');
    
        $polseks = Polsek::with('polres')
            ->where('nama', 'like', "%{$search}%")
            ->orWhereHas('polres', function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->limit(20)
            ->get();
    
        // Ambil polsek
        $polsekList = $polseks
            ->map(function ($polsek) {
                return [
                    'id' => $polsek->id,
                    'text' => $polsek->polres->nama . ' - ' . $polsek->nama,
                    'type' => 'polsek',
                    'polres_id' => $polsek->polres_id,
                    'polsek_id' => $polsek->id
                ];
            })
            ->values();
    
        // Hasil untuk Select2 (dengan grup)
        $result = [
            [
                'children' => $polsekList
            ]
        ];
    
        return response()->json($result);
    })->name('api.polsek.search.lagi');
    
});
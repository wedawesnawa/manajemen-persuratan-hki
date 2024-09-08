<?php    

use App\Http\Controllers\PengajuanUserController;
use App\Http\Controllers\PengajuanAdminController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use App\Models\Beranda;


// Route untuk halaman utama
Route::get('/', function () {
    return view('home');
});


// Rute untuk Admin
Route::get('/admin/beranda', function () {
    return view('admin/beranda');
})->middleware(['auth', 'verified', 'admin'])->name('admin.beranda');



// Route user
Route::get('/users/beranda', function () {
    return view('users/beranda');
})->middleware(['auth', 'verified', 'users'])->name('users.beranda');

// Rute untuk User
Route::prefix('users')->group(function () {
    Route::get('/hki', [SubmissionController::class, 'hki'])->name('users.hki');
    Route::get('/publikasi', [SubmissionController::class, 'publikasi'])->name('users.publikasi');
    Route::get('/beranda', [SubmissionController::class, 'beranda'])->middleware(['auth', 'verified'])->name('users.beranda');
});

Route::get('/beranda/{brd:slug}', function (Beranda $brd) {
    return view('brd', ['post' => $brd]);
});

// Route::get('/users/beranda', [SubmissionController::class, 'beranda'])->middleware(['auth', 'verified'])->name('users.beranda');
// Route::get('/beranda', function () {
//     $posts = Beranda::all();
//     // dd($posts);
//     return view('users.beranda', ['posts' => $posts]);
// });



// Route::get('/submission', function () {
//     return view('users.submission');
// });

// Route::get('/hki', [SubmissionController::class, 'hki'])->name('hki');
// Route::get('/publikasi', [SubmissionController::class, 'publikasi'])->name('publikasi');

Route::post('/submit-form', [SubmissionController::class, 'submitForm'])->name('submit.form');
Route::post('/submit-form-pub', [SubmissionController::class, 'submitFormPub'])->name('submit.form.pub');

// Route untuk dashboard dengan middleware auth dan verified
// Route::get('/beranda', function () {
//     return view('users.beranda', ['posts' => Beranda::all()]);
    
// })->middleware(['auth', 'verified'])->name('beranda');

// Route::get('/beranda/{brd:slug}', function (Beranda $brd) {
//     return view('brd', ['post' => $brd]);
// });

// Kelompok route dengan middleware auth
Route::middleware('auth')->group(function () {
    // Route untuk mengedit profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile-edit');
    // Route untuk memperbarui profil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile-update');
    // Route untuk menghapus profil
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile-destroy');

    //page profil
    Route::resource('users', ProfilesController::class);

    //  //page submission
    //  Route::post('users/hki', [SubmissionController::class, 'create']);

    // //page submission
    // Route::post('users/publikasi', [SubmissionController::class, 'create']);
});

Route::middleware('auth', 'admin')->group(function (){

    Route::prefix('admin')->group(function () {
        Route::get('/hki', [PengajuanAdminController::class, 'hki'])->name('admin.hki');
        Route::get('/publikasi', [PengajuanAdminController::class, 'publikasi'])->name('admin.publikasi');
        Route::get('/mahasiswa', [InformasiController::class, 'mahasiswa'])->name('admin.mahasiswa');
        Route::get('/dosen', [InformasiController::class, 'dosen'])->name('admin.dosen');
        Route::get('/role', [PengajuanUserController::class, 'role'])->name('admin.role');
        Route::get('/beranda', [BerandaController::class, 'index'])->name('admin.beranda');
        Route::post('/beranda', [BerandaController::class, 'store'])->name('admin.beranda.store');
        Route::get('/edit-beranda/{id}', [BerandaController::class, 'edit'])->name('admin.beranda.edit');
        Route::delete('/edit-beranda/{id}', [BerandaController::class, 'destroy'])->name('admin.beranda.delete');
    });

    Route::get('/hki/{nim_mhs}', [PengajuanAdminController::class, 'detail'])->name('admin.hki.detail');
    Route::get('/publikasi/{nim_mhs}', [PengajuanAdminController::class, 'detailPublikasi'])->name('admin.publikasi.detail');
    
    Route::post('/edit-form', [PengajuanAdminController::class, 'editForm'])->name('edit.form');
    Route::post('/edit-form-pub', [PengajuanAdminController::class, 'editFormPub'])->name('edit.form.pub');

    Route::get('/mahasiswa/{nim_mhs}', [InformasiController::class, 'editMhs'])->name('admin.mahasiswa.detail');
    Route::delete('/mahasiswa/{nim}', [InformasiController::class, 'destroy'])->name('admin.mahasiswa.delete');
    Route::post('/edit-mhs', [InformasiController::class, 'editMahasiswa'])->name('edit.mhs');
    Route::post('/tambah-mhs', [InformasiController::class, 'tambahMhs'])->name('tambah.mhs');

    Route::post('/tambah-dosen', [InformasiController::class, 'tambahDosen'])->name('tambah.dosen');
    Route::get('/dosen/{nip}', [InformasiController::class, 'detailDosen'])->name('admin.dosen.detail');
    Route::delete('/dosen/{nip}', [InformasiController::class, 'destroyDosen'])->name('admin.dosen.delete');
    Route::post('/edit-dosen', [InformasiController::class, 'editDosen'])->name('edit.dosen');

    Route::post('/edit-role', [PengajuanUserController::class, 'editRole'])->name('edit.role');

    Route::post('/update', [BerandaController::class, 'update'])->name('admin.beranda.update');
});

// Mengimpor route otentikasi
require __DIR__.'/auth.php';
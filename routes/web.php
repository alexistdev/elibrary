<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardAdmin as AdmDash,
    KategoriController as AdmKat,
    PengarangController as AdmAuthor,
    BukuController as AdmBook,
    StockController as AdmStock,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['roles' => 'admin'], function () {
        Route::get('/admin/dashboard', [AdmDash::class, 'index'])->name('adm.dashboard');
        /** Master data kategori */
        Route::get('/admin/kategori', [AdmKat::class, 'index'])->name('adm.kategori');
        Route::post('/admin/kategori', [AdmKat::class, 'store'])->name('adm.kategori.add');
        Route::patch('/admin/kategori', [AdmKat::class, 'update'])->name('adm.kategori.edit');
        Route::delete('/admin/kategori', [AdmKat::class, 'destroy'])->name('adm.kategori.delete');
        /** Master data pengarang */
        Route::get('/admin/author', [AdmAuthor::class, 'index'])->name('adm.author');
        Route::post('/admin/author', [AdmAuthor::class, 'store'])->name('adm.author.add');
        Route::patch('/admin/author', [AdmAuthor::class, 'update'])->name('adm.author.edit');
        Route::delete('/admin/author', [AdmAuthor::class, 'destroy'])->name('adm.author.delete');
        /** Master data buku */
        Route::get('/admin/books', [AdmBook::class, 'index'])->name('adm.book');
        Route::post('/admin/books', [AdmBook::class, 'store'])->name('adm.book.add');
        Route::patch('/admin/books', [AdmBook::class, 'update'])->name('adm.book.edit');
        Route::delete('/admin/books', [AdmBook::class, 'destroy'])->name('adm.book.delete');
        /** Master data Stock */
        Route::get('/admin/stock', [AdmStock::class, 'index'])->name('adm.stock');

        /** Ajax */
        Route::get('/admin/ajax/get_buku_bykategori', [AdmStock::class, 'ajax_getBuku_byKategori'])->name('admin.ajax.get-buku-bykategori');

    });
});

require __DIR__.'/auth.php';

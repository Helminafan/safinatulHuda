<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VidioController;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

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

function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}


Route::get('/welcome', function () {
    return view('welcome');
});



Route::get('/', [UserController::class, 'dashboard'])->name('dashboard.user');
Route::get('/portoVidio', [UserController::class, 'portoVidio'])->name('portoVidio.user');
Route::get('/event', [UserController::class, 'event'])->name('event.user');
Route::get('/event/blog/{id}', [UserController::class, 'blog'])->name('blog.user');
Route::get('/prestasi', [UserController::class, 'prestasi'])->name('user.prestasi');
Route::get('/pendafataran', [PendaftaranController::class, 'create'])->name('user.pendaftaran');
Route::post('/store/pendaftaran', [PendaftaranController::class, 'store'])->name('store.pendaftaran');
Route::get('/produk', [UserController::class, 'produk'])->name('produk.user');
Route::get('/produk/detail/{id}', [UserController::class, 'detailproduk'])->name('produk.detail');
Route::post('/produk/komentar/{id}', [UserController::class, 'create_komentar'])->name('produk.komentar');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
});

Route::group(['prefix' => 'prestasi', 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {
    Route::get('/view', [PrestasiController::class, 'index'])->name('prestasi_admin');
    Route::get('/add', [PrestasiController::class, 'create'])->name('add.prestasi_admin');
    Route::post('/store', [PrestasiController::class, 'store'])->name('store.prestasi_admin');
    Route::get('/edit/{id}', [PrestasiController::class, 'edit'])->name('edit.prestasi_admin');
    Route::post('/update/{id}', [PrestasiController::class, 'update'])->name('update.prestasi_admin');
    Route::get('/delete/{id}', [PrestasiController::class, 'destroy'])->name('delete.prestasi_admin');
});
Route::group(['prefix' => 'vidio', 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {
    Route::get('/view', [VidioController::class, 'index'])->name('vidio_admin');
    Route::get('/add', [VidioController::class, 'create'])->name('add.vidio_admin');
    Route::post('/store', [VidioController::class, 'store'])->name('store.vidio_admin');
    Route::get('/edit/{id}', [VidioController::class, 'edit'])->name('edit.vidio_admin');
    Route::post('/update/{id}', [VidioController::class, 'update'])->name('update.vidio_admin');
    Route::get('/delete/{id}', [VidioController::class, 'destroy'])->name('delete.vidio_admin');
});
Route::group(['prefix' => 'pengumuman', 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {
    Route::get('/view', [PengumumanController::class, 'index'])->name('pengumuman');
    Route::get('/add', [PengumumanController::class, 'create'])->name('add.pengumuman');
    Route::post('/store', [PengumumanController::class, 'store'])->name('store.pengumuman');
    Route::get('/edit/{id}', [PengumumanController::class, 'edit'])->name('edit.pengumuman');
    Route::post('/update/{id}', [PengumumanController::class, 'update'])->name('update.pengumuman');
    Route::get('/delete/{id}', [PengumumanController::class, 'destroy'])->name('delete.pengumuman');
});
Route::group(['prefix' => 'event', 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {
    Route::get('/view', [EventController::class, 'index'])->name('event_admin');
    Route::get('/add', [EventController::class, 'create'])->name('add.event_admin');
    Route::post('/store', [EventController::class, 'store'])->name('store.event_admin');
    Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit.event_admin');
    Route::post('/update/{id}', [EventController::class, 'update'])->name('update.event_admin');
    Route::get('/delete/{id}', [EventController::class, 'destroy'])->name('delete.event_admin');
});
Route::group(['prefix' => 'pendaftaran', 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {
    Route::get('/view', [PendaftaranController::class, 'index'])->name('view_pendaftaran');
    Route::get('/download', [PendaftaranController::class, 'export'])->name('download');
    Route::get('/detail/{id}', [PendaftaranController::class, 'show'])->name('show_pendaftaran');
    Route::get('/reset', [PendaftaranController::class, 'reset'])->name('reset');
    Route::get('/delete/{id}', [PendaftaranController::class, 'destroy'])->name('delete.pendaftaran');
});
Route::group(['prefix' => 'produk', 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {
    Route::get('/view', [\App\Http\Controllers\ProdukController::class, 'index'])->name('produk.index');
    Route::get('/add', [\App\Http\Controllers\ProdukController::class, 'create'])->name('produk.create');
    Route::post('/store', [\App\Http\Controllers\ProdukController::class, 'store'])->name('produk.store');
    Route::get('/edit/{id}', [\App\Http\Controllers\ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/update/{id}', [\App\Http\Controllers\ProdukController::class, 'update'])->name('produk.update');
    Route::get('/delete/{id}', [\App\Http\Controllers\ProdukController::class, 'destroy'])->name('produk.delete');
    Route::delete('/gambar/{id}', [\App\Http\Controllers\ProdukController::class, 'destroyImage'])->name('produk.gambar.delete');
    Route::get('/diskon/{id}', [\App\Http\Controllers\ProdukController::class, 'diskon'])->name('produk.diskon');
    Route::post('/diskon/store/{id}', [\App\Http\Controllers\ProdukController::class, 'storeDiskon'])->name('produk.diskon.store');
});
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout')->middleware('auth');

<?php

use App\Http\Controllers\akunController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\hargaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\jenisController;
use App\Http\Controllers\memberController;
use App\Http\Controllers\metodeProduksiController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\paymentRequestController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\platformController;
use App\Http\Controllers\produkController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\rolePermissionController;
use App\Http\Controllers\templateChatController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\tokoController;
use App\Http\Controllers\transactionController;
use App\Http\Controllers\varianController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WaAdminController;
use App\Http\Controllers\XenditController;
use App\Http\Controllers\UserCountController;
use App\Http\Controllers\VideoTutorialController;
use App\Http\Controllers\TrendingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    // Member
    Route::get('/Member', [memberController::class, 'index']);
    Route::get('/Profile', [memberController::class, 'profile']);
    Route::get('/Member/Bio/Update', [memberController::class, 'bio']);
    Route::post('/Member/Update', [memberController::class, 'update']);
    Route::get('/Member/Account/Update', [memberController::class, 'account']);
    Route::post('/Member/Store', [memberController::class, 'store']);
    Route::post('Member/fetchUserRole', [memberController::class, 'fetchUserRole']);
    Route::post('/Member/Delete', [memberController::class, 'destroy']);

    //Promo
    Route::get('/Promo', [PromoController::class, 'index'])->name('promos.index');
    Route::get('/Promo/create', [PromoController::class, 'create'])->name('promos.create');
    Route::post('/Promo', [PromoController::class, 'store'])->name('promos.store');
    Route::get('/Promo/{id}/edit', [PromoController::class, 'edit'])->name('promos.edit');
    Route::put('/Promo/{id}', [PromoController::class, 'update'])->name('promos.update');
    Route::delete('/Promo/{id}', [PromoController::class, 'destroy'])->name('promos.destroy');

    //Testimonial
    Route::get('Testimonial', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::get('Testimonial/create', [TestimonialController::class, 'create'])->name('testimonial.create');
    Route::post('Testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::get('/Testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonial.edit');
    Route::put('/Testimonial/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
    Route::delete('/Testimonial/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');

    // Routes for Trending CRUD
    Route::get('Trending', [TrendingController::class, 'index'])->name('trendings.index');
    Route::get('Trending/create', [TrendingController::class, 'create'])->name('trendings.create');
    Route::post('Trending', [TrendingController::class, 'store'])->name('trendings.store');
    Route::get('Trending/{id}/edit', [TrendingController::class, 'edit'])->name('trendings.edit');
    Route::put('Trending/{id}', [TrendingController::class, 'update'])->name('trendings.update');
    Route::delete('Trending/{id}', [TrendingController::class, 'destroy'])->name('trendings.destroy');


    //Customer
    Route::resource('customers', CustomerController::class);

    //Voucher
    Route::resource('vouchers', VoucherController::class);

    // Role Management
    Route::get('/AccessManagement', [rolePermissionController::class, 'index']);
    Route::post('AccessManagement/fetchPermission', [rolePermissionController::class, 'fetchPermission']);
    Route::post('/AccessManagement/Role/Store', [rolePermissionController::class, 'store']);
    Route::post('/AccessManagement/Permission/Store', [rolePermissionController::class, 'storePermission']);
    Route::post('/AccessManagement/Update', [rolePermissionController::class, 'update']);


    // Produk
    Route::get('/MasterData/Produk', [produkController::class, 'index'])->name('produk.index');
    Route::get('/Produk/fetch/form', [produkController::class, 'create']);
    Route::get('/Produk/Get/Filter', [produkController::class, 'getFilter']);
    Route::get('/produk/create', [produkController::class, 'create'])->name('produk.create');
    Route::get('/produk/edit/{id}', [produkController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/store', [produkController::class, 'store'])->name('produk.store');
    Route::put('/produk/update/{id}', [produkController::class, 'update'])->name('produk.update');
    Route::delete('/produk/delete/{id}', [produkController::class, 'destroy'])->name('produk.destroy');
    Route::post('/Produk/Filter', [produkController::class, 'FetchFilter']);

    // Varian
    Route::post('/Varian/Produk/Store', [varianController::class, 'store']);
    Route::post('/Varian/Produk/Update', [varianController::class, 'update']);
    Route::post('/Varian/Produk/Delete', [varianController::class, 'destroy']);

    // Jenis
    Route::post('/Jenis/Produk/Store', [jenisController::class, 'store']);
    Route::post('/Jenis/Produk/Update', [jenisController::class, 'update']);
    Route::post('/Jenis/Produk/Delete', [jenisController::class, 'destroy']);

    // Sumber Transaksi
    Route::get('/MasterData/SumberTransaksi', [tokoController::class, 'index']);
    Route::get('/Toko/fetch/form', [tokoController::class, 'create']);
    Route::post('/Toko/Store', [tokoController::class, 'store']);
    Route::post('/Toko/Update', [tokoController::class, 'update']);
    Route::post('/Toko/Delete', [tokoController::class, 'destroy']);

    // Platform
    Route::post('/Platform/Sumber/Store', [platformController::class, 'store']);
    Route::post('/Platform/Sumber/Update', [platformController::class, 'update']);
    Route::post('/Platform/Sumber/Delete', [platformController::class, 'destroy']);

    // Harga
    Route::get('/MasterData/Harga', [hargaController::class, 'index']);
    Route::get('/Harga/fetch/form', [hargaController::class, 'create']);
    Route::get('/Harga/Get/Filter', [hargaController::class, 'getFilter']);
    Route::post('/Harga/Filter', [hargaController::class, 'FetchFilter']);
    Route::post('/Harga/Store', [hargaController::class, 'store']);
    Route::post('/Harga/Update', [hargaController::class, 'update']);
    Route::post('/Harga/Delete', [hargaController::class, 'destroy']);

    // Template Chat
    Route::get('/MasterData/Template/PemberianAkun', [templateChatController::class, 'index']);
    Route::get('/Template/fetch/form', [templateChatController::class, 'create']);
    Route::post('/Template/Store', [templateChatController::class, 'store']);
    Route::post('/Template/Update', [templateChatController::class, 'update']);
    Route::post('/Template/Delete', [templateChatController::class, 'destroy']);

    // Akun
    // Netflix
    Route::get('/Akun/Index', [akunController::class, 'index']);
    Route::get('/Akun/Netflix/Create', [akunController::class, 'create']);
    Route::get('/Akun/Netflix/fetch/form', [akunController::class, 'fetchFormUpdate']);
    Route::post('/Akun/Netflix/Store', [akunController::class, 'store']);
    Route::post('/Akun/Netflix/Update', [akunController::class, 'update']);
    Route::post('/Akun/Netflix/Delete', [akunController::class, 'destroy']);

    // Metode
    Route::post('/Metode/Produksi/Store', [metodeProduksiController::class, 'store']);
    Route::post('/Metode/Produksi/Update', [metodeProduksiController::class, 'update']);
    Route::post('/Metode/Produksi/Delete', [metodeProduksiController::class, 'destroy']);

    // Transaksi
    Route::get('/Transaksi/Today', [transactionController::class, 'index']);
    Route::get('/Transaksi/fetch/form', [transactionController::class, 'create']);
    Route::get('/Transaksi/fetch/form/update', [transactionController::class, 'edit']);
    Route::get('/Transaksi/fetch/sumber', [transactionController::class, 'fetchSumber']);
    Route::get('/Transaksi/fetch/produk', [transactionController::class, 'fetchProduk']);
    Route::get('/Transaksi/fetch/lastTransaction', [transactionController::class, 'fetchLastTransaction']);
    Route::post('/Transaksi/Today/updateStatus', [transactionController::class, 'updateStatus']);
    Route::post('/Transaksi/Store', [transactionController::class, 'store']);
    Route::post('/Transaksi/Update', [transactionController::class, 'update']);
    Route::get('/Transaksi/pending', [TransactionController::class, 'indexTransactionPending'])->name('transactions.pending.index');
    Route::put('/transactions/{id}/pending', [TransactionController::class, 'updateTransactionPending'])->name('transactions.pending.update');
    Route::get('/transactions/history', [TransactionController::class, 'indexHistory']);

    // Payment Method
    Route::post('/Payment/Store', [paymentController::class, 'store']);
    Route::post('/Payment/Update', [paymentController::class, 'update']);
    Route::post('/Payment/Delete', [paymentController::class, 'destroy']);

    // Provide Akun
    Route::get('/Transaksi/Provide/Akun', [transactionController::class, 'fetchAkun']);
    Route::get('/Transaksi/Provide/Akun/Detail', [transactionController::class, 'fetchDetailAkun']);
    Route::post('/Transaksi/Provide/Akun/Store', [transactionController::class, 'provideAkun']);

    //list payments
    Route::resource('payments', PaymentsController::class);

    //list wa admin
    Route::resource('wa_admin', WaAdminController::class);

    //user count
    Route::get('user_counts', [UserCountController::class, 'index'])->name('user_counts.index');
    Route::get('user_counts/increment', [UserCountController::class, 'incrementCount'])->name('user_counts.increment');

    //testimonial
    Route::post('/testimonial/{id}/publish', [TestimonialController::class, 'publish'])->name('testimonial.publish');

    //video tutorial
    Route::resource('video_tutorials', VideoTutorialController::class);

    //banner
    Route::resource('banners', BannerController::class);
});

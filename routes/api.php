<?php

use App\Http\Controllers\API\BannerAPI;
use App\Http\Controllers\API\CustomersAPI;
use App\Http\Controllers\API\get_products_by_shop;
use App\Http\Controllers\API\getProduct;
use App\Http\Controllers\API\PromoAPI;
use App\Http\Controllers\API\TrendingAPI;
use App\Http\Controllers\API\TestimonialAPI;
use App\Http\Controllers\API\VoucherAPI;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\PaymentMethod;
use App\Http\Controllers\API\PaymentMidtransController;
use App\Http\Controllers\API\TransactionReminderController;
use App\Http\Controllers\API\VideoTutorialAPI;
use App\Http\Controllers\API\WaAdminAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_detail_products', [getProduct::class, 'index']);
Route::get('/variances', [getProduct::class, 'getVariances']);
Route::get('/get_detail_products/{id}', [getProduct::class, 'show']);
Route::get('/get_detail_products/variance/{variance}', [getProduct::class, 'varianceDetail']);

Route::get('/promo', [PromoAPI::class, 'index']);

Route::get('/trending', [TrendingAPI::class, 'index']);

Route::get('/vouchers', [VoucherAPI::class, 'index']);

Route::get('/testimonial', [TestimonialAPI::class, 'index']);
Route::post('/testimonial/add', [TestimonialAPI::class, 'store']);

Route::apiResource('customers', CustomersAPI::class);
Route::post('customers/login', [CustomersAPI::class, 'login']);

Route::get('/profile', [CustomersAPI::class, 'profile']);

// Route::post('/create-invoice', [PaymentController::class, 'createInvoice']);
Route::post('/create-invoice', [PaymentController::class, 'createInvoiceManual']);
Route::post('/pay', [PaymentController::class, 'createEWalletInvoice']);
Route::get('/get-invoice/{invoiceId}', [PaymentController::class, 'getInvoice']);
// Route::post('/confirm-payment', [PaymentController::class, 'handleXenditCallback']);
Route::post('/confirm-payment', [PaymentController::class, 'handleXenditCallbackManual']);
Route::post('/check-payment-status', [PaymentController::class, 'checkPaymentStatus']);
Route::get('/transactions/history/{id}', [PaymentController::class, 'historyTransaction']); 

Route::get('/reminders/expiring', [TransactionReminderController::class, 'getExpiringTransactions']);

Route::get('/list-waadmin', [WaAdminAPI::class, 'index']);
Route::get('/list-payments', [PaymentMethod::class, 'index']);
Route::get('/video-tutorial', [VideoTutorialAPI::class, 'index']);
Route::get('/banner', [BannerAPI::class, 'index']);

Route::post('/payment/create', [PaymentMidtransController::class, 'createPayment']);  
Route::post('/payment/callback', [PaymentMidtransController::class, 'handleCallback']);  

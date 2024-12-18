<?php

use App\Http\Controllers\API\CustomersAPI;
use App\Http\Controllers\API\get_products_by_shop;
use App\Http\Controllers\API\getProduct;
use App\Http\Controllers\API\PromoAPI;
use App\Http\Controllers\API\TestimonialAPI;
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

Route::get('/get_detail_products', [getProduct::class,'index']);
Route::get('/get_detail_products/{id}', [getProduct::class,'show']);

Route::get('/promo', [PromoAPI::class,'index']);

Route::get('/testimonial', [TestimonialAPI::class, 'index']);
Route::post('/testimonial/add', [TestimonialAPI::class, 'store']);

Route::apiResource('customers', CustomersAPI::class);
Route::post('customers/login', [CustomersAPI::class, 'login']);
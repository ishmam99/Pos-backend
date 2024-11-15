<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
    Route::group(['middleware'=>'auth:sanctum'] ,function () {
        Route::get('products',[ProductController::class,'index']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('checkout', [ProductController::class, 'checkout']);
            Route::get('date-wise-sales-report', [ReportController::class, 'dateWiseSalesReport']);
            Route::get('product-wise-sales-report', [ReportController::class, 'productWiseSalesReport']);
            Route::get('product-stock-report', [ReportController::class, 'productWiseStockReport']);
    });
}
)
;

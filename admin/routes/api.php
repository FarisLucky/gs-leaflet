<?php

use App\Http\Controllers\Api\LeafletController;
use App\Http\Controllers\Api\MUnitController;
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
Route::name('api.')->group(function () {
    Route::prefix('/leaflet')->name('leaflet.')->group(function () {
        Route::get('', [LeafletController::class, 'index'])->name('index');
        Route::get('/data-file/{idLeaflet}', [LeafletController::class, 'dataFile'])->name('data_file');
        Route::put('/update-order/{id}', [LeafletController::class, 'updateOrder'])->name('update_order');
        Route::delete('/destroy-order/{id}', [LeafletController::class, 'destroyOrder'])->name('destroy_order');
        Route::delete('/destroy/{id}', [LeafletController::class, 'destroy'])->name('destroy');
        Route::get('/show-pdf/{id}', function () {
            return response()->file(public_path('surat.pdf'));
        });
    });

});
Route::resource('m-unit', MUnitController::class)->names('api.m_unit');


include __DIR__ . '/frontend.php';

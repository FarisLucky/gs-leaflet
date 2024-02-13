<?php

use App\Http\Controllers\LeafletController;
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

Route::get('/', function () {
    return view('layouts.home');
})->name('home');

Route::resource('leaflet', LeafletController::class)->except('edit')->names('leaflets');
Route::post('/leaflet/upload-file/{id?}', [LeafletController::class, 'uploadFile'])->name('leaflet.upload_file');
Route::get('/leaflet/file/{name}', [LeafletController::class, 'getFile'])->name('leaflet.file.data');
Route::get('/leaflet/showFile/{leaflet_id}', [LeafletController::class, 'showFile'])->name('leaflet.showFile');
Route::get('/leaflet/download/{leaflet_id}', [\App\Http\Controllers\Frontend\LeafletController::class, 'download']);

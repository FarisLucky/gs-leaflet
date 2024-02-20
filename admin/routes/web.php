<?php

use App\Http\Controllers\LeafletController;
use App\Http\Controllers\MUnitController;
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

Auth::routes(["register" => false]);


Route::middleware(["auth"])->group(function () {
    Route::get("/", [App\Http\Controllers\HomeController::class, "index"])->name("home");

    Route::resource("leaflet", LeafletController::class)->except("edit")->names("leaflets");
    Route::post("/leaflet/upload-file/{id?}", [LeafletController::class, "uploadFile"])->name("leaflet.upload_file");
    Route::get("/leaflet/file/{name}", [LeafletController::class, "getFile"])->name("leaflet.file.data");
    Route::get("/leaflet/showFile/{leaflet_id?}", [LeafletController::class, "showFile"])->name("leaflet.showFile");
    Route::get("/leaflet/download/{leaflet_id}", [\App\Http\Controllers\Frontend\LeafletController::class, "download"]);
    Route::resource("/m-unit", MUnitController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy'])
        ->names("m_unit");
});

Route::get("/leaflet/pdf-file/{id?}", [LeafletController::class, "pdfFile"])->name("pdf_file");
Route::get("/leaflet/view-cover/{id?}", [LeafletController::class, "viewCover"])->name("view_cover");
Route::get("/leaflet/view-leaflet/{id?}", [LeafletController::class, "viewLeaflet"])->name("view_leaflet");

Route::get("/optimize", function () {
    return \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get("/link", function () {
    return \Illuminate\Support\Facades\Artisan::call('storage:link');
});

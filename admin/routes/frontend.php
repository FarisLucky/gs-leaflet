<?php
use App\Http\Controllers\Frontend\LeafletController;

Route::prefix("fr-leaflet")->name("fr.leaflet")->group(function () {
    Route::get("/list", [LeafletController::class, "index"])->name("index");
    Route::get("/show/{id}", [LeafletController::class, "show"])->name("show");
    Route::get("/show-leaflet/{id}", [LeafletController::class, "showLeaflet"])->name("show_leaflet");
    Route::get("/show-leaflet-by-unit/{unit}", [LeafletController::class, "showLeafletByUnit"])->name("show_leaflet_by_unit");
    Route::get("/search/{name}", [LeafletController::class, "search"])->name("search");
    Route::get("/units", [LeafletController::class, "units"])->name("units");
});

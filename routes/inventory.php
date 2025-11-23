<?php

use App\Http\Controllers\Inventory\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('inventory/warehouses', [WarehouseController::class, 'show'])
        ->name('inventory.warehouses.show');
    Route::get('inventory/{placeId?}/warehouses', [WarehouseController::class, 'show'])
        ->name('inventory.warehouses.showWithPlaceId');
});

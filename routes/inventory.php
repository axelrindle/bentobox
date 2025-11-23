<?php

use App\Http\Controllers\Inventory\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('inventory/warehouses', [WarehouseController::class, 'showOverview'])
        ->name('inventory.warehouses.showOverview');

    Route::get('inventory/{place?}/warehouses', [WarehouseController::class, 'showOverview'])
        ->name('inventory.warehouses.showOverviewWithPlaceId');

    Route::get('inventory/{place}/warehouses/{warehouse}', [WarehouseController::class, 'showSingleWarehouse'])
        ->name('inventory.warehouses.showSingleWarehouse');
});

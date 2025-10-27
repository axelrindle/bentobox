<?php

use App\Http\Controllers\Settings\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::redirect('inventory', '/inventory/warehouses');

    Route::get('inventory/warehouses', [WarehouseController::class, 'show'])->name('warehouses.show');
});

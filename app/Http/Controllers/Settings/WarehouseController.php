<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WarehouseController extends Controller
{
    /**
     * Show the inventory warehouses page.
     */
    public function show(Request $request): Response
    {
        return Inertia::render('inventory/Warehouses');
    }
}

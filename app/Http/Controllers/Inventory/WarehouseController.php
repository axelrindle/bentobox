<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WarehouseController extends Controller
{
    /**
     * Show the inventory warehouses page.
     */
    public function show(Request $request, ?string $placeId = null): Response
    {
        $places = Place::all();
        $currentPlace = null;
        $warehouses = [];

        // if placeId is provided, we can load the place details here else load the first place that can be found as default
        if ($placeId) {
            $currentPlace = Place::find($placeId);
        } else {
            $currentPlace = $places->first();
        }

        $warehouses = $currentPlace ? Place::find($currentPlace->id)->warehouses : [];

        return Inertia::render('inventory/Warehouses', [
            'places' => $places,
            'currentPlace' => $currentPlace,
            'warehouses' => $warehouses,
        ]);
    }
}

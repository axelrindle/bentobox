<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Warehouse;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WarehouseController extends Controller
{
    /**
     * Show the inventory warehouses page.
     */
    public function showOverview(Request $request, ?string $placeId = null): Response
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

        return Inertia::render('inventory/WarehouseOverview', [
            'places' => $places,
            'currentPlace' => $currentPlace,
            'warehouses' => $warehouses,
        ]);
    }

    public function showSingleWarehouse(Request $request, ?Place $place = null, ?Warehouse $warehouse = null): Response
    {
        if (!$place || !$warehouse) {
            abort(404, 'Place or Warehouse not found');
        }

        if ($warehouse->place_id !== $place->id) {
            abort(404, 'Warehouse does not belong to the specified Place');
        }

        $items = Item::query()
            ->where('warehouse_id', $warehouse->id)
            ->get();

        return Inertia::render('inventory/WarehouseDetails', [
            'currentPlace' => $place,
            'currentWarehouse' => $warehouse,
            'items' => $items,
        ]);
    }
}

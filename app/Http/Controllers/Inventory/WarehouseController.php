<?php

namespace App\Http\Controllers\Inventory;

use App\Data\ItemResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Models\Item;
use App\Models\Place;
use App\Models\Warehouse;
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

    public function showSingleWarehouse(PaginationRequest $request, ?Place $place = null, ?Warehouse $warehouse = null): Response
    {
        if (! $place || ! $warehouse) {
            abort(404, 'Place or Warehouse not found');
        }

        if ($warehouse->place_id !== $place->id) {
            abort(404, 'Warehouse does not belong to the specified Place');
        }

        $request->validated();

        $items = Item::query()
            ->where('warehouse_id', $warehouse->id)
            ->paginate(
                perPage: $request->query('per_page', 15),
                page: $request->query('page', 1)
            );

        return Inertia::render('inventory/WarehouseDetails', [
            'currentPlace' => $place->toData(),
            'currentWarehouse' => $warehouse->toData(),
            'items' => ItemResource::collect($items),
        ]);
    }
}

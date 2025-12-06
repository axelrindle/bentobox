<?php

namespace App\Http\Controllers;

use App\Http\Requests\Import\ImportExcelSheetRequest;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    // TODO: Specify excel schema
    public function importExcelSheet(ImportExcelSheetRequest $request)
    {
        $file = $request->file('sheet');
        if (! ($file instanceof UploadedFile)) {
            abort(400, 'please upload exactly one file at once');
        }

        $localPath = $file->store('import/sheet', [
            'disk' => 'local',
        ]);

        $disk = Storage::disk('local');

        try {
            $spreadsheet = IOFactory::load($disk->path($localPath));
            $sheet = $spreadsheet->getActiveSheet();
            $table = $sheet->getTableByName('Inventory');
            if ($table == null) {
                return response()->json(['error' => 'no formatted table named "Inventory" found'], status: 400);
            }

            $data = $sheet->rangeToArray($table->getRange());

            if (count($data) < 2) {
                return response()->json(['error' => 'spreadsheet has no data'], status: 400);
            }

            $headers = $data[0];

            $warehouseId = $request->input('warehouse_id');

            DB::beginTransaction();

            $mapped = collect($data)->slice(1)->map(function (array $values) use ($headers) {
                return collect($values)->mapWithKeys(fn (string $value, int $key) => [$headers[$key] => $value])->toArray();
            })->values()->map(function (array $values) use ($warehouseId) {
                $item = new Item;
                $item->name = $values['Name'];
                $item->amount = $values['Anzahl'];
                $item->is_consumable = true;
                $item->is_lendable = true;
                $item->warehouse_id = $warehouseId;
                $item->tags = ['imported'];
                $item->save();

                return $item;
            });

            DB::commit();

            return response()->json($mapped);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['error' => $th->getMessage()], status: 500);
        } finally {
            Storage::delete($localPath);
        }

        return response()->noContent();
    }
}

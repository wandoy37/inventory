<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;

class ItemUnitTypeController extends Controller
{
        // Mengembalikan array [{ value, label }] untuk Choices
        public function optionsByItem(Item $item)
        {
                // sesuaikan kolom: mis. 'name'/'unit_name'
                $units = $item->units()
                        ->select('id', 'name') // ganti 'name' sesuai kolom satuan kamu
                        ->orderBy('name')
                        ->get()
                        ->map(fn($u) => [
                                'value' => $u->id,
                                'label' => $u->name,
                        ]);

                return response()->json($units);
        }
}

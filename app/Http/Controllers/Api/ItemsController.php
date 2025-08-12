<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemsController extends Controller
{
        public function items(Request $request)
        {
                $q = trim($request->q ?? '');
                $perPage = min((int)($request->per_page ?? 20), 50); // hard cap

                if (mb_strlen($q) < 2) {
                        return response()->json([]);
                }

                $items = Item::query()
                        ->where(function ($query) use ($q) {
                                $query->where('name', 'like', "%{$q}%")
                                        ->orWhere('code', 'like', "%{$q}%");
                        })
                        ->orderBy('name')
                        ->limit($perPage)
                        ->get(['id', 'name', 'code']); // tambahkan 'code' jika mau ditampilkan

                $choices = $items->map(fn($v) => [
                        'value' => $v->id,
                        'label' => "{$v->code} - {$v->name}", // bisa gabungkan code & name
                ]);

                return response()->json($choices);
        }
}

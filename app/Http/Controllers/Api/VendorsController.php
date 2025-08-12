<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorsController extends Controller
{
        public function vendors(Request $request)
        {
                $q = trim($request->q ?? '');
                $perPage = min((int)($request->per_page ?? 20), 50); // hard cap

                if (mb_strlen($q) < 2) {
                        return response()->json([]);
                }

                $vendors = Vendor::query()
                        ->where('name', 'like', "%{$q}%")
                        ->orderBy('name')
                        ->limit($perPage)
                        ->get(['id', 'name']);

                $choices = $vendors->map(fn($v) => [
                        'value' => $v->id,
                        'label' => $v->name,
                ]);

                return response()->json($choices);
        }
}

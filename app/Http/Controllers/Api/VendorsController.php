<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorsController extends Controller
{
        public function vendors(Request $request)
        {
                // ===== Mode by ID (prefill) =====
                if ($request->filled('id')) {
                        // dukung single id
                        $id = $request->id;

                        // cari vendor
                        $vendor = Vendor::query()->select(['id', 'name'])->find($id);

                        if (!$vendor) {
                                // boleh balas null atau 404 — di sini pakai null supaya JS gampang handle
                                return response()->json(null);
                        }

                        // konsisten dengan format Choices: { value, label }
                        return response()->json([
                                'value' => $vendor->id,
                                'label' => $vendor->name,
                        ]);
                }


                // ===== Mode search (list) =====
                $q = trim((string) $request->q);
                $perPage = (int) ($request->per_page ?? 20);
                $perPage = max(1, min($perPage, 50)); // hard cap 50

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

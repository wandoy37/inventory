<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RekeningVendor;

class RekeningVendorController extends Controller
{
        // Mengembalikan array [{ value, label }] untuk Choices
        public function optionsByRekening(int $vendorId)
        {
                $rekenings = RekeningVendor::where('vendor_id', $vendorId)
                        ->select('id', 'vendor_id', 'bank_name', 'rekening_number')
                        ->orderBy('bank_name')
                        ->get()
                        ->map(fn($u) => [
                                'value' => $u->id,
                                'label' => $u->bank_name . ' - ' . $u->rekening_number . ' a.n. ' . $u->vendor->name,
                        ]);

                return response()->json($rekenings);
        }
}

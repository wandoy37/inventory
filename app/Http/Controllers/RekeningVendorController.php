<?php

namespace App\Http\Controllers;

use App\Models\RekeningVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RekeningVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'bank_name' => 'required',
            'rekening_number' => 'required',
        ])->validate('errors', 'Periksa kembali form rekening vendor.!');

        RekeningVendor::create([
            'vendor_id' => $request->vendor_id,
            'bank_name' => $request->bank_name,
            'rekening_number' => $request->rekening_number
        ]);

        return redirect()->back()->with('success', 'Rekening vendor berhasil di tambahkan.!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rekeningVendor = RekeningVendor::findOrFail($id);
        $rekeningVendor->delete();
        return redirect()->back()->with('success', 'Rekening vendor berhasil di hapus.!');
    }
}

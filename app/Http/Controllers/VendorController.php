<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(
                Vendor::orderBy('created_at', 'desc')
            )
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '<a href="' . route('daftar-vendor.edit', $item->id) . '" class="btn btn-outline-primary btn-md">
                    <i class="bi bi-pen"></i>
                </a>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable' => false, 'searchable' => false],
            ['data' => 'name'],
            ['data' => 'address'],
            ['data' => 'email'],
            ['data' => 'phone'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]);

        return view('vendor.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data utama
        $validated = $request->validate([
            'name' => ['required', 'string', 'unique:vendors'],
            'address' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'numeric'],
        ]);

        // Simpan Data
        Vendor::create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);


        return redirect()
            ->route('daftar-vendor.index')
            ->with('success', 'Vendor baru berhasil tambahkan');
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
        $vendor = Vendor::findOrFail($id);
        return view('vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari data vendor
        $vendor = Vendor::findOrFail($id);

        // Validasi data
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('vendors')->ignore($vendor->id),
            ],
            'address' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'numeric'],
        ]);

        // Update data
        $vendor->update([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()
            ->route('daftar-vendor.index')
            ->with('success', 'Vendor berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

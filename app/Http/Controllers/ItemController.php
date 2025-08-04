<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Resources\ItemResource;
use App\Models\ItemUnitType;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        return view('item.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            // Tambahkan created_at jika ingin digunakan
            $items = Item::select(['id', 'code', 'name', 'description', 'created_at'])->orderBy('created_at', 'desc');

            return DataTables::of($items)
                ->addIndexColumn() // Untuk kolom NO auto increment
                ->addColumn('action', function ($item) {
                    return '<a href="' . route('daftar.barang.edit', $item->id) . '" class="btn btn-primary btn-md"><i class="bi bi-eye"></i></a>';
                    // <button class="btn btn-danger btn-sm" onclick="deleteItem(' . $item->id . ')">Delete</button> tambahkan jika dibutuhkan di dalam  petik satu''
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        // Validasi data utama
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'satuan' => ['nullable', 'array'],
            'satuan.*.name' => ['required_with:satuan.*.quantity', 'string', 'max:100'],
            'satuan.*.quantity' => ['nullable', 'numeric', 'min:0'],
            'satuan.*.price_buy' => ['nullable', 'string'],
            'satuan.*.price_sell' => ['nullable', 'string'],
        ]);

        // Simpan Item
        $item = Item::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Jika ada satuan
        if (!empty($validated['satuan'])) {
            foreach ($validated['satuan'] as $satuan) {
                if (!empty($satuan['name'])) {
                    ItemUnitType::create([
                        'item_id' => $item->id,
                        'name' => $satuan['name'],
                        'quantity' => $satuan['quantity'] ?? 0,
                        'price_buy' => clean_rupiah($satuan['price_buy'] ?? 0),
                        'price_sell' => clean_rupiah($satuan['price_sell'] ?? 0),
                    ]);
                }
            }
        }

        return redirect()
            ->route('daftar.barang.index')
            ->with('success', 'Barang berhasil disimpan');
    }

    public function edit($id)
    {
        $item = Item::with('units')->findOrFail($id);
        return view('item.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->save();

        if ($request->has('satuan')) {
            foreach ($request->satuan as $data) {
                // jika ada id, update
                if (!empty($data['id'])) {
                    $unit = ItemUnitType::find($data['id']);
                    if ($unit) {
                        $unit->name = $data['name'];
                        $unit->quantity = $data['quantity'];
                        $unit->price_buy = str_replace('.', '', $data['price_buy']);
                        $unit->price_sell = str_replace('.', '', $data['price_sell']);
                        $unit->save();
                    }
                } else {
                    // jika tidak ada id -> buat baru
                    ItemUnitType::create([
                        'item_id' => $item->id,
                        'name' => $data['name'],
                        'quantity' => $data['quantity'],
                        'price_buy' => str_replace('.', '', $data['price_buy']),
                        'price_sell' => str_replace('.', '', $data['price_sell']),
                    ]);
                }
            }
        }

        return redirect()->route('daftar.barang.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroySatuan($id)
    {
        $satuan = ItemUnitType::findOrFail($id);
        $satuan->delete();

        return redirect()->back()->with('success', 'Satuan berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Purchases;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $query = Purchases::where('payment_type', 'credit')->with('vendor')->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('payment_type', function ($row) {
                    return '<span class="text-uppercase badge bg-light-warning">' . e($row->payment_type) . '</span>';
                })
                ->editColumn('payment_total', function ($row) {
                    // Format angka ke format rupiah 100000 -> 100.000
                    return number_format($row->payment_total, 0, ',', '.');
                })
                ->addColumn('action', function ($item) {
                    return '<a href="' . route('hutang.edit', $item->id) . '" class="icon-link icon-link-hover text-dark">
                <i class="bi-credit-card mb-1"></i>
                Bayar
            </a>';
                })
                ->rawColumns(['payment_type', 'action'])
                ->escapeColumns([])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable' => false, 'searchable' => false],
            ['data' => 'purchase_number'],
            ['data' => 'vendor.name'],
            ['data' => 'opname_date'],
            ['data' => 'payment_type'],
            ['data' => 'payment_total', 'name' => 'payment_total', 'title' => 'Outstanding Payable'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]);

        return view('hutang.index', compact('html'));
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
        //
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
        $dataPurchase = Purchases::findOrFail($id);
        return view('hutang.edit');
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
        //
    }
}

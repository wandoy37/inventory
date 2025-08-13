<?php

namespace App\Http\Controllers;

use App\Models\Purchases;
use App\Models\BankAccount;
use App\Models\ItemUnitType;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use App\Models\PurchaseCredit;
use App\Models\PurchaseTransfer;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $query = Purchases::with('vendor')->orderBy('created_at', 'desc');

            $pt = session('payment_type_filter');
            if (!empty($pt)) {
                $query->where('payment_type', $pt);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('payment_type', function ($row) {
                    $map = [
                        'cash'          => 'success',
                        'cek/bg'        => 'primary',
                        'bank transfer' => 'primary',
                        'credit'        => 'warning',
                    ];
                    $val   = strtolower(trim($row->payment_type));
                    $class = $map[$val] ?? 'secondary';
                    return '<span class="text-uppercase badge bg-light-' . $class . '">' . e($row->payment_type) . '</span>';
                })
                ->editColumn('payment_total', function ($row) {
                    // Format angka ke format rupiah 100000 -> 100.000
                    return number_format($row->payment_total, 0, ',', '.');
                })
                ->addColumn('action', function ($item) {
                    return '<a href="' . route('stock-opname.edit', $item->id) . '" class="icon-link icon-link-hover text-dark">
                <i class="bi bi-pen mb-2"></i>
                Edit
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
            ['data' => 'payment_total'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]);

        $widget = Purchases::select('payment_type', DB::raw('COUNT(*) as total'))
            ->groupBy('payment_type')
            ->pluck('total', 'payment_type')
            ->toArray();

        return view('stockopname.index', compact('html', 'widget'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bankAccounts = BankAccount::get();
        return view('stockopname.create', compact('bankAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dulu biar aman
        $validated = $request->validate([
            'vendor_id' => 'required|integer',
            'tanggal'   => 'required|date',
            'items'     => 'required|array|min:1',
            'items.*.item_id' => 'required|integer',
            'items.*.item_unit_type_id' => 'required|integer',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.price_buy' => 'required|integer|min:1',
            'items.*.price_sell' => 'nullable|integer|min:0',
            'items.*.price_total' => 'required|integer|min:1',
            'payment_type' => 'required|in:cash,cek/bg,bank transfer,credit',
            'payment_total' => 'required|integer|min:1',
        ]);

        // === Store data purchases ===
        $dataPurchase = Purchases::create([
            // 'purchase_number' otomatis
            'user_id' => Auth::user()->id,
            'vendor_id' => $request->vendor_id,
            'opname_date' => $request->tanggal,
            'payment_type' => $request->payment_type,
            'payment_total' => $request->payment_total,
            'status' => $request->payment_type === 'credit' ? 'credit' : 'paid',
        ]);

        // === Store dan looping data purchase_items ===
        foreach ($request->items as $item) {
            PurchaseItem::create([
                'purchase_id'        => $dataPurchase->id,
                'item_id'            => $item['item_id'],
                // 'item_unit_type_id'  => $item['item_unit_type_id'],
                'quantity'           => $item['quantity'],
                'price_buy'          => $item['price_buy'],
                'price_sell'         => $item['price_sell'],
                'price_total'        => $item['price_total'],
                'status'        => 'purchase',
                'note'        => 'PO',
            ]);
        }

        // === Update stock/quantity data pada tabel item_unit_types
        foreach ($request->items as $item) {
            $unitType = ItemUnitType::find($item['item_unit_type_id']);
            $unitType->update([
                'quantity' => $unitType->quantity + $item['quantity'],
            ]);
        }

        // === Jika Purchases payment_type credit
        if ($request->payment_type == 'credit') {
            PurchaseCredit::create([
                'purchase_id' => $dataPurchase->id,
                'repayment_date' => null,
                'payment_type' => null,
                'status' => 'credit',
            ]);
        }

        // === Jika Purchases payment_type bank transfer
        if ($request->payment_type == 'bank transfer') {
            PurchaseTransfer::create([
                'purchase_id' => $dataPurchase->id,
                'bank_id' => $request->bank_id,
                'bank_origin' => $request->bank_origin, //asal bank
                'reference_number' => $request->reference_number // nomor refrensi bank transfer
            ]);
        }

        return 'berhasil';
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
        //
    }
}

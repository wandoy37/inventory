<?php

namespace App\Http\Controllers;

use App\Models\Purchases;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\PurchaseCredit;
use App\Models\RekeningVendor;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\PurchaseCreditTransfer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $query = PurchaseCredit::with(['purchase', 'purchase.vendor'])->orderBy('created_at', 'desc');
            

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('payment_type', function ($row) {
                    return '<span class="text-uppercase badge bg-light-warning">' . e($row->purchase->payment_type) . '</span>';
                })
                ->editColumn('payment_total', function ($row) {
                    // Format angka ke format rupiah 100000 -> 100.000
                    return number_format($row->purchase->payment_total, 0, ',', '.');
                })
                ->addColumn('action', function ($item) {
                    if ($item->status == 'credit') {
                        return '<a href="' . route('hutang.edit', $item->id) . '" class="icon-link icon-link-hover text-dark">
                                <i class="bi-credit-card mb-1"></i>
                                Bayar
                            </a>';
                    }

                    if ($item->status == 'paid') {
                        return '<a href="' . route('hutang.show', $item->id) . '" class="icon-link icon-link-hover text-dark">
                                <i class="bi bi-eye mb-2"></i>
                                Lihat
                            </a>';
                    }
                })
                ->editColumn('vendor_name', function ($row) {
                    return $row->purchase->vendor->name ?? '-';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 'credit') {
                        return '<span class="badge rounded-pill bg-light-warning"><i class="bi bi-info"></i></span>';
                    }

                    if ($row->status == 'paid') {
                        return '<span class="badge rounded-pill bg-light-success"><i class="bi bi-check-circle"></i></span>';
                    }
                })
                ->escapeColumns([])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable' => false, 'searchable' => false],
            ['data' => 'purchase.purchase_number'],
            ['data' => 'vendor_name'],
            ['data' => 'purchase.opname_date'],
            ['data' => 'payment_total', 'name' => 'purchase.payment_total', 'title' => 'Outstanding Payable'],
            ['data' => 'status'],
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
        $purchaseCreditPaid = PurchaseCredit::findOrFail($id);
        return view('hutang.show', compact('purchaseCreditPaid'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataHutang = PurchaseCredit::findOrFail($id);
        $bankAccounts = BankAccount::get();
        $rekeningVendors = RekeningVendor::where('vendor_id', $dataHutang->purchase->vendor_id)->get();
        return view('hutang.edit', compact('dataHutang', 'bankAccounts', 'rekeningVendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'repayment_date' => ['required'],
            'payment_type'   => ['required'],

            'bank_id' => [
                Rule::when($request->payment_type === 'bank transfer', ['required']),
            ],
            'rekening_vendor_id' => [
                Rule::when($request->payment_type === 'bank transfer', ['required']),
            ],
            'reference_number' => [
                Rule::when($request->payment_type === 'bank transfer', ['required']),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataPurchaseCredit = PurchaseCredit::findOrFail($id);
        // 1. if payment_type bank transfer, maka buat data purchase_credit_transfers
        if ($request->payment_type == 'bank transfer') {
            PurchaseCreditTransfer::create([
                'purchase_credit_id' => $dataPurchaseCredit->id,
                'bank_id' => $request->bank_id,
                'rekening_vendor_id' => $request->rekening_vendor_id,
                'reference_number' => $request->reference_number
            ]);
        }

        // 2. update status data purchases_credit credit menjadi paid
        $dataPurchaseCredit->update([
            'repayment_date' => $request->repayment_date,
            'payment_type' => $request->payment_type,
            'status' => 'paid',
        ]);
        // 3. updat status data purchases
        $dataPurchase = Purchases::findOrFail($dataPurchaseCredit->purchase_id);
        $dataPurchase->update([
            'status' => 'paid',
        ]);

        return redirect()->route('hutang.index')->with('success', 'Hutang berhasil di bayar.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

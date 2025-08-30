@extends('layouts.app')

@section('title', 'Hutang # ' . $purchaseCreditPaid->purchase->purchase_number)
@section('pageHeading')
  Hutang # {{ $purchaseCreditPaid->purchase->purchase_number }}
  <span class="badge rounded-pill bg-light-success">
    <i class="bi bi-check-circle"></i>
     Paid
  </span>
@endsection

@section('content')
    <div class="page-content">
        <section class="section">
            <div class="row pb-4">
                <div class="col-lg-12">
                    <a href="{{ route('hutang.index') }}" class="btn btn-rounded btn-outline-primary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_opname">Vendor/Supplier</label>
                                    <input type="text" class="form-control" id="date_opname" value="{{ $purchaseCreditPaid->purchase->vendor->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="date_opname">Tanggal Stock Opname</label>
                                    <input type="text" class="form-control" id="date_opname" value="{{ $purchaseCreditPaid->purchase->opname_date }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="date_opname">Tanggal Pelunasan</label>
                                    <input type="text" class="form-control" id="date_opname" value="{{ $purchaseCreditPaid->repayment_date }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="date_opname">Metode Pelunasan</label>
                                    <input type="text" class="form-control text-uppercase" id="date_opname" value="{{ $purchaseCreditPaid->payment_type }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4>Daftar Barang</h4>
                                <hr class="my-2">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Satuan</th>
                                            <th>Kuantitas</th>
                                            <th>Harga Beli (Rp)</th>
                                            <th>Harga Jual (Rp)</th>
                                            <th>Jumlah (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($purchaseCreditPaid->purchase->items as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->item->name }}</td>
                                                <td>{{ $item->unitType->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->price_buy, 0, ',', '.') }}</td>
                                                <td>{{ number_format($item->price_sell, 0, ',', '.') }}</td>
                                                <td>{{ number_format($item->price_total, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="fw-bold table-secondary">
                                            <td colspan="6" class="text-center">Jumlah</td>
                                            <td>{{ number_format($purchaseCreditPaid->purchase->payment_total, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/simple-datatables/style.css">
@endpush

@push('script')
    <script src="{{ asset('assets') }}/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="{{ asset('assets') }}/static/js/pages/simple-datatables.js"></script>
@endpush

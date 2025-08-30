@extends('layouts.app')

@section('title', 'Hutang # ' . $dataHutang->purchase->purchase_number)
@section('pageHeading', 'Hutang # ' . $dataHutang->purchase->purchase_number)

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
                <form action="{{ route('hutang.update', $dataHutang->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- Form Pelunasan Hutang --}}
                    <div class="col-md-12">
                        @if (session('errors'))
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <p>Terjadi kesalahan, periksa data yang di input.!</p>
                                        @foreach ($errors->all() as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4>Pelunasan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Pelunasan</label>
                                            <input type="text" name="repayment_date" class="form-control @error('repayment_date') is-invalid @enderror"
                                                id="repayment_date" value="{{ old('repayment_date') }}"
                                                placeholder="yyyy-mm-dd" readonly>
                                                @error('repayment_date')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_type">Tipe Pembayaran</label>
                                            <select class="form-select @error('payment_type') is-invalid @enderror"
                                                id="payment_type" name="payment_type">
                                                <option value="">-- Pilih Tipe Pembayaran --</option>
                                                <option value="cash"
                                                    {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash
                                                </option>
                                                <option value="cek/bg"
                                                    {{ old('payment_type') == 'cek/bg' ? 'selected' : '' }}>
                                                    Cek/BG
                                                </option>
                                                <option value="bank transfer"
                                                    {{ old('payment_type') == 'bank transfer' ? 'selected' : '' }}>Bank
                                                    Transfer
                                                </option>
                                            </select>
                                            @error('payment_type')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Section khusus Bank Transfer --}}
                                <div class="bank-transfer-fields fx-fade" id="bank_transfer_wrap">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bank_id">Akun Bank</label>
                                                <select class="form-select @error('bank_id') is-invalid @enderror"
                                                    id="bank_id" name="bank_id" disabled>
                                                    <option value="">-- Pilih Akun Bank --</option>
                                                    @foreach ($bankAccounts as $bank)
                                                        <option value="{{ $bank->id }}"
                                                            {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                            {{ $bank->account_number }} - {{ $bank->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('bank_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bank_origin">Tujuan Bank/Rekening</label>
                                                <select id="rekening_vendor_id" name="rekening_vendor_id"
                                                    class="form-select  @error('rekening_vendor_id') is-invalid @enderror">
                                                    <option value="">-- Pilih tujuan bank/rekening --</option>
                                                    @foreach ($rekeningVendors as $rekening)
                                                        <option value="{{ $rekening->id }}">{{ $rekening->bank_name }} -
                                                            {{ $rekening->rekening_number }} a.n.
                                                            {{ $rekening->vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('rekening_vendor_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                @error('bank_origin')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="reference_number">Nomor Referensi Transfer</label>
                                                <input type="text"
                                                    class="form-control @error('reference_number') is-invalid @enderror"
                                                    id="reference_number" name="reference_number"
                                                    value="{{ old('reference_number') }}" placeholder="Reference number"
                                                    disabled>
                                                @error('reference_number')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Total Pembayaran</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text"
                                            class="form-control satuan-input price-input"
                                            name="payment_total" placeholder="0"
                                            value="{{ number_format($dataHutang->purchase->payment_total, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group float-end pt-4">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Bayar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Form Pelunasan Hutang --}}

                    <div class="col-md-12">
                        <hr class="my-4">
                        <h4>
                            Rincian Pembelian
                        </h4>
                        <hr class="my-4">
                    </div>

                    {{-- Form Vendor & Tanggal Opname --}}
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vendor</label>
                                            <input type="text" class="form-control" name="vendor_id" id="vendor_id"
                                                value="{{ old('vendor_id', $dataHutang->purchase->vendor->name) }}"
                                                placeholder="vendors" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Opname</label>
                                            <input type="text" name="tanggal" class="form-control"
                                                value="{{ old('tanggal', $dataHutang->purchase->opname_date) }}"
                                                placeholder="yyyy-mm-dd" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Form Vendor & Tanggal Opname --}}

                    {{-- Tabel Daftar Barang --}}
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Barang</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover" id="table1">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
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
                                        @foreach ($dataHutang->purchase->items as $item)
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
                                            <td colspan="6" class="text-center">Total</td>
                                            <td>{{ number_format($dataHutang->purchase->payment_total, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- End Tabel Daftar Barang --}}
                </form>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="{{ asset('assets/css/fade-in-out.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker_style.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets') }}/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="{{ asset('assets') }}/static/js/pages/simple-datatables.js"></script>
    <script src="{{ asset('assets') }}/js/bootstrap-datepicker.min.js"></script>

    {{-- Date repayment_date Picker --}}
    <script>
        $(function() {
            $('#repayment_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'id'
            });
        });
    </script>

    {{-- Jika memilih bank transfer tampilkan akun bank, asal bank dan nomor refrensi transfer --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentType = document.querySelector('#payment_type');
            const bankWrap = document.querySelector('.bank-transfer-fields');

            // Pastikan class dasar tetap ada
            bankWrap.classList.add('fx-fade');
            bankWrap.classList.remove('is-open');

            // Fungsi toggle
            const toggleBankFields = (isOpen) => {
                if (isOpen) {
                    bankWrap.classList.add('is-open');
                } else {
                    bankWrap.classList.remove('is-open');
                }
                bankWrap.querySelectorAll('input, select, textarea')
                    .forEach(el => el.disabled = !isOpen);
            };

            // Event saat tipe pembayaran berubah
            paymentType.addEventListener('change', function() {
                toggleBankFields(this.value === 'bank transfer');
            });

            // Initial load (prefill edit)
            toggleBankFields(paymentType.value === 'bank transfer');
        });
    </script>
@endpush

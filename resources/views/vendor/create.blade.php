@extends('layouts.app')

@section('title', 'Tambah Vendor')
@section('pageHeading', 'Tambah Vendor')

@section('content')
    <div class="page-content">
        @if (session('errors'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-error alert-dismissible show fade">
                        <Strong>Terjadi kesalahan, periksa data yang di input.!</Strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        <section class="section">
            <div class="row pb-4">
                <div class="col-lg-12">
                    <a href="{{ route('daftar-vendor.index') }}" class="btn btn-rounded btn-outline-primary">
                        <i class="bi bi-plus"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="row">
                <form action="{{ route('daftar-vendor.store') }}" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Vendor</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="2" required>{{ old('address') }}</textarea>
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Nomor Telepon</label>
                                                <input type="number"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                    value="{{ old('phone') }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group float-end">
                                        <button type="submit" class="btn btn-rounded btn-outline-primary">
                                            <i class="bi bi-floppy-fill"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
@endpush

@push('script')
    <script src="{{ asset('assets') }}/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
@endpush

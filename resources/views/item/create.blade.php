@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('pageHeading', 'Tambah Barang')

@section('content')
    <div class="page-content">
        <section class="section">
            <div class="row pb-4">
                <div class="col-lg-12">
                    <a href="{{ route('daftar.barang.index') }}" class="btn btn-rounded btn-outline-primary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('daftar.barang.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama barang</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi barang</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">

                        <div id="container_satuan"></div>

                        <div class="d-grid pb-4" id="tambah_satuan">
                            <button class="btn btn-rounded btn-outline-primary" type="button" onclick="tambahSatuan()">
                                <i class="bi bi-plus"></i>
                                Tambah Satuan
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="float-end pb-4">
                                <button type="submit" class="btn btn-rounded btn-outline-primary">
                                    <i class="bi bi-floppy-fill"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            {{-- End Form --}}
        </section>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/form_satuan.css">
@endpush
@push('script')
    <script src="{{ asset('assets') }}/js/form_satuan.js"></script>
@endpush

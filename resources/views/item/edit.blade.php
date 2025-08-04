@extends('layouts.app')

@section('title', 'Edit Barang')
@section('pageHeading', 'Edit Barang')

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

            @if (session('success'))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissible show fade">
                            <Strong>Success </Strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('daftar.barang.update', $item->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Kode barang</label>
                                    <input type="text" class="form-control" value="{{ $item->code }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama barang</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $item->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi barang</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3" required>{{ old('description', $item->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Satuan yang sudah ada --}}
                    <div class="col-lg-6" id="container_satuan">
                        @if ($item->units->count())
                            @foreach ($item->units as $unit)
                                <div class="card form-satuan fade-in" id="form_satuan_db_{{ $unit->id }}">
                                    <div class="card-body">
                                        {{-- Tombol hapus dengan konfirmasi SweetAlert --}}
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove"
                                            onclick="hapusSatuanDatabase({{ $unit->id }})">
                                            <i class="bi bi-x"></i>
                                            Hapus
                                        </button>

                                        {{-- Hidden input ID untuk deteksi data lama --}}
                                        <input type="hidden" name="satuan[{{ $loop->iteration }}][id]"
                                            value="{{ $unit->id }}">

                                        <div class="form-group mb-3">
                                            <label>Satuan</label>
                                            <input type="text" class="form-control satuan-input"
                                                name="satuan[{{ $loop->iteration }}][name]" value="{{ $unit->name }}"
                                                required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Kuantitas (Stock Awal)</label>
                                            <input type="number" class="form-control satuan-input"
                                                name="satuan[{{ $loop->iteration }}][quantity]"
                                                value="{{ $unit->quantity }}" min="0" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Harga Beli</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control satuan-input price-input"
                                                    name="satuan[{{ $loop->iteration }}][price_buy]"
                                                    value="{{ number_format($unit->price_buy, 0, ',', '.') }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Harga Jual</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control satuan-input price-input"
                                                    name="satuan[{{ $loop->iteration }}][price_sell]"
                                                    value="{{ number_format($unit->price_sell, 0, ',', '.') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p><i>Tidak ada satuan</i></p>
                        @endif

                        {{-- tombol tambah --}}
                        <div class="d-grid pb-4" id="tambah_satuan">
                            <button class="btn btn-rounded btn-outline-primary" type="button" onclick="tambahSatuan()">
                                <i class="bi bi-plus"></i>
                                Tambah Satuan
                            </button>
                        </div>
                    </div>




                    {{-- tombol simpan --}}
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
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/form_satuan.css">
@endpush
@push('script')
    <script src="{{ asset('assets') }}/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script>
        window.baseDeleteUrl = "{{ url('/daftar-barang/satuan') }}";
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('assets') }}/js/form_satuan.js"></script>
    <script src="{{ asset('assets') }}/js/hapus_satuan_database.js"></script>
@endpush

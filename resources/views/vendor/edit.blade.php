@extends('layouts.app')

@section('title', 'Edit Vendor')
@section('pageHeading', 'Edit Vendor')

@section('content')
    <div class="page-content">
        @if (session('errors'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan, periksa data yang di input.!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        @if (session('success'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
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
                <form action="{{ route('daftar-vendor.update', $vendor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                                                    value="{{ old('name', $vendor->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="2" required>{{ old('address', $vendor->address) }}</textarea>
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
                                                    value="{{ old('email', $vendor->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Nomor Telepon</label>
                                                <input type="number"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                    value="{{ old('phone', $vendor->phone) }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group float-end">
                                        <button type="submit" class="btn btn-rounded btn-outline-primary">
                                            <i class="bi bi-arrow-repeat"></i>
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                @include('vendor.form_tambah_rekening')
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Rekening</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <th>NO</th>
                                        <th>BANK</th>
                                        <th>NOMOR REKENING</th>
                                        <th>ACTION</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($vendor->rekenings as $rekening)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $rekening->bank_name }}</td>
                                                <td>{{ $rekening->rekening_number }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-md text-danger ms-2 btn-delete"
                                                        data-id="{{ $rekening->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <!-- Form delete disembunyikan -->
                                                    <form id="delete-form-{{ $rekening->id }}"
                                                        action="{{ route('rekening-vendor.destroy', $rekening->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/sweetalert2/sweetalert2.min.css">
@endpush

@push('script')
    <script src="{{ asset('assets') }}/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/sweetalert2/sweetalert2.min.js"></script>>

    {{-- Button Delete wiht confirmation sweetAlert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const roomId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure you want to delete?',
                        text: "Deleted data cannot be returned!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit form sesuai ID
                            document.getElementById('delete-form-' + roomId).submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush

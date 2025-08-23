@extends('layouts.app')

@section('title', 'Stock Opname')
@section('pageHeading', 'Stock Opname')

@section('content')
    <div class="page-content">
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
        <section class="section">
            {{-- Widget --}}
            @include('stockopname.widget')

            <div class="row pb-4">
                <div class="col-lg-12">
                    <a href="{{ route('stock-opname.create') }}" class="btn btn-rounded btn-outline-primary float-end">
                        <i class="bi bi-plus"></i>
                        Stock Opname
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                {!! $html->table(['class' => 'table table-hover'], true) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/sweetalert2/sweetalert2.min.css">
@endpush

@push('script')
    <script src="{{ asset('assets') }}/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/sweetalert2/sweetalert2.min.js"></script>>
    {!! $html->scripts() !!}

    {{-- Button Delete wiht confirmation sweetAlert --}}
    <script>
        // Delegasi event: berlaku untuk elemen yang ditambahkan setelah draw DataTables
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return; // klik bukan pada tombol delete

            const id = btn.dataset.id;

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
                    const form = document.getElementById('delete-form-' + id);
                    if (form) form.submit();
                }
            });
        });
    </script>
@endpush

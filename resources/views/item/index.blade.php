@extends('layouts.app')

@section('title', 'Daftar Barang')
@section('pageHeading', 'Daftar Barang')

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
            <div class="row pb-4">
                <div class="col-lg-12">
                    <a href="{{ route('daftar.barang.create') }}" class="btn btn-rounded btn-outline-primary">
                        <i class="bi bi-plus"></i>
                        Tambah Barang
                    </a>
                </div>
            </div>
            <div class="row" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="item-table">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>CODE</th>
                                                <th>NAMA BARANG</th>
                                                <th>DESCRIPTION</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
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
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
@endpush

@push('script')
    <script src="{{ asset('assets') }}/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#item-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('daftar.barang.data') }}',
                columns: [{
                        data: 'DT_RowIndex', // Untuk kolom NO auto increment
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    processing: "Memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });

        // Function untuk handle button actions
        function editItem(id) {
            // Logic edit
            console.log('Edit item:', id);
        }

        function deleteItem(id) {
            // Logic delete
            if (confirm('Yakin ingin menghapus item ini?')) {
                console.log('Delete item:', id);
            }
        }
    </script>
@endpush

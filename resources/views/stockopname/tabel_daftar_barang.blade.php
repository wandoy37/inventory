<table class="table table-striped" id="table1">
    <thead>
        <tr>
            <th>NO</th>
            <th>Barang</th>
            <th>Satuan</th>
            <th>Kuantitas</th>
            <th>Harga Beli (Rp)</th>
            <th>Harga Jual (Rp)</th>
            <th>Jumlah (Rp)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="itemsTbody">
    </tbody>
</table>

@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/extensions/simple-datatables/style.css">
@endpush

@push('script')
    <script src="{{ asset('assets') }}/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="{{ asset('assets') }}/static/js/pages/simple-datatables.js"></script>
@endpush

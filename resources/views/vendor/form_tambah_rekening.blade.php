<div class="col-md-6">
    <div class="card">
        <form action="{{ route('rekening-vendor.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-froup">
                    <h4 class="pb-2">Tamabh Rekening</h4>
                </div>
                <div class="form-group">
                    <label>Nama Bank</label>
                    <input type="text" name="vendor_id" value="{{ $vendor->id }}" hidden>
                    <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror"
                        value="{{ old('bank_name') }}">
                </div>
                <div class="form-group">
                    <label>No. Rekening</label>
                    <input type="text" name="rekening_number"
                        class="form-control @error('rekening_number') is-invalid @enderror"
                        value="{{ old('rekening_number') }}">
                </div>
                <div class="form-group float-end">
                    <button type="submit" class="btn btn-outline-primary">
                        Tambah
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

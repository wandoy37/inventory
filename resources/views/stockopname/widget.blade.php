<div class="row">
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon green mb-2">
                            <i class="bi-cash"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <a href="{{ route('stock-opname.filter', 'cash') }}">
                            <h6 class="text-muted font-semibold">Cash</h6>
                            <h6 class="font-extrabold mb-0">{{ number_format($widget['cash'] ?? 0, 0, ',', '.') }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon blue mb-2">
                            <i class="bi-journal-text"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <a href="{{ route('stock-opname.filter', 'cek-bg') }}">
                            <h6 class="text-muted font-semibold">Cek/BG</h6>
                            <h6 class="font-extrabold mb-0">{{ number_format($widget['cek/bg'] ?? 0, 0, ',', '.') }}
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon blue mb-2">
                            <i class="bi-bank"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <a href="{{ route('stock-opname.filter', 'bank transfer') }}">
                            <h6 class="text-muted font-semibold">Bank Transfer</h6>
                            <h6 class="font-extrabold mb-0">
                                {{ number_format($widget['bank transfer'] ?? 0, 0, ',', '.') }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon mb-2" style="background-color:#FFDE21;">
                            <i class="bi-credit-card"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <a href="{{ route('stock-opname.filter', 'credit') }}">
                            <h6 class="text-muted font-semibold">Kredit</h6>
                            <h6 class="font-extrabold mb-0">{{ number_format($widget['credit'] ?? 0, 0, ',', '.') }}
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <a href="{{ route('stock-opname.filter', 'all') }}" class="btn btn-outline-secondary">Tampilkan Semua</a>
        <div class="float-end">
        </div>
    </div>
</div>

@extends('layouts.app')

@section('title', 'Edit Stock Opname')
@section('pageHeading', 'Edit Stock Opname')

@section('content')
    <div class="page-content">
        @if (session('errors'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-danger alert-dismissible show fade">
                        <p>Terjadi kesalahan, periksa data yang di input.!</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
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
                    <a href="{{ route('stock-opname.index') }}" class="btn btn-rounded btn-outline-primary">
                        <i class="bi bi-plus"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="row">
                <form action="{{ route('stock-opname.update', $dataPurchase->id) }}" method="POST" id="formOpname"
                    novalidate>
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pilih Vendor</label>
                                            <select id="vendor_id" name="vendor_id" class="choices form-select">
                                                <option value="" disabled selected>Ketik 2 karakter ...</option>
                                            </select>
                                            @error('vendor_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Opname</label>
                                            <input type="text" id="tanggal" name="tanggal"
                                                class="form-control form-control-lg @error('tanggal') is-invalid @enderror"
                                                placeholder="yyyy-mm-dd"
                                                value="{{ old('tanggal', $dataPurchase->opname_date) }}">
                                            @error('tanggal')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            @include('stockopname.modal_tambah_barang')
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Barang</h4>
                            </div>
                            <div class="card-body">
                                @include('stockopname.tabel_daftar_barang')
                            </div>
                        </div>
                    </div>
                    <div id="itemsHidden"></div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="payment_type">Tipe Pembayaran</label>
                                    <select class="form-select @error('payment_type') is-invalid @enderror"
                                        id="payment_type" name="payment_type">
                                        <option value="">-- Pilih Tipe Pembayaran --</option>
                                        @php $pt = old('payment_type', $dataPurchase->payment_type); @endphp
                                        <option value="cash" {{ $pt === 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="cek/bg" {{ $pt === 'cek/bg' ? 'selected' : '' }}>Cek/BG</option>
                                        <option value="bank transfer" {{ $pt === 'bank transfer' ? 'selected' : '' }}>Bank
                                            Transfer</option>
                                        <option value="credit" {{ $pt === 'credit' ? 'selected' : '' }}>Kredit</option>
                                    </select>
                                    @error('payment_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Section khusus Bank Transfer --}}
                                <div class="bank-transfer-fields fx-fade" id="bank-transfer-fields">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bank_id">Akun Bank</label>
                                                <select class="form-select @error('bank_id') is-invalid @enderror"
                                                    id="bank_id" name="bank_id" disabled>
                                                    <option value="">-- Pilih Akun Bank --</option>
                                                    @foreach ($bankAccounts as $bank)
                                                        <option value="{{ $bank->id }}"
                                                            {{ old('bank_id', optional($dataPurchase->transfer)->bank_id) == $bank->id ? 'selected' : '' }}>
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
                                                <label for="bank_origin">Asal Bank</label>
                                                <input type="text"
                                                    class="form-control @error('bank_origin') is-invalid @enderror"
                                                    id="bank_origin" name="bank_origin"
                                                    value="{{ old('bank_origin', optional($dataPurchase->transfer)->bank_origin) }}"
                                                    placeholder="Bank origin" disabled>
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
                                                    value="{{ old('reference_number', optional($dataPurchase->transfer)->reference_number) }}"
                                                    placeholder="Reference number" disabled>
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
                                            class="form-control @error('payment_total') is-invalid @enderror satuan-input price-input"
                                            name="payment_total" placeholder="0" required readonly>
                                        @error('payment_total')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group float-end pb-4">
                            <button type="submit" class="btn btn-outline-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select_vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fade-in-out.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets') }}/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets') }}/js/bootstrap-datepicker.min.js"></script>

    {{-- Select2 Vendors --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('vendor_id');

            const choices = new Choices(el, {
                allowHTML: false, // default masa depan → aman dari XSS
                searchEnabled: true,
                shouldSort: false,
                removeItemButton: false,
                placeholder: true,
                placeholderValue: 'Ketik untuk mencari…',
                searchResultLimit: 20,
                renderChoiceLimit: 50,
                loadingText: 'Memuat…',
                noResultsText: 'Tidak ada hasil',
                noChoicesText: 'Tidak ada data',
            });

            // --- Prefill: ambil id dari old() atau model ---
            const selectedId = "{{ old('vendor_id', $dataPurchase->vendor_id) }}";

            (async function prefillSelected() {
                if (!selectedId) return;

                try {
                    const url = `{{ url('/api/options/vendors') }}?id=${encodeURIComponent(selectedId)}`;
                    const res = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json(); // null atau {value,label}

                    if (data && data.value && data.label) {
                        // ganti choices dengan 1 opsi terpilih
                        choices.setChoices(
                            [{
                                value: data.value,
                                label: data.label,
                                selected: true
                            }],
                            'value',
                            'label',
                            true // replaceChoices
                        );
                    } else {
                        // fallback: kalau id tidak valid lagi, biarkan kosong
                        console.warn('Vendor tidak ditemukan untuk id:', selectedId);
                    }
                } catch (e) {
                    console.error('Gagal prefill vendor:', e);
                }
            })();

            // --- Remote search (debounce) ---
            let debounceTimer = null;
            let lastQuery = '';

            // Event 'search' dari Choices dipancarkan di elemen select
            el.addEventListener('search', (e) => {
                const q = (e.detail?.value || '').trim();

                if (q.length < 2) {
                    // jangan hapus pilihan yang sudah ada; cukup diam
                    return;
                }
                if (q === lastQuery) return;
                lastQuery = q;

                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const url =
                        `{{ url('/api/options/vendors') }}?q=${encodeURIComponent(q)}&per_page=20`;
                    choices.setChoices(async () => {
                        const res = await fetch(url, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json(); // array of {value,label}
                        return Array.isArray(data) ? data : [];
                    }, 'value', 'label', true);
                }, 300);
            });
        });
    </script>

    {{-- Date Opname Picker --}}
    <script>
        $(function() {
            $('#tanggal').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'id'
            });
        });
    </script>

    {{-- Keranjang Sementara --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ====== UTIL ======
            const parseIDRInt = (s) => {
                const digits = (s ?? '').toString().replace(/\D/g, '');
                return digits ? parseInt(digits, 10) : 0;
            };
            const formatIDR = (n) => new Intl.NumberFormat('id-ID').format(n);

            // ====== STATE: ambil items awal dari server ======
            // ==> pastikan variabel $initialItems dikirim dari controller
            const items = @json($initialItems ?? []);

            // ====== DOM ======
            const tbody = document.getElementById('itemsTbody');
            const hidden = document.getElementById('itemsHidden');
            const form = document.getElementById('formOpname');

            const modalEl = document.getElementById('modalTambahBarang');
            const itemEl = document.getElementById('item_id');
            const unitEl = document.getElementById('item_unit_type_id');
            const qtyEl = document.querySelector('input[name="quantity"]');
            const buyEl = document.querySelector('input[name="price_buy"]');
            const sellEl = document.querySelector('input[name="price_sell"]');
            const totalEl = document.querySelector('input[name="price_total"]');
            const btnAdd = document.getElementById('btnTambahBarang');

            const payTotalEl = document.querySelector('input[name="payment_total"]');
            const grandTotalTextEl = document.getElementById('grandTotalText');

            function calcSubtotal() {
                return items.reduce((sum, it) => sum + (Number(it.price_total) || 0), 0);
            }

            function updateGrandTotal() {
                const subtotal = calcSubtotal();
                if (payTotalEl) payTotalEl.value = formatIDR(subtotal);
                if (grandTotalTextEl) grandTotalTextEl.textContent = formatIDR(subtotal);
            }

            function renderTable() {
                tbody.innerHTML = '';
                items.forEach((it, idx) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                <td>${idx + 1}</td>
                <td>${it.item_name}</td>
                <td>${it.unit_name}</td>
                <td>${it.qty}</td>
                <td>${formatIDR(it.price_buy)}</td>
                <td>${formatIDR(it.price_sell)}</td>
                <td>${formatIDR(it.price_total)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" data-action="delete" data-index="${idx}">
                        Hapus
                    </button>
                </td>
            `;
                    tbody.appendChild(tr);
                });
                updateGrandTotal();
            }

            function syncHiddenInputs() {
                hidden.innerHTML = '';
                items.forEach((it, idx) => {
                    const fields = {
                        item_id: it.item_id,
                        item_unit_type_id: it.unit_id,
                        quantity: it.qty,
                        price_buy: it.price_buy,
                        price_sell: it.price_sell,
                        price_total: it.price_total,
                    };
                    Object.entries(fields).forEach(([key, val]) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `items[${idx}][${key}]`;
                        input.value = val;
                        hidden.appendChild(input);
                    });
                });
            }

            // ==== INIT: render data awal bila ada ====
            renderTable();
            syncHiddenInputs();

            // ==== Helper ambil label dari Choices/select ====
            function getSelectedLabel(selectEl) {
                if (selectEl && selectEl.selectedIndex >= 0) {
                    const opt = selectEl.options[selectEl.selectedIndex];
                    if (opt && opt.text) return opt.text.trim();
                }
                try {
                    const arr = selectEl?._choices?.getValue?.();
                    if (Array.isArray(arr) && arr[0]?.label) return String(arr[0].label).trim();
                } catch (_) {}
                return '';
            }

            // ====== TAMBAH dari modal ======
            btnAdd?.addEventListener('click', function() {
                const itemId = itemEl?.value || '';
                const unitId = unitEl?.value || '';
                const itemName = getSelectedLabel(itemEl);
                const unitName = getSelectedLabel(unitEl);
                const qty = parseFloat(qtyEl?.value) || 0;
                const priceBuy = parseIDRInt(buyEl?.value);
                const priceSell = parseIDRInt(sellEl?.value);
                const computedTotal = Math.round(qty * priceBuy);

                if (!itemId) return alert('Pilih barang terlebih dahulu.');
                if (!unitId) return alert('Pilih satuan terlebih dahulu.');
                if (qty <= 0) return alert('Kuantitas harus > 0.');
                if (priceBuy <= 0) return alert('Harga beli harus > 0.');

                items.push({
                    item_id: itemId,
                    item_name: itemName,
                    unit_id: unitId,
                    unit_name: unitName,
                    qty: qty,
                    price_buy: priceBuy,
                    price_sell: priceSell,
                    price_total: computedTotal
                });

                renderTable();
                syncHiddenInputs();

                // bersihkan modal
                try {
                    itemEl?._choices?.removeActiveItems();
                    unitEl?._choices?.removeActiveItems();
                } catch (_) {}
                if (qtyEl) qtyEl.value = '';
                if (buyEl) buyEl.value = '';
                if (sellEl) sellEl.value = '';
                if (totalEl) totalEl.value = '';
            });

            // ====== HAPUS dari tabel ======
            tbody?.addEventListener('click', function(e) {
                const btn = e.target.closest('button[data-action="delete"]');
                if (!btn) return;
                const idx = parseInt(btn.dataset.index, 10);
                if (Number.isInteger(idx)) {
                    items.splice(idx, 1);
                    renderTable();
                    syncHiddenInputs();
                }
            });

            // ====== SUBMIT: pastikan hidden inputs sinkron ======
            form?.addEventListener('submit', function() {
                syncHiddenInputs();
                // kalau masih ada .price-input lain di form, bersihkan titiknya
                form.querySelectorAll('.price-input').forEach((i) => {
                    i.value = i.value.replace(/\./g, '');
                });
            });

            // ====== (opsional) sinkron total di modal ======
            const recalcFromModal = () => {
                const qty = parseFloat(qtyEl?.value) || 0;
                const buy = parseIDRInt(buyEl?.value);
                const total = Math.round(qty * buy);
                if (totalEl) totalEl.value = formatIDR(total);
            };
            qtyEl?.addEventListener('input', recalcFromModal);
            buyEl?.addEventListener('input', recalcFromModal);
            modalEl?.addEventListener('shown.bs.modal', recalcFromModal);
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

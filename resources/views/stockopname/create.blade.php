@extends('layouts.app')

@section('title', 'Tambah Stock Opname')
@section('pageHeading', 'Tambah Stock Opname')

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
                <form action="{{ route('stock-opname.store') }}" method="POST" id="formOpname" novalidate>
                    @csrf
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
                                                placeholder="yyyy-mm-dd">
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
                                        <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="cek/bg" {{ old('payment_type') == 'cek/bg' ? 'selected' : '' }}>
                                            Cek/BG
                                        </option>
                                        <option value="bank transfer"
                                            {{ old('payment_type') == 'bank transfer' ? 'selected' : '' }}>Bank Transfer
                                        </option>
                                        <option value="credit" {{ old('payment_type') == 'credit' ? 'selected' : '' }}>
                                            Kredit
                                        </option>
                                    </select>
                                    @error('payment_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Section khusus Bank Transfer --}}
                                <div class="bank-transfer-fields fx-fade" id="bank_transfer_wrap">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bank_id">Akun Bank</label>
                                                <select class="form-select @error('bank_id') is-invalid @enderror"
                                                    id="bank_id" name="bank_id" disabled>
                                                    <option value="">-- Pilih Akun Bank --</option>
                                                    @foreach ($bankAccounts as $bank)
                                                        <option value="{{ $bank->id }}"
                                                            {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
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
                                                    id="bank_origin" name="bank_origin" value="{{ old('bank_origin') }}"
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
                                                    value="{{ old('reference_number') }}" placeholder="Reference number"
                                                    disabled>
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

            let debounceTimer = null;
            let lastQuery = '';

            // Event 'search' dari Choices dipancarkan di elemen select
            el.addEventListener('search', (e) => {
                const q = (e.detail.value || '').trim();

                if (q.length < 2) {
                    choices.clearChoices();
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
                        const data = await res
                            .json(); // harus array of { value, label }
                        return data;
                    }, 'value', 'label', true); // replaceChoices = true
                }, 300);
            });

            // kosongkan pilihan awal
            choices.clearChoices();
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
            // ====== UTIL yang sudah ada / dipakai ulang ======
            const parseIDRInt = (s) => {
                const digits = (s ?? '').toString().replace(/\D/g, '');
                return digits ? parseInt(digits, 10) : 0;
            };
            const formatIDR = (n) => new Intl.NumberFormat('id-ID').format(n);

            // ====== STATE SEMENTARA ======
            const items = []; // {item_id, item_name, unit_id, unit_name, qty, price_buy, price_sell, price_total}

            // ====== DOM ELEMENTS ======
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

            // Ambil label pilihan dari Choices
            function getSelectedLabel(selectEl) {
                // Ambil teks dari <option> yang terpilih
                if (selectEl && selectEl.selectedIndex >= 0) {
                    const opt = selectEl.options[selectEl.selectedIndex];
                    if (opt && opt.text) return opt.text.trim();
                }
                // Fallback: ambil dari Choices (kalau ada)
                try {
                    const arr = selectEl?._choices?.getValue?.();
                    if (Array.isArray(arr) && arr[0]?.label) return String(arr[0].label).trim();
                } catch (_) {}
                return '';
            }

            // === GRAND TOTAL ===
            const payTotalEl = document.querySelector('input[name="payment_total"]'); // field Total Pembayaran
            const grandTotalTextEl = document.getElementById('grandTotalText'); // opsional (jika kamu buat di HTML)

            function calcSubtotal() {
                return items.reduce((sum, it) => sum + (Number(it.price_total) || 0), 0);
            }

            function updateGrandTotal() {
                const subtotal = calcSubtotal();
                // isi field pembayaran (terformat)
                if (payTotalEl) payTotalEl.value = formatIDR(subtotal);
                // jika ada tampilan teks di bawah tabel
                if (grandTotalTextEl) grandTotalTextEl.textContent = formatIDR(subtotal);
            }

            // ====== RENDER TABEL ======
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

            // ====== SYNC -> HIDDEN INPUTS UNTUK SUBMIT ======
            function syncHiddenInputs() {
                hidden.innerHTML = ''; // reset
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

            // ====== TAMBAHKAN ITEM DARI MODAL ======
            btnAdd?.addEventListener('click', function() {
                const itemId = itemEl?.value || '';
                const unitId = unitEl?.value || '';
                const itemName = getSelectedLabel(itemEl);
                const unitName = getSelectedLabel(unitEl);
                const qty = parseFloat(qtyEl?.value) || 0;

                const priceBuy = parseIDRInt(buyEl?.value);
                const priceSell = parseIDRInt(sellEl?.value);
                // kalau user belum sempat mengetik sampai total terhitung, hitung ulang di sini:
                const computedTotal = Math.round(qty * priceBuy);

                // Validasi sederhana
                if (!itemId) {
                    alert('Pilih barang terlebih dahulu.');
                    return;
                }
                if (!unitId) {
                    alert('Pilih satuan terlebih dahulu.');
                    return;
                }
                if (qty <= 0) {
                    alert('Kuantitas harus > 0.');
                    return;
                }
                if (priceBuy <= 0) {
                    alert('Harga beli harus > 0.');
                    return;
                }

                // Simpan ke state
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

                // Render & Sync
                renderTable();
                syncHiddenInputs();

                // Reset isi modal (kamu juga sudah punya handler reset on hidden, tapi ini biar langsung bersih)
                try {
                    itemEl?._choices?.removeActiveItems();
                    unitEl?._choices?.removeActiveItems();
                } catch (_) {}
                if (qtyEl) qtyEl.value = '';
                if (buyEl) buyEl.value = '';
                if (sellEl) sellEl.value = '';
                if (totalEl) totalEl.value = '';
            });

            // ====== HAPUS ITEM DI TABEL ======
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

            // ====== PASTIKAN ANGKA MURNI SAAT SUBMIT (backup tambahan) ======
            form?.addEventListener('submit', function() {
                // kalau user tidak pernah klik Tambah (modal), tapi mengisi field manual — tidak kita dukung.
                // Di sini cukup pastikan hidden inputs sudah dibuat dari items[].
                syncHiddenInputs();

                // Jika kamu masih punya .price-input lain di form, bersihkan titiknya
                form.querySelectorAll('.price-input').forEach((i) => {
                    i.value = i.value.replace(/\./g, '');
                });
            });

            // ====== OPSIONAL: hitung ulang total di input modal (kalau user ubah qty/harga) ======
            const recalcFromModal = () => {
                const qty = parseFloat(qtyEl?.value) || 0;
                const buy = parseIDRInt(buyEl?.value);
                const total = Math.round(qty * buy);
                if (totalEl) totalEl.value = formatIDR(total);
            };
            qtyEl?.addEventListener('input', recalcFromModal);
            buyEl?.addEventListener('input', recalcFromModal);
            document.getElementById('modalTambahBarang')?.addEventListener('shown.bs.modal', recalcFromModal);
        });
    </script>

    {{-- Jika memilih bank transfer tampilkan akun bank, asal bank dan nomor refrensi transfer --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentType = document.querySelector('#payment_type');
            const bankWrap = document.querySelector('.bank-transfer-fields');

            bankWrap.classList.add('fx-fade');
            bankWrap.classList.remove('is-open');

            paymentType.addEventListener('change', function() {
                if (this.value === 'bank transfer') {
                    bankWrap.classList.add('is-open');
                    bankWrap.querySelectorAll('input, select, textarea').forEach(el => el.disabled = false);
                } else {
                    bankWrap.classList.remove('is-open');
                    bankWrap.querySelectorAll('input, select, textarea').forEach(el => el.disabled = true);
                }
            });

            if (paymentType.value === 'bank transfer') {
                bankWrap.classList.add('is-open');
            }
        });
    </script>
@endpush

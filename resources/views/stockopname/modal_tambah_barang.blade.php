<div class="d-grid">
    <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
        Tambah Barang
    </button>
</div>
<div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="modalTambahBarangTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahBarangTitle">
                    Tambah Barang
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih Barang</label>
                    <select id="item_id" name="item_id"
                        class="choices form-select @error('item_id') is-invalid @enderror">
                        <option value="" disabled selected>Ketik 2 karakter ...</option>
                    </select>
                    @error('item_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Pilih Satuan</label>
                    <select id="item_unit_type_id" name="item_unit_type_id"
                        class="choices form-select  @error('item_unit_type_id') is-invalid @enderror">
                        <option value="" disabled selected>Ketik 2 karakter ...</option>
                    </select>
                    @error('item_unit_type_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label>Kuantitas</label>
                    <input type="number" class="form-control satuan-input @error('quantity') is-invalid @enderror"
                        name="quantity" placeholder="0" required>
                    @error('quantity')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label>Harga Beli</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text"
                            class="form-control satuan-input price-input @error('price_buy') is-invalid @enderror"
                            name="price_buy" placeholder="0" required>
                    </div>
                    @error('price_buy')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label>Harga Jual</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text"
                            class="form-control satuan-input price-input @error('price_sell') is-invalid @enderror"
                            name="price_sell" placeholder="0"required>
                        @error('price_sell')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Jumlah</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text"
                            class="form-control satuan-input price-input @error('price_total') is-invalid @enderror"
                            name="price_total" placeholder="0"required readonly>
                        @error('price_total')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal" id="btnTambahBarang">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Tambah</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('script')
    {{-- Select2 Items --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('item_id');

            // kalau sudah pernah di-init, JANGAN init lagi
            if (!el._choices) {
                el._choices = new Choices(el, {
                    allowHTML: false,
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
                    itemSelectText: ''
                });
                // kosongkan pilihan awal hanya saat pertama kali
                el._choices.clearChoices();
            }
            const choices = el._choices;

            let debounceTimer = null;
            let lastQuery = '';

            // pasang listener 'search' sekali saja
            if (!el.dataset.searchBound) {
                el.dataset.searchBound = '1';

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
                        // PERBAIKAN: template literal harus pakai backtick
                        const url =
                            `{{ url('/api/options/items') }}?q=${encodeURIComponent(q)}&per_page=20`;
                        choices.setChoices(async () => {
                            const res = await fetch(url, {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            });
                            const data = await res.json(); // [{value,label}]
                            return data;
                        }, 'value', 'label', true);
                    }, 300);
                });
            }
        });
    </script>

    {{-- Select2 Item Unit Types (dependent) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // PAKAI instance yang sudah ada, jangan init Choices lagi utk item_id
            const itemEl = document.getElementById('item_id');
            const itemChoices = itemEl._choices; // <-- sudah ada dari script 1

            // === UNIT (pilih satuan) ===
            const unitEl = document.getElementById('item_unit_type_id');

            // Jika kamu ingin unit juga memakai Choices, pastikan tidak dobel init
            if (!unitEl._choices) {
                unitEl._choices = new Choices(unitEl, {
                    allowHTML: false,
                    searchEnabled: true,
                    shouldSort: false,
                    placeholder: true,
                    placeholderValue: 'Pilih satuan…',
                    loadingText: 'Memuat…',
                    noResultsText: 'Tidak ada hasil',
                    noChoicesText: 'Tidak ada data',
                    itemSelectText: ''
                });
            }
            const unitChoices = unitEl._choices;

            const setUnitLoading = () => {
                unitChoices.clearChoices();
                unitChoices.setChoices([{
                    value: '',
                    label: 'Memuat…',
                    disabled: true,
                    selected: true
                }], 'value', 'label', true);
            };
            const setUnitEmpty = () => {
                unitChoices.clearChoices();
                unitChoices.setChoices([{
                    value: '',
                    label: 'Tidak ada satuan untuk barang ini',
                    disabled: true,
                    selected: true
                }], 'value', 'label', true);
            };

            // pasang listener 'change' sekali saja
            if (!itemEl.dataset.changeBound) {
                itemEl.dataset.changeBound = '1';

                itemEl.addEventListener('change', async (e) => {
                    const itemId = e.target.value;
                    if (!itemId) {
                        setUnitEmpty();
                        return;
                    }

                    setUnitLoading();
                    try {
                        // PERBAIKAN: pakai backtick & url() blade
                        const url = `{{ url('/api/items') }}/${itemId}/units`;
                        const res = await fetch(url, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json(); // [{ value, label }]

                        if (!Array.isArray(data) || data.length === 0) {
                            setUnitEmpty();
                            return;
                        }
                        unitChoices.setChoices(data, 'value', 'label', true);
                    } catch (err) {
                        console.error(err);
                        unitChoices.clearChoices();
                        unitChoices.setChoices([{
                            value: '',
                            label: 'Gagal memuat satuan',
                            disabled: true,
                            selected: true
                        }], 'value', 'label', true);
                    }
                });
            }
        });
    </script>

    {{-- Clear Modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalTambahBarang');
            const itemEl = document.getElementById('item_id');
            const unitEl = document.getElementById('item_unit_type_id');

            // Reset saat modal ditutup (TANPA destroy)
            modal?.addEventListener('hidden.bs.modal', () => {
                // bersihkan pilihan aktif & daftar opsi (item)
                itemEl?._choices?.removeActiveItems();
                itemEl?._choices?.clearChoices();
                // kembalikan placeholder awal
                itemEl?._choices?.setChoices(
                    [{
                        value: '',
                        label: 'Ketik 2 karakter ...',
                        disabled: true,
                        selected: true
                    }],
                    'value', 'label', true
                );

                // bersihkan pilihan aktif & daftar opsi (unit)
                unitEl?._choices?.removeActiveItems();
                unitEl?._choices?.clearChoices();
                unitEl?._choices?.setChoices(
                    [{
                        value: '',
                        label: 'Ketik 2 karakter ...',
                        disabled: true,
                        selected: true
                    }],
                    'value', 'label', true
                );

                // kosongkan input angka/harga di dalam modal
                modal.querySelectorAll('input').forEach((inp) => {
                    if (inp.hasAttribute('readonly')) return;
                    inp.value = '';
                });
            });
        });
    </script>

    {{-- Format rupaih pada clas price-input --}}
    <script>
        // Formatter Rupiah (tanpa simbol)
        function formatRupiahFromString(str) {
            const digits = str.replace(/\D/g, ""); // ambil angka saja
            if (!digits) return "";
            return new Intl.NumberFormat("id-ID").format(Number(digits));
        }

        function attachPriceFormatter(el) {
            // Format saat ketik
            el.addEventListener("input", function() {
                const cursorEnd = this.value.length;
                this.value = formatRupiahFromString(this.value);
                // (opsional) biarkan caret di akhir supaya tidak “lompat”
                this.setSelectionRange(this.value.length, this.value.length);
            });

            // Pastikan terformat saat blur
            el.addEventListener("blur", function() {
                this.value = formatRupiahFromString(this.value);
            });
        }

        // Ambil semua .price-input (bukan dari ID)
        document.querySelectorAll(".price-input").forEach(attachPriceFormatter);

        // (Opsional) sebelum submit, kirim angka murni ke server
        // Supaya Laravel tidak bingung dengan titik pemisah ribuan
        const form = document.querySelector("form");
        if (form) {
            form.addEventListener("submit", function() {
                document.querySelectorAll(".price-input").forEach((i) => {
                    i.value = i.value.replace(/\./g, "");
                });
            });
        }
    </script>

    {{-- Penjumlahan Kuantitas x Harga Beli --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qtyEl = document.querySelector('input[name="quantity"]');
            const buyEl = document.querySelector('input[name="price_buy"]');
            const totalEl = document.querySelector('input[name="price_total"]');

            // Ambil angka murni dari string rupiah: "10.000" -> 10000
            const parseIDRInt = (s) => {
                const digits = (s ?? '').toString().replace(/\D/g, ''); // buang semua non-digit
                return digits ? parseInt(digits, 10) : 0;
            };

            const formatIDR = (n) => new Intl.NumberFormat('id-ID').format(n);

            const recalcTotal = () => {
                const qty = parseFloat(qtyEl?.value) ||
                    0; // quantity boleh desimal, kalau mau bulat pakai parseInt
                const buy = parseIDRInt(buyEl?.value); // harga beli integer (tanpa titik)
                const total = Math.round(qty * buy); // pembulatan aman
                if (totalEl) totalEl.value = formatIDR(total);
            };

            // Hitung ulang saat qty/harga beli berubah
            qtyEl?.addEventListener('input', recalcTotal);
            qtyEl?.addEventListener('change', recalcTotal);
            // Jika kamu punya formatter di price_buy, parsing ini tetap aman
            buyEl?.addEventListener('input', recalcTotal);
            buyEl?.addEventListener('change', recalcTotal);

            // Saat modal dibuka, sinkronkan nilai awal jika ada
            document.getElementById('modalTambahBarang')
                ?.addEventListener('shown.bs.modal', recalcTotal);
        });
    </script>

    {{-- script disable input modal saat tertutup --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalTambahBarang');
            const modalInputs = modal.querySelectorAll('select, input');

            const setDisabled = (val) => modalInputs.forEach(el => el.disabled = val);

            modal.addEventListener('hidden.bs.modal', () => setDisabled(true));
            modal.addEventListener('shown.bs.modal', () => setDisabled(false));

            setDisabled(true);
        });
    </script>
@endpush

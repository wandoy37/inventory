let formCounter = 0; // Counter untuk ID unik

function tambahSatuan() {
    formCounter++; // Increment counter untuk ID unik
    
    const container = document.getElementById('container_satuan');
    
    // Template HTML untuk form satuan baru
    const formHTML = `
        <div class="card form-satuan fade-in" id="form_satuan_${formCounter}" data-form-id="${formCounter}">
            <div class="card-body">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove" onclick="hapusSatuan(${formCounter})">
                    <i class="bi bi-x"></i>
                    Hapus
                </button>
                
                <div class="row">
                    <div class="col-12">
                        <h6 class="card-title satuan-title">Satuan #1</h6>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label>Satuan</label>
                    <input type="text" class="form-control satuan-input" name="satuan[${formCounter}][name]" placeholder="Contoh: Kg, Pcs, Liter" required>
                </div>
                
                <div class="form-group mb-3">
                    <label>Kuantitas (Stock Awal)</label>
                    <input type="number" class="form-control satuan-input" name="satuan[${formCounter}][quantity]" placeholder="0" min="0" required>
                </div>
                
                <div class="form-group mb-3">
                    <label>Harga Beli</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" class="form-control satuan-input price-input" name="satuan[${formCounter}][price_buy]" placeholder="0" required>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label>Harga Jual</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" class="form-control satuan-input price-input" name="satuan[${formCounter}][price_sell]" placeholder="0"required>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', formHTML);
    updateFormNumbers(); // Update nomor urut setelah menambah
    
    
    
    // PENTING: Attach event listeners untuk format rupiah pada input harga yang baru ditambah
    const newForm = document.getElementById(`form_satuan_${formCounter}`);
    const priceInputs = newForm.querySelectorAll('.price-input');
    priceInputs.forEach(input => {
        attachPriceFormatter(input);
    });
}

function hapusSatuan(id) {
    const formElement = document.getElementById(`form_satuan_${id}`);
    if (formElement) {
        // Animasi fade out sebelum menghapus
        formElement.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => {
            formElement.remove();
            updateFormNumbers(); // Update nomor urut setelah menghapus
        }, 300);
    }
}

function updateFormNumbers() {
    const forms = document.querySelectorAll('.form-satuan');
    let counter = 1;
    forms.forEach((form) => {
        const title = form.querySelector('.satuan-title');
        const inputs = form.querySelectorAll('.satuan-input');

        if (form.querySelector('input[name*="[id]"]')) {
            // ini satuan database, jangan ubah name
            if (title) title.textContent = `Satuan #${counter}`;
            counter++;
            return;
        }

        if (title) title.textContent = `Satuan #${counter}`;
        inputs.forEach(input => {
            const currentName = input.getAttribute('name');
            if (currentName) {
                const newName = currentName.replace(/satuan\[\d+\]/, `satuan[${counter}]`);
                input.setAttribute('name', newName);
            }
        });
        counter++;
    });
}

// Fungsi untuk format rupiah
function formatRupiah(angka) {
    // Hapus semua karakter non-digit
    let numberString = angka.replace(/[^,\d]/g, '').toString();
    let split = numberString.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}

// Fungsi untuk menghapus format rupiah dan mendapatkan angka asli
function unformatRupiah(formattedNumber) {
    return formattedNumber.replace(/\./g, '').replace(/[^0-9]/g, '');
}

// Fungsi untuk attach event listener format rupiah
function attachPriceFormatter(input) {
    // Format saat user mengetik
    input.addEventListener('input', function(e) {
        let cursorPosition = e.target.selectionStart;
        let oldLength = e.target.value.length;
        
        // Format nilai
        e.target.value = formatRupiah(e.target.value);
        
        // Adjust cursor position
        let newLength = e.target.value.length;
        let newCursorPosition = cursorPosition + (newLength - oldLength);
        e.target.setSelectionRange(newCursorPosition, newCursorPosition);
    });

    // Format saat focus keluar
    input.addEventListener('blur', function(e) {
        if (e.target.value) {
            e.target.value = formatRupiah(e.target.value);
        }
    });

    // Izinkan hanya angka dan backspace/delete
    input.addEventListener('keypress', function(e) {
        let charCode = e.which ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            e.preventDefault();
        }
    });
}
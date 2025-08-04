function hapusSatuanDatabase(id) {
    Swal.fire({
        title: "Yakin hapus satuan ini?",
        text: "Data akan terhapus permanen dari database.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = window.baseDeleteUrl + "/" + id;

            let token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = window.csrfToken;

            let method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';

            form.appendChild(token);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
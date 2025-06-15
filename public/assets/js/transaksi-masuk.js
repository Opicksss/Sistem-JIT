
let itemsData = [];
let itemCounter = 0;

// Tambah item ke tabel sementara
document.getElementById('btn-tambah-item').addEventListener('click', function () {
    // Validasi form item
    const formItem = document.getElementById('form-item');
    const suplierId = document.getElementById('suplier_id').value;
    const bahanBakuId = document.getElementById('bahan_baku_id').value;
    const stok = document.getElementById('stok').value;

    if (!suplierId || !bahanBakuId || !stok) {
        alert('Harap lengkapi semua field item!');
        return;
    }

    if (parseFloat(stok) <= 0) {
        alert('Stok harus lebih dari 0!');
        return;
    }

    // Ambil data dari select option
    const suplierOption = document.querySelector(`#suplier_id option[value="${suplierId}"]`);
    const bahanBakuOption = document.querySelector(`#bahan_baku_id option[value="${bahanBakuId}"]`);

    const suplierNama = suplierOption.textContent;
    const bahanBakuNama = bahanBakuOption.getAttribute('data-nama');
    const idBahanBaku = bahanBakuOption.getAttribute('data-id-bahan');

    // Cek duplikasi item
    const isDuplicate = itemsData.some(item =>
        item.suplier_id === suplierId && item.bahan_baku_id === bahanBakuId
    );

    if (isDuplicate) {
        alert('Item dengan suplier dan bahan baku yang sama sudah ada!');
        return;
    }

    // Tambah ke array data
    itemCounter++;
    const newItem = {
        id: itemCounter,
        suplier_id: suplierId,
        bahan_baku_id: bahanBakuId,
        suplier_nama: suplierNama,
        bahan_baku_nama: bahanBakuNama,
        id_bahan_baku: idBahanBaku,
        stok: parseFloat(stok)
    };
    itemsData.push(newItem);

    // Update tabel
    updateTableSementara();

    // Reset form item
    formItem.reset();

    // Enable tombol simpan
    document.getElementById('btn-simpan-transaksi').disabled = false;
});

// Update tabel sementara
function updateTableSementara() {
    const tbody = document.querySelector('#table-sementara tbody');

    if (itemsData.length === 0) {
        tbody.innerHTML =
            '<tr id="empty-row"><td colspan="6" class="text-center text-muted">Belum ada item yang ditambahkan</td></tr>';
        document.getElementById('btn-simpan-transaksi').disabled = true;
        return;
    }

    let html = '';
    itemsData.forEach((item, index) => {
        html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.id_bahan_baku}</td>
                        <td>${item.bahan_baku_nama}</td>
                        <td>${item.suplier_nama}</td>
                        <td style="width: 250px;">
                            <input type="number" 
                                   class="form-control form-control-sm stok-input" 
                                   value="${item.stok}" 
                                   min="0.001"
                                   step="0.001"
                                   data-item-id="${item.id}"
                                   onchange="updateStokItem(${item.id}, this.value)">
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger " onclick="hapusItem(${item.id})">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
    });

    tbody.innerHTML = html;
}

// Update stok item di tabel
function updateStokItem(itemId, newStok) {
    // Validasi input
    if (!newStok || parseFloat(newStok) <= 0) {
        alert('Stok harus lebih dari 0!');
        // Reset ke nilai sebelumnya
        const input = document.querySelector(`input[data-item-id="${itemId}"]`);
        const item = itemsData.find(item => item.id === itemId);
        if (item) {
            input.value = item.stok;
        }
        return;
    }

    // Update data di array
    const itemIndex = itemsData.findIndex(item => item.id === itemId);
    if (itemIndex !== -1) {
        itemsData[itemIndex].stok = parseFloat(newStok);
    }
}

// Hapus item dari tabel
function hapusItem(itemId) {
    if (confirm('Yakin ingin menghapus item ini?')) {
        itemsData = itemsData.filter(item => item.id !== itemId);
        updateTableSementara();
    }
}

// Simpan transaksi ke database
document.getElementById('btn-simpan-transaksi').addEventListener('click', function () {
    // Validasi header
    const idTransaksi = document.getElementById('id_transaksi').value;
    const penerima = document.getElementById('penerima').value;
    const tanggalMasuk = document.getElementById('tanggal_masuk').value;

    if (!idTransaksi || !penerima || !tanggalMasuk) {
        alert('Harap lengkapi data header transaksi!');
        return;
    }

    if (itemsData.length === 0) {
        alert('Harap tambahkan minimal satu item transaksi!');
        return;
    }

    if (confirm('Yakin ingin menyimpan transaksi ini?')) {
        // Buat form untuk submit
        const formSubmit = document.getElementById('form-final-submit');

        // Tambah field header
        formSubmit.innerHTML = `
                    @csrf
                    <input type="hidden" name="id_transaksi" value="${idTransaksi}">
                    <input type="hidden" name="penerima" value="${penerima}">
                    <input type="hidden" name="tanggal_masuk" value="${tanggalMasuk}">
                `;

        // Tambah field items
        itemsData.forEach((item, index) => {
            formSubmit.innerHTML += `
                        <input type="hidden" name="items[${index}][suplier_id]" value="${item.suplier_id}">
                        <input type="hidden" name="items[${index}][bahan_baku_id]" value="${item.bahan_baku_id}">
                        <input type="hidden" name="items[${index}][stok]" value="${item.stok}">
                    `;
        });

        // Submit form
        formSubmit.submit();
    }
});

// Set tanggal hari ini sebagai default
document.getElementById('tanggal_masuk').value = new Date().toISOString().split('T')[0];

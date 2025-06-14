<x-layout>
    <x-slot:title>Tambah Transaksi Masuk</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Transaksi Masuk</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Transaksi Masuk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="me-2">
                        <a href="{{ url('/') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="active" aria-current="page">Transaksi Masuk</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Form Transaksi Masuk</h5>

                <!-- Form Header Transaksi -->
                <form id="form-header" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label for="id_transaksi" class="form-label">ID Transaksi *</label>
                        <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" required>
                    </div>
                    <div class="col-md-6">
                        <label for="penerima" class="form-label">Penerima *</label>
                        <input type="text" class="form-control" id="penerima" name="penerima" value="admin" readonly required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk *</label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                    </div>
                </form>

                <hr>

                <!-- Form Item Transaksi -->
                <h6 class="mb-3">Tambah Item Transaksi</h6>
                <form id="form-item" class="row g-3">
                    <div class="col-md-4">
                        <label for="suplier_id" class="form-label">Nama Suplier *</label>
                        <select class="form-control" id="suplier_id" name="suplier_id" required>
                            <option value="">-- Pilih Suplier --</option>
                            @foreach ($supliers as $suplier)
                                <option value="{{ $suplier->id }}">{{ $suplier->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="bahan_baku_id" class="form-label">Nama Bahan Baku *</label>
                        <select class="form-control" id="bahan_baku_id" name="bahan_baku_id" required>
                            <option value="">-- Pilih Bahan Baku --</option>
                            @foreach ($bahan_bakus as $bahan_baku)
                                <option value="{{ $bahan_baku->id }}" data-nama="{{ $bahan_baku->nama }}"
                                    data-id-bahan="{{ $bahan_baku->id_bahan_baku }}">
                                    {{ $bahan_baku->nama }} ({{ $bahan_baku->satuan }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="stok" class="form-label">Stok Masuk *</label>
                        <input type="number" step="0.001" class="form-control" id="stok" name="stok"
                            required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" id="btn-tambah-item" class="btn btn-primary w-100">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </form>

                <hr>

                <!-- Tabel Sementara -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Daftar Item Transaksi</h6>
                    <div>
                        <button type="button" id="btn-simpan-transaksi" class="btn btn-success px-4" disabled>
                            <i class="bx bx-save"></i> Simpan Transaksi
                        </button>
                        <a href="{{ route('transaksi_masuk.index') }}" class="btn btn-secondary px-4">
                            <i class="bx bx-x"></i> Batal
                        </a>
                    </div>
                </div>

                <table class="table table-bordered" id="table-sementara">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>ID Bahan Baku</th>
                            <th>Nama Bahan Baku</th>
                            <th>Suplier</th>
                            <th>Stok Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="empty-row">
                            <td colspan="6" class="text-center text-muted">Belum ada item yang ditambahkan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form untuk submit ke database -->
    <form id="form-final-submit" action="{{ route('transaksi_masuk.store') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        let itemsData = [];
        let itemCounter = 0;

        // Tambah item ke tabel sementara
        document.getElementById('btn-tambah-item').addEventListener('click', function() {
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
        document.getElementById('btn-simpan-transaksi').addEventListener('click', function() {
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
    </script>
</x-layout>

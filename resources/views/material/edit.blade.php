<x-layout>
    <x-slot:title>Edit Bahan Baku</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Edit Bahan Baku</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Bahan Baku</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="me-2">
                        <a href="{{ url('/') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="active" aria-current="page">Edit Bahan Baku</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Form Edit Bahan Baku</h5>
                <form class="row g-3" action="{{ route('bahanBaku.update', $bahanBaku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-12">
                        <label for="id_bahan_baku" class="form-label">ID Bahan</label>
                        <input type="text" class="form-control" id="id_bahan_baku" name="id_bahan_baku" value="{{ $bahanBaku->id_bahan_baku }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="nama" class="form-label">Nama Bahan</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $bahanBaku->nama }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="jenis" class="form-label">Jenis</label>
                        <select id="jenis" name="jenis" class="form-select" required>
                            <option disabled>Pilih Jenis...</option>
                            <option value="Bahan Baku" {{ $bahanBaku->jenis == 'Bahan Baku' ? 'selected' : '' }}>Bahan Baku</option>
                            <option value="Bahan Pendukung" {{ $bahanBaku->jenis == 'Bahan Pendukung' ? 'selected' : '' }}>Bahan Pendukung</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select id="satuan" name="satuan" class="form-select" required>
                            <option disabled>Pilih Satuan...</option>
                            <option value="Kg" {{ $bahanBaku->satuan == 'Kg' ? 'selected' : '' }}>Kg</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="stok" class="form-label">Stock</label>
                        <input type="number" step="0.001" class="form-control" id="stok" name="stok" value="{{ $bahanBaku->stok }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="{{ $bahanBaku->harga }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="gambar" class="form-label">Gambar (opsional)</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                        @if ($bahanBaku->gambar)
                            <small class="text-muted d-block mt-1">
                                Gambar saat ini: <br>
                                <img src="{{ asset('storage/' . $bahanBaku->gambar) }}" alt="gambar" height="60">
                            </small>
                        @else
                            <small class="text-muted d-block mt-1">Tidak ada gambar</small>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <button type="submit" class="btn btn-grd-primary px-4 text-white">Update</button>
                            <a href="{{ route('bahanBaku.index') }}" class="btn btn-grd-royal px-4 text-white">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

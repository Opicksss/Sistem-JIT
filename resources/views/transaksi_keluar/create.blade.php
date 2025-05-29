<x-layout>
    <x-slot:title>Tambah Transaksi Keluar</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Transaksi keluar</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Trasnsaksi keluar</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="me-2">
                        <a href="{{ url('/') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="active" aria-current="page">Transaksi keluar</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Form Transaksi keluar</h5>
                <form class="row g-3" action="{{ route('transaksi_keluar.store') }}" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <label for="penerima" class="form-label">Penerima</label>
                        <input type="text" class="form-control" id="penerima" name="penerima" required>
                    </div>
                    <div class="col-md-12">
                        <label for="suplier_id" class="form-label">Nama Suplier</label>
                        <select class="form-control" id="suplier_id" name="suplier_id" required>
                            <option value="">-- Pilih Suplier --</option>
                            @foreach($supliers as $suplier)
                                <option value="{{ $suplier->id }}">{{ $suplier->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="bahan_baku_id" class="form-label">Nama Bahan Baku</label>
                        <select class="form-control" id="bahan_baku_id" name="bahan_baku_id" required>
                            <option value="">-- Pilih Bahan Baku --</option>
                            @foreach($bahan_bakus as $bahan_baku)
                                <option value="{{ $bahan_baku->id }}">{{ $bahan_baku->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>
                    <div class="col-md-12">
                        <label for="tanggal_keluar" class="form-label">Tanggal keluar</label>
                        <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" required>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <button type="submit" class="btn btn-grd-primary px-4 text-white">Simpan</button>
                            <a href="{{ route('transaksi_keluar.index') }}" class="btn btn-grd-royal px-4 text-white">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

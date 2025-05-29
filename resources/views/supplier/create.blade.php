<x-layout>
    <x-slot:title>Tambah Supplier</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Tambah Supplier</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Supplier</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="me-2">
                        <a href="{{ url('/') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="active" aria-current="page">Tambah Supplier</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Form Tambah Supplier</h5>
                <form class="row g-3" action="{{ route('supplier.store') }}" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <label for="id_suplier" class="form-label">ID Supplier</label>
                        <input type="text" class="form-control" id="id_suplier" name="id_suplier" required>
                    </div>
                    <div class="col-md-12">
                        <label for="nama" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                    </div>
                    <div class="col-md-12">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota" name="kota" required>
                    </div>
                    <div class="col-md-12">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <button type="submit" class="btn btn-grd-primary px-4 text-white">Simpan</button>
                            <a href="{{ route('supplier.index') }}" class="btn btn-grd-royal px-4 text-white">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

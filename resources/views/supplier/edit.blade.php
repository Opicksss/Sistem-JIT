<x-layout>
    <x-slot:title>Edit Supplier</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Edit Supplier</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Supplier</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="me-2">
                        <a href="{{ url('/') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="active" aria-current="page">Edit Supplier</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Form Edit Supplier</h5>
                <form class="row g-3" action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <label for="id_suplier" class="form-label">ID Supplier</label>
                        <input type="text" class="form-control" id="id_suplier" name="id_suplier" value="{{ old('id_suplier', $supplier->id_suplier) }}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="nama" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $supplier->nama) }}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat ..." rows="3" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $supplier->telepon) }}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota" name="kota" value="{{ old('kota', $supplier->kota) }}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ old('provinsi', $supplier->provinsi) }}" required>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <button type="submit" class="btn btn-grd-primary px-4 text-white">Update</button>
                            <a href="{{ route('supplier.index') }}" class="btn btn-grd-royal px-4 text-white">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

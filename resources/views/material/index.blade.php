<x-layout>
    <x-slot:title>Bahan Baku</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Master Bahan Baku </div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Bahan Baku</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item me-2">
                        <a href="javascript:void(0)"><i class="bx bx-package"></i></a>
                    </li>
                    <li> Master Bahan Baku</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Master Bahan Baku</h5>
                    </div>
                    <a href="{{ route('bahanBaku.create') }}" class="btn btn-primary px-3">
                        <i class="bx bx-plus me-1"></i>Bahan Baku
                    </a>
                </div>
            </div>

            <div class="card-body" enctype="multipart/form-data">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Bahan</th>
                                <th width="20%">Nama Bahan</th>
                                <th width="10%">Jenis</th>
                                <th width="10%">Satuan</th>
                                <th width="10%">Stock</th>
                                <th width="15%">Harga</th>
                                <th width="15%">Gambar</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bahanBakus as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->id_bahan_baku }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td class="text-center">{{ $item->satuan }}</td>
                                    <td class="text-end">{{ $item->stok }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if ($item->gambar && file_exists(public_path('storage/' . $item->gambar)))
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Bahan Baku"
                                                class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('bahanBaku.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $item->id }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal delete -->
                                <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                                    aria-labelledby="delete{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header justify-content-center border-bottom-0 py-2">
                                                <h5 class="modal-title text-danger text-decoration-underline fw-bold">
                                                    Konfirmasi Penghapusan
                                                </h5>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p class="mb-4">
                                                    Apakah Anda yakin ingin menghapus data
                                                    <strong style="font-size: 1rem;">{{ ucwords($item->nama) }}
                                                        ?</strong>
                                                    Tindakan ini tidak dapat dibatalkan.
                                                </p>
                                                <div class="d-flex justify-content-center">
                                                    <i class="bi bi-exclamation-circle-fill text-warning"
                                                        style="font-size: 6rem;"></i>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0">
                                                <button type="button" class="btn btn-outline-secondary "
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('bahanBaku.destroy', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //Modal delete -->
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>

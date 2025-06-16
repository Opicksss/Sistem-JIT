<x-layout>
    <x-slot:title>Transaksi Masuk</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Transaksi Bahan Baku Masuk</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Transaksi</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item me-2">
                        <a href="javascript:void(0)"><i class="bx bx-package"></i></a>
                    </li>
                    <li> Transaksi Bahan Baku Masuk</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Transaksi Bahan Baku Masuk</h5>
                    </div>
                    <a href="{{ route('transaksi_masuk.create') }}" class="btn btn-primary px-3">
                        <i class="bx bx-plus me-1"></i>Transaksi Masuk
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>ID Transaksi</th>
                                <th width="20%">Penerima</th>
                                <th width="10%">Suplier</th>
                                <th width="10%">Bahan Baku</th>
                                <th width="10%">Stok Masuk</th>
                                <th width="10%">Tanggal</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi_masuks as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->id_transaksi }}</td>
                                    <td>{{ $item->penerima }}</td>
                                    <td>{{ $item->suplier->nama }}</td>
                                    <td>{{ $item->bahanBaku->nama }}</td>
                                    <td class="text-end">{{ $item->stok }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->locale('id')->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>

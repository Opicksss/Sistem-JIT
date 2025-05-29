<x-layout>
    <x-slot:title>Transaksi Keluar</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Transaksi Bahan Baku Keluar</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Transaksi</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item me-2">
                        <a href="javascript:void(0)"><i class="bx bx-package"></i></a>
                    </li>
                    <li> Transaksi Bahan Baku Keluar</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Transaksi Bahan Baku Keluar</h5>
                    </div>
                    <a href="{{ route('transaksi_keluar.create') }}" class="btn btn-primary px-3">
                        <i class="bx bx-plus me-1"></i>Transaksi Keluar
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Penerima</th>
                                <th width="10%">Suplier</th>
                                <th width="10%">Bahan Baku</th>
                                <th width="10%">Stok Keluar</th>
                                <th width="10%">Tanggal Keluar</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksiKeluars as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->penerima }}</td>
                                    <td>{{ $item->suplier->nama }}</td>
                                    <td>{{ $item->bahanBaku->nama }}</td>
                                    <td class="text-end">{{ $item->stok }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>

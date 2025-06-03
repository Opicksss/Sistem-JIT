<x-layout>
    <x-slot:title>Sisa</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Laporan Sisa</div>
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Sisa</h5>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="10%">ID Transaksi</th>
                                <th width="20%">Penerima</th>
                                <th width="10%">Stok masuk</th>
                                <th width="10%">Stok keluar</th>
                                <th width="10%">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>{{ $transaksiKeluar->id_transaksi }}</td>
                            <td>{{ $transaksiKeluar->penerima }}</td>
                            <td>{{ $transaksiKeluar->stok_awal }}</td>
                            <td>{{ $transaksiKeluar->stok }}</td>
                            <td>{{ $transaksiKeluar->sisa }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>

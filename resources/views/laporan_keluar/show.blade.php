<x-layout>
    <x-slot:title>Detail Transaksi Keluar</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Detail Transaksi Keluar</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Laporan Transaksi Bahan Baku Keluar</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item me-2">
                        <a href="javascript:void(0)"><i class="bx bx-package"></i></a>
                    </li>
                    <li> Detail Laporan Bahn Baku Keluar</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Transaksi Bahan Baku Keluar</h5>
                    </div>

                    <div>
                        <a href="{{ route('detail_laporan_keluar.print', $transaksiKeluar->id) }}" target="_blank"
                            class="btn btn-outline-secondary me-2" title="Cetak">
                            <i class="bx bx-printer"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="20%">ID Transaksi</th>
                        <td>: {{ $transaksiKeluar->id_transaksi }}</td>
                    </tr>
                    <tr>
                        <th width="20%">ID Suplier</th>
                        <td>: {{ $transaksiKeluar->suplier->id_suplier }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Penerima</th>
                        <td>: {{ $transaksiKeluar->penerima }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Nama Suplier</th>
                        <td>: {{ $transaksiKeluar->suplier->nama }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Alamat</th>
                        <td>: {{ $transaksiKeluar->suplier->alamat }}</td>
                    </tr>
                    <tr>
                        <th width="20%">No Telepon</th>
                        <td>: {{ $transaksiKeluar->suplier->telepon }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Kota</th>
                        <td>: {{ $transaksiKeluar->suplier->kota }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Provinsi</th>
                        <td>: {{ $transaksiKeluar->suplier->provinsi }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Tanggal Keluar</th>
                        <td>:
                            {{ \Carbon\Carbon::parse($transaksiKeluar->tanggal_keluar)->locale('id')->format('d M Y') }}
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">Detail Bahan Baku keluar</h6>
                    </div>



                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="10%" class="text-center">ID Bahan Baku</th>
                                <th width="20%">Bahan Baku</th>
                                <th width="10%" class="text-end">Stok keluar</th>
                                <th width="10%" class="text-end">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">{{ $transaksiKeluar->bahanBaku->id_bahan_baku }}</td>
                                <td>{{ $transaksiKeluar->bahanBaku->nama }}</td>
                                <td class="text-end">{{ $transaksiKeluar->stok }}</td>
                                <td class="text-end">{{ number_format($transaksiKeluar->stok * $transaksiKeluar->bahanBaku->harga, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total Stok keluar</th>
                                <th class="text-end">{{ $transaksiKeluar->stok }}</th>
                                <th class="text-end">{{ number_format($transaksiKeluar->stok * $transaksiKeluar->bahanBaku->harga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex justify-content-end align-items-center mb-3 gap-2">
                        <a href="{{ route('laporan_keluar.index') }}" class="btn btn-primary">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                        <a href="{{ route('detail_laporan_keluar.show_laporan_keluar_show', $transaksiKeluar->id) }}"
                            class="btn btn-warning">
                            <i class="bx bx-archive"></i> Sisa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

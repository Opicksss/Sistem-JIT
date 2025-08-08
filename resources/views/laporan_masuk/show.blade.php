<x-layout>
    <x-slot:title>Detail Transaksi Masuk</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Detail Transaksi Masuk</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Laporan Transaksi Bahan Baku Masuk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item me-2">
                        <a href="javascript:void(0)"><i class="bx bx-package"></i></a>
                    </li>
                    <li> Detail Laporan Bahn Baku Masuk</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Transaksi Bahan Baku Masuk</h5>
                    </div>
                    <div>
                        <a href="{{ route('detail_laporan_masuk.print', $transaksiMasuk->id) }}" target="_blank"
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
                        <td>: {{ $transaksiMasuk->id_transaksi }}</td>
                    </tr>
                    <tr>
                        <th width="20%">ID Suplier</th>
                        <td>: {{ $transaksiMasuk->suplier->id_suplier}}</td>
                    </tr>
                    <tr>
                        <th width="20%">Penerima</th>
                        <td>: {{ $transaksiMasuk->penerima }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Nama Suplier</th>
                        <td>: {{ $transaksiMasuk->suplier->nama }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Alamat</th>
                        <td>: {{ $transaksiMasuk->suplier->alamat }}</td>
                    </tr>
                    <tr>
                        <th width="20%">No Telepon</th>
                        <td>: {{ $transaksiMasuk->suplier->telepon }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Kota</th>
                        <td>: {{ $transaksiMasuk->suplier->kota }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Provinsi</th>
                        <td>: {{ $transaksiMasuk->suplier->provinsi }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Tanggal Masuk</th>
                        <td>: {{ \Carbon\Carbon::parse($transaksiMasuk->tanggal_masuk)->locale('id')->format('d M Y') }}</td>
                    </tr>
                </table>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">Detail Bahan Baku Masuk</h6>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="10%" class="text-center">ID Bahan Baku</th>
                                <th width="20%">Bahan Baku</th>
                                <th width="10%" class="text-end">Stok Masuk</th>
                                <th width="10%" class="text-end">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">{{ $transaksiMasuk->bahanBaku->id_bahan_baku }}</td>
                                <td>{{ $transaksiMasuk->bahanBaku->nama }}</td>
                                <td class="text-end">{{ $transaksiMasuk->stok }}</td>
                                <td class="text-end">{{ number_format($transaksiMasuk->stok * $transaksiMasuk->bahanBaku->harga, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total Stok Masuk</th>
                                <th class="text-end">{{ $transaksiMasuk->bahanBaku->stok }}</th>
                                <th class="text-end">{{ number_format($transaksiMasuk->bahanBaku->stok * $transaksiMasuk->bahanBaku->harga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                        </div>
                        <div>
                            <a href="{{ route('laporan_masuk.index') }}" class="btn btn-primary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

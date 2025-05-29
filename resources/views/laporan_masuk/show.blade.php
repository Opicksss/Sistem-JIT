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

                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="20%" >ID Transaksi</th>
                        <td>: {{ $transaksiMasuk->id_transaksi }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >ID Suplier</th>
                        <td>: {{ $transaksiMasuk->suplier_id }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Penerima</th>
                        <td>: {{ $transaksiMasuk->penerima }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Nama Suplier</th>
                        <td>: {{ $transaksiMasuk->suplier->nama }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Alamat</th>
                        <td>: {{ $transaksiMasuk->suplier->alamat }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >No Telepon</th>
                        <td>: {{ $transaksiMasuk->suplier->telepon }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Kota</th>
                        <td>: {{ $transaksiMasuk->suplier->kota }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Provinsi</th>
                        <td>: {{ $transaksiMasuk->suplier->provinsi }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Tanggal Masuk</th>
                        <td>: {{ \Carbon\Carbon::parse($transaksiMasuk->tanggal)->format('d-m-Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</x-layout>

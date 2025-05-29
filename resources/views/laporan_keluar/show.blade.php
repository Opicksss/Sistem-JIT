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

                </div>
            </div>
            <div class="card-body">
                <table class="table" >
                    <tr>
                        <th width="20%" >ID Transaksi</th>
                        <td>: {{ $transaksiKeluar->id_transaksi }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >ID Suplier</th>
                        <td>: {{ $transaksiKeluar->suplier_id }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Penerima</th>
                        <td>: {{ $transaksiKeluar->penerima }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Nama Suplier</th>
                        <td>: {{ $transaksiKeluar->suplier->nama }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Alamat</th>
                        <td>: {{ $transaksiKeluar->suplier->alamat }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >No Telepon</th>
                        <td>: {{ $transaksiKeluar->suplier->telepon }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Kota</th>
                        <td>: {{ $transaksiKeluar->suplier->kota }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Provinsi</th>
                        <td>: {{ $transaksiKeluar->suplier->provinsi }}</td>
                    </tr>
                    <tr>
                        <th width="20%" >Tanggal Keluar</th>
                        <td>: {{ \Carbon\Carbon::parse($transaksiKeluar->tanggal)->format('d-m-Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</x-layout>

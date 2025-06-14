<x-layout>
    <x-slot:title>JIT</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Perencanaan produksi dengan metode JIT </div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">JIT</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item me-2">
                        <a href="javascript:void(0)"><i class="bx bx-package"></i></a>
                    </li>
                    <li> Master JIT</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $bahanBaku->nama }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body" enctype="multipart/form-data">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th style="width:5%;">No</th>
                                <th style="width:35%;">Keterangan</th>
                                <th style="width:30%;">Kondisi Aktual</th>
                                <th style="width:30%;"><em>Metode Just In Time</em></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Kebutuhan bahan baku periode {{ $tahun }} </td>
                                <td>{{ $D}} Kg</td>
                               <td>{{ $D }} Kg</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Kuantitas pemesanan yang optimal</td>
                                <td>{{ number_format($Q, 3, ',', '.') }} Kg</td>
                                <td>{{ number_format($Qn, 2, ',', '.') }} Kg</td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Frekuensi pemesanan per tahun periode 2024</td>
                                  <td>{{ $jumlahPemesanan ?? '-' }} Kali</td>
                                 <td>{{ $n}} Kali</td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Jumlah pengiriman yang optimal setiap kali pesan</td>
                                <td>{{ $D }} Kg</td>
                                 <td>{{ number_format($q, 3, ',', '.') }} Kg</td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Frekuensi pengiriman per pesan</td>
                                <td>1 kali</td>
                                <td>{{ $na }} Kali</td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Total biaya persediaan periode {{ $tahun }}</td>
                                <td>Rp. {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($TIJ, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <h1>Menghitung kuantitas pemesanan bahan baku</h1>
                    <table class="table table-bordered table-striped align-middle text-center mt-4">
                        <thead class="table-secondary">
                            <tr>
                                <th>Total Biaya pesan</th>
                                <th>frekuensi</th>
                                <th>O</th>
                                <th>Q</th>
                                <th>T</th>
                                <th>a</th>
                                <th>Na</th>
                                <th>Qn</th>
                                <th>q</th>
                                <th>n</th>
                                <th>Biaya Persediaan</th>
                                <th>TIJ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $totalBiayaPemesanan ?? '-' }}</td>
                                <td>{{ $jumlahPemesanan ?? '-' }}</td>
                                <td>{{ number_format($O, 0, ',', '.') }}</td>
                                <td>{{ number_format($Q, 3, ',', '.') }}</td>
                                <td>{{ $T }}</td>
                                <td>{{ number_format($a, 3, ',', '.') }}</td>
                                <td>{{ $na }}</td>
                                <td>{{ number_format($Qn, 2, ',', '.') }}</td>
                                <td>{{ number_format($q, 3, ',', '.') }}</td>
                                <td>{{ $n}}</td>
                                <td>{{ $totalBiaya }}</td>
                                <td>{{ $TIJ }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h1>Biaya Pemesanan {{ $totalBiayaPemesanan }}</h1>
                    <h1>Biaya Penyimpanan {{ $totalBiayaPenyimpanan }}</h1> -->
                </div>
            </div>
        </div>
    </div>
    <style>
        @media (max-width: 767.98px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table th,
            .table td {
                white-space: nowrap;
                font-size: 14px;
            }
        }
    </style>
</x-layout>

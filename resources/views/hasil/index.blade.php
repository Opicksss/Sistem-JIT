<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Hasil Perhitugan JIT</title>
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet">
    <script src="assets/js/pace.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css">

    <!--plugins-->
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/metisMenu.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/mm-vertical.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/simplebar/css/simplebar.css">
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
    <!--bootstrap css-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!--main css-->
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="sass/main.css" rel="stylesheet">
    <link href="sass/dark-theme.css" rel="stylesheet">
    <link href="sass/blue-theme.css" rel="stylesheet">
    <link href="sass/semi-dark.css" rel="stylesheet">
    <link href="sass/bordered-theme.css" rel="stylesheet">
    <link href="sass/responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


</head>

<body>

    <!--start header-->
    <x-header></x-header>
    <!--end top header-->


    <x-sidebar></x-sidebar>
    <!--end sidebar-->

    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
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
                            <h5 class="mb-0">{{ $bahanBaku->nama }}</h5>

                            <form id="filterForm" method="GET" action="{{ route('hasil.index') }}"
                                class="d-flex gap-2 mb-0">
                                <select name="bahan_baku_id" id="bahan_baku_id" class="form-select form-select-sm"
                                    style="width: 200px">
                                    @foreach ($bahanBakuList as $b)
                                        <option value="{{ $b->id }}"
                                            {{ $b->id == $bahanBaku->id ? 'selected' : '' }}>
                                            {{ $b->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="tahun" id="tahun" class="form-select form-select-sm">
                                    @foreach ($tahunList as $t)
                                        <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>
                                            {{ $t }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
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
                                        <th style="width:30%;"><em>Efisiensi Presentase</em></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Kebutuhan bahan baku periode {{ $tahun }} </td>
                                        <td>{{ $D }} Kg</td>
                                        <td>{{ $D }} Kg</td>
                                        <td>{{ $frekuensi1 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Kuantitas pemesanan yang optimal</td>
                                        <td>{{ number_format($Q, 3, ',', '.') }} Kg</td> 
                                        <td>{{ number_format($Qn, 2, ',', '.') }} Kg</td> 
                                       <td>{{ $frekuensi2 < 0 ? '' : number_format($frekuensi2, 2, ',', '.') . '%' }}</td>

                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Frekuensi pemesanan per tahun periode {{ $tahun }}</td>
                                        <td>{{ $jumlahPemesanan ?? '-' }} Kali</td>
                                        <td>{{ $n }} Kali</td>
                                        <td>{{ $frekuensi3 < 0 ? ' ' : number_format($frekuensi3, 2, ',', '.') . '%' }}</td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Jumlah pengiriman yang optimal setiap kali pesan</td>
                                        <td>{{ $D }} Kg</td>
                                        <td>{{ number_format($q, 3, ',', '.') }} Kg</td>
                                        <td>{{ $frekuensi4 < 0 ? ' ' : number_format($frekuensi4, 2, ',', '.') . '%' }}</td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Frekuensi pengiriman per pesan</td>
                                        <td>1 kali</td>
                                        <td>{{ $na }} Kali</td>
                                        <td>{{ $frekuensi5 < 0 ? ' ' : number_format($frekuensi5, 2, ',', '.') . '%' }}</td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Total biaya persediaan periode {{ $tahun }}</td>
                                        <td>Rp. {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($TIJ, 0, ',', '.') }}</td>
                                        <td>{{ $frekuensi6 < 0 ? ' ' : number_format($frekuensi6, 2, ',', '.') . '%' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Frekuensi pemesanan tahun {{ $tahun }} </h5>
                        </div>
                    </div>
                    <div class="card-body" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="12">Bulan</th>
                                        <th rowspan="2" class="align-middle text-center">Total</th>
                                    </tr>
                                    <tr>
                                        @foreach ($bulanList as $bulan)
                                            <th>{{ $bulan }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($bulanPemesanan as $jumlah)
                                            <td>{{ $jumlah }}</td>
                                        @endforeach
                                        <td>{{ $n }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <!--end main wrapper-->

    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->

    <!--start footer-->
    <x-footer></x-footer>
    <!--end footer-->



    <!--bootstrap js-->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="assets/plugins/notifications/js/notifications.min.js"></script>

    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <!--plugins-->
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/plugins/metismenu/metisMenu.min.js"></script>
    <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/peity/jquery.peity.min.js"></script>

    <script src="assets/js/main.js"></script>

    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.getElementById('tahun').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('bahan_baku_id').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    </script>

    <x-script></x-script>


</body>

</html>

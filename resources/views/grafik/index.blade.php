<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Grafik Transaksi Masuk</title>
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
            <div class="mb-3 text-uppercase breadcrumb-title">Grafik Transaksi</div>
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Grafik Transaksi</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item me-2">
                                <a href="javascript:void(0)"><i class='bx bx-line-chart'></i></a>
                            </li>
                            <li>Tampilan Grafik Transaksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="page-content">
                <div class="col-12 col-xl-12">
                    <div class="card rounded-4">
                        <div class="card-header py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">Transaksi Masuk</h5>
                                <select id="tahun-masuk" class="form-select form-select-sm mb-3" style="width: 200px">
                                    @foreach ($tahunMasukList as $tahun)
                                        <option value="{{ $tahun }}"
                                            {{ $tahun == $tahunMasukTerpilih ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <div class="col-12 col-xl-12">
                    <div class="card rounded-4">
                        <div class="card-header py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">Transaksi Keluar</h5>
                                <select id="tahun-keluar" class="form-select form-select-sm mb-3" style="width: 200px">
                                    @foreach ($tahunKeluarList as $tahun)
                                        <option value="{{ $tahun }}"
                                            {{ $tahun == $tahunKeluarTerpilih ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart2"></div>
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
        // Ambil tahun dari dropdown, lalu reload dengan query string baru
        document.getElementById('tahun-masuk').addEventListener('change', function() {
            const tahunMasuk = this.value;
            const tahunKeluar = document.getElementById('tahun-keluar').value;
            window.location.href = `?tahun_masuk=${tahunMasuk}&tahun_keluar=${tahunKeluar}`;
        });
        document.getElementById('tahun-keluar').addEventListener('change', function() {
            const tahunMasuk = document.getElementById('tahun-masuk').value;
            const tahunKeluar = this.value;
            window.location.href = `?tahun_masuk=${tahunMasuk}&tahun_keluar=${tahunKeluar}`;
        });

        // Chart Transaksi Masuk
        var optionsMasuk = {
            series: [{
                name: "Stok Masuk",
                data: @json($dataMasuk)
            }],
            chart: {
                foreColor: "#9ba7b2",
                height: 350,
                type: 'area',
                toolbar: { show: false },
            },
            dataLabels: { enabled: false },
            stroke: { width: 4, curve: 'smooth' },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ['#28a745'],
                    shadeIntensity: 1,
                    type: 'vertical',
                    opacityFrom: 0.8,
                    opacityTo: 0.1,
                    stops: [0, 100, 100, 100]
                },
            },
            colors: ["#28a745"],
            grid: { show: true, borderColor: 'rgba(0, 0, 0, 0.15)', strokeDashArray: 4 },
            tooltip: { theme: "dark" },
            xaxis: { categories: @json($namaBulan) },
            markers: { show: false, size: 5 },
        };
        var chartMasuk = new ApexCharts(document.querySelector("#chart1"), optionsMasuk);
        chartMasuk.render();

        // Chart Transaksi Keluar
        var optionsKeluar = {
            series: [{
                name: "Stok Keluar",
                data: @json($dataKeluar)
            }],
            chart: {
                foreColor: "#9ba7b2",
                height: 350,
                type: 'area',
                toolbar: { show: false },
            },
            dataLabels: { enabled: false },
            stroke: { width: 4, curve: 'smooth' },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ['#dc3545'],
                    shadeIntensity: 1,
                    type: 'vertical',
                    opacityFrom: 0.8,
                    opacityTo: 0.1,
                    stops: [0, 100, 100, 100]
                },
            },
            colors: ["#dc3545"],
            grid: { show: true, borderColor: 'rgba(0, 0, 0, 0.15)', strokeDashArray: 4 },
            tooltip: { theme: "dark" },
            xaxis: { categories: @json($namaBulan) },
            markers: { show: false, size: 5 },
        };
        var chartKeluar = new ApexCharts(document.querySelector("#chart2"), optionsKeluar);
        chartKeluar.render();
    </script>

</body>
</html>

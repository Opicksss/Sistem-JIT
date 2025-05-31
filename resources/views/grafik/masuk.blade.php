<x-layout>
    <x-slot:title>Grafik Transaksi Masuk</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Grafik Transaksi Masuk </div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Grafik Transaksi Masuk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item me-2">
                        <a href="javascript:void(0)"><i class='bx bx-line-chart' ></i></a>
                    </li>
                    <li>Tampilan Grafik Transaksi Masuk</li>
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

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart1"></div>
                    </div>
                </div>
            </div>
    </div>
</x-layout>

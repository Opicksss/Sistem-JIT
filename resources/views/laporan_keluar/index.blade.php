<x-layout>
     <x-slot:title>Laporan Transaksi Keluar</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">DAFTAR LAPORAN BAHAN BAKU Keluar</div>
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Laporan</h5>
                    </div>
                   
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Transaksi</th>
                                <th width="20%">Penerima</th>
                                <th width="10%">Tanggal Keluar</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksiKeluar as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->id_transaksi }}</td>
                                    <td>{{ $item->penerima }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->locale('id')->format('d M Y') }}</td>
                                    <td class="text-center">
                                         <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('detail_laporan_keluar.show', $item->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bx bx-show"></i> 
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>

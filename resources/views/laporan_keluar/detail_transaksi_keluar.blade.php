<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Transaksi Keluar</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3>Detail Transaksi Bahan Baku Keluar</h3>

    <table>
        <tr><th>ID Transaksi</th><td>{{ $transaksiKeluar->id_transaksi }}</td></tr>
        <tr><th>ID Suplier</th><td>{{ $transaksiKeluar->suplier->id_suplier }}</td></tr>
        <tr><th>Penerima</th><td>{{ $transaksiKeluar->penerima }}</td></tr>
        <tr><th>Nama Suplier</th><td>{{ $transaksiKeluar->suplier->nama }}</td></tr>
        <tr><th>Alamat</th><td>{{ $transaksiKeluar->suplier->alamat }}</td></tr>
        <tr><th>No Telepon</th><td>{{ $transaksiKeluar->suplier->telepon }}</td></tr>
        <tr><th>Kota</th><td>{{ $transaksiKeluar->suplier->kota }}</td></tr>
        <tr><th>Provinsi</th><td>{{ $transaksiKeluar->suplier->provinsi }}</td></tr>
        <tr><th>Tanggal Keluar</th><td>{{ \Carbon\Carbon::parse($transaksiKeluar->tanggal)->locale('id')->format('d M Y') }}</td></tr>
    </table>

    <h4 style="margin-top: 20px;">Detail Bahan Baku Keluar</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Bahan Baku</th>
                <th>Nama Bahan Baku</th>
                <th>Stok Keluar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $transaksiKeluar->bahanBaku->id_bahan_baku }}</td>
                <td>{{ $transaksiKeluar->bahanBaku->nama }}</td>
                <td>{{ $transaksiKeluar->stok }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total Stok Keluar</th>
                <th>{{ $transaksiKeluar->bahanBaku->stok }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>

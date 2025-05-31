<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Transaksi Masuk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3>Detail Transaksi Bahan Baku Masuk</h3>

    <table>
        <tr><th>ID Transaksi</th><td>{{ $transaksiMasuk->id_transaksi }}</td></tr>
        <tr><th>ID Suplier</th><td>{{ $transaksiMasuk->suplier->id_suplier }}</td></tr>
        <tr><th>Penerima</th><td>{{ $transaksiMasuk->penerima }}</td></tr>
        <tr><th>Nama Suplier</th><td>{{ $transaksiMasuk->suplier->nama }}</td></tr>
        <tr><th>Alamat</th><td>{{ $transaksiMasuk->suplier->alamat }}</td></tr>
        <tr><th>No Telepon</th><td>{{ $transaksiMasuk->suplier->telepon }}</td></tr>
        <tr><th>Kota</th><td>{{ $transaksiMasuk->suplier->kota }}</td></tr>
        <tr><th>Provinsi</th><td>{{ $transaksiMasuk->suplier->provinsi }}</td></tr>
        <tr><th>Tanggal Masuk</th><td>{{ \Carbon\Carbon::parse($transaksiMasuk->tanggal_masuk)->locale('id')->format('d M Y') }}</td></tr>
    </table>

    <h4 style="margin-top: 20px;">Detail Bahan Baku Masuk</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Bahan Baku</th>
                <th>Nama Bahan Baku</th>
                <th>Stok Masuk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $transaksiMasuk->bahanBaku->id_bahan_baku }}</td>
                <td>{{ $transaksiMasuk->bahanBaku->nama }}</td>
                <td>{{ $transaksiMasuk->stok }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total Stok Masuk</th>
                <th>{{ $transaksiMasuk->bahanBaku->stok }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Buku</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 18px; text-align: center; margin-bottom: 5px; }
        h2 { font-size: 14px; text-align: center; font-weight: normal; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h1>LAPORAN DATA BUKU PERPUSTAKAAN</h1>
    <h2>Per Tanggal {{ date('d M Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th style="text-align:center">Total Stok</th>
                <th style="text-align:center">Tersedia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->kode_buku }}</td>
                <td>{{ $book->judul }}</td>
                <td>{{ $book->category->nama_kategori ?? '-' }}</td>
                <td style="text-align:center">{{ $book->jumlah }}</td>
                <td style="text-align:center">{{ $book->tersedia }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
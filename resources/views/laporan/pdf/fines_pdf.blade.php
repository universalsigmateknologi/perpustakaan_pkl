<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Denda</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 18px; text-align: center; margin-bottom: 5px; }
        h2 { font-size: 14px; text-align: center; font-weight: normal; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .total { margin-top: 20px; text-align: right; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>LAPORAN KEUANGAN DENDA</h1>
    <h2>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Denda</th>
                <th>Anggota</th>
                <th>Tgl Bayar</th>
                <th style="text-align:right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fines as $fine)
            <tr>
                <td>{{ $fine->kode_denda }}</td>
                <td>{{ $fine->member->nama }}</td>
                <td>{{ $fine->tanggal_bayar }}</td>
                <td style="text-align:right">Rp {{ number_format($fine->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
</body>
</html>
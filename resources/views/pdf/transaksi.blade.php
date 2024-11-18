<!DOCTYPE html>
<html>

<head>
    <title>Transaksi {{ $blth }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            margin-left: auto;
            margin-right: auto;
            width: 70%;
            max-width: 70%; /* Menjaga tabel tidak lebih dari lebar halaman */
            border-collapse: collapse;
            word-wrap: break-word; /* Mengatur pemotongan kata untuk teks panjang */
            table-layout: auto; /* Memungkinkan tabel mengatur lebar kolom otomatis */
            position: center;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            word-wrap: break-word; /* Membungkus teks agar sesuai */
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        /* Mengatur agar halaman memiliki margin */
        @page {
            margin: 20px;
        }

        /* Mengurangi padding pada kolom untuk menghindari overflow */
        th, td {
            padding: 6px;
        }

        /* Mengatur agar kolom tidak terlalu sempit */
        th:nth-child(1), td:nth-child(1) { width: 5%; } /* Kolom ID */
        th:nth-child(2), td:nth-child(2) { width: 8%; } /* Kolom BLTH */
        th:nth-child(3), td:nth-child(3) { width: 8%; } /* Kolom Kode */
        th:nth-child(4), td:nth-child(4),
        th:nth-child(5), td:nth-child(5),
        th:nth-child(6), td:nth-child(6),
        th:nth-child(7), td:nth-child(7),
        th:nth-child(8), td:nth-child(8),
        th:nth-child(9), td:nth-child(9) { width: 8%; } /* Kolom lainnya */
        th:nth-child(10), td:nth-child(10) { width: 12%; } /* Kolom Kapasitas Produksi */
    </style>
</head>

<body>
    <h1>{{ $judul }}</h1>
    <table>
        <thead>
            <tr>
                <th>BLTH</th>
                <th>Nama Sumber</th>
                <th>Jam Operasional</th>
                <th>Liter</th>
                <th>Produksi</th>
                <th>Distribusi</th>
                <th>Flushing</th>
                <th>Spey</th>
                <th>Kapasitas Produksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->blth }}</td>
                    <td>{{ $transaksi->sumber->nama_sumber }}</td>
                    <td>{{ $transaksi->jam_operasional }}</td>
                    <td>{{ $transaksi->liter }}</td>
                    <td>{{ $transaksi->produksi }}</td>
                    <td>{{ $transaksi->distribusi }}</td>
                    <td>{{ $transaksi->flushing }}</td>
                    <td>{{ $transaksi->spey }}</td>
                    <td>{{ number_format($transaksi->kapasitas_produksi) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" style="text-align: right;"><strong>Total Kapasitas Produksi:</strong></td>
                <td>{{ number_format($totalKapasitasProduksi) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>

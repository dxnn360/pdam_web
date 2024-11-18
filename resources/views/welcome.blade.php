@extends('layouts.app')

@section('title', 'Halaman Utama')

@section('content')
<div class="container mb-3 mx-2 ">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="my-1">Dashboard</h2>
            <h2 class="mb-5">Distribusi Kapasitas Produksi</h2>
            <div class="row mt-4">
                <!-- Card Total Kapasitas Produksi -->

                <div class="col-md-4">
                    <a href="{{ route('transaksi.create') }}">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">Total Kapasitas Produksi</div>
                            <div class="card-body mb-3">
                                <h2 class="card-title">{{ number_format($totalKapasitasProduksi, 0) }} Liters</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ route('transaksi.create') }}">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body">Total Produksi Bulan Ini</div>
                            <div class="card-body mb-3">
                                <h2 class="card-title">{{ number_format($totalKapasitasProduksiBulanIni, 0) }} Liters</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card Jumlah Sumber -->
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">Jumlah Sumber</div>
                        <div class="card-body mb-3">
                            <h2 class="card-title">{{$jumlahSumber}} Sumber</h2>
                        </div>
                    </div>
                </div>

                <!-- Grafik Kapasitas Produksi -->
                <div class="container mt-4">
                    <h2 class="mb-4">Grafik Kapasitas Produksi per Bulan</h2>
                    <canvas id="productionChart" width="400" height="85"></canvas>
                </div>

            </div>

            <h2 class="mb-4 mt-4 pt-2">List Transaksi</h2>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">Tambahkan Transaksi Baru</a>

            <form action="{{ route('filter.by.blth') }}" method="GET">
                <select name="blth" class="form-select form-select-sm" style="width=100px"
                    onchange="this.form.submit()">
                    <option value="">Pilih Bulan/Tahun</option>
                    @foreach($listBlth as $blthOption)
                        <option value="{{ $blthOption }}" {{ $blthOption == $blth ? 'selected' : '' }}>
                            {{ $blthOption }}
                        </option>
                    @endforeach
                </select>
                @if($blth)
                    <div class="my-3 d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('download.pdf', $blth) }}" class="btn btn-outline-danger btn-sm mx-2">Download
                            PDF</a>
                        <a href="{{ route('download.excel', $blth) }}" class="btn btn-outline-success btn-sm">Download
                            Excel</a>
                    </div>
                @endif
            </form>
            <!-- Tabel Transaksi -->
            <table id="transaksiTable" class="table table-striped text-center pb-2">
                <thead class="thead">
                    <tr>
                        <th class="text-center">BLTH</th>
                        <th class="text-center">Sumber</th>
                        <th class="text-center">Jam Operasional</th>
                        <th class="text-center">Liter</th>
                        <th class="text-center">Kapasitas Produksi</th>
                        <th class="text-center">Produksi</th>
                        <th class="text-center">Distribusi</th>
                        <th class="text-center">Flushing</th>
                        <th class="text-center">Spey</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $transaksi)
                        <tr>
                            <td class="text-center">{{ $transaksi->blth }}</td>
                            <td class="text-center">{{ $transaksi->sumber->nama_sumber }}</td>
                            <td class="text-center">{{ $transaksi->jam_operasional }}</td>
                            <td class="text-center">{{ $transaksi->liter }}</td>
                            <td class="text-center">{{ number_format($transaksi->kapasitas_produksi, 0) }}</td>
                            <td class="text-center">{{ $transaksi->produksi }}</td>
                            <td class="text-center">{{ $transaksi->distribusi }}</td>
                            <td class="text-center">{{ $transaksi->flushing }}</td>
                            <td class="text-center">{{ $transaksi->spey }}</td>
                            <td class="text-center">
                                <a href="{{ route('transaksi.edit', $transaksi->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ url('/transaksi/' . $transaksi->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <thead class="text-start">
                    <th colspan="4">Total Kapasitas Produksi: </th>
                    <th class="text-center">{{ number_format($totalKapasitasProduksi, 0) }}</th>
                    <th colspan="5"></th>
                </thead>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari server
    const labels = @json($labels);
    const data = @json($values);

    // Format data untuk chart
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Kapasitas Produksi (Liter)',
            data: data,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235)',
            borderWidth: 1
        }]
    };

    // Konfigurasi chart
    const config = {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return `Kapasitas Produksi: ${tooltipItem.raw} Liter`;
                        }
                    }
                }
            }
        }
    };

    // Buat chart
    const ctx = document.getElementById('productionChart').getContext('2d');
    new Chart(ctx, config);
</script>
@endsection
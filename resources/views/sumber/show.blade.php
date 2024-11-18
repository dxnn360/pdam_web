@extends('layouts.app')

@section('title', 'Detail Sumber')

@section('content')
<div class="container mb-6">
    <div class="row">
        <div class="col-lg-12">
            <div class="container my-3"></div>
            <h2 class="my-2">Detail Sumber</h2>
            <h2>{{ $sumber->nama_sumber }}</h2>

            <div class="row mt-4">
                <!-- Card Total Kapasitas Produksi Keseluruhan -->
                <div class="col-md-6">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <p class="card-title">Total Kapasitas Produksi Keseluruhan</p>
                            <h2 class="card-body">{{ number_format($totalKapasitasProduksi, 0) }} Liters</h2>
                        </div>
                    </div>
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <p class="card-title">Kapasitas Produksi Bulan Ini</p>
                            <h2 class="card-body">{{ number_format($kapasitasProduksiBulanIni, 0) }} Liters</h2>
                        </div>
                    </div>
                </div>

                <!-- Card Kapasitas Produksi Bulanan -->
                <div class="col-md-6">
                    <div class="card text-black bg-light mb-3">
                        <div class="card-body">
                            <canvas id="monthlyProductionChart" width="400" height="260"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Tabel Transaksi -->
                <h3 class="my-4">List Transaksi</h3>
                <div class="table-responsive mb-3">
                    <table id="transaksiTable" class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>BLTH</th>
                                <th>Jam Operasional</th>
                                <th>Liter</th>
                                <th>Kapasitas Produksi</th>
                                <th>Produksi</th>
                                <th>Distribusi</th>
                                <th>Flushing</th>
                                <th>Spey</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->blth }}</td>
                                    <td>{{ $transaksi->jam_operasional }}</td>
                                    <td>{{ $transaksi->liter }}</td>
                                    <td>{{ number_format($transaksi->kapasitas_produksi, 0) }}</td>
                                    <td>{{ $transaksi->produksi }}</td>
                                    <td>{{ $transaksi->distribusi }}</td>
                                    <td>{{ $transaksi->flushing }}</td>
                                    <td>{{ $transaksi->spey }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari server
    const labels = {!! json_encode($bulanProduksi->keys()->toArray()) !!};
    const data = {!! json_encode($bulanProduksi->values()->toArray()) !!};
    // Format data untuk chart
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Kapasitas Produksi Bulanan (Liter)',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
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
            },
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Buat chart
    const ctx = document.getElementById('monthlyProductionChart').getContext('2d');
    new Chart(ctx, config);


    console.log("Labels:", {!! json_encode($bulanProduksi->keys()->toArray()) !!});
    console.log("Data:", {!! json_encode($bulanProduksi->values()->toArray()) !!});

</script>
@endsection
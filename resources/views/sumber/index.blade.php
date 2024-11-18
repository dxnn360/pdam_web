@extends('layouts.app')

@section('title', 'Sumber')

@section('content')
<div class="container my-5 justify-content-center">
    <h2 class="mb-4">List Sumber</h2>

    <a href="{{ route('sumber.create') }}" class="btn btn-primary mb-3">Tambahkan Sumber Baru</a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table id="sumberTable" class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Nama Sumber</th>
                    <th>Kode</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sumbers as $sumber)
                    <tr>
                        <td>{{ $sumber->nama_sumber }}</td>
                        <td>{{ $sumber->kode }}</td>
                        <td>
                            @if ($sumber->status == 0)
                                <span class="badge bg-danger">Nonaktif</span>
                            @elseif($sumber->status == 1)
                                <span class="badge bg-success">Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('sumber.show', $sumber->id) }}" class="btn btn-info btn-sm me-2">Lihat
                                Detail</a>
                            <a href="{{ route('sumber.edit', $sumber->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="{{ route('sumber.changeStatus', $sumber->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm me-2">Ubah Status</button>
                            </form>
                            <form action="{{ route('sumber.destroy', $sumber->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container mt-4">
        <h2 class="mb-4">Grafik Total Kapasitas Produksi per Sumber</h2>
        <canvas id="productionChart" width="300" height="100"></canvas>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari server (diubah ke format array JavaScript)
    const labels = @json($totalKapasitasProduksi->pluck('nama_sumber'));
    const data = @json($totalKapasitasProduksi->pluck('total_produksi'));
    var colors = ["red", "green","blue","orange","brown", "black", "beige"];

    // Membuat grafik menggunakan Chart.js
    const ctx = document.getElementById('productionChart').getContext('2d');
    const productionChart = new Chart(ctx, {
        type: 'bar', // Bisa diganti dengan 'line', 'pie', dll.
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Kapasitas Produksi',
                data: data,
                backgroundColor: colors,
                borderColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Total Kapasitas Produksi per Sumber'
                }
            }
        }
    });
</script>

@endsection
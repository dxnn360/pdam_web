@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container mb-3">

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

    <h2 class="mb-1  pt-2">List Transaksi</h2>
    <h2 class="mb-4">
        @if($blth)
            {{ $judulTanggal }}
        @else
            {{$judulBulanIni}}
        @endif
    </h2>

    <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">Tambahkan Transaksi Baru</a>

    <form action="{{ route('filter.by.blth') }}" method="GET">
        <select name="blth" class="form-select form-select-sm" style="width=100px" onchange="this.form.submit()">
            <option value="{{ $blth }}" selected>Pilih Bulan/Tahun</option>
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
        @else
            <div class="my-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('download.pdf', $bulanIni) }}" class="btn btn-outline-danger btn-sm mx-2">Download
                    PDF</a>
                <a href="{{ route('download.excel', $bulanIni) }}" class="btn btn-outline-success btn-sm">Download
                    Excel</a>
            </div>
        @endif
    </form>
    <!-- Tabel Transaksi -->
    <table id="transaksiTable" class="table table-striped text-center pb-2">
        <thead class="thead text-center">
            <tr>
                <th class="text-center">BLTH</th>
                <th class="text-center">Sumber</th>
                <th class="text-center">Jam Operasional</th>
                <th class="text-center">Liter</th>
                <th class="text-center">Kapasitas Produksi</th>
                <th class="text-center">Produksi</th>
                <th>Distribusi</th>
                <th>Flushing</th>
                <th>Spey</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksismonth as $transaksi)
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
                    <td>
                        <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ url('/transaksi/' . $transaksi->id) }}" method="POST" style="display:inline;">
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
            }
        }
    };

    // Buat chart
    const ctx = document.getElementById('productionChart').getContext('2d');
    new Chart(ctx, config);
</script>
@endsection
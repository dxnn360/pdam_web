@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Tambah Transaksi Baru</h1>
    @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="blth" class="form-label">BLTH:</label>
            <select name="blth" id="blth" class="form-select" aria-hidden="false" aria-modal="true">
                @foreach ($blthOptions as $blth)
                    <option value="{{ $blth }}">{{ $blth}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kode" class="form-label">Sumber:</label>
            <select name="kode" id="sumber" class="form-select" required>
                @foreach ($availSumber as $sumber)
                    <option value="{{ $sumber->kode }}">{{ $sumber->nama_sumber }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jam_operasional" class="form-label">Jam Operasional:</label>
            <input type="number" name="jam_operasional" id="jam_operasional" class="form-control"
                placeholder="Enter Operational Hours" min="1" max="24" required>
        </div>

        <div class="mb-3">
            <label for="liter" class="form-label">Liter:</label>
            <input type="number" name="liter" id="liter" class="form-control" placeholder="Enter Amount of Liters"
                min="1" required>
        </div>

        <div class="mb-3">
            <label for="produksi" class="form-label">Produksi:</label>
            <input type="number" name="produksi" id="produksi" class="form-control"
                placeholder="Enter Amount of Production" min="1" required>
        </div>

        <div class="mb-3">
            <label for="distribusi" class="form-label">Distribusi:</label>
            <input type="number" name="distribusi" id="distribusi" class="form-control"
                placeholder="Enter Amount of Distribution" min="1" required>
        </div>

        <div class="mb-3">
            <label for="flushing" class="form-label">Flushing:</label>
            <input type="number" name="flushing" id="flushing" class="form-control"
                placeholder="Enter Amount of Flushing" min="1" required>
        </div>

        <div class="mb-3">
            <label for="spey" class="form-label">Spey:</label>
            <input type="number" name="spey" id="spey" class="form-control" placeholder="Enter Amount of Spey" min="1"
                required>
        </div>

        <button type="submit" class="btn btn-primary my-2 rounded-0">Tambahkan Transaksi</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#blth').change(function() {
        var blth = $(this).val();
        $.ajax({
            url: "{{ route('getSumberByBlth') }}",
            type: "GET",
            data: { blth: blth },
            success: function(data) {
                var sumberSelect = $('#sumber');
                sumberSelect.empty();
                $.each(data, function(key, sumber) {
                    sumberSelect.append('<option value="' + sumber.kode + '">' + sumber.nama_sumber + '</option>');
                });
            },
            error: function() {
                alert('Failed to fetch sources!');
            }
        });
    });
});
</script>
@endsection
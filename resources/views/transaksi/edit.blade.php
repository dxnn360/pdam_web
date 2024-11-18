@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Edit Transaksi</h2>

    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="blth" class="form-label">BLTH</label>
            <input type="number" name="blth" id="blth" class="form-control" min="0" max="130000" value="{{ old('blth', $transaksi->blth) }}" disabled>
        </div>

        <div class="mb-3">
            <label for="kode" class="form-label">Nama Sumber</label>
            <select name="kode" id="kode" class="form-select" disabled>
                @foreach($sumbers as $sumber)
                    <option value="{{ $sumber->kode }}" {{ $transaksi->kode == $sumber->kode ? 'selected' : '' }}>
                        {{ $sumber->nama_sumber }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jam_operasional" class="form-label">Jam Operasional</label>
            <input type="number" name="jam_operasional" id="jam_operasional" min="1" max="24" class="form-control" value="{{ old('jam_operasional', $transaksi->jam_operasional) }}" required>
        </div>

        <div class="mb-3">
            <label for="liter" class="form-label">Liter</label>
            <input type="number" name="liter" id="liter" min="1" class="form-control" value="{{ old('liter', $transaksi->liter) }}" required>
        </div>

        <div class="mb-3">
            <label for="produksi" class="form-label">Produksi</label>
            <input type="number" name="produksi" id="produksi" min="1" class="form-control" value="{{ old('produksi', $transaksi->produksi) }}" required>
        </div>

        <div class="mb-3">
            <label for="distribusi" class="form-label">Distribusi</label>
            <input type="number" name="distribusi" id="distribusi" min="1" class="form-control" value="{{ old('distribusi', $transaksi->distribusi) }}" required>
        </div>

        <div class="mb-3">
            <label for="flushing" class="form-label">Flushing</label>
            <input type="number" name="flushing" id="flushing" min="1" class="form-control" value="{{ old('flushing', $transaksi->flushing) }}" required>
        </div>

        <div class="mb-3">
            <label for="spey" class="form-label">Spey</label>
            <input type="number" name="spey" id="spey" min="1" class="form-control" value="{{ old('spey', $transaksi->spey) }}" required>
        </div>

        <button type="submit" class="btn btn-primary btn-edit my-2 rounded-0">Update Transaksi</button>
    </form>
</div>
@endsection

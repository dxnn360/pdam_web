@extends('layouts.app')

@section('title', 'Tambah Sumber Baru')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Add New Sumber</h2>

    <form action="{{ route('sumber.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nama_sumber" class="form-label">Nama Sumber</label>
                <input type="text" name="nama_sumber" id="nama_sumber" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="kode" class="form-label">Kode</label>
                <input type="text" name="kode" id="kode" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary my-2 rounded-0">Add Sumber</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Sumber')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Edit Sumber</h2>

    <form action="{{ route('sumber.update', $sumber->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_sumber" class="form-label">Nama Sumber</label>
            <input type="text" name="nama_sumber" id="nama_sumber" class="form-control" value="{{ $sumber->nama_sumber }}" required>
        </div>

        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" name="kode" id="kode" class="form-control" value="{{ $sumber->kode }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="1" {{ $sumber->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $sumber->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-edit my-2 rounded-0">Update Sumber</button>
    </form>
</div>
@endsection

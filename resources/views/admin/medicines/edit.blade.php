@extends('adminlte::page')

@section('title', 'Edit Obat')

@section('content_header')
    <h1>Edit Obat</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Edit Obat</h3>
            </div>

            <form action="{{ route('admin.medicines.update', $medicine->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    <div class="form-group">
                        <label>Kode Obat</label>
                        <input type="text"
                               name="code"
                               value="{{ old('code', $medicine->code) }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Nama Obat</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $medicine->name) }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text"
                               name="category"
                               value="{{ old('category', $medicine->category) }}"
                               class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Satuan</label>
                        <input type="text"
                               name="unit"
                               value="{{ old('unit', $medicine->unit) }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $medicine->status == 1 ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="0" {{ $medicine->status == 0 ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('admin.medicines.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@stop

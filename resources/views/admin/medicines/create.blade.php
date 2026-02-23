@extends('adminlte::page')

@section('title', 'Tambah Obat')

@section('content_header')
    <h1>Tambah Obat</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Obat</h3>
                </div>

                <form action="{{ route('admin.medicines.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Kode Obat</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Nama Obat</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="category" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" name="unit" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

@stop

@extends('adminlte::page')

@section('title', 'Upload Master Obat')

@section('content_header')
    <h1>Upload Master Obat</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Upload File Excel</h3>
                </div>

                <form action="{{ route('admin.medicines.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label>File Excel</label>
                            <input type="file" name="file" class="form-control" required>
                            <small class="text-muted">
                                Format: xlsx, xls, csv
                            </small>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Upload
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

@stop

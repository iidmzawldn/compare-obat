@extends('adminlte::page')

@section('title', 'Upload Harga Obat')

@section('content_header')
    <h1>Upload Harga Obat</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Upload File Excel</h3>
            </div>

            <form action="{{ route('vendor.prices.upload') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file"
                               name="file"
                               class="form-control"
                               required>
                    </div>

                    <div class="alert alert-info">
                        <small>
                            - Gunakan template resmi<br>
                            - Jangan ubah kode obat<br>
                            - Harga wajib diisi<br>
                            - Upload ulang akan memperbarui harga lama
                        </small>
                    </div>

                </div>

                <div class="card-footer text-right">

                    <a href="{{ route('vendor.prices.index') }}"
                       class="btn btn-secondary">
                       Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Upload
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

@stop

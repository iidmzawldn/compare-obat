@extends('adminlte::page')

@section('title', 'Dashboard Vendor')

@section('content_header')
    <h1>Dashboard Vendor</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-4">
        <div class="small-box bg-primary">
            <div class="inner">
                <h4>Kelola Harga</h4>
                <p>Upload & Update Harga Obat</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-excel"></i>
            </div>
            <a href="{{ route('vendor.prices.index') }}"
               class="small-box-footer">
                Masuk <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

@stop

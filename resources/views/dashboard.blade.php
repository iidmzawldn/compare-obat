@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistem Pembanding Harga Obat</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>0</h3>
                    <p>Jumlah Obat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-pills"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>0</h3>
                    <p>Vendor Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Info</div>
        <div class="card-body">
            Selamat datang di sistem perbandingan harga vendor farmasi.
        </div>
    </div>
@stop

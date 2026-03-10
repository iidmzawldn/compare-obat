@extends('adminlte::page')

@section('title', 'Dashboard Vendor')

@section('content_header')
    <h1>Dashboard Vendor</h1>
@stop

@section('content')

    <div class="row">

        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $totalMedicines }}" text="Total Obat Aktif" icon="fas fa-pills" theme="info" />
        </div>

        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $totalPrices }}" text="Harga Sudah Diisi" icon="fas fa-file-excel"
                theme="success" />
        </div>

        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $notFilled }}" text="Belum Diisi" icon="fas fa-exclamation-triangle"
                theme="warning" />
        </div>

    </div>
@stop

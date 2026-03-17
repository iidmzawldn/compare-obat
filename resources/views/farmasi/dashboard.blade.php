@extends('adminlte::page')

@section('title', 'Dashboard Farmasi')

@section('content_header')
<h1>Dashboard Farmasi</h1>
@stop

@section('content')

<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalMedicines }}</h3>
                <p>Total Obat Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-pills"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalVendors }}</h3>
                <p>Total Vendor</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalPrices }}</h3>
                <p>Total Data Harga</p>
            </div>
            <div class="icon">
                <i class="fas fa-tags"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $medicineNoPrice }}</h3>
                <p>Obat Belum Ada Harga</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

</div>

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Update Harga Terbaru Vendor</h3>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Vendor</th>
                    <th>Harga</th>
                    <th>Update</th>
                </tr>
            </thead>

            <tbody>

                @forelse($recentPrices as $price)
                <tr>
                    <td>{{ $price->medicine->name }}</td>
                    <td>{{ $price->vendor->name }}</td>
                    <td>
                        Rp {{ number_format($price->final_price,0,',','.') }}
                    </td>
                    <td>
                        {{ $price->updated_at->format('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">
                        Belum ada data harga
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop
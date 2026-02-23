@extends('adminlte::page')

@section('title','Detail Compare')

@section('content_header')
    <h1>Compare Harga</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h5>
            {{ $medicine->name }} ({{ $medicine->code }})
        </h5>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prices as $index => $price)
                    <tr @if($index == 0) class="table-success" @endif>
                        <td>{{ $price->vendor->name }}</td>
                        <td>Rp {{ number_format($price->price,0,',','.') }}</td>
                        <td>{{ $price->discount ?? '-' }}</td>
                        <td>{{ $price->stock ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada vendor yang mengisi harga
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($prices->count() > 0)
            <div class="alert alert-success mt-3">
                Vendor termurah: 
                <strong>{{ $prices->first()->vendor->name }}</strong>
            </div>
        @endif

    </div>

</div>

@stop

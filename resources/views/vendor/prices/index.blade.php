@extends('adminlte::page')

@section('title', 'Harga Obat Saya')

@section('content_header')
    <h1>Harga Obat Saya</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Daftar Harga Obat</h3>

            <div>
                <a href="{{ route('vendor.prices.template') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Download Template
                </a>

                <a href="{{ route('vendor.prices.upload.form') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-upload"></i> Upload Harga
                </a>
            </div>
            <div>
                <form method="GET" action="{{ route('vendor.prices.index') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari kode atau nama obat...">

                    <div class="input-group-append">
                        <button class="btn btn-primary">
                            Cari
                        </button>
                    </div>
                </div>
            </form>
            </div>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th width="10%">Kode</th>
                        <th>Nama Obat</th>
                        <th width="15%">Harga</th>
                        <th width="10%">Diskon</th>
                        <th width="10%">Stok</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($prices ?? [] as $price)
                        <tr>
                            <td>{{ $price->medicine->code }}</td>
                            <td>{{ $price->medicine->name }}</td>
                            <td>
                                Rp {{ number_format($price->price, 0, ',', '.') }}
                            </td>
                            <td>
                                {{ $price->discount ?? '-' }}
                            </td>
                            <td>
                                {{ $price->stock ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data harga. Silakan upload terlebih dahulu.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>

        @if (isset($prices))
            <div class="card-footer">
                {{ $prices->links() }}
            </div>
        @endif

    </div>

@stop

@include('components.alert-toast')

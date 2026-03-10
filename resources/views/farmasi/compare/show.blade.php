@extends('adminlte::page')

@section('title', 'Detail Compare Harga')

@section('content_header')
    <h1>Compare Vendor</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-header">
            <h5>
                {{ $medicine->name }}
                <small class="text-muted">({{ $medicine->code }})</small>
            </h5>
            <div>
                Kategori: <b>{{ $medicine->category }}</b> |
                Satuan: <b>{{ $medicine->unit }}</b>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th width="80">Rank</th>
                            <th>Vendor</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Final Price</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($prices as $index => $price)
                            <tr class="{{ $index == 0 ? 'table-success' : '' }}">

                                <td>
                                    @if ($index == 0)
                                        🏆
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </td>

                                <td>
                                    <b>{{ $price->vendor->name }}</b>
                                </td>

                                <td>
                                    Rp {{ number_format($price->price, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $price->discount_percent }} %
                                </td>

                                <td>
                                    <b>
                                        Rp {{ number_format($price->final_price, 0, ',', '.') }}
                                    </b>
                                </td>

                                <td>
                                    {{ $price->updated_at->diffForHumans() }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada vendor yang upload harga
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            <a href="{{ route('farmasi.compare.index') }}" class="btn btn-secondary mt-3">
                Kembali
            </a>

        </div>

    </div>

@stop

@extends('adminlte::page')

@section('title', 'Compare Harga Obat')

@section('content_header')
    <h1>Compare Harga Obat</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-body">

            <form method="GET" class="row mb-3">

                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Search nama / kode obat">
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-control">

                        <option value="">-- Semua Kategori --</option>

                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary">Filter</button>
                </div>

            </form>

            <div class="row mb-3">
                <div class="col-md-3">
                    <a href="{{ route('farmasi.compare.export', request()->query()) }}" class="btn btn-success">

                        Export Compare Excel
                    </a>
                </div>
            </div>


            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="bg-primary">

                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Vendor Termurah</th>
                            <th>Harga Final</th>
                            <th>Total Vendor</th>
                            <th>Last Update</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($medicines as $medicine)
                            <tr>

                                <td>{{ $medicine->code }}</td>

                                <td>{{ $medicine->name }}</td>

                                <td>{{ $medicine->category }}</td>

                                <td>

                                    @if ($medicine->cheapest_vendor_id)
                                        @php
                                            $vendor = \App\Models\Vendor::find($medicine->cheapest_vendor_id);
                                        @endphp

                                        <span class="badge badge-success">
                                            {{ $vendor->name ?? '-' }}
                                        </span>
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>

                                    @if ($medicine->cheapest_price)
                                        <strong>
                                            Rp {{ number_format($medicine->cheapest_price, 0, ',', '.') }}
                                        </strong>
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>
                                    {{ $medicine->vendor_prices_count }}
                                </td>

                                <td>

                                    @if ($medicine->last_update)
                                        <small>
                                            {{ \Carbon\Carbon::parse($medicine->last_update)->diffForHumans() }}
                                        </small>
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('farmasi.compare.show', $medicine->id) }}"
                                        class="btn btn-sm btn-info">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-3">
                {{ $medicines->links() }}
            </div>

        </div>
    </div>

@stop

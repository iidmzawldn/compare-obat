@extends('adminlte::page')

@section('title','Compare Harga Obat')

@section('content_header')
    <h1>Compare Harga Obat</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form method="GET" action="{{ route('farmasi.compare.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Cari nama atau kode obat...">

                <div class="input-group-append">
                    <button class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
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
                                <a href="{{ route('farmasi.compare.show', $medicine->id) }}"
                                   class="btn btn-sm btn-primary">
                                   Lihat Vendor
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
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

@extends('adminlte::page')

@section('title', 'Master Obat')

@section('content_header')
    <h1>Master Obat</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Data Obat</h3>

            <form method="GET" class="form-inline">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm mr-2"
                    placeholder="Cari kode / nama obat">

                <button class="btn btn-sm btn-primary">Search</button>
            </form>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary btn-sm">
                    Tambah Obat
                </a>

                <a href="{{ route('admin.medicines.upload') }}" class="btn btn-warning btn-sm">
                    Upload Excel
                </a>

                <a href="{{ route('admin.medicines.template') }}" class="btn btn-success btn-sm">
                    Download Template
                </a>
            </div>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th width="100">Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($medicines as $medicine)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $medicine->code }}</td>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->category }}</td>
                            <td>{{ $medicine->unit }}</td>

                            <td>
                                @if ($medicine->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.medicines.destroy', $medicine->id) }}" method="POST"
                                    style="display:inline" class="form-delete">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Data obat belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $medicines->appends(request()->query())->links() }}
            </div>

        </div>
    </div>

@stop

@include('components.alert-toast')
@extends('adminlte::page')

@section('title', 'Vendor Management')

@section('content_header')
    <h1>Vendor Management</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Vendor</h3>
        </div>

        <div class="card-body">

            <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary mb-3">
                Tambah Vendor
            </a>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>User</th>
                        <th>Nama Vendor</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vendor->user->name ?? '-' }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->address }}</td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ $vendor->pic }}</td>
                            <td>
                                @if ($vendor->status == 1)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="mt-3 ml-3">
            {{ $vendors->links() }}
        </div>

    </div>

@stop

@include('components.alert-toast')

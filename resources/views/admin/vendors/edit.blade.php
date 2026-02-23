@extends('adminlte::page')

@section('title', 'Edit Vendor')

@section('content_header')
    <h1>Edit Vendor</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Vendor</h3>
                </div>

                <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- USER VENDOR --}}
                        <div class="form-group">
                            <label>User Vendor</label>
                            <select name="user_id" class="form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $vendor->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- NAMA VENDOR --}}
                        <div class="form-group">
                            <label>Nama Vendor</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $vendor->name) }}" required>
                        </div>

                        {{-- ALAMAT --}}
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ old('address', $vendor->address) }}</textarea>
                        </div>

                        {{-- TELEPON --}}
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $vendor->phone) }}" required>
                        </div>

                        {{-- PIC --}}
                        <div class="form-group">
                            <label>PIC (Penanggung Jawab)</label>
                            <input type="text" name="pic" class="form-control" value="{{ old('pic', $vendor->pic) }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ $vendor->status == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="0" {{ $vendor->status == 0 ? 'selected' : '' }}>
                                    Nonaktif
                                </option>
                            </select>
                        </div>


                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-warning">
                            Update Vendor
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@stop

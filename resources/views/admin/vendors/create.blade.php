@extends('adminlte::page')

@section('title', 'Tambah Vendor')

@section('content_header')
    <h1>Tambah Vendor</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Vendor</h3>
                </div>

                <form action="{{ route('admin.vendors.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        {{-- USER VENDOR --}}
                        <div class="form-group">
                            <label>User Vendor</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">-- Pilih User Vendor --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- NAMA VENDOR --}}
                        <div class="form-group">
                            <label>Nama Vendor</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        {{-- ALAMAT --}}
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                        </div>

                        {{-- TELEPON --}}
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>

                        {{-- PIC --}}
                        <div class="form-group">
                            <label>PIC (Penanggung Jawab)</label>
                            <input type="text" name="pic" class="form-control" value="{{ old('pic') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>


                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Simpan Vendor
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@stop

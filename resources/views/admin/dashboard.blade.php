@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1>Dashboard Admin</h1>
@stop

@section('content')

    {{-- =========================
    RINGKASAN DATA (CARDS)
    ========================= --}}
    <div class="row">

        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalMedicines }}</h3>
                    <p>Total Obat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-pills"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
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

        <div class="col-lg-4 col-6">
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

    </div>


    {{-- =========================
    SELISIH HARGA TERTINGGI
    ========================= --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Top 5 Selisih Harga Tertinggi</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Obat</th>
                        <th>Harga Tertinggi</th>
                        <th>Harga Terendah</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($priceDifferences as $item)
                        <tr>
                            <td>{{ $item->medicine->name ?? '-' }}</td>
                            <td>Rp {{ number_format($item->max_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->min_price, 0, ',', '.') }}</td>
                            <td class="text-danger font-weight-bold">
                                Rp {{ number_format($item->selisih, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- =========================
    RANKING VENDOR TERMURAH
    ========================= --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Top 5 Vendor Termurah (Rata-rata Harga)</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>Rata-rata Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendorRanking as $vendor)
                        <tr>
                            <td>{{ $vendor->vendor->name ?? '-' }}</td>
                            <td>Rp {{ number_format($vendor->avg_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- =========================
    GRAFIK JUMLAH OBAT PER VENDOR
    ========================= --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Distribusi Jumlah Obat per Vendor</h3>
        </div>
        <div class="card-body">
            <canvas id="vendorChart"></canvas>
        </div>
    </div>

@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('vendorChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($chartData as $data)
                        "{{ $data->vendor->name }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah Obat',
                    data: [
                        @foreach ($chartData as $data)
                            {{ $data->total_obat }},
                        @endforeach
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@stop

@extends('layouts/contentNavbarLayout')

@section('title', 'PA Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')

<!-- ROW 1: Year and Period Filter -->
<div class="row gy-4">
    <!-- Year Selection -->
    <div class="col-md-12 col-lg-2">
        <div>
            <div>
                <label for="tahunDropdown" class="form-label">Tahun - Periode</label>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">2024</button>
                <ul class="dropdown-menu" id="tahunDropdown">
                    <li><a class="dropdown-item" href="javascript:void(0);">2023</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">2022</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">2021</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<h5 class="pb-1 mb-4">Grafik Perbandingan</h5>

<!-- ROW 2: Graph -->
<div class="row gy-4">
    <div class="col-md-12">
        <div class="card h-100">
            <div class="card-header pb-0">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">{{ auth()->user()->userRole->id == 1 ? '-' : $kategori_pa[0] }}</button>
                    <ul class="dropdown-menu" id="kategoriList">
                        @foreach($kategori_pa as $kategori)
                        <li><a class="dropdown-item" href="javascript:void(0);" data-kategori="{{ $kategori }}">{{ $kategori }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <br>
            <div class="card-body">
                <div id="totalProfitLineChart" class="mb-3"></div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<h5 class="pb-1 mb-4">Kesimpulan</h5>

<!-- ROW 3: Table -->
<div class="row gy-4">
    <div class="col-12">
        <div class="card">
            <h5 class="card-header">Sebelum Revisi</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>A+</th>
                            <th>A</th>
                            <th>A-</th>
                            <th>B+</th>
                            <th>B</th>
                            <th>B-</th>
                            <th>C+</th>
                            <th>C</th>
                            <th>C-</th>
                            <th>D+</th>
                            <th>D</th>
                            <th>D-</th>
                            <th>E</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($data as $item)
                        <tr>
                            <th scope="row">
                                {{ $item['kategori_pa']}}
                            </th>
                            @php
                            $total = 0;
                            @endphp
                            @foreach ($item['jumlah'] as $jumlah)
                            <td>{{ $jumlah['nilai_awal_count'] }}</td>
                            @php
                            $total += $jumlah['nilai_awal_count'];
                            @endphp
                            @endforeach
                            <td>{{ $total }}</td>
                        </tr>
                        @endforeach

                        <!-- Row for 'Jumlah' -->
                        <tr>
                            <th scope="row">Jumlah</th>
                            @php
                            $totals = array_fill(0, 9, 0); // Initialize an array to hold column totals
                            @endphp
                            @foreach (['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'] as $index => $score)
                            @php
                            $columnTotal = $data->sum(function ($item) use ($score) {
                            return $item['jumlah']->firstWhere('nilai', $score)['nilai_awal_count'] ?? 0;
                            });
                            $totals[$index] = $columnTotal;
                            @endphp
                            <td>{{ $columnTotal }}</td>
                            @endforeach
                            <td>{{ array_sum($totals) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br>
<!-- ROW 4: Table -->
<div class="row gy-4">
    <div class="col-12">
        <div class="card">
            <h5 class="card-header">Sesudah Revisi</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>A+</th>
                            <th>A</th>
                            <th>A-</th>
                            <th>B+</th>
                            <th>B</th>
                            <th>B-</th>
                            <th>C+</th>
                            <th>C</th>
                            <th>C-</th>
                            <th>D+</th>
                            <th>D</th>
                            <th>D-</th>
                            <th>E</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($data as $item)
                        <tr>
                            <th scope="row">
                                {{ $item['kategori_pa']}}
                            </th>
                            @php
                            $total = 0;
                            @endphp
                            @foreach ($item['jumlah'] as $jumlah)
                            <td>{{ $jumlah['revisi_hod_count'] }}</td>
                            @php
                            $total += $jumlah['revisi_hod_count'];
                            @endphp
                            @endforeach
                            <td>{{ $total }}</td>
                        </tr>
                        @endforeach

                        <!-- Row for 'Jumlah' -->
                        <tr>
                            <th scope="row">Jumlah</th>
                            @php
                            $totals = array_fill(0, 9, 0); // Initialize an array to hold column totals
                            @endphp
                            @foreach (['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'] as $index => $score)
                            @php
                            $columnTotal = $data->sum(function ($item) use ($score) {
                            return $item['jumlah']->firstWhere('nilai', $score)['revisi_hod_count'] ?? 0;
                            });
                            $totals[$index] = $columnTotal;
                            @endphp
                            <td>{{ $columnTotal }}</td>
                            @endforeach
                            <td>{{ array_sum($totals) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

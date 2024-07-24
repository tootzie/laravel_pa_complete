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
            <label for="tahunDropdown" class="form-label">Tahun</label>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">2024</button>
                <ul class="dropdown-menu" id="tahunDropdown">
                <li><a class="dropdown-item" href="javascript:void(0);">2023</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">2022</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">2021</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Period Selection -->
    <div class="col-md-12 col-lg-2">
        <div>
            <label for="periodeDropdown" class="form-label">Periode</label>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">1: Jan-Jul</button>
                <ul class="dropdown-menu" id="periodeDropdown">
                <li><a class="dropdown-item" href="javascript:void(0);">2: Aug-Des</a></li>
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
            <h4 class="mb-0">$86.4k</h4>
          </div>
          <div class="card-body">
            <div id="totalProfitLineChart" class="mb-3"></div>
            <h6 class="text-center mb-0">Total Profit</h6>
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
                    <th>Total</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                    <th scope="row">Administrasi</th>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    </tr>
                    <tr>
                    <th scope="row">Produksi</th>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    </tr>
                    <tr>
                    <th scope="row">Jumlah</th>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
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
                    <th>Total</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                    <th scope="row">Administrasi</th>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    </tr>
                    <tr>
                    <th scope="row">Produksi</th>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    </tr>
                    <tr>
                    <th scope="row">Jumlah</th>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    <td>Table cell</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

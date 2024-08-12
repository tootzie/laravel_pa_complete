@extends('layouts/contentNavbarLayout')

@section('title', 'PA Detail Departement')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/company-detail.js')}}"></script>
@endsection

@section('content')
    <h3>Human Resource Department - PT Wings Surya</h3>
    <h6 class="pb-1 mb-4">Effendi Harsono</h3>

    <br>
    <!-- <br> -->
    <h5 class="pb-1 mb-4">Grafik Human Resource Department</h5>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card h-100">
            <div class="card-header pb-0">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">2024</button>
                    <ul class="dropdown-menu" id="tahunDropdown">
                    <li><a class="dropdown-item" href="javascript:void(0);">2023</a></li>
                    </ul>
                </div>
            </div>
            <br>
            <div class="card-body">
                <div id="totalProfitLineChart" class="mb-3"></div>
                <h6 class="text-center mb-0">Rata-rata: B+</h6>
            </div>

            </div>
        </div>
    </div>

    <br>
    <br>
    <h5 class="pb-1 mb-4">Perbandingan Nilai PA</h5>

    <!-- ROW 3: Table -->
    <div class="row gy-4">
        <div class="col-12">
            <div class="card">
                <!-- <h5 class="card-header">Perbandingan Nilai</h5> -->
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
                        <th scope="row">2023</th>
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
                        <th scope="row">2024</th>
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
    <br>
    <br>
    <h3 class="pb-1 mb-3">Cari Karyawan</h3>

    <!-- SEARCH BAR -->
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify"></i></span>
        <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
    </div>

    <br>

    <div class="row">
        <div class="col">
            <a href="{{ url('/company/employee') }}" class="card-link">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-1">
                            <div class="card-body">
                            <img class="card-img card-img-profile" src="{{asset('assets/img/elements/13.jpg')}}" alt="Card image" />
                            </div>
                        </div>
                        <div class="col-11">
                            <div class="card-body">
                                <p class="card-title-dark"><b>Jessica Clarensia S</b></p>
                                <p class="card-text">
                                HRIS
                                </p>
                                <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="{{ url('/company/employee') }}" class="card-link">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-1">
                            <div class="card-body">
                            <img class="card-img card-img-profile" src="{{asset('assets/img/elements/12.jpg')}}" alt="Card image" />
                            </div>
                        </div>
                        <div class="col-11">
                            <div class="card-body">
                                <p class="card-title-dark"><b>Jessica Clarensia S</b></p>
                                <p class="card-text">
                                HRIS
                                </p>
                                <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="{{ url('/company/employee') }}" class="card-link">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-1">
                            <div class="card-body">
                            <img class="card-img card-img-profile" src="{{asset('assets/img/elements/11.jpg')}}" alt="Card image" />
                            </div>
                        </div>
                        <div class="col-11">
                            <div class="card-body">
                                <p class="card-title-dark"><b>Jessica Clarensia S</b></p>
                                <p class="card-text">
                                HRIS
                                </p>
                                <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div>


@endsection

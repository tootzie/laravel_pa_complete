@extends('layouts/contentNavbarLayout')

@section('title', 'PA Detail Perusahaan')

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
    <h3>PT Wings Surya</h3>
    <h6 class="pb-1 mb-4">EMMA - Surabaya</h3>

    <br>
    <!-- <br> -->
    <h5 class="pb-1 mb-4">Grafik PT Wings Surya</h5>
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
    <h3 class="pb-1 mb-3">Cari Departemen</h3>

    <!-- SEARCH BAR -->
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify"></i></span>
        <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
    </div>

    <br>
    <br>

    <!-- DEPARTMENT CARD -->
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/company/department') }}" class="card-link">
                <div class="card bg-dark border-0 text-white mb-3">
                    <img class="overlay-img" src="{{asset('assets/img/departments/department1.jpg')}}" alt="Card image"/>
                    <div class="overlay-img-dark"></div>
                    <div class="card-company">
                        <h5 class="card-title">Human Resource Department</h5>
                        <p class="card-text">Effendi Harsono</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/company/department') }}" class="card-link">
                <div class="card bg-dark border-0 text-white mb-3">
                    <img class="overlay-img" src="{{asset('assets/img/departments/department2.jpg')}}" alt="Card image"/>
                    <div class="overlay-img-dark"></div>
                    <div class="card-company">
                        <h5 class="card-title">Accounting</h5>
                        <p class="card-text">John Doe</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/company/department') }}" class="card-link">
                <div class="card bg-dark border-0 text-white mb-3">
                    <img class="overlay-img" src="{{asset('assets/img/departments/department3.jpg')}}" alt="Card image"/>
                    <div class="overlay-img-dark"></div>
                    <div class="card-company">
                        <h5 class="card-title">Information and Technology</h5>
                        <p class="card-text">Jane Doe</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/company/department') }}" class="card-link">
                <div class="card bg-dark border-0 text-white mb-3">
                    <img class="overlay-img" src="{{asset('assets/img/departments/department1.jpg')}}" alt="Card image"/>
                    <div class="overlay-img-dark"></div>
                    <div class="card-company">
                        <h5 class="card-title">Human Resource Department</h5>
                        <p class="card-text">Effendi Harsono</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/company/department') }}" class="card-link">
                <div class="card bg-dark border-0 text-white mb-3">
                    <img class="overlay-img" src="{{asset('assets/img/departments/department2.jpg')}}" alt="Card image"/>
                    <div class="overlay-img-dark"></div>
                    <div class="card-company">
                        <h5 class="card-title">Accounting</h5>
                        <p class="card-text">John Doe</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="{{ url('/company/department') }}" class="card-link">
                <div class="card bg-dark border-0 text-white mb-3">
                    <img class="overlay-img" src="{{asset('assets/img/departments/department3.jpg')}}" alt="Card image"/>
                    <div class="overlay-img-dark"></div>
                    <div class="card-company">
                        <h5 class="card-title">Information and Technology</h5>
                        <p class="card-text">Jane Doe</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

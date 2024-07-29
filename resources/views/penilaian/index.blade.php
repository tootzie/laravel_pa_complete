@extends('layouts/contentNavbarLayout')

@section('title', 'PA Penilaian')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/index-penilaian.js')}}"></script>
@endsection

@section('content')

<!-- ROW 1: Year and Period Filter -->
<div class="row gy-4">
    <!-- Year Selection -->
    <div class="col-md-12 col-lg-2">
        <div>
            <label for="tahunDropdown" class="form-label">Tahun</label>
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

    <!-- Period Selection -->
    <div class="col-md-12 col-lg-2">
        <div>
            <label for="periodeDropdown" class="form-label">Periode</label>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">1: Jan-Jul</button>
                <ul class="dropdown-menu" id="periodeDropdown">
                    <li><a class="dropdown-item" href="javascript:void(0);">2: Aug-Des</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Division Selection -->
    <div class="col-md-12 col-lg-2">
        <div>
            <label for="divisiDropdown" class="form-label">Divisi</label>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Administrasi</button>
                <ul class="dropdown-menu" id="divisiDropdown">
                    <li><a class="dropdown-item" href="javascript:void(0);">Produksi</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>

<br>
<br>
<h5 class="pb-1 mb-4">Administrasi (ADM)</h5>

<div class="col-md-12 col-lg-2">
    <div>
        <label for="statusDropdown" class="form-label">Filter Status</label>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">Semua</button>
            <ul class="dropdown-menu" id="statusDropdown">
                <li><a class="dropdown-item" href="javascript:void(0);" data-status="semua">Semua</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);" data-status="Belum Dinilai">Belum Dinilai</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);" data-status="Penilaian Awal">Penilaian Awal</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);" data-status="Revisi Head of Dept">Revisi Head of Dept</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);" data-status="Revisi GM (Final)">Revisi GM (Final)</a></li>
            </ul>
        </div>
    </div>
</div>
<br>

<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-truncate">User</th>
                        <th class="text-truncate">Nilai</th>
                        <th class="text-truncate">Terakhir Update</th>
                        <th class="text-truncate">User Update</th>
                        <th class="text-truncate">Status</th>
                        <th class="text-truncate">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">Jordan Stevenson</h6>
                                    <small class="text-truncate">WIN*1465</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate"> A+</td>
                        <td class="text-truncate">10 Juli 2024, 10:00</td>
                        <td class="text-truncate">Jessica Clarensia</td>
                        <td><span class="badge bg-label-primary rounded-pill">Revisi Head of Dept</span></td>
                        <td>
                            <a type="button" class="btn btn-icon btn-warning" href="{{ url('/penilaian/detail-awal') }}">
                                <span class="tf-icons mdi mdi-square-edit-outline"></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/3.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">Benedetto Rossiter</h6>
                                    <small class="text-truncate">WIN*0981</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate">-</td>
                        <td class="text-truncate">-</td>
                        <td class="text-truncate">-</td>
                        <td><span class="badge bg-label-secondary rounded-pill">Belum Dinilai</span></td>
                        <td>
                            <a type="button" class="btn btn-icon btn-warning" href="{{ url('/penilaian/detail') }}">
                                <span class="tf-icons mdi mdi-square-edit-outline"></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">Bentlee Emblin</h6>
                                    <small class="text-truncate">WIN*1291</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate">C+</td>
                        <td class="text-truncate">10 Juli 2024, 10:00</td>
                        <td class="text-truncate">Catherina Setiawati</td>
                        <td><span class="badge bg-label-success rounded-pill">Revisi GM (Final)</span></td>
                        <td>
                            <button type="button" class="btn btn-icon btn-warning" disabled>
                                <span class="tf-icons mdi mdi-square-edit-outline"></span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/5.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">Bertha Biner</h6>
                                    <small class="text-truncate">WIN*0698</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate">B</td>
                        <td class="text-truncate">10 Juli 2024, 10:00</td>
                        <td class="text-truncate">Jessica Clarensia</td>
                        <td><span class="badge bg-label-info rounded-pill">Penilaian Awal</span></td>
                        <td>
                            <a type="button" class="btn btn-icon btn-warning" href="{{ url('/penilaian/detail-awal') }}">
                                <span class="tf-icons mdi mdi-square-edit-outline"></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/4.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">Beverlie Krabbe</h6>
                                    <small class="text-truncate">WIN*1821</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate">A-</td>
                        <td class="text-truncate">10 Juli 2024, 10:00</td>
                        <td class="text-truncate">Effendi Harsono</td>
                        <td><span class="badge bg-label-success rounded-pill">Revisi GM (Final)</span></td>
                        <td>
                            <button type="button" class="btn btn-icon btn-warning" disabled>
                                <span class="tf-icons mdi mdi-square-edit-outline"></span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/7.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">Bradan Rosebotham</h6>
                                    <small class="text-truncate">WIN*8746</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate">-</td>
                        <td class="text-truncate">-</td>
                        <td class="text-truncate">-</td>
                        <td><span class="badge bg-label-secondary rounded-pill">Belum Dinilai</span></td>
                        <td>
                            <a type="button" class="btn btn-icon btn-warning" href="{{ url('/penilaian/detail') }}">
                                <span class="tf-icons mdi mdi-square-edit-outline"></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/6.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">Bree Kilday</h6>
                                    <small class="text-truncate">WIN*8927</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate">B-</td>
                        <td class="text-truncate">10 Juli 2024, 10:00</td>
                        <td class="text-truncate">Effendi Harsono</td>
                        <td><span class="badge bg-label-success rounded-pill">Revisi GM (Final)</span></td>
                        <td>
                            <button type="button" class="btn btn-icon btn-warning" disabled>
                                <span class="tf-icons mdi mdi-square-edit-outline"></span>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-transparent">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">Breena Gallemore</h6>
                                    <small class="text-truncate">WIN*1287</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate">A+</td>
                        <td class="text-truncate">10 Juli 2024, 10:00</td>
                        <td class="text-truncate">Jessica Clarensia</td>
                        <td><span class="badge bg-label-primary rounded-pill">Revisi Head of Dept</span></td>
                        <td>
                            <a type="button" class="btn btn-icon btn-warning" href="{{ url('/penilaian/detail-awal') }}">
                                <span class="tf-icons mdi mdi-square-edit-outline"></span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>
@endsection

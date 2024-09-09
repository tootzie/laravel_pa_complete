@extends('layouts/contentNavbarLayout')

@section('title', 'PA Laporan Perusahaan')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/table-function.js')}}"></script>
@endsection

@section('content')
    <h5 class="pb-1 mb-4">Semua Penilaian Karyawan</h5>

    <!-- ROW 1: Year and Period Filter -->
    <div class="row gy-4">
        <!-- Year Selection -->
        <div class="col-auto">
            <div>
                <div>
                    <label for="tahunDropdown" class="form-label">Tahun</label>
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

        <!-- Period Selection -->
        <div class="col-auto">
            <div>
                <div>
                    <label for="periodeDropdown" class="form-label">Periode</label>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">1: Jan-Jul</button>
                    <ul class="dropdown-menu" id="periodeDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0);">2: Aug-Des</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Company Selection -->
        <div class="col-auto">
            <div>
                <div>
                    <label for="companyDropdown" class="form-label">Perusahaan</label>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">PT Wings Surya</button>
                    <ul class="dropdown-menu" id="companyDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0);">PT Karunia Alam Segar</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">PT Adyabuana Persada</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Filter Status -->
        <div class="col-auto">
            <div>
                <div>
                    <label for="statusDropdown" class="form-label">Filter Status</label>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">Semua</button>
                    <ul class="dropdown-menu" id="statusDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="semua">Semua</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="Belum Dinilai">Belum Dinilai</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="Penilaian Awal">Penilaian Awal</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="Revisi Head of Dept">Revisi Head of Dept</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="Revisi GM">Revisi GM</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="Nilai Akhir">Nilai Akhir</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

    <!-- SEARCH BAR -->
    <form method="GET" action="{{ url('/user-akses') }}">
        <div class="input-group input-group-merge">
            <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify"></i></span>
            <input type="text" class="form-control" name="search" value="{{ request()->input('search') }}" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
            <button type="submit" class="btn btn-sm btn-primary">Search</button>
        </div>
    </form>

    <br>

    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th class="text-truncate">User</th>
                            <th class="text-truncate">Penilaian Awal</th>
                            <th class="text-truncate">Revisi Head of Dept</th>
                            <th class="text-truncate">Revisi GM</th>
                            <th class="text-truncate">Nilai Akhir</th>
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
                            <td class="text-truncate">A+</td>
                            <td class="text-truncate">A</td>
                            <td class="text-truncate">-</td>
                            <td class="text-truncate">-</td>
                            <td class="text-truncate">10 Juli 2024, 10:00</td>
                            <td class="text-truncate">Jessica Clarensia</td>
                            <td><span class="badge bg-label-warning rounded-pill">Revisi Head of Dept</span></td>
                            <td>
                                <div class="action-buttons">
                                    <a type="button" class="btn btn-icon btn-success" href="{{ url('/penilaian-all/detail') }}">
                                        <span class="tf-icons mdi mdi-eye-outline"></span>
                                    </a>
                                    <a type="button" class="btn btn-icon btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalCenter">
                                        <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>

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
                            <td class="text-truncate">A+</td>
                            <td class="text-truncate">A</td>
                            <td class="text-truncate">-</td>
                            <td class="text-truncate">-</td>
                            <td class="text-truncate">10 Juli 2024, 10:00</td>
                            <td class="text-truncate">Jessica Clarensia</td>
                            <td><span class="badge bg-label-warning rounded-pill">Revisi Head of Dept</span></td>
                            <td>
                                <div class="action-buttons">
                                    <a type="button" class="btn btn-icon btn-success" href="{{ url('/penilaian-all/detail') }}">
                                        <span class="tf-icons mdi mdi-eye-outline"></span>
                                    </a>
                                    <a type="button" class="btn btn-icon btn-warning" href="#">
                                        <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Edit Penilaian Karyawan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row gy-4 mb-4">
                        <div class="col-12">
                            <table>
                                <tr>
                                    <td>Jessica Clarensia Suko (WIN*1465)</td>
                                </tr>
                                <tr>
                                    <td>PT Wings Surya</td>
                                </tr>
                                <tr>
                                    <td>Adiministrasi - HRD</td>
                                </tr>
                                <tr>
                                    <td>Periode 1 - 2024</td>
                                </tr>
                            </table>
                        </div>


                    </div>

                    <div class="row gy-4">
                        <!-- Nilai Awal -->
                        <div class="col-auto">
                            <div>
                                <div>
                                    <label for="statusDropdown" class="form-label">Nilai Awal</label>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">A+</button>
                                    <ul class="dropdown-menu" id="statusDropdown">
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A+">A+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A">A</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A-">A-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B+">B+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B">B</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B-">B-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C+">C+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C">C</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C-">C-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D+">D+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D">D</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D-">D-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="E">E</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Revisi Head of Dept -->
                        <div class="col-auto">
                            <div>
                                <div>
                                    <label for="statusDropdown" class="form-label">Revisi Head of Dept</label>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">A+</button>
                                    <ul class="dropdown-menu" id="statusDropdown">
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A+">A+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A">A</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A-">A-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B+">B+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B">B</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B-">B-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C+">C+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C">C</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C-">C-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D+">D+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D">D</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D-">D-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="E">E</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Revisi GM -->
                        <div class="col-auto">
                            <div>
                                <div>
                                    <label for="statusDropdown" class="form-label">Revisi GM</label>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">A+</button>
                                    <ul class="dropdown-menu" id="statusDropdown">
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A+">A+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A">A</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A-">A-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B+">B+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B">B</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B-">B-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C+">C+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C">C</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C-">C-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D+">D+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D">D</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D-">D-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="E">E</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Nilai Akhir -->
                        <div class="col-auto">
                            <div>
                                <div>
                                    <label for="statusDropdown" class="form-label">Nilai Akhir</label>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">A+</button>
                                    <ul class="dropdown-menu" id="statusDropdown">
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A+">A+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A">A</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="A-">A-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B+">B+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B">B</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="B-">B-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C+">C+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C">C</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="C-">C-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D+">D+</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D">D</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="D-">D-</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="E">E</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


@endsection

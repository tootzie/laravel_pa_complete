@extends('layouts/contentNavbarLayout')

@section('title', 'PA Penilaian')

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

<!-- ALERT -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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

    <!-- Division Selection -->
    <div class="col-auto">
        <div>
            <div>
                <label for="divisiDropdown" class="form-label">Kategori PA</label>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Administrasi</button>
                <ul class="dropdown-menu" id="divisiDropdown">
                    <li><a class="dropdown-item" href="javascript:void(0);">Produksi</a></li>
                </ul>
            </div>
        </div>
    </div>

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
<h5 class="pb-1 mb-4">Daftar Karyawan</h5>



<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/penilaian') }}">
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
            @php
                $userRole = auth()->user()->id_user_role;
            @endphp
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-truncate">User</th>
                        <th class="text-truncate">Kategori PA</th>
                        <th class="text-truncate">Nilai Awal</th>
                        <th class="text-truncate">Revisi Head of Dept</th>
                        @if ($userRole == '3')
                            <th class="text-truncate">Revisi GM</th>
                            <th class="text-truncate">Nilai Akhir</th>
                        @endif
                        <th class="text-truncate">Action</th>
                        <th class="text-truncate">Terakhir Update</th>
                        <th class="text-truncate">User Update</th>
                        <th class="text-truncate">Status</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($header_pa as $pa)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">{{$pa->nama_employee}}</h6>
                                        <!-- <small class="text-truncate">WIN*1465</small> -->
                                    </div>
                                </div>
                            </td>
                            <td class="text-truncate"> {{$pa->kategori_pa ?? '-'}}</td>
                            <td class="text-truncate"> {{$pa->nilai_awal ?? '-'}}</td>
                            <td class="text-truncate"> {{$pa->revisi_hod ?? '-'}}</td>
                            @if ($userRole == '3')
                                <td class="text-truncate"> {{$pa->revisi_gm ?? '-'}}</td>
                                <td class="text-truncate"> {{$pa->nilai_akhir ?? '-'}}</td>
                            @endif
                            <td>
                                <div class="action-buttons">
                                <form action="{{ url('/penilaian/detail') }}" method="POST">
                                    @csrf <!-- Include CSRF token for security if using Laravel -->
                                    <input type="hidden" name="pa_employee" value="{{$pa}}">

                                    <button type="submit" class="btn btn-icon btn-warning">
                                        <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                    </button>
                                </form>
                                </div>
                            </td>
                            <td class="text-truncate">{{$pa->updated_at}}</td>
                            <td class="text-truncate">{{$pa->updated_by}}</td>
                            <td><span class="badge bg-label-warning rounded-pill">{{$pa->StatusPenilaian->name ?? '-'}}</span></td>

                        </tr>
                    @empty
                        <div class="alert alert-danger">
                            Data Tidak Tersedia
                        </div>
                    @endforelse

                </tbody>
            </table>

            <br>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {!! $header_pa->links() !!}
            </div>
        </div>
    </div>
</div>



<br>
@endsection

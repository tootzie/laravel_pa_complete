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

</div>

<br>
<br>
<h5 class="pb-1 mb-4">Daftar Karyawan</h5>



<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/penilaian-menu-by-user/detail') }}">
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify"></i></span>
        <input type="text" class="form-control" name="search" value="{{ request()->input('search') }}" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
        <input type="hidden" name="ektp" value="{{ $ektpUser }}">
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </div>
</form>

<br>




<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            @php
            $userRole = auth()->user()->userRole->id;
            @endphp
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-truncate sticky-column">User</th>
                        <th class="text-truncate">Kategori PA</th>
                        <th class="text-truncate">Nilai Awal</th>
                        <th class="text-truncate">Revisi Head of Dept</th>
                        <th class="text-truncate">Revisi GM</th>
                        <!-- <th class="text-truncate">Terakhir Update</th>
                        <th class="text-truncate">User Update</th>
                        <th class="text-truncate">Status</th> -->

                    </tr>
                </thead>
                <tbody>
                    @forelse ($header_pa as $pa)
                    <tr>
                        <td class="sticky-column">
                            <div class="d-flex align-items-center sticky-column ">
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
                        <td class="text-truncate"> {{$pa->revisi_gm ?? '-'}}</td>
                        <!-- <td class="text-truncate">{{$pa->updated_at}}</td>
                            <td class="text-truncate">{{$pa->updated_by}}</td>
                            <td><span class="badge bg-label-warning rounded-pill">{{$pa->StatusPenilaian->name ?? '-'}}</span></td> -->

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
                {{ $header_pa->appends(['ektp' => $ektpUser, 'search' => request()->input('search')])->links() }}
            </div>
        </div>
    </div>
</div>



<br>
@endsection

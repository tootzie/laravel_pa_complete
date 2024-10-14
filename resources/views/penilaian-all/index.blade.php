@extends('layouts/contentNavbarLayout')

@section('title', 'PA Semua Nilai')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/penilaian-all.js')}}"></script>
@endsection

@section('content')
<h5 class="pb-1 mb-4">Semua Penilaian Karyawan</h5>

<form method="GET" action="{{ url('/penilaian-menu-all') }}" id="filterForm">
    <!-- ROW 1: Year and Period Filter -->
    <div class="row gy-4">
        <!-- Year Selection -->
        <div class="col-auto">
            <div>
                <div>
                    <label for="tahunDropdown" class="form-label">Tahun - Periode</label>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-periode-label">{{$active_periode->tahun}} - {{$active_periode->periode}}</button>
                    <ul class="dropdown-menu" id="tahunDropdown">
                        @foreach ($all_periode as $periode)
                        <li><a class="dropdown-item" href="javascript:void(0);" data-periode="{{ $periode->id }}">
                                {{ $periode->tahun }} - {{ $periode->periode }}
                            </a></li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="periode" id="selectedPeriode" value="{{ request('periode') }}">
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
                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-company-label">{{ request('company') ? request('company') : 'Semua' }}</button>
                    <ul class="dropdown-menu" id="companyDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0);" data-company="00">
                                Semua
                            </a></li>
                        @foreach ($all_companies as $company)
                        <li><a class="dropdown-item" href="javascript:void(0);" data-company="{{ $company->companycode }}">
                                {{ $company->companycode }}
                            </a></li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="company" id="selectedCompany" value="{{ request('company') }}">
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
                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">{{ request('status') ? request('status') : 'Semua' }}</button>
                    <ul class="dropdown-menu" id="statusDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="00">
                                Semua
                            </a></li>
                        @foreach ($all_status as $status)
                        <li><a class="dropdown-item" href="javascript:void(0);" data-status="{{ $status->kode_status }}" data-status-label="{{ $status->name }}">
                                {{ $status->name }}
                            </a></li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="status" id="selectedStatus" value="{{ request('status') }}">
                    <input type="hidden" name="status_id" id="selectedStatusId" value="{{ request('status_id') }}">
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

    <!-- SEARCH BAR -->

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
            $userRole = auth()->user()->userRole->id;
            @endphp
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-truncate sticky-column">User</th>
                        <th class="text-truncate sticky-column">Atasan</th>
                        <th class="text-truncate">Kategori PA</th>
                        <th class="text-truncate">Perusahaan</th>
                        <th class="text-truncate">Nilai Awal</th>
                        <th class="text-truncate">Revisi Head of Dept</th>
                        <th class="text-truncate">Revisi GM</th>
                        <th class="text-truncate">Nilai Akhir</th>
                        <th class="text-truncate">Action</th>
                        <!-- <th class="text-truncate">Terakhir Update</th>
                        <th class="text-truncate">User Update</th>
                        <th class="text-truncate">Status</th> -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($header_pa as $pa)
                    <tr>
                        <td class="sticky-column">
                            <div class="d-flex align-items-center sticky-column">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">{{$pa->nama_employee}}</h6>
                                    <!-- <small class="text-truncate">WIN*1465</small> -->
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate"> {{$pa->nama_atasan ?? '-'}}</td>
                        <td class="text-truncate"> {{$pa->kategori_pa ?? '-'}}</td>
                        <td class="text-truncate"> {{$pa->perusahaan ?? '-'}}</td>
                        <td class="text-truncate"> {{$pa->nilai_awal ?? '-'}}</td>
                        <td class="text-truncate"> {{$pa->revisi_hod ?? '-'}}</td>
                        <td class="text-truncate"> {{$pa->revisi_gm ?? '-'}}</td>
                        <td class="text-truncate"> {{$pa->nilai_akhir ?? '-'}}</td>
                        @php
                        // Encrypt the ID
                        $encryptedId = Crypt::encrypt($pa->id);
                        @endphp
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn btn-icon btn-warning"
                                    onclick="window.location.href='{{ $pa->id_status_penilaian === 100 ? route('penilaian-detail', ['id' => $encryptedId]) : route('penilaian-detail-revisi-all', ['id' => $encryptedId]) }}'"
                                    @if (!$is_in_periode)
                                    disabled
                                    @endif>
                                    <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                </button>
                            </div>
                        </td>
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
            {{ $header_pa->appends([
                'search' => request()->input('search'),
                'company' => request()->input('company'),
                'status' => request()->input('status'),
                'periode' => request()->input('periode')
                ])->links()
            }}
            </div>
        </div>
    </div>
</div>


@endsection

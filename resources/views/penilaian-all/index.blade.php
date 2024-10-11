@extends('layouts/contentNavbarLayout')

@section('title', 'PA Semua Nilai')

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
                    <label for="tahunDropdown" class="form-label">Tahun - Periode</label>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">2024 - 1</button>
                    <ul class="dropdown-menu" id="tahunDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0);">2024 - 2</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">2023 - 1</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">2023 - 2</a></li>
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
    <form method="GET" action="{{ url('/penilaian-menu-all') }}">
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
                        <td class="text-truncate"> {{$data_subordinates[$pa->ektp_employee]['nama_atasan'] ?? '-'}}</td>
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
                {{ $header_pa->appends(['search' => request()->input('search')])->links() }}
            </div>
        </div>
    </div>
</div>


@endsection

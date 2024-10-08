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
@if (false)
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
@endif

<h5 class="pb-1 mb-4">Daftar Karyawan</h5>

<div class="row gy-4 mb-4">
    <div class="col-6">
        <table>
            <tr>
                <td>Nama Atasan </td>
                <td> : </td>
                <td>{{ $namaAtasan }}</td>
            </tr>
            <tr>
                <td>Total Karyawan </td>
                <td> : </td>
                <td>{{ $jumlahAnakBuah }} orang</td>
            </tr>
            <tr>
                <td>Periode Penilaian </td>
                <td> : </td>
                <td>{{ $stringPeriode }}</td>
            </tr>
        </table>
    </div>
</div>



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
                $userRole = auth()->user()->userRole->id;
            @endphp
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-truncate sticky-column">User</th>
                        <th class="text-truncate">Kategori PA</th>
                        <th class="text-truncate">Nilai Awal</th>
                        <th class="text-truncate">Revisi Head of Dept</th>
                        @if ($userRole == '3')
                        <th class="text-truncate">Revisi GM</th>
                        <!-- <th class="text-truncate">Nilai Akhir</th> -->
                        @endif
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
                        @if ($userRole == '3')
                        <td class="text-truncate"> {{$pa->revisi_gm ?? '-'}}</td>
                        <!-- <td class="text-truncate"> {{$pa->nilai_akhir ?? '-'}}</td> -->
                        @endif
                        <td>
                            <div class="action-buttons">
                                @php
                                    $disabledButton = false;
                                    if($userRole == 1 || $userRole == 2) {
                                        $disabledButton = !$is_in_periode;
                                    } else if ($userRole == 3) {
                                        // If bawahan langsung
                                        if(in_array($pa->ektp_employee, $ktp_bawahan_langsung)) {
                                            $disabledButton = !$is_in_periode;
                                        } else {
                                            $disabledButton = !$is_in_periode || ($pa->id_status_penilaian == 100 || $pa->id_status_penilaian == 200);
                                        }
                                    }

                                    // Encrypt the ID
                                    $encryptedId = Crypt::encrypt($pa->id);

                                    //Determine Route
                                    $route = '';
                                    if($pa->id_status_penilaian == 100) {
                                        $route = route('penilaian-detail', ['id' => $encryptedId]);
                                    } else {
                                        $route = route('penilaian-detail-revisi', ['id' => $encryptedId]);
                                        if($userRole == 1) {
                                            $route = route('penilaian-detail-revisi-all', ['id' => $encryptedId]);
                                        }

                                        if($userRole == 3 && in_array($pa->ektp_employee, $ktp_bawahan_langsung)) {
                                            $route = route('penilaian-detail-revisi-all', ['id' => $encryptedId]);
                                        }
                                    }
                                @endphp
                                <button type="button" class="btn btn-icon btn-warning"
                                    onclick="window.location.href='{{ $route }}'"
                                    @if ($disabledButton)
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
                {!! $header_pa->links() !!}
            </div>
        </div>
    </div>
</div>



<br>
@endsection

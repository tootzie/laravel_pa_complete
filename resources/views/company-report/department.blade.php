@extends('layouts/contentNavbarLayout')

@section('title', 'PA Detail Departement')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/department-report-detail.js')}}"></script>
@endsection

@section('content')
<h3>{{$department}} - {{$master_perusahaan->nama_perusahaan}}</h3>

<br>
<!-- <br> -->

<div hidden id="company" data-value="{{$master_perusahaan->kode_perusahaan}}"></div>
<div hidden id="department" data-value="{{$department}}"></div>

<h5 class="pb-1 mb-4">Grafik {{ $department }}</h5>
<div class="row gy-4">
    <div class="col-md-12">
        <div class="card h-100">
            <div class="card-header pb-0">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">{{ $years[0] }}</button>
                    <ul class="dropdown-menu" id="tahunDropdown">
                        @foreach($years as $year)
                        <li><a class="dropdown-item" href="javascript:void(0);" data-tahun="{{ $year }}">{{ $year }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <br>
            <div class="card-body">
                <div id="totalProfitLineChart" class="mb-3"></div>
                <!-- <h6 class="text-center mb-0">Rata-rata: B+</h6> -->
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
                            <th>D+</th>
                            <th>D</th>
                            <th>D-</th>
                            <th>E</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="tableYear">
                        @foreach ($chartData['data'] as $year => $scores)
                        <tr>
                            <th scope="row">
                                {{ $year }}
                            </th>
                            @php
                            $total = 0;
                            @endphp

                            @foreach ($scores as $score => $count)
                            <td>{{ $count }}</td>
                            @php
                            $total += $count;
                            @endphp
                            @endforeach
                            <td>{{ $total }}</td>
                        </tr>
                        @endforeach

                        <!-- Row for 'Jumlah' -->
                        <tr>
                            <th scope="row">Jumlah</th>
                            @php
                            // Initialize totals for each score
                            $totals = array_fill(0, 13, 0); // Adjusted for 13 scores: A+, A, A-, etc.
                            @endphp
                            @foreach (['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'] as $index => $score)
                            @php
                            // Initialize column total for this score across all years
                            $columnTotal = 0;

                            // Sum the counts for this score from each year
                            foreach ($chartData['data'] as $year => $scores) {
                            $columnTotal += $scores[$score] ?? 0;
                            }

                            // Store the column total
                            $totals[$index] = $columnTotal;
                            @endphp
                            <td>{{ $columnTotal }}</td>
                            @endforeach
                            <td>{{ array_sum($totals) }}</td>
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
<h3 class="pb-1 mb-3">Nilai Karyawan Tahun {{ $years[0] }}</h3>

<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/company/department/' . $master_perusahaan->kode_perusahaan . '/' . $department) }}">
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
                ])->links()
            }}
            </div>
        </div>
    </div>
</div>





@endsection

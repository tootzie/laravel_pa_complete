@extends('layouts/contentNavbarLayout')

@section('title', 'PA Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboard-summary.js')}}"></script>
@endsection

@section('content')
<h5 class="pb-1 mb-4">Grafik Wings Group</h5>

<!-- ROW 2: Graph -->
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
                        @foreach ($chartData['byTahun'] as $year => $scores)
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
                            foreach ($chartData['byTahun'] as $year => $scores) {
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
<h5 class="pb-1 mb-4" id="rekapTitle">Rekap Nilai per PT ({{ $years[0] }})</h5>
<!-- ROW 4: Table -->
<div class="row gy-4">
    <div class="col-12">
        <div class="card">
            <!-- <h5 class="card-header">Sesudah Revisi</h5> -->
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
                    <tbody class="table-border-bottom-0" id="tableCompany">
                    @foreach ($chartData['byCompany'] as $company => $scores)
                        <tr>
                            <th scope="row">
                                {{ $company }}
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
                            foreach ($chartData['byCompany'] as $company => $scores) {
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
@endsection

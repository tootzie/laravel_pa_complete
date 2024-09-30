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
<h5 class="pb-1 mb-4">Lihat Penilaian Berdasarkan User (EKTP)</h5>

<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/penilaian') }}">
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-card-account-details"></i></span>
        <input type="text" class="form-control" name="ektp" value="{{ request()->input('ektp') }}" placeholder="E-KTP (3578xxxxxxxxxxxx)" aria-label="ektp" aria-describedby="basic-addon-search31" />
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
    </div>
</form>
@endsection

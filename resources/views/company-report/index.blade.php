@extends('layouts/contentNavbarLayout')

@section('title', 'PA Laporan Perusahaan')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
    <h5 class="pb-1 mb-4">Laporan Perusahaan</h5>

    <!-- SEARCH BAR -->
    <form method="GET" action="{{ url('/company') }}">
        <div class="input-group input-group-merge">
            <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify"></i></span>
            <input type="text" class="form-control" name="search" value="{{ request()->input('search') }}" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
            <button type="submit" class="btn btn-sm btn-primary">Search</button>
        </div>
    </form>

    <br>
    <br>

    <!-- COMPANY LIST -->
    <div class="row">
        @forelse ($companies as $company)
            <div class="col-md-6 col-xl-4">
                <a href="{{ url('/company/detail/' . $company->companycode) }}" class="card-link">
                    <div class="card bg-dark border-0 text-white mb-3">
                    @php
                        $images = [
                            'company1.jpg',
                            'company2.jpg',
                            'company3.jpg',
                            'company4.jpg',
                            'company5.jpg',
                            'company6.jpg',
                        ];
                        $randomImage = $images[array_rand($images)];
                    @endphp
                        <img class="overlay-img" src="{{asset('assets/img/companies/' . $randomImage)}}" alt="Card image"/>
                        <div class="overlay-img-dark"></div>
                        <div class="card-company">
                            <h5 class="card-title">{{$company->companycode}}</h5>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div   div class="alert alert-danger">
                Data Tidak Tersedia
            </div>
        @endforelse

    </div>
@endsection

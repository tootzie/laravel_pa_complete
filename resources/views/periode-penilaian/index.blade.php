@extends('layouts/contentNavbarLayout')

@section('title', 'Periode Penilaian')

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

<h5 class="pb-1 mb-4">Periode Penilaian</h5>

<div class="col-12">
    <div class="card shadow-none bg-transparent border border-success mb-3">
        <div class="card-body">
            <h6>PERIODE SEKARANG</h6>
            <p class="card-text">
                {{$string_periode_active}}
            </p>
        </div>
    </div>
</div>

<br>

<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/penilaian-menu-periode') }}">
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify"></i></span>
        <input type="text" class="form-control" name="search" value="{{ request()->input('search') }}" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </div>
</form>

<br>
<br>

<div class="d-flex justify-content-left">
    <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='/penilaian-menu-periode/create'">+ Tambah Periode</button>
</div>
<br>
<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-truncate">Tahun</th>
                        <th class="text-truncate">Periode</th>
                        <th class="text-truncate">Tgl Start</th>
                        <th class="text-truncate">Tgl End</th>
                        <th class="text-truncate">Aktif</th>
                        <th class="text-truncate">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($periods as $period)
                    <tr>
                        <td class="text-truncate"> {{$period->tahun}}</td>
                        <td class="text-truncate"> {{$period->periode}}</td>
                        <td class="text-truncate"> {{\Carbon\Carbon::parse($period->start_date)->translatedFormat('j F Y')}}</td>
                        <td class="text-truncate"> {{\Carbon\Carbon::parse($period->end_date)->translatedFormat('j F Y')}}</td>
                        <td><span type="button" class="badge {{$period->is_active == 0 ? 'bg-label-danger' : 'bg-label-success'}} rounded-pill" data-bs-toggle="modal" data-bs-target="#confirmationModal{{$period->id}}">{{$period->is_active == 0 ? 'Tidak' : 'Ya'}}</span></td>
                        <!-- Modal 1-->
                        <div class="modal fade" id="confirmationModal{{$period->id}}" aria-labelledby="confirmationModalLabel{{$period->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modalToggleLabel">Edit Periode</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Toggle periode?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('penilaian-menu-periode-toggle', $period->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <td><span class="badge rounded-pill"></span>{{$user->userRole->name ?? 'null'}}</td> -->
                        <td>
                            <div class="action-buttons">
                                <a type="button" class="btn btn-icon btn-warning" href="{{ route('penilaian-menu-periode-edit', $period->id) }}">
                                    <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                </a>
                                <a type="button" class="btn btn-icon btn-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalToggle{{$period->id}}">
                                    <span class="tf-icons mdi mdi-trash-can-outline"></span>
                                </a>
                                <!-- Modal 1-->
                                <div class="modal fade" id="modalToggle{{$period->id}}" aria-labelledby="modalToggleLabel{{$period->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modalToggleLabel">Hapus User</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Hapus periode {{$period->periode}} tahun {{$period->tahun}}?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('penilaian-menu-periode-delete', $period->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Hapus</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
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
                {!! $periods->links() !!}
            </div>
        </div>
    </div>
</div>



<br>
@endsection

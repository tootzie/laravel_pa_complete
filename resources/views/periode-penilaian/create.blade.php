@extends('layouts/contentNavbarLayout')

@section('title', ' Periode Penilaian - Tambah')

@section('content')

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Periode Penilaian</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('penilaian-menu-periode-store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="tahun">Tahun</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" id="tahun" name="tahun" class="form-control" placeholder="2024" aria-label="john.doe" aria-describedby="basic-default-email2" />
                                <!-- <span class="input-group-text" id="basic-default-email2">@example.com</span> -->
                            </div>
                            @error('tahun')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="periode">Periode</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" id="periode" name="periode" class="form-control" placeholder="2" aria-label="john.doe" aria-describedby="basic-default-email2" />
                                <!-- <span class="input-group-text" id="basic-default-email2">@example.com</span> -->
                            </div>
                            @error('periode')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="start_date">Tgl Start</label>
                        <div class="col-sm-10">
                            <div class="">
                                <input class="form-control" type="date" id="start_date" name="start_date"/>
                            </div>
                            @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="end_date">Tgl End</label>
                        <div class="col-sm-10">
                            <div class="">
                                <input class="form-control" type="date" id="end_date" name="end_date"/>
                            </div>
                            @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

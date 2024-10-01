@extends('layouts/contentNavbarLayout')

@section('title', ' Periode Penilaian - Edit')

@section('content')

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Periode Penilaian</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('penilaian-menu-periode-update', $period->id) }}" method="POST">
                    @csrf
                    @method('patch')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="tahun">Tahun</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" id="tahun" name="tahun" class="form-control" placeholder="2024" aria-label="john.doe" aria-describedby="basic-default-email2" value="{{ $period->tahun }}" />
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
                                <input type="text" id="periode" name="periode" class="form-control" placeholder="2" aria-label="john.doe" aria-describedby="basic-default-email2" value="{{ $period->periode }}" />
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
                                <input class="form-control" type="date" id="start_date" name="start_date" value="{{ \Carbon\Carbon::parse($period->start_date)->format('Y-m-d') }}" />
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
                                <input class="form-control" type="date" id="end_date" name="end_date" value="{{ \Carbon\Carbon::parse($period->end_date)->format('Y-m-d') }}" />
                            </div>
                            @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="limit_date">Tgl Limit</label>
                        <div class="col-sm-10">
                            <div class="">
                                <input class="form-control" type="date" id="limit_date" name="limit_date" value="{{ \Carbon\Carbon::parse($period->limit_date)->format('Y-m-d') }}" />
                            </div>
                            @error('limit_date')
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

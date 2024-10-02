@extends('layouts/contentNavbarLayout')

@section('title', 'PA Penilaian')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/detail-revisi.js')}}"></script>
@endsection

@section('content')

<h5 class="pb-1 mb-4">Detail Penilaian</h5>

@php
$userRole = auth()->user()->userRole->id;
@endphp

<!-- DETAIL INFORMATION -->
<div class="row gy-4">
    <div class="col-6">
        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{$pa_employee->nama_employee}}</td>
            </tr>
            <tr>
                <td>Kode Perusahaan</td>
                <td>:</td>
                <td>{{$pa_employee->perusahaan}}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{$pa_employee->departemen}} - {{$pa_employee->kategori_pa}} </td>
            </tr>
        </table>
    </div>

    <div class="col-6">
        <table>
            <tr>
                <td>Penilaian Awal</td>
                <td>:</td>
                <td>{{$pa_employee->nilai_awal ?? '-'}}</td>
            </tr>
            <tr>
                <td>Revisi Head of Dept </td>
                <td>:</td>
                <td>{{$pa_employee->revisi_hod ?? '-'}}</td>
            </tr>
            @if ($userRole == 3 || $userRole == 1)
            <tr>
                <td>Revisi GM</td>
                <td>:</td>
                <td>{{$pa_employee->revisi_gm ?? '-'}}</td>
            </tr>
            @endif
            @if ($userRole == 1)
            <tr>
                <td>Nilai Akhir</td>
                <td>:</td>
                <td>{{$pa_employee->nilai_akhir ?? '-'}}</td>
            </tr>
            @endif
        </table>
    </div>
</div>

<br>
<br>
<h5 class="pb-1 mb-4">Aspek Kepribadian</h5>

<div class="row gy-4">
    <div class="accordion mt-3" id="accordion1">
        @forelse ($questions['Kepribadian'] as $key => $question_kepribadian)
        <div class="accordion-item active">
            @php
            // Replace spaces or special characters to create a valid and unique ID
            $subaspek_id = Str::slug($question_kepribadian['subaspek']);
            $is_first = $key === 0;
            @endphp
            <h2 class="accordion-header" id="head1-{{$subaspek_id}}">
                <button type="button" class="accordion-button {{ !$is_first ? 'collapsed' : '' }}" data-bs-toggle="collapse" data-bs-target="#ac1-{{$subaspek_id}}" aria-expanded="{{ $is_first ? 'true' : 'false' }}" aria-controls="ac1-{{$subaspek_id}}">
                    {{$question_kepribadian['subaspek']}}
                </button>
            </h2>

            <div id="ac1-{{$subaspek_id}}" class="accordion-collapse collapse {{ $is_first ? 'show' : '' }}" data-bs-parent="#accordion1">
                <div class="accordion-body">
                    @forelse ($question_kepribadian['questions'] as $question)
                    <div class="mb-4">
                        <table>
                            <tr>
                                <td>{{$question['question']}}</td>
                                <td>:</td>
                                <td><b>{{$question['score']}}</b></td>
                            </tr>
                        </table>
                    </div>
                    @empty
                    <div class="alert alert-danger">
                        Data Tidak Tersedia
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-danger">
            Data Tidak Tersedia
        </div>
        @endforelse

    </div>
</div>

<br>
<br>
<h5 class="pb-1 mb-4">Aspek Pekerjaan</h5>

<div class="row gy-4">
    <div class="accordion mt-3" id="accordion2">
        @forelse ($questions['Pekerjaan'] as $key => $question_pekerjaan)
        <div class="accordion-item active">
            @php
            // Replace spaces or special characters to create a valid and unique ID
            $subaspek_id = Str::slug($question_pekerjaan['subaspek']);
            $is_first = $key === 0;
            @endphp
            <h2 class="accordion-header" id="head2-{{$subaspek_id}}">
                <button type="button" class="accordion-button {{ !$is_first ? 'collapsed' : '' }}" data-bs-toggle="collapse" data-bs-target="#ac2-{{$subaspek_id}}" aria-expanded="{{ $is_first ? 'true' : 'false' }}" aria-controls="ac2-{{$subaspek_id}}">
                    {{$question_pekerjaan['subaspek']}}
                </button>
            </h2>

            <div id="ac2-{{$subaspek_id}}" class="accordion-collapse collapse {{ $is_first ? 'show' : '' }}" data-bs-parent="#accordion2">
                <div class="accordion-body">
                    @forelse ($question_pekerjaan['questions'] as $question)
                    <div class="mb-4">
                        <table>
                            <tr>
                                <td>{{$question['question']}}</td>
                                <td>:</td>
                                <td><b>{{$question['score']}}</b></td>
                            </tr>
                        </table>
                    </div>
                    @empty
                    <div class="alert alert-danger">
                        Data Tidak Tersedia
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-danger">
            Data Tidak Tersedia
        </div>
        @endforelse

    </div>
</div>

<br>
<br>

<form id="revisiForm" method="POST" action="{{ route('penilaian-detail-revisi-store-all') }}">
    @csrf
    <h5 class="pb-1 mb-4">Revisi</h5>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="revisi_input_hod">Head of Dept</label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <select id="revisi_input_hod" name="revisi_input_hod" class="form-select">
                    <option value="00" {{ $defaultScoreHod == '00' ? 'selected' : '' }}>Pilih Nilai</option>

                    @foreach ($scores as $score)
                    <option value="{{$score}}" {{ $defaultScoreHod == $score ? 'selected' : '' }}>{{$score}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('revisi_input_hod')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="revisi_input_gm">GM</label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <select id="revisi_input_gm" name="revisi_input_gm" class="form-select">
                    <option value="00" {{ $defaultScoreGM == '00' ? 'selected' : '' }}>Pilih Nilai</option>

                    @foreach ($scores as $score)
                    <option value="{{$score}}" {{ $defaultScoreGM == $score ? 'selected' : '' }}>{{$score}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('revisi_input_gm')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    @if ($userRole == 1)
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="revisi_input_nilai_akhir">Nilai Akhir</label>
            <div class="col-sm-10">
                <div class="input-group input-group-merge">
                    <select id="revisi_input_nilai_akhir" name="revisi_input_nilai_akhir" class="form-select">
                        <option value="00" {{ $defaultScoreAkhir == '00' ? 'selected' : '' }}>Pilih Nilai</option>

                        @foreach ($scores as $score)
                        <option value="{{$score}}" {{ $defaultScoreAkhir == $score ? 'selected' : '' }}>{{$score}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('revisi_input_nilai_akhir')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    @endif


    <input type="hidden" name="pa_employee" value="{{json_encode($pa_employee)}}">
    <input type="hidden" name="stringRevisi" value="{{$stringRevisi}}">
    <input type="hidden" name="ektp" value="{{$ektp}}">

    <div class="mt-5 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>



@endsection

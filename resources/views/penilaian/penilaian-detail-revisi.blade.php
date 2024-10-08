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
            @if ($userRole == 3)
            <tr>
                <td>Revisi GM</td>
                <td>:</td>
                <td>{{$pa_employee->revisi_gm ?? '-'}}</td>
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

@if ($pa_employee->id_status_penilaian != 500)
<form id="revisiForm" method="POST" action="{{ route('penilaian-detail-revisi-store') }}">
    @csrf
    <h5 class="pb-1 mb-4">{{$stringRevisi}}</h5>

    <div class="row mb-3">
        <div class="col-12">
            <div class="input-group input-group-merge">
                <select id="revisi_input" name="revisi_input" class="form-select">
                    <option value="00" {{ $defaultScore == '00' ? 'selected' : '' }}>Pilih Nilai</option>

                    @foreach ($scores as $score)
                    <option value="{{$score}}" {{ $defaultScore == $score ? 'selected' : '' }}>{{$score}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('revisi_input')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <br>
    <h5 class="pb-1 mb-2">Kesimpulan & Saran</h5>
    @forelse ($pertanyaan_kesimpulan as $key => $question_kesimpulan)
        @forelse ($question_kesimpulan['questions'] as $index => $question)
            <label class="col-sm-12 col-form-label" for="nama_atasan">{{$index + 1}}. {{ $question['question'] }}</label>
            <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="input-group input-group-merge">
                            <textarea type="text" id="kesimpulan[{{$question['id']}}]" name="kesimpulan[{{$question['id']}}]" class="form-control" placeholder="Saran..." aria-label="john.doe" aria-describedby="basic-default-email2" >{{isset($detailPA[$question['id']]) ? $detailPA[$question['id']]->text_value : ''}}</textarea>
                        </div>
                    </div>
            </div>
        @empty
            <div class="alert alert-danger">
                    Data Tidak Tersedia
            </div>
        @endforelse
    @empty
        <div class="alert alert-danger">
                Data Tidak Tersedia
        </div>
    @endforelse
    <input type="hidden" name="pa_employee" value="{{json_encode($pa_employee)}}">
    <input type="hidden" name="stringRevisi" value="{{$stringRevisi}}">

    <div class="mt-5 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

@endif



@endsection

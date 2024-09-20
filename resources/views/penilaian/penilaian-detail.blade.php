@extends('layouts/contentNavbarLayout')

@section('title', 'PA Penilaian')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script>
    var autosaveUrl = '{{ route("penilaian-detail-autosave") }}';
</script>
<script src="{{asset('assets/js/index-penilaian.js')}}"></script>
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
                <td>Revisi Head of Dept  </td>
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
<div id="autosaveMessage" ></div>
<form id="penilaianForm" method="POST" action="{{ route('penilaian-detail-store') }}">
    @csrf
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
                        <p>{{$question['question']}}</p>
                        <div class="form-check-group">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="question[{{ $question['id'] }}]"
                                        id="{{ $question['id'] }}"
                                        value="{{ $i }}"
                                        {{ isset($detailPA[$question['id']]) && $detailPA[$question['id']]->score == $i ? 'checked' : '' }}
                                    />
                                    <label class="form-check-label" for="{{ $question['id'] }}">{{ $i }}</label>
                                </div>
                            @endfor
                        </div>
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
                        <p>{{$question['question']}}</p>
                        <div class="form-check-group">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="question[{{ $question['id'] }}]"
                                        id="{{ $question['id'] }}"
                                        value="{{ $i }}"
                                    />
                                    <label class="form-check-label" for="{{ $question['id'] }}">{{ $i }}</label>
                                </div>
                            @endfor
                        </div>
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

    <input type="hidden" name="pa_employee" value="{{json_encode($pa_employee)}}">
    <input type="hidden" name="questions" value="{{json_encode($questions)}}">

    <div class="mt-5 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>


@endsection

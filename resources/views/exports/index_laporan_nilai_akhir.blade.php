@extends('layouts/contentNavbarLayout')

@section('title', 'PA Laporan Nilai AKhir')

@section('vendor-style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/table-function.js')}}"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for searchable dropdown
        $('.select2').select2({
            placeholder: "Pilih Tahun - Periode",
            theme: 'bootstrap-5'
        });

        // Listen to change event on the select2 dropdown
        // $('#user_choice').on('change', function() {
        //     // Get the selected user's E-KTP value
        //     var selectedEktp = $(this).val();

        //     // Set the E-KTP field with the selected value
        //     $('#ektp').val(selectedEktp);
        // });
    });
</script>
@endsection

@section('content')
<h5 class="pb-1 mb-4">Laporan Nilai Akhir</h5>

<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/download-laporan-nilai-akhir') }}">
    <!-- @csrf -->
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-clock-time-eight-outline"></i></span>
        <select id="id_master_tahun_periode" name="id_master_tahun_periode" class="form-select select2">
            <option value="00">Pilih Tahun dan Periode</option>
            @foreach ($periods as $period)
            <option value="{{$period->id}}">{{$period->tahun}} - {{$period->periode}}</option>
            @endforeach
        </select>

    </div>
    @error('id_master_tahun_periode')
        <small class="text-danger">{{ $message }}</small>
    @enderror
    <input type="hidden" name="isIndex" id="isIndex" value="true">
    <br>
    <div class="text-center">
        <button type="submit" class="btn btn-md btn-primary">DOWNLOAD</button>
    </div>
</form>
@endsection

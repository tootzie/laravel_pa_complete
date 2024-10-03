@extends('layouts/contentNavbarLayout')

@section('title', 'PA Laporan Perusahaan')

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
            placeholder: "Pilih User",
            theme: 'bootstrap-5'
        });

        // Listen to change event on the select2 dropdown
        $('#user_choice').on('change', function() {
            // Get the selected user's E-KTP value
            var selectedEktp = $(this).val();

            // Set the E-KTP field with the selected value
            $('#ektp').val(selectedEktp);
        });
    });
</script>
@endsection

@section('content')
<h5 class="pb-1 mb-4">Lihat Penilaian Berdasarkan User (EKTP)</h5>

<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/penilaian-menu-by-user/detail') }}">
    <!-- @csrf -->
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-account"></i></span>
        <select id="user_choice" name="user_choice" class="form-select select2">
            <option value="00">Pilih User</option>
            @foreach ($users as $user)
            <option value="{{$user->ektp_atasan}}">{{$user->nama_atasan}}</option>
            @endforeach
        </select>

    </div>
    @error('user_choice')
        <small class="text-danger">{{ $message }}</small>
    @enderror
    <div class="input-group input-group-merge mt-2 mb-4">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-card-account-details"></i></span>
        <input type="text" class="form-control" name="ektp" id="ektp" placeholder="E-KTP" aria-label="ektp" readonly />
    </div>
    <input type="hidden" name="isIndex" id="isIndex" value="true">
    <div class="text-center">
        <button type="submit" class="btn btn-md btn-primary">Submit</button>
    </div>
</form>
@endsection

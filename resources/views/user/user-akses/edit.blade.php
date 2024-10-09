@extends('layouts/contentNavbarLayout')

@section('title', 'Akses User - Edit')

@section('vendor-style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endsection

@section('vendor-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection

@section('page-script')
<script>
    $(document).ready(function() {
        var selectedEktp = "{{ $selectedEktp }}";

        // Initialize Select2 for searchable dropdown
        $('.select2').select2({
            placeholder: "Pilih User",
            theme: 'bootstrap-5'
        });

        $('#user_choice').val(selectedEktp).trigger('change.select2');

        var selectedOption = document.getElementById('user_choice').options[document.getElementById('user_choice').selectedIndex];
        var namaAtasan = selectedOption.getAttribute('data-nama-atasan');
        document.getElementById('nama_atasan').value = namaAtasan;

        // Listen to change event on the select2 dropdown
        $('#user_choice').on('change', function() {
            // Get the selected user's E-KTP value
            var selectedEktp = $(this).val();
            $('#ektp').val(selectedEktp);

            selectedOption = this.options[this.selectedIndex];
            namaAtasan = selectedOption.getAttribute('data-nama-atasan');
            document.getElementById('nama_atasan').value = namaAtasan;
        });
    });
</script>
@endsection

@section('content')

<!-- Basic Layout & Basic with Icons -->
<div class="row">
  <!-- Basic Layout -->
  <div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Akses User</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('user-akses-update', $user->id) }}" method="POST">
            @csrf
            @method('patch')
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="email">Email</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <input type="text" id="email" name="email" class="form-control" placeholder="john.doe@sby.wingscorp.com" aria-label="john.doe" aria-describedby="basic-default-email2" value="{{ $user->email }}" />
                <!-- <span class="input-group-text" id="basic-default-email2">@example.com</span> -->
              </div>
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="nama_atasan">Nama Atasan</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <select id="user_choice" name="user_choice" class="form-select select2">
                            <option value="00">Pilih User</option>
                            @foreach ($users as $user1)
                                <option value="{{$user1->ektp_atasan}}" data-nama-atasan="{{$user1->nama_atasan}}">{{$user1->nama_atasan}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('user_choice')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
          </div>

          <input type="hidden" name="nama_atasan" id="nama_atasan">

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="email">E-KTP</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <input type="text" id="ektp" name="ektp" class="form-control" placeholder="356878110000002" aria-label="john.doe" aria-describedby="basic-default-email2" value="{{ $user->ektp }}" readonly/>
                <!-- <span class="input-group-text" id="basic-default-email2">@example.com</span> -->
              </div>
              @error('ektp')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="role_name">Role</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <select id="role_name" name="role_name" class="form-select">
                    <option value="00" {{ $selectedRoleId == '00' ? 'selected' : '' }}>Pilih Role User</option>

                    @foreach ($roles as $role)
                        <option value="{{$role->id}}" {{ $selectedRoleId == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                    @endforeach
                </select>
              </div>
              @error('role_name')
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

@extends('layouts/contentNavbarLayout')

@section('title', 'Akses User - Edit')

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
            <label class="col-sm-2 col-form-label" for="email">E-KTP</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <input type="text" id="ektp" name="ektp" class="form-control" placeholder="356878110000002" aria-label="john.doe" aria-describedby="basic-default-email2" value="{{ $user->ektp }}" />
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

@extends('layouts/contentNavbarLayout')

@section('title', ' Role User - Edit')

@section('content')

<!-- Basic Layout & Basic with Icons -->
<div class="row">
  <!-- Basic Layout -->
  <div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Role User</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('user-roles-update', $role->id) }}" method="POST">
            @csrf
            @method('patch')
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="name">Nama Role</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <input type="text" id="name" name="name" class="form-control" placeholder="Super Admin" aria-label="john.doe" aria-describedby="basic-default-email2" value="{{$role->name}}"/>
                <!-- <span class="input-group-text" id="basic-default-email2">@example.com</span> -->
              </div>
              <!-- @error('name')
                <small class="text-danger">{{ $message }}</small>
              @enderror -->
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

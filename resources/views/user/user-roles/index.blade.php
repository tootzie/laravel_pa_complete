@extends('layouts/contentNavbarLayout')

@section('title', 'User Roles')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/table-function.js')}}"></script>
@endsection

@section('content')

<h5 class="pb-1 mb-4">Role User</h5>

<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/user-roles') }}">
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify"></i></span>
        <input type="text" class="form-control" name="search" value="{{ request()->input('search') }}" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </div>
</form>

<br>
<br>

<div class="d-flex justify-content-left">
    <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='/user-roles/create'">+ Tambah Role</button>
</div>
<br>
<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-truncate">ID</th>
                        <th class="text-truncate">Nama Role</th>
                        <th class="text-truncate">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                    <tr>
                        <td class="text-truncate"> {{$role->id}}</td>
                        <td class="text-truncate"> {{$role->name}}</td>
                        <td>
                            <div class="action-buttons">
                                <a type="button" class="btn btn-icon btn-warning" href="{{ route('user-roles-edit', $role->id) }}">
                                    <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                </a>
                                <a type="button" class="btn btn-icon btn-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalToggle{{$role->id}}">
                                    <span class="tf-icons mdi mdi-trash-can-outline"></span>
                                </a>
                                <!-- Modal 1-->
                                <div class="modal fade" id="modalToggle{{$role->id}}" aria-labelledby="modalToggleLabel{{$role->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title" id="modalToggleLabel">Hapus Role</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        Hapus role '{{$role->name}}'?
                                        </div>
                                        <div class="modal-footer">
                                        <form action="{{ route('user-roles-delete', $role->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                        </form>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger">
                        Data Tidak Tersedia
                    </div>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <!-- {!! $roles->links() !!} -->
                {!! $roles->appends(['search' => request()->input('search')])->links() !!}
            </div>
        </div>
    </div>
</div>



<br>
@endsection

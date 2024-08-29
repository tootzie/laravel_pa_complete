@extends('layouts/contentNavbarLayout')

@section('title', 'User Akses')

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

<h5 class="pb-1 mb-4">Akses User</h5>

<!-- SEARCH BAR -->
<form method="GET" action="{{ url('/user-akses') }}">
    <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify"></i></span>
        <input type="text" class="form-control" name="search" value="{{ request()->input('search') }}" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<br>
<br>

<div class="d-flex justify-content-left">
    <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='/user-akses/create'">+ Tambah User</button>
</div>
<br>
<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-truncate">ID</th>
                        <th class="text-truncate">User</th>
                        <th class="text-truncate">Email</th>
                        <th class="text-truncate">Role</th>
                        <th class="text-truncate">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td class="text-truncate"> {{$user->id}}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{$user->avatar ?? asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">{{$user->name ?? "-"}}</h6>
                                    <!-- <small class="text-truncate">WIN*1465</small> -->
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate"> {{$user->email}}</td>
                        <td><span class="badge rounded-pill"></span>{{$user->userRole->name ?? 'null'}}</td>
                        <td>
                            <div class="action-buttons">
                                <a type="button" class="btn btn-icon btn-warning" href="{{ route('user-akses-edit', $user->id) }}">
                                    <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                </a>
                                <a type="button" class="btn btn-icon btn-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalToggle{{$user->id}}">
                                    <span class="tf-icons mdi mdi-trash-can-outline"></span>
                                </a>
                                <!-- Modal 1-->
                                <div class="modal fade" id="modalToggle{{$user->id}}" aria-labelledby="modalToggleLabel{{$user->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title" id="modalToggleLabel">Hapus User</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        Hapus user '{{$user->email}}'?
                                        </div>
                                        <div class="modal-footer">
                                        <form action="{{ route('user-akses-delete', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                        </form>
                                        <!-- <button class="btn btn-primary" data-bs-target="#modalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal" onclick="window.location.href='/user-akses/delete/{{$user->id}}'">Hapus</button> -->
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

            <br>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {!! $users->links() !!}
            </div>
        </div>
    </div>
</div>



<br>
@endsection


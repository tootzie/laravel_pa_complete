@extends('layouts/contentNavbarLayout')

@section('title', 'PA Karyawan')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/company-detail.js')}}"></script>
@endsection

@section('content')
<h3>Jessica Clarensia Suko</h3>
<h6 class="pb-1 mb-4">Human Resource Department - HRIS</h3>

    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Periode</th>
                            <th>Penilaian Awal</th>
                            <th>Revisi Head of Dept</th>
                            <th>Revisi GM</th>
                            <th>Nilai Akhir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td>2024</td>
                            <td>2</td>
                            <td>A+</td>
                            <td>B</td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <a type="button" class="btn btn-icon btn-success" href="#">
                                    <span class="tf-icons mdi mdi-eye-outline"></span>
                                </a>
                                <a type="button" class="btn btn-icon btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2024</td>
                            <td>1</td>
                            <td>A+</td>
                            <td>B-</td>
                            <td>B+</td>
                            <td>-</td>
                            <td>
                                <a type="button" class="btn btn-icon btn-success" href="#">
                                    <span class="tf-icons mdi mdi-eye-outline"></span>
                                </a>
                                <a type="button" class="btn btn-icon btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2023</td>
                            <td>2</td>
                            <td>A+</td>
                            <td>B-</td>
                            <td>B-</td>
                            <td>B-</td>
                            <td>
                                <a type="button" class="btn btn-icon btn-success" href="#">
                                    <span class="tf-icons mdi mdi-eye-outline"></span>
                                </a>
                                <a type="button" class="btn btn-icon btn-warning disabled-anchor" href="#">
                                    <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2023</td>
                            <td>1</td>
                            <td>A+</td>
                            <td>B</td>
                            <td>B-</td>
                            <td>B-</td>
                            <td>
                                <a type="button" class="btn btn-icon btn-success" href="#">
                                    <span class="tf-icons mdi mdi-eye-outline"></span>
                                </a>
                                <a type="button" class="btn btn-icon btn-warning disabled-anchor" href="#">
                                    <span class="tf-icons mdi mdi-square-edit-outline"></span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Revisi GM</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row gy-4 mb-4">
                        <div class="col-6">
                            <table>
                                <tr>
                                    <td>Jessica Clarensia Suko (WIN*1465)</td>
                                </tr>
                                <tr>
                                    <td>PT Wings Surya</td>
                                </tr>
                                <tr>
                                    <td>Adiministrasi - HRD</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-6">
                            <table>
                                <tr>
                                    <td>Penilaian Awal</td>
                                    <td>:</td>
                                    <td>A+</td>
                                </tr>
                                <tr>
                                    <td>Revisi Head of Dept </td>
                                    <td>:</td>
                                    <td>B</td>
                                </tr>
                                <tr>
                                    <td>Revisi GM</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Nilai Akhir</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h6 class="modal-title mb-2" id="modalCenterTitle">Input Revisi GM</h6>
                    <div class="col-md-12 col-lg-2">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary fixed-width-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown-status-label">A+</button>
                            <ul class="dropdown-menu" id="statusDropdown">
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="A+">A+</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="A">A</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="A-">A-</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="B+">B+</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="B">B</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="B-">B-</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="C+">C+</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="C">C</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="C-">C-</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="D+">D+</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="D">D</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="D-">D-</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="E">E</a></li>
                            </ul>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    @endsection

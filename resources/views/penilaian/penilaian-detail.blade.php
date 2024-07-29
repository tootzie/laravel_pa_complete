@extends('layouts/contentNavbarLayout')

@section('title', 'PA Penilaian')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/index-penilaian.js')}}"></script>
@endsection

@section('content')

<h5 class="pb-1 mb-4">Detail Penilaian</h5>

<!-- DETAIL INFORMATION -->
<div class="row gy-4">
    <div class="col-4">
        <table>
            <tr>
                <td>Jordan Stevenson (WIN*1465)</td>
            </tr>
            <tr>
                <td>PT Wings Surya</td>
            </tr>
            <tr>
                <td>Adiministrasi - HRD</td>
            </tr>
        </table>
    </div>

    <div class="col-4">
        <table>
            <tr>
                <td>Penilaian Awal</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Revisi Head of Dept  </td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Revisi GM</td>
                <td>:</td>
                <td>-</td>
            </tr>
        </table>
    </div>
</div>

<br>
<br>
<h5 class="pb-1 mb-4">Aspek Kepribadian</h5>

<div class="row gy-4">
<div class="accordion mt-3" id="accordionExample">
      <div class="accordion-item active">
        <h2 class="accordion-header" id="ac1-headingOne">
          <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#ac1-accordionOne" aria-expanded="true" aria-controls="ac1-accordionOne">
            Teamwork/Kerjasama
          </button>
        </h2>

        <div id="ac1-accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <!-- Q1 -->
                <div class="mb-4">
                    <p> Menghubungi pihak lain yang dapat membantu pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="mb-4">
                    <p> Melakukan tindakan untuk mempermudah pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="mb-4">
                    <p> Menunjukkan tindakan yang mencegah timbulnya konflik dalam kelompok. (TQ)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="ac1-headingTwo">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#ac1-accordionTwo" aria-expanded="false" aria-controls="ac1-accordionTwo">
            Komunikasi
          </button>
        </h2>
        <div id="ac1-accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
                <!-- Q1 -->
                <div class="mb-4">
                    <p> Menghubungi pihak lain yang dapat membantu pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="mb-4">
                    <p> Melakukan tindakan untuk mempermudah pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="mb-4">
                    <p> Menunjukkan tindakan yang mencegah timbulnya konflik dalam kelompok. (TQ)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="ac1-headingThree">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#ac1-accordionThree" aria-expanded="false" aria-controls="ac1-accordionThree">
            Loyalitas
          </button>
        </h2>
        <div id="ac1-accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
                <!-- Q1 -->
                <div class="mb-4">
                    <p> Menghubungi pihak lain yang dapat membantu pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="mb-4">
                    <p> Melakukan tindakan untuk mempermudah pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="mb-4">
                    <p> Menunjukkan tindakan yang mencegah timbulnya konflik dalam kelompok. (TQ)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

<br>
<br>
<h5 class="pb-1 mb-4">Aspek Pekerjaan</h5>

<div class="row gy-4">
<div class="accordion mt-3" id="accordionExample">
      <div class="accordion-item active">
        <h2 class="accordion-header" id="headingOne">
          <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
            Teamwork/Kerjasama
          </button>
        </h2>

        <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <!-- Q1 -->
                <div class="mb-4">
                    <p> Menghubungi pihak lain yang dapat membantu pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="mb-4">
                    <p> Melakukan tindakan untuk mempermudah pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="mb-4">
                    <p> Menunjukkan tindakan yang mencegah timbulnya konflik dalam kelompok. (TQ)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ks-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
            Komunikasi
          </button>
        </h2>
        <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
                <!-- Q1 -->
                <div class="mb-4">
                    <p> Menghubungi pihak lain yang dapat membantu pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="mb-4">
                    <p> Melakukan tindakan untuk mempermudah pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="mb-4">
                    <p> Menunjukkan tindakan yang mencegah timbulnya konflik dalam kelompok. (TQ)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="k-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">
            Loyalitas
          </button>
        </h2>
        <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
                <!-- Q1 -->
                <div class="mb-4">
                    <p> Menghubungi pihak lain yang dapat membantu pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group1" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="mb-4">
                    <p> Melakukan tindakan untuk mempermudah pencapaian tujuan bersama. (TF)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group2" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="mb-4">
                    <p> Menunjukkan tindakan yang mencegah timbulnya konflik dalam kelompok. (TQ)</p>
                    <div class="form-check-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio1" value="option1" />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="l-group3" id="inlineRadio2" value="option2" />
                            <label class="form-check-label" for="inlineRadio2">5</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="mt-5 d-flex justify-content-center">
    <button type="button" class="btn btn-primary">Simpan</button>
</div>


@endsection

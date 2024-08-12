@extends('layouts/blankLayout')

@section('title', 'PA Login')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">

            <!-- Login -->
            <div class="card p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{url('/')}}" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                        <img src="{{asset('assets/img/logo/wings.png')}}" alt="auth-tree" height="40">
                        </span>
                        <span class="app-brand-text demo text-heading fw-semibold">Personal Assessement</span>
                    </a>
                </div>
                <!-- /Logo -->

                <div class="card-body mt-2">
                    <!-- <h4 class="mb-2">Halo!👋</h4>
                    <p class="mb-4">Sign in dulu yuk</p> -->

                    <form id="formAuthentication" class="mb-3" action="{{url('/authenticate')}}" method="post">
                        @csrf
                        <!-- <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" autofocus>

                            <label for="email">Email</label>
                            @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                            @enderror
                        </div> -->
                        <!-- <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <label for="password">Password</label>
                                        @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                        @enderror
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me">
                                <label class="form-check-label" for="remember-me">
                                    Ingat Saya
                                </label>
                            </div>
                            <a href="{{url('auth/forgot-password-basic')}}" class="float-end mb-1">
                                <span>Lupa Password?</span>
                            </a>
                        </div> -->
                        <!-- <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div> -->

                        <button type="button" class="btn btn-primary w-100 mb-4" onclick="window.location.href='/auth/google'">
                            <span class="tf-icons mdi mdi-google me-1"></span>Sign in dengan Google
                        </button>

                        @if ($errors->any())
                            <div class="mt-3">
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </form>

                    <!-- <p class="text-center">
                        <span>Belum punya akun?</span>
                        <a href="{{url('/register')}}">
                            <span>Buat disini</span>
                        </a>
                    </p> -->
                </div>
            </div>
            <!-- /Login -->
            <img src="{{asset('assets/img/illustrations/tree-3.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
            <img src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" alt="triangle-bg">
            <img src="{{asset('assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
        </div>
    </div>
</div>
@endsection

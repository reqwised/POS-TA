@extends('layouts.auth')
@push('css')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
    }
    .login-image {
        background: url('/img/login.jpg') no-repeat center center;
        background-size: cover;
        width: 100%;
        height: 100%;
    }
    @media (max-width: 768px) {
        .login-image {
            display: none;
        }
    }
</style>
@endpush

@section('login')
<div class="row vh-100 g-0">
        <div class="col-lg-6 position-relative d-none d-lg-block">
            <div class="login-image rounded"></div>
        </div>
        <div class="col-lg-6">
            <div class="row align-items-center justify-content-center h-100 g-0 px-4 px-sm-0 ">
                <div class="col col-sm-7 col-lg-8 col-xl-7">
                    <a href="#" class="d-flex justify-content-center mb-4">
                        <img src="{{ url($setting->path_logo) }}" alt="logo.png" width="100">
                    </a>
                    <div class="text-center mb-10">
                        <h1 class="font-weight-bold">Login</h1>
                        <p class="text-secondary">Silahkan login untuk mengelola penjualan Toko Anda dengan mudah dan efisien.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger text-center" role="alert">
                            <strong>LOGIN GAGAL! EMAIL ATAU PASSWORD SALAH!</strong>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="post" class="form-login" id="loginForm" novalidate>
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="user@example.com" required value="{{ old('email') }}" autofocus>
                            <div class="invalid-feedback">
                                Email tidak valid. Pastikan email memiliki format yang benar (misalnya, user@example.com).
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="password" required>
                            <div class="invalid-feedback">
                                Password tidak boleh kosong.
                            </div>
                        </div>

                        <div class="form-group form-check my-3">
                            <input class="form-check-input icheck" type="checkbox" id="rememberMe" name="remember">
                            <label class="form-check-label text-secondary" for="rememberMe">
                                Remember Me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary w-100" id="loginButton" disabled>Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
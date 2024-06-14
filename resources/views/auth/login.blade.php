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
                <div class="col col-sm-6 col-lg-7 col-xl-6">
                    <a href="#" class="d-flex justify-content-center mb-4">
                        <img src="{{ url($setting->path_logo) }}" alt="logo.png" width="100">
                    </a>
                    <div class="text-center mb-5">
                        <h1 class="font-weight-bold">Login</h1>
                        <p class="text-secondary">Get access to your account</p>
                    </div>

                    <form action="{{ route('login') }}" method="post" class="form-login">
                        @csrf
                        <div class="form-group mb-3 @error('email') has-error @enderror">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="email" class="form-control form-control-lg" placeholder="Email" required value="{{ old('email') }}" autofocus>
                            </div>
                            @error('email')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @else
                                <span class="help-block with-errors text-danger"></span>
                            @enderror
                        </div>

                        <div class="form-group @error('password') has-error @enderror">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                            </div>
                            @error('password')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @else
                                <span class="help-block with-errors text-danger"></span>
                            @enderror
                        </div>

                        <div class="custom-control custom-checkbox my-4">
                            <input class="custom-control-input icheck" type="checkbox" id="rememberMe" name="remember">
                            <label class="custom-control-label text-secondary" for="rememberMe">
                                Remember Me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
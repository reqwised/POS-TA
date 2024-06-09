@extends('layouts.auth')

@section('login')
<div class="login-box">

    <!-- /.login-logo -->
    <div class="login-box-body">
        <h1 class="text-center">Login</h1>
        <!-- <div class="login-logo">
            <a href="{{ url('/') }}">
                <img src="{{ url($setting->path_logo) }}" alt="logo.png" width="100">
            </a>
        </div> -->

        <form action="{{ route('login') }}" method="post" class="form-login">
            @csrf
            <!-- <div class="form-group has-feedback @error('email') has-error @enderror">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="" required value="{{ old('email') }}" autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @error('email')
                    <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div> -->
            <div class="form-group @error('email') has-error @enderror">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="" required value="{{ old('email') }}" autofocus>
                <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                @error('email')
                    <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <div class="form-group @error('password') has-error @enderror">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="" required>
                <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
                @error('password')
                    <span class="help-block">{{ $message }}</span>
                @else
                    <span class="help-block with-errors"></span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
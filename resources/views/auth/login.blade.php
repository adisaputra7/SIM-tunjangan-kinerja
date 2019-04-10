@extends('layouts.app')

@section('content')
<!-- <div class="">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email address</label>
                        <input class="form-control" id="email" name="email" 
                        type="email" aria-describedby="emailHelp" placeholder="Enter email"
                        value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <p style="color:red;">{{ $errors->first('email') }}</p>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <input class="form-control" name="password" id="password" type="password" 
                        placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <p style="color:red;">{{ $errors->first('password') }}</p>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                        </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div> -->
<div class="loginPages">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('images/kab_bogor_logo.png') }}"
                class="mx-auto d-block img-responsive"
                alt="Logo Kab Bogor" width="100px" height="120px">
                <br>
                <h2 class="text-center text-white mb-4">Sistem Informasi Tunjangan Kinerja</h2>
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <span class="anchor" id="formLogin"></span>

                        <!-- form card login -->
                        <div class="card rounded-0">
                            <div class="card-header">
                                <h3 class="mb-0 text-center">Login</h3>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email">Alamat email</label>
                                        <input class="form-control" id="email" name="email" 
                                        type="email" aria-describedby="emailHelp" placeholder="Masukkan email"
                                        value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <p style="color:red;">{{ $errors->first('email') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password">Password</label>
                                        <input class="form-control" name="password" id="password" type="password" 
                                        placeholder="Masukkan password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <p style="color:red;">{{ $errors->first('password') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                                        </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </form>
                            </div>
                            <!--/card-block-->
                        </div>
                        <!-- /form card login -->

                    </div>


                </div>
                <!--/row-->

            </div>
            <!--/col-->
        </div>
        <!--/row-->
    </div>
    <!--/container-->
</div>

@endsection

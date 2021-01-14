@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 text-center">
            <div class="alert" role="alert" style="font-family:segoe ui black; background-color:#c4eb2a; font-size:22px; border-radius:100px;">
                Sistem Informasi Akuntansi Siklus Pendapatan Toko ANABEE
            </div>
        </div>       
    </div> <hr>
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="row ml-auto">
                <button class="btn btn-dark" style="width:150px; height:70px; font-size:22px; color:#c4eb2a; border-radius:100px;"> <b> Owner </b> </button>
            </div> <br>
            <div class="row ml-auto">
                <button class="btn btn-dark" style="width:150px; height:70px; font-size:22px; color:#c4eb2a; border-radius:100px;"> <b> Gudang </b> </button>
            </div> <br>
            <div class="row ml-auto">
                <button class="btn btn-dark" style="width:150px; height:70px; font-size:22px; color:#c4eb2a; border-radius:100px;"> <b> Kasir </b> </button>
            </div> <br>
            <div class="row ml-auto">
                <button class="btn btn-dark" style="width:150px; height:70px; font-size:22px; color:#c4eb2a; border-radius:100px;"> <b> Kurir </b> </button>
            </div> <br>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-center " style="font-size:25px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> <span class="fa fa-user mr-3"></span>  {{ __('Log in') }}  </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-dark text-center " style="font-size:18px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;">&copy Sistem informasi 2018 </div>

            </div>
        </div>
    </div>
</div>
@endsection

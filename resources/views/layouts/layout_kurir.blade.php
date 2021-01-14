<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm fixed-top">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    <span><div style="font-size:20px; font-family:segoe ui black; color:#c4eb2a; font-weight:bold;"> <i class="fa fa-home"></i> Toko Anabee </div> </span>
                </a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span style=" font-family:segoe ui black; color:#c4eb2a;"> {{ Auth::user()->name }} </span> <span class="caret"> </span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <br>
        <div>
            <br><br><br>
        </div>
        <!-- Pembuka Nav Menu -->
        <div class="container">
        
            <ul class="nav nav-tabs justify-content-center nav-fill ">
        
                <li class="nav-item ">
                    <a class="nav-link {{(request()->is('home')) ? 'active' : ''}}" style="font-weight:bold; " href="/home">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{(request()->is('kurir/perlu_dikirim')) ? 'active' : ''}}" style="font-weight:bold; " href="/kurir/perlu_dikirim">Perlu dikirim </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{(request()->is('kurir/dalam_pengiriman')) ? 'active' : ''}}" style="font-weight:bold; " href="/kurir/dalam_pengiriman">Dalam Pengiriman </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{(request()->is('kurir/penagihan')) ? 'active' : ''}}" style="font-weight:bold;" href="/kurir/penagihan">Penagihan</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{(request()->is('kurir/data_pesanan')) ? 'active' : ''}}" style="font-weight:bold;" href="/kurir/data_pesanan">Data Pesanan</a>
                </li>
              
            </ul>
        </div>
        <!-- Penutup Nav Menu -->


        <main class="py-4">
            @yield('content')
        </main>

    </div>
</body>
</html>


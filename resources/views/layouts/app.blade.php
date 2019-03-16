<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Instavel</title>
    <meta name="robots" content="noimageindex, noarchive">
    <meta name="mobile-web-app-capable" content="yes">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="Description" content="Instavel, is a basic application with some similarity to instagram. Developed by shipotech for educational uses. You can contact me through Github as shipotech: https://github.com/shipotech">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <!-- Bootstrap core CSS -->
    <noscript>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL={{ route('no-js') }}">
    </noscript>
    <link rel="stylesheet" href="{{ asset('css/bootstrap6.min.css') }}" as="style">
    <noscript><link rel="stylesheet" href="{{ asset('css/bootstrap6.min.css') }}"></noscript>
    <!-- Material Design Bootstrap -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css"></noscript>
    <!-- Your custom styles (optional) -->
    <link rel="preload" href="{{ asset('css/style.css') }}" as="style" onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/style.css') }}"></noscript>
    <!-- Font Awesome -->
    <link rel="prefetch" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"></noscript>

    <link rel="preconnect" href="https://doc-0s-4c-docs.googleusercontent.com">
    <link rel="preconnect" href="https://drive.google.com">
</head>
<body class="@if (session('isDark')) dark-mode @else @guest rgba-blue-strong @else light-mode @endguest @endif ">
<div class="se-pre-con"></div>
<header>
    <nav class="navbar fixed-top navbar-expand-lg @if (session('isDark')) navbar-dark unique-color-dark @else navbar-light light-mode @endif py-0">
        <div class="container">
            <div class="row">
                <a class="navbar-brand m-0" href="{{ route('home') }}">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-center">
                    <i class="fa fa-camera-retro" id="logo"> </i>
                        <h1 class="mx-2 mb-0 text-logo h2-responsive font-weight-bolder">| Instavel</h1>
                    </div>
                </div>
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="text-black-50 navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                    <!-- Authentication Links -->
                    @guest
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link text-indigo font-weight-bolder" href="{{ route('login') }}">{{ __('Sing In') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-indigo font-weight-bolder" href="{{ route('register') }}">{{ __('Create Account') }}</a>
                            </li>
                        @endif
                    </ul>
                    @else
                        <!--Profile Icon-->
                        <ul class="navbar-nav ml-auto">

                            <li class="nav-item">
                                <a href="{{ route('dark') }}" class="nav-link">Dark Mode
                                    @if(session('isDark'))
                                        <i class="fas fa-toggle-on"></i>
                                    @else
                                        <i class="fas fa-toggle-off"></i>
                                    @endif
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">Home</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('user.people') }}" class="nav-link">People</a>
                            </li>

                            <li class="nav-item avatar dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="preview_image2 rounded-circle z-depth-0 mx-auto pp_f2"
                                         src="@if(Auth::user()->drive_id2 === null || empty(Auth::user()->drive_id2))
                                                 https://i.ibb.co/st2Gyvk/rsz-noimage-min.png
@else {{ 'https://drive.google.com/uc?id='.Auth::user()->drive_id2.'&export=media' }} @endif"
                                         alt="avatar image" width="35" height="35">
                                </a>


                                <div class="dropdown-menu dropdown-menu-right dropdown-primary @if(session('isDark')) unique-color-dark @else white @endif" aria-labelledby="navbarDropdownMenuLink-55">
                                    <a class="dropdown-item @if(session('isDark')) text-white @else black-text @endif" href="{{ route('user.profile', ['id' => Auth::user()->id]) }}">
                                        Profile
                                    </a>

                                    <a class="dropdown-item @if(session('isDark')) text-white @else black-text @endif" href="{{ route('config') }}">
                                        Configuration
                                    </a>

                                    <a class="dropdown-item @if(session('isDark')) text-white @else black-text @endif" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                        <!-- Profile Icon -->
                    @endguest
            </div>
        </div>
    </nav>
</header>

<main class="h-100">
    @yield('content')
</main>

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js" defer></script>
<!-- Bootstrap core JavaScript -->
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript" defer></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/js/mdb.min.js" async></script>
<script src="{{ asset('js/lazysizes.min.js') }}" async></script>
<script src="{{ asset('js/ls.respimg.min.js') }}" async></script>
<!-- SCRIPTS -->

<script type="text/javascript">
    $(document).ready(function () {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");

        // Validate Register Form Client-Side
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    });
</script>
@if(Auth::user())
    <script src="{{ asset('js/profile-picture.js') }}" defer></script>
@endif
<script src="{{ asset('js/show-likes.js') }}" defer></script>
<script src="{{ asset('js/show-more.js') }}" defer></script>
<script src="{{ asset('js/likes.js') }}" defer></script>
<script src="{{ asset('js/upload.js') }}" defer></script>
<script src="{{ asset('js/image-edit.js') }}" defer></script>
<script src="{{ asset('js/prevent.js') }}" defer></script>
<script src="{{ asset('js/showpass.js') }}" defer></script>
<script src="{{ asset('js/search-people.js') }}" defer></script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Instavel</title>

    <!-- Styles -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="@if (session('isDark')) dark-mode @else @guest rgba-blue-strong @else light-mode @endguest @endif ">

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
                            <a class="nav-link text-indigo font-weight-bolder" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-indigo font-weight-bolder" href="{{ route('register') }}">{{ __('Register') }}</a>
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

                            <li class="nav-item avatar dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="@if(Auth::user()->image === null || empty(Auth::user()->image))https://i.ibb.co/2kjt747/nouser.png @elseif(Auth::user()->drive_id) {{ 'https://drive.google.com/uc?id='.Auth::user()->drive_id.'&export=media' }} @endif" class="preview_image rounded-circle z-depth-0 mx-auto" alt="avatar image" width="35" height="35">
                                </a>


                                <div class="dropdown-menu dropdown-menu-right dropdown-primary @if(session('isDark')) unique-color-dark @else white @endif" aria-labelledby="navbarDropdownMenuLink-55">
                                    <a class="dropdown-item @if(session('isDark')) text-white @else black-text @endif" href="">
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript" async></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/js/mdb.min.js"></script>
<!-- SCRIPTS -->

<script type="text/javascript">
    $(document).ready(function () {
        // Tooltips Initialization
        $('[data-toggle="tooltip"]').tooltip();

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
    <!-- Profile Picture -->
    // Function that click the <input type='file'>
    function changeProfile() {
        $('#file').click();
    }

    // Funtion that capture the value of the chosen photo
    $('#file').change(function () {
        if ($(this).val() !== '') {
            upload(this);
        }
    });

    // Function for upload the new photo Async
    function upload(img) {
        let form_data = new FormData();

        // Verify is Image (gif, jpg, png)
        let upload = img.files[0];
        let fileType = upload["type"];
        let validImageTypes = ["image/gif", "image/jpeg", "image/png"];

        // Hide error container
        $('#error').removeClass('show').addClass('d-none');

        // Verify is the fileType not is in array
        if ($.inArray(fileType, validImageTypes) < 0) {
            $('.error').text('The file must be an image (jpeg, png, gif)');
            $('#error').removeClass('d-none').addClass('show');
        } else {
        form_data.append('file', img.files[0]);
        form_data.append('_token', '{{ csrf_token() }}');

        // Show the loader animation and hide the blue mask
        $('#loading').css('display', 'block');
        $('.mask').css('display', 'none');
        $('#profile').attr('href', '#!');

        // Store the current profile photo
        @if(Auth::user())
            if(typeof currentPhoto === 'undefined') {
                var currentPhoto = "{{'https://drive.google.com/uc?id='.Auth::user()->drive_id.'&export=media'}}";
            }
        @endif

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: "{{ url('/update/photo') }}",
            data: form_data,
            contentType: false,
            processData: false,
        })
            .done(function (data) {
                if (data.fail) {
                    $('.error').text(data.errors['file']);
                    $('#error').removeClass('d-none').addClass('show');
                    $('.preview_image').attr('src', currentPhoto);
                } else {
                    $('#file_name').val(data);
                    $('.preview_image').attr('src', data);
                    currentPhoto = data;
                }
                $('#loading').css('display', 'none');
                $('.mask').css('display', 'flex');
                $('#profile').attr('href', 'javascript:changeProfile()');
            })
            .fail(function () {
                $('.preview_image').attr('src', currentPhoto);
                $('#loading').css('display', 'none');
                $('.error').text('The file must be an image (jpeg, png, gif)');
                $('#error').removeClass('d-none').addClass('show');
                $('.mask').css('display', 'flex');
                $('#profile').attr('href', 'javascript:changeProfile()');
            })
        }
    }
    <!-- Profile Picture -->
</script>
<script src="{{ asset('js/show-likes.js') }}" async></script>
<script src="{{ asset('js/upload.js') }}" defer></script>
<script src="{{ asset('js/prevent.js') }}" defer></script>
<script src="{{ asset('js/showpass.js') }}" defer></script>
<script src="{{ asset('js/likes.js') }}" defer></script>
</body>
</html>

@extends('layouts.app')

@section('content')
    <div class="container mt-lg-5 py-5">
        <div class="row justify-content-center mt-lg-5">
            <div class="col-sm-8 col-md-7 col-lg-5">
                <!-- Material form login -->
                <div class="card z-depth-1-half">
                    <h5 class="card-header indigo accent-4 white-text text-center py-4">
                        <strong>{{ __('Login') }}</strong>
                    </h5>

                    <!--Card content-->
                    <div class="card-body px-lg-5 pt-0">

                        <!-- Form -->
                        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate style="color: #757575;">
                        @csrf

                        <!-- Email -->
                            <div class="md-form">
                                <i class="fa fa-envelope prefix grey-text"></i>
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value=" {{ old('email') }}" autofocus required />
                                <label for="email">{{ __('E-Mail Address') }}</label>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Password -->
                            <div class="md-form">
                                <span class="prefix grey-text fa fa-eye" id="showpass"> </span>
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required onfocus="this.removeAttribute('readonly');" readonly />
                                <label for="password">{{ __('Password') }}</label>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6 pl-0">
                                    <!-- Remember me -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember">
                                        <label class="form-check-label col-12" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                {{--<div class="col-12 col-md-6 mt-2 mt-md-0 pr-0 text-center">--}}
                                    {{--<!-- Forgot password -->--}}
                                    {{--@if (Route::has('password.request'))--}}
                                        {{--<a class="text-indigo mx-auto" href="{{ route('password.request') }}">--}}
                                            {{--{{ __('Forgot Your Password?') }}--}}
                                        {{--</a>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            </div>

                            <!-- Sign in button -->
                            <button type="submit" class="btn btn-outline-indigo btn-rounded btn-block my-4 waves-effect z-depth-0"> {{ __('Login') }} </button>
                        </form>
                        <!-- Form -->

                    </div>

                </div>
                <!-- Material form login -->
            </div>
        </div>
    </div>
@endsection
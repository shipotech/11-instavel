@extends('layouts.app')

@section('content')
    <div class="container mt-lg-5 py-5">
        <div class="row justify-content-center mt-lg-5">
            <div class="col-sm-8 col-lg-5">
                <!-- Material form register -->
                <div class="card z-depth-1-half ">
                    <h5 class="card-header indigo accent-4 white-text text-center py-4">
                        <strong>{{ __('Create Account') }}</strong>
                    </h5>

                    <!--Card content-->
                    <div class="card-body px-lg-5 pt-0">

                        <!-- Form -->
                        <form method="POST" action="{{ route('register') }}" class="text-center needs-validation" novalidate style="color: #757575;">
                            @csrf
                            <div class="form-row">
                                <div class="col-md">
                                    <!-- First name -->
                                    <div class="md-form">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                        <label for="name">{{ __('Name') }}</label>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md">
                                    <!-- Surname -->
                                    <div class="md-form mt-0 mt-md-4">
                                        <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required>
                                        <label for="surname">{{ __('Surname') }}</label>

                                        @if ($errors->has('surname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('surname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Nick -->
                            <div class="md-form mt-0">
                                <input id="nick" type="text" class="form-control{{ $errors->has('nick') ? ' is-invalid' : '' }}" name="nick" value="{{ old('nick') }}" required />
                                <label for="nick">{{ __('Nick') }}</label>

                                @if ($errors->has('nick'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nick') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- E-mail -->
                            <div class="md-form mt-0">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required>
                                <label for="email">{{ __('E-Mail Address') }}</label>

                                <div class="invalid-feedback">
                                    Please provide a valid email.
                                </div>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Password -->
                            <div class="md-form">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" aria-describedby="help" required />
                                <label for="password">{{ __('Password') }}</label>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <small id="help" class="form-text text-muted mb-4">
                                    At least 6 characters
                                </small>
                            </div>

                            <!-- Password Confirm -->
                            <div class="md-form">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" aria-describedby="help2" required />
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <small id="help2" class="form-text text-muted mb-4">
                                    Please confirm your password
                                </small>
                            </div>

                            <div class="md-form">
                            <div class="form-group col">
                                <div class="form-check p-0 col">
                                    <input class="form-check-input" type="checkbox" value="1" id="checkbox" name="checkbox" required>
                                    <label class="form-check-label col-12" for="checkbox">
                                        Agree to terms and conditions
                                    </label>
                                    @if($errors->has('checkbox'))
                                        <div class="invalid-feedback">
                                            You must agree before submitting.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            </div>
                            <!-- Sign up button -->
                            <button class="btn btn-outline-indigo btn-rounded btn-block my-4 waves-effectz-depth-0" type="submit"> {{ __('Register') }} </button>
                            <hr>

                            <!-- Terms of service -->
                            <p>By clicking
                                <em>Sign up</em> you agree to our
                                <a href="#!" class="text-indigo" target="_blank">terms of service</a>
                            </p>
                        </form>
                        <!-- Form -->

                    </div>

                </div>
                <!-- Material form register -->
            </div>
        </div>
    </div>
@endsection
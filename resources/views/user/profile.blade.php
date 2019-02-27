@extends('layouts.app')

@section('content')
<div class="container mt-lg-4 py-5 py-lg-5">
    <div class="row">
        <div class="container mb-4">
            <div class="row justify-content-center">
            <div class="alert alert-danger fade d-none" role="alert" id="error">
                <strong>Whoops!</strong> <span class="error"></span>
            </div>

            <!--Profile Picture-->
            <div class="card testimonial-card z-depth-0 @if(session('isDark')) dark-mode @else light-mode @endif">
                <div class="mx-auto">
                    <div class="card text-center mb-3 overflow-hidden">
                    <div class="rounded-circle view overlay zoom overflow-hidden d-block mx-auto mt-4">
                        @if($user->id === Auth::user()->id)
                            <a title="Change your photo" href="javascript:changeProfile()" id="profile">
                        @endif
                            <img src="@if($user->drive_id === null || empty($user->drive_id)) https://i.ibb.co/2kjt747/nouser.png @elseif($user->drive_id) {{ 'https://drive.google.com/uc?id='.$user->drive_id.'&export=media' }} @endif" alt="profile picture" class="rounded-circle mx-auto d-block profile-photo preview_image">

                        @if($user->id === Auth::user()->id)
                            <!--Loader animation-->
                            <span id="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="position: absolute; left: 45%; top: 45%; display: none;"> </span>
                            <div class="mask flex-center text-white blue-gradient-rgba overflow-hidden rounded-circle">
                                <i class="fa fa-camera fa-2x"></i>
                            </div>
                        </a>
                        @endif
                    </div>
                    <div class="card-body">
                    @if($user->id === Auth::user()->id)
                        <input type="file" id="file" style="display: none"/>
                        <input type="hidden" id="file_name"/>
                    @endif

                    <h5 class="card-title text-dark">{{ strtolower($user->nick) }}</h5>
                    <p class="card-text">{{ ucwords($user->name . ' ' . $user->surname) }}</p>
                    <span class="mdb-color-text font-weight-bold">
                        <i class="fas fa-images text-primary"></i>
                        <span class="mr-2">
                        @if($publications)
                            @if($publications === 1)
                                {{ $publications }} publication
                            @elseif($publications === 0)
                            @else
                                {{ $publications }} publications
                            @endif
                        @endif
                        </span>

                        <i class="fas fa-heart like-color"></i>
                        <span class="mr-2">
                        @if($likes)
                            @if($likes === 1)
                                {{ $likes }} like
                            @elseif($likes === 0)
                            @else
                                {{ $likes }} likes
                            @endif
                        @endif
                        </span>

                        <i class="fas fa-comments text-indigo"></i>
                        <span>
                        @if($comments)
                            @if($comments === 1)
                                {{ $comments }} comment
                            @elseif($comments === 0)
                            @else
                                {{ $comments }} comments
                            @endif
                        @endif
                        </span>
                    </span>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Profile Picture -->


        @if(\count($user->images) === 0)
        <div class="card-columns">
            <!-- Card -->
                <div class="card card-personal">
                    <!-- Card image-->
                    <img class="card-img-top border-0" src="https://i.ibb.co/rQQ3XSW/default.jpg" alt="Card image cap">
                    <!-- Card image-->

                    <!-- Card content -->
                    <div class="card-body">
                        <!-- Title-->
                        <a>
                            <h4 class="card-title title-one text-dark">Nothing here</h4>
                        </a>
                        <!-- Text -->
                        <p class="card-text">Please, upload some Images and post amazing things.</p>
                    </div>
                    <!-- Card content -->
                </div>
                <!-- Card -->
        </div>
        @endif

    <section class="card-columns">
        @include('user.show-more')
        @include('layouts.loaders')
    </section>

    </div>
</div>

@include('like.modal')
@endsection
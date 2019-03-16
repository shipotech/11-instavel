@extends('layouts.app')

@section('content')
<div class="container mt-lg-4 py-5 py-lg-5">
    <div class="row">
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="alert alert-danger fade d-none" role="alert" id="error">
                    <strong>Whoops!</strong> <span class="error"></span>
                </div>
            </div>

            <div class="row justify-content-center">
            <!--Profile Picture-->
            <div class="card testimonial-card z-depth-0 @if(session('isDark')) dark-mode @else light-mode @endif">
                <div class="mx-auto">
                    <div class="card text-center mb-3 overflow-hidden" style="min-width: 20em;">
                    <div class="rounded-circle view overlay zoom overflow-hidden d-block mx-auto mt-4">
                        @if($user->id === Auth::user()->id)
                            <a title="Change your photo" href="javascript:changeProfile()" id="profile">
                        @endif
                            <img class="rounded-circle mx-auto d-block profile-photo preview_image pp_f"
                                    src="@if($user->drive_id1 === null || empty($user->drive_id1))
                                            https://i.ibb.co/st2Gyvk/rsz-noimage-min.png
@else {{ 'https://drive.google.com/uc?id='.$user->drive_id1.'&export=media' }} @endif"
                                 alt="profile picture">

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
                        @if($publications || $publications === 0)
                            @if($publications === 1)
                                {{ $publications }} publication
                            @elseif($publications === 0)
                                0 publications
                            @else
                                {{ $publications }} publications
                            @endif
                        @endif
                        </span>

                        <i class="fas fa-heart like-color"></i>
                        <span class="mr-2">
                        @if($likes || $likes === 0)
                            @if($likes === 1)
                                {{ $likes }} like
                            @elseif($likes === 0)
                                    0 likes
                            @else
                                {{ $likes }} likes
                            @endif
                        @endif
                        </span>

                        <i class="fas fa-comments text-indigo"></i>
                        <span>
                        @if($comments || $comments === 0)
                            @if($comments === 1)
                                {{ $comments }} comment
                            @elseif($comments === 0)
                                    0 comments
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
        <div class="row justify-content-center mx-auto">
            <div class="col-12 mb-2">
        @if(session('image-message'))
            <div class="alert alert-{{session('alert-color')}} fade show alert-dismissible" role="alert">
                <strong>{{session('title')}}</strong> {{ session('image-message') }}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            </div>
        </div>

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
        <section class="card-columns" id="show-more">
            @include('user.show-more')
        </section>
        <!-- We need to store the last ID -->
        <div class="lastId" style="display:none" id="{{ session('lastId') }}"></div>
        <div class="layout_name" style="display:none" id="{{ session('layout_name') }}"></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 p-0">
            <!-- show preloader -->
            <div class="before"></div>
            <div id="no-more"></div>
        </div>
    </div>
</div>
@include('layouts.modal-edit')
@include('like.modal')
@endsection
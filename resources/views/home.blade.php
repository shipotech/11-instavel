@extends('layouts.app')

@section('content')
<div class="container mt-lg-5 py-5">
    <div class="row justify-content-center">
        <div class="col-10 col-md-4 order-md-2 mb-5 pr-lg-5 pl-lg-5">
            <!-- Card NEW -->
                <article class="card news-card mb-5">

                    <!-- Heading-->
                    <div class="card-body w-100 py-2">
                        <div class="content d-flex">
                            <div class="row w-100 m-0 p-0">
                                <div class="col-12 p-0">
                                    <img src="@if(Auth::user()->drive_id2 === null || empty(Auth::user()->drive_id2))
                                            https://i.ibb.co/2kjt747/nouser.png
@else {{ 'https://drive.google.com/uc?id='.Auth::user()->drive_id2.'&export=media' }} @endif"
                                         class="rounded-circle avatar-img d-block d-sm-inline float-none float-sm-left mx-auto mx-sm-0 mr-sm-3" alt="avatar">
                                    <div class="col text-center text-sm-left">
                                        <p class="font-weight-bold text-dark m-0">
                                            <a class="text-dark" href="{{ route('user.profile', ['id' => Auth::user()->id]) }}" aria-label="go to {{ strtolower(Auth::user()->nick) }} profile">
                                                {{ strtolower(Auth::user()->nick) }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card content -->
                    <div class="card-body m-0 py-0">
                        <div class="alert alert-danger fade text-danger d-none text-sm" role="alert" id="error1">
                            <strong>Whoops!</strong> <span>The file must be an image (jpeg, png)</span>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger fade show text-danger text-sm" role="alert">
                                <strong>Whoops!</strong>
                                @foreach($errors->all() as $message)
                                    <span>{{ $message }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger fade show text-dark text-sm" role="alert">
                                <strong>Whoops!</strong> {{ session('error') }}.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('message'))
                            <div class="alert alert-success alert-dismissible fade show text-sm" role="alert">
                                <strong>Success!</strong> {{ session('message') }}.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="mx-auto">
                            <div class="view overlay overflow-hidden">
                                <a title="Upload your photo" href="#!" class="change_upload" id="c_1" aria-label="Upload your photo">
                                    <img src="https://i.ibb.co/jGvG5VL/upload2.png" alt="upload picture" class="card-img-top upload-preview1">
                                    <div class="mask flex-center text-white rgba-black-strong overflow-hidden">
                                        <i class="fa fa-camera fa-2x"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="form-group shadow-textarea w-100">
                            <form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data" id="upload-form" class="prevent-form-submit">
                                @csrf
                                <input type="hidden" name="form_token" value="{{ session('form_token') }}">
                                <input type="file" name="upload" id="upload-image1" style="display: none" />
                                <label for="description" class="sr-only-focusable"></label>
                                <textarea name="description" class="form-control z-depth-1" id="description" rows="2" placeholder="Write something here..." aria-label="Description, Write something here..." required></textarea>
                                <div class="row">
                                    <div class="col">
                                        <div class="d-flex justify-content-center">
                                            <div class="preloader-wrapper small active load d-none mt-2">
                                                <div class="spinner-layer spinner-blue">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="gap-patch">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                                <div class="spinner-layer spinner-red">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="gap-patch">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                                <div class="spinner-layer spinner-yellow">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="gap-patch">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                                <div class="spinner-layer spinner-green">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="gap-patch">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn primary-color-dark border-0 hoverable mt-4 m-0 w-100 white-text prevent-button-submit">
                                            <i class="fas fa-upload" aria-hidden="true"></i> Upload
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </article>
                <!-- Card -->
        </div>

        <div class="col-md-7 order-md-1" id="show-more">
            @if(session('image-message'))
            <div class="alert alert-{{session('alert-color')}} fade show alert-dismissible" role="alert">
                <strong>{{session('title')}}</strong> {{ session('image-message') }}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        @if(\count($images) === 0)
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
        @endif
            @include('layouts.show-more')
        </div>
        <!-- We need to store the last ID -->
        <div class="lastId" style="display:none" id="{{ session('lastId') }}"></div>
        <div class="layout_name" style="display:none" id="{{ session('layout_name') }}"></div>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <!-- show preloader -->
            <div class="before"></div>
            <div id="no-more"></div>
        </div>
        <div class="col-md-4">&nbsp;</div>
    </div>
</div>
@include('layouts.modal-edit')
@include('like.modal')
@endsection

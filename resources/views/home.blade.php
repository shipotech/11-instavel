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
                                    <img src="@if(Auth::user()->image === null || empty(Auth::user()->image)) https://i.ibb.co/2kjt747/nouser.png @elseif(Auth::user()->drive_id) {{ 'https://drive.google.com/uc?id='.Auth::user()->drive_id.'&export=media' }} @endif"
                                         class="rounded-circle avatar-img d-block d-sm-inline float-none float-sm-left mx-auto mx-sm-0 mr-sm-3" alt="avatar">
                                    <div class="col text-center text-sm-left">
                                        <p class="font-weight-bold text-dark m-0">
                                            {{ strtolower(Auth::user()->nick) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card content -->
                    <div class="card-body m-0 py-0">
                        <div class="alert alert-danger fade text-danger d-none text-sm" role="alert" id="error">
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
                                <a title="Upload your photo" href="javascript:changeUpload()">
                                    <img src="https://i.ibb.co/jGvG5VL/upload2.png" alt="upload picture" class="card-img-top upload-preview">
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
                                <input type="file" name="upload" id="upload-image" style="display: none" />
                                <label for="description" class="sr-only-focusable"></label>
                                <textarea name="description" class="form-control z-depth-1" id="description" rows="2" placeholder="Write something here..." required></textarea>
                                <div class="row">
                                    <div class="col">
                                        <div class="d-flex justify-content-center">
                                        <div class="preloader-wrapper small active load mt-1">
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
                                        <button type="submit" class="btn primary-color border-0 hoverable mt-4 m-0 w-100 white-text prevent-button-submit">
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

        <div class="col-md-7 order-md-1">
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

            @if($images)
            @foreach($images as $image)
                <!-- Card -->
                    <article class="card news-card mb-5">

                        <!-- Heading-->
                            <header class="card-body w-100 py-2">
                                <div class="content d-flex">
                                    <div class="row w-100 m-0 p-0">
                                        <div class="col-12 p-0">
                                            <img src="@if($image->user->drive_id === null || empty($image->user->drive_id)) https://i.ibb.co/2kjt747/nouser.png @elseif($image->user->drive_id) {{ 'https://drive.google.com/uc?id='.$image->user->drive_id.'&export=media' }} @endif"
                                                 class="rounded-circle avatar-img d-block d-sm-inline float-none float-sm-left mx-auto mx-sm-0 mr-sm-3" alt="avatar">
                                            <div class="col text-center text-sm-left">
                                            <p class="font-weight-bold text-dark m-0">
                                                {{ strtolower($image->user->nick) }}
                                            </p>

                                        <div class="text-sm text-muted font-weight-normal mt-1"><i class="fas fa-clock"></i> {{ $image->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </header>

                        <!-- Card image -->
                        <div class="view like-overlay">
                            <a href="{{ route('image.show', ['id' => $image->id]) }}" class="link-overlay">
                            <img class="card-img-top" src="@if($image->drive_id) {{ 'https://drive.google.com/uc?id='.$image->drive_id.'&export=media' }} @else https://i.ibb.co/b23YqqB/noimage.png @endif"
                                 alt="image upload by: {{ strtolower($image->user->nick) }}" style="max-height: 600px;">
                                <div class="maskaa no-opacity-like flex-center text-white rgba-black-slight mask_{{$image->id}}">
                                    <i class="fas fa-heart d-none white-text heart_{{$image->id}}"></i>
                                </div>
                            </a>
                        </div>

                        <div class="card-body pb-0 pt-3 mdb-color-text">
                            <div class="row p-0 m-0">
                                <div class="col px-0">
                                    {{-- if user logged like this Image --}}
                                    @php $user_like = false; @endphp
                                    @foreach($image->likes as $like)
                                        @if($like->user->id === Auth::user()->id)
                                            @php $user_like = true; @endphp
                                        @endif
                                    @endforeach

                                    @if($user_like)
                                        @include('like.likes')
                                    @else
                                        @include('like.dislikes')
                                    @endif

                                    <a href="{{ route('image.show', ['id' => $image->id]) }}" class="text-muted icons">
                                        @if(count($image->comments) > 0)
                                            <i class="fas fa-comments"></i>
                                        @else
                                            <i class="far fa-comments"></i>
                                        @endif
                                        {{ count($image->comments) }}
                                    </a>
                                </div>
                            </div>
                            <div class="row p-0 m-0">
                                <div class="col px-0">
                                    <p class="card-text">
                                        <a type="button" data-toggle="modal" data-target="#modal_like"
                                          class="show_likes" id="s_{{$image->id}}">
                                        <span class="mdb-color-text font-weight-bold" id="amount_{{$image->id}}">
                                            @if(count($image->likes) === 1)
                                                {{ count($image->likes) }} like
                                            @elseif(count($image->likes) === 0)
                                            @else
                                                {{ count($image->likes) }} likes
                                            @endif</span>
                                       </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Card content -->
                        <div class="card-body pb-0 pt-2 mdb-color-text">
                            <div class="collapse-content pb-3 pt-0">
                                <!-- Text -->
                                <p class="card-text collapse" id="collapseContent">
                                    <span class="black-text font-weight-bold">{{ strtolower($image->user->nick) }}</span>
                                    {{ $image->description }}
                                </p>
                            </div>
                        </div>

                    </article>
                    <!-- Card -->
            @endforeach
            @endif

                <div class="clearfix"></div>

                @if(count($images) > 5)
                <div class="d-flex justify-content-center white align-items-center align-content-center">
                    <div class="mt-3">
                        {{ $images->links() }}
                    </div>
                </div>
                @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_like" tabindex="-1" role="dialog" aria-labelledby="modal_like"
     aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">


        <div class="modal-content text-dark rounded ">
            <div class="modal-header py-2 d-flex justify-content-center align-items-center flex-row">
                <h5 class="modal-title d-flex justify-content-center mx-auto font-weight-bold" id="exampleModalLongTitle">Likes</h5>
                <button type="button" class="close m-0 p-0 d-flex justify-content-end" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Grid column -->
                <div class="col-md-12" id="show_likes">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

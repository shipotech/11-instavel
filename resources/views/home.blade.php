@extends('layouts.app')

@section('content')
<div class="container mt-lg-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-4 order-md-2 mb-5 pr-lg-5 pl-lg-5">
            {{--<!-- Card -->--}}
                {{--<div class="card promoting-card mb-2">--}}
                    {{--<!-- Card content -->--}}
                    {{--<div class="card-body d-flex flex-row py-2 align-items-center">--}}
                        {{--<!-- Avatar -->--}}
                        {{--<img src="{{ asset('storage/users/' . Auth::user()->image) }}" class="rounded-circle mr-3" height="50px" width="50px" alt="avatar">--}}
                        {{--<!-- Content -->--}}
                        {{--<div class="mdb-color-text">--}}
                            {{--<!-- Nick -->--}}
                            {{--<h4 class="card-title font-weight-bold mb-1 h5-responsive">{{ Auth::user()->name . ' ' . Auth::user()->surname}}</h4>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<!-- Card content -->--}}
                    {{--<div class="card-body m-0 py-0">--}}
                        {{--<div class="alert alert-danger fade text-danger d-none text-sm" role="alert" id="error">--}}
                            {{--<strong>Whoops!</strong> <span>The file must be an image (jpeg, png)</span>--}}
                        {{--</div>--}}

                        {{--@if($errors->any())--}}
                            {{--<div class="alert alert-danger fade show text-danger text-sm" role="alert">--}}
                                {{--<strong>Whoops!</strong>--}}
                                    {{--@foreach($errors->all() as $message)--}}
                                        {{--<span>{{ $message }}</span>--}}
                                    {{--@endforeach--}}
                            {{--</div>--}}
                        {{--@endif--}}

                        {{--@if(session('message'))--}}
                            {{--<div class="alert alert-success alert-dismissible fade show text-sm" role="alert">--}}
                                {{--<strong>Success!</strong> {{ session('message') }}.--}}
                                {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                                    {{--<span aria-hidden="true">&times;</span>--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--@endif--}}


                        {{--<div class="mx-auto">--}}
                            {{--<div class="view overlay overflow-hidden">--}}
                                {{--<a title="Upload your photo" href="javascript:changeUpload()">--}}
                                    {{--<img src="{{ asset('img/img2-escala.png') }}" alt="upload picture" class="img-fluid upload-preview w-100">--}}
                                    {{--<div class="mask flex-center text-white rgba-black-strong overflow-hidden">--}}
                                        {{--<i class="fa fa-camera fa-2x"></i>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{----}}
                        {{--<div class="form-group shadow-textarea w-100">--}}
                            {{--<form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data" id="upload-form">--}}
                                {{--@csrf--}}
                                {{--<input type="file" name="upload" id="upload-image" style="display: none" required/>--}}
                                {{--<label for="description" class="sr-only-focusable"></label>--}}
                                {{--<textarea name="description" class="form-control z-depth-1" id="description" rows="2" placeholder="Write something here..." required></textarea>--}}
                                {{--<button type="submit" class="btn indigo accent-4 border-0 hoverable float-right  mx-0 my-4 white-text">--}}
                                    {{--<i class="fas fa-upload" aria-hidden="true"></i> Upload--}}
                                {{--</button>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}
                {{--<!-- Card -->--}}


            <!-- Card NEW -->
                <article class="card news-card mb-5">

                    <!-- Heading-->
                    <div class="card-body w-100 py-2">
                        <div class="content d-flex">
                            <div class="row w-100 m-0 p-0">
                                <div class="col-12 p-0">
                                    <img src="@if(Auth::user()->image) {{ asset('storage/users/' . Auth::user()->image) }} @else {{ asset('img/img3-escala.png') }} @endif"
                                         class="rounded-circle avatar-img d-block d-sm-inline float-none float-sm-left mx-auto mx-sm-0 mr-sm-3" alt="avatar">
                                    <div class="col text-center text-sm-left">
                                        <p class="font-weight-bold text-dark m-0">
                                            {{ Auth::user()->nick }}
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
                                    <img src="{{ asset('img/img3-escala.png') }}" alt="upload picture" class="img-fluid upload-preview w-100">
                                    <div class="mask flex-center text-white rgba-black-strong overflow-hidden">
                                        <i class="fa fa-camera fa-2x"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="form-group shadow-textarea w-100">
                            <form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data" id="upload-form">
                                @csrf
                                <input type="file" name="upload" id="upload-image" style="display: none" required/>
                                <label for="description" class="sr-only-focusable"></label>
                                <textarea name="description" class="form-control z-depth-1" id="description" rows="2" placeholder="Write something here..." required></textarea>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn indigo accent-4 border-0 hoverable mt-4 m-0 w-100 white-text">
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

            @foreach($images as $image)
                <!-- Card -->
                    <article class="card news-card mb-5">

                        <!-- Heading-->
                            <header class="card-body w-100 py-2">
                                <div class="content d-flex">
                                    <div class="row w-100 m-0 p-0">
                                        <div class="col-12 p-0">
                                            <img src="@if($image->user->image) {{ asset('storage/users/' . $image->user->image) }} @else {{ asset('img/img3-escala.png') }} @endif"
                                                 class="rounded-circle avatar-img d-block d-sm-inline float-none float-sm-left mx-auto mx-sm-0 mr-sm-3" alt="avatar">
                                            <div class="col text-center text-sm-left">
                                            <p class="font-weight-bold text-dark m-0">
                                                {{ $image->user->nick }}
                                            </p>

                                        <div class="text-sm text-muted font-weight-normal mt-1"><i class="fas fa-clock"></i> {{ $image->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </header>

                        <!-- Card image -->
                        <div class="view overlay">
                            <img class="card-img-top rounded-0" src="
@if($image->user->image) {{ asset('storage/images/' . $image->image_path) }}
                            @else {{ asset('img/img3-escala.png') }} @endif"
                                 alt="Card image cap"
                                 style="@if($image->user->image) height:{{ (\Intervention\Image\Facades\Image::make(asset('storage/images/' . $image->image_path) )->height()) . 'px;' }} @else height: 400px;@endif">
                            <a href="{{ route('image.show', ['id' => $image->id]) }}">
                                <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>

                        <div class="card-body pb-0 pt-3 mdb-color-text">
                            <div class="row p-0 m-0">
                                <div class="col px-0">
                                    <a href="#" class="pr-2 text-muted icons likes">
                                        <i class="far fa-heart"></i>
                                        {{ count($image->likes) }}
                                    </a>

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
                        </div>
                        <!-- Card content -->
                        <div class="card-body pb-0 pt-2 mdb-color-text">
                            <div class="collapse-content pb-3 pt-0">
                                <!-- Text -->
                                <p class="card-text collapse" id="collapseContent">
                                    <span class="black-text font-weight-bold">{{ $image->user->nick }}</span>
                                    {{ $image->description }}
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab amet enim est fuga fugit in iste, necessitatibus non possimus quibusdam quidem reprehenderit sapiente sint suscipit temporibus tenetur ut vero voluptates.
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi doloremque eaque explicabo facere optio, ratione tempora totam. Architecto aut autem ex facere facilis harum illo neque, numquam provident tempora. Ipsa.
                                </p>
                            </div>
                        </div>

                    </article>
                    <!-- Card -->
            @endforeach
                <div class="clearfix"></div>
                <div class="d-flex justify-content-center white align-items-center align-content-center">
                    <div class="mt-3">
                        {{ $images->links() }}
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection

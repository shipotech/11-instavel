@extends('layouts.app')

@section('content')
<div class="container mt-lg-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-4 order-md-2 mb-5 pr-lg-5 pl-lg-5">
            <!-- Card -->
                <div class="card promoting-card mb-2">
                    <!-- Card content -->
                    <div class="card-body d-flex flex-row py-2 align-items-center">
                        <!-- Avatar -->
                        <img src="{{ asset('storage/users/' . Auth::user()->image) }}" class="rounded-circle mr-3" height="50px" width="50px" alt="avatar">
                        <!-- Content -->
                        <div class="mdb-color-text">
                            <!-- Nick -->
                            <h4 class="card-title font-weight-bold mb-1 h5-responsive">{{ Auth::user()->name . ' ' . Auth::user()->surname}}</h4>
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
                                    <img src="{{ asset('img/img2-escala.png') }}" alt="upload picture" class="img-fluid upload-preview w-100">
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
                                <button type="submit" class="btn indigo accent-4 border-0 hoverable float-right  mx-0 my-4 white-text">
                                    <i class="fas fa-upload" aria-hidden="true"></i> Upload
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- Card -->
        </div>

        <div class="col-md-7 order-md-1">

            @foreach($images as $image)
            <!-- Card -->
            <article class="card promoting-card mb-5">
                <!-- Card content -->
                <header class="card-body d-flex flex-row py-2 align-items-center">
                    <!-- Avatar -->
                    <img src="@if($image->user->image) {{ asset('storage/users/' . $image->user->image) }} @else {{ asset('img/img3-escala.png') }} @endif" class="rounded-circle mr-3" height="50px" width="50px" alt="avatar">
                    <!-- Content -->
                    <div class="mdb-color-text">
                        <!-- Nick -->
                        <h4 class="card-title font-weight-bold mb-1 h4-responsive">{{ $image->user->nick }}</h4>
                        <!-- Subtitle -->
                        <p class="card-text">5 min ago</p>
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

                <!-- Card content -->
                <div class="card-body">
                    <div class="collapse-content">
                        <!-- Text -->
                        <p class="card-text collapse" id="collapseContent">
                            <span class="black-text">{{ '@' . $image->user->nick }}</span>
                            {{ $image->description }}
                        </p>
                    </div>
                </div>

                <!-- Card footer -->
                <div class="rounded-bottom mdb-color lighten-3 text-center pt-3">
                    <ul class="list-unstyled list-inline">
                        <li class="list-inline-item">
                            <div class="feed-footer">
                                <a class="like">
                                    <i class="fas fa-heart pr-1"></i>
                                    <span>{{ count($image->likes) }}</span>
                                </a>
                            </div>
                            {{--<a href="#" class="white-text">--}}
                                {{--<i class="far fa-heart pr-1"></i>--}}
                                {{--{{ count($image->likes) }}--}}
                            {{--</a>--}}
                        </li>
                        <li class="list-inline-item pr-2">
                            <a href="{{ route('image.show', ['id' => $image->id]) }}" class="white-text">
                        @if(count($image->comments) > 0)
                                <i class="fas fa-comments pr-1"></i>
                            @else
                                <i class="far fa-comments pr-1"></i>
                            @endif
                            {{ count($image->comments) }}
                            </a>
                        </li>
                        <li class="list-inline-item pr-2 white-text"><i class="far fa-clock pr-1"></i>{{ $image->created_at->diffForHumans() }}</li>
                    </ul>
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

@extends('layouts.app')

@section('content')
    <section class="container mt-lg-5 py-5">
        <div class="row justify-content-center mt-lg-3">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show text-danger text-sm" role="alert">
                    <span class="text-center"><strong><i class="fas fa-exclamation-circle"></i> Whoops!</strong></span>
                    @foreach($errors->all() as $message)
                        <br><span>* {{ $message }}</span>
                    @endforeach
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-danger text-sm" role="alert">
                    <span class="text-center">
                        <strong><i class="fas fa-exclamation-circle"></i> Whoops!</strong>
                        {{ session('error') }}
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-md-12">
                <!-- Card -->
                <div class="card promoting-card mb-5 z-depth-2">
                    <div class="row">

                        <div class="col-md-7 pr-md-0">
                            <!-- Card image -->
                            <div class="w-100 white">
                                <img class="card-img-top rounded-0 d-block"
                                     src="@if($image->user->image) {{ asset('storage/images/' . $image->image_path) }} @else {{ asset('img/img3-escala.png') }} @endif"
                                     alt="Image uploaded by {{ '@' . $image->user->nick }}"
                                     style="@if($image->user->image)height:{{ (\Intervention\Image\Facades\Image::make(asset('storage/images/' . $image->image_path) )->height()) . 'px;' }}@else height: 400px;@endif">
                            </div>
                        </div>

                        <div class="col-md-5 pl-md-0"
                             style="@if($image->user->image)height:{{ (\Intervention\Image\Facades\Image::make(asset('storage/images/' . $image->image_path) )->height()) . 'px;' }}@else height: 450px;@endif">
                            <div class="h-30 news-card overflow-hidden border-bottom">

                            <!-- Heading-->
                                <div class="card-body w-100 mb-0">
                                    <div class="content d-flex align-items-center">
                                        <div class="row w-100 m-0 p-0">
                                            <div class="col-12 text-center">
                                            <img src="@if($image->user->image) {{ asset('storage/users/' . $image->user->image) }} @else {{ asset('img/img3-escala.png') }} @endif"
                                                 class="rounded-circle avatar-img d-block mx-auto" alt="avatar">
                                                <p class="font-weight-bolder text-muted m-0">
                                            {{ $image->user->nick }}
                                                </p>
                                            </div>

                                            <div class="right-side-meta ml-auto text-sm text-primary font-weight-normal align-self-center mt-0"><i class="fas fa-clock"></i> {{ $image->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column h-70">
                                <div class="scrollbar scrollbar-primary p-0 mb-0">
                                    <div class="force-overflow">
                                        <!-- Card content -->
                                        <div class="card-body pb-0 pt-2">
                                            <!-- Text -->
                                            <p class="card-text text-body">
                                                <span class="black-text font-weight-bold">{{ $image->user->nick }}</span> {{ $image->description }}
                                            </p>
                                            @if(count($image->comments) > 0)
                                                <div class="d-inline-flex w-100">
                                                    <p class="card-text mx-auto">
                                                        -- Comments <i
                                                                class="fas fa-comments"> {{ count($image->comments) }}</i>
                                                        --
                                                    </p>
                                                </div>
                                            @endif
                                            <div class="mdb-feed">
                                                @foreach($image->comments as $comment)
                                                    <div class="news mb-1">
                                                        <!-- Label -->
                                                        <div class="label">
                                                            <img src="@if($comment->user->image) {{ asset('storage/users/' . $comment->user->image) }} @else {{ asset('img/img3-escala.png') }} @endif"
                                                                 class="rounded-circle avatar-img d-block">
                                                        </div>

                                                        <!-- Excerpt -->
                                                        <div class="excerpt">
                                                            <div class="brief">
                                                                <a class="name">{{ $comment->user->nick }}</a>
                                                                <span class="card-text text-body">
                       {{ $comment->content }}
                       </span>
                                                        @if(Auth::check() && ($comment->user_id === Auth::user()->id || $comment->image->user_id === Auth::user()->id))&nbsp;
                                                            <!-- Feed footer -->
                                                                <div class="feed-footer">
                                                                    <a href="{{ route('comment.delete', ['id' => $comment->id]) }}"
                                                                       class="like float-left" title="delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            </div>
                                                        </div>
                                                        <!-- Excerpt -->
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <div class="card-body px-3 py-0">
                                        <form action="{{ route('comment.store') }}" method="post" id="comment-form">
                                        @csrf
                                        <!--Material textarea-->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="col p-0">
                                                    <div class="md-form h5-responsive">
                                                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                                                        <textarea type="text" id="form7" name="content"
                                                                  class="md-textarea form-control py-2" rows="1"
                                                                  cols="1"></textarea>
                                                        <label for="form7">Comment here...</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="md-form">
                                                        <a type="button" class="btn-floating indigo accent-4"
                                                           onclick="event.preventDefault(); document.getElementById('comment-form').submit();">
                                                            <i class="far fa-comment" aria-hidden="true"></i></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card -->
            </div>
        </div>
    </section>
@endsection
@extends('layouts.app')

@section('content')
<article class="container mt-lg-5 py-5">
    <div class="row justify-content-center mt-lg-3">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show text-danger text-sm" role="alert">
                <span class="text-center"><strong><i class="fas fa-exclamation-circle"></i> Whoops!</strong></span>
                @foreach($errors->all() as $message)
                    <br><span>* {{ $message }}</span>
                @endforeach
                <button type="button" class="close py-2" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show text-sm" role="alert">
                <strong>Success!</strong> {{ session('message') }}.
                <button type="button" class="close py-2" data-dismiss="alert" aria-label="Close">
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
                <button type="button" class="close py-2" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <div class="container">
        <!-- Section: Personal card -->
        <section class="m-0 mb-5 w-100 p-0">
            <!-- Grid row -->
            <div class="row h-100 z-depth-1">
                <!-- Grid column -->
                <div class="col-md-7 px-0">
                    <!-- Card -->
                    <div class="card card-personal h-100 rounded-0 z-depth-0">
                        <!-- Card image-->
                        <img class="card-img-top rounded-0 h-100 min-img"
                             src="@if($image->drive_id) {{ 'https://drive.google.com/uc?id='.$image->drive_id.'&export=media' }} @else https://i.ibb.co/b23YqqB/noimage.png @endif"
                             alt="Image uploaded by {{ '@' . strtolower($image->user->nick) }}">
                        <!-- Card image-->
                    </div>
                    <!-- Card -->
                </div>
                <!-- Grid column -->
                <div class="col-md-5 px-0">
                    <!-- Card -->
                    <div class="card card-personal h-100 white rounded-0 z-depth-0">
                        <header class="h-30 news-card border-bottom">
                            <!-- Heading-->
                            <div class="card-body w-100 h-100 pb-0 pt-2">
                                <div class="content h-100">
                                    <div class="row w-100 h-100 m-0 p-0">
                                        <div class="col-12 text-center">
                                            <img src="@if($image->user->drive_id === null || empty($image->user->drive_id)) https://i.ibb.co/2kjt747/nouser.png @elseif($image->user->drive_id) {{ 'https://drive.google.com/uc?id='.$image->user->drive_id.'&export=media' }} @endif"
                                                 class="rounded-circle avatar-img d-block mx-auto" alt="avatar">
                                            <p class="font-weight-bolder text-muted m-0">
                                                <a href="{{ route('user.profile', ['id' => $image->user->id]) }}">
                                                {{ strtolower($image->user->nick) }}
                                                </a>
                                            </p>
                                        </div>
                                        <div class="col-12">
                                        <p class="text-muted text-sm font-weight-normal m-0 p-0 text-right"><i class="fas fa-clock"></i> {{ $image->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <div class="d-flex flex-column h-70 overflow-hidden">
                            <div class="scrollbar scrollbar-primary p-0 mb-0">
                                <div class="force-overflow">
                                    <!-- Card content -->
                                    <div class="card-body pb-0 pt-2">
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
                                        <!-- Text -->
                                        <p class="card-text text-body text-pre">
                                            <span class="black-text font-weight-bold">{{ strtolower($image->user->nick) }}</span> {{ $image->description }}
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
                                                    <div class="label text-center">
                                                        <img src="@if($comment->user->drive_id === null || empty($comment->user->drive_id)) https://i.ibb.co/2kjt747/nouser.png @elseif($comment->user->drive_id) {{ 'https://drive.google.com/uc?id='.$comment->user->drive_id.'&export=media' }} @endif"
                                                             class="rounded-circle avatar-img d-block">
                                                    </div>

                                                    <!-- Excerpt -->
                                                    <div class="excerpt">
                                                        <div class="brief">
                                                            <div class="p-0 d-flex align-items-center justify-content-between w-100">
                                                            <a class="name" href="{{ route('user.profile', ['id' => $comment->user->id]) }}">{{ strtolower($comment->user->nick) }}</a>
                                                                @if(Auth::check() && ($comment->user_id === Auth::user()->id || $comment->image->user_id === Auth::user()->id))
                                                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="likes mdb-color-text text-sm" title="delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex align-items-start justify-content-start">
                                                            <p class="card-text text-body">
                                                                {{ $comment->content }}
                                                            </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Excerpt -->
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <footer class="mt-auto">
                                <div class="card-body px-3 py-0">
                                    <form action="{{ route('comment.store') }}" method="post" id="comment-form" class="prevent-form-submit">
                                        @csrf
                                        <input type="hidden" name="form_token" value="{{ session('form_token') }}">
                                        <!--Material textarea-->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="col p-0">
                                                <div class="md-form h5-responsive">
                                                    <input type="hidden" name="image_id" value="{{ $image->id }}">
                                                    <textarea type="text" id="form7" name="content"
                                                              class="md-textarea form-control py-2" rows="1"
                                                              cols="1" required></textarea>
                                                    <label for="form7">Comment here...</label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="md-form">
                                                    <button type="submit" class="btn-floating btn-rounded border-0 primary-color white-text prevent-button-submit"><i class="far fa-comment"></i>
                                                        <i class="fas fa-circle-notch fa-spin load"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </footer>
                        </div>
                    </div>
                    <!-- Card -->
                </div>
            </div>
            <!-- Grid row -->
        </section>
        <!-- Section: Personal card -->
    </div>
</article>

    @include('like.modal')
@endsection
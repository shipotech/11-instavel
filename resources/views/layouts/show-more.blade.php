@if($images)
    @foreach($images as $image)
        <!-- Card -->
        <article class="card news-card mb-5">

            <!-- Heading-->
            <header class="card-body w-100 py-2">
                <div class="content d-flex">
                    <div class="row w-100 m-0 p-0">
                        <div class="col p-0">
                            <div class="rounded-circle avatar-img d-block d-sm-inline float-none float-sm-left mx-auto mx-sm-0 mr-sm-3">
                                <img src="@if($image->user->drive_id2 === null || empty($image->user->drive_id2))
                                    https://i.ibb.co/st2Gyvk/rsz-noimage-min.png
@else {{ 'https://drive.google.com/uc?id='.$image->user->drive_id2.'&export=media' }} @endif"
                             class="rounded-circle avatar-img" alt="avatar">
                            </div>
                            <div class="col text-center text-sm-left">
                                <p class="font-weight-bold text-dark m-0">
                                    <a href="{{ route('user.profile', ['id' => $image->user->id]) }}" aria-label="go to {{ strtolower($image->user->nick) }} profile">
                                        {{ strtolower($image->user->nick) }}
                                    </a>
                                </p>

                                <div class="text-sm text-muted font-weight-normal mt-1"><i class="fas fa-clock"></i> {{ $image->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @if(Auth::user() && Auth::user()->id === $image->user->id)
                            <div class="p-0 d-flex align-items-center justify-content-end grey-text">
                                <!--Dropdown primary-->
                                <div class="dropdown dropleft">
                                    <!--Trigger-->
                                    <a class="text-decoration-none" type="button" id="dropdownMenu1"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="menu">
                                        <i class="fas fa-ellipsis-v icon-menu"></i>
                                    </a>
                                    <!--Menu-->
                                    <div class="dropdown-menu dropdown-primary">
                                        <a type="button" data-toggle="modal" data-target="#image_edit"
                                           class="image_edit dropdown-item" id="s_{{$image->id}}" aria-label="edit">
                                            Edit</a>

                                        <a type="button" data-toggle="modal"
                                           data-target="#modalConfirmDelete{{$image->id}}" class="dropdown-item" aria-label="delete">
                                            Delete</a>
                                    </div>
                                </div>
                                <!--/Dropdown primary-->
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Card image -->
            <div class="view like-overlay bg-dark">
                <a href="{{ route('image.show', ['id' => $image->id]) }}" class="link-overlay" aria-label="show image by: {{ strtolower($image->user->nick) }}">
                    <img class="card-img-top lazyload rounded-0"
                         src="@if($image->drive_id4 === null || empty($image->drive_id4))
                                 https://i.ibb.co/b23YqqB/noimage.png
@else {{'https://drive.google.com/uc?id='.$image->drive_id4.'&export=media'}} @endif"
                         @if($image->drive_id2 !== null || !empty($image->drive_id2))
                         data-srcset="
{{'https://drive.google.com/uc?id='.$image->drive_id3.'&export=media 420w'}},
{{'https://drive.google.com/uc?id='.$image->drive_id2.'&export=media 640w'}},
{{'https://drive.google.com/uc?id='.$image->drive_id1.'&export=media 860w'}}"
                         data-src="
{{'https://drive.google.com/uc?id='.$image->drive_id2.'&export=media'}}"
                         @endif
                         alt="image uploaded by: {{ strtolower($image->user->nick) }}" style="max-height: 700px;">
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

                        <a href="{{ route('image.show', ['id' => $image->id]) }}" class="text-muted icons" aria-label="show comments">
                            @if(count($image->comments) > 0)
                                <i class="fas fa-comments"></i>
                                {{ count($image->comments) }}
                            @else
                                <i class="far fa-comments"></i>
                            @endif
                        </a>
                    </div>
                </div>
                <div class="row pt-2 pb-0 m-0">
                    <div class="col px-0">
                        <p class="card-text">
                            <a type="button" data-toggle="modal" data-target="#modal_like"
                               class="show_likes" id="s_{{$image->id}}" aria-label="show people who like this">
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
        @php session(['lastId' => $image->id]); @endphp
       @include('layouts.modal-confirm')
    @endforeach
        @php session(['layout_name' => 'home']); @endphp
@endif
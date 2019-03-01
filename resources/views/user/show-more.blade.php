@if($images)
    @foreach($images as $image)
        <!-- Card -->
        <article class="card news-card">
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

            <!-- Card items-->
            <div class="card-body pb-0 pt-3 mdb-color-text">
                <div class="row p-0 m-0">
                    <div class="col px-0 d-flex w-100">
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

                        <span class="text-sm text-muted font-weight-normal ml-auto text-right align-self-center"><i class="fas fa-clock"></i> {{ $image->created_at->diffForHumans() }}</span>
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

            <!-- Card footer -->
            <footer class="card-body pb-0 pt-2 mdb-color-text">
                <div class="collapse-content pb-3 pt-0">
                    <!-- Text -->
                    <p class="card-text collapse" id="collapseContent">
                        <span class="black-text font-weight-bold">{{ strtolower($image->user->nick) }}</span>
                        {{ $image->description }}
                    </p>
                </div>
            </footer>

        </article>
        <!-- Card -->
        @php session(['lastId' => $image->id]); @endphp
    @endforeach
        @php session(['layout_name' => 'profile']); @endphp
@endif
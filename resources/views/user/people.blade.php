@if($users)
    @foreach($users as $user)
        <!-- Card -->
        <div class="col-md-4">
        <div class="card testimonial-card mb-4">
            <!-- Background color -->
            <div class="card-up {{ $color[array_rand($color)] }}"></div>
            <!-- Avatar -->
            <div class="light-mode">
                <div class="avatar mx-auto white light-mode zoom">
                    <a href="{{ route('user.profile', ['id' => $user->id]) }}">
                    <img src="@if($user->drive_id === null || empty($user->drive_id))
                            https://i.ibb.co/2kjt747/nouser.png @elseif($user->drive_id) {{ 'https://drive.google.com/uc?id='.$user->drive_id.'&export=media' }}
                    @endif" alt="profile picture of {{ strtolower($user->nick) }}"
                         class="rounded-circle" style="height: 110px; width: 110px;">
                    </a>
                </div>
            </div>
            <!-- Content -->
            <div class="card-body light-mode p-0">
                <div class="card-body py-0">
                <!-- Name -->
                <h5 class="card-title text-dark">
                    <a href="{{ route('user.profile', ['id' => $user->id]) }}">{{ strtolower($user->nick) }}</a>
                </h5>
                <p class="card-text">{{ ucwords($user->name . ' ' . $user->surname) }}</p>
                <p class="card-text text-right mb-0">Joined on {{ $user->created_at->englishMonth .' '. $user->created_at->year}}</p>
                </div>
                <hr class="m-0 pb-2">
                <div class="card-body py-0">
                    <!-- Quotation -->
                    <div class="text-left mdb-color-text font-weight-bold pb-2">
                        <div>
                            <i class="fas fa-images text-primary fa-fw"></i>
                            @php $publications = \count($user->images); @endphp
                            @if($publications || $publications === 0)
                                @if($publications === 1)
                                    {{ $publications }} publication
                                @elseif($publications === 0)
                                    0 publications
                                @else
                                    {{ $publications }} publications
                                @endif
                            @endif
                        </div>
                        <div>
                            <i class="fas fa-heart like-color fa-fw"></i>
                            @php $likes = \count($user->likes); @endphp
                            @if($likes || $likes === 0)
                                @if($likes === 1)
                                    {{ $likes }} like
                                @elseif($likes === 0)
                                    0 likes
                                @else
                                    {{ $likes }} likes
                                @endif
                            @endif
                        </div>
                        <div>
                            <i class="fas fa-comments text-indigo fa-fw"></i>
                            @php $comments = \count($user->comments); @endphp
                            @if($comments || $comments === 0)
                                @if($comments === 1)
                                    {{ $comments }} comment
                                @elseif($comments === 0)
                                    0 comments
                                @else
                                    {{ $comments }} comments
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Card -->

@php session(['lastId' => $user->id]); @endphp

    @endforeach
@php session(['layout_name' => 'people']); @endphp
@endif
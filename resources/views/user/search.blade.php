@if($users)
    @foreach($users as $user)
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
            <div class="card-body py-2 border-bottom">
                <div class="content d-flex">
                    <div class="row w-100 m-0 p-0">
                        <div class="col p-0">
                            <img src="@if($user->drive_id2 === null || empty($user->drive_id2))
                                    https://i.ibb.co/st2Gyvk/rsz-noimage-min.png
@else {{ 'https://drive.google.com/uc?id='.$user->drive_id2.'&export=media' }} @endif"
                                 class="rounded-circle avatar-img3 d-block d-sm-inline float-none float-sm-left mx-auto mx-sm-0 mr-sm-3"
                                 alt="avatar">
                            <div class="col text-center text-sm-left text-sm">
                                <p class="font-weight-bold text-dark m-0">
                                    <span>{{ strtolower($user->nick) }}</span>
                                </p>
                                <div class="text-sm text-muted font-weight-normal mt-1">
                                    {{ ucwords($user->name . ' ' . $user->surname) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@endif
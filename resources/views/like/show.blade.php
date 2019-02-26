@foreach($likes as $like)
<!-- Card -->
<article class="card news-card z-depth-0 px-0">
    <header class="card-body w-100 py-2 px-0">
        <div class="content d-flex">
            <div class="row w-100 m-0 p-0">
                <div class="col-12 p-0">
                    <img src="@if($like->user->drive_id === null || empty($like->user->drive_id)) https://i.ibb.co/2kjt747/nouser.png @elseif($like->user->drive_id) {{ 'https://drive.google.com/uc?id='.$like->user->drive_id.'&export=media' }} @endif"
                         class="rounded-circle avatar-img2 d-block float-left mx-0 mr-3" alt="avatar">
                    <div class="col text-left">
                        <p class="font-weight-bold text-dark m-0">
                            <a href="#!">{{ $like->user->nick }}</a>
                        </p>

                        <div class="text-sm text-muted font-weight-normal mt-1">{{ $like->user->name .' '. $like->user->surname }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</article>
@endforeach
@if($image)
<div class="row justify-content-center">
    <div class="col-12 p-0">
        <!-- Card NEW -->
        <article class="card news-card z-depth-0">
            <!-- Heading-->
            <div class="card-body w-100 py-2">
                <div class="content d-flex">
                    <div class="row w-100 m-0 p-0">
                        <div class="col-12 p-0">
                            <img src="@if(Auth::user()->drive_id2 === null || empty(Auth::user()->drive_id2))
                                    https://i.ibb.co/st2Gyvk/rsz-noimage-min.png
@else {{ 'https://drive.google.com/uc?id='.Auth::user()->drive_id2.'&export=media' }} @endif"
                                 class="rounded-circle avatar-img d-block float-none mx-auto" alt="avatar">
                            <div class="col text-center">
                                <p class="font-weight-bold text-dark m-0">
                                    <a href="{{ route('user.profile', ['id' => Auth::user()->id]) }}">
                                        {{ strtolower(Auth::user()->nick) }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card content -->
            <div class="card-body m-0 py-0">
                <div class="alert alert-danger fade text-danger d-none text-sm" role="alert" id="error2">
                    <strong>Whoops!</strong> <span>The file must be an image (jpeg, png)</span>
                </div>

                <div class="mx-auto">
                    <div class="view overlay overflow-hidden bg-dark">
                        <a title="Upload your photo" href="#!" class="change_upload" id="c_2">
                            <img class="card-img-top upload-preview2 lazyload"
                                 src="@if($image->drive_id4 === null || empty($image->drive_id4))
                                         https://i.ibb.co/b23YqqB/noimage.png
@else {{'https://drive.google.com/uc?id='.$image->drive_id4.'&export=media'}} @endif"
                                 @if($image->drive_id3 !== null || !empty($image->drive_id3))
                                 data-srcset="
{{'https://drive.google.com/uc?id='.$image->drive_id3.'&export=media 420w'}}"
                                 data-src="
{{'https://drive.google.com/uc?id='.$image->drive_id3.'&export=media'}}"
                                 @endif
                                 alt="upload your photo" style="max-height: 400px; min-height: 250px;">
                            <div class="mask flex-center text-white rgba-black-strong overflow-hidden rounded">
                                <i class="fa fa-camera fa-2x"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="form-group shadow-textarea w-100 mb-0">
                    <form action="{{ route('image.update') }}" method="post" enctype="multipart/form-data" id="upload-form" class="prevent-form-submit2">
                        @csrf
                        <input type="hidden" name="form_token" value="{{ session('form_token') }}">
                        <input type="hidden" name="image_id" value="{{ $image->id }}" />
                        <input type="file" name="upload" id="upload-image2" accept="image/*" style="display: none" />
                        <label for="description" class="sr-only-focusable"></label>
                        <textarea name="description" class="form-control z-depth-1" id="description" rows="3" required>{{$image->description}}</textarea>
                        <div class="row">
                            <div class="col">
                                <div class="d-flex justify-content-center">
                                    <div class="preloader-wrapper small active load2 d-none mt-2">
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
                        <div class="row justify-content-end mt-2 px-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm prevent-button-submit2">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </div>
</div>
@endif
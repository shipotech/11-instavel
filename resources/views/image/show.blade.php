@extends('layouts.app')

@section('content')
    <div class="container mt-lg-5 py-5">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <!-- Card -->
                <div class="card promoting-card mb-5 z-depth-2">
                    <div class="row">

                        <div class="col-md-7 p-md-0">
                            <!-- Card image -->
                            <div class="view overlay">
                                <img class="card-img-top rounded-0"
                                     src="@if($image->user->image) {{ asset('storage/images/' . $image->image_path) }} @else {{ asset('img/img3-escala.png') }} @endif"
                                     alt="Image uploaded by {{ '@' . $image->user->nick }}" height="500px"
                                     width="500px">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="h-25">
                                <!-- Card content -->
                                <div class="card-body d-flex flex-row px-3 pt-4 pb-0">
                                    <div class="col d-flex align-self-start p-0">
                                    <!-- Avatar -->
                                    <img src="@if($image->user->image) {{ asset('storage/users/' . $image->user->image) }} @else {{ asset('img/img3-escala.png') }} @endif"
                                         class="rounded-circle mr-3" height="50px" width="50px" alt="avatar">
                                    <!-- Content -->
                                    <div class="col d-flex align-self-start p-0">
                                        <div class="mdb-color-text p-0">
                                            <!-- Nick -->
                                            <h4 class="card-title font-weight-bold mb-1 h5-responsive">{{ $image->user->nick }}</h4>
                                            <!-- Subtitle -->
                                            <p class="card-text"><i class="far fa-clock"></i> {{ $image->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-body px-3 py-0">
                                    <hr class="hr-bold">
                                </div>
                            </div>

                            <div class="d-flex flex-column h-75">
                                <div class="scrollspy-example p-0">
                                    <!-- Card content -->
                                    <div class="card-body px-3 py-0">
                                        <div class="black-text">
                                            <!-- Text -->
                                            <p class="card-text text-body">
                                                <span class="black-text font-weight-bold">{{ '@' . $image->user->nick }}</span>
                                                {{ $image->description }}
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid,
                                                asperiores debitis dicta dolore, ea esse exercitationem fuga id, in
                                                natus nemo non pariatur quaerat quas quidem repudiandae sit tempora
                                                ullam.
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam
                                                aperiam autem illum possimus quae! Ab aliquam ipsam minus praesentium,
                                                provident quia totam. Aspernatur blanditiis dolore maxime repudiandae
                                                soluta voluptatibus, voluptatum?
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus,
                                                beatae distinctio dolorum ea, incidunt iste numquam quaerat quibusdam
                                                repellendus repudiandae sequi sit temporibus vitae! Beatae cupiditate
                                                dolorem enim magni modi.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <div class="card-body px-3 py-0">
                                        <form action="" method="post">
                                        @csrf
                                        <!--Material textarea-->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="col p-0">
                                                <div class="md-form h5-responsive">
                                                    <textarea type="text" id="form7"
                                                              class="md-textarea form-control py-2" rows="1"
                                                              cols="1"></textarea>
                                                    <label for="form7">Comment here...</label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="md-form">
                                                    <a type="button" class="btn-floating indigo accent-4"><i class="far fa-comment" aria-hidden="true"></i></a>

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
    </div>
@endsection
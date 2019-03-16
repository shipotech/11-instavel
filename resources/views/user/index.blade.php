@extends('layouts.app')

@section('content')
    <div class="container mt-lg-4 py-5 py-lg-5">
        <div class="row justify-content-center mb-4 text-dark">
            <div class="card py-0 z-depth-0 border">
                <div class="card-body align-items-center justify-content-center flex-column d-flex py-0">
                    <h2 class="h3-responsive font-weight-bold text-center pb-0 mt-2">People</h2>
                    <!-- Search form -->
                    <div class="md-form m-0">
                        <form method="post" class="form-inline md-form form-sm">
                            <input type="search" id="search-people"
                                   class="form-control form-control-sm mdb-autocomplete w-75 mr-3"
                                   onfocus="this.removeAttribute('readonly');" readonly autocomplete="off"/>
                            <label for="search-people" class="active">Search</label>
                            <a type="button" class="likes" id="search-button">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </a>
                        </form>
                    </div>
                    <div class="peoplee text-center d-none">
                            {{--<i class="fas fa-caret-up fa-2x text-center m-0 p-0"></i>--}}
                        <div class="caret-people"></div>
                        <div class="div-people scrollbar-primary p-0 mb-0 z-depth-1-half border rounded">
                            <div class="div-people2">
                                <!-- Card -->
                                <div class="card news-card" id="show-people">

                                </div>
                                <!-- Card -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="show-more">
        @include('user.people')
        <!-- Profile -->

            <!-- We need to store the last ID -->
            <div class="lastId" style="display:none" id="{{ session('lastId') }}"></div>
            <div class="layout_name" style="display:none" id="{{ session('layout_name') }}"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- show preloader -->
                <div class="before"></div>
                <div id="no-more"></div>
            </div>
        </div>
    </div>
@endsection
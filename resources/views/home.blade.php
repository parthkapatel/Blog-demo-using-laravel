@extends('layouts.app')

@section("title",config('app.name'))
@section('content')

    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 img-fluid" src="/img/sigmund-HsTnjCVQ798-unsplash.jpg"
                     style="width:100%;height:auto;min-height: 625px;" alt="Images">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Planning</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 img-fluid" src="/img/thumbnail-image.jpg" style="width:100%;height:auto;min-height: 625px;"
                     alt="Images">
                <div class="carousel-caption d-none d-md-block">
                    <h5>House</h5>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carousel" data-slide="prev" role="button">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" data-slide="next" role="button">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

@endsection

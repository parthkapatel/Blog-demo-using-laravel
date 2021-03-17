@extends("layouts.app")

@section("title","Blogs")

@section("content")
    <div class="container-fluid p-5" style="background-color: rgba(253,251,251,0.7);min-height:650px;">
        @if(isset($blogs))
            <div class="container-fluid ">
                <!---->
                @foreach ($blogs as $blog)

                    <div class="container p-0 my-5 blog-post">
                        <div class="container blog-post-img p-0"
                             style="@if($blog->image_path != null ) height: 500px; @else height:auto; @endif">
                            @if($blog->image_path !== null)
                                <img src="../../img/{{ $blog->image_path }}" width="100%" height="100%"
                                     class="img-fluid">
                            @endif
                        </div>
                        <div class="container clearfix px-4 py-2 blog-post-title">
                            <h2>{{ $blog->title }}</h2>
                            <h6>Author : <b>{{ $blog->name }}</b></h6>
                            <h6 class="date text-secondary">Published Date
                                : {{ date('j F, Y', strtotime($blog->created_at)) }}</h6>
                            <hr>
                            <p class="text-truncate text-justify">{{ $blog->description }}</p>
                            <a href="/blogs/{{ $blog->id }}" class="btn btn-primary float-right" name="submit" id="post"
                               value="{{ $blog->id }}">Read More...
                            </a>
                        </div>
                    </div>

                @endforeach
                <div class="container">{{  $blogs->links() }}</div>

                @else
                    <div class="container blog-post">
                        <span class="text-info display-2">No Data Found</span>
                    </div>
                @endif
            </div>
    </div>
@endsection

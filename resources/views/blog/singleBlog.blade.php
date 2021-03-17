@extends("layouts.app")


@section("title", $blog->title )

@section("content")
    <div class="container mb-4 w-auto h-100"
         style="background-color: rgba(255, 255, 255, 0.3);min-height:650px;margin-top:80px;border-radius: 20px;box-shadow: 0px 0px 20px rgba(67, 67, 67, 0.3) ;">
        <div class="container p-1">
            <div class="container-fluid px-4 py-4 blog-post-title">
                <a href="/blogs" title="Back">
                    <div class="p-1 m-1 float-left">
                        <img src="../../img/back-arrow.png" width="32px" height="32px">
                    </div>
                </a>
                <div class="p-1 m-1">
                    <h2 style="display: none;" id="id">{{ $blog->id }}</h2>
                    <h2>{{ $blog->title }}</h2>
                </div>
                <hr>
                <div class="container m-0 p-0 clearfix">
                    <h6 class="float-left ">By <b>{{ $blog->name }}</b>&nbsp;<span

                            class="date text-secondary">{{ date('j F, Y', strtotime($blog->created_at)) }}</span>
                    </h6>
                    <h6 class="float-right text-secondary" id="view_counter">Views : {{ $blog->total_views }}</h6>
                </div>
                <hr>
            </div>
            @if($blog->image_path !== null)
                <div class="container  p-0">
                    <img src="../../img/{{ $blog->image_path }}" width="100%" style="height: 600px;min-height: 600px;"
                         class="img-fluid">
                </div>
            @endif
            <div class="container p-3 blog-post-title">
                <p class="text-justify text-break">{{ $blog->description }}</p>
            </div>
            <hr>
            <div class="container" id="LandD">

                <img id="likeimg" class="p-1 pb-2" width="32px" height="32px" style="cursor: pointer"><span class=""
                                                                                                            id="like"></span>
                <img id="dislikeimg" class="p-1 pt-2" width="32px" height="32px"
                     style="transform: scaleX(-1); cursor: pointer"><span class="" id="dislike"></span>

                <span class="float-right btn btn-primary" id="comment">Comments <b id="c_counter">0</b></span>
            </div>
            <hr>
            <div class="container m-0 p-0 clearfix" id="LandD">
                @if(isset($previous->id) && $previous->id != null)
                    <a href="/blogs/{{$previous->id}}" title="{{$previous->title}}" id="previous">
                        <div class="container  text-left w-auto float-left">
                            <img src="../../img/left-arrow.png" width="40px" height="40px">{{$previous->title}}
                        </div>
                    </a>
                @endif

                @if(isset($next->id) && $next->id != null)
                    <a href="/blogs/{{$next->id}}" title="{{$next->title}}" id="next">
                        <div class="container  text-right w-auto float-right">
                            {{$next->title}}<img src="../../img/arrow-point-to-right.png" width="40px" height="40px">
                        </div>
                    </a>
                @endif
            </div>
            <hr>
            <!--style="display: none;"-->
            <div class="container p-2 commentSection" id="comment-section"
                 style="width:100%;{{ (count($comments) != 0) ? "height:680px;overflow-y: scroll;" : 'height:auto;display:none;' }}">
                <div class="container clearfix p-2 overflow-auto" id="co">
                @foreach($comments as $comment)
                    <!--    Login User Comments -->

                        <div class='container mb-3 float-right bg-secondary comment-post w-75'>
                            <div class='container clearfix w-100'>
                                <h6 class='text-white float-left '>{{ $comment->name }}</h6>
                                <h6 class='float-left text-warning'>
                                    &nbsp{{ date('j F, Y H:i', strtotime($comment->created_at)) }}</h6>
                                <button type='button'
                                        class='text-right  reply float-right text-white btn btn-primary'
                                        value='{{ $comment->id }}' style='cursor: pointer;'>Reply
                                </button>
                            </div>
                            <hr class='m-2 bg-warning'>
                            <div class='container '>
                                <p class=' text-white '>
                                    {{ $comment->comment_message }}
                                </p>
                            </div>

                            <!--    Sub Comment Data-->
                            <script> getNestedCommentData(<?php echo $comment->id ?>); </script>

                            <div class="container m-0 p-0" id="nestedCommentSection{{$comment->id}}">

                            </div>


                            <!--    Reply Form    -->
                            <div class='container p-2 w-75 float-right bg-white rounded' id='{{ $comment->id }}'
                                 style="display: none;">
                                <label for='name'
                                       class='text-primary'>{{\Illuminate\Support\Facades\Auth::user()->name}}</label>
                                <textarea cols='20' rows='3' class='form-control commentReply'
                                          id='commentReply{{ $comment->id }}'
                                          placeholder='Type Comment Here.....' value=''></textarea>
                                <label class=" replyError{{ $comment->id }}"></label>
                                <button name='sub' id='sub' value='{{ $comment->id }}'
                                        class='sub btn btn-success m-2 float-right'>Post Comment
                                </button>

                                <div class='alert alert-success alert-dismissible fade show' id='success'
                                     style='display:none;'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                            </div>
                            <!--   End Reply Form    -->

                        </div>


                    @endforeach


                </div>
                <img src="../../img/up-arrow.png" width="50px" height="50px" style="cursor: pointer;" id="upArrow" class="p-2" title="go to top">
            </div>

            <div class="container mb-3 p-3 float-center bg-light border border-rounded">
                <form method="POST" action="/blog/{{ $blog->id }}/comment">
                    @csrf
                    @method("put")
                    <div class="form-group">
                        <label for="name" class="text-primary">{{ Auth::user()->name }}</label>
                        <textarea rows="5" class="form-control @error('comment_message') is-invalid @enderror"
                                  id="comment_message" name="comment_message" autocomplete="comment_message"
                                  placeholder="Enter your Comment..."
                                  cols="20">{{ old('comment_message') }}</textarea>
                        @error('comment_message')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            Post Comment
                        </button>
                    </div>
                    @if(session("msg"))
                        <div class="alert alert-success">
                            {{session("msg")}}
                        </div>
                    @endif
                </form>
            </div>

        </div>
    </div>

    <script>
        window.onload = getLikeDislike();
    </script>
@endsection

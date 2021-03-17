@extends("layouts.app")

@section("title","Your Blogs")

@section("content")
    <div class="container-fluid p-5">
        <div class="table-responsive blog-post h-100">
            <h3 class="display-4 text-danger text-center p-2">Your Uploded Blogs</h3>

            @if(session("msg"))
                <div class="w-auto float-right">
                    <div class="alert alert-success">
                        {{session("msg")}}
                    </div>
                </div>
            @endif
            <table class="table table-hover text-center table-light usersTable p-0 m-0">
                <thead class="thead usersTable-head">
                <tr class="text-light bg-dark">
                    <th>Id</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Views</th>
                    <th>Created At</th>
                    <th>Update At</th>
                    <th>Publish Status</th>
                    <th>Total Likes</th>
                    <th>Total DisLikes</th>
                    <th>Total Comments</th>
                    <th>Update Block</th>
                    <th>Delete Blog</th>
                </tr>
                </thead>
                <tbody class="tbody usersTable-body ">
                @if(count($blogs) > 0)
                    @foreach ($blogs as $blog)
                        <tr class='{{  (($blog->status == "draft" ? 'bg-secondary text-white' : 'bg-success text-white')) }}'>
                            <td>{{ $blog->id }}</td>
                            @if($blog->status == "publish")
                                <td><a href='/blogs/{{$blog->id}}' class="text-white">{{ $blog->title }}</a></td>
                            @else
                                <td>{{ $blog->title }}</td>
                            @endif
                            @if($blog->image_path != null)
                                <td><img src="../../img/{{ $blog->image_path }}" width='100px' height='100px'></td>
                            @else
                                <td class="text-center my-auto text-dark"><h5><b>No Image</b></h5></td>
                            @endif
                            <td>{{ $blog->total_views }}</td>
                            <td>{{ date('d-m-Y h:i', strtotime($blog->created_at)) }}</td>
                            <td>{{ date('d-m-Y h:i', strtotime($blog->updated_at)) }}</td>
                            <td>{{ strtoupper($blog->status) }}</td>
                            <td id="likes{{$blog->id}}"></td>
                            <td id="dislikes{{$blog->id}}"></td>
                            <td id="comments{{$blog->id}}"></td>
                            <td><a href='/blog/{{$blog->id}}/edit' class='btn btn-primary'>Update</a></td>
                            <td><a href='/blog/{{$blog->id}}/delete' class='btn btn-primary'>Delete</a></td>
                        </tr>
                        <script> userBlogsCounterValues({{$blog->id}})</script>
                    @endforeach
                @else
                    <tr>
                        <td><h2 class='text-warning'>No Data Found</h2></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

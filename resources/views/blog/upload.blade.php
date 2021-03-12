@extends("layouts.app")

@section("title","Upload Blog")

@section("content")

    <div class="container bg-dark rounded p-3 my-5 text-light " style="opacity: 0.9;">
        <form action="/upload/blog" method="post" enctype="multipart/form-data" class="w-75 mx-auto">
            @if(session("msg"))
                <div class="alert alert-success">
                    {{session("msg")}}
                </div>
            @endif
            <h2 class="text-warning">Upload Blog</h2>
            @csrf
            @method("put")
            <div class="form-group ">
                <label for="title" class="col-form-label ">Blog Title</label>
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}"  autocomplete="title" autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>

            <div class="form-group ">
                <label for="image" class="col-form-label ">Blog Image</label>
                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"  autocomplete="image" autofocus>
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>

            <div class="form-group">
                <label for="password" class="col-form-label">Blog Description</label>
                <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="description" name="description" autocomplete="description" placeholder="Enter your purpose..." cols="20">{{ old('description') }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="col-form-label">Blog Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="publish">Publish</option>
                    <option value="draft">Draft</option>
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">
                    Submit
                </button>
            </div>
        </form>
    </div>
@endsection

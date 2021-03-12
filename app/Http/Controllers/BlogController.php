<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("blog.upload");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => 'required|string',
            "image" => 'required',
            "description" => 'required|string',
            "status" => 'required|string'
        ]);
        $blog = new Blog();
        $imageName = time().'.'.$request->image->extension();
        if($request->image->move(public_path('img'), $imageName))
        {
            $blog->title = $request->title;
            $blog->user_id = Auth::user()->id;
            $blog->image_path = $imageName;
            $blog->description = $request->description;
            $blog->status = $request->status;
            $blog->save();
            return Redirect::back()->with("msg","Blog Upload Successfully");
        }else{
            return Redirect::back()->with("msg","Something is wrong to upload blog");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Blog $blog
     * @return Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Blog $blog
     * @return Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}

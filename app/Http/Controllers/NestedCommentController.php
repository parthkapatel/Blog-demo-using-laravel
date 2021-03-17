<?php

namespace App\Http\Controllers;

use App\Models\NestedComment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NestedCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request  $request)
    {
        $blog_id = $request->route("blog_id");
        $comment_id = $request->route("comment_id");
        $nestedComment = NestedComment::join("users","users.id","nested_comments.user_id")->where("nested_comments.blog_id",$blog_id)->where("nested_comments.comment_id",$comment_id)->
        select("users.name","nested_comments.id","nested_comments.blog_id","nested_comments.user_id","nested_comments.comment_id","nested_comments.sub_comment","nested_comments.created_at")->get();
        return json_encode($nestedComment);
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
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
      /* $request->validate([
            'commentReply' => 'required|string',
       ]);*/
        $blog_id = $request->route("blog_id");
        $comment_id = $request->route("comment_id");
        $comment = $request->comment;
        $user_id = Auth::user()->id;

        $nestedComment = new NestedComment();
        $nestedComment->blog_id = $blog_id;
        $nestedComment->user_id = $user_id;
        $nestedComment->comment_id = $comment_id;
        $nestedComment->sub_comment = $comment;
        $nestedComment->save();
        //Redirect::route("/blogs/".$blog_id)->with("msg","Successful insert your comment reply");
        /*$arr = [
            "route" => "/blogs/$blog_id",
            "msg" => "Successfully insert your comment reply"
        ];*/
        return "Successfully insert your comment reply";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NestedComment  $nestedComment
     * @return Response
     */
    public function show(NestedComment $nestedComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NestedComment  $nestedComment
     * @return Response
     */
    public function edit(NestedComment $nestedComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NestedComment  $nestedComment
     * @return Response
     */
    public function update(Request $request, NestedComment $nestedComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NestedComment  $nestedComment
     * @return Response
     */
    public function destroy(NestedComment $nestedComment)
    {
        //
    }
}

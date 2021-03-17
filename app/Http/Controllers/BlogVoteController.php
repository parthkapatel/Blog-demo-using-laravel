<?php

namespace App\Http\Controllers;

use App\Models\BlogVote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BlogVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param BlogVote $blogVote
     * @return Response
     */
    public function show(BlogVote $blogVote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogVote $blogVote
     * @return Response
     */
    public function edit(BlogVote $blogVote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BlogVote $blogVote
     * @return BlogVote
     */
    public function update(Request $request, BlogVote $blogVote)
    {
        $id = $request->route("blog_id");
        $str = $request->route("str");
        $uid = Auth::user()->id;
        $blogVotes = BlogVote::where("blog_votes.blog_id",$id)->where("blog_votes.user_id",$uid)->get();
        echo $blogVotes;
        if(!empty($blogVotes[0]))
            $blogVoteData = $blogVotes[0];

        if(empty($blogVotes[0]) &&  $str == "like"){
            $blogVote->blog_id = $id;
            $blogVote->user_id = $uid;
            $blogVote->likes = 1;
            $blogVote->dislikes = 0;
            $blogVote->save();
        }
        else if (!empty($blogVotes[0]) && $blogVoteData["likes"] == 0 && $blogVoteData["dislikes"] == 0 &&  $str == "like"){
            BlogVote::where('blog_id', $id)
                ->where('user_id', $uid)
                ->update(['likes' => 1]);
        }
        else if(!empty($blogVotes[0]) && $blogVoteData["likes"] == 1 && $blogVoteData["dislikes"] == 0 &&  $str == "like"){
            BlogVote::where('blog_id', $id)
                ->where('user_id', $uid)
                ->update(['likes' => 0]);
        }
        if(empty($blogVotes[0]) &&  $str == "dislikes"){
            $blogVote->blog_id = $id;
            $blogVote->user_id = $uid;
            $blogVote->likes = 0;
            $blogVote->dislikes = 1;
            $blogVote->save();
        }
        else if (!empty($blogVotes[0]) && $blogVoteData["likes"] == 0 && $blogVoteData["dislikes"] == 0 &&  $str == "dislikes"){
            BlogVote::where('blog_id', $id)
                ->where('user_id', $uid)
                ->update(['dislikes' => 1]);
        }
        else if(!empty($blogVotes[0]) && $blogVoteData["likes"] == 0 && $blogVoteData["dislikes"] == 1 &&  $str == "dislikes"){
            BlogVote::where('blog_id', $id)
                ->where('user_id', $uid)
                ->update(['dislikes' => 0]);
        }
       else if(!empty($blogVotes[0]) && $blogVoteData["likes"] == 1 && $blogVoteData["dislikes"] == 0 &&  $str == "dislikes"){
            BlogVote::where('blog_id', $id)
                ->where('user_id', $uid)
                ->update(['dislikes' => 1,"likes"=>0]);
        }
        else if(!empty($blogVotes[0]) && $blogVoteData["likes"] == 0 && $blogVoteData["dislikes"] == 1 &&  $str == "like"){
            BlogVote::where('blog_id', $id)
                ->where('user_id', $uid)
                ->update(['likes' => 1,"dislikes"=>0]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogVote $blogVote
     * @return Response
     */
    public function destroy(BlogVote $blogVote)
    {
        //
    }
}

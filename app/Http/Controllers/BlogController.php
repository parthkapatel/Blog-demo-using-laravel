<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogVote;
use App\Models\Comment;
use App\Models\User;
use App\Interfaces\BlogRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller
{

    private $blogRepository;
    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->middleware('auth');
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $blogs = $this->blogRepository->all();
      //  $blogs = User::join('blogs', 'blogs.user_id', '=', 'users.id')->where("status", "!=", "draft")->orderBy("blogs.created_at", "desc")->paginate(5);
        return view("blog.blogs",[
            'blogs' => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $heading = "Upload Blog";
        $action = "/upload/blog";
        return view("blog.upload", compact("heading", "action"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => 'required|string',
            "description" => 'required|string',
            "status" => 'required|string'
        ]);
        $blog = new Blog();

        if ($request->image != null) {
            $imageName = time() . '.' . $request->image->extension();
            if ($request->image->move(public_path('img'), $imageName)) {
                $blog->title = $request->title;
                $blog->user_id = Auth::user()->id;
                $blog->image_path = $imageName;
                $blog->description = $request->description;
                $blog->status = $request->status;
                $blog->save();
                return Redirect::back()->with("msg", "Blog Upload Successfully");
            }
        } else if ($request->image == null) {
            $blog->title = $request->title;
            $blog->user_id = Auth::user()->id;
            $blog->description = $request->description;
            $blog->status = $request->status;
            $blog->save();
            return Redirect::to("view-your-blogs")->with("msg", "Blog Upload Successfully");
        } else {
            return Redirect::to("view-your-blogs")->with("msg", "Something is wrong to upload blog");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function show(Blog $blog, Request $request)
    {
        $id = $request->route('blog_id');
        $blog = Blog::find($id);

        $blog->total_views += 1;
        $blog->save();
        /* id and title for  next and previous button */

        $previousId = Blog::where('blogs.id', '<', $blog->id)->where("status", "!=", "draft")->max('blogs.id');
        $nextId = Blog::where('blogs.id', '>', $blog->id)->where("status", "!=", "draft")->min('blogs.id');

        $previous = Blog::where('blogs.id', '=', $previousId)->first();
        $next = Blog::where('blogs.id', '=', $nextId)->first();

        /* ------------------- */
        /* Blog Data */

        $blog = User::join('blogs', 'blogs.user_id', '=', 'users.id')->where("blogs.id", "=", $id)->where("status", "!=", "draft")->first();

        /* Comment Data on Blog */

        $comments = Comment::join('users', 'users.id','=', 'comments.user_id')->where("comments.blog_id",$id)->select("users.name","comments.id","comments.blog_id","comments.user_id","comments.comment_message","comments.created_at")->orderBy("comments.created_at","asc")->paginate();
        //$comments = Comment::join('users', 'comments.user_id', '=', 'users.id')->where("comments.blog_id",$id)->orderBy("comments.created_at","asc")->simplePaginate(5);
        return  view("blog.singleBlog", compact("blog", "previous", "next","comments"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Blog $blog
     * @param Request $request
     * @return Response
     */
    public function edit(Blog $blog, Request $request)
    {
        $id = $request->route("blog_id");
        $blogData = Blog::where("id", $id)->get();
        $blog = $blogData[0];
        $heading = "Update Blog";
        $action = "/blog/$id/update";
        return view("blog.upload", compact("blog", "heading", "action"));
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
        $blog = $blog::find($request->route("blog_id"));
        if ($request->image != null) {
            $imageName = time() . '.' . $request->image->extension();
            if ($request->image->move(public_path('img'), $imageName)) {
                $blog->title = $request->title;
                $blog->user_id = Auth::user()->id;
                $blog->image_path = $imageName;
                $blog->description = $request->description;
                $blog->status = $request->status;
                $blog->save();
                return Redirect::to("view-your-blogs")->with("msg", "Blog Update Successfully");
            }
        } else if ($request->image == null) {
            $blog->title = $request->title;
            $blog->user_id = Auth::user()->id;
            $blog->description = $request->description;
            $blog->status = $request->status;
            $blog->save();
            return Redirect::to("view-your-blogs")->with("msg", "Blog Update Successfully");
        } else {
            return Redirect::to("view-your-blogs")->with("msg", "Something is wrong to upload blog");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @param Request $request
     */
    public function destroy(Blog $blog, Request $request)
    {
        $id = $request->route("blog_id");
        Blog::where('id', $id)->delete();
        $blogs = Blog::where('blogs.user_id', '=', Auth::user()->id)->get();
        return Redirect::to("view-your-blogs")->with("msg","Blog Deleted Successfully");
    }

    public function userBlogs()
    {
        //$blogs = Blog::where('blogs.user_id', '=', Auth::user()->id)->get();
        $blogs = Blog::where('blogs.user_id', '=', Auth::user()->id)->get();
        return view("blog.view_user_blogs", compact("blogs"));
    }

    public function getCountValues(Request $request){
        $id = $request->route("blog_id");
        $uid = Auth::user()->id;
        /* Like Dislike Count */
        $likes = BlogVote::where('blog_votes.blog_id', $id)->sum('blog_votes.likes');
        $dislikes = BlogVote::where('blog_votes.blog_id', $id)->sum('blog_votes.dislikes');
        /* comment counter */
        $commentCounter = Comment::where('comments.blog_id', $id)->count('id');

        /* check user has clicked any button or not */
        $userLikes = BlogVote::where('blog_votes.blog_id', $id)->where('blog_votes.user_id', $uid)->sum('blog_votes.likes');
        $useDislikes = BlogVote::where('blog_votes.blog_id', $id)->where('blog_votes.user_id', $uid)->sum('blog_votes.dislikes');

        $arr = [
            "total_likes" => $likes,
            "total_dislikes" => $dislikes,
            "total_comment" => $commentCounter,
            "user_likes" => $userLikes,
            "user_dislikes" => $useDislikes
        ];
        return response()->json($arr);;
    }

}

<?php

namespace App\Http\Controllers;

use App\Interfaces\BlogRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
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
        $blogs = $this->blogRepository->getPaginate();
        return view("blog.blogs", [
            'blogs' => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "title" => 'required|string',
            "description" => 'required|string',
            "status" => 'required|string'
        ]);

        $user_id = Auth::user()->id;
        $data = [
            "title" => $request->title,
            "image" => $request->image,
            "description" => $request->description,
            "status" => $request->status
        ];
        $data = $this->blogRepository->save($data, $user_id);
        if ($data) {
            return Redirect::to("view-your-blogs")->with("msg", "Blog Upload Successfully");
        } else {
            return Redirect::to("view-your-blogs")->with("msg", "Something is wrong to upload blog");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function show(Request $request)
    {
        $blog_id = $request->route('blog_id');

        $this->blogRepository->updateTotalViews($blog_id);
        $data = $this->blogRepository->getDataByIdAndStatus($blog_id);
        $blog = $data['blog'];
        $comments = $data['comment'];
        $previous = $data['previous'];
        $next = $data['next'];
        return view("blog.singleBlog", compact("blog", "previous", "next", "comments"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function edit(Request $request)
    {
        $id = $request->route("blog_id");
        $data = $this->blogRepository->getDataById($id);
        $blog = $data;
        $heading = "Update Blog";
        $action = "/blog/$id/update";
        return view("blog.upload", compact("blog", "heading", "action"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $blog_id = $request->route("blog_id");
        $user_id = Auth::id();
        $array = [
            "title" => $request->title,
            "image" => $request->image,
            "description" => $request->description,
            "status" => $request->status
        ];
        $data = $this->blogRepository->update($array, $blog_id, $user_id);
        if ($data) {
            return Redirect::to("view-your-blogs")->with("msg", "Blog Update Successfully");
        } else {
            return Redirect::to("view-your-blogs")->with("msg", "Something is wrong to upload blog");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $blog_id = $request->route("blog_id");
        $data = $this->blogRepository->delete($blog_id);
        if ($data)
            return Redirect::to("view-your-blogs")->with("msg", "Blog deleted successfully");
        else
            return Redirect::to("view-your-blogs")->with("msg", "Something is wrong to delete data");
    }

    public function userBlogs()
    {
        $blogs = $this->blogRepository->getAllDataByUserId(Auth::user()->id);
        return view("blog.view_user_blogs", compact("blogs"));
    }

    public function getCountValues(Request $request): JsonResponse
    {
        $blog_id = $request->route("blog_id");
        $user_id = Auth::user()->id;
        $data = $this->blogRepository->getPostsAllCounterValues($blog_id, $user_id);
        return response()->json($data);;
    }

}

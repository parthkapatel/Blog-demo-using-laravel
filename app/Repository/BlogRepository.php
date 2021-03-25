<?php

namespace App\Repository;

use App\Models\Blog;
use App\Interfaces\BlogRepositoryInterface;
use App\Models\BlogVote;
use App\Models\Comment;
use App\Models\User;
use phpDocumentor\Reflection\Types\This;

class BlogRepository implements BlogRepositoryInterface
{
    private $blog;
    private $user;
    private $blogVote;
    private $comment;

    /**
     * BlogRepository constructor.
     * @param Blog $blog
     * @param User $user
     * @param BlogVote $blogVote
     * @param Comment $comment
     */
    public function __construct(Blog $blog,User $user,BlogVote $blogVote,Comment $comment)
    {
        $this->blog = $blog;
        $this->user = $user;
        $this->blogVote = $blogVote;
        $this->comment = $comment;
    }

    public function all()
    {
        return $this->blog->all();
    }

    public function save($data, $user_id)
    {
        if ($data["image"] != null) {
            $imageName = time() . '.' . $data["image"]->extension();
            if ($data["image"]->move(public_path('img'), $imageName)) {
                $this->blog->image_path = $imageName;
            }
        }
        $this->blog->title = $data["title"];
        $this->blog->user_id = $user_id;
        $this->blog->description = $data["description"];
        $this->blog->status = $data["status"];
        if ($this->blog->save()) {
            return $this->blog;
        } else {
            return false;
        }
    }

    public function getPaginate()
    {
        return $this->user::join('blogs', 'blogs.user_id', '=', 'users.id')->where("status", "!=", "draft")->orderBy("blogs.created_at", "desc")->paginate(5);
    }

    public function getDataById($blog_id)
    {
        return $this->blog::where("id", $blog_id)->first();
    }

    public function getPostsAllCounterValues($blog_id, $user_id): array
    {
        /* Like Dislike Count */
        $likes = $this->blogVote::where('blog_votes.blog_id', $blog_id)->sum('blog_votes.likes');
        $dislikes = $this->blogVote::where('blog_votes.blog_id', $blog_id)->sum('blog_votes.dislikes');
        /* comment counter */
        $commentCounter = $this->comment::where('comments.blog_id', $blog_id)->count('id');

        /* check user has clicked any button or not */
        $userLikes = $this->blogVote::where('blog_votes.blog_id', $blog_id)->where('blog_votes.user_id', $user_id)->sum('blog_votes.likes');
        $useDislikes = $this->blogVote::where('blog_votes.blog_id', $blog_id)->where('blog_votes.user_id', $user_id)->sum('blog_votes.dislikes');

        return [
            "total_likes" => $likes,
            "total_dislikes" => $dislikes,
            "total_comment" => $commentCounter,
            "user_likes" => $userLikes,
            "user_dislikes" => $useDislikes
        ];
    }

    public function update($data, $blog_id, $user_id)
    {
        $this->blog = $this->blog::find($blog_id);
        if ($data["image"] != null) {
            $imageName = time() . '.' . $data["image"]->extension();
            if ($data["image"]->move(public_path('img'), $imageName)) {
                $this->blog->image_path = $imageName;
            }
        }

        $this->blog->title = $data["title"];
        $this->blog->user_id = $user_id;
        $this->blog->description = $data["description"];
        $this->blog->status = $data["status"];
        if ($this->blog->save()) {
            return $this->blog;
        } else {
            return false;
        }
    }

    public function delete($blog_id)
    {
        return $this->blog::where('id', $blog_id)->delete();
    }

    public function getAllDataByUserId($user_id)
    {
        return $this->blog::where('blogs.user_id', '=', $user_id)->get();
    }

    public function updateTotalViews($blog_id)
    {
        $blog = $this->blog::find($blog_id);
        $blog->total_views += 1;
        $blog->save();
    }

    public function getDataByIdAndStatus($blog_id): array
    {
        $blog = $this->blog::find($blog_id);
        /* id and title for  next and previous button */
        $previousId = $this->blog::where('blogs.id', '<', $blog->id)->where("status", "!=", "draft")->max('blogs.id');
        $nextId = $this->blog::where('blogs.id', '>', $blog->id)->where("status", "!=", "draft")->min('blogs.id');
        $previous = $this->blog::where('blogs.id', '=', $previousId)->first();
        $next = $this->blog::where('blogs.id', '=', $nextId)->first();
        /* ------------------- */
        /* Blog Data */
        $blog = $this->user::join('blogs', 'blogs.user_id', '=', 'users.id')->where("blogs.id", "=", $blog_id)->where("status", "!=", "draft")->first();
        /* Comment Data on Blog */
        $comments = $this->comment::join('users', 'users.id', '=', 'comments.user_id')->where("comments.blog_id", $blog_id)->select("users.name", "comments.id", "comments.blog_id", "comments.user_id", "comments.comment_message", "comments.created_at")->orderBy("comments.created_at", "asc")->get();
        return [
            "blog" => $blog,
            "comment" => $comments,
            "previous" => $previous,
            "next" => $next
        ];
    }
}

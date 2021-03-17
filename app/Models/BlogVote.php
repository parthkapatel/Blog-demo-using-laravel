<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogVote extends Model
{
    use HasFactory;

    /**
     * @var \Illuminate\Routing\Route|mixed|object|string|null
     */
    private $blog_id;
    /**
     * @var mixed
     */
    private $user_id;
    /**
     * @var int|mixed
     */
    private $likes;
    /**
     * @var int|mixed
     */
    private $dislikes;
}

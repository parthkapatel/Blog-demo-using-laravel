<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "image",
        "description",
        "status",
    ];
    /**
     * @var mixed
     */
    private $title;
    /**
     * @var mixed|string
     */
    private $image_path;
    /**
     * @var mixed
     */
    private $description;
    /**
     * @var mixed
     */
    private $status;
    /**
     * @var mixed
     */
    private $user_id;
}

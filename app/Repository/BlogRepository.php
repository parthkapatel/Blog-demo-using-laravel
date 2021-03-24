<?php

namespace App\Repository;

use App\Models\Blog;
use App\Interfaces\BlogRepositoryInterface;
use Illuminate\Support\Collection;

class BlogRepository implements BlogRepositoryInterface
{
    private $model;

    /**
     * BlogRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        $this->model = $model;
    }


    public function all()
    {
        return $this->model->all();
    }
}

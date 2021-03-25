<?php

namespace App\Interfaces;

use App\Models\Blog;
use Illuminate\Support\Collection;

interface BlogRepositoryInterface
{
    public function all();

    public function save($data,$user_id);

    public function getPaginate();

    public function getDataById($blog_id);

    public function getAllDataByUserId($user_id);

    public function update($data,$blog_id,$user_id);

    public function delete($blog_id);

    public function getPostsAllCounterValues($blog_id,$user_id);

    public function updateTotalViews($blog_id);

    public function getDataByIdAndStatus($blog_id);
}

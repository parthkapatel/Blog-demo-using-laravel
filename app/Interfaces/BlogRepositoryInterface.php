<?php

namespace App\Interfaces;

use App\Models\Blog;
use Illuminate\Support\Collection;

interface BlogRepositoryInterface
{
    public function all();
}

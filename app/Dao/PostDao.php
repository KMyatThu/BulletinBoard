<?php

namespace App\Dao;

use App\Post;
use App\Contracts\Dao\PostDaoInterface;

class PostDao implements PostDaoInterface
{
    public function getPostList()
    {
        \Log::info(" -- TestDao getList -- ");
        return Post::get();
    }
}

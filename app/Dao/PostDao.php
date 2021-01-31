<?php

namespace App\Dao;

use App\Post;
use App\Contracts\Dao\PostDaoInterface;

class PostDao implements PostDaoInterface
{
    /**
     * Get Post List
     */
    public function getPostList()
    {
        return Post::active()->paginate(5);
    }

    /**
     * Register Post
     * 
     * @param post
     */

    public function registerPost($post)
    {
        return Post::create($post);
    }

    /**
     * Post Update
     * @param post
     */
    public function updatePost($post)
    {
        return Post::where('id', $post['id'])->update($post);
    }

    /**
     * Soft Delete Post
     * @param id
     */
    public function deletePost($post)
    {
        return POST::where('id', $post['id'])->update($post);
    }

    /**
     * Search Post post
     * @param keyword
     */
    public function searchPost($keyword)
    {
        return Post::active()->where(function($posts) use ($keyword) {
            $posts->where('title', 'LIKE', '%' . $keyword . '%')
            ->orwhere('description', 'LIKE', '%' . $keyword . '%');
        })->paginate(5);
    }
}

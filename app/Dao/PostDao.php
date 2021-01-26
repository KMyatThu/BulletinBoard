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
        return Post::whereNull('deleted_user_id')->paginate(5);
    }

    /**
     * Register Post
     * 
     * @param post
     */

    public function registerPost($post)
    {
        Post::create($post);
    }

    /**
     * Post Update
     * @param post
     */
    public function updatePost($post)
    {
        Post::where('id', $post['id'])->update($post);
    }

    /**
     * Soft Delete Post
     * @param id
     */
    public function deletePost($post)
    {
        POST::where('id', $post['id'])->update($post);
    }

    /**
     * Search Post post
     * @param keyword
     */
    public function searchPost($keyword)
    {
        return Post::whereNull('deleted_user_id')->where(function($posts) use ($keyword) {
            $posts->where('title', 'LIKE', '%' . $keyword . '%')
            ->orwhere('description', 'LIKE', '%' . $keyword . '%');
        })->paginate(5);
    }
}

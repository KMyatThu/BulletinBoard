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
        Post::create([
                'title' => $post['title'],
                'description' => $post['description'],
                'status' => $post['status'],
                'create_user_id' => $post['create_user_id'],
                'updated_user_id' => $post['updated_user_id'],
            ]);
    }

    /**
     * Post Update
     * @param post
     */
    public function updatePost($post)
    {
        Post::where('id', $post->id)->update([
            'title' => $post['title'],
            'description' => $post['description'],
            'status' => $post['status'],
            'updated_user_id' => $post['updated_user_id'],
            'updated_at' => $post['updated_at']
        ]);
    }

    /**
     * Soft Delete Post
     * @param id
     */
    public function deletePost($post)
    {
        POST::where('id', $post->id)->update([
            'deleted_user_id' => $post['deleted_user_id'],
            'deleted_at' => $post['deleted_at']
        ]);
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
        })->get();
    }
}

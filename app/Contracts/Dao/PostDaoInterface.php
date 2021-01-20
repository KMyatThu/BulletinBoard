<?php

namespace App\Contracts\Dao;

interface PostDaoInterface
{
    /**
     * Get Post Lists
     */
    public function getPostList();

    /**
     * Register Post
     * @param post
     */
    
    public function registerPost($post);
    /**
     * Post Update
     * @param post
     */
    public function updatePost($post);

    /**
     * Soft Delete Post
     * @param post 
     */
    public function deletePost($post);

    /**
     * Search Post 
     * @param keyword
     */
    public function searchPost($keyword);
}

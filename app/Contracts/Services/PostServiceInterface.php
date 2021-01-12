<?php

namespace App\Contracts\Services;

interface PostServiceInterface
{
    public function getPostList();
    /**
     * Register Post
     * 
     * @param post
     */
    public function registerPost($post);

    /**
     * Edit Post
     * 
     * @param post
     */
    public function editPost($post);

    /**
     * Post Delete
     * @param post
     * 
     */
    public function deletePost($post);

    /**
     * Search post
     *
     * @param  keyword
     */
    public function searchPost($keyword);
}

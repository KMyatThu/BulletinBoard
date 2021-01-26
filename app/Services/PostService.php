<?php

namespace App\Services;

use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Services\PostServiceInterface;
use App\Post;

class PostService implements PostServiceInterface
{
    // file dao for injecting PostDaoInterface
    private $postDao;

    /**
     * Class Constructor
     * @param PostDaoInterface
     * @return
     */
    public function __construct(PostDaoInterface $postDao)
    {
        $this->postDao = $postDao;
    }

    /**
     * Get Post Lists
     */
    public function getPostList()
    {
        return $this->postDao->getPostList();
    }

    /**
     * Create Post
     * @param post
     */
    public function registerPost($post)
    {
        $post = $post->toArray();
        $post['status'] = 1;
        $post['create_user_id'] = auth()->user()->type;
        $post['updated_user_id'] = auth()->user()->type;
        $this->postDao->registerPost($post);
    }

    /**
     * Edit post
     * @param post
     */
    public function editPost($post)
    {
        $post = [
            'id' => $post['id'],
            'title' => $post['title'],
            'description' => $post['description'],
            'status' => $post['status'],
            'updated_user_id' => auth()->user()->type,
            'updated_at' => now()
        ];
        $this->postDao->updatePost($post);
    }

    /**
     * Delete post
     * @param post
     */
    public function deletePost($post)
    {
        $post = [
            'id' => $post['id'],
            'deleted_at' => now(),
            'deleted_user_id' => auth()->user()->id
        ];
        $this->postDao->deletePost($post);
    }

    /**
     * Search post
     * @param $keyword
     * @return Post
     */
    public function searchPost($keyword)
    {
        return $this->postDao->searchPost($keyword);
    }
}

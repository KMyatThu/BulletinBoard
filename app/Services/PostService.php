<?php

namespace App\Services;

use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Services\PostServiceInterface;
use App\Post;
use DateTime;

class PostService implements PostServiceInterface
{
    // file dao for injecting PostDaoInterface
    private $postDaoInterface;

    /**
     * Class Constructor
     * @param PostDaoInterface
     * @return
     */
    public function __construct(PostDaoInterface $postDaoInterface)
    {
        $this->postDaoInterface = $postDaoInterface;
    }

    public function getPostList()
    {
        return $this->postDaoInterface->getPostList();
    }

    /**
     * Create Post
     * @param post
     */
    public function registerPost($post)
    {
        $post->status = 1;
        $post->create_user_id = auth()->user()->type;
        $post->updated_user_id = auth()->user()->type;
        $this->postDaoInterface->registerPost($post);
    }

    /**
     * Edit post
     * @param post
     */
    public function editPost($post)
    {
        $post->updated_user_id = auth()->user()->type;
        $this->postDaoInterface->updatePost($post);
    }

    /**
     * Delete post
     * @param post
     */
    public function deletePost($post)
    {
        $post->deleted_at = new DateTime();
        $post->deleted_user_id = auth()->user()->type;
        $this->postDaoInterface->deletePost($post);
    }

    /**
     * Search post
     * @param $keyword
     * @return Post
     */
    public function searchPost($keyword)
    {
        return $this->postDaoInterface->searchPost($keyword);
    }
}

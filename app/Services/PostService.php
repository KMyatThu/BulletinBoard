<?php

namespace App\Services;

use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Services\PostServiceInterface;

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
        \Log::info(" -- TestService getList -- ");
        return $this->postDaoInterface->getPostList();
    }
}

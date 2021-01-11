<?php

namespace App\Services;

use App\Contracts\Dao\TestDaoInterface;
use App\Contracts\Services\TestServiceInterface;

class TestService implements TestServiceInterface
{
    // file dao for injecting TestDaoInterface
    private $testDao;

    /**
     * Class Constructor
     * @param TestDaoInterface
     * @return
     */
    public function __construct(TestDaoInterface $testDao)
    {
        $this->testDao = $testDao;
    }

    public function getList()
    {
        \Log::info(" -- TestService getList -- ");
        return $this->testDao->getList();
    }
}

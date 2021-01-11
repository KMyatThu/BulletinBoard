<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Services\TestServiceInterface;

class TestController extends Controller
{
    // test service for injecting TestServiceInterface
    private $testService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TestServiceInterface $testService)
    {
        $this->testService = $testService;
    }
    
    public function getList(Request $request)
    {
        \Log::info(" -- TestController getList  -- ");
        \Log::info($this->testService->getList());

        return view('test')->with(["userList" => $this->testService->getList()]);
    }
}

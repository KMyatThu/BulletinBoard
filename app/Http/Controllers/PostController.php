<?php

namespace App\Http\Controllers;

use App\Exports\PostExport;
use App\Http\Requests\PostFormRequest;
use App\Imports\PostImport;
use App\Post;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\Services\PostServiceInterface;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    // test service for injecting TestServiceInterface
    private $postServiceInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostServiceInterface $postServiceInterface)
    {
        $this->middleware('auth');
        $this->postServiceInterface = $postServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postServiceInterface->getPostList();
        return view('posts.postlist', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        return view('posts.postCreate', compact('post'));
    }

    public function postCreateConfirm(PostFormRequest $request)
    {
        $post = new Post($request->all());
        return view('posts.postCreateConfirm', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostFormRequest $request)
    {
        $post = new Post($request->all());
        $createdPost = $this->postServiceInterface->registerPost($post);
        if ($createdPost) {
            return redirect()->route('posts.index')
                ->with('success', 'Post created successfully.');
        } else {
            return redirect()->route('posts.index')
                ->with('error', 'Post not created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.postDetail', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.postEdit', compact('post'));
    }

    public function postUpdateConfirm(PostFormRequest $request)
    {
        $post = new Post($request->all());
        $post->status = $request->has('status') ? 1 : 0;
        return view('posts.postUpdateConfirm', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post = new Post($request->all());
        $post->status = $request->has('status') ? 1 : 0;
        $updated = $this->postServiceInterface->editPost($post);
        if ($updated == 1) {
            return redirect()->route('posts.index')
                ->with('success', 'Post update successfully.');
        } else {
            return redirect()->route('posts.index')
                ->with('error', 'Post not updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $deleted = $this->postServiceInterface->deletePost($post);
        if ($deleted == 1) {
            return redirect()->route('posts.index')
                ->with('success', 'Post deleted successfully');
        } else {
            return redirect()->route('posts.index')
                ->with('error', 'Post not deleted');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function searchPost(Request $request)
    {
        $keyword = $request->input('keyword');
        $posts = $this->postServiceInterface->searchPost($keyword);
        (Log::info($posts));
        return view('posts.postlist', compact('posts'));
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function download()
    {
        return Excel::download(new PostExport, 'posts.csv');
    }

    public function uploadIndex()
    {
        return view('posts.postUpload');
    }

    public function upload(PostFormRequest $request)
    {
        Excel::import(new PostImport, $request->file('file')->store('temp'));
        return redirect()->route('posts.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\PostExport;
use App\Imports\PostImport;
use DateTime;
use App\Post;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::whereNull('deleted_user_id')->paginate(5);
        return $this->userList($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        return view('posts.create',compact('post'));
    }

    public function postCreateConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $post = new Post($request->all());
     
        return view('posts.createConfirm',compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post = new Post($request->all());
        $post->status = 1;
        $post->create_user_id = auth()->user()->id;
        $post->updated_user_id = auth()->user()->id;
        $post->created_at = new DateTime();
        $post->updated_at = new DateTime();

        Post::create([
            'title' => $post['title'],
            'description' => $post['description'],
            'status' => $post['status'],
            'create_user_id' => $post['create_user_id'],
            'updated_user_id' => $post['updated_user_id'],
            'created_at' => $post['created_at'],
            'updated_at' => $post['updated_at']
        ]);
     
        return redirect()->route('posts.index')
                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.postDetail',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.postEdit',compact('post'));
    }

    public function postUpdateConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $post = new Post($request->all());
        $post->status = $request->has('status') ? 1 : false ;
     
        return view('posts.postUpdateConfirm',compact('post'));
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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post = new Post($request->all());
        $post->status = $request->has('status') ? 1 : false ;
        $post->create_user_id = 1;
        $post->updated_user_id = 1;

        Post::where('id' , $post->id )->update([
            'title' => $post['title'],
            'description' => $post['description'],
            'status' => $post['status'],
            'create_user_id' => $post['create_user_id'],
            'updated_user_id' => $post['updated_user_id'],
        ]);

        return redirect()->route('posts.index')
                        ->with('success','Product update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->deleted_at = new DateTime();
        Post::where('id' , $post->id )->update([
            'deleted_user_id' => '1',
            'deleted_at' => $post['deleted_at']
        ]);

        return redirect()->route('posts.index')
                        ->with('success','Product deleted successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request['keyword'];
        $posts = Post::whereNull('deleted_user_id')
                ->where('title','LIKE','%'.$search.'%')
                ->orWhere('description','LIKE','%'.$search.'%')
                ->paginate(5);
                // $postss = Post::where('title','LIKE','%'.$search.'%')->orWhere('description','LIKE','%'.$search.'%')->paginate(5);
        return $this->userList($posts);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function download()
    {
        return Excel::download(new PostExport, 'posts.csv');
    }

    public function postUploadIndex()
    {
        return view('posts.postUpload');
    }

    public function upload(Request $request)
    {
        dd($request);
        Excel::import(new PostImport, $request->file('file')->store('temp'));
        return redirect()->route('posts.index');
    }

    public function userList($posts)
    {
        return view('posts.index',compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}

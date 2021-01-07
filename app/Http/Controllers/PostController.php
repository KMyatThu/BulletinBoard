<?php

namespace App\Http\Controllers;

use App\Exports\PostExport;
use App\Imports\PostImport;
use DateTime;
use App\Post;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

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
    public function index(Request $request)
    {
        $search = (!empty($_GET["keyword"])) ? ($_GET["keyword"]) : ('');
        $posts = Post::whereNull('deleted_user_id');
        if($search != '') $posts->where('title', 'LIKE', '%' . $search . '%')
            ->orwhere('description', 'LIKE', '%' . $search . '%');
        if ($request->ajax()) {
            return DataTables::of($posts)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    return '<a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="btn btn-link" data-attr="/posts/'. $row->id .'">'. $row->title .'</a>';
                })->editColumn('create_user_id', function ($row) {
                    return $row->create_user_id == 1 ? 'User' : 'Admin' ;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="posts/'.$row->id.'/edit" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn = $btn.'<a href="posts/'.$row->id.'/destroy" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->editColumn('created_at', function ($row) 
                {
                return date('Y/m/d', strtotime($row->created_at) );
                })
                ->rawColumns(['title'],['action'],['create_user_id'])
                ->make(true);
        }
        return view('posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        return view('posts.create', compact('post'));
    }

    public function postCreateConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $post = new Post($request->all());

        return view('posts.createConfirm', compact('post'));
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
        $post->create_user_id = auth()->user()->type;
        $post->updated_user_id = auth()->user()->type;
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
            ->with('success', 'Product created successfully.');
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

    public function postUpdateConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post = new Post($request->all());
        $post->status = $request->has('status') ? 1 : false;
        $post->updated_user_id = auth()->user()->id;
        $post->updated_at = new DateTime();

        Post::where('id', $post->id)->update([
            'title' => $post['title'],
            'description' => $post['description'],
            'status' => $post['status'],
            'updated_user_id' => $post['updated_user_id'],
            'updated_at' => $post['updated_at']
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Product update successfully.');
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
        Post::where('id', $post->id)->update([
            'deleted_user_id' => '1',
            'deleted_at' => $post['deleted_at']
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Product deleted successfully');
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
        Excel::import(new PostImport, $request->file('file')->store('temp'));
        return redirect()->route('posts.index');
    }

    public function postList($request,$posts)
    {
        if ($request->ajax()) {
            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return '<a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="btn btn-link" data-attr="/posts/'. $row->id .'">'. $row->title .'</a>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="posts/'.$row->id.'/edit" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn = $btn.'<a href="posts/'.$row->id.'/destroy" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->editColumn('created_at', function ($row) 
                {
                return date('Y/m/d', strtotime($row->created_at) );
                })
                ->rawColumns(['title'],['action'])
                ->make(true);
        }
        return view('posts.index');
    }
}

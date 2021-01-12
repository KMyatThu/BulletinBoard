<?php

namespace App\Http\Controllers;

use App\Exports\PostExport;
use App\Http\Requests\PostFormRequest;
use App\Imports\PostImport;
use DateTime;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Contracts\Services\PostServiceInterface;

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
    // public function index(Request $request)
    // {
    //     $search = (!empty($_GET["keyword"])) ? ($_GET["keyword"]) : ('');
    //     $posts = Post::whereNull('deleted_user_id');
    //     if($search != '') $posts->where('title', 'LIKE', '%' . $search . '%')
    //         ->orwhere('description', 'LIKE', '%' . $search . '%');
    //     if ($request->ajax()) {
    //         return DataTables::of($posts)
    //             ->addIndexColumn()
    //             ->editColumn('title', function ($row) {
    //                 return '<a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="btn btn-link" data-attr="/posts/'. $row->id .'">'. $row->title .'</a>';
    //             })->editColumn('create_user_id', function ($row) {
    //                 return $row->create_user_id == 1 ? 'User' : 'Admin' ;
    //             })
    //             ->addColumn('action', function ($row) {
    //                 $btn = '<a href="posts/'.$row->id.'/edit" class="edit btn btn-primary btn-sm">Edit</a>';
    //                 $btn = $btn.'<a href="posts/'.$row->id.'/destroy" class="edit btn btn-danger btn-sm">Delete</a>';
    //                 return $btn;
    //             })
    //             ->editColumn('created_at', function ($row) 
    //             {
    //             return date('Y/m/d', strtotime($row->created_at) );
    //             })
    //             ->rawColumns(['title'],['action'],['create_user_id'])
    //             ->make(true);
    //     }
    //     return view('posts.index');
    // }

    public function index()
    {
        $posts = $this->postServiceInterface->getPostList();
        return view('posts.index')->with(["posts" => $posts]);
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

    public function postCreateConfirm(PostFormRequest $request)
    {
        $post = new Post($request->all());
        return view('posts.createConfirm', compact('post'));
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
        $this->postServiceInterface->registerPost($post);

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
        $this->postServiceInterface->editPost($post);

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
        $this->postServiceInterface->deletePost($post);
        return redirect()->route('posts.index')
            ->with('success', 'Product deleted successfully');
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
        return view('posts.index')->with(["posts" => $posts]);
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

    public function postList($request, $posts)
    {
        if ($request->ajax()) {
            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return '<a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="btn btn-link" data-attr="/posts/' . $row->id . '">' . $row->title . '</a>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="posts/' . $row->id . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn = $btn . '<a href="posts/' . $row->id . '/destroy" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return date('Y/m/d', strtotime($row->created_at));
                })
                ->rawColumns(['title'], ['action'])
                ->make(true);
        }
        return view('posts.index');
    }
}

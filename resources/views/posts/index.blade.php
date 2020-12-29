@extends('layout')
@section('content')
<div class="card">
    <div class="card-header">
        Featured
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <form action="/search" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">keyword</div>
                        <div class="col"><input type="text" name="keyword" class="form-control" placeholder=""></div>
                        <div class="col"><button type="submit" class="btn btn-primary"> Search </button></div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"><a class="btn btn-success" href="{{ route('posts.create') }}"> Create</a>
            <a class="btn btn-primary" href="postUploadIndex"> Upload</a>
            <a class="btn btn-primary" href="download"> Download</a></div>
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
        </div>
        <div class="row">
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>title</th>
                    <th>Description</th>
                    <th>Posted User</th>
                    <th>Posted Date</th>
                    <th width="280px">Operation</th>
                </tr>
                @foreach ($posts as $post)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>
                    <td>{{ $post->create_user_id }}</td>
                    <td>{{ $post->created_at->format('Y/m/d') }}</td>
                    <td>
                        <form action="{{ route('posts.destroy',$post->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('posts.show',$post->id) }}">Show</a>

                            <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

{!! $posts->links() !!}

@endsection
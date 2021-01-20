@extends('layout')
@section('content')
<div class="py-4">
    <div class="card">
            <div class="card-header">
                Post List
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form action="searchPost" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col" style="text-align: right;">keyword</div>
                                <div class="col"><input type="text" name="keyword" class="form-control" placeholder=""></div>
                                <div class="col"><button type="submit" class="btn btn-primary">Search</button></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4"><a class="btn btn-success" href="{{ route('posts.create') }}"> Create</a>
                        <a class="btn btn-primary" href="postUploadIndex"> Upload</a>
                        <a class="btn btn-primary" href="download"> Download</a>
                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th style="min-width: 200px;">Post title</th>
                                <th style="min-width: 200px;">Post Description</th>
                                <th style="min-width: 120px;">Posted User</th>
                                <th style="min-width: 130px;">Posted Date</th>
                                <th style="min-width: 250px;">Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                            <tr>
                                <td ><a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="text-info" style="cursor: pointer;" data-attr="/posts/{{$post->id}}"> {{ $post->title }}</a></td>
                                <td scope="col">{{ $post->description }}</td>
                                <td scope="col">{{ $post->create_user_id }}</td>
                                <td scope="col">{{ $post->created_at->format('Y/m/d') }}</td>
                                <td scope="col">
                                    <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                                        <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-left">
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Post Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mediumBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>


<script type="text/javascript">
    // when click detail
    $('body').on('click', '#mediumButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href,
            beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                // $('#mediumModal').modal("show");
                $('#mediumModal').appendTo("body");
                $('#mediumBody').html(result).show();
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            },
        })
    });
</script>
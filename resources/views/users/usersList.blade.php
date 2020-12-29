@extends('layout')
@section('content')
<div class="py-4">
    <div class="card">
        <div class="card-header">
            User Lists
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col"></div>
                <div class="col">keyword</div>
                <div class="col"><input type="text" name="keyword" class="form-control" placeholder=""></div>
                <div class="col"><a class="btn btn-primary" href="{{ route('users.index') }}"> Search</a></div>
                <div class="col"><a class="btn btn-success" href="{{ route('users.create') }}"> Create</a></div>
                <div class="col"><a class="btn btn-primary" href="{{ route('users.index') }}"> Upload</a></div>
                <div class="col"><a class="btn btn-primary" href="{{ route('users.index') }}"> Download</a></div>
            </div>

            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif

            <table class="table table-bordered">
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Create User</th>
                    <th>Type</th>
                    <th>Phone</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th width="280px">Operation</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->create_user_id }}</td>
                    <td>{{ $user->type == 1 ? 'Admin' : 'User' }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->dob }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->created_at->format('Y/m/d') }}</td>
                    <td>{{ $user->updated_at->format('Y/m/d') }}</td>
                    <td>
                        <form action="{{ route('users.destroy',$user->id) }}" method="POST">

                            <a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="btn btn-info" data-attr="{{ route('users.show',$user->id) }}" title="show">Show</a>
                            <!-- <a class="btn btn-info" data-toggle="modal" data-target="#exampleModalLong" data-attr="{{ route('users.show',$user->id) }}">Show</a> -->
                            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                            <a data-toggle="modal" id="deleteButton" data-target="#deleteModal" data-attr="/userDeleteModal/{{$user->id}}" class="btn btn-primary">Delete</a>
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

{!! $users->links() !!}
@endsection
<!--Detail Modal -->
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="deleteBody">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{ route('users.destroy',$user->id) }}" type="submit" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).on('click', '#mediumButton', function(event) {
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

    $(document).on('click', '#deleteButton', function(event) {
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
                $('#deleteModal').appendTo("body");
                $('#deleteBody').html(result).show();
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
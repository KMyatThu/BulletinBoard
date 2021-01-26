@extends('layout')
@section('content')
<div class="py-4">
    <div class="card">
        <div class="card-header">
            User Lists
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row" style="flex-flow: row-reverse;">
                    <table>
                        <tr>
                            <form action="/users/searchUser" method="POST">
                                @csrf
                                <th>Name</th>
                                <th>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="">
                                </th>
                                <th>
                                    <div class="col">Email</div>
                                </th>
                                <th>
                                    <div class="col"><input type="text" id="email" name="email" class="form-control" placeholder=""></div>
                                </th>
                                <th>
                                    <div class="col">From</div>
                                </th>
                                <th>
                                    <div class="col"><input type="text" name="start_date" id="start_date" class="form-control" autocomplete="off"></div>
                                </th>
                                <th>
                                    <div class="col">To</div>
                                </th>
                                <th>
                                    <div class="col"><input type="text" name="end_date" id="end_date" class="form-control" autocomplete="off"></div>
                                </th>
                                <th>
                                    <div class="col"><button type="submit" class="btn btn-primary" style="width:135px;"> Search</a></div>
                                </th>
                            </form>
                        </tr>
                    </table>
                </div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
                <div class="row">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center" style="min-width: 115px;">Create User</th>
                                <th class="text-center" style="min-width: 115px;">Type</th>
                                <th class="text-center" style="min-width: 180px;">Phone</th>
                                <th class="text-center" style="min-width: 140px;">Date of Birth</th>
                                <th class="text-center" style="min-width: 250px;">Address</th>
                                <th class="text-center" style="min-width: 130px;">Created Date</th>
                                <th class="text-center" style="min-width: 130px;">Updated Date</th>
                                <th class="text-center">Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td><a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="btn btn-link" data-attr="/users/{{$user->id}}"> {{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->create_user_id == 0 ? 'Admin' : 'User' }}</td>
                                <td>{{ $user->type == 0 ? 'Admin' : 'User' }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->dob }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->created_at->format('Y/m/d') }}</td>
                                <td>{{ $user->updated_at->format('Y/m/d') }}</td>
                                <td><a data-toggle="modal" id="deleteButton" data-target="#deleteModal" class="btn btn-danger" data-attr="users/{{$user->id}}/userDeleteModal/">Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

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
            <div class="modal-body" id="deleteBody">
                ...
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

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

    //date picker
    $(function() {
        $("#start_date, #end_date").datepicker({
            dateFormat: 'yy/mm/dd'
        });
    });
</script>
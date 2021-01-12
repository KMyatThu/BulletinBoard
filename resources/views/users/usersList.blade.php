@extends('layout')
@section('content')
<div class="py-4">
    <div class="card">
        <div class="card-header">
            User Lists
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">Name</div>
                <div class="col"><input type="text" id="name" name="name" class="form-control" placeholder=""></div>
                <div class="col">Email</div>
                <div class="col"><input type="text" id="email" name="email" class="form-control" placeholder=""></div>
                <div class="col">From</div>
                <div class="col"><input type="text" name="from" id="from" class="form-control" placeholder=""></div>
                <div class="col">To</div>
                <div class="col"><input type="text" name="to" id="to" class="form-control" placeholder=""></div>
                <div class="col"><a class="btn btn-primary" id="searchBtn"> Search</a></div>
            </div>

            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif

            <table class="table table-bordered" id="user_table">
                <thead>
                <tr>
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
                </thead>
                <tbody>
                </tbody>
            </table>
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
 $(document).ready(function() {
        $('#user_table').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{ route('users.index') }}",
                type: 'GET',
                data: function(d) {
                    d.name = $('#name').val();
                    d.email = $('#email').val();
                    d.from = $('#from').val().replace(/(\d\d)\/(\d\d)\/(\d{4})/, "$3-$1-$2");
                    d.to = $('#to').val().replace(/(\d\d)\/(\d\d)\/(\d{4})/, "$3-$1-$2");
                }
            },
            columns: [{
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'create_user_id'
                },
                {
                    data: 'type'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'dob'
                },
                {
                    data: 'address'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $('#searchBtn').click(function() {
            $('#user_table').DataTable().draw(true);
        });
    });

    // For adding the token to axios header (add this only one time).
    // var token = document.head.querySelector('meta[name="csrf-token"]');
    // window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

    // send contact form data.
    // axios.get("/api/user").then((response)=>{
    //     console.log(response)
    // }).catch((error)=>{
    //     console.log(error.response.data)
    // });

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

    $( function() {
    $( "#to, #from" ).datepicker({  
       format: 'mm/dd/yyyy'
     });  
  } );
</script>
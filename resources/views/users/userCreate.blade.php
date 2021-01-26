@extends('layout')
@section('content')
<div class="py-4 container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Register
                </div>
                <div class="card-body">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="userCreateConfirm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--  -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">E-mail-Address</label>
                            <div class="col-md-6">
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Type</label>
                            <div class="col-md-6">
                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="type">
                                <option value="0" selected>Admin</option>
                                <option value="1">User</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Phone</label>
                            <div class="col-md-6">
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Date Of Birth</label>
                            <div class="col-md-6">
                                <input type="text" name="dob" class="form-control" id="dob" placeholder="mm/dd/yyyy" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Address</label>
                            <div class="col-md-6">
                                <input type="text" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Profile</label>
                            <div class="col-md-6">
                                <input type="file" name="profile" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Register</button>
                                <input type="reset" class="btn btn-secondary" value="Clear" />
                            </div>
                        </div>
                        <!--  -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#dob" ).datepicker({  
       format: 'mm/dd/yyyy'
     });  
  } );
  </script>
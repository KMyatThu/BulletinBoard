@extends('layout')
@section('content')
<div class="py-4 container">
    <div class="card">
        <div class="card-header">
            Profile Edit
        </div>
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
        <div class="card-body">
            <form action="/editProfile" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="type">
                            <option value="0" {{ $user->type == 0 ? 'selected' : ''}}>Admin</option>
                            <option value="1" {{ $user->type == 1 ? 'selected' : ''}}>User</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dob" class="col-sm-2 col-form-label">Date of Birth</label>
                    <div class="col-sm-10">
                        <input type="text" name="dob" id="dob" class="form-control" placeholder="mm/dd/yyyy" value="{{ $user->dob }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="profile" class="col-sm-2 col-form-label">Old Profile</label>
                    <div class="col-sm-10">
                        <img src="/uploads/images/{{ $user->profile }}" alt="old profile" width="250" height="200">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="profile" class="col-sm-2 col-form-label">New Profile</label>
                    <div class="col-sm-10">
                        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </div>
                <input type="hidden" value="{{ $user->id }}" name="id">
                <input type="hidden" value="{{ $user->profile }}" name="profile">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <button type="reset" class="btn btn-secondary">Clear</button>
                    <a href="passwordChange">Change Password</a>
                </div>
            </form>
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
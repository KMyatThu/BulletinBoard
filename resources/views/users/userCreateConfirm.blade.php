@extends('layout')
@section('content')
<div class="py-4 container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Register Confirm
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

                    <form action="createUser" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">E-mail-Address</label>
                            <div class="col-md-6">
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" name="password" class="form-control" value="{{ $user->password }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" name="confirm_password" class="form-control" value="{{ $user->password }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Type</label>
                            <div class="col-md-6">
                            <input type="text" name="type" class="form-control" value="{{ $user->type == 0 ? 'Admin' : 'User' }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Phone</label>
                            <div class="col-md-6">
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Date Of Birth</label>
                            <div class="col-md-6">
                                <input type="text" name="dob" class="form-control" id="dob" value="{{ $user->dob }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Address</label>
                            <div class="col-md-6">
                                <input type="text" name="address" class="form-control" value="{{ $user->address }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Profile</label>
                            <div class="col-md-6">
                                <img src="/uploads/images/{{ $user->profile }}" alt="old profile" width="250" height="200">
                            </div>
                        </div>
                        <input type="hidden" value="{{ $user->profile }}" name="profile">
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                                <input type="reset" class="btn btn-secondary" value="Cancel" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
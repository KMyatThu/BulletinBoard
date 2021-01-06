@extends('layout')
@section('content')
<div class="py-4 container">
    <div class="card">
        <div class="card-header">
            Profile
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <img src="/uploads/images/{{ $user->profile }}" width="200" height="200" />
                    </div>
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $user->name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Type:</strong>
                                {{ $user->type == 1 ? 'Admin' : 'User' }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                {{ $user->email }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Phone:</strong>
                                {{ $user->phone }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Date of Birth:</strong>
                                {{ $user->dob }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Address:</strong>
                                {{ $user->address }}
                            </div>
                        </div>
                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
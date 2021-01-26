@extends('layout')
@section('content')
<div class="py-4 container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">
                Post Edit Confirm
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

                <form action="update" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                        <div class="col-md-6">
                            <input type="text" name="title" class="form-control" value="{{ $post->title }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control" readonly>{{ $post->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">Status</label>
                        <div class="col-md-6">
                            <!-- <input type="checkbox" name="status" {{  ($post->status == 1 ? ' checked' : '') }}> -->
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="status" type="checkbox" id="flexSwitchCheckChecked" {{  ($post->status == 1 ? ' checked' : '') }} />
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{ $post->id }}" name="id">
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">Edit Confirm</button>
                            <input type="reset" class="btn btn-secondary" value="Clear" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.0.0/mdb.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.0.0/mdb.min.css" rel="stylesheet" />
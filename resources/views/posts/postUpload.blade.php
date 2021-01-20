@extends('layout')

@section('content')

<body>
    <div class="container mt-5 text-center">
        <h2 class="mb-4">
            Posts upload as CSV & Excel to Database
        </h2>

        <form action="/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                <div class="custom-file text-left">
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label form-control @error('file') is-invalid @enderror" for="customFile">Choose file</label>
                    @error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <button class="btn btn-primary">Import data</button>
        </form>
    </div>
</body>

@endsection
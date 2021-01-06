<div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
        <label for="staticEmail" class="col-sm-10 col-form-label">{{ $post->title }}</label>
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
        <label for="staticEmail" class="col-sm-10 col-form-label">{{ $post->description }}</label>
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
    <div class="col-sm-10">
        <label for="staticEmail" class="col-sm-10 col-form-label">{{ $post->status == 1 ? 'Active' : 'Unactive' }}</label>
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Created Date</label>
    <div class="col-sm-10">
        <label for="staticEmail" class="col-sm-10 col-form-label">{{ $post->created_at->format('Y/m/d') }}</label>
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Created User</label>
    <div class="col-sm-10">
        <label for="staticEmail" class="col-sm-10 col-form-label">{{ $post->create_user_id }}</label>
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Updated Date</label>
    <div class="col-sm-10">
        <label for="staticEmail" class="col-sm-10 col-form-label">{{ $post->updated_at->format('Y/m/d') }}</label>
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Updated User</label>
    <div class="col-sm-10">
        <label for="staticEmail" class="col-sm-10 col-form-label">{{ $post->updated_user_id }}</label>
    </div>
</div>
@extends('layouts.admin')
@section('page-title','New Portfolio')

@section('content')
<form method="post" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data">
  @csrf
  <div class="card">
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-8">
          <label>Title</label>
          <input class="form-control" name="title" required>
        </div>
        <div class="form-group col-md-4">
          <label>Author</label>
          <input class="form-control" name="author">
        </div>
      </div>
      <div class="form-group">
        <label>Excerpt</label>
        <textarea class="form-control" name="excerpt" rows="3"></textarea>
      </div>
      <div class="form-row">
        <div class="form-group col-sm-4">
          <label>Cover</label>
          <input type="file" class="form-control-file" name="cover" accept="image/*">
        </div>
        <div class="form-group col-sm-4">
          <label>Sort Order</label>
          <input type="number" class="form-control" name="sort_order" value="0" min="0">
        </div>
        <div class="form-group col-sm-4">
          <label class="d-block">Flags</label>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="f1" name="is_featured" value="1">
            <label class="custom-control-label" for="f1">Featured</label>
          </div>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="v1" name="is_visible" value="1" checked>
            <label class="custom-control-label" for="v1">Visible</label>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary">Batal</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
@endsection

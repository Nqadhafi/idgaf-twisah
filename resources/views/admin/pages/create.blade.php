@extends('layouts.admin')
@section('page-title','New Page')

@section('content')
<form method="post" action="{{ route('admin.pages.store') }}">
  @csrf
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label>Title</label>
        <input class="form-control" name="title" required>
      </div>
      <div class="form-group">
        <label>Slug</label>
        <input class="form-control" name="slug" placeholder="contoh: visi-misi atau /">
        <small class="text-muted">Isi "/" untuk home.</small>
      </div>
      <div class="form-group">
        <label>Meta Title</label>
        <input class="form-control" name="meta_title">
      </div>
      <div class="form-group">
        <label>Meta Description</label>
        <textarea class="form-control" name="meta_description" rows="3"></textarea>
      </div>
      <div class="form-row">
        <div class="form-group col-sm-4">
          <div class="custom-control custom-switch mt-4">
            <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" checked>
            <label class="custom-control-label" for="is_published">Published</label>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <label>Published At</label>
          <input type="datetime-local" class="form-control" name="published_at">
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Batal</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
@endsection

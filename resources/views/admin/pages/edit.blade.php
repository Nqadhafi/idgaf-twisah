@extends('layouts.admin')
@section('page-title','Edit Page')

@section('content')
<form method="post" action="{{ route('admin.pages.update',$page) }}">
  @csrf @method('put')
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label>Title</label>
        <input class="form-control" name="title" value="{{ old('title',$page->title) }}" required>
      </div>
      <div class="form-group">
        <label>Slug</label>
        <input class="form-control" name="slug" value="{{ old('slug',$page->slug) }}">
      </div>
      <div class="form-group">
        <label>Meta Title</label>
        <input class="form-control" name="meta_title" value="{{ old('meta_title',$page->meta_title) }}">
      </div>
      <div class="form-group">
        <label>Meta Description</label>
        <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description',$page->meta_description) }}</textarea>
      </div>
      <div class="form-row">
        <div class="form-group col-sm-4">
          <div class="custom-control custom-switch mt-4">
            <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" {{ $page->is_published?'checked':'' }}>
            <label class="custom-control-label" for="is_published">Published</label>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <label>Published At</label>
          <input type="datetime-local" class="form-control" name="published_at" value="{{ optional($page->published_at)->format('Y-m-d\TH:i') }}">
        </div>
      </div>
    </div>
    <div class="card-footer d-flex justify-content-between">
      <a href="{{ route('admin.pages.sections.index',$page) }}" class="btn btn-outline-info"><i class="fas fa-layer-group mr-1"></i>Manage Sections</a>
      <div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</form>
@endsection

@extends('layouts.admin')
@section('page-title','Edit Portfolio')

@section('content')
<form method="post" action="{{ route('admin.portfolio.update',$item) }}" enctype="multipart/form-data">
  @csrf @method('put')
  <div class="card">
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-8">
          <label>Title</label>
          <input class="form-control" name="title" value="{{ old('title',$item->title) }}" required>
        </div>
        <div class="form-group col-md-4">
          <label>Author</label>
          <input class="form-control" name="author" value="{{ old('author',$item->author) }}">
        </div>
      </div>
      <div class="form-group">
        <label>Excerpt</label>
        <textarea class="form-control" name="excerpt" rows="3">{{ old('excerpt',$item->excerpt) }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group col-sm-4">
          <label>Cover</label>
          @if($item->cover_url)
            <div class="mb-2"><img src="{{ $item->cover_url }}" class="img-120" alt=""></div>
          @endif
          <input type="file" class="form-control-file" name="cover" accept="image/*">
        </div>
        <div class="form-group col-sm-4">
          <label>Sort Order</label>
          <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order',$item->sort_order) }}" min="0">
        </div>
        <div class="form-group col-sm-4">
          <label class="d-block">Flags</label>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="f1" name="is_featured" value="1" {{ $item->is_featured?'checked':'' }}>
            <label class="custom-control-label" for="f1">Featured</label>
          </div>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="v1" name="is_visible" value="1" {{ $item->is_visible?'checked':'' }}>
            <label class="custom-control-label" for="v1">Visible</label>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary">Kembali</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
@endsection

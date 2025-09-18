@extends('layouts.admin')
@section('page-title','Edit Testimonial')

@section('content')
<form method="post" action="{{ route('admin.testimonials.update',$row) }}" enctype="multipart/form-data">
  @csrf @method('put')
  <div class="card">
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Author</label>
          <input class="form-control" name="author" value="{{ old('author',$row->author) }}" required>
        </div>
        <div class="form-group col-md-6">
          <label>Role</label>
          <input class="form-control" name="role" value="{{ old('role',$row->role) }}">
        </div>
      </div>
      <div class="form-group">
        <label>Quote</label>
        <textarea class="form-control" name="quote" rows="3" required>{{ old('quote',$row->quote) }}</textarea>
      </div>
      <div class="form-row">
        <div class="form-group col-sm-4">
          <label>Avatar</label>
          @if($row->avatar_url)
            <div class="mb-2"><img src="{{ $row->avatar_url }}" class="img-64" alt=""></div>
          @endif
          <input type="file" class="form-control-file" name="avatar" accept="image/*">
        </div>
        <div class="form-group col-sm-4">
          <label>Sort Order</label>
          <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order',$row->sort_order) }}" min="0">
        </div>
        <div class="form-group col-sm-4">
          <label class="d-block">Visible</label>
          <div class="custom-control custom-switch mt-2">
            <input type="checkbox" class="custom-control-input" id="v1" name="is_visible" value="1" {{ $row->is_visible?'checked':'' }}>
            <label class="custom-control-label" for="v1">Yes</label>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Kembali</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
@endsection

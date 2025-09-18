@extends('layouts.admin')
@section('page-title','Edit FAQ')

@section('content')
<form method="post" action="{{ route('admin.faqs.update',$row) }}">
  @csrf @method('put')
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label>Question</label>
        <input class="form-control" name="question" value="{{ old('question',$row->question) }}" required>
      </div>
      <div class="form-group">
        <label>Answer</label>
        <textarea class="form-control" name="answer" rows="4" required>{{ old('answer',$row->answer) }}</textarea>
      </div>
      <div class="form-row">
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
      <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Kembali</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
@endsection

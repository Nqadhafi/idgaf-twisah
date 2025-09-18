@extends('layouts.admin')
@section('page-title',"Edit Section — {$page->title}")

@section('content')
<form method="post" action="{{ route('admin.pages.sections.update',[$page,$section]) }}">
  @csrf @method('put')
  <div class="card">
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label>Tipe</label>
          <input class="form-control" value="{{ $section->type }}" disabled>
          <input type="hidden" name="type" value="{{ $section->type }}">
        </div>
        <div class="form-group col-md-3">
          <label>Urutan</label>
          <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order',$section->sort_order) }}" min="0">
        </div>
        <div class="form-group col-md-3">
          <label>Visible</label>
          <select class="form-control" name="is_visible">
            <option value="1" {{ $section->is_visible?'selected':'' }}>Yes</option>
            <option value="0" {{ !$section->is_visible?'selected':'' }}>No</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Payload (JSON)</label>
        <textarea class="form-control" name="payload" id="payload" rows="10">{{ json_encode($section->payload ?? new stdClass, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) }}</textarea>
      </div>
      <button type="button" class="btn btn-sm btn-outline-info" onclick="pretty()">Pretty</button>
    </div>
    <div class="card-footer text-right">
      <a href="{{ route('admin.pages.sections.index',$page) }}" class="btn btn-secondary">Kembali</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
  function pretty(){
    try {
      const obj = JSON.parse(document.getElementById('payload').value || '{}');
      document.getElementById('payload').value = JSON.stringify(obj, null, 2);
    } catch(e){ alert('JSON tidak valid'); }
  }
</script>
@endpush

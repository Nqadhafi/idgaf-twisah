@extends('layouts.admin')
@section('page-title',"Edit Section — {$page->title}")

@section('content')
<form method="post" action="{{ route('admin.pages.sections.update',[$page,$section]) }}">
  @csrf @method('put')

  <div class="card">
    <div class="card-body">

      <div class="form-row">
        {{-- TYPE (locked) --}}
        <div class="form-group col-md-4">
          <label class="mb-1">Tipe</label>
          <input class="form-control" value="{{ $section->type }}" disabled>
          <input type="hidden" name="type" value="{{ $section->type }}">
        </div>

        {{-- SORT ORDER --}}
        <div class="form-group col-md-3">
          <label class="mb-1">Urutan</label>
          <input type="number"
                 name="sort_order"
                 min="0"
                 value="{{ old('sort_order',$section->sort_order) }}"
                 class="form-control @error('sort_order') is-invalid @enderror">
          @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- VISIBLE --}}
        <div class="form-group col-md-3">
          <label class="mb-1">Visible</label>
          @php $visible = old('is_visible', (int) $section->is_visible); @endphp
          <select name="is_visible" class="form-control @error('is_visible') is-invalid @enderror">
            <option value="1" {{ (string)$visible==='1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ (string)$visible==='0' ? 'selected' : '' }}>No</option>
          </select>
          @error('is_visible')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      {{-- PAYLOAD (JSON) --}}
      <div class="form-group">
        <label class="mb-1 d-flex align-items-center">
          <span>Payload (JSON)</span>
          <small class="text-muted ml-2">(gunakan objek/array JSON; klik Pretty untuk merapikan)</small>
        </label>

        <textarea id="payload"
                  name="payload"
                  rows="12"
                  class="form-control font-monospace @error('payload') is-invalid @enderror"
                  spellcheck="false">{{ old('payload', json_encode($section->payload ?? (object)[], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)) }}</textarea>
        @error('payload')<div class="invalid-feedback">{{ $message }}</div>@enderror

        <div class="mt-2">
          <button type="button" class="btn btn-sm btn-outline-info" onclick="prettyJSON()">Pretty</button>
          <button type="button" class="btn btn-sm btn-outline-secondary" onclick="validateJSON()">Validate</button>
        </div>
      </div>

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
  function prettyJSON(){
    const el = document.getElementById('payload');
    try {
      const parsed = el.value.trim() ? JSON.parse(el.value) : {};
      el.value = JSON.stringify(parsed, null, 2);
      el.classList.remove('is-invalid');
    } catch(e){
      alert('JSON tidak valid. Periksa kembali tanda kutip/koma.');
      el.classList.add('is-invalid');
    }
  }
  function validateJSON(){
    const el = document.getElementById('payload');
    try {
      if (el.value.trim() === '') { alert('Kosong: ini akan disimpan sebagai NULL.'); return; }
      JSON.parse(el.value);
      alert('JSON valid ✅');
      el.classList.remove('is-invalid');
    } catch(e){
      alert('JSON tidak valid ❌: ' + e.message);
      el.classList.add('is-invalid');
    }
  }
</script>
@endpush

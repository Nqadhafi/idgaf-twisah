@extends('layouts.admin')
@section('page-title','Site Settings')

@section('content')
<form method="post" action="{{ route('admin.settings.updateMany') }}">
  @csrf
  <div class="card mb-3">
    <div class="card-header">WhatsApp</div>
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-8">
          <label>URL</label>
          <input class="form-control" name="settings[whatsapp_link][url]" value="{{ data_get($settings,'whatsapp_link.url') }}">
        </div>
        <div class="form-group col-md-4">
          <label>Label</label>
          <input class="form-control" name="settings[whatsapp_link][label]" value="{{ data_get($settings,'whatsapp_link.label','WhatsApp') }}">
        </div>
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header">Contact</div>
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Address</label>
          <input class="form-control" name="settings[contact][address]" value="{{ data_get($settings,'contact.address') }}">
        </div>
        <div class="form-group col-md-3">
          <label>Phone</label>
          <input class="form-control" name="settings[contact][phone]" value="{{ data_get($settings,'contact.phone') }}">
        </div>
        <div class="form-group col-md-3">
          <label>Email</label>
          <input class="form-control" name="settings[contact][email]" value="{{ data_get($settings,'contact.email') }}">
        </div>
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header">Maps Embed</div>
    <div class="card-body">
      <div class="form-group">
        <label>Iframe HTML</label>
        <textarea class="form-control" name="settings[maps_embed][iframe]" rows="4">{{ data_get($settings,'maps_embed.iframe') }}</textarea>
        <small class="text-muted">Tempel kode iframe Google Maps apa adanya.</small>
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header">About Gallery</div>
    <div class="card-body">
      <div class="form-group">
        <label>Images (JSON)</label>
        <textarea class="form-control" name="settings[about_gallery][images]" rows="5">@php
          $imgs = data_get($settings,'about_gallery.images',[]);
          echo json_encode($imgs, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        @endphp</textarea>
        <small class="text-muted">Format: [{"path":"gallery/1.jpg","alt":"..."}, ...]</small>
      </div>
    </div>
  </div>

  <div class="text-right">
    <button class="btn btn-primary">Simpan Semua</button>
  </div>
</form>
@endsection

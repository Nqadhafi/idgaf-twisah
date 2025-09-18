@extends('layouts.admin')
@section('page-title',"New Section — {$page->title}")

@section('content')
<form method="post" action="{{ route('admin.pages.sections.store',$page) }}">
  @csrf
  <div class="card">
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label>Tipe</label>
          <select class="form-control" name="type" id="sec-type">
            @foreach(['hero','services','packages','how_it_works','portfolio','testimonials','faq','contact','about_gallery'] as $t)
              <option value="{{ $t }}">{{ $t }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-3">
          <label>Urutan</label>
          <input type="number" class="form-control" name="sort_order" value="0" min="0">
        </div>
        <div class="form-group col-md-3">
          <label>Visible</label>
          <select class="form-control" name="is_visible">
            <option value="1" selected>Yes</option>
            <option value="0">No</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Payload (JSON)</label>
        <textarea class="form-control" name="payload" id="payload" rows="10">{}</textarea>
        <small class="text-muted">Isi sesuai struktur tipe section. Klik "Template" untuk prefill.</small>
      </div>
      <button type="button" class="btn btn-sm btn-outline-secondary" onclick="applyTemplate()">Template</button>
      <button type="button" class="btn btn-sm btn-outline-info" onclick="pretty()">Pretty</button>
    </div>
    <div class="card-footer text-right">
      <a href="{{ route('admin.pages.sections.index',$page) }}" class="btn btn-secondary">Batal</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
  const templates = {
    hero: {"title":"Judul Besar","subtitle":"Subjudul singkat","cta_text":"Hubungi Kami","cta_url":"https://wa.me/62","image_path":"banners/hero.jpg"},
    services: {"heading":"Layanan Kami","items":[{"icon":"fas fa-pen-nib","title":"Editing","desc":"Penyuntingan naskah."},{"icon":"fas fa-file-alt","title":"Layout","desc":"Tata letak profesional."}]},
    packages: {"heading":"Paket","items":[{"name":"Basic","price":"Rp990.000","features":["ISBN","Layout dasar"]},{"name":"Pro","price":"Rp1.990.000","features":["ISBN","Layout premium","Cover"]}]},
    how_it_works: {"heading":"Alur","steps":[{"title":"Kirim Naskah","desc":"Upload naskah."},{"title":"Editing","desc":"Perapian."}]},
    portfolio: {"heading":"Buku Terbit","show_featured":true,"limit":8,"cta_more_url":"/buku-terbit"},
    testimonials: {"heading":"Testimoni","limit":6},
    faq: {"heading":"FAQ","limit":6},
    contact: {"heading":"Kontak","show_whatsapp":true,"show_form":false,"note":"Kami balas cepat."},
    about_gallery: {"heading":"Galeri","images":[{"path":"gallery/1.jpg","alt":"Foto 1"}]}
  };
  function applyTemplate(){
    const t = document.getElementById('sec-type').value;
    document.getElementById('payload').value = JSON.stringify(templates[t] || {}, null, 2);
  }
  function pretty(){
    try {
      const obj = JSON.parse(document.getElementById('payload').value || '{}');
      document.getElementById('payload').value = JSON.stringify(obj, null, 2);
    } catch(e){ alert('JSON tidak valid'); }
  }
</script>
@endpush

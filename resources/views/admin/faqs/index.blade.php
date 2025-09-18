@extends('layouts.admin')
@section('page-title','FAQs')
@section('page-actions')
  <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>New</a>
@endsection

@section('content')
<form class="mb-3" method="get">
  <div class="input-group">
    <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Cari pertanyaan...">
    <div class="input-group-append"><button class="btn btn-outline-secondary">Search</button></div>
  </div>
</form>

<div class="card">
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead><tr><th style="width:60px">ID</th><th>Question</th><th>Answer</th><th class="text-center">Visible</th><th style="width:160px"></th></tr></thead>
      <tbody id="faq-list">
      @forelse($rows as $f)
        <tr data-id="{{ $f->id }}">
          <td>#{{ $f->id }}</td>
          <td>{{ $f->question }}</td>
          <td><div class="small text-truncate" style="max-width: 420px;">{{ $f->answer }}</div></td>
          <td class="text-center">
            <button class="btn btn-sm btn-outline-{{ $f->is_visible?'success':'secondary' }}" onclick="toggleVisible({{ $f->id }})"><i class="fas fa-eye"></i></button>
          </td>
          <td class="text-right">
            <a href="{{ route('admin.faqs.edit',$f) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.faqs.destroy',$f) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus FAQ ini?')">
              @csrf @method('delete')
              <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted p-4">Belum ada FAQ.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer d-flex justify-content-between align-items-center">
    <div class="text-muted small">Drag baris untuk mengurutkan.</div>
    <div>{{ $rows->links() }}</div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  new Sortable(document.getElementById('faq-list'), {
    animation: 150,
    onEnd(){ const ids=[...document.querySelectorAll('#faq-list tr[data-id]')].map(tr=>+tr.dataset.id);
      postJSON('{{ route('admin.faqs.reorder') }}',{ids}).then(()=>console.log('reordered')); }
  });
  function toggleVisible(id){
    postJSON('{{ url('admin/faqs') }}/'+id+'/toggle-visible',{}).then(()=>location.reload());
  }
</script>
@endpush

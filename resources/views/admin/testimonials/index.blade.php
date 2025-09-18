@extends('layouts.admin')
@section('page-title','Testimonials')
@section('page-actions')
  <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>New</a>
@endsection

@section('content')
<form class="mb-3" method="get">
  <div class="input-group">
    <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Cari author/role...">
    <div class="input-group-append"><button class="btn btn-outline-secondary">Search</button></div>
  </div>
</form>

<div class="card">
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead><tr><th style="width:64px"></th><th>Author</th><th>Role</th><th>Quote</th><th class="text-center">Visible</th><th style="width:150px"></th></tr></thead>
      <tbody id="tst-list">
      @forelse($rows as $t)
        <tr data-id="{{ $t->id }}">
          <td>@if($t->avatar_url)<img src="{{ $t->avatar_url }}" class="img-64">@else <div class="bg-light img-64 d-flex align-items-center justify-content-center text-muted">N/A</div>@endif</td>
          <td class="align-middle"><b>{{ $t->author }}</b><div class="text-muted small">#{{ $t->id }}</div></td>
          <td class="align-middle">{{ $t->role }}</td>
          <td class="align-middle"><div class="small text-truncate" style="max-width: 320px;">“{{ $t->quote }}”</div></td>
          <td class="align-middle text-center">
            <button class="btn btn-sm btn-outline-{{ $t->is_visible?'success':'secondary' }}" onclick="toggleVisible({{ $t->id }})"><i class="fas fa-eye"></i></button>
          </td>
          <td class="align-middle text-right">
            <a href="{{ route('admin.testimonials.edit',$t) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.testimonials.destroy',$t) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus testimonial ini?')">
              @csrf @method('delete')
              <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted p-4">Belum ada testimonial.</td></tr>
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
  new Sortable(document.getElementById('tst-list'), {
    animation: 150,
    onEnd(){ const ids=[...document.querySelectorAll('#tst-list tr[data-id]')].map(tr=>+tr.dataset.id);
      postJSON('{{ route('admin.testimonials.reorder') }}',{ids}).then(()=>console.log('reordered')); }
  });
  function toggleVisible(id){
    postJSON('{{ url('admin/testimonials') }}/'+id+'/toggle-visible',{}).then(()=>location.reload());
  }
</script>
@endpush

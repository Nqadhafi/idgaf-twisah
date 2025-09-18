@extends('layouts.admin')
@section('page-title','Portfolio')
@section('page-actions')
  <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>New</a>
@endsection

@section('content')
<form class="mb-3" method="get">
  <div class="input-group">
    <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Cari judul/penulis...">
    <div class="input-group-append"><button class="btn btn-outline-secondary">Search</button></div>
  </div>
</form>

<div class="card">
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead><tr>
        <th style="width:64px"></th><th>Title</th><th>Author</th><th class="text-center">Featured</th><th class="text-center">Visible</th><th style="width:200px"></th>
      </tr></thead>
      <tbody id="pf-list">
      @forelse($items as $it)
        <tr data-id="{{ $it->id }}">
          <td>
            @if($it->cover_url) <img src="{{ $it->cover_url }}" class="img-64" alt=""> @else <div class="bg-light img-64 d-flex align-items-center justify-content-center text-muted">N/A</div> @endif
          </td>
          <td class="align-middle"><b>{{ $it->title }}</b><div class="text-muted small">#{{ $it->id }}</div></td>
          <td class="align-middle">{{ $it->author ?: '—' }}</td>
          <td class="align-middle text-center">
            <button class="btn btn-sm btn-outline-{{ $it->is_featured?'success':'secondary' }}" onclick="toggleFeatured({{ $it->id }})">
              <i class="fas fa-star"></i>
            </button>
          </td>
          <td class="align-middle text-center">
            <button class="btn btn-sm btn-outline-{{ $it->is_visible?'success':'secondary' }}" onclick="toggleVisible({{ $it->id }})">
              <i class="fas fa-eye"></i>
            </button>
          </td>
          <td class="align-middle text-right">
            <a href="{{ route('admin.portfolio.edit',$it) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.portfolio.destroy',$it) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
              @csrf @method('delete')
              <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted p-4">Belum ada item.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer d-flex justify-content-between align-items-center">
    <div class="text-muted small">Drag baris untuk mengurutkan.</div>
    <div>{{ $items->links() }}</div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Reorder with Sortable
  new Sortable(document.getElementById('pf-list'), {
    animation: 150,
    onEnd: function(){
      const ids = [...document.querySelectorAll('#pf-list tr[data-id]')].map(tr => parseInt(tr.dataset.id));
      postJSON('{{ route('admin.portfolio.reorder') }}', {ids}).then(() => console.log('reordered'));
    }
  });

  function toggleFeatured(id){
    postJSON('{{ url('admin/portfolio') }}/'+id+'/toggle-featured',{}).then(()=>location.reload());
  }
  function toggleVisible(id){
    postJSON('{{ url('admin/portfolio') }}/'+id+'/toggle-visible',{}).then(()=>location.reload());
  }
</script>
@endpush

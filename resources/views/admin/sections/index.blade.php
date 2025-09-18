@extends('layouts.admin')
@section('page-title',"Sections — {$page->title}")
@section('page-actions')
  <a href="{{ route('admin.pages.sections.create',$page) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>New Section</a>
@endsection

@section('content')
<div class="card">
  <div class="card-body p-0">
    <ul id="sec-list" class="list-group list-group-flush">
      @forelse($sections as $s)
        <li class="list-group-item d-flex align-items-center justify-content-between" data-id="{{ $s->id }}">
          <div>
            <i class="fas fa-grip-vertical text-muted mr-2"></i>
            <b class="mr-2">{{ $s->type }}</b>
            <span class="badge badge-{{ $s->is_visible?'success':'secondary' }}">{{ $s->is_visible?'Visible':'Hidden' }}</span>
            <small class="text-muted ml-2">#{{ $s->id }}</small>
          </div>
          <div>
            <button class="btn btn-sm btn-outline-secondary" onclick="toggleSection({{ $s->id }})">
              <i class="fas fa-eye{{ $s->is_visible?'':'-slash' }}"></i>
            </button>
            <a class="btn btn-sm btn-outline-info" href="{{ route('admin.pages.sections.edit',[$page,$s]) }}"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.pages.sections.destroy',[$page,$s]) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus section ini?')">
              @csrf @method('delete')
              <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
            </form>
          </div>
        </li>
      @empty
        <li class="list-group-item text-muted text-center">Belum ada section.</li>
      @endforelse
    </ul>
  </div>
  <div class="card-footer text-right">
    <a href="{{ route('admin.pages.edit',$page) }}" class="btn btn-secondary">Kembali</a>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Sortable reorder
  new Sortable(document.getElementById('sec-list'), {
    animation: 150,
    onEnd: function(){
      const ids = [...document.querySelectorAll('#sec-list [data-id]')].map(li => parseInt(li.dataset.id));
      postJSON('{{ route('admin.pages.sections.reorder',$page) }}', {ids}).then(() => {
        console.log('reordered');
      });
    }
  });

  function toggleSection(id){
    postJSON('{{ url('admin/pages/'.$page->id.'/sections') }}/'+id+'/toggle', {})
      .then(res => location.reload());
  }
</script>
@endpush

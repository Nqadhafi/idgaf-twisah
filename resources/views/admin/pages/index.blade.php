@extends('layouts.admin')
@section('page-title','Pages')
@section('page-actions')
  <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>New Page</a>
@endsection

@section('content')
<form class="mb-3" method="get">
  <div class="input-group">
    <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Cari title/slug...">
    <div class="input-group-append"><button class="btn btn-outline-secondary">Search</button></div>
  </div>
</form>

<div class="card">
  <div class="card-body p-0">
    <table class="table table-striped table-hover mb-0">
      <thead><tr>
        <th style="width:60px">ID</th><th>Title</th><th>Slug</th><th class="text-center">Published</th><th>Updated</th><th style="width:180px"></th>
      </tr></thead>
      <tbody>
      @forelse($pages as $p)
        <tr>
          <td>#{{ $p->id }}</td>
          <td>{{ $p->title }}</td>
          <td><code>{{ $p->slug }}</code></td>
          <td class="text-center">
            @if($p->is_published)
              <span class="badge badge-success">Yes</span>
            @else
              <span class="badge badge-secondary">No</span>
            @endif
          </td>
          <td>{{ $p->updated_at->format('d/m/Y H:i') }}</td>
          <td class="table-actions text-right">
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.pages.edit',$p) }}"><i class="fas fa-edit"></i></a>
            <a class="btn btn-sm btn-outline-info" href="{{ route('admin.pages.sections.index',$p) }}"><i class="fas fa-layer-group"></i> Sections</a>
            <form action="{{ route('admin.pages.destroy',$p) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus page ini?')">
              @csrf @method('delete')
              <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted p-4">Belum ada page.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $pages->links() }}</div>
</div>
@endsection

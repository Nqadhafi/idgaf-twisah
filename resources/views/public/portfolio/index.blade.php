@extends('layouts.public')
@section('title','Buku Terbit — '.config('app.name'))

@push('head')
<style>
  /* Scoped ke halaman Buku Terbit */
  .books-index .card-fancy .card-body{padding:1rem}
  @media (min-width:768px){ .books-index .card-fancy .card-body{padding:1.25rem} }
  @media (min-width:1200px){ .books-index .card-fancy .card-body{padding:1.5rem} }

  .btn-outline-gold{border-color:var(--accent); color:var(--accent)}
  .btn-outline-gold:hover{background:var(--accent); color:#1b1b1b; border-color:var(--accent)}

  .books-index .cover-wrap{position:relative; overflow:hidden; border-bottom:1px solid var(--ring)}
  .books-index .cover-wrap img{transition: transform .35s ease}
  .books-index .card-hover:hover .cover-wrap img{transform: scale(1.05)}

  .books-index .featured-ribbon{
    position:absolute; top:10px; left:10px;
    background: linear-gradient(180deg,#f7e6a3,var(--accent));
    color:#1b1b1b; font-weight:600; font-size:.7rem;
    padding:.2rem .5rem; border-radius:999px;
  }

  .books-index .search-input{min-width:220px}
</style>
@endpush

@section('content')
<section class="section books-index">
  <div class="container">

    {{-- Section header + search --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
      <div class="section-header mb-0">
        <h1 class="title section-title h4 mb-1">Buku Terbit</h1>
        <div class="prestige-line"></div>
      </div>

      <form class="d-flex" method="get" role="search" aria-label="Cari buku">
        <input class="form-control form-control-sm me-2 rounded-2xl ring search-input"
               type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul/penulis…">
        <button class="btn btn-sm btn-outline-gold rounded-2xl px-3" type="submit">
          <i class="bi bi-search me-1"></i> Cari
        </button>
      </form>
    </div>

    @if($items->count())
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($items as $item)
          <div class="col">
            <div class="card-fancy h-100 card-hover overflow-hidden">
              <div class="cover-wrap">
                @if($item->cover_url)
                  <div class="ratio ratio-3x4 bg-light">
                    <img src="{{ $item->cover_url }}"
                         class="w-100 h-100"
                         style="object-fit:cover" alt="{{ $item->title }}" loading="lazy">
                  </div>
                @else
                  <div class="ratio ratio-3x4 bg-light d-flex align-items-center justify-content-center text-secondary">
                    No Cover
                  </div>
                @endif
                @if($item->is_featured)
                  <span class="featured-ribbon">Featured</span>
                @endif
              </div>

              <div class="card-body">
                <div class="small muted mb-1">{{ $item->author ?: '—' }}</div>
                <h3 class="h6 fw-semibold mb-0 text-dark">{{ $item->title }}</h3>
              </div>

              <div class="card-footer bg-white border-0">
                <a href="{{ route('portfolio.show',$item) }}"
                   class="btn btn-sm btn-outline-gold w-100 rounded-2xl">
                  Detail
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-3">
        {{ $items->appends(['q'=>request('q')])->links() }}
      </div>
    @else
      <div class="alert alert-secondary small">Belum ada buku terbit.</div>
    @endif

  </div>
</section>
@endsection

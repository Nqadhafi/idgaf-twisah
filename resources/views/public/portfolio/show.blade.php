@extends('layouts.public')
@section('title', $item->title.' — '.config('app.name'))

@push('head')
<style>
  /* Scoped ke halaman detail buku */
  .book-show .btn-outline-gold{border-color:var(--accent); color:var(--accent)}
  .book-show .btn-outline-gold:hover{background:var(--accent); color:#1b1b1b; border-color:var(--accent)}

  .book-show .cover-wrap{position:relative; overflow:hidden}
  .book-show .cover-wrap img{transition: transform .35s ease}
  .book-show .cover-zoom:hover img{transform: scale(1.04)}
  .book-show .featured-ribbon{
    position:absolute; top:10px; left:10px; z-index:2;
    background: linear-gradient(180deg,#a3edf7,var(--accent));
    color:#1b1b1b; font-weight:600; font-size:.7rem;
    padding:.2rem .5rem; border-radius:999px;
  }
  .book-show .zoom-ovl{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
    background: rgba(0,0,0,.22); color:#fff; opacity:0; transition:.25s;
  }
  .book-show .cover-zoom:hover .zoom-ovl{opacity:1}

  .book-show .meta-badges .badge{font-weight:600}
  .book-show .excerpt-card .card-body{padding:1.25rem}
  @media (min-width:768px){ .book-show .excerpt-card .card-body{padding:1.5rem} }
  @media (min-width:1200px){ .book-show .excerpt-card .card-body{padding:1.75rem} }

  @media (min-width: 992px){
    .book-show .sticky-lg{ position: sticky; top: 92px; }
  }
</style>
@endpush

@section('content')
<section class="section book-show">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="{{ route('portfolio.index') }}"
         class="btn btn-sm btn-outline-gold rounded-2xl px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
    </div>

    <div class="row g-4">
      {{-- Cover --}}
      <div class="col-md-4">
        <div class="sticky-lg">
          @if($item->cover_url)
            <a href="javascript:void(0)" class="d-block cover-wrap cover-zoom ratio ratio-3x4 rounded-2xl ring shadow-soft overflow-hidden"
               id="coverTrigger" aria-label="Perbesar sampul">
              <img src="{{ $item->cover_url }}" class="w-100 h-100" style="object-fit:cover" alt="{{ $item->title }}">
              @if($item->is_featured)
                <span class="featured-ribbon">Featured</span>
              @endif
              <div class="zoom-ovl"><i class="bi bi-zoom-in fs-4"></i></div>
            </a>
          @else
            <div class="ratio ratio-3x4 bg-light rounded-2xl d-flex align-items-center justify-content-center muted">
              No Cover
            </div>
          @endif
        </div>
      </div>

      {{-- Info --}}
      <div class="col-md-8">
        <div class="section-header mb-3">
          <h1 class="title section-title h4 mb-1">{{ $item->title }}</h1>
          <div class="prestige-line"></div>
        </div>

        <div class="mb-3 muted">{{ $item->author ?: '—' }}</div>

        @if($item->excerpt)
          <div class="card-fancy excerpt-card mb-3">
            <div class="card-body">
              <p class="mb-0">{{ $item->excerpt }}</p>
            </div>
          </div>
        @endif

        <div class="meta-badges d-flex flex-wrap gap-2">
          @if($item->is_featured)
            <span class="badge" style="background:linear-gradient(180deg,#a3eaf7,var(--accent)); color:#1b1b1b;">Featured</span>
          @endif
          <span class="badge bg-light text-dark ring">ID #{{ $item->id }}</span>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- Lightbox modal untuk cover --}}
@if($item->cover_url)
<div class="modal fade" id="coverModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <img src="{{ $item->cover_url }}" alt="{{ $item->title }}" class="w-100">
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
  (function(){
    const trg = document.getElementById('coverTrigger');
    const modalEl = document.getElementById('coverModal');
    if(trg && modalEl){ trg.addEventListener('click', ()=> new bootstrap.Modal(modalEl).show()); }
  })();
</script>
@endpush
@endif
@endsection

@push('head')
<style>
  /* Scoped ke portfolio section saja */
  .books-section .card-fancy .card-body{padding:1rem}
  @media (min-width:768px){ .books-section .card-fancy .card-body{padding:1.25rem} }
  @media (min-width:1200px){ .books-section .card-fancy .card-body{padding:1.5rem} }

  .btn-outline-gold{border-color:var(--accent); color:var(--accent)}
  .btn-outline-gold:hover{background:var(--accent); color:#1b1b1b; border-color:var(--accent)}

  .books-section .cover-wrap{position:relative; overflow:hidden; border-bottom:1px solid var(--ring)}
  .books-section .cover-wrap img{transition: transform .35s ease}
  .books-section .card-hover:hover .cover-wrap img{transform: scale(1.05)}

  .books-section .featured-ribbon{
    position:absolute; top:10px; left:10px;
    background: linear-gradient(180deg,#a3eaf7,var(--accent));
    color:#1b1b1b; font-weight:600; font-size:.7rem;
    padding:.2rem .5rem; border-radius:999px;
  }
</style>
@endpush

<section class="section books-section" aria-labelledby="books-title">
  <div class="container">

    {{-- Section header selaras --}}
    <div class="section-header d-flex align-items-center justify-content-between mb-4">
      <div>
        <h2 id="books-title" class="title section-title h4 mb-1">{{ $data['heading'] ?? 'Buku Terbit' }}</h2>
        <div class="prestige-line"></div>
      </div>
      @if(!empty($data['cta_more_url']))
        <a href="{{ $data['cta_more_url'] }}" class="btn btn-sm btn-outline-gold rounded-2xl px-3">
          Lihat Semua
        </a>
      @endif
    </div>

    @php
      $limit  = $data['limit'] ?? 8;
      $query  = \App\Models\PortfolioItem::visible()->ordered();
      if (!empty($data['show_featured'])) $query->featured();
      $items  = $query->take($limit)->get();
    @endphp

    @if($items->count())
      <div class="row row-cols-2 row-cols-md-4 g-4">
        @foreach($items as $item)
          <div class="col">
            <a class="text-decoration-none d-block h-100" href="{{ route('portfolio.show',$item) }}">
              <div class="card-fancy h-100 card-hover overflow-hidden">
                <div class="cover-wrap">
                  @if($item->cover_url)
                    <div class="ratio ratio-3x4 bg-light">
                      <img src="{{ $item->cover_url }}"
                           class="w-100 h-100"
                           style="object-fit:cover"
                           alt="{{ $item->title }}"
                           loading="lazy">
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
                  <div class="fw-semibold small text-dark">{{ $item->title }}</div>
                  <span class="stretched-link" aria-hidden="true"></span>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    @else
      <div class="alert alert-secondary small mt-3">Belum ada data portfolio.</div>
    @endif

  </div>
</section>

@push('head')
<style>
  /* Scoped ke Packages */
  .packages-section .card-fancy .card-body{padding:1.25rem}
  @media (min-width:768px){ .packages-section .card-fancy .card-body{padding:1.5rem} }
  @media (min-width:1200px){ .packages-section .card-fancy .card-body{padding:1.75rem} }

  .packages-section .pkg-chip{
    display:inline-block; border-radius:999px; padding:.25rem .7rem;
    background: linear-gradient(180deg,#a3f7f7,var(--accent));
    border:1px solid var(--accent);
    color:#1b1b1b; font-weight:700;
  }
  .packages-section .pkg-list{line-height:1.65}
  .packages-section .pkg-list i{color:var(--brand-600)}
  .packages-section .card-popular{outline:2px solid rgba(69, 163, 200, 0.55); box-shadow:0 14px 36px rgba(69, 200, 172, 0.18)}
  .packages-section .popular-ribbon{
    position:absolute; top:10px; right:10px; z-index:2;
    background: linear-gradient(180deg,#e7f3ff,#d5e9ff);
    color:var(--brand-600); border:1px solid rgba(13,71,161,.2);
    padding:.2rem .55rem; border-radius:999px; font-size:.72rem; font-weight:700;
  }
</style>
@endpush

<section class="section packages-section" aria-labelledby="pkg-title">
  <div class="container">

    {{-- Section header selaras --}}
    <div class="section-header mb-4">
      <h2 id="pkg-title" class="title section-title h4 mb-1 text-center">{{ $data['heading'] ?? 'Paket Penerbitan' }}</h2>
      <div class="prestige-line"></div>
    </div>

    <div class="row g-4">
      @forelse(($data['items'] ?? []) as $pkg)
        @php
          // Opsi opsional di payload: popular:bool, cta:{label,url}
          $popular = !empty($pkg['popular']);
          $ctaUrl  = data_get($pkg,'cta.url');
          $ctaLbl  = data_get($pkg,'cta.label','Pilih Paket');
          $cardCls = 'card-fancy h-100 card-hover position-relative '.($popular ? 'card-popular' : '');
        @endphp
        <div class="col-12 col-md-4">
          <div class="{{ $cardCls }}">
            @if($popular)
              <span class="popular-ribbon">Terpopuler</span>
            @endif
            <div class="card-body d-flex flex-column">
              <div class="mb-3">
                <h3 class="h6 fw-semibold mb-1">{{ $pkg['name'] ?? 'Paket' }}</h3>
                <div class="pkg-chip">{{ $pkg['price'] ?? 'Rp -' }}</div>
              </div>

              @if(!empty($pkg['features']))
                <ul class="pkg-list list-unstyled small mb-3 flex-grow-1">
                  @foreach($pkg['features'] as $f)
                    <li class="mb-1 d-flex">
                      <i class="bi bi-check2 me-2"></i><span>{{ $f }}</span>
                    </li>
                  @endforeach
                </ul>
              @else
                <div class="muted small flex-grow-1">Detail paket menyusul.</div>
              @endif

              @if($ctaUrl)
                <div class="mt-2">
                  <a href="{{ $ctaUrl }}" class="btn btn-cta w-100 rounded-2xl">{{ $ctaLbl }}</a>
                </div>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-secondary small mb-0">Paket belum diisi.</div>
        </div>
      @endforelse
    </div>

  </div>
</section>

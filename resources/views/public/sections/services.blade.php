@push('head')
<style>
  /* Scoped ke Services saja */
  .services-section .card-fancy .card-body{padding:1.25rem}
  @media (min-width:768px){ .services-section .card-fancy .card-body{padding:1.5rem} }
  @media (min-width:1200px){ .services-section .card-fancy .card-body{padding:1.75rem} }

  .services-section .svc-icon{
    width:64px;height:64px;border-radius:50%;
    display:inline-flex;align-items:center;justify-content:center;
    background: radial-gradient(100% 100% at 50% 0%, #b0f4f6 0%, #45a3c8 100%);
    box-shadow: 0 6px 18px rgba(69, 185, 200, 0.28);
    color:#1b1b1b;
  }
  .services-section .svc-icon i{font-size:1.35rem}
  .services-section .card-fancy:hover .svc-icon{filter:saturate(1.05) brightness(1.02)}
  .services-section .svc-desc{line-height:1.65}
  /* Opsi highlight kartu tertentu */
  .services-section .card-highlight{outline:2px solid rgba(69, 130, 200, 0.55); outline-offset:-2px}
</style>
@endpush

<section class="section services-section" aria-labelledby="svc-title">
  <div class="container">

    {{-- Section header selaras --}}
    <div class="section-header mb-4">
      <h2 id="svc-title" class="title section-title h4 mb-1 text-center">{{ $data['heading'] ?? '' }}</h2>
      <div class="prestige-line"></div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
      @forelse(($data['items'] ?? []) as $it)
        @php
          $asLink   = !empty($it['url']);
          $cardCls  = 'card-fancy h-100 card-hover '.(!empty($it['highlight']) ? 'card-highlight' : '');
        @endphp
        <div class="col">
          @if($asLink)
            <a href="{{ $it['url'] }}" class="text-reset text-decoration-none d-block h-100">
              <div class="{{ $cardCls }}">
                <div class="card-body text-center">
                  <div class="svc-icon mb-3"><i class="{{ $it['icon'] ?? 'bi bi-check-circle' }}"></i></div>
                  <h3 class="h6 fw-semibold mb-2">{{ $it['title'] ?? 'Layanan' }}</h3>
                  @if(!empty($it['desc'])) <p class="svc-desc muted small mb-0">{{ $it['desc'] }}</p> @endif
                  <span class="stretched-link" aria-hidden="true"></span>
                </div>
              </div>
            </a>
          @else
            <div class="{{ $cardCls }}">
              <div class="card-body text-center">
                <div class="svc-icon mb-3"><i class="{{ $it['icon'] ?? 'bi bi-check-circle' }}"></i></div>
                <h3 class="h6 fw-semibold mb-2">{{ $it['title'] ?? 'Layanan' }}</h3>
                @if(!empty($it['desc'])) <p class="svc-desc muted small mb-0">{{ $it['desc'] }}</p> @endif
              </div>
            </div>
          @endif
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-secondary small mb-0">Item layanan belum diisi.</div>
        </div>
      @endforelse
    </div>

  </div>
</section>

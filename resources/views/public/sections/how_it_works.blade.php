@push('head')
<style>
  /* Scoped ke How It Works */
  .howit-section .card-fancy .card-body{padding:1.25rem}
  @media (min-width:768px){ .howit-section .card-fancy .card-body{padding:1.5rem} }
  @media (min-width:1200px){ .howit-section .card-fancy .card-body{padding:1.75rem} }

  .howit-section .step-badge{
    width:44px;height:44px;border-radius:50%;
    display:inline-flex;align-items:center;justify-content:center;
    background: linear-gradient(180deg,#a3d8f7,var(--accent));
    color:#1b1b1b;font-weight:800; box-shadow:0 8px 18px rgba(69, 158, 200, 0.25);
  }
  .howit-section .step-icon{
    width:44px;height:44px;border-radius:50%;
    display:inline-flex;align-items:center;justify-content:center;
    background: rgba(13,71,161,.08); color:var(--brand-600);
    border:1px solid rgba(13,71,161,.18);
    font-size:1.15rem;
  }
  .howit-section .step-desc{line-height:1.65}
  /* konektor halus antar kartu di layar besar */
  @media (min-width:992px){
    .howit-section .htw-col{position:relative}
    .howit-section .htw-col::after{
      content:""; position:absolute; top:22px; right:-12px; width:24px; height:2px;
      background: linear-gradient(90deg,var(--accent),#8ad8f0);
      opacity:.6;
    }
    .howit-section .htw-col:last-child::after{display:none}
  }
</style>
@endpush

<section class="section howit-section" aria-labelledby="howit-title">
  <div class="container">

    {{-- Section header selaras --}}
    <div class="section-header mb-4">
      <h2 id="howit-title" class="title section-title h4 mb-1">{{ $data['heading'] ?? 'Alur Penerbitan' }}</h2>
      <div class="prestige-line"></div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      @forelse(($data['steps'] ?? []) as $i => $s)
        @php
          $asLink = !empty($s['url']);
          $title  = $s['title'] ?? 'Langkah';
          $desc   = $s['desc']  ?? '';
          $icon   = $s['icon']  ?? null; // contoh: "bi bi-pen" (opsional)
          $colCls = 'col htw-col';
        @endphp
        <div class="{{ $colCls }}">
          @if($asLink)
            <a href="{{ $s['url'] }}" class="text-reset text-decoration-none d-block h-100">
              <div class="card-fancy h-100 card-hover">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3 gap-2">
                    @if($icon)
                      <span class="step-icon"><i class="{{ $icon }}"></i></span>
                    @else
                      <span class="step-badge">{{ $i+1 }}</span>
                    @endif
                    <h3 class="h6 fw-semibold mb-0">{{ $title }}</h3>
                  </div>
                  @if($desc)<p class="step-desc muted small mb-0">{{ $desc }}</p>@endif
                  <span class="stretched-link" aria-hidden="true"></span>
                </div>
              </div>
            </a>
          @else
            <div class="card-fancy h-100 card-hover">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3 gap-2">
                  @if($icon)
                    <span class="step-icon"><i class="{{ $icon }}"></i></span>
                  @else
                    <span class="step-badge">{{ $i+1 }}</span>
                  @endif
                  <h3 class="h6 fw-semibold mb-0">{{ $title }}</h3>
                </div>
                @if($desc)<p class="step-desc muted small mb-0">{{ $desc }}</p>@endif
              </div>
            </div>
          @endif
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-secondary small mb-0">Langkah belum diisi.</div>
        </div>
      @endforelse
    </div>

  </div>
</section>

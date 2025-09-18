{{-- resources/views/public/sections/testimonials.blade.php --}}
@push('head')
<style>
  /* Scoped ke section ini saja */
  .tst-section .card-fancy .card-body{padding:1.25rem;}
  @media (min-width:768px){ .tst-section .card-fancy .card-body{padding:1.5rem;} }
  @media (min-width:1200px){ .tst-section .card-fancy .card-body{padding:1.75rem;} }

  .tst-section .tst-quote{line-height:1.65; margin-bottom:1.25rem;}
  .tst-section .tst-meta{margin-top:auto;}
  .tst-section .carousel-indicators [data-bs-target]{background-color:#45b9c8;} /* gold */
</style>
@endpush

<section class="section tst-section">
  <div class="container">

    {{-- Section header selaras --}}
    <div class="section-header mb-4">
      <h2 class="title section-title h4 mb-1">{{ $data['heading'] ?? 'Apa Kata Penulis' }}</h2>
      <div class="prestige-line"></div>
    </div>

    @php
      $limit  = $data['limit'] ?? 6;
      $rows   = \App\Models\Testimonial::visible()->ordered()->take($limit)->get();
      $chunks = $rows->chunk(2);
    @endphp

    @if($chunks->count())
      <div id="tst-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true" data-bs-interval="6500">
        {{-- Indicators --}}
        <div class="carousel-indicators mb-0">
          @for($i=0; $i < $chunks->count(); $i++)
            <button type="button"
                    data-bs-target="#tst-carousel"
                    data-bs-slide-to="{{ $i }}"
                    class="{{ $i===0 ? 'active' : '' }}"
                    aria-label="Slide {{ $i+1 }}"></button>
          @endfor
        </div>

        <div class="carousel-inner">
          @foreach($chunks as $chunkIndex => $chunk)
            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
              {{-- Naikkan jarak antar kartu: g-4 --}}
              <div class="row g-4">
                @foreach($chunk as $t)
                  <div class="col-12 col-md-6 mb-5">
                    <div class="card-fancy h-100 card-hover">
                      <div class="card-body d-flex flex-column">
                        <p class="tst-quote muted">
                          <i class="bi bi-quote fs-4 text-primary me-1" aria-hidden="true"></i>
                          <span class="lead-strong">{{ $t->quote }}</span>
                        </p>

                        <div class="tst-meta d-flex align-items-center gap-2">
                          @if($t->avatar_url)
                            <img src="{{ $t->avatar_url }}"
                                 class="rounded-circle ring"
                                 alt="{{ $t->author }}"
                                 width="44" height="44" loading="lazy">
                          @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center ring"
                                 style="width:44px;height:44px;" aria-hidden="true">
                              <i class="bi bi-person text-secondary"></i>
                            </div>
                          @endif

                          <div class="small">
                            <div class="fw-semibold">{{ $t->author }}</div>
                            @if($t->role)<div class="muted">{{ $t->role }}</div>@endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>

        {{-- Controls --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#tst-carousel" data-bs-slide="prev" aria-label="Sebelumnya">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#tst-carousel" data-bs-slide="next" aria-label="Selanjutnya">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
      </div>
    @else
      <div class="alert alert-secondary small">Belum ada testimoni.</div>
    @endif

  </div>
</section>

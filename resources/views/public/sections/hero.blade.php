@php
  $slides = $data['slides'] ?? null; // optional: [{image_path,title,subtitle,cta:{label,url,variant}}...]
@endphp

@if(is_array($slides) && count($slides))
  {{-- Fullscreen Carousel --}}
  <section class="hero-vh">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
      <div class="carousel-inner">
        @foreach($slides as $i => $s)
          @php
            $img = !empty($s['image_path']) ? \Illuminate\Support\Facades\Storage::url($s['image_path']) : 'https://picsum.photos/seed/slide'.($i+1).'/1600/900';
          @endphp
          <div class="carousel-item {{ $i===0?'active':'' }}">
            <div class="hero-slide d-flex align-items-center justify-content-center text-center"
                 style="background-image:url('{{ $img }}');">
              <div class="hero-overlay"></div>
              <div class="container hero-content">
                <h1 class="fw-bold mb-2">{{ $s['title'] ?? 'Judul Slide' }}</h1>
                @if(!empty($s['subtitle']))
                  <p class="lead mb-3">{{ $s['subtitle'] }}</p>
                @endif
                @if(!empty($s['cta']['url']))
                  @php $variant = $s['cta']['variant'] ?? 'primary'; @endphp
                  <a href="{{ $s['cta']['url'] }}" class="btn btn-{{ $variant }} btn-lg mt-2">{{ $s['cta']['label'] ?? 'Selengkapnya' }}</a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Prev</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
@else
  {{-- Hero single (fallback) --}}
  <section class="hero-vh d-flex align-items-center" style="background:
    linear-gradient(rgba(0,0,0,.45), rgba(0,0,0,.45)),
    url('{{ !empty($data['image_path']) ? \Illuminate\Support\Facades\Storage::url($data['image_path']) : 'https://picsum.photos/seed/hero/1600/900' }}') center/cover no-repeat;">
    <div class="container text-white text-center">
      <h1 class="fw-bold mb-2">{{ $data['title'] ?? 'Penerbitan Buku Profesional' }}</h1>
      @if(!empty($data['subtitle']))<p class="lead mb-3">{{ $data['subtitle'] }}</p>@endif
      <div class="d-flex justify-content-center gap-2">
        @if(!empty($data['cta_url']))<a href="{{ $data['cta_url'] }}" class="btn btn-primary btn-lg"> {{ $data['cta_text'] ?? 'Hubungi Kami' }} </a>@endif
        <a href="{{ route('portfolio.index') }}" class="btn btn-outline-light btn-lg">Buku Terbit</a>
      </div>
    </div>
  </section>
@endif

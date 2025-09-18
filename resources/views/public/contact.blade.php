@extends('layouts.public')
@section('title','Contact — '.config('app.name'))

@section('content')
<section class="section">
  <div class="container">

    {{-- Section header selaras (title + prestige line) --}}
    <div class="section-header mb-4">
      <h1 class="title section-title h4 mb-1">Contact</h1>
      <div class="prestige-line"></div>
    </div>

    <div class="row g-4">
      {{-- Info Kontak --}}
      <div class="col-lg-5">
        <div class="card-fancy p-3 p-md-4">
          <h2 class="h6 text-uppercase muted mb-3">Info Kontak</h2>
          <ul class="list-unstyled mb-0 small">
            <li class="mb-2 d-flex">
              <i class="bi bi-geo-alt me-2 icon-lg" aria-hidden="true"></i>
              <span>{{ $contact['address'] ?? '—' }}</span>
            </li>
            <li class="mb-2 d-flex">
              <i class="bi bi-telephone me-2 icon-lg" aria-hidden="true"></i>
              <span>
                @if(!empty($contact['phone']))
                  <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}" class="link-secondary text-decoration-none">
                    {{ $contact['phone'] }}
                  </a>
                @else
                  —
                @endif
              </span>
            </li>
            <li class="mb-2 d-flex">
              <i class="bi bi-envelope me-2 icon-lg" aria-hidden="true"></i>
              <span>
                @if(!empty($contact['email']))
                  <a href="mailto:{{ $contact['email'] }}" class="link-secondary text-decoration-none">
                    {{ $contact['email'] }}
                  </a>
                @else
                  —
                @endif
              </span>
            </li>

            @if(!empty($whatsapp['url']))
              <li class="mt-3">
                <a href="{{ $whatsapp['url'] }}"
                   class="btn btn-cta btn-sm rounded-2xl px-3"
                   target="_blank" rel="noopener"
                   aria-label="Hubungi via WhatsApp">
                  <i class="bi bi-whatsapp me-1" aria-hidden="true"></i>{{ $whatsapp['label'] ?? 'WhatsApp' }}
                </a>
              </li>
            @endif
          </ul>
        </div>
      </div>

      {{-- Peta --}}
      <div class="col-lg-7">
        <div class="ratio ratio-16x9 rounded-2xl ring shadow-soft overflow-hidden">
          {!! $maps['iframe'] ?? '<div class="bg-light d-flex align-items-center justify-content-center text-secondary">Maps Embed</div>' !!}
        </div>
        <div class="small muted mt-2">
          Lokasi kantor/area layanan kami. Silakan buka di Google Maps untuk navigasi.
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

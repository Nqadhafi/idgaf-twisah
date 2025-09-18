@push('head')
<style>
  /* Scoped ke homepage contact section */
  .home-contact .card-fancy .card-body{padding:1.25rem}
  @media (min-width:768px){ .home-contact .card-fancy .card-body{padding:1.5rem} }
  @media (min-width:1200px){ .home-contact .card-fancy .card-body{padding:1.75rem} }

  .home-contact .icon-circle{
    width:40px;height:40px;border-radius:50%;
    display:inline-flex;align-items:center;justify-content:center;
    background: rgba(13,71,161,.08); color:var(--brand-600);
    border:1px solid rgba(13,71,161,.18);
    margin-right:.5rem; flex:0 0 auto;
  }
  .home-contact .contact-item{display:flex; align-items:flex-start}
  .home-contact .contact-item + .contact-item{margin-top:.5rem}
  .home-contact .map-note{color:var(--muted)}
</style>
@endpush

<section class="section home-contact" aria-labelledby="contact-title">
  @php
    $contact  = \App\Models\SiteSetting::get('contact', []);
    $maps     = \App\Models\SiteSetting::get('maps_embed', []);
    $whatsapp = \App\Models\SiteSetting::get('whatsapp_link', []);
  @endphp

  <div class="container">
    {{-- Section header selaras --}}
    <div class="section-header mb-4">
      <h2 id="contact-title" class="title section-title h4 mb-2 text-center">{{ $data['heading'] ?? 'Kontak Kami' }}</h2>
      <div class="prestige-line"></div>
    </div>

    <div class="row g-4">
      {{-- Info kontak --}}
      <div class="col-lg-5">
        <div class="card-fancy">
          <div class="card-body">
            <ul class="list-unstyled small mb-0">
              <li class="contact-item">
                <span class="icon-circle" aria-hidden="true"><i class="bi bi-geo-alt"></i></span>
                <span>{{ $contact['address'] ?? '—' }}</span>
              </li>
              <li class="contact-item">
                <span class="icon-circle" aria-hidden="true"><i class="bi bi-telephone"></i></span>
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
              <li class="contact-item">
                <span class="icon-circle" aria-hidden="true"><i class="bi bi-envelope"></i></span>
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
      </div>

      {{-- Maps --}}
      <div class="col-lg-7">
        <div class="ratio ratio-16x9 rounded-2xl ring shadow-soft overflow-hidden">
          {!! $maps['iframe'] ?? '<div class="bg-light d-flex align-items-center justify-content-center text-secondary">Maps Embed</div>' !!}
        </div>
        <div class="small map-note mt-2">
          Lokasi kantor/area layanan kami. Silakan buka di Google Maps untuk navigasi.
        </div>
      </div>
    </div>
  </div>
</section>

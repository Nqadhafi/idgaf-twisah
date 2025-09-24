@push('head')
<style>
  /* Scoped ke Galeri */
  .gallery-section .thumb{position:relative; overflow:hidden;}
  .gallery-section .thumb img{transition: transform .35s ease}
  .gallery-section .thumb:hover img{transform: scale(1.06)}
  .gallery-section .thumb .ovl{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
    background: rgba(0,0,0,.25); color:#fff; font-size:1.4rem; opacity:0; transition:.25s;
  }
  .gallery-section .thumb:hover .ovl{opacity:1}

  .gallery-section .card-fancy .card-body{padding:1.25rem}
  @media (min-width:768px){ .gallery-section .card-fancy .card-body{padding:1.5rem} }
  @media (min-width:1200px){ .gallery-section .card-fancy .card-body{padding:1.75rem} }

  /* Modal nav */
  .gallery-section .gal-nav{
    position:absolute; top:50%; transform:translateY(-50%);
    width:36px; height:36px; border-radius:999px;
    background: rgba(0,0,0,.4); color:#fff; border:1px solid var(--ring);
    display:flex; align-items:center; justify-content:center;
  }
  .gallery-section .gal-prev{left:8px}
  .gallery-section .gal-next{right:8px}

    /* ===== Visi & Misi (scoped) ===== */
  .vm-section .vm-card .card-body{padding:1.25rem}
  @media (min-width:768px){ .vm-section .vm-card .card-body{padding:1.5rem} }
  @media (min-width:1200px){ .vm-section .vm-card .card-body{padding:1.75rem} }

  .vm-section .vm-badge{
    display:inline-flex; align-items:center; gap:.4rem;
    background: linear-gradient(180deg,#f7e6a3,var(--accent));
    color:#1b1b1b; font-weight:800; font-size:.75rem;
    padding:.25rem .6rem; border-radius:999px;
  }
  .vm-section .vm-icon{
    width:40px;height:40px;border-radius:50%;
    display:inline-flex;align-items:center;justify-content:center;
    background: rgba(13,71,161,.08); color:var(--brand-600);
    border:1px solid rgba(13,71,161,.18);
    font-size:1.1rem;
  }
  .vm-section .vm-lead{
    font-size:1.05rem; line-height:1.75; color:#1f2937;
  }
  .vm-section .vm-list{line-height:1.85; margin-bottom:0}
  .vm-section .vm-list li + li{margin-top:.35rem}
  .vm-section .vm-list i{color:var(--brand-600)}
</style>
@endpush
{{-- ===== Visi & Misi (new) ===== --}}
<section class="section vm-section" aria-labelledby="vm-title">
  @php
    $vm     = $data['visi_misi'] ?? \App\Models\SiteSetting::get('visi_misi', []);
    $visi   = $data['visi'] ?? ($vm['visi'] ?? null);           // string
    $misi   = $data['misi'] ?? ($vm['misi'] ?? []);             // array atau string
    $ctaUrl = $data['vm_cta_url'] ?? null;                      // opsional
  @endphp

  <div class="container">
    <div class="section-header d-flex align-items-center justify-content-between mb-4">
      <div>
        {{-- <h2 id="vm-title" class="title section-title h4 mb-1">Visi &amp; Misi</h2> --}}
        <div class="prestige-line"></div>
      </div>
      @if($ctaUrl)
        <a href="{{ $ctaUrl }}" class="btn btn-sm btn-outline-neutral rounded-2xl px-3">Selengkapnya</a>
      @endif
    </div>

    <div class="row g-4 align-items-stretch">
      {{-- Visi --}}
      <div class="col-lg-5">
        <div class="card-fancy vm-card h-100 ring shadow-soft">
          <div class="card-body">
            <div class="d-flex align-items-center gap-2 mb-3">
              <span class="vm-badge"><i class="bi bi-stars"></i> VISI</span>
              <span class="vm-icon" aria-hidden="true"><i class="bi bi-eye"></i></span>
            </div>
            @if(!empty($visi))
              <div class="vm-lead">{!! nl2br(e($visi)) !!}</div>
            @else
              <div class="vm-lead text-muted">Belum ada visi yang ditetapkan.</div>
            @endif
          </div>
        </div>
      </div>

      {{-- Misi --}}
      <div class="col-lg-7">
        <div class="card-fancy vm-card h-100 ring shadow-soft">
          <div class="card-body">
            <div class="d-flex align-items-center gap-2 mb-3">
              <span class="vm-badge"><i class="bi bi-flag"></i> MISI</span>
              <span class="vm-icon" aria-hidden="true"><i class="bi bi-compass"></i></span>
            </div>

            @if(is_array($misi) && count($misi))
              <ul class="vm-list list-unstyled">
                @foreach($misi as $point)
                  <li class="d-flex">
                    <i class="bi bi-check2-circle me-2"></i>
                    <span>{{ $point }}</span>
                  </li>
                @endforeach
              </ul>
            @elseif(is_string($misi) && trim($misi) !== '')
              <div class="vm-lead">{!! nl2br(e($misi)) !!}</div>
            @else
              <div class="text-muted">Belum ada misi yang ditetapkan.</div>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
<section class="section gallery-section" aria-labelledby="gallery-title">
  <div class="container">

    {{-- Section header selaras --}}
    <div class="section-header mb-4">
      <h2 id="gallery-title" class="title section-title h4 mb-1">{{ $data['heading'] ?? 'Galeri' }}</h2>
      <div class="prestige-line"></div>
    </div>

    <div class="row g-4">
      @forelse(($data['images'] ?? []) as $img)
        @php $src = \Illuminate\Support\Facades\Storage::url($img['path']); @endphp
        <div class="col-6 col-md-3 col-lg-2">
          <a href="javascript:void(0)"
             class="thumb ratio ratio-1x1 rounded-2xl ring shadow-soft overflow-hidden d-block js-gal"
             data-index="{{ $loop->index }}"
             data-full="{{ $src }}"
             data-alt="{{ $img['alt'] ?? 'Gallery' }}"
             aria-label="Lihat gambar: {{ $img['alt'] ?? 'Gallery' }}">
            <img src="{{ $src }}" loading="lazy" class="w-100 h-100" style="object-fit:cover" alt="{{ $img['alt'] ?? 'Gallery' }}">
            <div class="ovl"><i class="bi bi-zoom-in"></i></div>
          </a>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-secondary small mb-0">
            Galeri belum diisi.
          </div>
        </div>
      @endforelse
    </div>

  </div>

  {{-- Lightbox Modal --}}
  <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-dark">
        <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0 position-relative">
          <img id="galModalImg" src="" alt="" class="w-100">
          <button type="button" class="gal-nav gal-prev" aria-label="Sebelumnya">&#10094;</button>
          <button type="button" class="gal-nav gal-next" aria-label="Selanjutnya">&#10095;</button>
        </div>
        <div id="galCaption" class="small text-light p-2"></div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  (function(){
    const items = Array.from(document.querySelectorAll('.gallery-section .js-gal'));
    if(!items.length) return;

    const modalEl = document.getElementById('galleryModal');
    const imgEl   = document.getElementById('galModalImg');
    const capEl   = document.getElementById('galCaption');
    const modal   = new bootstrap.Modal(modalEl);
    let current   = 0;

    function show(idx){
      if(idx < 0) idx = items.length - 1;
      if(idx >= items.length) idx = 0;
      current = idx;
      const it = items[current];
      imgEl.src = it.dataset.full;
      imgEl.alt = it.dataset.alt || '';
      capEl.textContent = it.dataset.alt || '';
    }

    items.forEach((a, i) => {
      a.addEventListener('click', (e) => {
        e.preventDefault();
        show(i);
        modal.show();
        // fokus ke modal agar bisa pakai panah kiri/kanan
        setTimeout(()=> modalEl.focus(), 50);
      });
    });

    modalEl.querySelector('.gal-prev')?.addEventListener('click', () => show(current-1));
    modalEl.querySelector('.gal-next')?.addEventListener('click', () => show(current+1));

    modalEl.setAttribute('tabindex','0');
    modalEl.addEventListener('keydown', (e) => {
      if(e.key === 'ArrowLeft') show(current-1);
      if(e.key === 'ArrowRight') show(current+1);
    });
  })();
</script>
@endpush

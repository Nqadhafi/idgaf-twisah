@push('head')
<style>
  /* Scoped ke FAQ saja */
  .faq-section .accordion{ border-radius:14px; }
  .faq-section .accordion-item{ border:0; border-bottom:1px solid var(--ring); }
  .faq-section .accordion-item:last-child{ border-bottom:0; }
  .faq-section .accordion-button{
    padding:1rem 1.25rem; font-weight:600; color:var(--ink); background:#fff;
  }
  @media (min-width:768px){ .faq-section .accordion-button{ padding:1.1rem 1.25rem; } }
  .faq-section .accordion-button:focus{
    box-shadow:0 0 0 .2rem rgba(69, 200, 178, 0.25);
    border-color:rgba(69, 196, 200, 0.55);
  }
  .faq-section .accordion-button:not(.collapsed){
    color:var(--brand-600); background:linear-gradient(180deg,#ffffff,#fafafa);
    box-shadow: inset 0 -1px 0 rgba(0,0,0,.03);
  }
  .faq-section .accordion-button::after{ filter: hue-rotate(20deg) saturate(1.2); } /* chevron sedikit gold */
  .faq-section .accordion-body{ padding:1rem 1.25rem 1.25rem; line-height:1.7; color:#374151; }
</style>
@endpush

<section class="section faq-section" aria-labelledby="faq-title">
  <div class="container">

    {{-- Section header selaras --}}
    <div class="section-header mb-4">
      <h2 id="faq-title" class="title section-title h4 mb-1">{{ $data['heading'] ?? 'Pertanyaan Umum' }}</h2>
      <div class="prestige-line"></div>
    </div>

    @php
      $limit = $data['limit'] ?? 6;
      $rows  = \App\Models\Faq::visible()->ordered()->take($limit)->get();
    @endphp

    @if($rows->count())
      <div class="accordion rounded-2xl ring shadow-soft" id="faqAcc">
        @foreach($rows as $i => $f)
          @php $uid = $f->id ?? $i; @endphp
          <div class="accordion-item">
            <h2 class="accordion-header" id="faq-h-{{ $uid }}">
              <button class="accordion-button {{ $i ? 'collapsed' : '' }}"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#faq-c-{{ $uid }}"
                      aria-expanded="{{ $i ? 'false' : 'true' }}"
                      aria-controls="faq-c-{{ $uid }}">
                {{ $f->question }}
              </button>
            </h2>
            <div id="faq-c-{{ $uid }}"
                 class="accordion-collapse collapse {{ $i ? '' : 'show' }}"
                 data-bs-parent="#faqAcc"
                 aria-labelledby="faq-h-{{ $uid }}">
              <div class="accordion-body">
                {!! nl2br(e($f->answer)) !!}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="alert alert-secondary small mb-0">FAQ belum tersedia.</div>
    @endif

  </div>
</section>

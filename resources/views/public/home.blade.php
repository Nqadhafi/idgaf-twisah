@extends('layouts.public')
@section('title','Home — '.config('app.name'))

{{-- Override hero bawaan layout --}}
{{-- @section('hero')
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <h1 class="headline display-6 mb-3">
          Penerbit Buku untuk UMKM, Komunitas, dan Penulis Mandiri
        </h1>
        <p class="sub lead-strong mb-4">
          Editing, layout, desain cover, hingga cetak & distribusi—semua dalam satu atap.
        </p>
        <div class="d-flex flex-wrap gap-2">
          <a href="{{ route('pages.services') }}" class="btn btn-brand rounded-2xl px-4">
            <i class="bi bi-journal-text me-1"></i> Lihat Layanan
          </a>
          <a href="{{ route('portfolio.index') }}" class="btn btn-outline-neutral rounded-2xl px-4">
            <i class="bi bi-book me-1"></i> Buku Terbit
          </a>
        </div>
      </div>
      <div class="col-lg-5 d-none d-lg-block">
        <div class="ratio ratio-4x3 rounded-2xl ring shadow-soft overflow-hidden">
          <img src="https://picsum.photos/seed/sp-publish/800/600" class="w-100 h-100" style="object-fit:cover" alt="Penerbitan Buku">
        </div>
      </div>
    </div>
  </div>
</section>
@endsection --}}

@section('content')
  {{-- Sections dinamis --}}
  @if(isset($sections) && $sections->count())
    @foreach($sections as $section)
      @includeIf("public.sections.".$section->type, ['data' => $section->payload ?? []])
    @endforeach
  @else
    {{-- Fallback: services, portfolio, testimonials, faq --}}
    @include('public.sections.services', [
      'data'=>['heading'=>'Layanan Kami']
    ])
    @include('public.sections.portfolio', [
      'data'=>[
        'heading'=>'Buku Terbit',
        'show_featured'=>true,
        'limit'=>8,
        'cta_more_url'=>route('portfolio.index')
      ]
    ])
    @include('public.sections.testimonials', [
      'data'=>['heading'=>'Apa Kata Penulis']
    ])
    @include('public.sections.faq', [
      'data'=>['heading'=>'FAQ']
    ])
  @endif
@endsection

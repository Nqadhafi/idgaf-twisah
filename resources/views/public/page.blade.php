@extends('layouts.public')
@section('title', ($page->meta_title ?: $page->title).' — '.config('app.name'))
@section('meta_description', $page->meta_description ?? '')

@section('content')
  <section class="section">
    <div class="container">
      <header class="mb-4">
        <h1 class="h3 mb-1 mt-4 text-center">{{ $page->title }}</h1>
        @if($page->meta_description)
          <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($page->meta_description), 160, '') }}">

        @endif
      </header>

      @if($sections->count())
        @foreach($sections as $section)
          @includeIf("public.sections.".$section->type, ['data' => $section->payload ?? []])
        @endforeach
      @else
        <div class="alert alert-info">Konten sedang disiapkan.</div>
      @endif
    </div>
  </section>
@endsection

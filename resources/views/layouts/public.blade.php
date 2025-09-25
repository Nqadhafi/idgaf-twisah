<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', config('app.name'))</title>
  <meta name="title" content="@yield('meta_title', 'Shabat Printing — Penerbitan & Percetakan')">
  <meta name="description" content="@yield('meta_description', 'Bergabunglah dengan layanan percetakan & penerbitan tepercaya.')">
  {{-- Open Graph --}}
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:title" content="@yield('og_title', 'Shabat Printing')" />
  <meta property="og:description" content="@yield('og_description', 'Percetakan & penerbitan profesional.')" />
  <meta property="og:image" content="@yield('og_image', asset('favicon.png'))" />
  {{-- Twitter --}}
  <meta name="twitter:card" content="summary_large_image" />

  {{-- Fonts + Icons --}}
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --brand: #0d47a1; --brand-600:#0b3d8c; --accent:#4db0ce;
      --ink:#1f2937; --muted:#6b7280; --ring:rgba(13,71,161,.12);
    }
    html,body{height:100%}
    body{font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
         color:var(--ink); scroll-behavior:smooth; background:#fff;}
    /* ===== NAVBAR ala career site: transparan → solid saat scroll ===== */
    .navbar{transition:.25s ease; border-bottom:1px solid transparent;}
    .navbar.transparent{background:transparent; border-color:transparent;}
    .navbar.transparent .nav-link{color:#fff;}
    .navbar.transparent .navbar-brand, .navbar.transparent .btn-nav{color:#fff;}
    .navbar.solid{background:#fff; border-color:rgba(13,71,161,.12); box-shadow:0 6px 20px rgba(0,0,0,.06);}
    .navbar.solid .nav-link{color:var(--ink);}
    .navbar .nav-link:hover{color:var(--brand);}
    .btn-nav{border:1px solid #fff;}
    .navbar.solid .btn-nav{color:#fff; background:var(--brand); border-color:var(--brand);}
    .btn-nav-outline{border:1px solid #fff; color:#fff;}
    .navbar.solid .btn-nav-outline{border-color:var(--brand); color:var(--brand);}
    .brand-logo{height:36px; width:auto}
    /* ===== HERO fullscreen carousel (overlay gelap) ===== */
    .hero-vh{min-height:100vh;}
    .hero-slide{position:relative; min-height:100vh; background-size:cover; background-position:center;}
    .hero-overlay{position:absolute; inset:0; background:rgba(0,0,0,.5);}
    .hero-content{position:relative; z-index:2; color:#fff;}
    /* ===== Section & cards ===== */
    .section{padding:3rem 0} @media(min-width:992px){ .section{padding:4rem 0} }
    .section-title{font-weight:700}
    .card-fancy{border:1px solid var(--ring); border-radius:14px;}
    .badge-verified{background:linear-gradient(180deg,#e7f3ff,#d5e9ff); color:var(--brand-600); border:1px solid rgba(13,71,161,.2); font-weight:600;}
    /* ===== Footer ===== */
    footer{border-top:1px solid rgba(13,71,161,.1)}
    /* ===== Scroll to top ===== */
    #scrollToTopBtn{position:fixed; right:16px; bottom:16px; z-index:10; display:none;}
  </style>
  @stack('head')
</head>
@php
  $isHome = request()->routeIs('home');
  $branding = \App\Models\SiteSetting::get('branding', []);
  $logo_dark  = !empty($branding['logo_dark'])  ? asset('storage/img_logo/swg-color.webp')   : null;
  $logo_light = !empty($branding['logo_light']) ?  asset('storage/img_logo/swg-white.webp')  : null;
@endphp
<body class="d-flex flex-column min-vh-100">
  {{-- NAVBAR --}}
  <nav class="navbar navbar-expand-lg fixed-top {{ $isHome ? 'transparent' : 'solid' }}">
    <div class="container d-flex align-items-center">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
        @if($logo_dark || $logo_light)
          <img id="brandLogo" class="brand-logo" src="{{ $isHome ? ($logo_light ?? $logo_dark) : ($logo_dark ?? $logo_light) }}" alt="Logo">
        @else
          <span class="fw-semibold {{ $isHome ? 'text-white':'text-dark' }}">{{ config('app.name','Shabat Printing') }}</span>
        @endif
      </a>

      <div class="d-lg-none ms-auto me-2">
        @php $wa = \App\Models\SiteSetting::get('whatsapp_link'); @endphp
        @if(!empty($wa['url']))
          <a href="{{ $wa['url'] }}" class="btn btn-sm btn-nav {{ $isHome ? '' : 'btn-primary' }}" target="_blank">
            <ion-icon name="logo-whatsapp" class="align-text-top"></ion-icon>
            <span class="d-none d-lg-inline">{{ $wa['label'] ?? 'WhatsApp' }}</span>
          </a>
        @endif
      </div>

      <button class="navbar-toggler {{ $isHome ? 'navbar-light' : 'navbar-light' }}" type="button" data-bs-toggle="collapse" data-bs-target="#pubNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="pubNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.services')?'active':'' }}" href="{{ route('pages.services') }}">Services</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('portfolio.*')?'active':'' }}" href="{{ route('portfolio.index') }}">Buku Terbit</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.visimisi')?'active':'' }}" href="{{ route('pages.visimisi') }}">Visi–Misi</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact.index')?'active':'' }}" href="{{ route('contact.index') }}">Contact</a></li>
        </ul>
        <div class="d-none d-lg-flex ms-auto">
          @if(!empty($wa['url']))
            <a href="{{ $wa['url'] }}" class="btn btn-sm me-2 btn-nav-outline" target="_blank">
              <ion-icon name="logo-whatsapp" class="me-1"></ion-icon><span>WhatsApp</span>
            </a>
          @endif
          {{-- <a href="{{ route('login') }}" class="btn btn-sm btn-nav">
            <ion-icon name="log-in" class="me-1"></ion-icon><span>Login</span>
          </a> --}}
        </div>
      </div>
    </div>
  </nav>

  {{-- HERO slot / content --}}
  <main class="flex-grow-1">
    @yield('hero') {{-- kalau halaman bikin section('hero'), tampil di sini --}}
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="bg-dark text-light py-5 mt-5">
    <div class="container">
      <div class="row gy-4">
        <div class="col-md">
          @if($logo_light)
            <img src="{{ $logo_light }}" alt="Logo" style="width:10rem" class="mb-2">
          @else
            <div class="h5 mb-2">{{ config('app.name','Shabat Printing') }}</div>
          @endif
          <small class="text-white d-block">Designed & developed by Shabat Printing</small>
        </div>
        <div class="col-6 col-md">
          <h5>Company</h5>
          <ul class="list-unstyled small">
            <li><a class="text-white text-decoration-none" href="{{ route('pages.visimisi') }}">About Us</a></li>
            <li><a class="text-white text-decoration-none" href="https://shabatprinting.com" target="_blank">Website</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>Follow Us</h5>
          <ul class="list-unstyled small">
            <li><a class="text-white text-decoration-none" href="#">Instagram</a></li>
            <li><a class="text-white text-decoration-none" href="#">TikTok</a></li>
            <li><a class="text-white text-decoration-none" href="#">Facebook</a></li>
          </ul>
        </div>
        <div class="col-12 col-md-auto">
          <h5>Alamat</h5>
          <div class="small text-white"><i class="bi bi-geo-alt me-1"></i>{{ data_get(\App\Models\SiteSetting::get('contact'), 'address', '—') }}</div>
        </div>
      </div>
      <hr class="border-secondary mt-4">
      <div class="d-flex justify-content-between small text-muted">
        <div>© {{ date('Y') }} Shabat Printing. All rights reserved.</div>
        <div class="d-flex gap-2">
          <ion-icon name="logo-instagram"></ion-icon>
          <ion-icon name="logo-tiktok"></ion-icon>
          <ion-icon name="logo-facebook"></ion-icon>
        </div>
      </div>
    </div>
  </footer>

  <button id="scrollToTopBtn" class="btn btn-primary rounded-circle">
    <ion-icon name="arrow-up-circle" size="large"></ion-icon>
  </button>

  {{-- Scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    (function(){
      const nav = document.querySelector('.navbar');
      const isHome = {{ $isHome ? 'true' : 'false' }};
      const brandLogo = document.getElementById('brandLogo');
      const logoDark = @json($logo_dark);
      const logoLight = @json($logo_light);

      function applyNav(){
        const scrolled = window.scrollY > 50;
        if(isHome){
          nav.classList.toggle('transparent', !scrolled);
          nav.classList.toggle('solid', scrolled);
          // swap logo
          if(brandLogo && (logoDark || logoLight)){
            brandLogo.src = scrolled ? (logoDark || logoLight) : (logoLight || logoDark);
          }
        } else {
          nav.classList.remove('transparent'); nav.classList.add('solid');
        }
      }
      window.addEventListener('scroll', applyNav, {passive:true});
      document.addEventListener('DOMContentLoaded', applyNav);

      // scroll-to-top
      const topBtn = document.getElementById('scrollToTopBtn');
      function toggleTopBtn(){ topBtn.style.display = window.scrollY > 200 ? 'inline-flex' : 'none'; }
      window.addEventListener('scroll', toggleTopBtn, {passive:true});
      topBtn.addEventListener('click', ()=>window.scrollTo({top:0, behavior:'smooth'}));
    })();
  </script>
  @stack('scripts')
</body>
</html>

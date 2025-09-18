<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin — '.config('app.name'))</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Bootstrap 4.6 + AdminLTE 3.2 + Font Awesome (CDN) --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    .table-actions .btn { margin-right: .25rem; }
    .sortable-ghost { opacity: .4; }
    .content-header h1 { font-size: 1.25rem; margin: 0; }
    .pagination { margin-bottom: 0; }
    .img-64 { width:64px;height:64px;object-fit:cover;border-radius:.25rem; }
    .img-120 { width:120px;height:160px;object-fit:cover;border-radius:.25rem; }
  </style>
  @stack('head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- Navbar --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('home') }}" class="nav-link">Public Site</a></li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-user"></i> {{ auth()->user()->name ?? 'Admin' }}</a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="#" class="dropdown-item"
             onclick="event.preventDefault();document.getElementById('logout-form').submit();">
             <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
      </li>
    </ul>
  </nav>

  {{-- Sidebar --}}
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <span class="brand-text font-weight-light">{{ config('app.name','Shabat Printing') }}</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard')?'active':'' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*')?'active':'' }}">
              <i class="nav-icon fas fa-file-alt"></i><p>Pages</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.portfolio.index') }}" class="nav-link {{ request()->routeIs('admin.portfolio.*')?'active':'' }}">
              <i class="nav-icon fas fa-book"></i><p>Portfolio</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*')?'active':'' }}">
              <i class="nav-icon fas fa-comment-dots"></i><p>Testimonials</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*')?'active':'' }}">
              <i class="nav-icon fas fa-question-circle"></i><p>FAQs</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*')?'active':'' }}">
              <i class="nav-icon fas fa-cog"></i><p>Settings</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  {{-- Content Wrapper --}}
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <h1>@yield('page-title','Admin')</h1>
        @yield('page-actions')
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        @include('partials.flash')
        @yield('content')
      </div>
    </section>
  </div>

  <footer class="main-footer small">
    <strong>© {{ date('Y') }} {{ config('app.name') }}</strong>
    <div class="float-right d-none d-sm-inline">AdminLTE 3.2</div>
  </footer>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
  window.csrf = document.querySelector('meta[name=csrf-token]').getAttribute('content');
  function postJSON(url, data = {}) {
    return fetch(url, {
      method: 'POST',
      headers: {'Content-Type':'application/json','X-CSRF-TOKEN': window.csrf, 'X-Requested-With':'XMLHttpRequest'},
      body: JSON.stringify(data)
    }).then(r => r.json());
  }
</script>
@stack('scripts')
</body>
</html>

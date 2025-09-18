<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login — {{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Bootstrap 5.3 + Bootstrap Icons (CDN) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { min-height: 100vh; }
    .bg-grad { background: linear-gradient(180deg, rgba(13,110,253,.06), transparent 60%); }
    .card-login { max-width: 420px; }
  </style>
</head>
<body class="bg-grad d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 d-flex justify-content-center">
        <div class="card shadow-sm card-login w-100">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <a href="{{ route('home') }}" class="text-decoration-none">
                <div class="fw-semibold fs-5">{{ config('app.name','Shabat Printing') }}</div>
              </a>
              <div class="text-secondary small">Admin Login</div>
            </div>

            {{-- Flash & errors --}}
            @if(session('status'))
              <div class="alert alert-info py-2 mb-3">{{ session('status') }}</div>
            @endif
            @if($errors->any())
              <div class="alert alert-danger py-2 mb-3">
                <ul class="mb-0 ps-3">
                  @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
              </div>
            @endif

            <form method="post" action="{{ route('login.attempt') }}" novalidate>
              @csrf
              <div class="mb-3">
                <label class="form-label">Email atau Username</label>
                <input type="text"
                       name="login"
                       class="form-control @error('login') is-invalid @enderror"
                       value="{{ old('login') }}"
                       placeholder="nama@domain.com atau username"
                       required autofocus>
                @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label class="form-label d-flex justify-content-between">
                  <span>Password</span>
                  {{-- (Optional) <a href="#" class="small">Lupa password?</a> --}}
                </label>
                <div class="input-group">
                  <input type="password"
                         name="password"
                         class="form-control @error('password') is-invalid @enderror"
                         placeholder="••••••••"
                         required id="pwd">
                  <button class="btn btn-outline-secondary" type="button" id="togglePwd">
                    <i class="bi bi-eye-slash" id="eyeIcon"></i>
                  </button>
                  @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                  <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <a href="{{ route('home') }}" class="small text-decoration-none"><i class="bi bi-house-door"></i> Beranda</a>
              </div>

              <button class="btn btn-primary w-100" type="submit">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
              </button>
            </form>
          </div>
          <div class="card-footer text-center small text-secondary">
            © {{ date('Y') }} {{ config('app.name') }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const btn = document.getElementById('togglePwd');
    const pwd = document.getElementById('pwd');
    const icon = document.getElementById('eyeIcon');
    btn && btn.addEventListener('click', function(){
      const isText = pwd.type === 'text';
      pwd.type = isText ? 'password' : 'text';
      icon.classList.remove(isText ? 'bi-eye' : 'bi-eye-slash');
      icon.classList.add(isText ? 'bi-eye-slash' : 'bi-eye');
    });
  </script>
</body>
</html>

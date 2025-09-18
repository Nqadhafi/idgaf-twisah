@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check mr-2"></i>{{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
@endif
@if($errors->any())
  <div class="alert alert-danger">
    <b>Terjadi kesalahan:</b>
    <ul class="mb-0">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

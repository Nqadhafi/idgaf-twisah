@extends('layouts.admin')
@section('page-title','Dashboard')

@section('content')
<div class="row">
  @php
    $boxes = [
      ['label'=>'Pages','icon'=>'fa-file-alt','value'=>$stats['pages'] ?? 0,'color'=>'info'],
      ['label'=>'Sections','icon'=>'fa-layer-group','value'=>$stats['sections'] ?? 0,'color'=>'secondary'],
      ['label'=>'Portfolio','icon'=>'fa-book','value'=>$stats['portfolio'] ?? 0,'color'=>'primary'],
      ['label'=>'Testimonials','icon'=>'fa-comment-dots','value'=>$stats['testimonials'] ?? 0,'color'=>'success'],
      ['label'=>'FAQs','icon'=>'fa-question-circle','value'=>$stats['faqs'] ?? 0,'color'=>'warning'],
    ];
  @endphp
  @foreach($boxes as $b)
  <div class="col-12 col-sm-6 col-lg-3">
    <div class="info-box">
      <span class="info-box-icon bg-{{ $b['color'] }}"><i class="fas {{ $b['icon'] }}"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">{{ $b['label'] }}</span>
        <span class="info-box-number">{{ $b['value'] }}</span>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection

@extends('layouts.app')
@section('title','Solutions')

@section('content')

{{-- HERO --}}
<section class="position-relative" style="height:70vh; background:url('{{ asset('/solutions.jpg') }}') center/cover no-repeat;">
  <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background:rgba(11,18,32,0.6);"></div>
  <div class="d-flex h-100 align-items-center justify-content-center text-center text-white position-relative">
    <div data-aos="fade-up">
      <h1 class="display-3 fw-bold mb-3" style="color:#fff">Solutions</h1>
      <p class="lead">Comprehensive IP services tailored to your business needs.</p>
    </div>
  </div>
</section>

{{-- SOLUTIONS CARDS --}}
<section class="py-5">
  <div class="container">
    <h2 class="fw-bold mb-5 text-center" style="color:#4f708e;">Our Core Services</h2>
    <div class="row g-4">
      @php
        $solutions = [
          ['title'=>'Patent Filing','desc'=>'End-to-end support for PCT, national phase, and direct filings worldwide.','icon'=>'bi bi-file-earmark-text'],
          ['title'=>'Translations','desc'=>'High-quality technical translations for patents, trademarks, and designs.','icon'=>'bi bi-translate'],
          ['title'=>'EP Validation','desc'=>'Seamless EP validations across all contracting states.','icon'=>'bi bi-globe-europe-africa'],
          ['title'=>'Trademark & Design','desc'=>'Efficient filing and protection of trademarks and industrial designs.','icon'=>'bi bi-badge-tm'],
          ['title'=>'Recordals','desc'=>'Ownership changes, mergers, assignments, and legal updates.','icon'=>'bi bi-journal-text'],
        ];
      @endphp
      @foreach($solutions as $s)
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 text-center p-4">
          <i class="{{ $s['icon'] }} display-5 mb-3" style="color:#4f708e;"></i>
          <h5 class="fw-bold mb-2">{{ $s['title'] }}</h5>
          <p class="text-muted">{{ $s['desc'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- OUR APPROACH --}}
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-center mb-5" style="color:#4f708e;">Our Approach</h2>
    <div class="row g-4">
      <div class="col-md-3 text-center">
        <i class="bi bi-lightbulb display-5 mb-3" style="color:#4f708e;"></i>
        <h6 class="fw-bold">1. Consultation</h6>
        <p class="text-muted">Understanding your IP needs and goals.</p>
      </div>
      <div class="col-md-3 text-center">
        <i class="bi bi-gear display-5 mb-3" style="color:#4f708e;"></i>
        <h6 class="fw-bold">2. Strategy</h6>
        <p class="text-muted">Tailored filing and protection strategy for each jurisdiction.</p>
      </div>
      <div class="col-md-3 text-center">
        <i class="bi bi-file-earmark-check display-5 mb-3" style="color:#4f708e;"></i>
        <h6 class="fw-bold">3. Execution</h6>
        <p class="text-muted">Seamless coordination with global partners.</p>
      </div>
      <div class="col-md-3 text-center">
        <i class="bi bi-bar-chart-line display-5 mb-3" style="color:#4f708e;"></i>
        <h6 class="fw-bold">4. Monitoring</h6>
        <p class="text-muted">Continuous updates, renewals, and legal support.</p>
      </div>
    </div>
  </div>
</section>

{{-- INDUSTRIES WE SERVE --}}
<section class="py-5">
  <div class="container">
    <h2 class="fw-bold text-center mb-5" style="color:#4f708e;">Industries We Serve</h2>
    <div class="row g-4 text-center">
      <div class="col-md-3">
        <i class="bi bi-cpu display-5 mb-2" style="color:#4f708e;"></i>
        <p class="fw-bold mb-0">Technology</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-prescription2 display-5 mb-2" style="color:#4f708e;"></i>
        <p class="fw-bold mb-0">Pharma & Biotech</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-car-front display-5 mb-2" style="color:#4f708e;"></i>
        <p class="fw-bold mb-0">Automotive</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-hammer display-5 mb-2" style="color:#4f708e;"></i>
        <p class="fw-bold mb-0">Engineering</p>
      </div>
    </div>
  </div>
</section>

{{-- WHY CHOOSE US --}}
<section class="py-5 bg-light">
  <div class="container text-center" data-aos="zoom-in">
    <h2 class="fw-bold mb-4" style="color:#4f708e;">Why Choose Emuna IP?</h2>
    <p class="text-muted fs-5">We combine expertise, technology, and global partnerships to deliver seamless IP solutions.</p>
    <div class="row mt-4">
      <div class="col-md-4"><i class="bi bi-check2-circle text-success fs-3"></i><h5 class="fw-bold mt-2">Transparency</h5><p class="text-muted">Clear pricing & reporting.</p></div>
      <div class="col-md-4"><i class="bi bi-people text-primary fs-3"></i><h5 class="fw-bold mt-2">Global Network</h5><p class="text-muted">Trusted partners worldwide.</p></div>
      <div class="col-md-4"><i class="bi bi-shield-check text-warning fs-3"></i><h5 class="fw-bold mt-2">Reliability</h5><p class="text-muted">Timely, professional execution.</p></div>
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="py-5 text-center" style="background:#4f708e; color:#fff;">
  <div class="container">
    <h2 class="fw-bold mb-3">Ready to Simplify Your IP Journey?</h2>
    <p class="mb-4">Get in touch today and explore how Emuna IP can streamline your global filings.</p>
    <a href="{{ url('/contact') }}" class="btn btn-light btn-lg fw-bold"><i class="bi bi-envelope me-2"></i> Contact Us</a>
  </div>
</section>

@endsection

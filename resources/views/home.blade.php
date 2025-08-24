@extends('layouts.app')
@section('title','Home')

@section('content')

{{-- HERO SLIDER --}}

<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">

    {{-- Slide 1 --}}
    <div class="carousel-item active" 
         style="background: url('{{ asset('images/hero1.jpg') }}') center center/cover no-repeat; height: 85vh; position: relative;">
      <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background:rgba(11,18,32,0.6);"></div>
      <div class="d-flex h-100 align-items-center justify-content-center text-center text-white position-relative">
        <div data-aos="fade-up">
          <h1 class="display-3 fw-bold">Patent Estimates Made Simple</h1>
          <p class="lead mb-4">Accurate cost projections for global filings in minutes.</p>
          <a href="{{ url('/quotes/create') }}" class="btn btn-brand btn-lg me-2">
            <i class="bi bi-calculator"></i> Get a Quotation
          </a>
          <a href="{{ url('/solutions') }}" class="btn btn-outline-brand btn-lg">
            Explore Solutions
          </a>
        </div>
      </div>
    </div>

    {{-- Slide 2 --}}
    <div class="carousel-item" 
         style="background: url('{{ asset('images/hero2.jpg') }}') center center/cover no-repeat; height: 85vh; position: relative;">
      <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background:rgba(79,112,142,0.55);"></div>
      <div class="d-flex h-100 align-items-center justify-content-center text-center text-white position-relative">
        <div data-aos="fade-down">
          <h1 class="display-3 fw-bold">Trusted Worldwide</h1>
          <p class="lead mb-4">Serving innovators and companies across multiple jurisdictions.</p>
          <a href="{{ url('/about') }}" class="btn btn-light btn-lg">
            Learn More
          </a>
        </div>
      </div>
    </div>

    {{-- Slide 3 --}}
    <div class="carousel-item" 
         style="background: url('{{ asset('images/hero3.jpg') }}') center center/cover no-repeat; height: 85vh; position: relative;">
      <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background:rgba(0,0,0,0.55);"></div>
      <div class="d-flex h-100 align-items-center justify-content-center text-center text-white position-relative">
        <div data-aos="fade-right">
          <h1 class="display-3 fw-bold">Innovation Meets Protection</h1>
          <p class="lead mb-4">Safeguard your ideas with transparent IP cost insights.</p>
          <a href="{{ url('/contact') }}" class="btn btn-brand btn-lg">
            Contact Us
          </a>
        </div>
      </div>
    </div>

  </div>

  {{-- Controls --}}
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>


{{-- QUICK ESTIMATE --}}
<section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-lg border-0" data-aos="zoom-in">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-3 text-center" style="color:var(--brand-primary)">Quick Estimate</h4>
            <form class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Application Type</label>
                <select class="form-select">
                  <option>Provisional</option>
                  <option>Non-Provisional</option>
                  <option>PCT</option>
                  <option>National Phase</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Jurisdiction</label>
                <select class="form-select">
                  <option>US</option>
                  <option>EU</option>
                  <option>CN</option>
                  <option>JP</option>
                  <option>UK</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Claims</label>
                <input type="number" class="form-control" placeholder="e.g., 20">
              </div>
              <div class="col-md-6">
                <label class="form-label">Pages</label>
                <input type="number" class="form-control" placeholder="e.g., 25">
              </div>
              <div class="col-12 d-grid">
                <a href="{{ url('/quick/quotes/create') }}" class="btn btn-brand">Continue to Full Form</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- HOW IT WORKS --}}
<section class="py-5">
  <div class="container text-center">
    <h2 class="section-title" data-aos="fade-up">How It Works</h2>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="p-4 border rounded-3 shadow-sm h-100">
          <i class="bi bi-file-earmark-text fs-1 mb-3" style="color:var(--brand-primary)"></i>
          <h5 class="fw-bold">1. Enter Details</h5>
          <p class="text-muted small">Provide your basic application details.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="p-4 border rounded-3 shadow-sm h-100">
          <i class="bi bi-calculator fs-1 mb-3" style="color:var(--brand-primary)"></i>
          <h5 class="fw-bold">2. Get Instant Estimate</h5>
          <p class="text-muted small">Our calculator generates transparent estimates instantly.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="p-4 border rounded-3 shadow-sm h-100">
          <i class="bi bi-check2-circle fs-1 mb-3" style="color:var(--brand-primary)"></i>
          <h5 class="fw-bold">3. File With Confidence</h5>
          <p class="text-muted small">Proceed with accurate insights and support.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- WHY CHOOSE US --}}
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="section-title" data-aos="fade-up">Why Choose Us?</h2>
    <div class="row g-4">
      <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
        <i class="bi bi-globe2 fs-1" style="color:var(--brand-primary)"></i>
        <h6 class="fw-bold mt-3">Global Coverage</h6>
        <p class="text-muted small">Estimates across US, EU, Asia, and more.</p>
      </div>
      <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
        <i class="bi bi-speedometer2 fs-1" style="color:var(--brand-primary)"></i>
        <h6 class="fw-bold mt-3">Fast & Reliable</h6>
        <p class="text-muted small">Instant calculations with live data.</p>
      </div>
      <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
        <i class="bi bi-shield-check fs-1" style="color:var(--brand-primary)"></i>
        <h6 class="fw-bold mt-3">Secure</h6>
        <p class="text-muted small">Your sensitive info is always safe.</p>
      </div>
      <div class="col-md-3" data-aos="zoom-in" data-aos-delay="400">
        <i class="bi bi-people-fill fs-1" style="color:var(--brand-primary)"></i>
        <h6 class="fw-bold mt-3">Expert Team</h6>
        <p class="text-muted small">Professionals ready to support you.</p>
      </div>
    </div>
  </div>
</section>

{{-- TESTIMONIALS --}}
<section class="py-5">
  <div class="container text-center">
    <h2 class="section-title" data-aos="fade-up">What Our Clients Say</h2>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-right">
        <div class="p-4 border rounded-3 shadow-sm h-100">
          <p class="small text-muted">“Quick, accurate, and reliable estimates for our international filings.”</p>
          <h6 class="fw-bold mt-3">— Startup Founder</h6>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up">
        <div class="p-4 border rounded-3 shadow-sm h-100">
          <p class="small text-muted">“The transparency saved us time and budgeting headaches.”</p>
          <h6 class="fw-bold mt-3">— IP Manager</h6>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-left">
        <div class="p-4 border rounded-3 shadow-sm h-100">
          <p class="small text-muted">“We could plan filings with confidence thanks to instant projections.”</p>
          <h6 class="fw-bold mt-3">— Legal Counsel</h6>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CTA SECTION --}}
<section class="py-5 text-white text-center" style="background:var(--brand-primary)">
  <div class="container" data-aos="zoom-in">
    <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
    <p class="lead mb-4">Receive your patent estimate today and file with confidence.</p>
    <a href="{{ url('/quick/quotes/create') }}" class="btn btn-light btn-lg shadow-sm">
      <i class="bi bi-arrow-right-circle"></i> Get Your Free Estimate
    </a>
  </div>
</section>

@endsection

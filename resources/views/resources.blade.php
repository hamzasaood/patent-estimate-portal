@extends('layouts.app')
@section('title','Resources')

@section('content')

{{-- HERO --}}
<section class="position-relative" style="height:70vh; background:url('{{ asset('/rhome.jpg') }}') center/cover no-repeat;">
  <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background:rgba(11,18,32,0.6);"></div>
  <div class="d-flex h-100 align-items-center justify-content-center text-center text-white position-relative">
    <div data-aos="fade-up">
      <h1 class="display-3 fw-bold mb-3">Resources</h1>
      <p class="lead">Guides, insights, and tools to navigate the world of intellectual property.</p>
    </div>
  </div>
</section>

{{-- GUIDES --}}
<section class="py-5">
  <div class="container">
    <h2 class="fw-bold mb-5 text-center" style="color:#4f708e;">Our Guides & Insights</h2>
    <div class="row g-4">
      @php
        $resources = [
          ['title'=>'Understanding the PCT System','desc'=>'A beginner-friendly guide to the Patent Cooperation Treaty and how it simplifies international filings.','img'=>'pct.jpg'],
          ['title'=>'IP Translation Best Practices','desc'=>'How to ensure accuracy, consistency, and cost efficiency in patent translations.','img'=>'ip.jpg'],
          ['title'=>'Patent Filing Checklist','desc'=>'Step-by-step preparation for a successful patent application across jurisdictions.','img'=>'patent.jpg'],
        ];
      @endphp
      @foreach($resources as $r)
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="{{ asset($r['img']) }}" class="card-img-top" alt="{{ $r['title'] }}">
          <div class="card-body">
            <h5 class="fw-bold mb-2" style="color:#4f708e;">{{ $r['title'] }}</h5>
            <p class="text-muted">{{ $r['desc'] }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- RESOURCE CATEGORIES --}}
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-5" style="color:#4f708e;">Explore by Category</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="p-4 shadow-sm bg-white rounded h-100">
          <i class="bi bi-book display-5 mb-3" style="color:#4f708e;"></i>
          <h5 class="fw-bold">Guides</h5>
          <p class="text-muted">Step-by-step guides for filing, translations, and validations.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 shadow-sm bg-white rounded h-100">
          <i class="bi bi-tools display-5 mb-3" style="color:#4f708e;"></i>
          <h5 class="fw-bold">Tools</h5>
          <p class="text-muted">Practical checklists, templates, and estimation tools.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 shadow-sm bg-white rounded h-100">
          <i class="bi bi-question-circle display-5 mb-3" style="color:#4f708e;"></i>
          <h5 class="fw-bold">FAQs</h5>
          <p class="text-muted">Answers to common questions about global IP processes.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CASE STUDIES --}}
<section class="py-5">
  <div class="container">
    <h2 class="fw-bold mb-5 text-center" style="color:#4f708e;">Case Studies & Insights</h2>
    <div class="row g-4">
      <div class="col-md-6">
        <div class="p-4 shadow-sm rounded bg-light h-100">
          <h5 class="fw-bold mb-2"><i class="bi bi-briefcase me-2 text-primary"></i>Global Tech Startup</h5>
          <p class="text-muted">How Emuna IP streamlined multi-country filings for a SaaS innovator in under 30 days.</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="p-4 shadow-sm rounded bg-light h-100">
          <h5 class="fw-bold mb-2"><i class="bi bi-lightning-charge me-2 text-warning"></i>Pharma Industry</h5>
          <p class="text-muted">Supporting a biotech firm with translations and validations in 15+ jurisdictions.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- LEARNING HUB --}}
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold mb-5 text-center" style="color:#4f708e;">Learning Hub</h2>
    <div class="row g-4">
      <div class="col-md-6">
        <div class="ratio ratio-16x9 shadow-sm rounded">
          <iframe src="https://www.youtube.com/embed/TXxQFMGQ4GU" title="Patent Filing Webinar" allowfullscreen></iframe>
        </div>
        <p class="fw-bold mt-3 text-center">Webinar: Navigating the PCT Process</p>
      </div>
      <div class="col-md-6">
        <div class="ratio ratio-16x9 shadow-sm rounded">
          <iframe src="https://www.youtube.com/embed/MQH8tfQG0RQ" title="IP Translation Tips" allowfullscreen></iframe>
        </div>
        <p class="fw-bold mt-3 text-center">Video Guide: Translation Best Practices</p>
      </div>
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="py-5 text-center" style="background:#4f708e; color:#fff;">
  <div class="container" data-aos="fade-up">
    <h2 class="fw-bold mb-3">Stay Informed</h2>
    <p class="mb-4">Subscribe to our newsletter and receive the latest IP updates straight to your inbox.</p>
    <form class="d-flex justify-content-center">
      <input type="email" class="form-control w-50 me-2" placeholder="Enter your email">
      <button class="btn btn-light fw-bold"><i class="bi bi-envelope me-2"></i>Subscribe</button>
    </form>
  </div>
</section>

@endsection

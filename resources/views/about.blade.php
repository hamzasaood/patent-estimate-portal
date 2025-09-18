@extends('layouts.app')
@section('title','About Us')

@section('content')

{{-- HERO --}}
<section class="position-relative" style="height:70vh; background:url('{{ asset('/about.jpg') }}') center/cover no-repeat;">
  <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background:rgba(11,18,32,0.6);"></div>
  <div class="d-flex h-100 align-items-center justify-content-center text-center text-white position-relative">
    <div data-aos="fade-up">
      <h1 class="display-3 fw-bold mb-3">About Us</h1>
      <p class="lead">Trusted global partner for patent filing, translation & IP services.</p>
    </div>
  </div>
</section>

{{-- OUR STORY --}}
<section class="py-5">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <img src="{{ asset('/story.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Our Story">
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <h2 class="fw-bold mb-4" style="color:#4f708e;">Who We Are</h2>
        <p class="text-muted fs-5">
          Emuna IP was founded to simplify global IP filings with a focus on transparency, reliability, and client trust.
          We provide innovators and law firms with cost-effective solutions to protect their intellectual property worldwide.
        </p>
      </div>
    </div>
  </div>
</section>

{{-- ABOUT OUR NAME --}}
<section class="py-5 bg-light">
  <div class="container text-center" data-aos="zoom-in">
    <h2 class="fw-bold mb-3" style="color:#4f708e;">About Our Name</h2>
    <p class="text-muted fs-5">
      “Emuna” (אמונה) means faith or belief. This reflects our core values: integrity, reliability, and building lasting
      partnerships with our clients.
    </p>
  </div>
</section>

{{-- TEAM --}}
<section class="py-5">
  <div class="container">
    <h2 class="fw-bold text-center mb-5" style="color:#4f708e;">Meet Our Team</h2>
    <div class="row g-4">
      @php
        $team = [
          ['name'=>'Steven Rosen','role'=>'Co-Founder / CEO','img'=>'team1.png'],
          ['name'=>'Akiva Sausen','role'=>'COO','img'=>'team2.png'],
          ['name'=>'Reuben Berman','role'=>'Managing Director','img'=>'team3.png'],
          ['name'=>'Yehuda Fried','role'=>'VP – New Business Development','img'=>'team4.png'],
          ['name'=>'Moshe Shein','role'=>'Attorney Liaison – Business Development','img'=>'team5.png'],
        ];
      @endphp
      @foreach($team as $m)
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body d-flex flex-column align-items-center">
            <img src="{{ asset($m['img']) }}" class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;" alt="{{ $m['name'] }}">
            <h5 class="fw-bold mb-1">{{ $m['name'] }}</h5>
            <p class="text-muted">{{ $m['role'] }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- GLOBAL PRESENCE --}}
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-4" style="color:#4f708e;">Our Global Presence</h2>
    <p class="text-muted mb-5 fs-5">With offices in New York and Israel, and a network of partners worldwide, we serve clients across jurisdictions.</p>
    <img src="{{ asset('/worldmap.jpg') }}" class="img-fluid rounded shadow-sm" alt="Global Map">
  </div>
</section>



@endsection

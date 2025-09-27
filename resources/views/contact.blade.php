@extends('layouts.app')
@section('title','Contact Us')

@section('content')

{{-- HERO --}}
<section class="position-relative" style="height:70vh; background:url('{{ asset('/contact.webp') }}') center/cover no-repeat;">
  <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background:rgba(11,18,32,0.6);"></div>
  <div class="d-flex h-100 align-items-center justify-content-center text-center text-white position-relative">
    <div data-aos="fade-up">
      <h1 class="display-3 fw-bold mb-3" style="color:#fff">Contact Us</h1>
      <p class="lead">We’re here to answer your questions and provide expert support.</p>
    </div>
  </div>
</section>

{{-- CONTACT FORM --}}
<section class="py-5">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <h2 class="fw-bold mb-4" style="color:#4f708e;">Get In Touch</h2>
        <form method="POST" action="{{ route('contact.send') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" rows="5" class="form-control" required></textarea>
          </div>
          <button class="btn btn-primary px-4">Send Message</button>
        </form>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <h2 class="fw-bold mb-4" style="color:#4f708e;">Our Offices</h2>
        <ul class="list-unstyled fs-5 text-muted">
          <li><strong>📍 New York:</strong> 1000 East End Woodmere, NY 11598</li>
          <li><strong>📍 Israel:</strong> Eliezer Hoofien 7, Jerusalem 9727627, Israel</li>
          <li><strong>📧 Email:</strong> info@emunaip.com</li>
          <li><strong>☎ Phone:</strong> +1 (212) 555-7890</li>
        </ul>
        <div class="mt-4">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3027.3206457005135!2d-73.7165359245051!3d40.644861741723936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2644e35607e9f%3A0xc6608186259ae068!2s1000%20East%20End%2C%20Woodmere%2C%20NY%2011598%2C%20USA!5e0!3m2!1sen!2s!4v1758675002938!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>      </div>
    </div>
  </div>
</section>

@endsection

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title','Patent Estimate Portal')</title>

  {{-- Bootstrap 5 + Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  {{-- Custom branding CSS --}}
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


  <style>
    /* HEADER STYLING */
    .navbar-custom {
      padding: 1rem 0; /* taller navbar */
      background: linear-gradient(90deg, var(--brand-dark), #1d2742);
    }
    .navbar-custom .nav-link {
      font-weight: 500;
      padding: 0.75rem 1rem;
      transition: 0.2s;
    }
    .navbar-custom .nav-link:hover {
      color: var(--brand-primary) !important;
    }

    /* FULLSCREEN MOBILE MENU */
    @media (max-width: 991px) {
      #topnav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: #0b1220;
        padding-top: 5rem;
        text-align: center;
      }
      #topnav .nav-link {
        font-size: 1.25rem;
        padding: 1rem;
      }
    }

    /* FOOTER STYLING */
    .footer {
      background: var(--brand-dark);
      color: #fff;
      padding: 4rem 0;
    }
    .footer h6 {
      font-weight: 600;
      margin-bottom: 1rem;
      color: var(--brand-primary);
    }
    .footer a {
      color: #d1d5db;
      text-decoration: none;
    }
    .footer a:hover {
      color: #fff;
    }
    .footer .social a {
      font-size: 1.25rem;
      margin-right: 0.75rem;
      color: #d1d5db;
    }
    .footer .social a:hover {
      color: var(--brand-primary);
    }
  </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  {{-- NAVBAR --}}
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm navbar-custom">
    <div class="container">
      {{-- Brand --}}
      <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
        <img src="{{ asset('logo.png') }}" alt="Emuna IP" height="42">
      </a>

      {{-- Toggler --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Nav Links --}}
      <div class="collapse navbar-collapse" id="topnav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/solutions') }}">Solutions</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/resources') }}">Resources</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>

          {{-- Quotation CTA --}}
          <li class="nav-item ms-lg-3">
            <a class="btn btn-sm btn-brand shadow-sm px-3" href="{{ url('/quick/quotes/create') }}">
              <i class="bi bi-calculator"></i> Get a Quotation
            </a>
          </li>

          {{-- User Dropdown --}}
          <li class="nav-item dropdown ms-lg-3">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle fs-5"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              @guest
                <li><a class="dropdown-item" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i> Login</a></li>
                <li><a class="dropdown-item" href="{{ route('register') }}"><i class="bi bi-person-plus me-2"></i> Register</a></li>
              @else
              @if(Auth::user()->role == 'admin')
                <li><a class="dropdown-item" href="{{ url('admin/dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
              @else
                <li><a class="dropdown-item" href="{{ url('/dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
              @endif

                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                      <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                  </form>
                </li>
              @endguest
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- MAIN --}}
  <main class="flex-grow-1 py-4">
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="footer mt-auto">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <img src="{{ asset('logo.png') }}" alt="Emuna IP" height="40" class="mb-3">
          <p class="small">Providing transparent and reliable patent cost estimates worldwide.</p>
          <div class="social mt-3">
            <a href="#"><i class="bi bi-linkedin"></i></a>
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
          </div>
        </div>
        <div class="col-md-2">
          <h6>Quick Links</h6>
          <ul class="list-unstyled small">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/about') }}">About Us</a></li>
            <li><a href="{{ url('/solutions') }}">Solutions</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6>Resources</h6>
          <ul class="list-unstyled small">
            <li><a href="{{ url('/resources') }}">Blog</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Case Studies</a></li>
            <li><a href="#">Guides</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6>Contact</h6>
          <ul class="list-unstyled small">
            <li><i class="bi bi-envelope me-2"></i> info@emunaip.com</li>
            <li><i class="bi bi-telephone me-2"></i> +1-516-200-6130</li>
            <li><i class="bi bi-geo-alt me-2"></i> New York, USA</li>
          </ul>
        </div>
      </div>
      <hr class="border-secondary my-4">
      <div class="text-center small">
        © {{ date('Y') }} Emuna IP. All Rights Reserved.
      </div>
    </div>
  </footer>

  {{-- SCRIPTS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 800, once: true });
  </script>

</body>
</html>

<nav class="sidebar">
  <div class="logo d-flex justify-content-between align-items-center">
    <a class="large_logo" href="{{ url('/admin/dashboard') }}">
      <img src="{{ asset('logo.png') }}" alt="Logo">
    </a>
    <a class="small_logo" href="{{ url('/admin/dashboard') }}">
      <img src="{{ asset('logo.png') }}" alt="Logo Mini" style="width: 95%;">
    </a>
    <div class="sidebar_close_icon d-lg-none">
      <i class="fa-solid fa-xmark"></i>
    </div>
  </div>

  <ul id="sidebar_menu">
    
    {{-- Dashboard --}}
    <li>
      <a href="{{ url('/admin/dashboard') }}">
        <div class="nav_icon_small"><i class="fa-solid fa-gauge"></i></div>
        <div class="nav_title"><span>Dashboard</span></div>
      </a>
    </li>

    {{-- Quotes --}}
    <li>
      <a href="{{ url('/admin/quotes') }}">
        <div class="nav_icon_small"><i class="fa-solid fa-calculator"></i></div>
        <div class="nav_title"><span>Quotes</span></div>
      </a>
    </li>

    {{-- Pricing Logic --}}
    <li>
      <a href="{{ url('/admin/pricing-logics') }}">
        <div class="nav_icon_small"><i class="fa-solid fa-gears"></i></div>
        <div class="nav_title"><span>Pricing Logic</span></div>
      </a>
    </li>
    {{-- Pricing Levels --}}
    <li>
      <a href="{{ url('/admin/pricing-levels') }}">
        <div class="nav_icon_small"><i class="fa-solid fa-gears"></i></div>
        <div class="nav_title"><span>Pricing levels</span></div>
      </a>
    </li>

    {{-- Users --}}
    <li>
      <a class="has-arrow" href="#" aria-expanded="false">
        <div class="nav_icon_small"><i class="fa-solid fa-users"></i></div>
        <div class="nav_title"><span>Users</span></div>
      </a>
      <ul>
        <li><a href="{{ url('/admin/users') }}">User List</a></li>
        <li><a href="{{ url('/admin/users/create') }}">Add New User</a></li>
      </ul>
    </li>

    

    {{-- Settings --}}
    <li>
      <a href="{{ url('/admin/settings') }}">
        <div class="nav_icon_small"><i class="fa-solid fa-sliders"></i></div>
        <div class="nav_title"><span>Settings</span></div>
      </a>
    </li>

  </ul>
</nav>

<div class="container-fluid g-0">
  <style>
    .single_notify:hover{
      background-color: #f2f2f2;
    }

  </style>
<div class="row">
<div class="col-lg-12 p-0 ">
  <div class="header_iner d-flex justify-content-between align-items-center">
<div class="sidebar_icon d-lg-none">
<i class="ti-menu"></i>
</div>
<div class="line_icon open_miniSide d-none d-lg-block">
<img src="{!! asset('assets/img/line_img.png') !!}" alt="">
</div>
<div class="serach_field-area d-flex align-items-center">
<div class="search_inner">

</div>
</div>
<div class="header_right d-flex justify-content-between align-items-center">
<div class="header_notification_warp d-flex align-items-center">

<li>
        <a class="bell_notification_clicker ordernotification" id="orderBell" href="#"> 
            <img src="{{ asset('bell-solid.svg') }}" alt="">
            <span id="order-count">0</span> <!-- Live count of new orders -->
        </a>

        <div class="Menu_NOtification_Wrap order-menu">
            <div class="notification_Header" style="background:#000201;">
                <h4>Notifications</h4>
            </div>
            <div class="Notification_body ordernotificationbody">
                
                  
            </div>

            <div class="nofity_footer">
                <div class="submit_button text-center pt_20">
                    <a href="{{url('/admin/quotes')}}" class="btn_1">See All Quotes</a>
                </div>
            </div>
        </div>
    </li>


<div class="profile_info">
<img src="{!! asset('assets/img/client_img.png') !!}" alt="#">
<div class="profile_info_iner">
<div class="profile_author_name">
<p>{{Auth::user()->email}}</p>
<h5>{{Auth::user()->name}}</h5>
</div>
<div class="profile_info_details" style="    background-color: bisque;">




<a  href="{{ route('logout') }}"
       onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
  {{ __('Logout') }}
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
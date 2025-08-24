<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from demo.dashboardpack.com/user-management-html/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 05 Sep 2023 11:56:18 GMT -->
<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>Order Management system</title>
<link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


<link rel="stylesheet" href="{!! asset('assets/css/bootstrap1.min.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/themefy_icon/themify-icons.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/niceselect/css/nice-select.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/owl_carousel/css/owl.carousel.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/gijgo/gijgo.min.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/font_awesome/css/all.min.css') !!}" />
<link rel="stylesheet" href="{!! asset('assets/vendors/tagsinput/tagsinput.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/datepicker/date-picker.css') !!}" />
<link rel="stylesheet" href="{!! asset('assets/vendors/vectormap-home/vectormap-2.0.2.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/scroll/scrollable.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/datatable/css/responsive.dataTables.min.css') !!}" />
<link rel="stylesheet" href="{!! asset('assets/vendors/datatable/css/buttons.dataTables.min.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/text_editor/summernote-bs4.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/vendors/morris/morris.css') !!}">

<link rel="stylesheet" href="{!! asset('assets/vendors/material_icon/material-icons.css') !!}" />

<link rel="stylesheet" href="{!! asset('assets/css/metisMenu.css') !!}">

<link rel="stylesheet" href="{!! asset('assets/css/style1.css') !!}" />
<link rel="stylesheet" href="{!! asset('assets/css/colors/default.css') !!}" id="colorSkinCSS">


</head>

<body class="crm_body_bg">


@include('admin.layout.sidebar')


<section class="main_content dashboard_part large_header_bg">



@include('admin.layout.header')




<div  class="main_content_iner overly_inner">


@yield('content')



</div>
</section>

</body>
@include('admin.layout.footer')







</html>
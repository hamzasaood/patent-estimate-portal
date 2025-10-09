<div class="footer_part">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="footer_iner text-center">
<p>2025 ©  - Developed by <a href="#"> Emuna IP</a></p>
</div>
</div>
</div>
</div>
</div>





{{-- 
<script src="{!! asset('assets/js/jquery1-3.4.1.min.js') !!}"></script>
--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>


<script src="{!! asset('assets/js/popper1.min.js') !!}"></script>

<script src="{!! asset('assets/js/bootstrap1.min.js') !!}"></script>

<script src="{!! asset('assets/js/metisMenu.js') !!}"></script>

<script src="{!! asset('assets/vendors/count_up/jquery.waypoints.min.js') !!}"></script>

<script src="{!! asset('assets/vendors/chartlist/Chart.min.js') !!}"></script>

<script src="{!! asset('assets/vendors/count_up/jquery.counterup.min.js') !!}"></script>

<script src="{!! asset('assets/vendors/niceselect/js/jquery.nice-select.min.js') !!}"></script>
{{-- 
<script src="{!! asset('assets/vendors/owl_carousel/js/owl.carousel.min.js') !!}"></script>
--}}
<script src="{!! asset('assets/vendors/datatable/js/jquery.dataTables.min.js') !!}"></script>



<script src="{!! asset('assets/vendors/datepicker/datepicker.js') !!}"></script>
<script src="{!! asset('assets/vendors/datepicker/datepicker.en.js') !!}"></script>
<script src="{!! asset('assets/vendors/datepicker/datepicker.custom.js') !!}"></script>
<script src="{!! asset('assets/js/chart.min.js') !!}"></script>
<script src="{!! asset('assets/vendors/chartjs/roundedBar.min.js') !!}"></script>

<script src="{!! asset('assets/vendors/progressbar/jquery.barfiller.js') !!}"></script>

<script src="{!! asset('assets/vendors/tagsinput/tagsinput.js') !!}"></script>

<script src="{!! asset('assets/vendors/text_editor/summernote-bs4.js') !!}"></script>
<script src="{!! asset('assets/vendors/am_chart/amcharts.js') !!}"></script>

<script src="{!! asset('assets/vendors/scroll/perfect-scrollbar.min.js') !!}"></script>
<script src="{!! asset('assets/vendors/scroll/scrollable-custom.js') !!}"></script>

<script src="{!! asset('assets/vendors/vectormap-home/vectormap-2.0.2.min.js') !!}"></script>
<script src="{!! asset('assets/vendors/vectormap-home/vectormap-world-mill-en.js') !!}"></script>
{{--

 

--}}
<script src="{!! asset('assets/js/dashboard_init.js') !!}"></script>
<script src="{!! asset('assets/js/custom.js') !!}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
<script>
  $('#pricing').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[3, 'desc']],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "🔍 Search quotes..."
        }
    });


    $('#quotes').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[3, 'desc']],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "🔍 Search quotes..."
        }
    });

</script>

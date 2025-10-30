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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

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




    function fetchLiveOrders() {
    $.ajax({
        url: '/admin/new-quotes/', // Full route path
        type: 'GET',
        success: function(data) {
            var notificationBody = $('.ordernotificationbody');
            var orderCount = $('#order-count');
            
            // Clear current notifications
            notificationBody.empty();

            if (data.length === 0) {
                notificationBody.append(`
                    <div class="text-center py-2 text-muted">
                        No new quotes available.
                    </div>
                `);
                orderCount.text(0);
                return;
            }

            // Loop through each quote and show notification
            data.forEach(function(quote) {
                notificationBody.append(`
                    <div class="single_notify d-flex align-items-center" id="quote-${quote.id}">
                        <div class="notify_thumb">
                            <i class="fa-solid fa-calculator" style="font-size: 40px;"></i>
                        </div>
                        <a href="/admin/quotes/${quote.invoice_group}">
                        <div class="notify_content">
                            
                        <h5>New Quote #${quote.invoice_group} - ${quote.service ? quote.service : 'Service'}</h5>
                            
                            <p>Region: ${quote.regions ? quote.regions : 'N/A'}</p>
                            <p>Received ${moment(quote.created_at).fromNow()}</p>
                        </div>
                        </a>
                    </div>
                    <hr>
                `);
            });

            // Update the count
            orderCount.text(data.length);
        },
        error: function(xhr) {
            console.error('Error fetching quotes:', xhr.responseText);
        }
    });
}

    // Call the function to fetch new orders every 5 seconds
    setInterval(fetchLiveOrders, 5000); // Fetch data every 5 seconds

    // Toggle sound on click of the bell icon
    

</script>

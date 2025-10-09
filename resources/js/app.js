require('./bootstrap');
import 'bootstrap/dist/js/bootstrap.bundle';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

// Initialize
$(function () {
    $('#quotesTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[3, 'desc']],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "🔍 Search quotes..."
        }
    });
    
});
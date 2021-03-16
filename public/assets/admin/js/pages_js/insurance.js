var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    $('#insurance_company_datatable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });



});

var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    $('#hospital_datatable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });

    // $("input[data-bootstrap-switch]").each(function() {
    //     $(this).bootstrapSwitch('state', $(this).prop('checked'));
    // });

});

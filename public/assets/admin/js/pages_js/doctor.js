var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    $('#doctor_datatable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });


    //update user status
    // $('.patient_status_checkbox').click(function() {
    //     var status = 'Active';
    //     if ($(this).prop("checked") == true) {
    //         status = 'Active';
    //         console.log("Checkbox is checked.");
    //     } else if ($(this).prop("checked") == false) {
    //         status = 'Inactive';
    //         console.log("Checkbox is unchecked.");
    //     }
    //     var url = $(this).data('update_url');
    //     var userId = $(this).data('UserID');
    //     updateUserStatus(url,userId,status);
    // });

});

var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    $('#patient_datatable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });

    $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
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
    // $(".user_status_checkbox").bootstrapSwitch({
    //     onSwitchChange: function (e, state) {
    //         //alert(state);
    //         var status = state == true ? 'Active' : 'Inactive';
    //         var url = $(this).data('update_url');
    //         var userId = $(this).data('UserID'); 
    //         updateUserStatus(url, userId, status);
    //     }
    // });

});

// function updateUserStatus(url, userID, status) {
//     var data = {
//         Status: status,
//         _token: csrfToken,
//         // _method:'PATCH'
//     };
//     $.ajax({
//         url: url,
//         //  type: 'post',
//         method: 'post',
//         data: data,
//         dataType: 'JSON',
//         //  contentType: false,
//         // cache: false,
//         // processData: false,
//         success: function (data) {
//             console.log('success');
//             console.log(data);
//             toastr.success('Updated');
//             // location.href = '/seller/products';
//         },
//         error: function (data) {
//             console.log('error: ');
//             console.log(data);
//             toastr.error('Failed')
//             // let obj = data.responseJSON;
//             // console.log(obj);
//             // if (typeof obj.errors != 'undefined') {
//             //     $("div#validation_errors").append('<h5>Errors found in form, fix and resubmit!</h5>');
//             //     for (let key in obj.errors) {
//             //         for (let index in obj.errors[key]) {
//             //             // $("#" + key).parent().append('<span>' + obj.errors[key][index] + '</span><br>');
//             //             $("div#validation_errors").append('<span>' + obj.errors[key][index] + '</span><br>');
//             //         }

//             //     }
//             //     $('html, body').animate({
//             //         scrollTop: $("div#validation_errors").offset().top - 70,
//             //     }, 1000);

//             // } else {
//             //     //backend error
//             //     location.reload();
//             // }
//         }
//     });
// }
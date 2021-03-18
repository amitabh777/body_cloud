var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    $('#lab_test_datatable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });

    //status update
    $('input.lab_test_status_checkbox').click(function () {
        var url = $(this).data('status_update_url');
        var status = 'Active';
        var labTestId = $(this).data('lab_test_id');
        if ($(this).prop("checked") == true) {
            status = 'Active';
            console.log("Checkbox is checked.");
        } else if ($(this).prop("checked") == false) {
            status = 'Inactive';
            console.log("Checkbox is unchecked.");
        }
        updateLabTestStatus(url, status);
    });

    //delete
    $('.lab_test-delete').on('click', function () {
        var con = confirm('Are you confirm?');
        if (!con) {
            return;
        }
        var url = $(this).data('url');
        //delete lab test
        deleteLabTest(url, false);
    });
});

//update labtest status
function updateLabTestStatus(url, status) {
    var data = {
        Status: status,
        _token: csrfToken,
        _method: 'PATCH'
    };
    $.ajax({
        url: url,
        data: JSON.stringify(data),
        type: 'post',
        contentType: 'application/json',
        processData: false,
        dataType: 'json',
        success: function (data) {
            console.log('success');
            console.log(data);
            toastr.success('Status updated.'); //open toaster message
        },
        error: function (data) {
            console.log('error: ');
            console.log(data);
            toastr.error('Status failed');
        }
    });

}

//delete insurance category
function deleteLabTest(url, confirmExistDelete) {
    $.ajax({
        url: url,
        // type: 'DELETE',
        method: 'post',
        data: {
            _token: csrfToken,
            _method: 'DELETE',
            confirm: confirmExistDelete
        },
        dataType: "JSON",
        success: function success(result) {
            console.log('success');
            if (result.status == 'already_used') {
                var con = confirm('Blood group already used by existing user, Are you confirm?');
                if (!con) {
                    toastr.warning('Already used');
                    return;
                } else {
                    console.log('resending');
                    deleteLabTest(url, true); //resend delete request with confirm true                 
                }
            } else {
                toastr.success('Deleted');
                location.reload();           
            }           

        },
        error: function error(msg) {
            console.log('something went wrong');
            toastr.error('unable to delete');
            // location.reload();
        }
    });
}


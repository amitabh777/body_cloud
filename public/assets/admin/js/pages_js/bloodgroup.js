var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    $(document).ready(function () {

        $('#bloodgroups_datatable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        //status update
        $('input.bloodgroup_status_checkbox').click(function () {
            var url = $(this).data('status_update_url');
            var status = 'Active';
            var bloodgroupId = $(this).data('bloodgroup_id');
            console.log(url);
            if ($(this).prop("checked") == true) {
                status = 'Active';
                console.log("Checkbox is checked.");
            } else if ($(this).prop("checked") == false) {
                status = 'Inactive';
                console.log("Checkbox is unchecked.");
            }
            updateBloodgroupStatus(url, status, bloodgroupId);
        });

    });

    //update bloodgroup status
    function updateBloodgroupStatus(url, status, bloodgroupId) {
        var data = {
            Status: status,
            _token: csrfToken,
            // _method:'PATCH'
        };
        $.ajax({
            url: url,
            data: JSON.stringify(data),
            type: 'PATCH',
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
        // $.ajax({
        //     url: url,
        //     //  type: 'post',
        //     method: 'post',
        //     data: data,
        //     dataType: 'JSON',
        //     //  contentType: false,
        //     // cache: false,
        //     // processData: false,
        //     success: function (data) {
        //         console.log('success');
        //         console.log(data);
        //         toastr.success('Updated');
        //         // location.href = '/seller/products';
        //     },
        //     error: function (data) {
        //         console.log('error: ');
        //         console.log(data);
        //         toastr.error('Failed');               
        //     }
        // });
    }

});
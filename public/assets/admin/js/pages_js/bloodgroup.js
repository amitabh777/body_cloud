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

        //delete
        $('.bloodgroup-delete').on('click', function () {
            var con = confirm('Are you confirm?');
            if (!con) {
                return;
            }
            var url = $(this).data('url');
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': csrfToken
            //     }
            // });
            deleteBloodGroup(url,false);            
        });

    });

    function toastMsgBeforeRedirect(msg) {
        return new Promise(function (resolve, reject) {
            // "Producing Code" (May take some time)
            toastr.success(msg);
            resolve('success'); // when successful
            setTimeout(() => {
                console.log('tes')
            }, 1000);
            //reject();  // when error
        });
    }


    //update bloodgroup status
    function updateBloodgroupStatus(url, status, bloodgroupId) {
        var data = {
            Status: status,
            _token: csrfToken,
             _method:'PATCH'
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

    //delete bloodgroup
    function deleteBloodGroup(url,confirmExistDelete){
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
                    }else{    
                        console.log('resending');
                        deleteBloodGroup(url,true); //resend delete request with confirm true                 
                    }
                } else {
                    toastMsgBeforeRedirect('Deleted').then(function (res) {
                         location.reload();
                    });
                }
                // toastr.success('deleted');             

            },
            error: function error(msg) {
                console.log('something went wrong');
                toastr.error('unable to delete');
                // location.reload();
            }
        });
    }

});
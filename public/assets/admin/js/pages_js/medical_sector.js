var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    $(document).ready(function () {

        $('#medical_sectors_datatable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
        //status update
        $('.medical_sector_status_checkbox').click(function () {
           console.log('test');
            var url = $(this).data('status_update_url');
            var status = 'Active';
            var medical_sector_id = $(this).data('medical_sector_id');
            console.log(url);
            if ($(this).prop("checked") == true) {
                status = 'Active';
            } else if ($(this).prop("checked") == false) {
                status = 'Inactive';
            }
            updateMedicalSectorStatus(url, status);
        });

        //delete
        $('.medical_sector-delete').on('click', function () {
            var con = confirm('Are you confirm?');
            if (!con) {
                return;
            }
            var url = $(this).data('url');            
            deleteMedicalSector(url,false);       
        });

    });

    function deleteMedicalSector(url,confirmExistDelete) {
        $.ajax({
            url: url,
            type: 'post',
            data: {
                _token: csrfToken,
                _method: 'DELETE',
                confirm:confirmExistDelete
            },
            success: function success(result) {
                console.log(result);
                if (result.status == 'already_used') {                   
                    var con = confirm('Medical Sector already used. Deleting this data may delete sectors of some user. Are you confirm?');
                    if (!con) {
                        toastr.warning('Already used');
                        return;
                    }else{    
                        console.log('resending');
                        deleteMedicalSector(url,true); //resend delete request with confirm true                 
                    }
                } else {
                    toastMsgBeforeRedirect('Deleted').then(function (res) {
                         location.reload();
                    });
                }

            },
            error: function error(msg) {
                var res = msg.responseJSON;
                if(res.status && res.status=='failed'){
                    toastr.error(res.message);
                }else{
                    console.log('something went wrong');
                toastr.error('unable to delete'); 
                }
               
            }
        });

    }

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


    //update documenttype status
    function updateMedicalSectorStatus(url, status) {
        var data = {
            Status: status,
            _token: csrfToken,
            _method: 'PATCH'
        };
        $.ajax({
            url: url,
            data: JSON.stringify(data),
            type: 'POST',
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
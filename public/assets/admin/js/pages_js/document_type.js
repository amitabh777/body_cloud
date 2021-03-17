var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    $(document).ready(function () {

        $('#document_types_datatable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        //status update
        $('input.docuemnt_type_status_checkbox').click(function () {
            var url = $(this).data('status_update_url');
            var status = 'Active';
            var documentTypeId = $(this).data('document_type_id');
            console.log(url);
            if ($(this).prop("checked") == true) {
                status = 'Active';
            } else if ($(this).prop("checked") == false) {
                status = 'Inactive';
            }
            updateDocumentTypeStatus(url, status);
        });

        //delete
        $('.document_type-delete').on('click', function () {
            var con = confirm('Are you confirm?');
            if (!con) {
                return;
            }
            var url = $(this).data('url');            
            deleteDocumentType(url,false);       
        });

    });

    function deleteDocumentType(url,confirmExistDelete) {
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
                    var con = confirm('Document type already used, deleting this data will delete documents of user using this document type. Are you confirm?');
                    if (!con) {
                        toastr.warning('Already used');
                        return;
                    }else{    
                        console.log('resending');
                        deleteDocumentType(url,true); //resend delete request with confirm true                 
                    }
                } else {
                    toastMsgBeforeRedirect('Deleted').then(function (res) {
                         location.reload();
                    });
                }

            },
            error: function error(msg) {
                console.log('something went wrong');
                toastr.error('unable to delete');
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
    function updateDocumentTypeStatus(url, status) {
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
$(document).ready(function () {    
    $('#roles_datatable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
       // "info": true,
        "autoWidth": true,
        "responsive": true,
        "initComplete": function(){
            // alert('Data loaded successfully');
            // onClicPutDelete();
          }
    });

    $('.card-body').on('click','.role-delete', function () {
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
        deleteRole(url, false);
    });

});

function onClickPutDelete(){
  $('.role-delete').on('click', function () {
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
        deleteRole(url, false);
    });
}

//delete bloodgroup
function deleteRole(url, confirmExistDelete) {
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
                var con = confirm('Role already used by existing user, Are you confirm?');
                if (!con) {
                    toastr.warning('Already used');
                    return;
                } else {
                    console.log('resending');
                    deleteRole(url, true); //resend delete request with confirm true                 
                }
            } else {
                toastr.success('deleted');
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

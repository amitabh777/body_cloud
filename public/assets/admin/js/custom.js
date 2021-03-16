var csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {

    //update user status
    $(".user_status_checkbox").bootstrapSwitch({
        onSwitchChange: function (e, state) {
            //alert(state);
            var status = state == true ? 'Active' : 'Inactive';
            var url = $(this).data('update_url');
            var userId = $(this).data('UserID'); 
            updateUserStatus(url, userId, status);
        }
    });

});

function updateUserStatus(url, userID, status) {
    var data = {
        Status: status,
        _token: csrfToken,
        // _method:'PATCH'
    };
    $.ajax({
        url: url,
        //  type: 'post',
        method: 'post',
        data: data,
        dataType: 'JSON',
        //  contentType: false,
        // cache: false,
        // processData: false,
        success: function (data) {
            console.log('success');
            console.log(data);
            toastr.success('Updated');
            // location.href = '/seller/products';
        },
        error: function (data) {
            console.log('error: ');
            console.log(data);
            toastr.error('Failed');           
        }
    });
}



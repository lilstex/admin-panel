$(document).ready(function() {
    // Update CMS Page status
    $(document).on('click','.updateCmsStatus', function () {
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            type: 'post',
            url: 'cms_page/update_cms_status',
            data: { status: status, page_id: page_id },
            success: function (response) {
                if(response['status'] == 'Inactive') {
                    $("#page-"+page_id).html("<i class='fas fa-toggle-on' style='color: #3f6ed3;' status='Active'></i>");
                } else if(response['status'] == 'Active') {
                    $("#page-"+page_id).html("<i class='fas fa-toggle-off' style='color: grey;' status='Inactive'></i>");
                }
                
            },
            error: function () {

            }
        })
    });

    // Update Admin status
    $(document).on('click','.updateAdminStatus', function () {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            type: 'post',
            url: 'subadmin/update_admin_status',
            data: { status: status, admin_id: admin_id },
            success: function (response) {
                if(response['status'] == 'Inactive') {
                    $("#admin-"+admin_id).html("<i class='fas fa-toggle-on' style='color: #3f6ed3;' status='Active'></i>");
                } else if(response['status'] == 'Active') {
                    $("#admin-"+admin_id).html("<i class='fas fa-toggle-off' style='color: grey;' status='Inactive'></i>");
                }
                
            },
            error: function () {

            }
        })
    });

    // Confirm Delete Alert
    $(document).on('click', '.confirmDelete', function (event) {
        event.preventDefault(); // Prevent default form submission
    
        var form = $(this).closest("form");
    
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Manually submit the form if deletion is confirmed
            }
        });
    });
    
});
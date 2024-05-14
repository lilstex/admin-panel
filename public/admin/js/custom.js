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

    // Update Category status
     $(document).on('click','.updateCategoryStatus', function () {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            type: 'post',
            url: 'categories/update_category_status',
            data: { status: status, category_id: category_id },
            success: function (response) {
                if(response['status'] == 'Inactive') {
                    $("#category-"+category_id).html("<i class='fas fa-toggle-on' style='color: #3f6ed3;' status='Active'></i>");
                } else if(response['status'] == 'Active') {
                    $("#category-"+category_id).html("<i class='fas fa-toggle-off' style='color: grey;' status='Inactive'></i>");
                }
                
            },
            error: function () {

            }
        })
    });

      // Update Product status
      $(document).on('click','.updateProductStatus', function () {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            type: 'post',
            url: 'categories/update_product_status',
            data: { status: status, product_id: product_id },
            success: function (response) {
                if(response['status'] == 'Inactive') {
                    $("#product-"+product_id).html("<i class='fas fa-toggle-on' style='color: #3f6ed3;' status='Active'></i>");
                } else if(response['status'] == 'Active') {
                    $("#product-"+product_id).html("<i class='fas fa-toggle-off' style='color: grey;' status='Inactive'></i>");
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

    // Add/Remove Product Attribute fields
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="size[]" placeholder="size" style="width:120px;"/>&nbsp;<input type="text" name="sku[]" placeholder="sku" style="width:120px;"/>&nbsp;<input type="text" name="price[]" placeholder="price" style="width:120px;"/>&nbsp;<input type="text" name="stock[]" placeholder="stock" style="width:120px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });
    
});
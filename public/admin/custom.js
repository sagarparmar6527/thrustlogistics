var table = $('#dataTable');

jQuery('body').on('click','.open-form',function(){
    if(($(this).data('id'))){
        var link = table.data('edit-href')+'/'+$(this).data('id');
    }else{
        var link = $(this).data('create-href');
    }
    $.ajax({
        url: link,
        success: function (response) {
            if((response.error)){
                errorFun(response.error);
            }else{
                $('#content-form, #content-table').toggle();
                $('#content-form').html(response);
                /* JQuery Validations */
                $("#submit-form").validate();
            }
        },
        error: function (error) {
            warningFun();
        }
    });
});

jQuery('body').on('click','.goBack',function(){
    $('#content-form, #content-table').toggle();
});

/* Submit Form Using Ajax */
$(document).on('submit','#submit-form',function(e){
    e.preventDefault();
    
    $.ajax({
        type: $(this).prop('method'),
        url: $(this).prop('action'),
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if((response.error)){
                errorFun(response.error);
            }else{
                $('#content-form, #content-table').toggle();
                table.DataTable().ajax.reload();
                $.toast({
                    heading: 'Success',
                    text: response.success,
                    showHideTransition: 'slide',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-center'
                });
            }
        },error: function (error){
            warningFun();
        }
    });
});

/* Delete Record */
jQuery('body').on('click','.delete',function(){
    var $this = $(this);
    var action = table.data('delete-href');
    var id = $this.data('id');
    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this records!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: action+'/'+id,
                success: function (response) {
                    $this.parents('tr').remove();
                    Swal.fire("Deleted!",data,"success");
                },error: function (response) {
                    Swal.fire("Oops!", "something went wrong!", "warning");
                }
            });
        } else if (result.dismiss === "cancel") {
            Swal.fire("Cancelled","Your records is safe :)","error");
        }
    });
});


// Warning Function
function warningFun(){
    $.toast({
        heading: 'Warning',
        text: 'Something went wrong! Please try again!',
        showHideTransition: 'slide',
        icon: 'warning',
        loaderBg: '#57c7d4',
        position: 'top-center'
    });
}

// Error Function
function errorFun(error){
    $.toast({
        heading: 'Error',
        text: error,
        showHideTransition: 'slide',
        icon: 'error',
        loaderBg: '#f2a654',
        position: 'top-center'
    });
}

jQuery("body").on('click','#search-filter',function(){
    table.DataTable().draw();
});

jQuery("body").on('click','#clear-filter',function(){
    $('#filter-form')[0].reset();
    table.DataTable().draw();
});



// Order Page Js

/* Order Submit Form Using Ajax */
$(document).on('submit','#submit-order-form',function(e){
    e.preventDefault();
    
    $.ajax({
        type: $(this).prop('method'),
        url: $(this).prop('action'),
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if((response.error)){
                errorFun(response.error);
            }else{
                if((response.success)){
                    $('#content-form, #content-table').toggle();
                    table.DataTable().ajax.reload();
                    $.toast({
                        heading: 'Success',
                        text: response.success,
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-center'
                    });
                }else{
                    $('#content-form').html(response);
                    /* JQuery Validations */
                    $("#submit-carrier-form").validate();   
                }
            }
        },error: function (error){
            warningFun();
        }
    });
});

jQuery('body').on('click','.orderGoBack',function(){
    var link = $(this).data('href');

    $.ajax({
        url: link,
        success: function (response) {
            if((response.error)){
                errorFun(response.error);
            }else{
                $('#content-form').html(response);
            }
        },
        error: function (error) {
            warningFun();
        }
    });
});

$(document).on('submit','#submit-carrier-form',function(e){
    e.preventDefault();
    
    $.ajax({
        type: $(this).prop('method'),
        url: $(this).prop('action'),
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if((response.error)){
                errorFun(response.error);
            }else{
                $('#content-form').html(response);
            }
        },error: function (error){
            warningFun();
        }
    });
});

jQuery('body').on('click','.open-carrier-form',function(){
    if(($(this).data('id'))){
        var link = $(this).data('href')+'/'+$(this).data('id');
    }else{
        var link = $(this).data('href')+'/'+$(this).data('order-id');
    }
    $.ajax({
        url: link,
        success: function (response) {
            if((response.error)){
                errorFun(response.error);
            }else{
                $('#content-form').html(response);
            }
        },
        error: function (error) {
            warningFun();
        }
    });
});

jQuery('body').on('click','.deleteCarrier',function(){
    var $this = $(this);
    var action = $this.data('href');
    var id = $this.data('id');
    $.ajax({
        url: action+'/'+id,
        success: function (response) {
            $('#content-form').html(response);
        },error: function (response) {
            Swal.fire("Oops!", "something went wrong!", "warning");
        }
    });
});
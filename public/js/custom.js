jQuery(document).ready(function(){

/*========== Enter only number ========*/
    jQuery(document).on('keyup blur', '.mbCheckNm', function(e){
        e.preventDefault();
        var key  = e.charCode || e.keyCode || 0;
        if (key >= 65 && key <= 90){
          this.value = this.value.replace(/[^\d]/g,'');
          return false;
        }
    });

    /*========== Number ========*/
    $.validator.addMethod("Numbers", function(value, element) {
        return this.optional(element) || /^[0-9]*$/.test(value);
    }, "Please enter numeric values only.");


    /*===== delete Sender =====*/
    jQuery(document).on('click', '.delete_sender', function(){
        jQuery('#deletesender').modal('show');
        var senderid =  jQuery(this).attr('data-id');
        var url =  jQuery(this).attr('data-action');
        jQuery(document).off('click','.deletesenderconfirm').on('click', '.deletesenderconfirm', function(){
           
            jQuery.ajax({
                type      : 'post',
                url       : url,
                data      : {senderid:senderid},
                headers   : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "JSON",
                success:function(response){
                    if(response){
                        jQuery("#sendertable").load(" #sendertable");
                        jQuery("#deletesender").modal("hide");

                        swal("Success!", "Data has been Deleted successfully", "success");
                        setTimeout(() => {window.location.href = response.redirect_url},1500);
                    }
                }
            });
        });
    });
    /*===== End delete Sender =====*/

/*========== createcourier ========*/
    jQuery('#createcourier').validate({
        rules:
        {
            courier_name: {
                required: true,
            },
            phone: {
                Numbers: true,
                minlength:10,
            },
        },
        messages:
        {
            courier_name: {
                required: "Courier name is required"
            },
            phone: {
                Numbers: "Enter only numbers",
                minlength: "Enter at least 10 digits",
            },
        },
        submitHandler : function(form)
        {
            formSubmit(form);
            jQuery('#createcompany').modal('hide');
        }
    });
    jQuery('#add_courier').click(function(){
        $('#createcourier').trigger("reset");
    });

    // create company
    jQuery('#createforcmpny').validate({
        rules:
        {
            for_company: {
                required: true,
            },
        },
        messages:
        {
            for_company: {
                required: "Company name is required"
            },
        },
        submitHandler : function(form)
        {
            formSubmit(form);
            jQuery('#createforcompany').modal('hide');
        }
    });
    jQuery('#add_forcompany').click(function(){
        $('#createforcmpny').trigger("reset");
    });

    // update sender
    jQuery('#update_sender').validate({
        rules:
        {
            name: {
                required: true,
            },
        },
        messages:
        {
            name: {
                required: "Sender name is required"
            },
        },
        submitHandler : function(form)
        {
            formSubmit(form);
        }
    });
   


});
// End ready function //

function formSubmit(form)
{
    jQuery.ajax({
        url         : form.action,
        type        : form.method,
        data        : new FormData(form),
        contentType : false,
        cache       : false,
        headers     : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData : false,
        dataType    : "json",
        beforeSend  : function () {
            $(".load-main").show();
        },
        complete: function () {
            $(".load-main").hide();
        },
        success: function (response) {
            if(response.success){
                if(response.page == 'couriercompany'){
                    swal("Success!", "Data has been Submitted successfully", "success");
                    setTimeout(() => {window.location.href = response.redirect_url},1500);
                }else if(response.page == 'forcompany'){
                    swal("Success!", "Data has been Submitted successfully", "success");
                    setTimeout(() => {window.location.href = response.redirect_url},1500);
                }else if(response.page == 'sender-update'){
                    swal("Success!", "Data has been Updated successfully", "success");
                    setTimeout(() => {window.location.href = response.redirect_url},1500);
                }else{
                    
                }
            }
            if(response.formErrors)
            {
                var i = 0;
                $.each(response.errors, function(index,value)
                {
                    if (i == 0) {
                        $("input[name='"+index+"']").focus();
                    }
                    $("input[name='"+index+"']").parents('.form-group').addClass('has-error');
                    $("input[name='"+index+"']").after('<label id="'+index+'-error" class="error" for="'+index+'">'+value+'</label>');
                    $("select[name='"+index+"']").parents('.form-group').addClass('has-error');
                    $("select[name='"+index+"']").after('<label id="'+index+'-error" class="has-error" for="'+index+'">'+value+'</label>');
                      i++;
                });
            }
        },
        error:function(response){
            console.error(response);
        }
    });
}


// Add table row //

$("#addmore").on("click",function(){
    //alert('hi');
    $.ajax({
        headers     : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'add-trrow',
        data:{'action':'addDataRow'},
        success: function(data){
            $('#tb').append(data);
            //$('.selectpicker').selectpicker('refresh');
            $('#save').removeAttr('hidden',true);
        }
    });
});

////////////////
$(document).ready(function(){
    $("#save").on("click",function(){
       
        var field1 = $("#date_of_receipt").val();
        alert(field1);


    });

});


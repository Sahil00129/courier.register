jQuery(document).ready(function(){

    jQuery('#createcourier').validate({
        rules:
        {
            courier_name: {
                required: true,
            },
            phone: {

            },
        },
        messages:
        {
            courier_name: {
                required: "Courier name is required"
            },
            phone: {

            },
        },
        submitHandler : function(form)
        {
            formSubmit(form);
            jQuery('#createcompany').modal('hide');
        }
    });

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
                    setTimeout(() => {window.location.href = response.redirect_url},2000);
                }else if(response.page == 'forcompany'){
                    swal("Success!", "Data has been Submitted successfully", "success");
                    setTimeout(() => {window.location.href = response.redirect_url},2000);
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
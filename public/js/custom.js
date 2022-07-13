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
    $("#addmore").hide();
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

        var date = $("#date_of_receipt").val();
        var employee_name = $("#select_employee").val();
        var location = $("#location").val();
        var company_name =  $("#for").val();
        var remarks =  $("#remarks").val();
        var amount = $("#amount").val();
        var terfrom_date = $("#terfrom_date").val();
        var terto_date = $("#terto_date").val();
        var details = $("#details").val();
        var given_to = $("#given_to").val();
        var delivery_date = $("#delivery_date").val();
        var slct = $("#slct").val();
        var docket_no = $("#docket_no").val();
        var docket_date = $("#docket_date").val();
        
        if(date == '' || employee_name == '' || location == '' || company_name == '' || remarks == '' || amount == '' || terfrom_date == '' || terto_date == '' || details == '' || given_to == '' || delivery_date == '' || slct == '' || docket_no == '' || docket_date == ''){
            swal("Error!", "Please fill empity field", "error");
            return false;
        }

        var fd = new FormData();
        fd.append('date', date);
        fd.append('select_employee', employee_name);
        fd.append('location', location);
        fd.append('amount', amount);
        fd.append('company_name', company_name);
        fd.append('remarks', remarks);
        fd.append('terfrom_date', terfrom_date);
        fd.append('terto_date', terto_date);
        fd.append('details', details);
        fd.append('given_to', given_to);
        fd.append('delivery_date', delivery_date);
        fd.append('slct', slct);
        fd.append('docket_no', docket_no);
        fd.append('docket_date', docket_date);


        $.ajax({
            url: "/create-terrow", 
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',  
            data:fd,
            processData: false,
            contentType: false,
            beforeSend: function(){
                 
               },
              success: (data) => {  
                if(data.success){
                    swal("Success!", "Data has been Submitted successfully", "success");
                    setTimeout(() => {window.location.href = data.redirect_url},1500);
                }else{
                    swal("Error!", "Something went wrong", "error");
                }

              }
      });

    });

});


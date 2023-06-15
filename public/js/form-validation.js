jQuery(document).ready(function () {
    /*========== Enter only number ========*/
    jQuery(document).on("keyup blur", ".mbCheckNm", function (e) {
        e.preventDefault();
        var key = e.charCode || e.keyCode || 0;
        if (key >= 65 && key <= 90) {
            this.value = this.value.replace(/[^\d]/g, "");
            return false;
        }
    });

    /*========== Number ========*/
    $.validator.addMethod(
        "Numbers",
        function (value, element) {
            return this.optional(element) || /^[0-9]*$/.test(value);
        },
        "Please enter numeric values only."
    );

    /*========== createcourier ========*/
    jQuery("#createcourier").validate({
        rules: {
            courier_name: {
                required: true,
            },
            phone: {
                Numbers: true,
                minlength: 10,
            },
        },
        messages: {
            courier_name: {
                required: "Courier name is required",
            },
            phone: {
                Numbers: "Enter only numbers",
                minlength: "Enter at least 10 digits",
            },
        },
        submitHandler: function (form) {
            formSubmit(form);
            jQuery("#createcompany").modal("hide");
        },
    });

    // create company
    jQuery("#createforcmpny").validate({
        rules: {
            for_company: {
                required: true,
            },
        },
        messages: {
            for_company: {
                required: "Company name is required",
            },
        },
        submitHandler: function (form) {
            formSubmit(form);
            jQuery("#createforcompany").modal("hide");
        },
    });

    // update sender
    jQuery("#update_sender").validate({
        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Sender name is required",
            },
        },
        submitHandler: function (form) {
            formSubmit(form);
        },
    });

    //create po

    jQuery("#createpo").validate({
        rules: {
            po_number: {
                required: true,
                //maxlength:25,
                //lettersonly:true
            },
            vendor_name: {
                required: true,
            },
            vendor_code: {
                required: true,
            },
            po_value: {
                required: true,
            },
            activity: {
                required: true,
            },
            unit: {
                // required: true,
            },
        },
        messages: {
            activity: {
                required: "Activity is required",
            },
            po_number: {
                required: "PO number is required",
            },
            vendor_code: {
                required: "Vendor Code is required",
            },
            vendor_name: {
                required: "Vendor name is required",
            },
            po_value: {
                required: "Po value is required",
            },
            unit: {
                required: "Unit is required",
            },
        },
    
        submitHandler: function (form) {
            if(document.getElementById("po_value").value < 0)
            {
                swal("error", "PO Value should be positive", "error");
            
            }
            else{
                formSubmitRedirect(form);
            }
        },
    });

    
    //create invoice
    jQuery("#createinvoice").validate({
        rules: {
            po_id: {
                required: true,
                //maxlength:25,
                //lettersonly:true
            },
            basic_amount: {
                required: true,
            },
            total_amount: {
                required: true,
            },
            invoice_no: {
                required: true,
            },
            invoice_date: {
                required: true,
            },
            received_date: {
                required: true,

            },
            courier_name: {
                required: true
            },
            docket_no: {
                required: true
            }
        },
        messages: {
            po_id: {
                required: "PO number is required",
            },
            basic_amount: {
                required: "Basic Amount is required",
            },
            total_amount: {
                required: "Total Amount is required",
            },
            invoice_no: {
                required: "Invoice Number is required",
            },
            invoice_date: {
                required: "Invoice Date is required",
            },
            received_date: {
                required: "Received Date is required",
            },
            courier_name: {
                required: "Courier Name is required",
            },
            docket_no: {
                required: "Docket Number is required",
            },
        },
        submitHandler: function (form) {

            document.getElementById('loadingBlock').style.display="flex";
            formSubmitRedirect(form);
        },
    });
    // $.validator.addMethod("GstCheck", function(value, element) {
    //     return this.optional(element) || /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/.test(value);
    // }, "Invalid GST Format.");

        //create invoice
        jQuery("#vForm").validate({
            rules: {
                // GstCheck:true,
            },
            messages: {
                // GstCheck:"Invalid GST"
            },
            submitHandler: function (form) {
                let flag=true;
                const unRegisteredGst = document.getElementById('unRegistered')
            if (unRegisteredGst.checked && $('#pan_no').val().length == 0 && $('#phone').val().length == 0){
                flag=false;
                swal('error','Either Pan or Phone is required','error')
            }

                if ($('#gst').val().length != 0) {
                        let regex = new RegExp(/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/);
                        if (regex.test($('#gst').val()) != true) {
                           flag=false;
                           swal('error','Invalid GSt','error')
                        } 

                    }
                    if ($('#pan_no').val().length != 0) {
                        let regex = new RegExp(/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/);
                        if (regex.test($('#pan_no').val()) != true) {
                           flag=false;
                           swal('error','Invalid Pan Number','error')
                        } 

                    }
                    if ($('#phone').val().length != 0) {
                        let regex = new RegExp(/^[6-9][0-9]{9}$/);
                        if (regex.test($('#phone').val()) != true) {
                           flag=false;
                           swal('error','Invalid Phone Number','error')
                        } 

                    }

                    if ($('#pincode').val().length != 0) {
                        let regex = new RegExp(/^[1-9][0-9]{5}$/);
                        if (regex.test($('#pincode').val()) != true) {
                           flag=false;
                           swal('error','Invalid Picode','error')
                        } 

                    }

              if(flag){
                document.getElementById('loadingBlock').style.display="flex";
                    formSubmitRedirect(form);
              }
                

            
            },
        });

});
//end ready function//



/*======= submit redirect fuction =======*/
function formSubmitRedirect(form)
{
    $('.submit_po').prop('disabled',true);
    $('.submit_po').css('pointer-events', 'none');


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
            
        },
        complete: function (response) {
          
         
        },
        success: function (response)
        {
            if (response.page == "create-pos") {
                $('.submit_po').prop('disabled',true);
                $('.submit_po').css('pointer-events', 'none');
         }  
          	$.toast().reset('all');
      		var delayTime = 3000;
	        if(response.success){
                
	            $.toast({
		          heading             : 'Success',
		          text                : response.success_message,
		          loader              : true,
		          loaderBg            : '#fff',
		          showHideTransition  : 'fade',
		          icon                : 'success',
		          hideAfter           : delayTime,
		          position            : 'top-right'
		    	});

              
                if (response.page == "add-vendors-form") {
                    document.getElementById('loadingBlock').style.display="none";
                    swal(
                        "Success!",
                        "Data has been Submitted successfully",
                        "success"
                    );
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 1500);
                }

	        }

            if(response.error){
               
                if (response.page == "add-vendors-form") {
                
                    document.getElementById('loadingBlock').style.display="none";
                    // document.getElementById('sendForApproval').setAttribute('disabled', 'disabled');

                    var empty = false;
                    $('form .approvalReq').each(function() {
                        console.log('amit');
                        if ($(this).val() == '') empty = true;
                    });
                    console.log('amit1', empty);
        
                    if (empty) {
                        document.getElementById('sendForApproval').setAttribute('disabled', 'true');
                        document.getElementById('sendForApproval').classList.add('disabled');
                        document.getElementById('sendForApproval').style.pointerEvents = "none";
                        console.log('dsghdsfjhxcjfh adjfdus');
                    } else {
                        document.getElementById('sendForApproval').removeAttribute('disabled');
                        console.log('342343');

                    }

                        swal("error",
                            response.message,
                            "error"
                        );
                      
                    
                }

            }
          
	        if(response.resetform)
            {
                $('#'+form.id).trigger('reset');
            }else if(response.page == 'create-pos'){
                setTimeout(() => {window.location.href = response.redirect_url},1000);
            }else if(response.page == 'create-invoice'){
                setTimeout(() => {window.location.href = response.redirect_url},1000);
            }
            
            if(response.formErrors)
            {
              
                var i = 0;
              $('.error').remove();
              
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

            if(response.cnr_nickname_duplicate_error){
                jQuery("input[name='nick_name']").focus();
                jQuery("input[name='nick_name']").parents('.form-group').addClass('has-error');
                jQuery("input[name='nick_name']").after('<label id="nick_name-error" class="error" for="nick_name">'+response.error_message+'</label>');
                $("select[name='nick_name']").after('<label id="nick_name-error" class="has-error" for="nick_name">'+response.error_message+'</label>');
            }

            if(response.cnee_nickname_duplicate_error){
                jQuery("input[name='nick_name']").focus();
                jQuery("input[name='nick_name']").parents('.form-group').addClass('has-error');
                jQuery("input[name='nick_name']").after('<label id="nick_name-error" class="error" for="nick_name">'+response.error_message+'</label>');
                $("select[name='nick_name']").after('<label id="nick_name-error" class="has-error" for="nick_name">'+response.error_message+'</label>');
            }
            if(response.invoiceno_duplicate_error){
                jQuery("input[class='invc_no']").focus(); //.invc_no
                jQuery("input[class='invc_no']").parents().parents('#items_table').addClass('has-error');
                jQuery("input[class='invc_no']").after('<label class="invoice_no-error" class="error" for="invoice_no">'+response.error_message+'</label>');
                $("select[class='invc_no']").after('<label class="invoice_no-error" class="has-error" for="invoice_no">'+response.error_message+'</label>');
            }

            if(response.email_error){
                jQuery("#login_id-error").remove();
                jQuery("input[name='login_id']").focus();
                jQuery("input[name='login_id']").parents('.form-group').addClass('has-error');
                jQuery("input[name='login_id']").after('<label id="login_id-error" class="error" for="login_id">'+response.error_message+'</label>');
                $("select[name='login_id']").after('<label id="login_id-error" class="has-error" for="login_id">'+response.error_message+'</label>');
            }
		    var i = 0;
            $.each(response.errors, function( index, value )
            {
                if (i == 0) {
                    $("input[name='"+index+"']").focus();
                }
                var str=value.toString();
                if (str.indexOf('edit') != -1) {
                    // will not be triggered because str has _..
                    value=str.toString().replace('edit', '');
                }


                // $("input[name='"+index+"']").parents('.form-group').addClass('has-error');
                $("input[name='"+index+"']").after('<label id="'+index+'-error" class="has-error" for="'+index+'">'+value+'</label>');

                // $("textarea[name='"+index+"']").parents('.form-group').addClass('has-error');
                $("textarea[name='"+index+"']").after('<label id="'+index+'-error" class="has-error" for="'+index+'">'+value+'</label>');

                // $("select[name='"+index+"']").parents('.form-group').addClass('has-error');
                $("select[name='"+index+"']").after('<label id="'+index+'-error" class="has-error" for="'+index+'">'+value+'</label>');
                $("input[name='"+index+"']").addClass('is-invalid');
                $("select[name='"+index+"']").addClass('is-invalid');
                $("textarea[name='"+index+"']").addClass('is-invalid');
                i++;

            });
            $("input[type=submit]").removeAttr("disabled");
            $("button[type=submit]").removeAttr("disabled");
		},
        error:function(response){
            // alert("DS");
            document.getElementById('loadingBlock').style.display="none";
            swal('error',response,'error')


            $.toast({
                heading             : 'Error',
                text                : "Server Error",
                loader              : true,
                loaderBg            : '#fff',
                showHideTransition  : 'fade',
                icon                : 'error',
                hideAfter           : 4000,
                position            : 'top-right'
            });
            if (response.page == "add-vendors-form") {
                document.getElementById('loadingBlock').style.display="none";
            }
        }
    });
}
/*======= End submit redirect fuction =======*/

function formSubmit(form) {
    jQuery.ajax({
        url: form.action,
        type: form.method,
        data: new FormData(form),
        contentType: false,
        cache: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        processData: false,
        dataType: "json",
        beforeSend: function () {
            $(".load-main").show();
        },
        complete: function () {
            $(".load-main").hide();
        },
        success: function (response) {
            if (response.success) {
                if (response.page == "couriercompany") {
                    swal(
                        "Success!",
                        "Data has been Submitted successfully",
                        "success"
                    );
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 1500);
                } else if (response.page == "forcompany") {
                    swal(
                        "Success!",
                        "Data has been Submitted successfully",
                        "success"
                    );
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 1500);
                } else if (response.page == "sender-update") {
                    swal(
                        "Success!",
                        "Data has been Updated successfully",
                        "success"
                    );
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 1500);
                } else {
                }
            }
            if (response.formErrors) {
                var i = 0;
                $.each(response.errors, function (index, value) {
                    if (i == 0) {
                        $("input[name='" + index + "']").focus();
                    }
                    $("input[name='" + index + "']")
                        .parents(".form-group")
                        .addClass("has-error");
                    $("input[name='" + index + "']").after(
                        '<label id="' +
                            index +
                            '-error" class="error" for="' +
                            index +
                            '">' +
                            value +
                            "</label>"
                    );
                    $("select[name='" + index + "']")
                        .parents(".form-group")
                        .addClass("has-error");
                    $("select[name='" + index + "']").after(
                        '<label id="' +
                            index +
                            '-error" class="has-error" for="' +
                            index +
                            '">' +
                            value +
                            "</label>"
                    );
                    i++;
                });
            }
        },
        error: function (response) {
            console.error(response);
        },
    });
}
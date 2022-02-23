//////////////////////////////////Import Master///////////////////////
$(document).ready(function (e) {
    //alert('h');
    $('#new_sender_import').submit(function(e) {
        //alert('hii');return false;
       e.preventDefault();
       var formData = new FormData(this);
       var myfile = jQuery('#myxls').val();
       var itype = jQuery('#itype').val();
       if (!itype) {
       swal("Error!", "Please select import type", "error");
       return false;
    }
    if (!myfile) {
      swal("Error!", "No file, please upload an import file", "error");
      return false;
    }
              //alert (this);
              $.ajax({
                    url: "/import", 
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',  
                    data:new FormData(this),
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                      $(".indicator-progress").show(); 
                      $(".indicator-label").hide();
                         
                       },
                      success: (data) => {
                        $(".indicator-progress").hide();
                        $(".indicator-label").show();
                       
                        $('#new_sender_import').trigger('reset');
                      //this.reset();
                      //console.log(data.ignoredItems);
                      //console.log(data.ignoredcount);
                      if(data.import_type == 1) { 
                        
                          swal("Success!", "File has been imported successfully", "success");
                          window.location.href = "sender-table";
                        }else if(data.import_type == 2) {
                         
                          swal("Success!", "File has been imported successfully", "success");
                          window.location.href = "courier-company";
                        }else if(data.import_type == 3) {
                         
                          swal("Success!", "File has been imported successfully", "success");
                          window.location.href = "catagories";
                        }else if(data.import_type == 4) {
                         
                          swal("Success!", "File has been imported successfully", "success");
                          window.location.href = "for-company"; 
                         }else{
                      swal("Error", data.messages, "error");
                      }
                      
                      }
              });
          });

//////////////////////////Add Sender/////////////////////////////////////////////
$('#new_sender_add').submit(function(e) {
        //alert('hii');return false;
    e.preventDefault();
    var formData = new FormData(this);
    var name = jQuery('#name').val();
    var telephone = jQuery('#telephone_no').val();
    if (!name) {
    swal("Error!", "Please enter the name", "error");
    return false;
    }
    if (!telephone) {
    swal("Error!", "please enter telephone no.", "error");
    return false;
    }
        //alert (this); die;
        $.ajax({
              url: "/save-sender", 
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              type: 'POST',  
              data:new FormData(this),
              processData: false,
              contentType: false,
              beforeSend: function(){
              $(".indicator-progress").show(); 
              $(".indicator-label").hide();
               },
              success: (data) => {
                $(".indicator-progress").hide();
                $(".indicator-label").show();
                $('#new_sender_add').trigger('reset');
                //this.reset();
                //console.log(data.ignoredItems); 
                //console.log(data.ignoredcount);
                if(data.success === true) { 
                    swal("Success!", "Data has been Submitted successfully", "success");
                    
                  }
                    else{
                swal("Error!", data.messages, "error");
                
                }
                }
                
        }); 
    });	

    /////////////////////////New Courier Create//////////////////////////
    	//alert('h'); die;
		$('#new_courier_create').submit(function(e) {
            e.preventDefault();
            
                  //alert (this); die;
                    $.ajax({
                          url: "/create-newCourier", 
                          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                          type: 'POST',  
                          data:new FormData(this),
                          processData: false,
                          contentType: false,
                           beforeSend: function(){
                          $(".indicator-progress").show(); 
                          $(".indicator-label").hide();
            
                          },
                          success: (data) => {
                            $(".indicator-progress").hide();
                            $(".indicator-label").show();
                            $('#new_courier_create').trigger('reset');       
                            //this.reset();
                            //console.log(data.ignoredItems);
                            //console.log(data.ignoredcount);
                            if(data.success === true) {     
                                swal("Success!", "Data has been Saved", "success");
                                window.location.href = "courier-table";
                              }
                            
                            else{
                            swal("Error!", data.messages, "error");
                            }
                            }
                    }); 
                });	



});
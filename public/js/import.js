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
                      if(data.success === true) { 
                        
                         
                          swal("Success!", "File has been imported successfully", "success");
                        }
                      
                      else{
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
                            $('#newSender').trigger('reset');       
                            //this.reset();
                            //console.log(data.ignoredItems);
                            //console.log(data.ignoredcount);
                            if(data.success === true) { 
                              
                               
                                swal("Success!", "Data has been Saved", "success");
                              }
                            
                            else{
                            swal("Error!", data.messages, "error");
                            }
                            }
                    }); 
                });	



});
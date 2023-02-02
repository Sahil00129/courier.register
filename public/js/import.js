//////////////////////////////////Import Master///////////////////////
$(document).ready(function (e) {
    //alert('h');
    $("#new_sender_import").submit(function (e) {
        //alert('hii');return false;
        e.preventDefault();
        var formData = new FormData(this);
        var myfile = jQuery("#myxls").val();
        var itype = jQuery("#itype").val();
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
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".indicator-progress").show();
                $(".indicator-label").hide();
            },
            success: (data) => {
                $(".indicator-progress").hide();
                $(".indicator-label").show();

                $("#new_sender_import").trigger("reset");
                //this.reset();
                //console.log(data.ignoredItems);
                //console.log(data.ignoredcount);
                if (data.import_type == 1) {
                    swal(
                        "Success!",
                        "File has been imported successfully",
                        "success"
                    );
                    window.location.href = "sender-table";
                } else if (data.import_type == 2) {
                    swal(
                        "Success!",
                        "File has been imported successfully",
                        "success"
                    );
                    window.location.href = "courier-company";
                } else if (data.import_type == 3) {
                    swal(
                        "Success!",
                        "File has been imported successfully",
                        "success"
                    );
                    window.location.href = "catagories";
                } else if (data.import_type == 4) {
                    swal(
                        "Success!",
                        "File has been imported successfully",
                        "success"
                    );
                    window.location.href = "for-company";
                } else if (data.import_type == 5) {
                    // alert('5');
                    swal(
                        "Success!",
                        "File has been imported successfully",
                        "success"
                    );
                    window.location.href = "sender-table";
                } else {
                    swal("Error", data.messages, "error");
                }
            },
        });
    });

    //////////////////////////Add Sender/////////////////////////////////////////////
    $("#new_sender_add").submit(function (e) {
        //alert('hii');return false;
        e.preventDefault();
        var formData = new FormData(this);
        var name = jQuery("#name").val();
        var telephone = jQuery("#telephone_no").val();
        if (!name) {
            swal("Error!", "Please enter the name", "error");
            return false;
        }
        // if (!telephone) {
        //     swal("Error!", "please enter telephone no.", "error");
        //     return false;
        // }
        //alert (this); die;
        $.ajax({
            url: "/save-sender",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".indicator-progress").show();
                $(".indicator-label").hide();
            },
            success: (data) => {
                $(".indicator-progress").hide();
                $(".indicator-label").show();
                $("#new_sender_add").trigger("reset");
                //this.reset();
                if (data.success === true) {
                    swal(
                        "Success!",
                        "Data has been Submitted successfully",
                        "success"
                    );
                } else {
                    swal("Error!", data.messages, "error");
                }
            },
        });
    });

    /////////////////////////New Courier Create//////////////////////////
    $("#new_courier_create").submit(function (e) {
        e.preventDefault();
        //alert (this); die;
        $.ajax({
            url: "/create-newCourier",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".indicator-progress").show();
                $(".indicator-label").hide();
            },
            success: (data) => {
                $(".indicator-progress").hide();
                $(".indicator-label").show();
                $("#new_courier_create").trigger("reset");
                //this.reset();
                if (data.success === true) {
                    swal("Success!", "Data has been Saved", "success");
                    window.location.href = "courier-table";
                } else {
                    swal("Error!", data.messages, "error");
                }
            },
        });
    });

    /////////////////////////New TERCourier Create//////////////////////////
    $("#new_tercourier_create").submit(function (e) {
        e.preventDefault();
        var date_of_recp = $('#date_of_recp').val();
        var date_of_joinig = $('#date_of_joining').val();
        var d = new Date(date_of_joinig),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
// alert(d);
    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    var doj = [year, month, day].join('-');
  
        var ter_to = $('#terto_date').val();
        var docket_date=$('#docket_date').val();
        var ReciptDate = new Date(date_of_recp); //Year, Month, Date    
        var TerToDate = new Date(ter_to); //Year, Month, Date   
        var DOJ= new Date(doj);
        if (DOJ > TerToDate) {     
            swal("Error", "Date of Joining doesn't lie in the Ter Period", "error");
            return 1; 
        }
        if(TerToDate == 'Invalid Date')
        {
            swal("Error", "Please select Month", "error");
            return 1;  
        }
        else{
            if (ReciptDate < TerToDate) {     
                swal("Error", "Date of receipt can't be before Ter To date.", "error");
                return 1; 
            }
        }


        var today=new Date();
        if(ReciptDate > today)
        {
            swal("Error", "Date of receipt can't be future date", "error");
            return 1; 
        }

      
       
         if(docket_date!="")
         {
             var DocketDate = new Date(docket_date);
         if (DocketDate  > ReciptDate ) { 
            swal("Error", "Docket Date can't be after Date of receipt", "error");   
              return 1; 
          }
         }

        document.getElementById("save_ter_btn").disabled = true;
        jQuery("#save_ter_btn").prop("disabled", true);

        $.ajax({
            url: "/tercouriers",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".indicator-progress").show();
                $(".indicator-label").hide();
                // var nowdate1 = new Date();
                // var nowdate = nowdate1.getTime();
                // var lastwrk_date = $('#last_working_date').val();
                // var arr = lastwrk_date.split('-');
                // var lastwrk_date1 = new Date(arr[2]+"-" + arr[1]+"-"+arr[0]);
                // var lastwrk_date = lastwrk_date1.getTime();
                // console.log(lastwrk_date);
                // var empstatus = $('#emp_status').val();

                // var dateOffset = (24*60*60*1000) * 90;  // 90 days
                // console.log(dateOffset);
                // var caldays = lastwrk_date1.setTime(lastwrk_date1.getTime() - dateOffset);
                // console.log(caldays);
                // var from_date = $('#terfrom_date').val();
                // var arr2 = from_date.split('-');
                // var from_date = new Date(arr2[0]+"-" + arr2[1]+"-"+arr2[2]).getTime();
                // console.log(from_date);
                // if (empstatus == 'Blocked' || empstatus == '') {
                //     if(from_date > lastwrk_date) {
                //         swal("Error!", "Last working date should be greater than from date", "error");
                //         return false;
                //     }
                //     else if(caldays > from_date) {
                //         swal("Error!", "Last working date should be less than 90 days", "error");
                //         return false;
                //     }
                // }
            },
            complete: function (response) {},
            success: (data) => {
                $(".indicator-progress").hide();
                $(".indicator-label").show();
                // $("#save_ter_btn").disabled();
                $("#new_tercourier_create").trigger("reset");
                //this.reset();
                if (data.success === true) {
                    swal("Success!", "Data has been Saved", "success");
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 2000);
                } else {
                    swal("Error!", data, "error");
                }
            },
        });
    });

    // $('#new_tercourier_create').click(function(e) {
    //     docket_date = $('#docket_date').val();
    //     // alert(docket_date);
    //     if ($('#emp_status').val() == 'blocked' && $("#emp_status").val() == '') {
    //         $('.empstatus_error').show();
    //         return false;
    //     }else{
    //         $('.empstatus_error').hide();
    //     }
    // });
});

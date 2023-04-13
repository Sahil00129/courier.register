jQuery(document).ready(function () {

    /*===== delete Sender =====*/
    jQuery(document).on("click", ".delete_sender", function () {
        jQuery("#deletesender").modal("show");
        var senderid = jQuery(this).attr("data-id");
        var url = jQuery(this).attr("data-action");
        jQuery(document)
            .off("click", ".deletesenderconfirm")
            .on("click", ".deletesenderconfirm", function () {
                jQuery.ajax({
                    type: "post",
                    url: url,
                    data: { senderid: senderid },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response) {
                            jQuery("#sendertable").load(" #sendertable");
                            jQuery("#deletesender").modal("hide");

                            swal(
                                "Success!",
                                "Data has been Deleted successfully",
                                "success"
                            );
                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 1500);
                        }
                    },
                });
            });
    });
    /*===== End delete Sender =====*/
    
    jQuery("#add_courier").click(function () {
        $("#createcourier").trigger("reset");
    });

    jQuery("#add_forcompany").click(function () {
        $("#createforcmpny").trigger("reset");
    });

    // Add table row //
    $("#addmore").on("click", function () {
        $("#addmore").hide();
        //alert('hi');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: "add-trrow",
            data: { action: "addDataRow" },
            success: function (data) {
                $("#tb").append(data);
                //$('.selectpicker').selectpicker('refresh');
                $("#save").removeAttr("hidden", true);
            },
        });
    });

    $("#save").on("click", function () {
        var date = $("#date_of_receipt").val();
        var employee_name = $("#select_employee").val();
        var location = $("#location").val();
        var company_name = $("#for").val();
        var remarks = $("#remarks").val();
        var amount = $("#amount").val();
        var terfrom_date = $("#terfrom_date").val();
        var terto_date = $("#terto_date").val();
        var details = $("#details").val();
        var given_to = $("#given_to").val();
        var delivery_date = $("#delivery_date").val();
        var slct = $("#slct").val();
        var docket_no = $("#docket_no").val();
        var docket_date = $("#docket_date").val();

        if (
            date == "" ||
            employee_name == "" ||
            location == "" ||
            company_name == "" ||
            remarks == "" ||
            amount == "" ||
            terfrom_date == "" ||
            terto_date == "" ||
            details == "" ||
            given_to == "" ||
            delivery_date == "" ||
            slct == "" ||
            docket_date == ""
        ) {
            swal("Error!", "Please fill empity field", "error");
            return false;
        }

        var fd = new FormData();
        fd.append("date", date);
        fd.append("select_employee", employee_name);
        fd.append("location", location);
        fd.append("amount", amount);
        fd.append("company_name", company_name);
        fd.append("remarks", remarks);
        fd.append("terfrom_date", terfrom_date);
        fd.append("terto_date", terto_date);
        fd.append("details", details);
        fd.append("given_to", given_to);
        fd.append("delivery_date", delivery_date);
        fd.append("slct", slct);
        fd.append("docket_no", docket_no);
        fd.append("docket_date", docket_date);

        $.ajax({
            url: "/create-terrow",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: function () {},
            success: (data) => {
                if (data.success) {
                    swal(
                        "Success!",
                        "Data has been Submitted successfully",
                        "success"
                    );
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 1500);
                } else {
                    swal("Error!", "Something went wrong", "error");
                }
            },
        });
    });

    // search function on keypress
$.fn.searchtyping = function (callback) {
    var _this = $(this);
    var x_timer;
    _this.keyup(function () {
        clearTimeout(x_timer);
        x_timer = setTimeout(clear_timer, 300);
    });

    function clear_timer() {
        clearTimeout(x_timer);
        callback.call(_this);
    }
};

// common search function feature for all
jQuery("#search").searchtyping(function (callback) {
    let search = $.trim(jQuery(this).val());
    let url = jQuery(this).attr("data-action");
    jQuery.ajax({
        url: url,
        type: "get",
        data: { search: search },
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        beforeSend: function () {
            jQuery(".load-main").show();
        },
        complete: function () {
            jQuery(".load-main").hide();
        },
        success: function (response) {
            if (response.html) {
                jQuery(".main-table").html(response.html);
            }
        },
    });
});

// common reset filter function
jQuery(document).on("click", ".reset_filter", function () {
    var url = jQuery(this).attr("data-action");
    var resetfilter = "resetfilter";
    jQuery.ajax({
        type: "get",
        url: url,
        data: { resetfilter: resetfilter },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                setTimeout(() => {
                    window.location.href = response.redirect_url;
                }, 10);
            }
        },
    });
    return false;
});

/*======get consigner on regional client =====*/
$("#select_po").change(function (e) {
    // $("#items_table").find("tr:gt(1)").remove();
    var po_id = $(this).val();
    $.ajax({
        url: "/get-po",
        type: "get",
        cache: false,
        data: { po_id: po_id },
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="_token"]').attr("content"),
        },
        beforeSend: function () {
            $("#select_consigner").empty();
        },
        success: function (res) {
            if(res.data){
                console.log(res.data)
                $("#po_value").val(res.data.po_value);
                $("#po_unit").val(res.data.unit);
                $("#vendor_code").val(res.data.vendor_code);
                $("#vendor_name").val(res.data.vendor_name);

            }
        },
    });
});

/*======get consigner on regional client =====*/
$("#select_unit").change(function (e) {
    $('#select_pos').empty();
    $('.poInputToggle').hide();
    $("#vendor_code").val("");
    $("#vendor_name").val("");
    var unit = $(this).val();
  
    // $("#items_table").find("tr:gt(1)").remove();
   
    $.ajax({
        url: "/get_vendors/"+unit,
        // url: "https://beta.finfect.biz/api/getVendorList/"+unit,
        type: "get",
        // cache: false,
        // data: { po_id: po_id },
        // dataType: "json",
        beforeSend: function () {
            $("#select_consigner").empty();
        },
        success: function (res) {
            if(res){
               
                //  console.log(res.data);return 1;
                $("#select_pos").append('<option selected disabled>search..</option>');
                $.each(res.data, function (index, value) {
                
                    $("#select_pos").append(
                        '<option value="'+value.id+":" +
                        value.vname +":"+value.vcode+
                        '">' + ""+
                        value.vname + " : " + value.vcode + " : " + unit + 
                        "</option>"
                    );
              
                
                });
                $('.poInputToggle').show();

                // $("#select_pos").val(res.data);
                // $("#po_unit").val(unit);
                // $("#vendor_code").val(res.data.vendor_code);
                // $("#vendor_name").val(res.data.vendor_name);

            }
        },
    });
});

$(document).on("keyup",".quantity", function(){
    var qty =$(this).val();
    // var qty = $(this).parent().siblings().eq(1).children('.quantity').val();
    var unit_price = $(this).parent().siblings().eq(2).children('.unitPrice').val();
    if(unit_price !="")
    {
        var total_amount = qty * unit_price;
        $(this).parent().siblings().eq(3).children('.totalAmount').val(total_amount);

    }

});
$(document).on("keyup",".unitPrice", function(){
    var unit_price =$(this).val();
    var qty = $(this).parent().siblings().eq(2).children('.quantity').val();
    if(qty != "")
    {
        var total_amount = qty * unit_price;
        $(this).parent().siblings().eq(3).children('.totalAmount').val(total_amount);
        calculate_totals();
    }

});

$(document).on("keyup","#gst_rate", function(){
    calculate_totals();

});

function calculate_totals() {
    var rowCount = $("#appendTable tr").length;
 
    var total_tax_amount = 0;
    for(var i=1;i<rowCount;i++)
    {
        var tax_amt= !$('[name="data[' + i + '][total_amount]"]').val()
        ? 0
        : parseInt($('[name="data[' + i + '][total_amount]"]').val());
    
        total_tax_amount += tax_amt;
        // total_tax_amount = total_tax_amount +   $('.totalAmount').val();

    }
  
    var gst_rate =   $('#gst_rate').val()/100;
   
    var gstamount = gst_rate *total_tax_amount;
    $('#gstAmount').html(gstamount);
    $('#gst_amount').val(gstamount);
    $("#totalTaxAmount").html(total_tax_amount);
    $("#total_tax_amount").val(total_tax_amount);

    $("#po_value").val(total_tax_amount+gstamount);
    $("#poAmount").html(total_tax_amount+gstamount);


}



$("#select_pos").change(function (e) {
    console.log($("#select_pos").val());
    const vendor_data_split = $("#select_pos").val().split(":");
    // console.log(vendor_data_split);
    // return 1;
    $("#vendor_unique_id").val(vendor_data_split[0]);
    $("#vendor_code").val(vendor_data_split[2]);
    $("#vendor_name").val(vendor_data_split[1]); 

    $("#vendorunique_id").html(vendor_data_split[0]);
    $("#vendor_code").html(vendor_data_split[2]);
    $("#vendorname").html(vendor_data_split[1]);
});



});
// End ready function //








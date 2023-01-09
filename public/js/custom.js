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
                $("#po_value").val(res.data.po_value);
                $("#po_unit").val(res.data.unit);
            }
        },
    });
});


});
// End ready function //








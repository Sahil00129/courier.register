@extends('layouts.main')
@section('title', 'Update Courier')
@section('content')
<style>
    .list-group {
        width: 500px !important;

        padding: 10px !important;
        list-style-type: none;
    }

    /* .list-group {
    max-height: 230px;
    overflow-y: auto;
    /* // prevent horizontal scrollbar / */
    /* overflow-x: hidden;
  } */
    .list-group {
        max-height: 439px;
        overflow-y: auto;
        overflow-x: scroll;
    }

    #product_list {
        position: absolute;
        background: #e2e2e2;
        z-index: 9999;
        margin-top: 10px;
    }

    /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
    * html .ui-autocomplete {
        height: 100px;
    }

    li:hover {
        color: #1f4eaf;
    }

    .editlable {

        color: gray;

    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 10px;
        background-color: #f7f2f2;
        border: 1pxsolidrgba(0, 0, 0, .125);
        color: #000;
    }

    /* <meta name="csrf-token" content="{{ csrf_token() }}" /> */
</style>
<?php
// echo'<pre>'; print_r($lastdate->date_of_receipt); die;
?>

<div class="container" id="edit_ter">
    <div class="container">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Update New TERCourier</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="#">Search ID</a></li>
                </ol>
            </nav>

            <div id="html5-extension_filter" class="dataTables_filter"><label>
                    <input type="text" class="form-control" id="search_item" placeholder="Enter UN ID" v-model="unique_id" aria-controls="html5-extension"></label>
                <button class="btn btn-success" v-on:click="get_data_by_id()"> @{{button_text}} </button>
            </div>

        </div>
        <div class="row" v-if="got_data">
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <h5><b>Sender Details</b></h5>


                        <div class="form-row mb-2">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">From</label>
                                <div>Actual Entry - @{{this.all_data.employee_id}}: @{{this.all_data.sender_name}} : @{{this.all_data.ax_id}} </div>
                                <!-- <input type="text" class="form-control" name="from" :value="this.all_data.sender_detail.name"  disabled> -->
                                <input type="text" class="form-control" v-on:change="get_sender_data(sender_all_info)" v-model="sender_all_info" list="sender_data" />
                                <datalist class="select2-selection__rendered" id="sender_data">
                                    <option v-for="sender_all_info in senders_data" :key="sender_all_info.employee_id">

                                        @{{sender_all_info.employee_id}} : @{{sender_all_info.name}} : @{{sender_all_info.ax_id}} : @{{sender_all_info.status}}
                                    </option>
                                </datalist>
                                <!-- <select
                              class="form-control"
                              id="select_employee"
                              v-model="sender_all_info"
                            >
                            <option selected disabled>search..</option>
                              <option
                                v-for="sender in senders_data"
                                :key="sender.id"
                                :value="sender.id"
                              >
                              
                              @{{sender.id}}  @{{sender.name}} : @{{sender.ax_id}} : @{{sender.employee_id}} : @{{sender.status}}
                              </option>
                            </select> -->
                                <!-- <input type="text" class="form-control" name="from" :value="this.all_data.sender_detail.name" disabled> -->
                            </div>
                            <!-- <input type="hidden" class="form-control" name="sender_id"  id="senderID"> -->
                            <!--------------- Date of Receipt ---------->
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Date of Receipt</label>
                                <div style="height: 20px;"></div>
                                <input type="date" class="form-control" name="date_of_receipt" :value="this.all_data.date_of_receipt" disabled>
                            </div>
                            <!--------------- end ------------------>
                        </div>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Location</label>
                                <input type="text" class="form-control" id="location" name="location" v-model="sender_location" readonly="readonly">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Telephone No.</label>
                                <input type="text" class="form-control mbCheckNm" id="telephone_no" name="telephone_no" autocomplete="off" maxlength="10" readonly="readonly" v-model="sender_telephone">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Status</label>
                                <input type="text" class="form-control" id="emp_status" name="emp_status" autocomplete="off" readonly="readonly" v-model="sender_status" />

                            </div>
                        </div>

                        <h5><b>Courier Details</b></h5>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label for="inputState">Courier Name</label>
                                <input type="text" class="form-control" id="courier_name" autocomplete="off" readonly="readonly" :value="this.all_data.courier_company.courier_name">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Docket No.</label>
                                <input type="text" class="form-control" id="docket_no" name="docket_no" autocomplete="off" readonly="readonly" :value="this.all_data.docket_no">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Docket Date</label>
                                <input type="date" class="form-control" id="docket_date" name="docket_date" readonly="readonly" :value="this.all_data.docket_date">
                                <!-- <p class="docketdate_error text-danger" style="display: none; color: #ff0000; font-weight: 500;">Docket date invalid.</p> -->
                            </div>
                        </div>
                        <!------------Document details --------->
                        <!--  <div class="insertRowAfter" style="border-bottom: 3px solid #ffa69e; margin-bottom: 10px;">    -->
                        <h5><b>Document Details</b></h5>
                        <div class="form-row mb-0">
                            <div class="form-group col-md-4">
                                <label for="inputState">Location</label>
                                <input type="text" class="form-control location1" id="location" name="location" readonly="readonly" :value="this.all_data.location">
                            </div>
                            <!-- <div class="form-group col-md-4">
                                <label for="inputState">Company Name</label>
                                <input type="text" class="form-control" id="amount" name="amount" readonly="readonly" :value="this.all_data.company_name">
                            </div> -->
                            <div class="form-group col-md-4">
                                <label for="inputState">Company Name</label>
                                <select id="select_option" name="company_name" v-model="company_name" class="form-control">
                                    <!-- <option selected disabled>Select...</option> -->
                                    <option disabled selected style="background-color: #e9ecef;"> @{{company_name}}</option>
                                    <option value="FMC">FMC</option>
                                    <option value="Corteva">Corteva</option>
                                    <option value="Unit-HSB">Unit-HSB</option>
                                    <option value="Remainco">Remainco</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">TER Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" v-model="amount">
                            </div>
                        </div>
                        <div class="form-row mb-0">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">TER Period From</label>
                                <input type="date" class="form-control" id="terfrom_date" name="terfrom_date" v-model="terfrom">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">TER Period To</label>
                                <input type="date" class="form-control" id="terto_date" name="terto_date" v-model="terto">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Other Details</label>
                                <input type="text" class="form-control" id="details" name="details" readonly="readonly" :value="this.all_data.details">
                            </div>
                        </div>

                        <!--------------- Remarks ---------->
                        <div class="form-row mb-0">
                            <div class="form-group col-md-6">
                                <label for="remarks">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="1" cols="70" readonly="readonly" :value="this.all_data.remarks"></textarea>
                            </div>
                        </div>
                        <!--------------- end ------------------>
                        <!-- <h5><b>Add Details</b></h5> -->
                        <!-- <div class="form-row mb-0">
                            <div class="form-group col-md-6">
                                <label for="payable_">Payable Amount</label>
                                <input type="number" class="form-control" id="payable_" name="payable_" v-model="payable_amount" placeholder="Enter Payable Amount">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="voucher_c">Voucher Code</label>
                                <input type="text" class="form-control" id="voucher_c" name="voucher_c" v-model="voucher_code" placeholder="Enter Voucher Code">
                            </div>
                        </div> -->
                        <!--------------- Remarks ---------->
                        <div class="form-row mb-0">
                            <div class="form-group col-md-6">
                                <label for="remarks">Admin Remarks</label>
                                <textarea name="remarks" class="form-control" rows="1" cols="70" v-model="admin_remarks"></textarea>
                            </div>
                        </div>

                        <div v-if="!update_ter_flag">
                            <h5><b>Add Details</b></h5>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="payable_">Payable Amount</label>
                                    <input type="number" class="form-control" id="payable_" name="payable_" v-model="payable_amount" placeholder="Enter Payable Amount">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="voucher_c">Voucher Code</label>
                                    <input type="text" class="form-control" id="voucher_c" name="voucher_c" v-model="voucher_code" placeholder="Enter Voucher Code">
                                </div>
                            </div>
                        </div>

                        <div v-if="update_ter_flag">
                            <h5><b>Details</b></h5>
                            <button type="button" class="btn btn-primary" name="button" @click="edit_payable_func" v-if="edit_btn_flag">Edit</button>
                            <ul class="schools" style="list-style-type: none; -webkit-columns: 1;-moz-columns: 1;columns: 1;">
                                <li v-for="(payment_data_new,index) in db_pay_data_array" style="font-weight:bold;font-size:17px"><b>
                                        @{{index+1}} . Payable Amount : @{{payment_data_new.payable_amount}} , Voucher Code : @{{payment_data_new.voucher_code}}</b>

                                    <!-- <button @click="removePayment(payment_data)" style="margin-top:10px">remove</button> -->
                                </li>
                            </ul>
                        </div>

                        <button type="button" class="btn btn-primary" name="button" @click="addAnotherpayment" v-if="edit_payable">Add</button>
                        <button type="button" class="btn btn-primary" name="button" @click="cancel_payable_func" v-if="edit_payable">Cancel</button>
                        <ul class="schools" style="list-style-type: none; -webkit-columns: 1;-moz-columns: 1;columns: 1;">
                            <li v-for="(payment_data,index) in pay_data_array" style="font-weight:bold">
                                @{{index+1}} . Payable Amount : @{{payment_data.payable_amount}} Voucher Code : @{{payment_data.voucher_code}}

                                <button @click="removePayment(payment_data)" style="margin-top:10px">remove</button>
                            </li>
                        </ul>

                        <button type=" submit" class="btn btn-primary" v-on:click="update_data_by_admin()">
                            <span class="indicator-label">Save</span>
                            </span>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#delivery_date').val(new Date().toJSON().slice(0, 10));
        //////////
        // $('#select_employee').on('keyup',function () {

        //         var query = $(this).val();
        //         //alert(query);
        //         $.ajax({
        //             url:'{{ url('autocomplete-search') }}',
        //             type:'GET',
        //             data:{'search':query},
        //             beforeSend:function () {
        //                 $('#product_list').empty();

        //             },
        //             success:function (data) {
        //                 // console.log(data.fetch);
        //                 $('#location').val('');
        //                 $('.location1').val('');
        //                 $('#telephone_no').val('');
        //                 $('#emp_status').val('');
        //                 $('#senderID').val('');
        //                 $('#product_list').html(data);

        //             }
        //         });
        //     });


        //     $(document).on('click', 'li', function(){
        //         var value = $(this).text(); 
        //         //console.log(value);
        //         var location = value.split(':');         //break value in js split
        //         for(var i = 0; i < location.length; i++){
        //             //console.log(location);
        //             var slct = location[0]+':'+location[2]+':'+location[3]+':'+location[5] ;

        //         $('#select_employee').val(slct);
        //         $('#location').val(location[1]);
        //         $('.location1').val(location[1]);
        //         $('#telephone_no').val(location[4]);
        //         $('#emp_status').val(location[5]);
        //         $('#senderID').val(location[6]);
        //         $('#product_list').html("");
        //         }
        //     });
        /*   $('#search').on('keyup',function () {
                    var query = $(this).val();
                    $.ajax({
                        url:'{{ url('autocomplete-search') }}',
                        type:'GET',
                        data:{'search':query},
                        success:function (data) {
                            $('#product_list').html(data);
                        }
                    });
                }); */

        //// get employee data on change
        $('#select_employee').on('change', function() {
            var emp_id = $(this).val();

            $.ajax({
                type: 'GET',
                url: "/get_employees",
                data: {
                    emp_id: emp_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: true,

                success: function(res) {
                    if (res.data) {
                        //alert(res.data);
                        console.log(res.data);
                        if (res.data.location == null) {
                            var location = '';
                        } else {
                            var location = res.data.location;
                        }
                        if (res.data.telephone_no == null) {
                            var telephone_no = '';
                        } else {
                            var telephone_no = res.data.telephone_no;
                        }
                        if (res.data.status == null) {
                            var status = '';
                        } else {
                            var status = res.data.status;
                        }
                        $("#location").val(location);
                        $("#telephone_no").val(telephone_no);
                        $("#emp_status").val(status);
                        $("#last_working_date").val(res.data.last_working_date);
                        $(".location1").val(location);
                    }
                }
            });
        });




    });
</script> -->


<script>
    new Vue({
        el: '#edit_ter',
        // components: {
        //   ValidationProvider
        // },
        data: {
            got_data: "",
            unique_id: "",
            all_data: {},
            button_text: "Search",
            payable_amount: "",
            voucher_code: "",
            update_ter_flag: false,
            amount: "",
            senders_data: {},
            sender_all_info: "",
            sender_location: "",
            sender_telephone: "",
            sender_status: "",
            company_name: "",
            terfrom: "",
            terto: "",
            pay_btn_flag: false,
            db_pay_data_array: [],
            counter: 0,
            pay_data_array: [],
            flag: false,
            edit_payable: false,
            edit_btn_flag: true,
            admin_remarks:"",

        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
            this.button_text = "Search";

        },
        methods: {
            edit_payable_func() {
                this.update_ter_flag = false;
                this.edit_payable = true;
                this.edit_btn_flag = false;
                this.payable_amount = "",
                    this.voucher_code = "";

            },
            cancel_payable_func() {
                this.update_ter_flag = true;
                this.edit_payable = false;
                this.edit_btn_flag = true;
                this.payable_amount = "",
                    this.voucher_code = "";
                this.pay_data_array = [];

            },
            addAnotherpayment() {
                this.pay_btn_flag = "true";
                // your logic here...
                if (this.counter > 4) {
                    swal('error', "You should delete one first! only 5 allowed", 'error')
                } else {
                    if (this.payable_amount != "" && this.voucher_code != "" && this.voucher_code != null) {
                        const payment_data = {
                            payable_amount: this.payable_amount, //name here
                            voucher_code: this.voucher_code //location here
                        }

                        //   console.log(this.pay_data_array)


                        if (this.payable_amount <= parseInt(this.amount)) {
                            this.counter++;
                            this.pay_data_array.push(payment_data)
                            this.payable_amount = '';
                            this.voucher_code = '';
                        } else {
                            // this.sum_flag=false;
                            swal('error', "Amount can't be greater than total amount", 'error')
                            this.pay_btn_flag = false;
                        }
                    } else {
                        swal('error', "Fields are empty", 'error')
                        this.pay_btn_flag = false;
                    }
                }
            },
            removePayment(payment_data) {
                if (this.pay_data_array.length == 1) {
                    this.pay_btn_flag = false;
                }
                var getIndex = this.pay_data_array.indexOf(payment_data);
                this.pay_data_array.splice(this.pay_data_array.indexOf(payment_data), 1);
                this.counter--;
            },
            get_sender_data: function(data) {
                const emp_id = data.split(" : ");
                axios.post('/get_employees', {
                        'emp_id': emp_id[0]
                    })
                    .then(response => {
                        if (response.data) {
                            this.sender_location = response.data.data.location;
                            this.sender_telephone = response.data.data.telephone_no;
                            this.sender_status = response.data.data.status;
                        } else {
                            swal('error', "Not able to fetch employee details", 'error')
                        }

                    }).catch(error => {
                        this.got_data = false;
                        this.update_ter_flag = false;
                        this.button_text = "Search";


                    })
            },
            update_data_by_admin: function() {
                var sender_emp_id, sender_name, ax_code, pay_data;
                if (this.sender_all_info != "") {
                    const sender_data_split = this.sender_all_info.split(" : ");
                    sender_emp_id = sender_data_split[0];
                    sender_name = sender_data_split[1];
                    ax_code = sender_data_split[2];
                } else {
                    sender_emp_id = this.all_data.employee_id;
                    sender_name = this.all_data.sender_name;
                    ax_code = this.all_data.ax_id;;
                }
                pay_data = this.pay_data_array;

                if (this.pay_data_array.length == 0) {
                    pay_data = this.db_pay_data_array;
                }
                if(this.db_pay_data_array.length == 0)
                {
                    pay_data = "";
                }
                // console.log(this.payable_amount);
                // return 1;
                if (this.amount != "" && this.company_name != "" && sender_emp_id != "") {
                    axios.post('/update_by_hr_admin', {
                            'sender_emp_id': sender_emp_id,
                            'company_name': this.company_name,
                            'amount': this.amount,
                            'unique_id': this.unique_id,
                            'sender_name': sender_name,
                            'ax_id': ax_code,
                            'payable_data': pay_data,
                            'admin_remarks':this.admin_remarks,
                            'terfrom_date': this.terfrom,
                            'terto_date': this.terto


                        })
                        .then(response => {
                            // console.log(response.data);
                            if (response.data == "error_sum_amount") {
                                swal('error', "Amount can't be greater than total amount", 'error')
                                // window.location.reload();
                            } else if (response.data) {
                                // this.update_ter_flag = true;
                                swal('success', "Record has been updated Successfully!!!", 'success')
                                this.got_data = false;
                                document.getElementById("search_item").value = "";
                                this.unique_id = "";
                                this.sender_all_info = "";
                            } else if (response.data == 0) {

                                this.button_text = "Search";
                                this.got_data = false;
                                this.unique_id = "";
                                this.sender_all_info = "";
                                document.getElementById("search_item").value = "";
                                swal('error', "Request Already Submitted to finfect", 'error')
                            } else {
                                this.button_text = "Search";
                                this.got_data = false;
                                this.unique_id = "";
                                this.sender_all_info = "";
                                document.getElementById("search_item").value = "";
                                swal('error', "Either Record is already updated or not selected", 'error')
                            }

                        }).catch(error => {

                            this.button_text = "Search";
                            this.got_data = false;
                            document.getElementById("search_item").value = "";
                            this.unique_id = "";
                            this.sender_all_info = "";


                        })

                } else {
                    swal('error', "Fields are empty", 'error')
                }
            },
            get_data_by_id: function() {
                this.button_text = "Searching...";
                this.got_data = false;
                this.all_data = {};
                this.flag = false;
                this.update_ter_flag = false;
                this.payable_amount = "",
                this.voucher_code = "",
                this.pay_data_array = [];
                this.counter = 0;
                this.pay_btn_flag = false;
                this.db_pay_data_array = [];
                this.edit_payable = false;
                this.edit_btn_flag = true;
                this.admin_remarks="";

                //  alert(this.unique_id);

                axios.post('/get_all_data', {
                        'unique_id': this.unique_id
                    })
                    .then(response => {
                        var string_pay, split_data_pay_amt, pay_data_len, string_voucher, split_data_voucher, voucher_data_len, i;
                        // console.log(response.data);
                        if (response.data.status_of_data === "3") {
                            this.button_text = "Search";
                            swal('error', "Record Already submitted to Finfect", 'error')
                        } else if (response.data[0] != "" && response.data.status_of_data === "0") {
                            this.got_data = true;
                            this.button_text = "Search";
                            this.all_data = response.data[0];
                            this.amount = this.all_data.amount;
                            this.payable_amount = this.all_data.payable_amount;
                            this.voucher_code = this.all_data.voucher_code;
                            this.senders_data = response.data.all_senders_data;
                            this.sender_location = this.all_data.sender_detail.location;
                            this.sender_telephone = this.all_data.sender_detail.telephone_no;
                            this.sender_status = this.all_data.sender_detail.status;
                            this.company_name = this.all_data.company_name;
                            this.terfrom = this.all_data.terfrom_date;
                            this.terto = this.all_data.terto_date;
                            this.admin_remarks=this.all_data.hr_admin_remark;


                            // console.log(this.all_data.courier_company)
                        } else if (response.data[0] != "" && response.data.status_of_data === "1") {
                            this.got_data = true;
                            this.flag = true;
                            this.update_ter_flag = true;
                            this.button_text = "Search";
                            this.all_data = response.data[0];
                            this.amount = this.all_data.amount;
                            this.payable_amount = this.all_data.payable_amount;
                            this.voucher_code = this.all_data.voucher_code;
                            string_pay = this.payable_amount.replace(/[^a-zA-Z0-9,]/g, '');
                            split_data_pay_amt = string_pay.split(",");
                            pay_data_len = split_data_pay_amt.length;
                            // console.log(pay_data_len)
                            string_voucher = this.voucher_code.replace(/[^a-zA-Z0-9,]/g, '');
                            split_data_voucher = string_voucher.split(",");
                            voucher_data_len = split_data_voucher.length;
                            if (pay_data_len == voucher_data_len) {
                                for (i = 0; i < pay_data_len; i++) {
                                    // if(this.db_pay_data_array.length === 0)
                                    // {
                                    var payment_data_new = {
                                        payable_amount: split_data_pay_amt[i],
                                        voucher_code: split_data_voucher[i]
                                    }
                                    this.db_pay_data_array.push(payment_data_new);
                                    // }
                                }
                            }
                            this.senders_data = response.data.all_senders_data;
                            this.sender_location = this.all_data.sender_detail.location;
                            this.sender_telephone = this.all_data.sender_detail.telephone_no;
                            this.sender_status = this.all_data.sender_detail.status;
                            this.company_name = this.all_data.company_name;
                            this.terfrom = this.all_data.terfrom_date;
                            this.terto = this.all_data.terto_date;
                            this.admin_remarks=this.all_data.hr_admin_remark;

                            // console.log(this.all_data.courier_company)
                        } else {
                            this.got_data = false;
                            this.button_text = "Search";
                            this.update_ter_flag = false;
                            swal('error', "Either Details already updated or No record Found", 'error')
                        }

                    }).catch(error => {
                        this.got_data = false;
                        this.update_ter_flag = false;
                        this.button_text = "Search";


                    })
            },

        }


    })
</script>

@endsection
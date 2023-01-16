@extends('layouts.main')
@section('title', 'Create Courier')
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
            border: 1 pxsolidrgba(0, 0, 0, .125);
            color: #000;
        }

        .form-control-sm-30 {
            height: calc(2.8em + 2px) !important;
        }

        .form-group label,
        label {
            font-size: 12px;
            margin-bottom: 0;
        }

        .editTer .form-row {
            border-radius: 12px;
            padding: 1rem 8px 2px;
            position: relative;
        }

        .editTer .form-row h6 {
            font-size: 0.875rem;
            position: absolute;
            top: -0.5rem;
            left: 1rem;
            background: #dee2f4;
            padding: 1px 8px;
            border-radius: 7px;
            box-shadow: 0 2px 2px #83838350;
        }

        .addButton {
            height: 40px;
            width: 80px;
            padding: 0;
            border-radius: 8px;
        }

        .removeButton {
            padding: 0 3px;
            height: 20px;
            width: 60px;
            font-size: 12px;
            line-height: 12px;
        }
    </style>


    <div class="container" id="edit_ter">
        <div class="container">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Update New TERCourier</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Search ID</a></li>
                    </ol>
                </nav>

                @if($unique_id != '0')
                    <input type="hidden" id="unique_value" value="<?php echo $unique_id ?>"/>
                @else
                    <div id="html5-extension_filter" class="dataTables_filter d-flex align-items-center"
                         style="gap: 4px;">
                        <label>
                            <input type="text" class="form-control" placeholder="Enter UN ID" v-model="unique_id"
                                   aria-controls="html5-extension" style="height: 30px;">
                        </label>
                        <button class="btn btn-success" v-on:click="get_data_by_id()"
                                style="height: 30px; width: 80px; padding: 0; border-radius: 8px"> @{{button_text}}
                        </button>
                    </div>
                @endif

            </div>

            <div class="d-flex justify-content-center" id="cover-spin" v-if="loader">
            </div>

            <div class="row editTer" style="min-height: 70vh;">
                <div id="flFormsGrid" v-if="got_data" class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="form-row mb-4">
                                <h6><b>Sender Details</b></h6>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">From</label>
                                    <input type="text" class="form-control form-control-sm" name="from"
                                           v-model="emp_details" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Date of Receipt</label>
                                    <input type="date" class="form-control form-control-sm" name="date_of_receipt"
                                           v-model="date_of_receipt" disabled>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Location</label>
                                    <input type="text" class="form-control form-control-sm" id="location"
                                           name="location" v-model="location" readonly="readonly">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Telephone No.</label>
                                    <input type="text" class="form-control form-control-sm mbCheckNm" id="telephone_no"
                                           name="telephone_no" autocomplete="off" maxlength="10" readonly="readonly"
                                           v-model="telephone_no">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Status</label>
                                    <input type="text" class="form-control form-control-sm" id="emp_status"
                                           name="emp_status" autocomplete="off" readonly="readonly" v-model="status"/>

                                </div>
                            </div>

                            <!------------Document details --------->
                            <div class="form-row mb-4">
                                <h6><b>Document Details</b></h6>
                                <div class="form-group col-md-6">
                                    <label for="inputState">TER Amount</label>
                                    <input type="text" class="form-control form-control-sm" id="amount" name="amount"
                                           readonly="readonly" v-model="amount">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">Location</label>
                                    <input type="text" class="form-control form-control-sm location1" id="location"
                                           name="location" readonly="readonly" v-model="doc_location">
                                </div>

                                <div class="form-group col-md-3 n-chk align-self-center">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input onchange="onChangePeriodType()" id="for_month" disabled type="radio"
                                               class="new-control-input" name="period_type">
                                        <span class="new-control-indicator"></span>For Month
                                    </label>
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input checked="checked" onchange="onChangePeriodType()" id="for_period"
                                               disabled type="radio" class="new-control-input" name="period_type">
                                        <span class="new-control-indicator"></span>For Period
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="month">Select Month</label>
                                    <select disabled="true" id="month" class=" form-control form-control-sm"
                                            onchange="onSelectMonth()">
                                        <option disabled selected>--Select Month--</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">TER Period From</label>
                                    <input type="date" class="form-control form-control-sm" id="terfrom_date"
                                           name="terfrom_date"  v-model="terfrom">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">TER Period To</label>
                                    <input type="date" class="form-control form-control-sm" id="terto_date"
                                           name="terto_date" v-model="terto">
                                </div>

                                <!--
                                <div class="form-group col-md-3">
                                    <label for="remarks">Advance Amount</label>
                                    <input type="text" class="form-control form-control-sm" id="details" name="details"
                                           readonly="readonly" v-model="current_balance">
                                </div>
                                -->
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Other Details</label>
                                    <input type="text" class="form-control form-control-sm" id="details" name="details"
                                           readonly="readonly" :value="this.all_data.details">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control form-control-sm form-control-sm-30"
                                              rows="1" cols="70" readonly="readonly"
                                              :value="this.all_data.remarks"></textarea>
                                </div>
                            </div>
                            <!--------------- end ------------------>

                            <div class="form-row mb-4">
                                <h6><b>Courier Details</b></h6>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Courier Name</label>
                                    <input type="text" class="form-control form-control-sm" id="courier_name"
                                           autocomplete="off" readonly="readonly" v-model="courier_name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket No.</label>
                                    <input type="text" class="form-control form-control-sm" id="docket_no"
                                           name="docket_no" autocomplete="off" readonly="readonly" v-model="docket_no">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket Date</label>
                                    <input type="date" class="form-control form-control-sm" id="docket_date"
                                           name="docket_date" readonly="readonly" v-model="docket_date">
                                    <!-- <p class="docketdate_error text-danger" style="display: none; color: #ff0000; font-weight: 500;">Docket date invalid.</p> -->
                                </div>
                            </div>

                            <div>
                                <p class="display-3 d-flex align-items-center justify-content-between" style="font-size: 1rem; font-weight: 700; margin-bottom: 2rem;">
                                    TER Amount ₹@{{ amount }} &nbsp;&nbsp;|&nbsp;&nbsp; Advance Amount ₹@{{ current_balance }}
                                   <span v-if="all_data.sender_detail.last_working_date">
                                    Last working date @{{ all_data.sender_detail.last_working_date }}
                                   </span>
                                </p>
                            </div>

                            <div v-if="!update_ter_flag">
                                <div class="form-row mb-0">
                                    <h6><b>Add Details</b></h6>
                                    <div class="form-group col-md-6">
                                        <label for="payable_">Payable Amount</label>
                                        <input type="number" class="form-control form-control-sm" id="payable_"
                                               name="payable_" v-model="payable_amount" @keyup="amount_in_words(payable_amount)"
                                               placeholder="Enter Payable Amount" :disabled="flag">
                                        <span id="amountInwords" style="font-size: 12px;text-transform:capitalize;">@{{word_amount}}</span></div>
                                    <div class="form-group col-md-6">
                                        <label for="voucher_c">Voucher Code</label>
                                        <input type="text" class="form-control form-control-sm" id="voucher_c"
                                               name="voucher_c" v-model="voucher_code" placeholder="Enter Voucher Code"
                                               :disabled="flag">
                                    </div>
                                </div>
                            </div>
                            <div v-if="update_ter_flag">
                                <h6><b>Details</b></h6>
                                <ul class="schools"
                                    style="list-style-type: none; -webkit-columns: 1;-moz-columns: 1;columns: 1;">
                                    <li v-for="(payment_data_new,index) in db_pay_data_array"
                                        style="font-weight:bold;font-size:17px"><b>
                                            @{{index+1}} . Payable Amount : @{{payment_data_new.payable_amount}} ,
                                            Voucher Code : @{{payment_data_new.voucher_code}}</b>
                                    </li>
                                </ul>
                            </div>

                            <div class="d-flex">
                                <button type="button" class="btn btn-primary addButton" name="button"
                                        @click="addAnotherpayment" :disabled="update_ter_flag">
                                    Add
                                </button>
                                <div class="flex-grow-1 d-flex justify-content-end">
                                    <ul class="schools"
                                        style="list-style-type: none; -webkit-columns: 1;-moz-columns: 1;columns: 1;">
                                        <li v-for="(payment_data,index) in pay_data_array" style="font-weight:bold">
                                            @{{index+1}} . Payable Amount : @{{payment_data.payable_amount}} Voucher
                                            Code :
                                            @{{payment_data.voucher_code}}

                                            <button @click="removePayment(payment_data)"
                                                    class="btn btn-sm btn-danger removeButton">
                                                Remove
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mt-3" style="gap: 8px;"
                                 v-if="pay_btn_flag">
                                <button type=" submit" class="btn btn-primary addButton" v-on:click="ter_pay_now()"
                                        :disabled="update_ter_flag">
                                    <span class="indicator-label">Pay Now</span>
                                    </span>
                                </button>

                                <button type=" submit" class="btn btn-primary addButton" v-on:click="ter_pay_later()"
                                        :disabled="update_ter_flag">
                                    <span class="indicator-label">Pay Later</span>
                                    </span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>

    <script>
        $(document).ready(function () {
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
            $('#select_employee').on('change', function () {
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

                    success: function (res) {
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
    </script>

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
                payable_amount: 0,
                voucher_code: "",
                flag: false,
                update_ter_flag: false,
                amount: "",
                allow_flag: false,
                emp_details: "",
                counter: 0,
                pay_data_array: [],
                date_of_receipt: "",
                location: "",
                telephone_no: "",
                status: "",
                courier_name: "",
                docket_no: "",
                docket_date: "",
                doc_location: "",
                company_name: "",
                terfrom: "",
                terto: "",
                pay_btn_flag: false,
                db_pay_data_array: [],
                current_balance: "",
                // sum_flag:true,
                loader: false,
                word_amount:".",
            },
            created: function () {
                // alert(this.got_details)
                //   alert('hello');
                this.button_text = "Search";
                if (this.unique_id != "0") {
                    this.loader = true;
                }
                if (this.unique_id == "") {
                    this.loader = false;
                }
            },
            mounted: function () {
                this.button_text = "Search";
                this.unique_id = document.getElementById('unique_value').value;
                if (this.unique_id != "0") {
                    this.get_data_by_id(this.unique_id);
                }
                if (this.unique_id == "") {
                    this.loader = false;
                }

            },
            methods: {
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
                                this.word_amount = '.';
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
                ter_pay_later: function () {
                    var i, myArray, ter_to, myArray2, last_date_array, month_number, d1, d2;
                    var terto_date = new Date(this.all_data.terto_date);
                    if (this.all_data.sender_detail.last_working_date) {
                        myArray = this.terto.split("-");
                        myArray2 = this.all_data.sender_detail.last_working_date.split("-");
                        ter_to = myArray[0] + "-" + myArray[1] + "-" + myArray[2]
                        month_number = this.get_month_number(myArray2[1]);
                        if (month_number) {
                            last_date_array = myArray2[2] + "-" + month_number + "-" + myArray2[0]
                        }
                    } else {
                        this.allow_flag = true;
                    }
                    // alert(ter_to)
                    // alert(last_date_array)
                    // return 1;
                    d1 = new Date(ter_to);
                    d2 = new Date(last_date_array);
                    // alert(d1)
                    // alert(d2)
    
                    if (d1 <= d2 || this.allow_flag) {
                        axios.post('/ter_pay_later', {
                            'payable_data': this.pay_data_array,
                            'unique_id': this.all_data.id,
                            'payment_status': "2",
                            "ter_total_amount": this.amount,
                            "terfrom":this.terfrom,
                            'terto':this.terto
                        })
                            .then(response => {
                                // console.log(response.data);
                                if (response.data == "error_sum_amount") {
                                    swal('error', "Amount can't be greater than total amount", 'error')
                                    // window.location.reload();
                                } else if (response.data === "ifsc_error") {
                                    swal('error', "IFSC for this employee is not valid", 'error')
                                } else if (response.data[0] === "duplicate_voucher") {
                                    swal('error', "Voucher Code : " + response.data[1] + " has been Already used", 'error')
                                } else {
                                    if (response.data) {
                                        this.button_text = "Search";
                                        this.flag = true;
                                        this.update_ter_flag = true;
                                        this.allow_flag = false;
                                        this.get_data_by_id();
                                        swal('success', "Record has been updated Successfully!!!", 'success')
                                    } else {
                                        this.button_text = "Search";
                                        this.allow_flag = false;
                                        swal('error', "AX-ID missing in DB for this record", 'error')
                                    }
                                }

                            }).catch(error => {

                            this.button_text = "Search";


                        })

                    } else {
                        swal('error', "TER Dates needs update", 'error')
                    }
                    // } else {
                    //     swal('error', "Fields are empty", 'error')
                    // }
                },

                get_month_number: function (month) {
                    var number;
                    switch (month) {
                        case "Jan":
                            number = '01';
                            break;
                        case "Feb":
                            number = '02';
                            break;
                        case "Mar":
                            number = '03';
                            break;
                        case "Apr":
                            number = '04';
                            break;
                        case "May":
                            number = '05';
                            break;
                        case "Jun":
                            number = '06';
                            break;
                        case "Jul":
                            number = '07';
                            break;
                        case "Aug":
                            number = '08';
                            break;
                        case "Sep":
                            number = '09';
                            break;
                        case "Oct":
                            number = '10';
                            break;
                        case "Nov":
                            number = '11';
                            break;
                        case "Dec":
                            number = '12';
                            break;
                    }
                    return number;
                },
                ter_pay_now: function () {
                    var i, myArray, ter_to, myArray2, last_date_array, month_number, d1, d2;
                    var terto_date = new Date(this.all_data.terto_date);
                    if (this.all_data.sender_detail.last_working_date) {
                        myArray = this.terto.split("-");
                        myArray2 = this.all_data.sender_detail.last_working_date.split("-");
                        ter_to = myArray[0] + "-" + myArray[1] + "-" + myArray[2]
                        month_number = this.get_month_number(myArray2[1]);
                        if (month_number) {
                            last_date_array = myArray2[2] + "-" + month_number + "-" + myArray2[0]
                        }
                    } else {
                        this.allow_flag = true;
                    }
                    d1 = new Date(ter_to);
                    d2 = new Date(last_date_array);

                    if (d1 <= d2 || this.allow_flag) {

                        axios.post('/ter_pay_now', {
                            'payable_data': this.pay_data_array,
                            'unique_id': this.all_data.id,
                            'payment_status': "1",
                            "ter_total_amount": this.amount,
                            "current_balance": this.current_balance,
                            "terfrom":this.terfrom,
                            'terto':this.terto
                        })
                            .then(response => {
                                // console.log(response.data);
                                if (response.data === "error_sum_amount") {
                                    swal('error', "Payable Amount is Greater than TER Amount", 'error')
                                } 
                                else if (response.data === "pfu_missing") {
                                    swal('error', "PFU is not available for this TER", 'error')
                                } 
                                else if (response.data === "ifsc_error") {
                                    swal('error', "IFSC for this employee is not valid", 'error')
                                } else if (response.data[0] === "duplicate_voucher") {
                                    swal('error', "Voucher Code : " + response.data[1] + " has been Already used", 'error')
                                } else if (response.data === 1) {
                                    this.button_text = "Search";
                                    this.flag = true;
                                    this.update_ter_flag = true;
                                    this.allow_flag = false;
                                    this.pay_data_array = [];
                                    swal('success', "Record has been updated Successfully!!!", 'success')
                                    window.location.href = "/tercouriers";
                                    // this.get_data_by_id();
                                } else if (response.data[0] === 0) {
                                    swal('error', response.data[1], 'error')
                                    this.button_text = "Search";
                                    this.allow_flag = false;
                                    // this.get_data_by_id();
                                    //  window.location.reload();

                                } else {
                                    this.button_text = "Search";
                                    this.allow_flag = false;
                                    swal('error', "AX-ID missing in DB for this record", 'error')
                                }

                            }).catch(error => {

                            this.button_text = "Search";


                        })
                    } else {
                        swal('error', "TER Dates needs update", 'error')
                    }
                },
                get_data_by_id: function () {
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
                    this.current_balance = "";
                    //  alert(this.unique_id);

                    axios.post('/get_all_data', {
                        'unique_id': this.unique_id,
                        'role':""
                    })
                        .then(response => {
                            var string_pay, split_data_pay_amt, pay_data_len, string_voucher, split_data_voucher,
                                voucher_data_len, i;
                            this.loader = false;
                            // console.log(response.data);
                            // if voucher code and payable amount is not available in DB
                            if (response.data.status_of_data === "not_found") {
                                this.button_text = "Search";
                                swal('error', "No Record Found", 'error')
                            }
                            if (response.data.status_of_data === "3") {
                                this.button_text = "Search";
                                swal('error', "Record Already submitted to Finfect", 'error')
                            }
                            if (response.data.status_of_data === "5") {
                                this.button_text = "Search";
                                swal('error', "Record has been Already Paid", 'error')
                            }
                            if (response.data.status_of_data === "6") {
                                this.button_text = "Search";
                                swal('error', "Record has been Cancelled", 'error')
                            }
                            if (response.data.status_of_data === "7") {
                                this.button_text = "Search";
                                swal('error', "Record has been sent to admin", 'error')
                            }
                            if (response.data.status_of_data === "8") {
                                this.button_text = "Search";
                                swal('error', "Record has been sent to admin", 'error')
                            }   if (response.data.status_of_data === "9") {
                                this.button_text = "Search";
                                swal('error', "Unknow employee, contact HR admin.", 'error')
                            }
                            else if (isNaN(response.data[0].sender_id)) {
                                this.button_text = "Search";
                                swal('error', "Sender Details are missing for this record", 'error')
                            } else if (response.data[0] != "" && response.data.status_of_data === "0") {
                                this.got_data = true;
                                this.button_text = "Search";
                                this.all_data = response.data[0];
                                this.amount = this.all_data.amount;
                                this.payable_amount = this.all_data.payable_amount;
                                this.voucher_code = this.all_data.voucher_code;
                                this.emp_details = this.all_data.sender_name + " : " + this.all_data.employee_id + " : " + this.all_data.ax_id + " : "+ this.all_data.sender_detail.pfu;
                                this.date_of_receipt = this.all_data.date_of_receipt;
                                this.location = this.all_data.sender_detail.location;
                                this.telephone_no = this.all_data.sender_detail.telephone_no;
                                this.status = this.all_data.sender_detail.status;
                                this.courier_name = this.all_data.courier_company.courier_name;
                                this.docket_no = this.all_data.docket_no;
                                this.docket_date = this.all_data.docket_date;
                                this.doc_location = this.all_data.location;
                                this.company_name = this.all_data.company_name;
                                this.terfrom = this.all_data.terfrom_date;
                                this.terto = this.all_data.terto_date;
                                this.current_balance = response.data.current_balance;

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
                                this.current_balance = response.data.current_balance;
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
                                this.emp_details = this.all_data.sender_name + " : " + this.all_data.employee_id + " : " + this.all_data.ax_id + " : "+ this.all_data.sender_detail.pfu;
                                this.date_of_receipt = this.all_data.date_of_receipt;
                                this.location = this.all_data.sender_detail.location;
                                this.telephone_no = this.all_data.sender_detail.telephone_no;
                                this.status = this.all_data.sender_detail.status;
                                this.courier_name = this.all_data.courier_company.courier_name;
                                this.docket_no = this.all_data.docket_no;
                                this.docket_date = this.all_data.docket_date;
                                this.doc_location = this.all_data.location;
                                this.company_name = this.all_data.company_name;
                                this.terfrom = this.all_data.terfrom_date;
                                this.terto = this.all_data.terto_date;

                                // console.log(this.all_data.courier_company)
                            } else {
                                this.got_data = false;
                                this.button_text = "Search";
                                this.flag = false;
                                this.update_ter_flag = false;
                                swal('error', "Either Details already updated or No record Found", 'error')
                            }

                        }).catch(error => {
                        this.got_data = false;
                        this.flag = false;
                        this.update_ter_flag = false;
                        this.button_text = "Search";


                    })
                },

                inWords: function(num) {
                    var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
                    var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
                    if ((num = num.toString()).length > 9) return 'overflow';
                    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
                    if (!n) return;
                    var str = '';
                    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
                    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
                    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
                    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
                    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
                    return str;
                },
                amount_in_words: function(amount) {
                    this.word_amount = this.inWords(amount);
                    document.getElementById('amountInwords').style.textTransform = "capitalize";
                },
            }


        })
    </script>

    <script>
        function onChangePeriodType() {
            var forMonth = document.getElementById('for_month')
            var forPeiod = document.getElementById('for_period')
            if (forMonth.checked) {
                document.getElementById('terfrom_date').disabled = true;
                document.getElementById('terto_date').disabled = true;
                document.getElementById('month').disabled = false;
            }
            if (forPeiod.checked) {
                document.getElementById('terfrom_date').disabled = false;
                document.getElementById('terto_date').disabled = false;
                document.getElementById('month').disabled = true;
            }
        }

        function onSelectMonth() {
            const selectedMonth = document.getElementById('month').value
            const currentYear = new Date().getFullYear()
            if (selectedMonth == 1 || selectedMonth == 3 || selectedMonth == 5 || selectedMonth == 7 || selectedMonth == 8 || selectedMonth == 10 || selectedMonth == 12) {
                document.getElementById('terfrom_date').value = `${currentYear}-${selectedMonth}-01`;
                document.getElementById('terto_date').value = `${currentYear}-${selectedMonth}-31`;
            } else if (selectedMonth == 2) {
                document.getElementById('terfrom_date').value = `${currentYear}-${selectedMonth}-01`;
                document.getElementById('terto_date').value = `${currentYear}-${selectedMonth}-28`;
            } else {
                document.getElementById('terfrom_date').value = `${currentYear}-${selectedMonth}-01`;
                document.getElementById('terto_date').value = `${currentYear}-${selectedMonth}-30`;
            }
        }
    </script>

@endsection

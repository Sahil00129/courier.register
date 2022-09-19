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
                    <li class="breadcrumb-item"><a href="#">Edit Reception TERCourier</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="#">Search ID</a></li>
                </ol>
            </nav>

            <div id="html5-extension_filter" class="dataTables_filter"><label>
                    <input type="text" class="form-control" placeholder="Enter UN ID" v-model="unique_id" aria-controls="html5-extension"></label>
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
                            <!-- <div class="form-group col-md-6">
                                <label for="inputPassword4">From</label>
                                <input type="text" class="form-control" name="from" v-model="this.all_data.sender_detail.name">
                            </div> -->
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">From</label>
                                <div>Actual Entry - @{{this.all_data.sender_detail.name}} : @{{this.all_data.sender_detail.ax_id}} : @{{this.all_data.sender_detail.employee_id}} : @{{this.all_data.sender_detail.status}} </div>
                                <!-- <input type="text" class="form-control" name="from" :value="this.all_data.sender_detail.name"  disabled> -->
                                <input type="text" class="form-control" v-on:change="get_sender_data(sender_all_info)" v-model="sender_all_info" list="sender_data" />
                                <datalist class="select2-selection__rendered" id="sender_data">
                                    <option v-for="sender_all_info in senders_data" :key="sender_all_info.employee_id">

                                    @{{sender_all_info.employee_id}} :   @{{sender_all_info.name}} : @{{sender_all_info.ax_id}} : @{{sender_all_info.status}}
                                    </option>
                                </datalist>
                            </div>
                            <!-- <input type="hidden" class="form-control" name="sender_id"  id="senderID"> -->
                            <!--------------- Date of Receipt ---------->
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Date of Receipt</label>
                                <div style="height: 20px;"></div>
                                <input type="date" class="form-control" name="date_of_receipt" v-model="this.all_data.date_of_receipt" >
                            </div>
                            <!--------------- end ------------------>
                        </div>

                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Location</label>
                                <input type="text" class="form-control" id="location" name="location" v-model="sender_location" readonly="readonly" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Telephone No.</label>
                                <input type="text" class="form-control mbCheckNm" id="telephone_no" readonly="readonly" name="telephone_no" autocomplete="off" maxlength="10"  v-model="sender_telephone">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Status</label>
                                <input type="text" class="form-control" id="emp_status" name="emp_status" autocomplete="off" readonly="readonly"  v-model="sender_status" />

                                <!-- <div v-if="this.all_data.sender_detail.status === 1">
                                        <input type="text" class="form-control" id="emp_status" name="emp_status" autocomplete="off" readonly="readonly" value="Received" />
                                    </div>
                                    <div v-if="this.all_data.sender_detail.status === 2">
                                        <input type="text" class="form-control" id="emp_status" name="emp_status" autocomplete="off" readonly="readonly" value="Handover" />
                                    </div>
                                    <div v-if="this.all_data.sender_detail.status === 3">
                                        <input type="text" class="form-control" id="emp_status" name="emp_status" autocomplete="off" readonly="readonly" value="Unpaid" />
                                    </div> -->

                            </div>
                        </div>

                        <h5><b>Courier Details</b></h5>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label for="inputState">Courier Name</label>
                                <input type="text" class="form-control" id="courier_name" autocomplete="off"  v-model="this.all_data.courier_company.courier_name">
                            </div>

                            <!-- <div class="form-group col-md-4">
                                    <label for="inputState">Courier Name</label>
                                    <select id="slct" name="courier_id" class="form-control" onchange="yesnoCheck(this);">
                                        <option selected disabled>Select..</option>
                                        @foreach($couriers as $courier)
                                        <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                        @endforeach
                                        <option>Other</option>
                                    </select>
                                </div> -->

                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Docket No.</label>
                                <input type="text" class="form-control" id="docket_no" name="docket_no" autocomplete="off" v-model="this.all_data.docket_no">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Docket Date</label>
                                <input type="date" class="form-control" id="docket_date" name="docket_date" v-model="this.all_data.docket_date">
                                <!-- <p class="docketdate_error text-danger" style="display: none; color: #ff0000; font-weight: 500;">Docket date invalid.</p> -->
                            </div>
                        </div>
                        <!------------Document details --------->
                        <!--  <div class="insertRowAfter" style="border-bottom: 3px solid #ffa69e; margin-bottom: 10px;">    -->
                        <h5><b>Document Details</b></h5>
                        <div class="form-row mb-0">
                            <div class="form-group col-md-4">
                                <label for="inputState">Location</label>
                                <input type="text" class="form-control location1" id="location" name="location" v-model="this.all_data.location">
                            </div>
                            <!-- <div class="form-group col-md-4">
                                <label for="inputState">Company Name</label>
                                <input type="text" class="form-control" id="amount" name="amount"  v-model="this.all_data.company_name">
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
                                <input type="text" class="form-control" id="amount" name="amount"  v-model="this.all_data.amount">
                            </div>
                        </div>
                        <div class="form-row mb-0">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">TER Period From</label>
                                <input type="date" class="form-control" id="terfrom_date" name="terfrom_date"  v-model="this.all_data.terfrom_date">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">TER Period To</label>
                                <input type="date" class="form-control" id="terto_date" name="terto_date"  v-model="this.all_data.terto_date">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Other Details</label>
                                <input type="text" class="form-control" id="details" name="details"  v-model="this.all_data.details">
                            </div>
                        </div>

                        <!--------------- Remarks ---------->
                        <div class="form-row mb-0">
                            <div class="form-group col-md-6">
                                <label for="remarks">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="1" cols="70"  v-model="this.all_data.remarks"></textarea>
                            </div>
                        </div>
                        <!--------------- end ------------------>
                        <h5><b>Handover Details</b></h5>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="remarks">Given To</label>
                                    <select class="form-control" id="given_to" name="given_to">
                                        <!-- <option value="">Select</option> -->
                                        <option value="Veena">Veena</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="remarks">Delivery Date</label>
                                    <input type="date" class="form-control" id="delivery_date" name="delivery_date" v-model="this.all_data.delivery_date">
                                </div>
                            </div>

                        <button type=" submit" class="btn btn-primary" v-on:click="update_data_ter()" :disabled="update_ter_flag">
                            <span class="indicator-label">Save</span>
                            </span>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
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
            payable_amount: "",
            voucher_code: "",
            flag: false,
            update_ter_flag: false,
            amount: "",
            senders_data: {},
            sender_all_info: "",
            sender_location: "",
            sender_telephone: "",
            sender_status: "",
            company_name:"",
        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
            this.button_text = "Search";

        },
        methods: {
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
                            // alert(this.sender_telephone);
                        } else {
                            swal('error', "Not able to fetch employee details", 'error')
                        }

                    }).catch(error => {
                        this.got_data = false;
                        this.update_ter_flag = false;
                        this.button_text = "Search";


                    })
            },
            update_data_ter: function() {
                if (this.voucher_code != "" && this.payable_amount != "") {
                    // alert(this.payable_amount);
                    // alert(this.amount);
                    // alert(this.payable_amount)
                    // this.all_data.terto_date
                    // this.all_data.sender_detail.last_working_date
                    var terto_date = new Date(this.all_data.terto_date);
                    var last_working_date = new Date(this.all_data.sender_detail.last_working_date);

                    if (terto_date.getTime() <= last_working_date.getTime())
                    {

                    if (this.payable_amount <= parseInt(this.amount)) {

                        axios.post('/update_data_ter', {
                                'voucher_code': this.voucher_code,
                                'payable_amount': this.payable_amount,
                                'unique_id': this.all_data.id,
                            })
                            .then(response => {
                                // console.log(response.data);
                                if (response.data) {
                                    this.button_text = "Search";
                                    this.flag = true;
                                    this.update_ter_flag = true;
                                    swal('success', "Record has been updated Successfully!!!", 'success')
                                } else {
                                    this.button_text = "Search";
                                    swal('error', "Either Record is already updated or not selected", 'error')
                                }

                            }).catch(error => {

                                this.button_text = "Search";


                            })
                    } else {
                        // alert(this.amount)
                        // alert(this.payable_amount)
                        this.button_text = "Search";
                        swal('error', "Amount can't be greater than total amount", 'error')
                    }
                }
                else{
            swal('error', "TER Dates needs update", 'error')
                }
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
                    //  alert(this.unique_id);

                    axios.post('/get_all_data', {
                        'unique_id': this.unique_id
                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data[0] != "" && response.data.status_of_data === "0") {
                            this.got_data = true;
                            this.button_text = "Search";
                            this.all_data = response.data[0];
                            this.amount = this.all_data.amount;
                            this.senders_data = response.data.all_senders_data;
                            this.sender_telephone=this.all_data.sender_detail.telephone_no;
                            this.sender_location=this.all_data.sender_detail.location;   
                            this.sender_status=this.all_data.sender_detail.status;
                            this.company_name=this.all_data.company_name;
                            // console.log(this.sender_telephone)
                        } else if (response.data[0] != "" && response.data.status_of_data === "1") {
                            this.got_data = true;
                            this.flag = true;
                            this.update_ter_flag = true;
                            this.button_text = "Search";
                            this.all_data = response.data[0];
                            this.amount = this.all_data.amount;
                            this.senders_data = response.data.all_senders_data;
                            this.sender_telephone=this.all_data.sender_detail.telephone_no;
                            this.sender_location=this.all_data.sender_detail.location;   
                            this.sender_status=this.all_data.sender_detail.status;
                            this.company_name=this.all_data.company_name;

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

        }


    })
</script>

@endsection
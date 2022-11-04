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
            border: 1px solid rgba(0, 0, 0, .125);
            color: #000;
        }

        .form-control-sm {
            height: 30px !important;
        }

        .form-group label, label {
            font-size: 12px;
            margin-bottom: 0;
        }

        .editTer .form-row {
            background: #83838315;
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

        .editTer .form-row input {
            background: #fff !important
        }

        /* <meta name="csrf-token" content="








        {{ csrf_token() }}                         " /> */
    </style>

    <div class="container" id="edit_ter">
        <div class="container statbox">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Edit Reception TERCourier</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Search ID</a></li>
                    </ol>
                </nav>
                <div id="html5-extension_filter" class="dataTables_filter d-flex align-items-center" style="gap: 8px;">
                    <label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter UN ID"
                               v-model="unique_id"
                               aria-controls="html5-extension"></label>
                    <button class="btn btn-success" v-on:click="get_data_by_id()"
                            style="height: 30px; width: 80px; padding: 0; border-radius: 8px"> @{{button_text}}
                    </button>
                </div>
            </div>

            <div class="row" style="min-height: min(60vh, 600px)">
                <div id="flFormsGrid" v-if="got_data" class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="editTer widget-content widget-content-area">

                            <div class="form-row mb-4">
                                <h6><b>Sender Details</b></h6>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">From *</label>
                                    <div>Actual Entry - @{{this.all_data.sender_detail.name}} :
                                        @{{this.all_data.sender_detail.ax_id}} :
                                        @{{this.all_data.sender_detail.employee_id}} :
                                        @{{this.all_data.sender_detail.status}}
                                    </div>
                                    <input type="text" class="form-control form-control-sm"
                                           v-on:change="get_sender_data(sender_all_info)" v-model="sender_all_info"
                                           list="sender_data"/>
                                    <datalist class="select2-selection__rendered" id="sender_data">
                                        <option v-for="sender_all_info in senders_data"
                                                :key="sender_all_info.employee_id">
                                            @{{sender_all_info.employee_id}} : @{{sender_all_info.name}} :
                                            @{{sender_all_info.ax_id}} : @{{sender_all_info.status}}
                                        </option>
                                    </datalist>
                                </div>
                                <!--------------- Date of Receipt ---------->
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Date of Receipt *</label>
                                    <div style="height: 20px;"></div>
                                    <input type="date" class="form-control form-control-sm" name="date_of_receipt"
                                           v-model="date_of_receipt">
                                </div>
                                <!--------------- end ------------------>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Location</label>
                                    <input type="text" class="form-control form-control-sm" id="location"
                                           name="location" v-model="sender_location" readonly="readonly">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Telephone No.</label>
                                    <input type="text" class="form-control mbCheckNm form-control-sm" id="telephone_no"
                                           readonly="readonly" name="telephone_no" autocomplete="off" maxlength="10"
                                           v-model="sender_telephone" type="tel">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Status</label>
                                    <input type="text" class="form-control form-control-sm" id="emp_status"
                                           name="emp_status" autocomplete="off" readonly="readonly"
                                           v-model="sender_status"/>
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Courier Details</b></h6>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Courier Name</label>
                                    <select id="slct" name="courier_id" class="form-control form-control-sm">
                                        <option selected disabled :value="this.all_data.courier_id">
                                            @{{this.all_data.courier_company.courier_name}}
                                        </option>
                                        @foreach($couriers as $courier)
                                            <option value="{{$courier->id}}"
                                                    id="courier_id">{{$courier->courier_name}}</option>
                                        @endforeach
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket No.</label>
                                    <input type="text" class="form-control form-control-sm" id="docket_no"
                                           name="docket_no" autocomplete="off" v-model="docket_no">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket Date</label>
                                    <input type="date" class="form-control form-control-sm" id="docket_date"
                                           name="docket_date" v-model="docket_date">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Document Details</b></h6>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Location</label>
                                    <input type="text" class="form-control form-control-sm location1" id="location"
                                           name="location" v-model="location">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Company Name</label>
                                    <select id="select_option" name="company_name" v-model="company_name"
                                            class="form-control form-control-sm">
                                        <option disabled selected style="background-color: #e9ecef;">
                                            @{{company_name}}
                                        </option>
                                        <option value="FMC">FMC</option>
                                        <option value="Corteva">Corteva</option>
                                        <option value="Unit-HSB">Unit-HSB</option>
                                        <option value="Remainco">Remainco</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">TER Amount *</label>
                                    <input type="text" class="form-control form-control-sm" id="amount" name="amount"
                                           v-model="amount" required>
                                </div>

                                <div class="form-group col-md-3 n-chk align-self-center">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input onchange="onChangePeriodType()" id="for_month"
                                               type="radio" class="new-control-input" name="period_type">
                                        <span class="new-control-indicator"></span>For Month
                                    </label>
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input checked="checked" onchange="onChangePeriodType()" id="for_period"
                                               type="radio" class="new-control-input" name="period_type">
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
                                    <label for="inputPassword4">TER Period From *</label>
                                    <input type="date" class="form-control form-control-sm" id="terfrom_date"
                                           required name="terfrom_date" v-model="terfrom_date">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">TER Period To *</label>
                                    <input type="date" class="form-control form-control-sm" id="terto_date"
                                           required name="terto_date" v-model="terto_date">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Other Details</label>
                                    <input type="text" class="form-control form-control-sm" id="details" name="details"
                                           v-model="details">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control form-control-sm" rows="1" cols="70"
                                              v-model="remarks"></textarea>
                                </div>

                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Handover Details</b></h6>
                                <div class="form-group col-md-6">
                                    <label for="remarks">Given To</label>
                                    <select class="form-control form-control-sm" id="given_to" name="given_to">
                                        <!-- <option value="">Select</option> -->
                                        <option value="Veena">Veena</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="remarks">Delivery Date</label>
                                    <input type="date" class="form-control form-control-sm" id="delivery_date"
                                           name="delivery_date" v-model="delivery_date">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type=" submit" class="btn btn-primary" v-on:click="update_data_ter()"
                                        :disabled="update_ter_flag" style="border-radius: 8px; width: 100px;">
                                    <span class="indicator-label">Update</span>
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
                flag: false,
                update_ter_flag: false,
                amount: "",
                senders_data: {},
                sender_all_info: "",
                sender_location: "",
                sender_telephone: "",
                sender_status: "",
                company_name: "",
                date_of_receipt: "",
                docket_date: "",
                docket_no: "",
                location: "",
                terfrom_date: "",
                terto_date: "",
                details: "",
                amount: "",
                remarks: "",
                given_to: "",
                delivery_date: "",
            },
            created: function () {
                // alert(this.got_details)
                //   alert('hello');
                this.button_text = "Search";
            },
            methods: {
                get_sender_data: function (data) {
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
                update_data_ter: function () {
                    var sender_emp_id, sender_name, ax_code, courier_id
                    courier_id = $("#slct option:selected").val();
                    if (this.sender_all_info != "") {
                        const sender_data_split = this.sender_all_info.split(" : ");
                        sender_emp_id = sender_data_split[0];
                        sender_name = sender_data_split[1];
                        ax_code = sender_data_split[2];
                    } else {
                        sender_emp_id = this.all_data.employee_id;
                        sender_name = this.all_data.sender_name;
                        ax_code = this.all_data.ax_id;
                        ;
                    }

                    axios.post('/edit_tercourier', {
                        'employee_id': sender_emp_id,
                        'date_of_receipt': this.date_of_receipt,
                        'courier_id': courier_id,
                        'docket_no': this.docket_no,
                        'docket_date': this.docket_date,
                        'location': this.location,
                        'terfrom_date': this.terfrom_date,
                        'terto_date': this.terto_date,
                        'details': this.details,
                        'amount': this.amount,
                        'remarks': this.remarks,
                        // 'given_to':this.given_to,
                        'delivery_date': this.delivery_date,
                        'unique_id': this.all_data.id,
                        'sender_name': sender_name,
                        'ax_id': ax_code,
                        'company_name': this.company_name,
                    })
                        .then(response => {
                            // console.log(response.data);
                            if (response.data) {
                                this.update_ter_flag = true;
                                swal('success', "Record has been updated Successfully!!!", 'success')
                                this.got_data = false;
                                document.getElementById("search_item").value = "";
                                this.unique_id = "";
                                this.sender_all_info = "";
                                this.all_data = {};
                            } else if (response.data == 0) {
                                this.button_text = "Search";
                                swal('error', "Record has been Already changed to Handover", 'error')
                                this.got_data = false;
                                this.unique_id = "";
                                this.sender_all_info = "";
                                this.all_data = {};
                                document.getElementById("search_item").value = "";
                            } else {
                                this.button_text = "Search";
                                this.got_data = false;
                                this.unique_id = "";
                                this.sender_all_info = "";
                                this.all_data = {};
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


                },
                get_data_by_id: function () {
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
                                if (response.data[0]) {
                                    this.got_data = true;
                                    this.flag = true;
                                    this.button_text = "Search";
                                    this.sender_all_info = "";
                                    this.all_data = response.data[0];
                                    this.amount = this.all_data.amount;
                                    this.senders_data = response.data.all_senders_data;
                                    this.sender_telephone = this.all_data.sender_detail.telephone_no;
                                    this.sender_location = this.all_data.sender_detail.location;
                                    this.sender_status = this.all_data.sender_detail.status;
                                    this.company_name = this.all_data.company_name;
                                    this.date_of_receipt = this.all_data.date_of_receipt;
                                    this.docket_date = this.all_data.docket_date;
                                    this.docket_no = this.all_data.docket_no;
                                    this.location = this.all_data.location;
                                    this.terfrom_date = this.all_data.terfrom_date,
                                        this.terto_date = this.all_data.terto_date;
                                    this.details = this.all_data.details;
                                    this.remarks = this.all_data.remarks;
                                    this.given_to = this.all_data.given_to;
                                    this.delivery_date = this.all_data.delivery_date;


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

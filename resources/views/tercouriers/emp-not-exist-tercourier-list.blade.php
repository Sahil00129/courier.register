@extends('layouts.main')
@section('title', "Unknown TER Courier List")
@section('content')
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.min.js"
            integrity="sha256-ngFW3UnAN0Tnm76mDuu7uUtYEcG3G5H1+zioJw3t+68=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vee-validate@2.2.15/dist/vee-validate.min.js"
            integrity="sha256-m+taJnCBUpRECKCx5pbA0mw4ckdM2SvoNxgPMeUJU6E=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"
            integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>

    <style>
        .btn {
            padding: 10px 10px;
            font-size: 10px;
        }

        .table > tbody > tr > th,
        .table > tbody > tr > td {
            padding: 10px;
        }

        .uid {
            display: flex;
            position: relative;
            cursor: pointer;
            width: max-content;
        }

        .uid svg {
            height: 14px;
            width: 14px;
        }

        .terDetails {
            z-index: 9999999;
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: #ffffff;
            opacity: 0;
            display: none;
            box-shadow: 0 0 17px #83838360;
            border-radius: 12px;
            padding: 10px 16px;
            backdrop-filter: blur(10px);
        }

        .terDetails p {
            margin-bottom: 0;
        }

        .terDetails:before {
            content: '';
            display: block;
            height: 12px;
            width: 12px;
            background: #ffffff;
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
        }

        .uid:hover > .terDetails {
            opacity: 1;
            display: block;

        }

        .statusButton {
            padding: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            min-width: 80px;
        }

        .statusButton svg {
            height: 14px;
            width: 14px;
        }

        .senderBlock {
            max-width: 300px;
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 4px 8px;
            border-radius: 4px;
            background: #83838320;
        }

        .senderBlock .senderName {
            width: 110px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .senderBlock .senderId,
        .senderBlock .senderLocation {
            display: flex;
            flex-flow: column;
            justify-content: center;
            width: 110px;
        }

        .senderBlock .senderId span:nth-of-type(1),
        .senderBlock .senderLocation span:nth-of-type(1) {
            font-size: 12px;
        }

        .terBlock {
            display: flex;
            align-items: center;
            gap: 1rem;
            border-radius: 4px;
            background: #83838320;
            position: relative;
            width: 170px;
            padding: 2px 8px;
        }

        .axDetails {
            border-radius: 4px;
            background: #83838320;
            position: relative;
            width: 170px;
            padding: 2px 8px;
        }

        .terBlock {
            padding: 13px 8px 2px;
        }

        .terBlock .terDates,
        .terBlock .terAmount {
            display: flex;
            flex-flow: column;
            justify-content: center;
        }

        .dates {
            font-size: 12px;
            line-height: 15px;
            padding-left: 4px;
            margin-bottom: 0;
        }

        .dates p {
            margin: 0;
        }

        .dates .amount {
            flex: 1;
        }

        .amount .heading {
            width: 60px !important;
            margin-right: 4px;
        }

        .terDate {
            position: absolute;
            top: -5px;
            font-size: 11px;
            left: 50%;
            transform: translateX(-50%);
            background: #4361ee;
            color: #fff;
            padding: 2px 6px;
            line-height: 12px;
            border-radius: 4px;
        }

        .axVouchers {
            max-height: 30px;
            overflow-y: auto;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .axVouchers .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .axVouchers::-webkit-scrollbar {
            display: none;
        }

        .action svg {
            height: 16px;
            width: 16px;
            cursor: pointer;
            transition: all 200ms ease-in-out;
        }

        .action svg:hover {
            color: #4361ee;
        }

        .form-control-sm-30px {
            height: 30px;
        }

        .form-control-sm-30 {
            height: calc(2.8em + 2px);
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


        .closeButton {
            cursor: pointer;
            position: absolute;
            right: 1rem;
            top: 1rem;
            color: #000;
            height: 20px;
            width: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50vh;
            background: #fff;
        }

        .actionButtons {
            height: 30px;
            min-width: 80px;
            border-radius: 8px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .actionButtons svg {
            height: 14px;
            width: 14px;
        }

        .searchField svg {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            height: 14px;
            width: 14px;
        }

        .searchField input {
            padding-left: 30px;
        }

        .dataTables_empty {
            padding: 5rem 0 !important;
        }
    </style>



    <!-- END PAGE LEVEL CUSTOM STYLES -->
    <div class="layout-px-spacing" id="divbox">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Employee Doesn't Exist Courier List</a>
                    </li>
                </ol>
            </nav>
        </div>


        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

            
                    <!---unknown TER's table--->
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>UN ID</th>
                            <th>Status</th>
                            <th>Dates</th>
                            <th>Sender</th>
                            <th>TER</th>
                            <th>AX Detail</th>
                        </tr>
                        </thead>
                        <tbody id="tb">
                        @if(count($tercouriers) < 1)
                            <tr>
                                <td colspan="8">
                                    <div class="d-flex justify-content-center align-items-center"
                                         style="min-height: min(45vh, 400px)">
                                        No data to display
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($tercouriers as $key => $tercourier)
                                <tr>
                                    <td width="100px">
                                        <div class="d-flex align-items-center" style="gap: 4px;">
                                           <div style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" v-on:click="open_cancel_ter_modal(<?php echo $tercourier->id ?>)"> {{ $tercourier->id }}</div>
                                            <div class="uid">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-info">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                                </svg>
                                                <div class="terDetails">
                                                    <p>Given to <strong>{{ $tercourier->given_to ?? '-' }}</strong>
                                                        on
                                                        <strong>{{ Helper::ShowFormatDate($tercourier->delivery_date) }}</strong>
                                                    </p>
                                                    <div class="courier d-flex align-items-center" style="gap: 1rem">
                                                        <p><strong>Courier
                                                                Name:</strong> {{ ucwords(@$tercourier->CourierCompany->courier_name) ?? '-' }}
                                                        </p> |
                                                        <p><strong>Docket
                                                                No.:</strong> {{ $tercourier->docket_no ?? '-' }}
                                                        </p>
                                                        |
                                                        <p><strong>Docket
                                                                Date:</strong> {{ Helper::ShowFormatDate($tercourier->docket_date) }}
                                                        </p>
                                                    </div>
                                                    <p>
                                                        <strong>Remarks:</strong> {{ ucfirst($tercourier->remarks) ?? '-' }}
                                                    </p>
                                                    <p>
                                                        <strong>Finfect
                                                            response:</strong> {{ ucfirst($tercourier->finfect_response) ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <?php
                                    if ($tercourier->employee_id == 0) {
                                        $status = 'Missing Info';
                                        $class = 'btn-danger';
                                    } elseif ($tercourier->status == 2) {
                                        $status = 'Handover';
                                        $class = 'btn-warning';
                                    }
                                    ?>

                                    <td>
                                        @if($role == "Hr Admin")
                                            <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton"
                                                    data-toggle="modal" data-target="#partialpaidModal"
                                                    v-on:click="open_ter_modal(<?php echo $tercourier->id ?>)">
                                                {{ $status }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                        @else
                                            <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton"
                                                    style="cursor: default">
                                                {{ $status }}
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="dates d-flex flex-column justify-content-center">
                                            <li>
                                                Receipt: {{ Helper::ShowFormatDate($tercourier->received_date) }}</li>
                                            <li>
                                                Book: {{ Helper::ShowFormatDate($tercourier->book_date) }}</li>
                                            <li>
                                                Paid: {{ Helper::ShowFormatDate($tercourier->paid_date) }}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="senderBlock">
                                            <div class="senderId">
                                                <span>Emp ID: {{ $tercourier->employee_id ?? '-' }}</span>
                                                <span
                                                    class="senderName">{{ ucwords(@$tercourier->sender_name) ?? '-' }}</span>
                                            </div>
                                            <div class="senderLocation">
                                                <span>AX ID - {{ $tercourier->ax_id ?? '-' }}</span>
                                                <span>{{ ucwords($tercourier->location) ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <!--ter-->
                                    <td>
                                        <div class="terBlock">
                                            <div class="terDates flex-grow-1">
                                                <span class="terDate"><strong>{{ Helper::ShowFormatDate($tercourier->terfrom_date) }} - {{ Helper::ShowFormatDate($tercourier->terto_date) }}</strong></span>
                                                <div class="dates d-flex flex-column justify-content-center">
                                                    <div
                                                        class="amount d-flex align-items-center justify-content-between ">
                                                        <div class="heading">Claimed:</div>
                                                        ₹{{ $tercourier->amount ?? '-' }}
                                                    </div>
                                                    <div
                                                        class="amount d-flex align-items-center justify-content-between ">
                                                        <div class="heading">Paid:</div>
                                                        <?php
                                                        $payableAmount = json_decode($tercourier->payable_amount);
                                                        if (is_countable($payableAmount) && count($payableAmount) > 0) {
                                                            $totalPayableAmount = array_sum($payableAmount);
                                                        }
                                                        ?>
                                                        @if(is_countable($payableAmount) && count($payableAmount) > 0)
                                                            ₹{{ $totalPayableAmount }}
                                                        @else
                                                            ₹ 0
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="amount d-flex align-items-center justify-content-between ">
                                                        <div class="heading">Deduction:</div>
                                                        @if(is_countable($payableAmount) && count($payableAmount) > 0)
                                                            ₹{{ ((int)$totalPayableAmount - (int)$tercourier->amount) }}
                                                        @else
                                                            ₹ 0
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!--ax-->
                                    <td>
                                        <div class="axDetails flex-grow-1">
                                            <div class="heading d-flex justify-content-between align-items-center"
                                                 style="font-size: 12px; font-weight: 500;">Voucher:
                                                <span>Amount</span>
                                            </div>
                                            <div class="dates d-flex flex-column justify-content-center"
                                                 style="width: 100%;">
                                                <div class="axVouchers flex-grow-1">
                                                    <div class="heading" style="min-height: 30px;">
                                                        <?php
                                                        $voucherCode = json_decode($tercourier->voucher_code);
                                                        $payableAmount = json_decode($tercourier->payable_amount);
                                                        ?>

                                                        <span class="d-flex flex-column">
                                                        @if(is_countable($voucherCode) && count($voucherCode) > 0)
                                                                @foreach($voucherCode as $voucher)
                                                                    <span>{{$voucher}}</span>
                                                                @endforeach
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                    </span>
                                                        <span class="d-flex flex-column align-items-end">
                                                        @if(is_countable($payableAmount) && count($payableAmount) > 0)
                                                                @foreach($payableAmount as $amt)
                                                                    <span>₹{{$amt}}</span>
                                                                @endforeach
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>


                    <!-- Partial Paid Modal -->
                    <div class="modal fade show" id="partialpaidModal" v-if="ter_modal" tabindex="-1" role="dialog"
                         aria-labelledby="partialpaidModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="partialpaidModalLabel"> TER ID: @{{ter_id}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                            @click="ter_modal=false;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="inputPassword4">From</label>
                                            <div>Actual Entry - @{{this.all_data.employee_id}}:
                                                @{{this.all_data.sender_name}} : @{{this.all_data.ax_id}}
                                            </div>
                                            <!-- <input type="text" class="form-control" name="from" :value="this.all_data.sender_detail.name"  disabled> -->
                                            <input type="text" class="form-control"
                                                   v-on:change="get_sender_data(sender_all_info)"
                                                   v-model="sender_all_info" list="sender_data"/>
                                            <datalist class="select2-selection__rendered" id="sender_data">
                                                <option v-for="sender_all_info in senders_data"
                                                        :key="sender_all_info.employee_id">

                                                    @{{sender_all_info.employee_id}} : @{{sender_all_info.name}} :
                                                    @{{sender_all_info.ax_id}} : @{{sender_all_info.status}}
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
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Remarks:</label>
                                            <input type="text" class="form-control" id="recipient-name"
                                                   v-model="ter_remarks">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" @click="update_emp_details()"
                                            data-dismiss="modal">Save changes
                                    </button>
                                    <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Get Passbook</button> -->
                                    <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
                                </div>

                            </div>
                        </div>
                    </div>

                      <!-- Cancel TER Modal -->
                <div class="modal fade show" id="exampleModal" v-if="cancel_ter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cancel TER</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="ter_modal=false;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label pb-0">Ter ID:</label>
                                        <input type="text" class="form-control form-control-sm" id="recipient-name" v-model="ter_id" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label pb-0">Remarks:</label>
                                        <input type="text" class="form-control form-control-sm" id="recipient-name" v-model="cancel_remarks">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" style="border-radius: 8px;" @click="cancel_ter()" data-dismiss="modal">Save changes
                                </button>
                                <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Get Passbook</button> -->
                                <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
                            </div>

                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>


    <script>
        new Vue({
            el: '#divbox',
            // components: {
            //   ValidationProvider
            // },
            data: {
                ter_modal: false,
                ter_id: "",
                ter_remarks: "",
                all_data: {},
                senders_data: "",
                sender_all_info: "",
                search_data: "",
                cancel_ter_modal:false,
                cancel_remarks:"",
            },
            created: function () {
                // alert(this.got_details)
                //   alert('hello');
            },
            methods: {
                open_cancel_ter_modal: function(ter_id) {
                this.ter_id = ter_id;
                this.cancel_ter_modal = true;
            },
            cancel_ter: function() {
                if (this.cancel_remarks != "") {
                    axios.post('/cancel_ter', {
                            'ter_id': this.ter_id,
                            'remarks': this.cancel_remarks
                        })
                        .then(response => {
                            if (response.data) {
                                swal('success', "Ter Id :" + this.ter_id + " has been cancelled", 'success')
                                location.reload();
                            } else {
                                swal('error', "System Error", 'error')
                                this.cancel_ter_modal = false;
                                this.ter_id = "";
                            }

                        }).catch(error => {

                            swal('error', error, 'error')
                            this.cancel_ter_modal = false;
                            this.ter_id = "";
                        })
                } else {
                    swal('error', "Remarks needs to be added", 'error')
                }
            },
                search_data_fn: function () {
                    var table = $('#html5-extension').DataTable();
                    table.search(this.search_data).draw();
                },
                select_all_trx: function () {
                    var x = this.$el.querySelector("#select_all");
                    var y = this.$el.querySelectorAll(".selected_box");
                    if (x.checked == true) {
                        for (var i = 0; i < y.length; i++) {
                            y[i].checked = true;
                        }
                    } else {
                        for (i = 0; i < y.length; i++) {
                            y[i].checked = false;
                        }
                    }
                },
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
                            } else {
                                swal('error', "Not able to fetch employee details", 'error')
                            }

                        }).catch(error => {
                        this.got_data = false;
                        this.update_ter_flag = false;
                        this.button_text = "Search";


                    })
                },
                get_emp_list: function () {
                    this.all_data = {};

                    //  alert(this.unique_id);

                    axios.post('/get_emp_list', {
                        'id': this.ter_id
                    })
                        .then(response => {
                            console.log(response.data)
                            // this.ter_modal = true;
                            this.all_data = response.data[0];
                            this.senders_data = response.data.all_senders_data;
                        }).catch(error => {


                    })
                },
                update_emp_details: function () {
                    if (this.ter_remarks != "" && this.sender_all_info != "") {
                        const sender_data_split = this.sender_all_info.split(" : ");
                        sender_emp_id = sender_data_split[0];
                        sender_name = sender_data_split[1];
                        ax_code = sender_data_split[2];

                        axios.post('/update_emp_details', {
                            'remarks': this.ter_remarks,
                            'emp_id': sender_emp_id,
                            'emp_name': sender_name,
                            'ax_id': ax_code,
                            'id': this.ter_id

                        })
                            .then(response => {
                                if (response.data) {
                                    swal('success', "Ter Id :" + this.ter_id + " has been successfully updated", 'success')
                                    location.reload();
                                }

                            }).catch(error => {

                            swal('error', error, 'error')
                            this.ter_modal = false;
                            this.ter_id = "";
                        })

                    } else {
                        swal('error', "Fields are Empty", 'error')
                    }
                },
                open_ter_modal: function (ter_id) {
                    this.ter_modal = true;
                    this.ter_id = ter_id;
                    this.get_emp_list();

                },
                group_pay_now: function () {
                    var x = this.$el.querySelector("#tb");
                    var box = x.querySelectorAll(".selected_box");
                    var id = "";

                    for (var i = 0; i < box.length; i++) {
                        // console.log(y[i].value);
                        if (box[i].checked) {
                            if (id == "") {
                                id += box[i].value;
                            } else {
                                id += "|" + box[i].value;
                            }
                        }
                    }


                    const id_array = id.split("|");
                    if (id_array != "") {
                        axios.post('/group_pay_now', {
                            'selected_id': id
                        })
                            .then(response => {
                                console.log(response.data);
                                if (response.data >= 1) {
                                    // alert('hello')
                                    location.reload();
                                } else {
                                    swal('error', "Either Record is already updated,not selected or greater payable amount", 'error')
                                }

                            }).catch(error => {

                            console.log(response)
                            this.apply_offer_btn = 'Apply';

                        })
                    } else {
                        swal('error', "Either Record is not selected or field is empty", 'error')
                    }

                },
                pay_now_ter: function ($id) {
                    var unique_id = $id;
                    this.ter_id = $id;
                    axios.post('/pay_later_ter_now', {
                        'selected_id': unique_id
                    })
                        .then(response => {
                            console.log(response.data);
                            if (response.data == 1) {
                                swal('success', "Ter Id :" + this.ter_id + " has been sent to Finfect for Payment", 'success')
                                location.reload();
                            } else {
                                swal('error', "System Error", 'error')
                                this.ter_id = "";
                            }

                        }).catch(error => {

                        console.log(response)
                        this.apply_offer_btn = 'Apply';

                    })

                }
            }
        })
    </script>

@endsection

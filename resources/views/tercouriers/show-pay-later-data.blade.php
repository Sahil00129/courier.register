@extends('layouts.main')
@section('title', 'Pay Later Courier List')
@section('content')
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.min.js" integrity="sha256-ngFW3UnAN0Tnm76mDuu7uUtYEcG3G5H1+zioJw3t+68=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vee-validate@2.2.15/dist/vee-validate.min.js" integrity="sha256-m+taJnCBUpRECKCx5pbA0mw4ckdM2SvoNxgPMeUJU6E=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
<style>
    .btn {
        padding: 10px 10px;
        font-size: 10px;
    }

    .table>tbody>tr>th,
    .table>tbody>tr>td {
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

    .form-control-sm-30px {
        height: 30px !important;
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

    .uid:hover>.terDetails {
        opacity: 1;
        display: block;

    }

    .statusButton {
        padding: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        width: 80px;
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

    .actionButtons {
        height: 30px;
        width: 80px;
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

    .finfectResponseDetail {
        z-index: 9999999;
        position: absolute;
        left: 100%;
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

    .finfectResponseStatus:hover+.finfectResponseDetail {
        opacity: 1;
        display: block;
    }
</style>


<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="divbox">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Pay Later Courier List</a></li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6" style="width: 100%; overflow-x: auto;">

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
                        <?php $i = 1;
                        foreach ($tercouriers as $key => $tercourier) {
                            // echo'<pre>'; print_r($tercourier);
                        ?>
                            <tr>
                                <td width="100px">
                                    <div class="d-flex align-items-center" style="gap: 4px;">
                                        {{ $tercourier->id }}
                                        <div class="uid">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                            </svg>
                                            <div class="terDetails">
                                                <p>Given to <strong>{{ $tercourier->given_to ?? '-' }}</strong> on
                                                    <strong>{{ Helper::ShowFormatDate($tercourier->delivery_date) }}</strong>
                                                </p>
                                                <div class="courier d-flex align-items-center" style="gap: 1rem">
                                                    <p><strong>Courier
                                                            Name:</strong> {{ ucwords(@$tercourier->CourierCompany->courier_name) ?? '-' }}
                                                    </p> |
                                                    <p><strong>Docket No.:</strong> {{ $tercourier->docket_no ?? '-' }}
                                                    </p>
                                                    |
                                                    <p><strong>Docket
                                                            Date:</strong> {{ Helper::ShowFormatDate($tercourier->docket_date) }}
                                                    </p>
                                                </div>
                                                <p><strong>Remarks:</strong> {{ ucfirst($tercourier->remarks) ?? '-' }}</p>
                                                <p><strong>Response from
                                                        Finfect:</strong> {{ $tercourier->finfect_response ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <?php
                                if ($tercourier->status == 1) {
                                    $status = 'Received';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 2) {
                                    $status = 'Handover';
                                    $class = 'btn-warning';
                                } elseif ($tercourier->status == 3) {

                                    $status = 'Sent to Finfect';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 4) {

                                    $status = 'Pay';
                                    $class = 'btn-success';
                                } else {
                                    $status = 'Repay';
                                    $class = 'btn-danger';
                                }
                                ?>


                                <td>
                                    @if($tercourier->status == 3 || $tercourier->status == 4)
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" v-on:click="pay_now_ter(<?php echo $tercourier->id; ?>)" value="<?php echo $tercourier->id; ?> ">
                                        {{ $status }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                    @elseif($tercourier->status == 0 || $role == "tr admin")
                                    <div style="position: relative;">
                                        <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton finfectResponseStatus" style="cursor: pointer" v-on:click="pay_now_ter(<?php echo $tercourier->id; ?>)" value="<?php echo $tercourier->id; ?>">
                                            {{ $status }}
                                        </button>
                                        <div class="finfectResponseDetail">
                                            <p>
                                                <strong>Response form Finfect:</strong> {{ ucfirst($tercourier->finfect_response) ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    @else
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" v-on:click="pay_now_ter(<?php echo $tercourier->id; ?>)" value="<?php echo $tercourier->id; ?>">
                                        {{ $status }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                    @endif
                                </td>
                                <td>
                                    <ul class="dates d-flex flex-column justify-content-center">
                                        @if($tercourier->received_date)
                                        <li>
                                            Receipt: {{ Helper::ShowFormatDate($tercourier->received_date) }}</li>@endif
                                        @if($tercourier->date_of_receipt)
                                        <li>
                                            Courier: {{ Helper::ShowFormatDate($tercourier->date_of_receipt) }}</li>@endif
                                        @if($tercourier->handover_date)
                                        <li>
                                            Handover: {{ Helper::ShowFormatDate($tercourier->handover_date) }}</li>@endif
                                    </ul>
                                </td>
                                <td>
                                    <div class="senderBlock">
                                        <div class="senderId">
                                            <span>Emp ID: {{ $tercourier->employee_id ?? '-' }}</span>
                                            <span class="senderName">{{ ucwords(@$tercourier->sender_name) ?? '-' }}</span>
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
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Claimed:</div>
                                                    ₹{{ $tercourier->amount ?? '-' }}
                                                </div>
                                                <div class="amount d-flex align-items-center justify-content-between ">
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
                                                <div class="amount d-flex align-items-center justify-content-between ">
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
                                        <div class="heading d-flex justify-content-between align-items-center" style="font-size: 12px; font-weight: 500;">Voucher: <span>Amount</span>
                                        </div>
                                        <div class="dates d-flex flex-column justify-content-center" style="width: 100%;">
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

                        <?php } ?>
                    </tbody>

                </table>

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
            unique_amount_id: "",
            unique_coupon_id: "",
        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
        },
        methods: {
            select_all_trx: function() {
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

            group_pay_now: function() {
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


            pay_now_ter: function($id, ) {
                var unique_id = $id;

                axios.post('/pay_later_ter_now', {
                        'selected_id': unique_id
                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data == 1) {

                            location.reload();
                        } else if (response.data === "bank_details_missing") {
                            swal('error', "Bank Details are missing for this TER", 'error')
                        } else if (response.data === "pfu_missing") {
                            swal('error', "PFU is not available for this TER", 'error')
                        } else if (response.data === "ax_id_missing") {
                            swal('error', "AX-ID/IAG Code is not available for this TER", 'error')
                        } else {
                            swal('error', response.data[1], 'error')
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
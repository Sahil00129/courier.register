@extends('layouts.main')
@section('title', 'Courier List')
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

    .floatingButton {
        border-radius: 12px;
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        font-size: 1rem;
        display: flex;
        font-weight: 500;
        justify-content: center;
        align-items: center;
        height: 50px;
        width: 50px;
        overflow: hidden;
        transition: all 300ms ease-in-out;
    }

    .floatingButton span.text {
        display: none;
        white-space: nowrap;
        opacity: 0;
        transform: translateX(10px);
        transition: all 200ms ease-in-out;
    }

    .floatingButton:hover {
        width: 140px;
    }

    .floatingButton:hover span.text {
        margin-left: 8px;
        opacity: 1;
        display: inline-flex;
        transform: translateX(0px);
        transition: opacity 300ms ease-in-out, transform 200ms ease-in-out;
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
</style>


<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="divbox">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Courier List</a></li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">

                <!---searchbar--->
                <div class="d-flex justify-content-between align-items-center px-4 py-4" style="gap: 1rem;">
                    <div class="d-flex align-items-center" style="gap: 1rem;">
                        @if ($role != 'Tr Admin')
                        <button class="actionButtons btn btn-success" v-on:click="change_to_handover()">
                            Handover
                        </button>
                        @endif
                        <button class="actionButtons btn btn-success" @click="download_ter_list()">
                            Excel
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="searchField" style="width: 200px; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="search" class="form-control form-control-sm form-control-sm-30px" placeholder="Search..." aria-controls="html5-extension" v-model="search_data" style="padding-left: 30px" v-on:change="test()">
                    </div>
                </div>

                @if ($role === 'Tr Admin')

                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all" v-on:click="select_all_trx()" /></th>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Dates</th>
                            <th>Sender</th>
                            <th>TER</th>
                            <th>AX Detail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tb">
                        @if(count($tercouriers) < 1) <tr>
                            <td colspan="8">
                                <div class="d-flex justify-content-center align-items-center" style="min-height: min(45vh, 400px)">
                                    No data to display
                                </div>
                            </td>
                            </tr>
                            @else
                            @foreach ($tercouriers as $key => $tercourier)
                            <tr>
                                <td style="padding: 10px 21px;">
                                    <input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box" value="<?php echo $tercourier->id; ?>">
                                </td>
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
                                } elseif ($tercourier->status == 5) {
                                    $status = 'Paid';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 6) {
                                    $status = 'Cancel';
                                    $class = 'btn-danger';
                                } elseif ($tercourier->status == 7) {
                                    $status = 'Partially Paid';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 8) {
                                    $status = 'Rejected';
                                    $class = 'btn-danger';
                                } else {
                                    $status = 'Failed';
                                    $class = 'btn-danger';
                                }
                                ?>


                                <td>
                                    @if($tercourier->status == 0 || $tercourier->status == 1 || $tercourier->status == 2)
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" data-toggle="modal" data-target="#exampleModal" v-on:click="open_ter_modal(<?php echo $tercourier->id ?>)">
                                        {{ $status }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                    @elseif($tercourier->status == 5)
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" data-toggle="modal" data-target="#partialpaidModal" v-on:click="open_partial_paid_modal(<?php echo $tercourier->id ?>)">
                                        {{ $status }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                    @else
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                        {{ $status }}
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
                                        <div class="heading d-flex justify-content-between align-items-center" style="font-size: 12px; font-weight: 500;">Voucher:
                                            <span>Amount</span>
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

                                <td>
                                    <div class="action d-flex justify-content-center align-items-center">
                                        <a href="{{url('/update_ter')}}" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                    </tbody>
                </table>

                {{--
                            <table id="html5-extensio" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                <tr>
                                    <th>UN IDs</th>
                                    <th>Status</th>
                                    <th>Date of Receipt</th>
                                    <th>Sender Name</th>
                                    <th>AX ID</th>
                                    <th>Employee ID</th>
                                    <th>Location</th>
                                    <th>Company Name</th>
                                    <th>TER Amount</th>
                                    <th>TER Period From</th>
                                    <th>TER Period To</th>
                                    <th>Handover Date</th>
                                    <th>Courier Name</th>
                                    <th>Docket No</th>
                                    <th>Docket Date</th>
                                    <th>AX Payble Amount</th>
                                    <th>AX Voucher Code</th>
                                    <!-- <th> <input type="checkbox" id="select_all" v-on:click="select_all_trx()" style="zoom: 2" />
                                </th>
                                <th>Action</th> -->


                                    <!-- <th class="dt-no-sorting">Actions</th> -->
                                </tr>
                                </thead>
                                <tbody id="tb">
                                <?php $i = 1;
                                foreach ($tercouriers as $key => $tercourier) {
                                    // echo'<pre>'; print_r($tercourier);
                                ?>
                                <tr>
                                    <?php if ($tercourier->status == 1 || $tercourier->status == 2 || $tercourier->status == 0) { ?>
                                    <td style="cursor:pointer" data-toggle="modal" data-target="#exampleModal"
                                        v-on:click="open_ter_modal(<?php echo $tercourier->id ?>)">{{ $tercourier->id }}</td>
            <?php } else if ($tercourier->status == 5) { ?>
                <td style="cursor:pointer" data-toggle="modal" data-target="#partialpaidModal" v-on:click="open_partial_paid_modal(<?php echo $tercourier->id ?>)">{{ $tercourier->id }}</td>
            <?php } else { ?>
                <td>{{ $tercourier->id }}</td>
            <?php } ?>
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
                                    } elseif ($tercourier->status == 5) {

                                        $status = 'Paid';
                                        $class = 'btn-success';
                                    } elseif ($tercourier->status == 6) {

                                        $status = 'Cancel';
                                        $class = 'btn-danger';
                                    } elseif ($tercourier->status == 7) {

                                        $status = 'Partially Paid';
                                        $class = 'btn-success';
                                    } elseif ($tercourier->status == 8) {

                                        $status = 'Rejected';
                                        $class = 'btn-danger';
                                    } else {
                                        $status = 'Failed';
                                        $class = 'btn-danger';
                                    }
            ?>
            <td>

                <span class="btn {{ $class }}">{{ $status }}</span>


            </td>
            <td>{{ Helper::ShowFormatDate($tercourier->date_of_receipt) }}</td>
            <td>{{ ucwords(@$tercourier->sender_name) ?? '-' }}</td>
            <td>{{ $tercourier->ax_id ?? '-' }}</td>
            <td>{{ $tercourier->employee_id ?? '-' }}</td>
            <td>{{ ucwords($tercourier->location) ?? '-' }}</td>
            <td>{{ $tercourier->company_name ?? '-' }}</td>
            <td>{{ $tercourier->amount ?? '-' }}</td>
            <td>{{ Helper::ShowFormatDate($tercourier->terfrom_date) }}</td>
            <td>{{ Helper::ShowFormatDate($tercourier->terto_date) }}</td>
            <td>{{ Helper::ShowFormatDate($tercourier->delivery_date) }}</td>
            <td>{{ ucwords(@$tercourier->CourierCompany->courier_name) ?? '-' }}</td>
            <td>{{ $tercourier->docket_no ?? '-' }}</td>
            <td>{{ Helper::ShowFormatDate($tercourier->docket_date) }}</td>
            <td>{{ $tercourier->payable_amount ?? '-' }}</td>
            <td>{{ $tercourier->voucher_code ?? '-' }}</td>

            </tr>
        <?php } ?>
        </tbody>


        </table>
        --}}

        @else
        <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all" v-on:click="select_all_trx()" /></th>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Dates</th>
                    <th>Sender</th>
                    <th>TER</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tb">

                <?php $i = 1;
                foreach ($tercouriers as $key => $tercourier) {
                    // dd($tercourier)
                ?>
                    <tr>
                        <td style="padding: 10px 21px;">
                            <input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box" value="<?php echo $tercourier->id; ?>">
                        </td>
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
                                        <p><strong>Remarks:</strong> {{ ucfirst($tercourier->remarks) ?? '-' }}
                                        </p>
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
                        } elseif ($tercourier->status == 8) {
                            $status = 'Handover';
                            $class = 'btn-warning';
                        } elseif ($tercourier->status == 3) {
                            $status = 'Unpaid';
                            $class = 'btn-success';
                        } elseif ($tercourier->status == 6) {
                            $status = 'Cancel';
                            $class = 'btn-danger';
                        } else {
                            $status = 'Cancel';
                            $class = 'btn-danger';
                        }

                        ?>

                        <td>
                            @if($tercourier->status == 0 || $tercourier->status == 1)
                            <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" data-toggle="modal" data-target="#exampleModal" v-on:click="open_ter_modal(<?php echo $tercourier->id ?>)">
                                {{ $status }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                            @else
                            <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                {{ $status }}
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
                                    </div>
                                </div>
                            </div>
                        </td>
                        @if ($role == 'reception' && $tercourier->status== 1)
                        <td>
                            <div class="action d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" data-toggle="modal" data-target="#editTerModal" v-on:click="get_data_by_id(<?php echo $tercourier->id ?>)">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </div>
                        </td>
                        @else
                        <td>
                            <div class="action d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" v-on:click="get_data_by_id('not_allowed')">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </div>
                        </td>
                        @endif
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="{{url('tercouriers/create')}}" class="floatingButton btn btn-lg btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span class="text">TER Courier</span>
        </a>
        @endif

        <div class="d-flex justify-content-between align-items-start px-3">
            <div class="d-flex align-items-center" style="width: 200px; gap: 4px;">
                Rows on page:
                <select id="month" class=" form-control form-control-sm form-control-sm-30px" onchange="setRowsOnPage(this.value)" style="width: 80px">
                    <option selected value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade show" id="exampleModal" v-if="ter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <!-- Partial Paid Modal -->
        <div class="modal fade show" id="partialpaidModal" v-if="partial_paid_modal" tabindex="-1" role="dialog" aria-labelledby="partialpaidModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="partialpaidModalLabel">Partial Paid - TER ID:
                            @{{ter_id}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="partial_paid_modal=false;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label pb-0">Remarks:</label>
                                <input type="text" class="form-control form-control-sm" id="recipient-name" v-model="partial_remarks">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label pb-0">Payable
                                    Amount</label>
                                <input type="number" class="form-control form-control-sm" id="recipient-name" v-model="payable_amount">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label pb-0">Voucher Code</label>
                                <input type="text" class="form-control form-control-sm" id="recipient-name" v-model="voucher_code">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label pb-0">Upload File</label>
                                <input type="file" accept=".jpg,.pdf" class="form-control-file  form-control-file-sm" id="fileupload" v-on:change="upload_file($event)">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="update_payment()" data-dismiss="modal" style="border-radius: 8px;">Save changes
                        </button>
                        <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Get Passbook</button> -->
                        <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
                    </div>

                </div>
            </div>
        </div>

        <!-- Edit Reception TER Modal -->
        <div class="modal fade show" id="editTerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document" style="min-width: min(90%, 1100px)">
                <div class="modal-content" style="position: relative;">
                    <div class="editTer modal-body editTer" v-if="data_loaded">

                        <h3 style="text-align: center; font-size: 18px; font-weight: 700;">Update TER</h3>

                        <div class="form-row mb-4">
                            <h6><b>Sender Details</b></h6>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">From *</label>

                                <div>Actual Entry - @{{this.all_data.sender_detail.name}}
                                    @{{this.all_data.sender_detail.ax_id}}
                                    @{{this.all_data.sender_detail.employee_id}}
                                    @{{this.all_data.sender_detail.status}}
                                </div>
                                <input type="text" class="form-control form-control-sm" v-on:change="get_sender_data(sender_all_info)" v-model="sender_all_info" list="sender_data" />
                                <datalist class="select2-selection__rendered" id="sender_data">
                                    <option v-for="sender_all_info in senders_data" :key="sender_all_info.employee_id">
                                        @{{sender_all_info.employee_id}} : @{{sender_all_info.name}} :
                                        @{{sender_all_info.ax_id}} : @{{sender_all_info.status}}
                                    </option>
                                </datalist>
                            </div>

                            <!--------------- Date of Receipt ---------->
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Date of Receipt *</label>
                                <div style="height: 20px;"></div>
                                <input type="date" class="form-control form-control-sm" name="date_of_receipt" v-model="date_of_receipt">
                            </div>
                            <!--------------- end ------------------>

                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Location</label>
                                <input type="text" class="form-control form-control-sm" id="location" name="location" v-model="sender_location" readonly="readonly">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Telephone No.</label>
                                <input type="text" class="form-control mbCheckNm form-control-sm" id="telephone_no" v-model="sender_telephone" readonly="readonly" name="telephone_no" autocomplete="off" maxlength="10" type="tel">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Status</label>
                                <input type="text" class="form-control form-control-sm" id="emp_status" v-model="sender_status" name="emp_status" autocomplete="off" readonly="readonly" />
                            </div>
                        </div>

                        <div class="form-row mb-4">
                            <h6><b>Document Details</b></h6>
                            <div class="form-group col-md-4">
                                <label for="inputState">Location</label>
                                <input type="text" class="form-control form-control-sm location1" id="location" name="location" v-model="location">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">Company Name</label>
                                <select id="select_option" name="company_name" class="form-control form-control-sm" v-model="company_name">
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
                                <input type="text" class="form-control form-control-sm" id="amount" name="amount" v-model="amount" required>
                            </div>

                            <div class="form-group col-md-3 n-chk align-self-center">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input v-on:change="onChangePeriodType()" id="for_month" type="radio" class="new-control-input" name="period_type">
                                    <span class="new-control-indicator"></span>For Month
                                </label>
                                <label class="new-control new-radio radio-classic-primary">
                                    <input checked="checked" v-on:change="onChangePeriodType()" id="for_period" type="radio" class="new-control-input" name="period_type">
                                    <span class="new-control-indicator"></span>For Period
                                </label>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="month">Select Month</label>
                                <select disabled="true" id="month" class=" form-control form-control-sm" v-on:change="onSelectMonth()">
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
                                <input type="date" class="form-control form-control-sm" id="terfrom_date" required name="terfrom_date" v-model="terfrom_date">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">TER Period To *</label>
                                <input type="date" class="form-control form-control-sm" id="terto_date" required name="terto_date" v-model="terto_date">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Other Details</label>
                                <input type="text" class="form-control form-control-sm" id="details" name="details" v-model="details">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="remarks">Remarks</label>
                                <textarea name="remarks" class="form-control form-control-sm form-control-sm-30" rows="1" cols="70" v-model="remarks"></textarea>
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
                                    <option value="{{$courier->id}}" id="courier_id">{{$courier->courier_name}}</option>
                                    @endforeach
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Docket No.</label>
                                <input type="text" class="form-control form-control-sm" id="docket_no" v-model="docket_no" name="docket_no" autocomplete="off">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Docket Date</label>
                                <input type="date" class="form-control form-control-sm" id="docket_date" name="docket_date" v-model="docket_date">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type=" submit" class="btn btn-primary" style="width: 100px" @click="update_data_ter">
                                <span class="indicator-label">Save</span>
                                </span>
                            </button>
                        </div>

                    </div>
                    <div style="min-height: 90vh;" v-else class="d-flex justify-content-center align-items-center">
                        Loading...
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="closeButton feather feather-x-circle" data-dismiss="modal" aria-label="Close">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
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
            unique_amount_id: "",
            unique_coupon_id: "",
            ter_modal: false,
            partial_paid_modal: false,
            ter_id: "",
            cancel_remarks: "",
            diff_amount: "",
            partial_remarks: "",
            payable_amount: "",
            voucher_code: "",
            file: "",
            actual_amount: "",
            prev_payable_sum: "",
            button_text: "",
            got_data: false,
            all_data: {},
            flag: "",
            update_ter_flag: false,
            payable_amount: "",
            voucher_code: "",
            unique_id: "",
            sender_all_info: "",
            amount: "",
            senders_data: "",
            sender_telephone: "",
            sender_location: "",
            sender_status: "",
            company_name: "",
            date_of_receipt: "",
            docket_date: "",
            docket_no: "",
            location: "",
            terfrom_date: "",
            terto_date: "",
            details: "",
            remarks: "",
            given_to: "",
            delivery_date: "",
            data_loaded: false,
            url: "",
            search_data: "",


        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
            // var table=$('#html5-extension');
            // table.dataTable({dom : 'lrt'});
            // $('table').dataTable({bFilter: false, bInfo: false});
        },
        methods: {
            test: function() {
                var table = $('#html5-extension').DataTable();
                table.search(this.search_data).draw();
            },
            onSelectMonth: function() {
                const selectedMonth = document.getElementById('month').value
                const currentYear = new Date().getFullYear()
                if (selectedMonth == 1 || selectedMonth == 3 || selectedMonth == 5 || selectedMonth == 7 || selectedMonth == 8 || selectedMonth == 10 || selectedMonth == 12) {
                    this.terfrom_date = `${currentYear}-${selectedMonth}-01`;
                    this.terto_date = `${currentYear}-${selectedMonth}-31`;
                } else if (selectedMonth == 2) {
                    this.terfrom_date = `${currentYear}-${selectedMonth}-01`;
                    this.terto_date = `${currentYear}-${selectedMonth}-28`;
                } else {
                    this.terfrom_date = `${currentYear}-${selectedMonth}-01`;
                    this.terto_date = `${currentYear}-${selectedMonth}-30`;
                }
            },
            onChangePeriodType: function() {
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
            },
            update_data_ter: function() {
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
                    ax_code = this.all_data.ax_id;;
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
                            // alert(this.unique_id)
                            dt.row(0).cells().invalidate().render()
                            this.update_ter_flag = true;
                            swal('success', "Record has been updated Successfully!!!", 'success')
                            this.got_data = false;
                            document.getElementById("search_item").value = "";

                            this.sender_all_info = "";
                            this.all_data = {};
                            this.unique_id = "";
                            // $('#html5-extension').DataTable().response.data.reload();
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

                        // console.log(error)
                        // return 1;
                        this.button_text = "Search";
                        this.got_data = false;
                        document.getElementById("search_item").value = "";
                        this.unique_id = "";
                        this.sender_all_info = "";


                    })


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
            update_payment: function() {
                if (this.partial_remarks != "" && this.voucher_code != "" && this.payable_amount != "" && this.file != null) {
                    if (parseInt(this.diff_amount) >= this.payable_amount) {
                        const config = {
                            headers: {
                                'content-type': 'multipart/form-data',
                            }
                        }
                        let formData = new FormData();
                        formData.append('file', this.file);
                        formData.append('ter_id', this.ter_id);
                        formData.append('remarks', this.partial_remarks);
                        formData.append('voucher_code', this.voucher_code);
                        formData.append('payable_amount', this.payable_amount);
                        formData.append('actual_amount', this.actual_amount);
                        formData.append('prev_payable_sum', this.prev_payable_sum);
                        formData.append('left_amount', this.diff_amount);


                        axios.post('/update_ter_deduction', formData, config)
                            .then(response => {
                                if (response.data[0] === "duplicate_voucher") {
                                    swal('error', "Voucher Code : " + response.data[1] + " has been Already used", 'error')
                                } else if (response.data) {
                                    swal('success', "Ter Id :" + this.ter_id + " has been sent to HR for payment", 'success')
                                    location.reload();
                                } else {
                                    swal('error', "System Error", 'error')
                                    this.partial_paid_modal = false;
                                    this.ter_id = "";
                                    location.reload();
                                }

                            }).catch(error => {

                                swal('error', error, 'error')
                                this.partial_paid_modal = false;
                                this.ter_id = "";
                            })
                    } else {
                        swal('error', "Payable Amount = " + this.payable_amount + " can't be greater than Total Amount = " + this.diff_amount, 'error')
                    }
                } else {
                    swal('error', "Fields are Empty", 'error')
                }
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
                                this.ter_modal = false;
                                this.ter_id = "";
                            }

                        }).catch(error => {

                            swal('error', error, 'error')
                            this.ter_modal = false;
                            this.ter_id = "";
                        })
                } else {
                    swal('error', "Remarks needs to be added", 'error')
                }
            },
            upload_file(e) {
                this.file = e.target.files[0];
            },
            open_ter_modal: function(ter_id) {
                this.ter_id = ter_id;
                this.ter_modal = true;
            },
            open_partial_paid_modal: function(ter_id) {
                this.partial_paid_modal = true;
                this.ter_id = ter_id;
                axios.post('/check_deduction', {
                        'ter_id': this.ter_id,
                    })
                    .then(response => {
                        if (response.data[0] == "success") {
                            this.diff_amount = response.data[1];
                            this.actual_amount = response.data[2];
                            this.prev_payable_sum = response.data[3];
                        } else {
                            swal('error', "All dues are paid", 'error')
                            this.partial_paid_modal = false;
                            $('#partialpaidModal').modal('hide');
                        }
                        this.partial_remarks = "";
                        this.payable_amount = "";
                        this.voucher_code = "";
                        document.getElementById("fileupload").value = "";

                    }).catch(error => {

                        swal('error', error, 'error')
                        this.ter_modal = false;
                        this.ter_id = "";
                    })
                // this.partial_paid_modal = true;
            },
            get_data_by_id: function(id) {
                this.unique_id = id;
                if (this.unique_id == "not_allowed") {
                    swal('error', "This is not allowed", 'error')
                    return 1;
                }
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
                            this.data_loaded = true;
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
                            this.data_loaded = false;
                            swal('error', "Either Details already updated or No record Found", 'error')
                        }

                    }).catch(error => {
                        this.got_data = false;
                        this.flag = false;
                        this.update_ter_flag = false;
                        this.button_text = "Search";
                        this.data_loaded = false;


                    })
            },

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

            change_to_unpaid: function() {
                var x = this.$el.querySelector("#tb");
                var box = x.querySelectorAll(".selected_box");
                var y = x.querySelectorAll(".voucher_code");
                var z = x.querySelectorAll(".amount");
                var total_amount = x.querySelectorAll(".tamount");
                var id = "";
                var final_total = "";

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

                var coupon = "";
                var amount = "";

                for (var i = 0; i < y.length; i++) {
                    //   alert(y[i].value);

                    if (y[i].value != "") {
                        if (coupon == "") {
                            coupon += y[i].value;
                        } else {
                            coupon += "|" + y[i].value;
                        }
                    }
                }

                for (var i = 0; i < z.length; i++) {
                    // console.log(z[i].value);
                    if (z[i].value != "") {
                        if (amount == "") {
                            amount += z[i].value;
                        } else {
                            amount += "|" + z[i].value;
                        }
                    }
                }

                const myArray1 = amount.split("|");
                const myArray2 = coupon.split("|");
                const myArray3 = id.split("|");
                if (myArray1 != "" && myArray2 != "" && myArray3 != "") {
                    if (myArray1.length === myArray2.length && myArray2.length === myArray3.length) {
                        axios.post('/add_multiple_data', {
                                'coupon_code': coupon,
                                'amount': amount,
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
                } else {
                    swal('error', "Either Record is not selected or field is empty", 'error')
                }

            },
            
            download_ter_list: function() {

                axios.get('/download_ter_list', {

                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data == 1) {
                            this.url = '/download_ter_full_list';
                            window.location.href = this.url;
                        } else {
                            this.url = '/download_reception_list';
                            window.location.href = this.url;
                        }

                    }).catch(error => {

                        console.log(response)
                        this.apply_offer_btn = 'Apply';

                    })
            },

            change_to_handover: function() {
                var x = this.$el.querySelector("#tb");
                var y = x.querySelectorAll(".selected_box");
                var trx_str = "";

                for (var i = 0; i < y.length; i++) {
                    // console.log(y[i].value);
                    if (y[i].checked) {
                        if (trx_str == "") {
                            trx_str += y[i].value;
                        } else {
                            trx_str += "|" + y[i].value;
                        }
                    }
                }
                // alert(trx_str)

                axios.post('/change_status', {
                        'selected_value': trx_str
                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data >= 1) {
                            location.reload();
                        } else {
                            swal('error', "Either Record is already updated or not selected", 'error')
                        }

                    }).catch(error => {

                        console.log(response)
                        this.apply_offer_btn = 'Apply';

                    })
            },

            check_amount_id: function($value) {
                this.unique_amount_id = $value;
            },
            check_coupon_id: function($value) {
                this.unique_coupon_id = $value;
            },

            add_details: function($id, $total_amount) {
                var unique_id = $id;
                var x = this.$el.querySelector("#tb");
                var y = x.querySelectorAll(".voucher_code");
                var z = x.querySelectorAll(".amount");


                var coupon = "";
                var amount = "";
                try {
                    coupon = document.getElementById("voucher_code").value;
                    amount = document.getElementById("amount").value;
                } catch {
                    swal('error', "This Operation can not be done", 'error')
                }
                // alert($total_amount);
                // alert(amount)
                // return $total_amount;
                if ($total_amount >= amount) {
                    if (amount != "" && coupon != "") {

                        if (this.unique_amount_id === this.unique_coupon_id && this.unique_amount_id === unique_id) {
                            axios.post('/add_data', {
                                    'coupon_code': coupon,
                                    'amount': amount,
                                    'selected_id': unique_id
                                })
                                .then(response => {
                                    console.log(response.data);
                                    if (response.data >= 1) {
                                        amount = "";
                                        coupon = "";
                                        location.reload();
                                    } else {
                                        swal('error', "Either Record is already updated or not selected", 'error')
                                    }

                                }).catch(error => {

                                    console.log(response)
                                    this.apply_offer_btn = 'Apply';

                                })
                        } else {
                            swal('error', "This operation can't be done", 'error')
                        }
                    } else {
                        swal('error', "This operation can't be done", 'error')
                    }
                } else {
                    swal('error', "Amount can't be greater than total amount", 'error')
                }

            }
        }
    })
</script>

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

    function setRowsOnPage(rows) {
        alert(rows)
    }
</script>

@endsection
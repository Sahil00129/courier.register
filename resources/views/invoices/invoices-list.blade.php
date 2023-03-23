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
        min-width: 80px;
    }

    .statusButton svg {
        height: 14px;
        width: 14px;
    }

    .senderBlock {
        max-width: 165px;
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
        width: 130px;
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
        padding: 13px 4px 2px;
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
        width: 46px !important;
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
        min-width: 80px;
        border-radius: 8px;
        padding: 0 8px;
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
                <li class="breadcrumb-item"><a href="javascript:void(0);">Courier List</a></li>
            </ol>
        </nav>
    </div>


    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6" style="width: 100%; overflow-x: auto;">

                <!---searchbar--->
                <div class="d-flex justify-content-between align-items-center px-4 py-4" style="gap: 1rem;">
                    <div class="d-flex align-items-center" style="gap: 1rem;">
                        @if ($role == 'reception')
                        <button class="actionButtons btn btn-success" v-on:click="change_to_handover()">
                            Handover
                        </button>
                        <button class="actionButtons btn btn-success" v-on:click="redirect_to_ter()">
                            Ter List
                        </button>
                        @endif

                        @if ($role == 'sourcing')
                        <button class="actionButtons btn btn-success" v-on:click="handover_invoices_document('sourcing')">
                            Handover to Accounts
                        </button>
                        @endif

                        @if ($role == 'accounts')
                        <button class="actionButtons btn btn-success" v-on:click="handover_invoices_document('accounts')">
                            Handover to Scanning
                        </button>
                        @endif

                        @if(false)
                        <button class="actionButtons btn btn-success" @click="download_ter_list()" v-if="ter_full_excel">
                            Excel
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </button>
                        <button class="actionButtons btn btn-success" @click="download_ter_status_list()" v-if="!ter_full_excel">
                            Excel
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </button>
                        @endif
                    </div>
                    <div class="d-flex align-items-center" style="gap: 6px;">
                        <div class="form-group form-group-sm mb-0">
                            <select id="itype" class="form-control form-control-sm form-control-sm-30px" style="width: 150px;" v-model="searched_status" @change="get_filter_status_data()">
                                <option selected value="all">All</option>
                                @if($role =="reception")<option value="1"> Received at Reception</option>@endif
                                <option value="11">Handover to Sourcing</option>
                                <option value="2">Received at Sourcing</option>
                                <option value="3">Verified at Sourcing</option>
                                <option value="4">Handover to Accounts</option>
                                <option value="5">Unpaid</option>
                                <option value="6">Paid</option>
                                <option value="7">Handover to Scanning</option>
                                <option value="8">Received at Scanning</option>
                                <option value="9">Invoice Scanned</option>
                                <!-- <option value="fail">Failed</option> -->
                            </select>
                        </div>
                        <div class="searchField" style="width: 200px; position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="hidden" id="ter_role" value="<?php echo $role ?>" />
                            <input class="form-control form-control-sm form-control-sm-30px" id="searchedInput" placeholder="Search..." v-model="search_data" style="padding-left: 30px" v-on:keyup.enter="get_searched_invoice()" v-on:keyup="clear_search()">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center" id="cover-spin" v-if="loader">
                </div>



                <table id="html5-extensio" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            @if($role== "reception" || $role== "sourcing" || $role== "accounts" )
                            <th><input type="checkbox" id="select_all" v-on:click="select_all_trx()" /></th>
                            @endif
                            <th>UN ID</th>
                            <th>Status</th>
                            <th>Dates</th>
                            <th>Sender</th>
                            <th>Doc Details</th>
                            <th>PO Details</th>
                            <th>Payments</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tb" v-if="!search_flag">
                        <?php $i = 1;
                        foreach ($tercouriers as $key => $tercourier) {
                            // dd($tercourier)
                        ?>
                            <tr>
                                @if($role== "reception")    
                                <td style="padding: 10px 21px;">
                                @if($tercourier->status == 1)
                                    <input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box" value="<?php echo $tercourier->id; ?>">
                                @else <input type="checkbox" disabled>
                                @endif
                                </td>
                                @endif

                                @if($role == "sourcing")
                                <td style="padding: 10px 21px;">
                                    @if($tercourier->status == 3)
                                    <input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box" value="<?php echo $tercourier->id; ?>">
                                    @else <input type="checkbox" disabled>
                                    @endif
                                </td>
                                @endif
                                @if($role == "accounts")
                                <td style="padding: 10px 21px;">
                                    @if($tercourier->status == 6)
                                    <input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box" value="<?php echo $tercourier->id; ?>">
                                    @else <input type="checkbox" disabled>
                                    @endif
                                </td>
                                @endif
                                <td width="100px">
                                    <div class="d-flex align-items-center" style="gap: 4px;">
                                        {{ $tercourier->id }}

                                        <!-- <div class="uid">
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
                                                <p><strong>Remarks:</strong> {{ ucfirst($tercourier->sourcing_remarks) ?? '-' }}
                                                </p>
                                                <p><strong>Time taken:</strong> {{ $tercourier->recp_entry_time ?? '-' }} hrs
                                                </p>
                                            </div>
                                        </div> -->

                                    </div>
                                </td>
                                <?php

                                if ($tercourier->status == 1) {
                                    $status = 'Received at Recption';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 11) {
                                    $status = 'Handover to Sourcing';
                                    $class = 'btn-warning';
                                } elseif ($tercourier->status == 2) {
                                    $status = 'Received at Sourcing';
                                    $class = 'btn-warning';
                                } elseif ($tercourier->status == 3) {
                                    $status = 'Verified at Sourcing';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 4) {
                                    $status = 'Handover to Accounts';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 5) {
                                    $status = 'Unpaid';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 6) {
                                    $status = 'Paid';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 7) {
                                    $status = 'Handover to Scanning';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 8) {
                                    $status = 'Received at Scanning';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 9) {
                                    $status = 'Invoice Scanned';
                                    $class = 'btn-success';
                                } else {
                                    $status = 'Failed';
                                    $class = 'btn-danger';
                                }
                                ?>

                                <td>
                                    @if(!empty($tercourier->HandoverDetail) && $tercourier->status == 1 )
                                    @if($tercourier->status == 1 && $tercourier->HandoverDetail->handover_remarks!="")
                                    <div style="position: relative;">
                                        <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" style="cursor: pointer" >
                                            {{ $status }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                    </div>
                                    @elseif($tercourier->status == 11 )
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton">
                                        {{ $status }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                    @endif
                                    @elseif($tercourier->status == 0 || $tercourier->status == 1)
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton">
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
                                            Recieved: {{ Helper::ShowFormatDate($tercourier->received_date) }}</li>@endif

                                        @if($tercourier->date_of_receipt)
                                        <li>
                                            Entry: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Helper::ShowFormatDate($tercourier->date_of_receipt) }}</li>@endif

                                        @if($tercourier->handover_date)
                                        <li>
                                            Handover: {{ Helper::ShowFormatDate($tercourier->handover_date) }}</li>@endif
                                    </ul>
                                </td>

                                <!-- sender details -->
                                <td>
                                    <div class="senderBlock flex-wrap" style="gap: 0">
                                        <div class="senderId" style="width: 100%">
                                            <span class="senderName">{{ ucwords(@$tercourier->sender_name) ?? '-' }}</span>
                                        </div>
                                        <div class="senderLocation flex-row justify-content-start" style="gap: 8px">
                                            <span>ERP - {{ $tercourier->employee_id ?? '-' }} / {{ ucwords($tercourier->pfu) ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!--doc-->
                                <td>
                                    <div class="terBlock">
                                        <div class="terDates flex-grow-1">
                                            <span class="terDate"><strong>{{ $tercourier->invoice_no }}</strong></span>
                                            <div class="dates d-flex flex-column justify-content-center">
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Date:</div>
                                                    {{ $tercourier->invoice_date ?? '-' }}
                                                </div>
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Amount:</div>
                                                    ₹{{ $tercourier->basic_amount ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!--po-->
                                <td>
                                    <div class="terBlock">
                                        <div class="terDates flex-grow-1">
                                            <span class="terDate"><strong>{{ $tercourier->PoDetail->po_number }}</strong></span>
                                            <div class="dates d-flex flex-column justify-content-center">
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Date:</div>
                                                    {{ DateTime::createFromFormat("Y-m-d H:i:s",$tercourier->PoDetail->created_at)->format("d/m/Y") ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!--payment details-->
                                <td>
                                    <div class="terBlock" style="padding: 4px 8px;">
                                        <div class="terDates flex-grow-1">
                                            <div class="dates d-flex flex-column justify-content-center">
                                            <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Paid:</div>
                                                    ₹{{ $tercourier->total_amount ?? '-' }}
                                                </div>
                                                 <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Date:</div>
                                                    {{ $tercourier->paid_date ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>


                                @if ($role == 'reception' && $tercourier->status== 1 && false)
                                <td>
                                    <div class="action d-flex justify-content-center align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" data-toggle="modal" data-target="#editTerModal" v-on:click="get_data_by_id(<?php echo $tercourier->id ?>)">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </div>
                                </td>
                                @elseif ($role == 'sourcing' && $tercourier->status== 2)
                                <td>
                                    <div class="action d-flex justify-content-center align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" data-toggle="modal" data-target="#exampleModal" v-on:click="open_invoice_remark(<?php echo $tercourier->id ?>)">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </div>
                                </td>
                                @elseif ($role == 'scanning' && $tercourier->status== 8)
                                <td>
                                    <div class="action d-flex justify-content-center align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" data-toggle="modal" data-target="#partialpaidModal" v-on:click="open_scanning_modal(<?php echo $tercourier->id ?>)">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </div>
                                </td>
                                @elseif ($tercourier->status== 9)
                                <td>
                                    <div class="action d-flex justify-content-center align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye" data-toggle="modal" data-target="#viewFileModal" v-on:click="open_file_view_modal(<?php echo $tercourier->id ?>)">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </div>
                                </td>

                                @else
                                <td>
                                    <div class="action d-flex justify-content-center align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" style="color: #83838380;cursor: not-allowed !important;">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </div>
                                </td>
                                @endif
                            </tr>

                        <?php } ?>
                    </tbody>
                    <tbody id="tb1" v-else>

                        <tr v-for="tercourier in ter_all_data">
                        @if($role== "reception" || $role== "sourcing" || $role== "accounts" )
                        <td style="padding: 10px 21px;">
                                <input type="checkbox" id="selectboxid8" name="select_boxd[]" class="selected_boxd" disabled>
                            </td>
                        @endif    
                            <td width="100px">
                                <div class="d-flex align-items-center" style="gap: 4px;">
                                    @{{ tercourier.id }}
                                </div>
                            </td>


                            <td>
                                <!-- <div v-if="tercourier.status == 1 && tercourier.handover_detail.handover_remarks != 'null'"> -->
                                <!-- <div v-if="tercourier.status == 1 && tercourier.handover_detail.handover_remarks != 'null'">
                                    <button class="btn btn-danger btn-sm btn-rounded mb-2 statusButton" v-if="tercourier.status==1" data-toggle="modal" data-target="#exampleModal" v-on:click="open_ter_modal(tercourier.id)">
                                        Received
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                </div> -->
                                <div v-if="tercourier.status == 1">
                                    <button class="btn btn-success btn-sm btn-rounded mb-2 statusButton" v-if="tercourier.status==1" >
                                        Received at Reception
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                </div>
                                <button class="btn btn-danger btn-sm btn-rounded mb-2 statusButton" v-if="tercourier.status==0">
                                    Failed
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div v-if="tercourier.status == 2">
                                    <button class="btn btn-warning btn-sm btn-rounded mb-2 statusButton" v-if="tercourier.status==2">
                                    Received at Sourcing
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>

                                    </button>


                                </div>
                                <div v-if="tercourier.status == 11">
                                    <button class="btn btn-warning btn-sm btn-rounded mb-2 statusButton" v-if="tercourier.status==11">
                                    Handover to Sourcing
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>

                                    </button>


                                </div>
                                <div v-if="tercourier.status == 3">
                                    <button class="btn btn-success btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                    Verified at Sourcing
                                    </button>
                                </div>
                                <div v-if="tercourier.status == 4">
                                    <button class="btn btn-success btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                    Handover to Accounts
                                    </button>
                                </div>

                                <div v-if="tercourier.status == 5">
                                    <button class="btn btn-success btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                        Unpaid
                                    </button>
                                </div>
                                <div v-if="tercourier.status == 6">
                                    <button class="btn btn-success btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                        Paid
                                    </button>
                                </div>
                                <div v-if="tercourier.status == 7">
                                    <button class="btn btn-success btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                        Handover for Scanning
                                    </button>
                                </div>
                                <div v-if="tercourier.status == 8">
                                    <button class="btn btn-success btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                    Received at Scanning
                                    </button>
                                </div>
                                <div v-if="tercourier.status == 9">
                                    <button class="btn btn-success btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                    Invoice Scanned
                                    </button>
                                </div>
                                <!-- </div> -->
                            </td>


                            <td>
                                <ul class="dates d-flex flex-column justify-content-center">
                                    <li v-if="tercourier.received_date">
                                        Received: @{{ tercourier.received_date }}</li>
                                    <li v-if="tercourier.date_of_receipt">
                                        Entry: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @{{ tercourier.date_of_receipt }}</li>
                                    <li v-if="tercourier.handover_date">
                                        Handover: @{{ tercourier.handover_date }}</li>
                                </ul>
                            </td>


                                       <!-- sender details -->
                                       <td>
                                    <div class="senderBlock flex-wrap" style="gap: 0">
                                        <div class="senderId" style="width: 100%">
                                            <span class="senderName">@{{ tercourier.sender_name  }}</span>
                                        </div>
                                        <div class="senderLocation flex-row justify-content-start" style="gap: 8px">
                                            <span>ERP - @{{ tercourier.employee_id  }} / @{{ tercourier.pfu }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!--doc-->
                                <td>
                                    <div class="terBlock">
                                        <div class="terDates flex-grow-1">
                                            <span class="terDate"><strong>@{{ tercourier.invoice_no }} </strong></span>
                                            <div class="dates d-flex flex-column justify-content-center">
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Date:</div>
                                                    @{{ tercourier.invoice_date  }}
                                                </div>
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Claimed:</div>
                                                    ₹@{{ tercourier.basic_amount  }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!--po-->
                                <td>
                                    <div class="terBlock">
                                        <div class="terDates flex-grow-1">
                                            <span class="terDate"><strong>@{{ tercourier.po_detail.po_number }}</strong></span>
                                            <div class="dates d-flex flex-column justify-content-center">
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Date:</div>
                                                    @{{ trim_date(tercourier.po_detail.created_at) }}

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!--payment details-->
                                <td>
                                    <div class="terBlock" style="padding: 4px 8px;">
                                        <div class="terDates flex-grow-1">
                                            <div class="dates d-flex flex-column justify-content-center">
                                            <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Paid:</div>
                                                    ₹@{{ tercourier.total_amount }}
                                                </div>
                                                 <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Date:</div>
                                                    @{{ tercourier.paid_date}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            <td v-if="tercourier.status== 1 && false">
                                <div class="action d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" data-toggle="modal" data-target="#editTerModal" v-on:click="get_data_by_id(tercourier.id)">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </div>
                            </td>
                            <td v-else>
                                <div class="action d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" style="color: #83838380; cursor: not-allowed !important;">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </div>
                            </td>


                        </tr>
                    </tbody>
                </table>

                <a href="{{url('tercouriers/create')}}" class="floatingButton btn btn-lg btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span class="text">TER Courier</span>
                </a>


                <!-- Modal -->
                <div class="modal fade show" id="exampleModal" v-if="ter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Verify Document</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="ter_modal=false;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label pb-0">Ter ID:</label>
                                        <input type="text" class="form-control form-control-sm" id="recipient-name" v-model="unid" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label pb-0">Remarks:</label>
                                        <input type="text" class="form-control form-control-sm" id="recipient-name" v-model="sourcing_remarks">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" style="border-radius: 8px;" @click="submit_sourcing_remarks()" data-dismiss="modal">Submit
                                </button>
                                <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Get Passbook</button> -->
                                <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Scanning Paid Modal -->
                <div class="modal fade show" id="partialpaidModal" v-if="scanning_modal" tabindex="-1" role="dialog" aria-labelledby="partialpaidModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="partialpaidModalLabel">UNID:
                                    @{{scanning_id}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="scanning_modal=false;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label pb-0">Scanning Remarks:</label>
                                        <input type="text" class="form-control form-control-sm" id="recipient-name" v-model="scanning_remarks">
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label pb-0">Upload File</label>
                                        <input type="file" accept=".jpg,.pdf" class="form-control-file  form-control-file-sm" id="fileupload" v-on:change="upload_file($event)">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="update_scanning_data()" data-dismiss="modal" style="border-radius: 8px;">Save changes
                                </button>
                                <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Get Passbook</button> -->
                                <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
                            </div>

                        </div>
                    </div>
                </div>


                <div class="modal fade show" id="viewFileModal" v-if="file_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Uploaded File for @{{file_id}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="file_view_modal=false;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 bg-black">
                                    <img id="view-src" :src="view_file_name" alt="sample image" style="width: 100%; max-height: 300px; border-radius: 12px;" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-outline-primary" :href="view_file_name" target="_blank" style="border-radius: 8px; display: flex;align-items: center;gap: 6px;">
                                    Open in New Tab
                                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link" style="height: 14px; width: 14px">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                    </svg>
                                </a>
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

                                <h3 style="text-align: center; font-size: 18px; font-weight: 700;">Update Documnet @{{unique_id}}</h3>

                                <div class="form-row mb-4">
                                    <h6><b>AX Code</b></h6>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">From *</label>

                                        <div>Actual Entry - @{{this.all_data.sender_name}}
                                            @{{this.all_data.ax_id}}
                                            @{{this.all_data.pfu}}
                                        </div>
                                        <input type="text" class="form-control form-control-sm" v-on:change="get_sender_data(sender_all_info)" v-model="sender_all_info" list="sender_data" />
                                        <datalist class="select2-selection__rendered" id="sender_data">
                                            <option v-for="sender_all_info in senders_data" :key="sender_all_info.id">
                                                @{{sender_all_info.id}} :
                                                @{{sender_all_info.ax_code}} : @{{sender_all_info.vendor_name}} : @{{po_unit(sender_all_info.unit)}}
                                            </option>
                                        </datalist>
                                    </div>

                                    <!--------------- PO Value ---------->
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">PO Value *</label>
                                        <div style="height: 20px;"></div>
                                        <input type="number" class="form-control form-control-sm" name="po_val" v-model="po_value">
                                    </div>
                                    <!--------------- end ------------------>

                                    <!--------------- Courier Received Date ---------->
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Courier Received Date</label>
                                        <div style="height: 20px;"></div>
                                        <input type="date" class="form-control form-control-sm" name="date_of_receipt" v-model="date_of_receipt">
                                    </div>
                                    <!--------------- end ------------------>
                                </div>




                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Basic Amount</label>
                                    <input type="text" class="form-control form-control-sm" id="location" name="location" v-model="basic_amount">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Total Amount</label>
                                    <input type="text" class="form-control mbCheckNm form-control-sm" id="telephone_no" v-model="total_amount">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Unit</label>
                                    <input type="text" class="form-control form-control-sm" id="emp_status" v-model="unit" name="emp_status" autocomplete="off" readonly="readonly" />
                                </div>




                                <div class="form-group col-md-6">
                                    <label for="inputState">Invoice Number</label>
                                    <input type="text" class="form-control form-control-sm location1" id="location" name="location" v-model="invoice_number">
                                </div>





                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Invoice Date*</label>
                                    <input type="date" class="form-control form-control-sm" id="terto_date" required name="terto_date" v-model="invoice_date">
                                </div>

                                <div class="d-flex justify-content-end align-items-center">
                                    <button type=" submit" class="btn btn-primary" style="width: 100px" @click="update_data_invoice()">
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


                <div v-if="!search_flag && !ter_data_block_flag" class="d-flex align-items-center justify-content-center">
                    {{ $tercouriers->links() }}
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
            scanning_modal: false,
            ter_id: "",
            sourcing_remarks: "",
            diff_amount: "",
            scanning_remarks: "",
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
            basic_amount: "",
            total_amount: "",
            unit: "",
            company_name: "",
            date_of_receipt: "",
            docket_date: "",
            docket_no: "",
            invoice_number: "",
            terfrom_date: "",
            invoice_date: "",
            details: "",
            remarks: "",
            given_to: "",
            delivery_date: "",
            data_loaded: false,
            url: "",
            search_data: "",
            ter_all_data: {},
            courier_all_data: {},
            search_flag: false,
            ter_status: "",
            ter_class: "",
            ter_data_block_flag: false,
            page_role: "",
            word_amount: "",
            loader: false,
            searched_status: "all",
            ter_full_excel: true,
            actual_partial_id: "",
            selectedYear: "",
            currentYear: "",
            lastYear: "",
            forMonth: "",
            forPeiod: "",
            po_value: "",
            unid: "",
            scanning_id: "",
            file_id: "",
            file_view_modal: false,
            view_file_name: "",



        },
        created: function() {
            //   alert('hello');
            // var table=$('#html5-extension');
            // table.dataTable({dom : 'lrt'});
            // $('table').dataTable({bFilter: false, bInfo: false});
        },
        methods: {
            trim_date(date){
                const changed_date = date.split("T");
                return changed_date[0];
            },
            open_invoice_remark: function(id) {
                this.unid = id;
                this.ter_modal = true;
                // alert(this.unid)
            },
            update_data_invoice: function() {
                var po_id;
                if (this.sender_all_info != "") {
                    const sender_data_split = this.sender_all_info.split(" : ");
                    po_id = sender_data_split[0];
                } else {
                    po_id = this.all_data.po_id;
                }

                axios.post('/edit_invoice_details', {
                        'unid': this.unique_id,
                        'po_id': po_id,
                        'po_value': this.po_value,
                        'received_date': this.date_of_receipt,
                        'basic_amount': this.basic_amount,
                        'total_amount': this.total_amount,
                        'invoice_no': this.invoice_number,
                        'invoice_date': this.invoice_date
                    })
                    .then(response => {
                        // console.log(response.data);
                        if (response.data) {
                            // alert(this.unique_id)
                            // dt.row(0).cells().invalidate().render()
                            this.update_ter_flag = true;
                            swal('success', "Record has been updated Successfully!!!", 'success')
                            this.got_data = false;
                            // document.getElementById("search_item").value = "";

                            this.sender_all_info = "";
                            this.all_data = {};
                            this.unique_id = "";
                            // location.reload();
                            // $('#html5-extension').DataTable().response.data.reload();
                        } else if (response.data == 0) {
                            this.button_text = "Search";
                            swal('error', "Record has been Already changed to Handover", 'error')
                            this.got_data = false;
                            this.unique_id = "";
                            this.sender_all_info = "";
                            this.all_data = {};
                            // document.getElementById("search_item").value = "";
                        } else {
                            this.button_text = "Search";
                            this.got_data = false;
                            this.unique_id = "";
                            this.sender_all_info = "";
                            this.all_data = {};
                            // document.getElementById("search_item").value = "";
                            swal('error', "Either Record is already updated or not selected", 'error')
                        }

                    }).catch(error => {

                        // console.log(error)
                        // return 1;
                        this.button_text = "Search";
                        this.got_data = false;
                        // document.getElementById("search_item").value = "";
                        this.unique_id = "";
                        this.sender_all_info = "";


                    })


            },
            arraySum: function(ary) {

                const obj = JSON.parse(ary);
                var sum = 0;
                for (var el in obj) {
                    if (obj.hasOwnProperty(el)) {
                        sum += parseFloat(obj[el]);
                    }
                }
                return sum;
            },
            hand_shake_report: function() {
                axios.get('/hand_shake_report', {


                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data == 1) {
                            this.url = '/download_handshake_report';
                            window.location.href = this.url;
                        }

                    }).catch(error => {

                        console.log(response)
                        this.apply_offer_btn = 'Apply';

                    })
            },
            open_hr_verify_ter(id) {
                this.unique_id = id;
                this.loader = true;
                // alert(id);
                // return 1;
                // window.location="/pages/employee-passbook";
                // setTimeout(() => {window.location.href = "/employee-passbook"},2000);
                axios.post('/open_hr_verify_ter', {
                        'id': this.unique_id
                    })
                    .then(response => {
                        if (response.data) {
                            window.location = response.data;
                        } else {
                            this.loader = false;
                            swal('error', "System Error", 'error')
                            location.reload();
                        }

                    }).catch(error => {


                    })
            },
            po_unit(unit) {
                if (unit == 1) {
                    unit = 'SD1';
                } else if (unit == 2) {
                    unit = 'SD3';
                } else if (unit == 3) { //2
                    unit = 'MA2';
                } else if (unit == 4) { //3
                    unit = 'MA4';
                }
                return unit;
            },
            open_verify_ter(id) {
                this.unique_id = id;
                this.loader = true;
                // window.location="/pages/employee-passbook";
                // setTimeout(() => {window.location.href = "/employee-passbook"},2000);
                axios.post('/open_verify_ter', {
                        'id': this.unique_id
                    })
                    .then(response => {
                        if (response.data) {
                            window.location = response.data;
                        } else {
                            this.loader = false;
                            swal('error', "System Error", 'error')
                            location.reload();
                        }

                    }).catch(error => {


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
            clear_search: function() {
                if (this.search_data == "") {
                    this.ter_all_data = {};
                    this.search_flag = false;
                    this.ter_data_block_flag = false;

                    return 1;
                }
            },
            get_filter_status_data: function() {
                // alert(this.searched_status);
                // return 1;
                if (this.searched_status == "all") {
                    this.ter_all_data = {};
                    this.search_flag = false;
                    this.ter_data_block_flag = false;
                    this.search_data = "";
                    this.ter_full_excel = true;
                    document.getElementById('searchedInput').removeAttribute('disabled', true);
                } else {
                    this.search_data = this.searched_status;
                    this.get_searched_invoice();
                    this.ter_full_excel = false;
                    document.getElementById('searchedInput').setAttribute('disabled', true);
                }
            },
            download_ter_status_list: function() {

                this.url = '/download_status_wise_ter/' + this.searched_status;
                // alert(this.url)
                window.location.href = this.url;

            },

            get_searched_invoice: function() {
                // var table = $('#html5-extension').DataTable();
                // table.search(this.search_data).draw();
                // alert(role);
                // return 1;
                this.page_role = document.getElementById('ter_role').value;
                // reception
                // alert(role);
                // return 1;
                if (this.search_data == "") {
                    this.ter_all_data = {};
                    this.search_flag = false;
                    this.ter_data_block_flag = false;

                    return 1;
                }


                axios.post('/get_searched_invoice', {
                        'search_data': this.search_data,
                        'page_role': this.page_role
                    })
                    .then(response => {
                        if (response.data) {
                            this.ter_all_data = response.data[0];
                            // console.log(this.ter_all_data.courier_company.courier_name)
                            // if (this.page_role == "reception") {
                            this.search_flag = true;

                            // }
                            if (this.page_role == "Tr Admin") {
                                // alert('dd')
                                this.ter_data_block_flag = true;


                            }


                            //    alert("loading done")
                            // alert(this.sender_telephone);
                        } else {
                            // swal('error', "Not able to fetch employee details", 'error')
                        }

                    }).catch(error => {



                    })

            },
            onChangePeriodType: function() {
                this.selectedYear = new Date().getFullYear();
                this.currentYear = document.getElementById('current_year')
                this.lastYear = document.getElementById('last_year')
                this.forMonth = document.getElementById('for_month')
                this.forPeiod = document.getElementById('for_period')
                if (this.forMonth.checked) {
                    document.getElementById('terfrom_date').disabled = true;
                    document.getElementById('terto_date').disabled = true;
                    document.getElementById('month').disabled = false;
                    $("input[name='terfrom_date']").val('');
                    $("input[name='terto_date']").val('');
                    document.getElementById('month').setAttribute("required", "true");
                    this.currentYear.disabled = false;
                    this.lastYear.disabled = false;
                }
                if (this.forPeiod.checked) {
                    document.getElementById('terfrom_date').disabled = false;
                    document.getElementById('terto_date').disabled = false;
                    document.getElementById('month').disabled = true;
                    document.getElementById('month').setAttribute("required", "false");
                    document.getElementById('month').value = '00';

                    this.currentYear.disabled = true;
                    this.lastYear.disabled = true;
                }
            },
            // 7 sick, 7 el, 14 al
            onSelectMonth: function() {
                this.selectedMonth = document.getElementById('month').value
                this.currentYear = this.lastYear.checked ? (this.selectedYear - 1) : this.selectedYear;
                // alert(this.currentYear)
                // alert(`${this.currentYear}-${this.selectedMonth}-01`)
                if (this.selectedMonth == 1 || this.selectedMonth == 3 || this.selectedMonth == 5 || this.selectedMonth == 7 || this.selectedMonth == 8 || this.selectedMonth == 10 || this.selectedMonth == 12) {
                    this.terfrom_date = `${this.currentYear}-${this.selectedMonth}-01`;
                    this.terto_date = `${this.currentYear}-${this.selectedMonth}-31`;
                    // $("input[name='terfrom_date1']").val(`${this.currentYear}-${this.selectedMonth}-01`);
                    // $("input[name='terto_date1']").val(`${this.currentYear}-${this.selectedMonth}-31`);
                } else if (this.selectedMonth == 2) {
                    this.terfrom_date = `${this.currentYear}-${this.selectedMonth}-01`;
                    this.terto_date = `${this.currentYear}-${this.selectedMonth}-28`;
                    // $("input[name='terfrom_date1']").val(`${this.currentYear}-${this.selectedMonth}-01`);
                    // $("input[name='terto_date1']").val(`${this.currentYear}-${this.selectedMonth}-28`);
                } else {
                    this.terfrom_date = `${this.currentYear}-${this.selectedMonth}-01`;
                    this.terto_date = `${this.currentYear}-${this.selectedMonth}-30`;
                    // $("input[name='terfrom_date1']").val(`${this.currentYear}-${this.selectedMonth}-01`);
                    // $("input[name='terto_date1']").val(`${this.currentYear}-${this.selectedMonth}-30`);
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
                            // dt.row(0).cells().invalidate().render()
                            this.update_ter_flag = true;
                            swal('success', "Record has been updated Successfully!!!", 'success')
                            this.got_data = false;
                            // document.getElementById("search_item").value = "";

                            this.sender_all_info = "";
                            this.all_data = {};
                            this.unique_id = "";
                            location.reload();
                            // $('#html5-extension').DataTable().response.data.reload();
                        } else if (response.data == 0) {
                            this.button_text = "Search";
                            swal('error', "Record has been Already changed to Handover", 'error')
                            this.got_data = false;
                            this.unique_id = "";
                            this.sender_all_info = "";
                            this.all_data = {};
                            // document.getElementById("search_item").value = "";
                        } else {
                            this.button_text = "Search";
                            this.got_data = false;
                            this.unique_id = "";
                            this.sender_all_info = "";
                            this.all_data = {};
                            // document.getElementById("search_item").value = "";
                            swal('error', "Either Record is already updated or not selected", 'error')
                        }

                    }).catch(error => {

                        // console.log(error)
                        // return 1;
                        this.button_text = "Search";
                        this.got_data = false;
                        // document.getElementById("search_item").value = "";
                        this.unique_id = "";
                        this.sender_all_info = "";


                    })


            },
            get_sender_data: function(data) {
                const id = data.split(" : ");
                axios.post('/get_po_list', {
                        'id': id[0]
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

            open_file_view_modal: function(id) {
                this.file_id = id;
                this.file_view_modal = true;
                axios.post('/get_file_name', {
                        'id': this.file_id,
                    })
                    .then(response => {
                        this.view_file_name = 'uploads/scan_doc/' + response.data;
                        this.file_view_modal = true;
                    }).catch(error => {

                        swal('error', error, 'error')
                        this.file_view_modal = false;
                        this.file_id = "";
                    })
            },
            update_scanning_data: function() {
                if (this.scanning_remarks != "" && this.file != null) {
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data',
                        }
                    }
                    let formData = new FormData();
                    formData.append('file', this.file);
                    formData.append('unid', this.scanning_id);
                    formData.append('remarks', this.scanning_remarks);


                    axios.post('/update_scanning_data', formData, config)
                        .then(response => {
                            if (response.data[0] === "duplicate_voucher") {
                                swal('error', "Voucher Code : " + response.data[1] + " has been Already used", 'error')
                            } else if (response.data) {
                                swal('success', "UNID :" + this.ter_id + " has been submitted", 'success')
                                location.reload();
                            } else {
                                swal('error', "System Error", 'error')
                                this.scanning_modal = false;
                                this.ter_id = "";
                                location.reload();
                            }

                        }).catch(error => {

                            swal('error', error, 'error')
                            this.scanning_modal = false;
                            this.ter_id = "";
                        })

                } else {
                    swal('error', "Fields are Empty", 'error')
                }
            },
            submit_sourcing_remarks: function() {
                if (this.sourcing_remarks != "") {
                    axios.post('/submit_sourcing_remarks', {
                            'unid': this.unid,
                            'remarks': this.sourcing_remarks
                        })
                        .then(response => {
                            if (response.data) {
                                swal('success', "Remarks for UNID :" + this.unid + " has been successfully submitted", 'success')
                                location.reload();
                            } else {
                                swal('error', "System Error", 'error')
                                this.ter_modal = false;
                                this.unid = "";
                            }

                        }).catch(error => {

                            swal('error', error, 'error')
                            this.ter_modal = false;
                            this.unid = "";
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
            open_scanning_modal: function(id) {
                this.scanning_modal = true;
                this.scanning_id = id;
            },
            open_partial_paid_modal: function(ter_id) {
                this.scanning_modal = true;
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
                            this.scanning_modal = false;
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

                    axios.post('/get_all_invoice_data', {
                        'unique_id': this.unique_id,
                        'role': ""
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
                            this.senders_data = response.data.all_pos_data;
                            this.po_value = this.all_data.po_value;
                            this.basic_amount = this.all_data.basic_amount;
                            this.total_amount = this.all_data.total_amount;
                            this.unit = this.all_data.pfu;
                            this.date_of_receipt = this.all_data.received_date;
                            this.invoice_number = this.all_data.invoice_no;
                            this.invoice_date = this.all_data.invoice_date;
                            // document.getElementById('amountInwords').style.textTransform = "capitalize";
                            // this.amount_in_words();


                            // console.log(this.all_data.courier_company)
                        } else {
                            this.got_data = false;
                            this.button_text = "Search";
                            this.flag = false;
                            this.update_ter_flag = false;
                            this.data_loaded = false;
                            swal('error', "Either Details already updated or No record Found", 'error')
                        }
                        // this.amount_in_words();

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
            redirect_to_ter: function() {
                // this.url = '/download_handshake_report';
                window.location.href = '/tercouriers';

            },

            handover_invoices_document: function($type) {
                var x = this.$el.querySelector("#tb");
                if (x == null) {
                    x = "";
                    x = this.$el.querySelector("#tb1");
                }

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

                axios.post('/handover_invoices_document', {
                        'selected_value': trx_str,
                        'user_type': $type
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

            change_to_handover: function() {
                var x = this.$el.querySelector("#tb");
                if (x == null) {
                    x = "";
                    x = this.$el.querySelector("#tb1");
                }

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



@endsection
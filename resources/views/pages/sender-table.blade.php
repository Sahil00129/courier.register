@extends('layouts.main')
@section('title', 'Sender-List')
@section('content')
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
<style>
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

    .form-control-sm-30px {
        height: 30px;
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

    .senderBlock {
        max-width: 340px;
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 4px 8px;
        border-radius: 4px;
        background: #83838320;
    }

    .senderBlock .senderName {
        width: 125px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .senderBlock .senderId,
    .senderBlock .senderLocation {
        display: flex;
        flex-flow: column;
        justify-content: center;
        width: 125px;
    }

    .senderBlock .senderId span:nth-of-type(1),
    .senderBlock .senderLocation span:nth-of-type(1) {
        font-size: 12px;
    }

    .passbookIcon {
        height: 16px;
        width: 16px;
        transition: all 200ms ease-in-out;
    }

    .passbookIcon:hover {
        color: #0a53be;
        height: 18px;
        width: 18px;
    }

    .dataTables_filter {
        display: none;
    }

    .dt--top-section {
        margin: 0 !important;
    }


    /* for modal */
    .detailBox {
        border-radius: 12px;
        padding: 1rem;
        background: #8383831f;
        flex: 1;
        gap: 8px;
    }

    .detailBox p {
        color: #000;
        font-weight: 600;
        display: flex;
        align-items: center;
        margin-bottom: 0;
    }

    .detailBox p span {
        color: #838383;
        width: 100px;
    }
</style>

<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="sender_table_show">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Sender Table</a></li>

            </ol>
        </nav>
    </div>


    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <!---searchbar--->
                <div class="d-flex justify-content-end align-items-center px-4 py-4 " style="gap: 1rem; flex-wrap: wrap;">
                    <div class="searchField" style="width: 200px; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search" onclick="ss()">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="search" class="form-control form-control-sm form-control-sm-30px" placeholder="Search..." id="myInput" style="padding-left: 30px" v-model="search_keyword" @keyup="search_keyword_fn()">
                    </div>
                </div>

                <table id="html5-extension" class="html5-extension table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sender</th>
                            <th>Type</th>
                            <th>Telephone No</th>
                            <th>IAG Code</th>
                            <th>PFU</th>
                            <th>Last Working Date</th>
                            <th>Status</th>
                            <th>Passbook</th>
                            @if(!$flag)
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sends as $send)
                        <?php //echo '<pre>'; print_r($send); die;
                        ?>
                        <tr>
                            <td style="cursor:pointer; text-align: center;" data-toggle="modal" data-target="#editTerModal" v-on:click="get_employee_detail(<?php echo $send->id ?>)">{{ $send->id }}</td>
                            <td>
                                <div class="senderBlock">
                                    <div class="senderId">
                                        <span>Emp ID: {{ $send->employee_id ?? '-' }}</span>
                                        <span class="senderName" title="{{ ucwords(@$send->name) ?? '-' }}">{{ ucwords(@$send->name) ?? '-' }}</span>
                                    </div>
                                    <div class="senderLocation">
                                        <span>AX ID - {{ $send->ax_id ?? '-' }}</span>
                                        <span>{{ ucwords($send->location) ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{$send->type}}</td>
                            <td>{{$send->telephone_no}}</td>
                            <td>{{$send->iag_code}}</td>
                            <td>{{$send->pfu}}</td>
                            <td>{{Helper::ShowFormatDate($send->last_working_date)}}</td>
                            <td style="text-align: center;">
                                @if($send->status == 'Active')
                                <span style="color: green;">{{ucfirst($send->status)}}</span>
                                @else
                                <span style="color: red;">{{ucfirst($send->status)}}</span>
                                @endif
                            </td>
                            <td style="cursor:pointer; text-align: center;" v-on:click="get_employee_passbook(<?php echo $send->id ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye passbookIcon">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </td>
                            @if(!$flag)
                            <td>
                                <a href="{{url('edit-sender/'.Crypt::encrypt($send->id))}}" class="btn btn-primary">Edit</a>
                                <a href="Javascript:void();" class="btn btn-danger delete_sender" data-id="{{ $send->id }}" data-action="<?php echo URL::to('senders/delete-sender'); ?>">Delete</a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center" id="cover-spin" v-if="loader">
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Reception TER Modal -->
    <div class="modal fade show" id="editTerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document" style="min-width: min(90%, 1100px)">
            <div class="modal-content" style="position: relative;">
                <div class="editTer modal-body editTer" v-if="data_loaded">

                    <div class="d-flex justify-content-between align-items-center">
                        <h3 style="text-align: center; font-size: 18px; font-weight: 700;">Sender Details</h3>

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="closeButton feather feather-x-circle" data-dismiss="modal" aria-label="Close">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; width: 100%; gap: 1rem;">
                        <div class="detailBox d-flex" style="flex-wrap: wrap;">
                            <p style="flex: 1; min-width: 100%;"><span>Emp ID</span>: @{{sender_data.employee_id}}</p>
                            <p style="flex: 1; min-width: 100%;"><span>Grade</span>: @{{sender_data.grade}}</p>
                            <p style="flex: 1; min-width: 100%;"><span>AX Code</span>: @{{sender_data.ax_id}}</p>
                            <p style="flex: 1; min-width: 100%;"><span>IAG Code</span>: @{{sender_data.iag_code}}</p>
                        </div>

                        <div class="detailBox d-flex" style="flex-wrap: wrap;">
                            <p style="flex: 1; min-width: 100%;"><span>Name</span>: @{{sender_data.name}}</p>
                            <p style="flex: 1; min-width: 100%;"><span>Aadhar</span>: @{{sender_data.aadhar_number}}</p>
                            <p style="flex: 1; min-width: 100%;"><span>DOB</span>: @{{sender_data.date_of_birth}}</p>
                            <p style="flex: 1; min-width: 100%;"><span>Mobile</span>: @{{sender_data.telephone_no}}</p>
                            <p style="flex: 1; min-width: 100%;"><span>PAN</span>: @{{sender_data.pan}}</p>
                        </div>

                        <div class="detailBox d-flex" style="min-width: 100%; flex-wrap: wrap;">
                            <p style="font-size: 1rem; font-weight: 600; width: 100%; margin-top: -2rem">Employement Details</p>
                            <p style="flex: 1; min-width: 260px;"><span>Head Quarter</span>: @{{sender_data.hq_state}}</p>
                            <p style="flex: 1; min-width: 260px;"><span>Joining Date</span>: @{{sender_data.date_of_joining}}</p>
                            <p style="flex: 1; min-width: 260px;"><span>Leaving Date</span>: @{{sender_data.last_working_date}}</p>
                        </div>

                        <div class="detailBox d-flex" style="min-width: 100%; flex-wrap: wrap;">
                            <p style="font-size: 1rem; font-weight: 600; width: 100%; margin-top: -2rem">Bank Details</p>
                            <p style="flex: 1; min-width: 40%;"><span>Bank Name</span>: @{{sender_data.bank_name}}</p>
                            <p style="flex: 1; min-width: 40%;"><span>Holder Name</span>: @{{sender_data.beneficiary_name}}</p>
                            <p style="flex: 1; min-width: 40%;"><span>A/c Number</span>: @{{sender_data.account_number}}</p>
                            <p style="flex: 1; min-width: 40%;"><span>IFSC</span>: @{{sender_data.ifsc}}</p>
                            <p style="flex: 1; min-width: 40%;"><span>Branch</span>: @{{sender_data.branch_name}}</p>
                        </div>
                    </div>
                </div>
                <div style="min-height: 90vh;" v-else class="d-flex justify-content-center align-items-center">
                    Loading...
                </div>
            </div>
        </div>
    </div>

    @if(!$flag)
    <a href="{{url('add-sender')}}" class="floatingButton btn btn-lg btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        <span class="text">Add Sender</span>
    </a>
    @endif
</div>

<script>
    new Vue({
        el: '#sender_table_show',
        // components: {
        //   ValidationProvider
        // },
        data: {
            unique_id: "",
            loader: "",
            search_keyword: "",
            data_loaded: false,
            sender_data: {},
        },
        created: function() {


        },
        methods: {
            search_keyword_fn() {
                var table = $('.html5-extension').DataTable();
                table.search(this.search_keyword).draw();
            },
            get_employee_passbook(id) {
                this.unique_id = id;
                this.loader = true;
                // window.location="/pages/employee-passbook";
                // setTimeout(() => {window.location.href = "/employee-passbook"},2000);
                axios.post('/get_employee_passbook', {
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
            get_employee_detail: function(id) {
                this.unique_id = id;
                this.sender_data = {};
                //    alert(id);
                //    return 1;
                axios.post('/get_employee_details', {
                        'sender_id': this.unique_id
                    })
                    .then(response => {
                        if (response.data) {
                            this.data_loaded = true;
                            this.sender_data = response.data;
                        }

                    }).catch(error => {


                    })
            }

        }


    })
</script>


@include('models.delete-sender')
@endsection
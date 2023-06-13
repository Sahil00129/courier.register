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
        padding: 10px 21px 10px 21px;
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
</style>


<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="divbox">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Received Handovers</a></li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6" style="width: 100%; overflow-x: auto; padding: 2.5rem 0 1rem">
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Handover ID</th>
                            <th>Handover Department</th>
                            <th>UNID's</th>
                            <th>Count</th>
                            <th>Handover Date</th>
                            <th>Handover Remarks</th>
                            <th>Handover Status</th>
                            @if($name == 'tr admin' || $name == 'Hr Admin' || $name == "sourcing")
                            <th class="text-center">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="tb">
                        @foreach ($handovers as $key => $handover)

                        @if($name == 'reception')
                        <tr>
                            <td><strong>{{ $handover->handover_id }}</strong></td>
                            <td>{{$handover->department}}</td>
                            <td>{{$handover->ter_ids}}</td>
                            <td>{{$handover->ter_id_count}}</td>
                            <td>{{ DateTime::createFromFormat("Y-m-d H:i:s",$handover->created_at)->format("d/m/Y");}}</td>
                            @if($handover->handover_remarks!="" && $handover->reception_action == 0)
                            <td>{{$handover->handover_remarks}}</td>
                            @else
                            <td>-</td>
                            @endif
                            @if($handover->is_received == 1)
                            <td>Received</td>
                            @else
                            <td>Not Received</td>
                            @endif
                        </tr>

                        @elseif($name == 'tr admin' && $handover->department == 'ter-team')
                        <tr>
                            <td><strong>{{ $handover->handover_id }}</strong></td>
                            <td>{{$handover->department}}</td>
                            <td>{{$handover->ter_ids}}</td>
                            <td>{{$handover->ter_id_count}}</td>
                            <td>{{ DateTime::createFromFormat("Y-m-d H:i:s",$handover->created_at)->format("d/m/Y");}}</td>
                            @if($handover->handover_remarks!="")
                            <td>{{$handover->handover_remarks}}</td>
                            @else
                            <td>-</td>
                            @endif
                            @if($handover->is_received == 1)
                            <td>Received</td>
                            @else
                            <td>Not Received</td>
                            @endif
                            @if($handover->reception_action == '1' && $handover->is_received == 0)
                            <td>
                                <div class="action d-flex justify-content-center align-items-center" style="gap: 1rem">
                                    <div class="btn btn-sm btn-success" style="padding: 0.4375rem 1.25rem" v-on:click="accept_handover(<?php echo $handover->handover_id ?>)">Accept</div>
                                    <div class="btn btn-sm btn-danger" data-toggle="modal" data-target="#editTerModal" style="padding: 0.4375rem 1.25rem" v-on:click="decline_handover(<?php echo $handover->handover_id ?>)">Decline</div>
                                </div>
                            </td>
                            @else
                            <td>-</td>
                            @endif
                        </tr>

                        @elseif($name == 'sourcing' && $handover->department == 'sourcing-team')
                        <tr>
                            <td><strong>{{ $handover->handover_id }}</strong></td>
                            <td>{{$handover->department}}</td>
                            <td>{{$handover->ter_ids}}</td>
                            <td>{{$handover->ter_id_count}}</td>
                            <td>{{ DateTime::createFromFormat("Y-m-d H:i:s",$handover->created_at)->format("d/m/Y");}}</td>
                            @if($handover->handover_remarks!="")
                            <td>{{$handover->handover_remarks}}</td>
                            @else
                            <td>-</td>
                            @endif
                            @if($handover->is_received == 1)
                            <td>Received</td>
                            @else
                            <td>Not Received</td>
                            @endif
                            @if($handover->reception_action == '1' && $handover->is_received == 0)
                            <td>
                                <div class="action d-flex justify-content-center align-items-center" style="gap: 1rem">
                                    <div class="btn btn-sm btn-success" style="padding: 0.4375rem 1.25rem" v-on:click="accept_handover(<?php echo $handover->handover_id ?>)">Accept</div>
                                    <div class="btn btn-sm btn-danger" data-toggle="modal" data-target="#editTerModal" style="padding: 0.4375rem 1.25rem" v-on:click="decline_handover(<?php echo $handover->handover_id ?>)">Decline</div>
                                </div>
                            </td>
                            @else
                            <td>-</td>
                            @endif
                        </tr>

                        @elseif($name == 'Hr Admin' && $handover->department=='hr-admin')
                        <tr>
                            <td><strong>{{ $handover->handover_id }}</strong></td>
                            <td>{{$handover->department}}</td>
                            <td>{{$handover->ter_ids}}</td>
                            <td>{{$handover->ter_id_count}}</td>
                            <td>{{ DateTime::createFromFormat("Y-m-d H:i:s",$handover->created_at)->format("d/m/Y");}}</td>
                            @if($handover->handover_remarks!="")
                            <td>{{$handover->handover_remarks}}</td>
                            @else
                            <td>-</td>
                            @endif
                            @if($handover->is_received == 1 && $handover->handover_remarks == "")
                            <td>Received</td>
                            @else
                            <td>Not Received</td>
                            @endif
                            @if($handover->reception_action == '1' && $handover->is_received == 0)
                            <td>
                                <div class="action d-flex justify-content-center align-items-center" style="gap: 1rem">
                                    <div class="btn btn-sm btn-success" style="padding: 0.4375rem 1.25rem" v-on:click="accept_handover(<?php echo $handover->handover_id ?>)">Accept</div>
                                    <div class="btn btn-sm btn-danger" data-toggle="modal" data-target="#editTerModal" style="padding: 0.4375rem 1.25rem" v-on:click="decline_handover(<?php echo $handover->handover_id ?>)">Decline</div>
                                </div>
                            </td>
                            @else
                            <td>-</td>
                            @endif

                        </tr>
                        @endif
                        @endforeach
                    </tbody>

                </table>


                <!-- Edit Reception TER Modal -->
                <div class="modal fade show" id="editTerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="position: relative;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectedRemarksModalLabel"> Handover ID: @{{handover_id}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Cancel Remarks:</label>
                                        <input type="text" class="form-control" id="recipient-name" v-model="handover_remarks">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" style="min-width: 100px" class="btn btn-primary" data-dismiss="modal" v-on:click="confirm_decline()">Confirm Decline</button>
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
            handover_id: "",
            handover_remarks: "",
        },
        created: function() {},
        methods: {
            accept_handover: function(id) {
                this.handover_id = id;
                axios.post('/accept_handover', {
                        'handover_id': this.handover_id
                    })
                    .then(response => {
                        if (response.data) {
                            // window.location = response.data;
                            location.reload();
                        } else {
                            this.loader = false;
                            swal('error', "System Error", 'error')
                            // location.reload();
                        }

                    }).catch(error => {


                    })
            },
            confirm_decline: function() {
                if(this.handover_remarks!=""){
                axios.post('/reject_handover', {
                        'handover_id': this.handover_id,
                        'handover_remarks': this.handover_remarks
                    })
                    .then(response => {
                        if (response.data) {
                            swal('success', "Handover ID Declined Successfully..", 'success')
                            // window.location = response.data;
                            location.reload();
                        } else {
                            // this.loader = false;
                            swal('error', "System Error", 'error')
                            // location.reload();
                        }

                    }).catch(error => {


                    })
                }
                else{
                    swal('error', "Remarks are Mandatory", 'error')
                }

            },
            decline_handover: function(id) {
                this.handover_id = id;
            },


        }
    })
</script>


@endsection
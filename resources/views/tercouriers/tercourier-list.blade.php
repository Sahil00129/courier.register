@extends('layouts.main')
@section('title', 'Courier List')
@section('content')
 <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
 <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <style>
        .btn {
            padding: 10px 10px;
            font-size: 10px;
        }
    </style>
    <!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing">
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Courier List</a></li>
                        </ol>
                    </nav>
                </div>
                
                <div class="row layout-top-spacing" id="cancel-row">

                    <a class="dropdown-item" id="ter-bulkstatus" data-toggle="modal" data-target="#bulk-terstatus"><i class="fa fa-user"></i>Assign User</a>
                    <!-- <button class="btn-primary btn-cstm btn w-100"  disabled type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fa fa-list" aria-hidden="true"></i> Handover</span>
                    </button> -->

                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                
                                <thead>
                                    <tr>
                                        <th class="pr-0">
                                            <div class="checkbox">
                                                <label class="check-label">
                                                    <input id="ckbCheckAll" type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </th>
                                        <th>UN ID</th>
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
                                        <th>Other Details</th>
                                        <th width="200px;">Remarks</th>
								        <th>Given To</th>
                                        <th>Handover Date</th>
                                        <th>Courier Name</th>
							         	<th>Docket No</th>
								        <th>Docket Date</th>
                                        <!-- <th class="dt-no-sorting">Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody id="tb">
                                <?php $i=1;
                                    foreach ($tercouriers as $key => $tercourier) {  
                                ?>
                                    <tr>
                                        <td class="pr-0">
                                            <div class="checkbox">
                                                <label class="check-label">
                                                    <!-- <input type="checkbox" class="chkBoxClass"> -->
                                                    <input type="checkbox" id="tr{{$tercourier->id}}" class="chkBoxClass" name = "chk" value = "{{$tercourier->id}}"/>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{$tercourier->id }}</td>
                                        <?php
                                    if($tercourier->status==1){
                                        $status = 'Received';
                                        $class = "btn-success";
                                    }elseif($tercourier->status==2){
                                        $status = 'Handover';
                                        $class = "btn-warning";
                                    }else{
                                        $status = 'Cancel';
                                        $class = "btn-danger";
                                    }
                                    ?>
                                        <td>@if($tercourier->status == 1)
                                        <span class="btn {{$class}}">{{ $status }}</span>
                                        @else
                                        <span class="btn {{$class}}">{{ $status }}</span>
                                        @endif
                                    </td>
                                        <td>{{Helper::ShowFormatDate($tercourier->date_of_receipt)}}</td>
                                        <td>{{ucwords(@$tercourier->SenderDetail->name) ?? '-'}}</td>
                                        <td>{{$tercourier->SenderDetail->ax_id ?? '-'}}</td>
                                        <td>{{$tercourier->SenderDetail->employee_id ?? '-'}}</td>
                                        <td>{{ucwords($tercourier->location) ?? '-'}}</td> 
                                        <td>{{$tercourier->company_name ?? '-'}}</td> 
                                        <td>{{$tercourier->amount ?? '-'}}</td> 
                                        <td>{{Helper::ShowFormatDate($tercourier->terfrom_date)}}</td>
                                        <td>{{Helper::ShowFormatDate($tercourier->terto_date)}}</td>
                                        <td>{{ucfirst($tercourier->details) ?? '-'}}</td>
                                        <td>{{ucfirst($tercourier->remarks) ?? '-'}}</td>
                                        <td>{{$tercourier->given_to ?? '-'}}</td>
                                        <td>{{Helper::ShowFormatDate($tercourier->delivery_date)}}</td>
                                        <td>{{ucwords(@$tercourier->CourierCompany->courier_name) ?? '-'}}</td>
                                        <td>{{$tercourier->docket_no ?? '-'}}</td>
                                        <td>{{Helper::ShowFormatDate($tercourier->docket_date)}}</td>
                                        <!-- <td> <a href="{{ url('edit-tercourier/'.$tercourier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete-courier/{{$tercourier->id}}" class="btn btn-danger btn-sm">Delete</a>   
                                        </td> -->
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <a href="javascript:;" class="btn btn-danger" id="addmore"><i class="fa fa-fw fa-plus-circle"></i> Add row</a>
                                            <button type="submit" name="save" id="save" value="save" class="btn btn-primary" hidden><i class="fa fa-fw fa-save"></i> Save</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
                

<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script>
    ///// check box checked tercourier page

    jQuery(document).on('click','#ckbCheckAll',function(){
        // alert("hhjj");
        if(this.checked){
            jQuery('#ter-bulkstatus').prop('disabled', false);
            jQuery('.chkBoxClass').each(function(){
            this.checked = true;
            });
        }
        else{
            jQuery('.chkBoxClass').each(function(){
            this.checked = false;
            });
            jQuery('#ter-bulkstatus').prop('disabled', true);
        }

    });

    jQuery(document).on('click','.chkBoxClass',function(){
        if($('.chkBoxClass:checked').length == $('.chkBoxClass').length){
            $('#ckbCheckAll').prop('checked',true);
            jQuery('#ter-bulkstatus').prop('disabled', false);
        }else{

        var checklength = $('.chkBoxClass:checked').length;
        if(checklength < 1){
            jQuery('#ter-bulkstatus').prop('disabled', true);
        }else{
            jQuery('#ter-bulkstatus').prop('disabled', false);
        }

        $('#ckbCheckAll').prop('checked',false);
        }
    });

</script>


@include('models.bulk-statuschange')
@endsection
@extends('layouts.main')
@section('title', 'Courier List')
@section('content')
 <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
 <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
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
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>UN ID</th>
                                        <th>Date of Receipt</th>
                                        <th>Courier Name</th>
							         	<th>Docket No</th>
								        <th>Docket Date</th>
								        <th>Location</th>
                                        <th>Company Name</th>
                                        <th>TER Amount</th>
                                        <th>TER Period From</th>
                                        <th>TER Period To</th>
                                        <th>Other Details</th>
                                        <th>Remarks</th>
								        <th>Given To</th>
                                        <th>Handover Date</th>
                                        <!-- <th class="dt-no-sorting">Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1;  
                                    foreach ($tercouriers as $key => $tercourier) {  
                                ?> 
                                    <tr>
                                        <td>{{$tercourier->id }}</td>
                                        <td>{{Helper::ShowFormatDate($tercourier->date_of_receipt)}}</td>
                                        <td>{{ucwords($tercourier->CourierCompany->courier_name) ?? '-'}}</td>
                                        <td>{{$tercourier->docket_no ?? '-'}}</td>
                                        <td>{{Helper::ShowFormatDate($tercourier->docket_date)}}</td>
                                        <td>{{ucwords($tercourier->location) ?? '-'}}</td> 
                                        <td>{{$tercourier->company_name ?? '-'}}</td> 
                                        <td>{{$tercourier->amount ?? '-'}}</td> 
                                        <td>{{Helper::ShowFormatDate($tercourier->terfrom_date)}}</td>
                                        <td>{{Helper::ShowFormatDate($tercourier->terto_date)}}</td>
                                        <td>{{ucfirst($tercourier->details) ?? '-'}}</td>
                                        <td>{{ucfirst($tercourier->remarks) ?? '-'}}</td>
                                        <td>{{$tercourier->given_to ?? '-'}}</td>
                                        <td>{{Helper::ShowFormatDate($tercourier->delivery_date)}}</td>
                                        <!-- <td> <a href="{{ url('edit-tercourier/'.$tercourier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete-courier/{{$tercourier->id}}" class="btn btn-danger btn-sm">Delete</a>   
                                        </td> -->
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Date of Receipt</th>
                                        <th>Courier Name</th>
							         	<th>Docket No</th>
								        <th>Docket Date</th>
								        <th>Location</th>
                                        <th>Company Name</th>
                                        <th>TER Amount</th>
                                        <th>TER Period From</th>
                                        <th>TER Period To</th>
                                        <th>Other Details</th>
                                        <th>Remarks</th>
								        <th>Given To</th>
                                        <th>Handover Date</th>
                                        <!-- <th class="dt-no-sorting">Actions</th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                </div>
                
@endsection
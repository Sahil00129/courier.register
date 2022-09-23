@extends('layouts.main')
@section('title', 'Sender-List')
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
                <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Sender Tables</a></li>
                
            </ol>
        </nav>
        <?php
    if (!$flag) { ?>
        <a class="btn btn-primary" href="{{url('add-sender')}}" >Add Sender</a>
        <?php }?>
        <?php
    if ($flag) { ?>
    <a class="btn btn-primary" href="{{url('export_emp_table')}}" style="margin-left:50%" >Download Employee Table</a>
    
    <?php }?>

    <?php
    if ($flag_hr) { ?>
    <a class="btn btn-primary" href="{{url('export_ter_user_entry')}}" >Download Ter Report</a>
    <?php }?>
    
    </div>
                
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ax Id</th>
                            <th>Employee Id</th>
                            <th>Type</th>
                            <th>Sender Name</th>
                            <th>Location</th>
                            <th>Telephone No</th>
                            <th>Last Working Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($sends as $send)
                     <?php //echo '<pre>'; print_r($send); die; ?>
                        <tr>
                            <td>{{ $send->id }}</td>
                            <td>{{$send->ax_id}}</td>
                            <td>{{$send->employee_id}}</td>
                            <td>{{$send->type}}</td>
                            <td>{{$send->name}}</td> 
                            <td>{{$send->location}}</td>                      
                            <td>{{$send->telephone_no}}</td>
                            <td>{{Helper::ShowFormatDate($send->last_working_date)}}</td>
                            <td>{{ucfirst($send->status)}}</td>
                            <td>
                                <a href="{{url('edit-sender/'.Crypt::encrypt($send->id))}}" class="btn btn-primary">Edit</a>
                                <a href="Javascript:void();" class="btn btn-danger delete_sender" data-id="{{ $send->id }}" data-action="<?php echo URL::to('senders/delete-sender'); ?>">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('models.delete-sender')
@endsection
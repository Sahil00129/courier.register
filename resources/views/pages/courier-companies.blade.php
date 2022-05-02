@extends('layouts.main')
@section('title', 'Courier-Companies')
@section('content')
  <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_custom.css">
<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Courier Companies</a></li>
            </ol>
        </nav>
        <a class="btn btn-primary mb-2 mr-2" id="add_courier" data-toggle="modal" data-target="#createcompany" href="#"><span><i class="fa fa-plus"></i> Add New</span></a>
    </div>
    
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <table id="style-3" class="table style-3  table-hover">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Courier Companies</th>
                            <th>Contact Number</th>
                            <th class="text-center dt-no-sorting">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($couriers as $courier)
    			        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{$courier->courier_name}}</td>
                            <td>{{$courier->phone}}</td>
                            <td class="text-center">
                                <ul class="table-controls">
                                    <li><button type= "button" class="btn btn-warning editbtn btn-sm" value="{{$courier->id }}">Edit</button></li>
                                    <li><a href="delete-courierCompany/{{$courier->id}}" class="btn btn-danger btn-sm">Delete</a></li>
                                </ul>
                            </td>
                       </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal" id="createcompany" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <form method="POST" action="{{url('create-courierName')}}" id="createcourier">
                <div class="modal-header text-center">
                    <h4 class="modal-title">Create Courier Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-row mb-4">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Courier Company</label>
                            <input type="text" class="form-control" id="couriername" name="courier_name" placeholder="" autocomplete="off">
                        </div>  
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Contact Number</label>
                            <input type="text" class="form-control mbCheckNm" id="phoneno" name="phone" placeholder="" maxlength="10" autocomplete="off">
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="btn-section w-100 P-0">
                        <button type="submit" id="courier_savebtn" class="btn btn-primary">Add</button>
                        <a class="btn btn-modal" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Update Courier Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form action="{{ url('updated-courier')}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row mb-4">
                        <input type="hidden" name="courier_id" id="courier_id" value=""/>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Courier Company</label>
                            <input type="text" class="form-control" id="courier_name" name="courier_name" placeholder="" autocomplete="off">
                        </div>  
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Contact Number</label>
                            <input type="text" class="form-control mbCheckNm" id="phone" name="phone" placeholder="" maxlength="10" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" id="courier_savebtn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
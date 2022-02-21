@extends('layouts.main')
@section('title', 'Catagories')
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Catagories</a></li>
                            
                        </ol>
                    </nav>
                </div>
                
                <div class="row layout-top-spacing" id="cancel-row">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <table id="style-3" class="table style-3  table-hover">
                                <thead>
                                    <tr>
                                        <th>Catagories</th>
                                        <th class="text-center dt-no-sorting">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($catagories as $catagorie)
							<tr>
                            <td>{{$catagorie->catagories}}</td>
                            <td class="text-center">
                                                <ul class="table-controls">
                                                    <li><button type= "button" class="btn btn-warning editbtn btn-sm"  value="{{$catagorie->id }}">Edit</button></li>
                                                    <li><a href="delete-catagories/{{$catagorie->id}}" class="btn btn-danger btn-sm">Delete</a></li>
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
                                 <!-- Modal -->
                                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Update Catagories</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                                <form action="{{ url('update-catagories')}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    
                                                    <div class="form-row mb-4">
                                                    <input type="hidden" name="cat_id" id="cat_id" value=""/>
                                                
                                                    <div class="form-group col-md-6">
                                                <label for="inputEmail4">Catagories</label>
                                                <input type="text" class="form-control" id="catagories" name="catagories"  placeholder="" autocomplete="off" required>
                                                 </div>   
    
                                                    </div>
                                                                                                   
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                             </form>
                                            </div>
                                        </div>
                                    </div>

@endsection
@extends('layouts.main')
@section('title', 'Courier List')
@section('content')
 <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
 <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing">
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">DataTables</a></li>
                            
                        </ol>
                    </nav>
                </div>
                
                <div class="row layout-top-spacing" id="cancel-row">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date of Receipt</th>
							         	<th>Docket No</th>
								        <th>Docket Date</th>
                                        <th>Name</th>
								        <th>Location</th>
								        <th>Telephone No</th>
                                        <th>Catagories</th>
                                        <th>For</th>
                                        <th>Document Details</th>
                                        <th>Courier Company</th>
                                        <th>Checked By</th>
                                        <th>Given To</th>
                                        <th class="dt-no-sorting">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>123312</td>
                                        <td>123213</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                        <td>5421</td>
                                        <td>23424</td>
                                        <td>2342</td>
                                        <td>
                                            
                                        </td>
                                        <td><button type= "button" class="btn btn-warning  btn-sm"  value="">Edit</button> <a href="" class="btn btn-danger btn-sm">Delete</a>
                                            
                                        </td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                </div>
                
@endsection
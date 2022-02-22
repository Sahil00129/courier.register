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
                                        <th>S. No.</th>
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
                                    @foreach($couriers as $courier)
                                    <?php 
						           $l = (explode(":",$courier->name_company));
								   $n = @$l[0];
								   $c = @$l[1];
							    
                                   $document = $courier->distributor_agreement.' '.$courier->distributor_name.' '.$courier->document_type.' '.$courier->distributor_location.' '.$courier->remarks_distributor.' '.$courier->ledger_for.' '.$courier->type_ledger.' '.$courier->party_name.' '.$courier->year_l.' '.$courier->invoice_type.' '.$courier->invoice_number.' '.$courier->amount_invoice.' '.$courier->party_name_invoices.' '.$courier->month_invoices.' '.$courier->discription_i.' '.$courier->bills_type.' '.$courier->invoice_number_bills.' '.$courier->amount_bills.' '.$courier->previouse_reading_b.' '.$courier->current_reading_b.' '.$courier->for_month_b.' '.$courier->bank_name.' '.$courier->document_type_cheques.' '.$courier->acc_number.' '.$courier->for_month_cheques.' '.$courier->series.' '.$courier->statement_no.' '.$courier->amount_imperest.' '.$courier->for_month_imprest.' '.$courier->discription_legal.' '.$courier->company_name_legal.' '.$courier->person_name_legal.' '.$courier->number_of_pc.' '.$courier->discription_pc.' '.$courier->company_name_pc.' '.$courier->document_number_govt.' '.$courier->Discription_govt.' '.$courier->DDR_type.' '.$courier->number_of_DDR.' '.$courier->party_name_ddr.' '.$courier->physical_stock_report.' '.$courier->discription_physical.' '.$courier->month_physical.' '.$courier->discription_affidavits.' '.$courier->company_name_affidavits.' '.$courier->discription_it;
							   
                                  // echo'<pre>'; print_r($document); die;
                                  $newDate = date("d-m-Y", strtotime($courier->docket_date));
                                  $today = date("d-m-Y", strtotime($courier->created_at));

             		     	?>
                                    <tr>
                                        <td>{{$courier->id}}</td>
                                        <td>{{$today}}</td>
                                        <td>{{$courier->docket_no}}</td>
                                        <td>{{$newDate}}</td>
                                        <td>{{$n = $l[0]}}</td>
                                        <td>{{$courier->location}}</td>
                                        <td>{{$courier->telephone_no}}</td>
                                        <td>{{$courier->catagories}}</td>
                                        <td>{{$courier->for}}</td>
                                        <td>{{$document}}</td>
                                        <td>{{$courier->courier_name}}</td>
                                        <td>{{$courier->checked_by}}</td>
                                        <td>{{$courier->given_to}}</td>
                                        <td> <a href="{{ url('edit-courier/'.$courier->id) }}" class="btn btn-warning btn-sm">Edit</a> <a href="delete-courier/{{$courier->id}}" class="btn btn-danger btn-sm">Delete</a>   
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                                <tfoot>
                                     <tr>
                                        <th>S. No.</th>
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
                          </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                </div>
                
@endsection
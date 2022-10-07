@extends('layouts.main')
@section('title', 'Sender-List')
@section('content')
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="sender_table_show">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Sender Tables</a></li>

            </ol>
        </nav>
        <?php
        if (!$flag) { ?>
            <a class="btn btn-primary" href="{{url('add-sender')}}">Add Sender</a>
        <?php } ?>
        <?php
        if ($flag) { ?>
            <a class="btn btn-primary" href="{{url('export_emp_table')}}" style="margin-left:50%">Download Employee Table</a>

        <?php } ?>

        <?php
        if ($flag_hr) { ?>
            <a class="btn btn-primary" href="{{url('export_ter_user_entry')}}">Download Ter Report</a>
        <?php } ?>

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
                            <?php
                            if (!$flag) { ?> <th>Actions</th> <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sends as $send)
                        <?php //echo '<pre>'; print_r($send); die; 
                        ?>
                        <tr>
                            <td>{{ $send->id }}</td>
                            <td>{{$send->ax_id}}</td>
                            <td style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" v-on:click="open_emp_modal(<?php echo $send->id ?>)">{{$send->employee_id}}</td>
                            <td>{{$send->type}}</td>
                            <td>{{$send->name}}</td>
                            <td>{{$send->location}}</td>
                            <td>{{$send->telephone_no}}</td>
                            <td>{{Helper::ShowFormatDate($send->last_working_date)}}</td>
                            <td>{{ucfirst($send->status)}}</td>
                            <?php
                            if (!$flag) { ?> <td>
                                    <a href="{{url('edit-sender/'.Crypt::encrypt($send->id))}}" class="btn btn-primary">Edit</a>
                                    <a href="Javascript:void();" class="btn btn-danger delete_sender" data-id="{{ $send->id }}" data-action="<?php echo URL::to('senders/delete-sender'); ?>">Delete</a>
                                </td><?php } ?>
                        </tr>
                        @endforeach
                    </tbody>

                    <!-- Modal -->
                    <div class="modal fade show" id="exampleModal"  v-if="emp_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Advance for Employee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="emp_modal=false;emp_advance_amount=''">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Employee ID:</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="emp_id" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Employee Name:</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="emp_name" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Current Balance:</label>
                                            <input type="number" class="form-control" id="recipient-name"  v-model="current_balance" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Add Advance Amount:</label>
                                            <input type="number" class="form-control" id="recipient-name" v-model="emp_advance_amount">
                                        </div>
                                    </form>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary"  data-dismiss="modal" @click="add_advance_payment()">Save changes</button>
                                    <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="get_employee_passbook()">Get Passbook</button>
                                    <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    new Vue({
        el: '#sender_table_show',
        // components: {
        //   ValidationProvider
        // },
        data: {
            emp_id: "",
            emp_name: "",
            emp_all_data: "",
            emp_modal: false,
            emp_advance_amount:"",
            unique_id:"",
            current_balance:"",
        },
        created: function() {


        },
        methods: {
            get_employee_passbook(){
                // window.location="/pages/employee-passbook";
                // setTimeout(() => {window.location.href = "/employee-passbook"},2000);
                axios.post('/get_employee_passbook', {
                        'emp_id':this.emp_id
                    })
                    .then(response => {
                        if (response.data) {
                           window.location=response.data;
                        } else {
                            this.emp_modal=false;
                            this.emp_advance_amount="";
                            swal('error', "System Error", 'error')
                        }

                    }).catch(error => {



                    })
            },
            add_advance_payment(){
                axios.post('/add_advance_payment', {
                        'emp_advance_amount': this.emp_advance_amount,
                        'emp_id':this.emp_id
                    })
                    .then(response => {
                        if (response.data) {
                            swal('success', "Advance Added Successfully!!!", 'success')
                            this.emp_modal=false;
                            this.emp_advance_amount="";
                        } else {
                            this.emp_modal=false;
                            this.emp_advance_amount="";
                            swal('error', "System Error", 'error')
                        }

                    }).catch(error => {



                    })
            },
            open_emp_modal(id) {
                this.unique_id=id;
                this.emp_modal = true;
                axios.post('/get_emp_data', {
                        'sender_id': this.unique_id
                    })
                    .then(response => {
                        if (response.data) {
                            this.emp_all_data = response.data[0];
                            this.emp_name = this.emp_all_data.name;
                            this.emp_id = this.emp_all_data.employee_id;
                            this.current_balance=response.data.current_balance;
                            // alert(this.current_balance)
                            // alert(this.emp_name)
                            // alert(this.emp_id)
                            // console.log(response.data)
                        } else {
                            swal('error', "Not able to fetch employee details", 'error')
                        }

                    }).catch(error => {



                    })
            },

        }


    })
</script>

@include('models.delete-sender')
@endsection
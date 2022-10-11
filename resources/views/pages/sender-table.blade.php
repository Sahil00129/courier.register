@extends('layouts.main')
@section('title', 'Sender-List')
@section('content')
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
<style>
#cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    display:none;
}

@-webkit-keyframes spin {
	from {-webkit-transform:rotate(0deg);}
	to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
	from {transform:rotate(0deg);}
	to {transform:rotate(360deg);}
}

#cover-spin::after {
    content:'';
    display:block;
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}

</style>

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
                            <td style="cursor:pointer" v-on:click="get_employee_passbook(<?php echo $send->id ?>)">{{$send->employee_id}}</td>
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
                </table>
                <div class="d-flex justify-content-center" id="cover-spin" v-if="loader">
                </div>
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
            unique_id: "",
            loader: "",
        },
        created: function() {


        },
        methods: {
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

        }


    })
</script>
@include('models.delete-sender')
@endsection
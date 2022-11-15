@extends('layouts.main')
@section('title', 'Sender-List')
@section('content')
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/custom_dt_html5.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <style>

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

        .form-control-sm-30px {
            height: 30px;
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

        .senderBlock {
            max-width: 340px;
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 4px 8px;
            border-radius: 4px;
            background: #83838320;
        }

        .senderBlock .senderName {
            width: 125px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .senderBlock .senderId,
        .senderBlock .senderLocation {
            display: flex;
            flex-flow: column;
            justify-content: center;
            width: 125px;
        }

        .senderBlock .senderId span:nth-of-type(1),
        .senderBlock .senderLocation span:nth-of-type(1) {
            font-size: 12px;
        }

        .passbookIcon {
            height: 16px;
            width: 16px;
            transition: all 200ms ease-in-out;
        }

        .passbookIcon:hover {
            color: #0a53be;
            height: 18px;
            width: 18px;
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
        </div>


        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <!---searchbar--->
                    <div class="d-flex justify-content-between align-items-center px-4 py-4 " style="gap: 1rem; flex-wrap: wrap;">
                        <div class="d-flex align-items-center" style="gap: 1rem;">
                            @if($flag)
                                <a class="actionButtons btn btn-success" href="{{url('export_emp_table')}}"
                                   target="_blank">
                                    Employee Table
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="feather feather-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </a>
                            @endif
                            @if($flag_hr)
                                <a class="actionButtons btn btn-success" href="{{url('export_ter_user_entry')}}"
                                   target="_blank">
                                    TER Reports
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="feather feather-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        <div class="searchField" style="width: 200px; position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-search" onclick="ss()">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="search" class="form-control form-control-sm form-control-sm-30px"
                                   placeholder="Search..." id="myInput"
                                   style="padding-left: 30px" v-model="search_keyword" @keyup="search_keyword_fn()">
                        </div>
                    </div>

                    <table id="html5-extension" class="html5-extension table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sender</th>
                            <th>Type</th>
                            <th>Telephone No</th>
                            <th>Last Working Date</th>
                            <th>Status</th>
                            <th>Passbook</th>
                            @if(!$flag)
                                <th>Actions</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($sends as $send)
                            <?php //echo '<pre>'; print_r($send); die;
                            ?>
                            <tr>
                                <td>{{ $send->id }}</td>
                                <td>
                                    <div class="senderBlock">
                                        <div class="senderId">
                                            <span>Emp ID: {{ $send->employee_id ?? '-' }}</span>
                                            <span class="senderName"
                                                  title="{{ ucwords(@$send->name) ?? '-' }}">{{ ucwords(@$send->name) ?? '-' }}</span>
                                        </div>
                                        <div class="senderLocation">
                                            <span>AX ID - {{ $send->ax_id ?? '-' }}</span>
                                            <span>{{ ucwords($send->location) ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$send->type}}</td>
                                <td>{{$send->telephone_no}}</td>
                                <td>{{Helper::ShowFormatDate($send->last_working_date)}}</td>
                                <td style="text-align: center;">
                                    @if($send->status == 'Active')
                                        <span style="color: green;">{{ucfirst($send->status)}}</span>
                                    @else
                                        <span style="color: red;">{{ucfirst($send->status)}}</span>
                                    @endif
                                </td>
                                <td style="cursor:pointer; text-align: center;"
                                    v-on:click="get_employee_passbook(<?php echo $send->id ?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-eye passbookIcon">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </td>
                                @if(!$flag)
                                    <td>
                                        <a href="{{url('edit-sender/'.Crypt::encrypt($send->id))}}"
                                           class="btn btn-primary">Edit</a>
                                        <a href="Javascript:void();" class="btn btn-danger delete_sender"
                                           data-id="{{ $send->id }}"
                                           data-action="<?php echo URL::to('senders/delete-sender'); ?>">Delete</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center" id="cover-spin" v-if="loader">
                    </div>
                </div>
            </div>
        </div>

        @if(!$flag)
            <a href="{{url('add-sender')}}" class="floatingButton btn btn-lg btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-plus">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span class="text">Add Sender</span>
            </a>
        @endif
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
                search_keyword:"",
            },
            created: function () {


            },
            methods: {
                search_keyword_fn(){
                    var table = $('.html5-extension').DataTable();
                    table.search(this.search_keyword).draw();
                },
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

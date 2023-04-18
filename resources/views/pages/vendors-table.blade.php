@extends('layouts.main')
@section('title', 'Vendor-List')
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

    .dataTables_filter {
        display: none;
    }

    .dt--top-section {
        margin: 0 !important;
    }


    /* for modal */
    .detailBox {
        border-radius: 12px;
        padding: 1rem;
        background: #8383831f;
        flex: 1;
        gap: 8px;
    }

    .detailBox p {
        color: #000;
        font-weight: 600;
        display: flex;
        align-items: center;
        margin-bottom: 0;
    }

    .detailBox p span {
        color: #838383;
        width: 100px;
    }

    .action {
        color: #474d66;
        transition: all 200ms ease-in-out;
        text-align: center;
    }

    .action svg {
        height: 16px;
        width: 16px;
        cursor: pointer;
        transition: all 200ms ease-in-out;
    }
</style>

<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="vendor_table_show">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Vendor Table</a></li>

            </ol>
        </nav>
    </div>


    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <!---searchbar--->
                <div class="d-flex justify-content-between align-items-center px-4 py-4 " style="gap: 1rem; flex-wrap: wrap;">

                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px">
                        @if($role == "sourcing")

                        <!-- <a class="btn-primary btn-cstm btn ml-2" data-toggle="modal" data-target="#editTerModal" style="font-size: 12px; padding: 9px; width: 130px"><span><i class="fa fa-plus"></i> Add
                                Vendors</span></a> -->

                        <a class="btn-primary btn-cstm btn ml-2" href="/show_vendors_form" style="font-size: 12px; padding: 9px; width: 130px"><span><i class="fa fa-plus"></i> Add
                                Vendors</span></a>

                        @if(false)
                        <a class="btn-primary btn-cstm btn ml-2" data-toggle="modal" data-target="#exampleModal" style="font-size: 12px; padding: 9px; width: 130px"><span><i class="fa fa-plus"></i> Import
                            </span></a>
                        @endif

                        @endif

                        @if(false)
                        <a class="btn-primary btn-cstm btn ml-2" style="font-size: 12px; padding: 9px; width: 130px" href="{{'/download_vendor_list'}}"><span><i class="fa fa-plus"></i> Export
                            </span></a>
                        @endif
                    </div>


                    <div class="searchField" style="width: 200px; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search" onclick="ss()">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="search" class="form-control form-control-sm form-control-sm-30px" placeholder="Search..." id="myInput" style="padding-left: 30px" v-model="search_keyword" @keyup="search_keyword_fn()">
                    </div>

                </div>

                <table id="html5-extension" class="html5-extension table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Vendor Unique ID</th>
                            <th>Vendor Name</th>
                            <th>Vendor Code</th>
                            <th>Vendor Status</th>
                            <th>Unit</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $vendor)
                        <?php // echo '<pre>'; print_r($vendor); die;
                        ?>
                        <tr>
                            <td>{{$vendor->id}}</td>
                            <td>{{$vendor->vname}}</td>
                            <td>{{@$vendor->vcode}}</td>
                            <?php
                               if ($vendor->mode == "0") {
                                $mode = "Disabled/Rejected";
                            } elseif ($vendor->mode == "1") {
                                $mode = "Draft";
                            } elseif ($vendor->mode == "2") {
                                $mode = "Pending for approval";
                            } elseif ($vendor->mode == "3") {
                                $mode = "Active for PO";
                            } elseif ($vendor->mode == "4") {
                                $mode = "Active for Payments";
                            }
                            ?>
                            <td>{{$mode}}</td>


                            <?php
                            if ($vendor->pfu == "1") {
                                $pfu = "SD1";
                            } elseif ($vendor->pfu == "3") {
                                $pfu = "SD3";
                            } elseif ($vendor->pfu == "2") {
                                $pfu = "MA2";
                            } elseif ($vendor->pfu == "4") {
                                $pfu = "MA4";
                            }
                            ?>
                            <td>{{$pfu}}</td>
                            @if($vendor->mode == 0 || $vendor->mode == 1 )
                            <td class="action"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" v-on:click="open_edit_vendor(<?php echo $vendor->id ?>)">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg></td>
                            @else
                            <td></td>
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

    <!--Upload  Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Upload New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <form id="new_sender_import" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row mb-4">
                            <label for="inputState">Import Type</label>
                            <select id="itype" class="form-control" name="import_type">
                                <option selected disabled>Choose...</option>
                                <option value="14">Vendors</option>
                            </select>
                        </div>
                        <div class="custom-file-container" data-upload-id="myFirstImage">
                            <label>Upload (Single File) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                            <label class="custom-file-container__custom-file">
                                <input type="file" class="custom-file-container__custom-file__custom-file-input" id="myxls" name="file" accept=".xlsx">
                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress" style="display: none;">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Edit Reception TER Modal -->
    <div class="modal fade show" id="editTerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document" style="min-width: min(90%, 400px)">
            <div class="modal-content" style="position: relative;">
                <div class="editTer modal-body editTer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="closeButton feather feather-x-circle" data-dismiss="modal" aria-label="Close" style="position: absolute;right: 1rem;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>

                    <h3 style="text-align: center; font-size: 18px; font-weight: 700;">Add Vendor Details</h3>

                    <div class="form-row mb-4">

                        <!--------------- Vendor Name ---------->
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Vendor Name* </label>
                            <input type="text" class="form-control form-control-sm" v-model="vendor_name">
                        </div>
                        <!--------------- Vendor Code ---------->
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Vendor Code* </label>
                            <input type="text" class="form-control form-control-sm" v-model="vendor_code">
                        </div>
                        <!--------------- end ------------------>

                        <div class="form-group mb-4 col-md-12">
                            <label for="exampleFormControlInput2">Unit</label>
                            <select class="form-control" name="unit" v-model="unit">
                                <option value="">Select Unit</option>
                                <option value="SD1">SD1</option>
                                <option value="SD3">SD3</option>
                                <option value="MA2">MA2</option>
                                <option value="MA4">MA4</option>
                            </select>
                            <!-- <input type="text" class="form-control" name="unit" id="unit" placeholder=""> -->
                        </div>



                        <div class="d-flex justify-content-end align-items-center" style="width: 100%">
                            <button type=" submit" class="btn btn-primary" style="width: 100px" @click="add_vendor_details()">
                                <span class="indicator-label">Save</span>
                                </span>
                            </button>
                        </div>




                    </div>
                    <div style="min-height: 90vh;" v-else class="d-flex justify-content-center align-items-center">
                        Loading...
                    </div>
                </div>
            </div>
        </div>





    </div>

    <script>
        new Vue({
            el: '#vendor_table_show',
            // components: {
            //   ValidationProvider
            // },
            data: {
                unit: "",
                vendor_code: "",
                vendor_name: "",
                unique_id: "",
                loader: "",
                search_keyword: "",
                data_loaded: false,
                sender_data: {},

            },
            created: function() {


            },
            methods: {
                open_edit_vendor(id) {
                    axios.post('/open_edit_vendor', {
                            'id': id
                        })
                        .then(response => {
                            if (response.data) {
                                window.location = response.data;
                                // swal('success', "Vendor Added Successfully..", 'success')
                                // location.reload();
                            } else {

                                swal('error', "Vendor Code Already Exists", 'error')

                            }

                        }).catch(error => {


                        })

                },
                search_keyword_fn() {
                    var table = $('.html5-extension').DataTable();
                    table.search(this.search_keyword).draw();
                },
                add_vendor_details() {

                    if (this.vendor_code != "" && this.vendor_name != "" && this.unit != "") {
                        axios.post('/add_vendor_details', {
                                'name': this.vendor_name,
                                'erp_code': this.vendor_code,
                                'unit': this.unit
                            })
                            .then(response => {
                                if (response.data) {
                                    swal('success', "Vendor Added Successfully..", 'success')
                                    location.reload();
                                } else {

                                    swal('error', "Vendor Code Already Exists", 'error')

                                }

                            }).catch(error => {


                            })
                    } else {
                        swal('error', 'Vendor Details are missing', 'error')
                    }
                }

            }


        })
    </script>


    @include('models.delete-sender')
    @endsection
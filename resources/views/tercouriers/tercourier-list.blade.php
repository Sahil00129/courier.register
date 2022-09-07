@extends('layouts.main')
@section('title', 'Courier List')
@section('content')
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.min.js" integrity="sha256-ngFW3UnAN0Tnm76mDuu7uUtYEcG3G5H1+zioJw3t+68=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vee-validate@2.2.15/dist/vee-validate.min.js" integrity="sha256-m+taJnCBUpRECKCx5pbA0mw4ckdM2SvoNxgPMeUJU6E=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
<style>
    .btn {
        padding: 10px 10px;
        font-size: 10px;
    }
</style>


<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="divbox">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Courier List</a></li>
            </ol>
        </nav>
    </div>

    <?php
    // print_r($role);exit;
    if ($role != 'Tr Admin') { ?>
        <button class="btn btn-success" v-on:click="change_to_handover()">Handover</button>
    <?php } else if ($role === 'Tr Admin') { ?>
        <button class="btn btn-success" v-on:click="change_to_unpaid()">Unpaid</button>
    <?php } ?>

    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <?php
                // print_r($role);exit;
                if ($role === 'Tr Admin') { ?>



                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>UN IDs</th>
                                <th>Status</th>
                                <th>Sender Name</th>
                                <th>AX ID</th>
                                <th>Employee ID</th>
                                <th>Location</th>
                                <th>Company Name</th>
                                <th>TER Amount</th>
                                <th>TER Period From</th>
                                <th>TER Period To</th>
                                <th>AX Payble Amount</th>
                                <th>AX Voucher Code</th>
                                <th> <input type="checkbox" id="select_all" v-on:click="select_all_trx()" style="zoom: 2" />
                                </th>
                                <th>Action</th>



                                <!-- <th class="dt-no-sorting">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody id="tb">
                            <?php $i = 1;
                            foreach ($tercouriers as $key => $tercourier) {
                                // echo'<pre>'; print_r($tercourier);
                            ?>
                                <tr>
                                    <td>{{ $tercourier->id }}</td>
                                    <?php
                                    if ($tercourier->status == 1) {
                                        $status = 'Received';
                                        $class = 'btn-success';
                                    } elseif ($tercourier->status == 2) {
                                        $status = 'Handover';
                                        $class = 'btn-warning';
                                    } elseif ($tercourier->status == 3) {

                                        $status = 'Unpaid';
                                        $class = 'btn-success';
                                    } else {
                                        $status = 'Cancel';
                                        $class = 'btn-danger';
                                    }
                                    ?>
                                    <td>

                                        <span class="btn {{ $class }}">{{ $status }}</span>


                                    </td>
                                    <td>{{ ucwords(@$tercourier->SenderDetail->name) ?? '-' }}</td>
                                    <td>{{ $tercourier->SenderDetail->ax_id ?? '-' }}</td>
                                    <td>{{ $tercourier->SenderDetail->employee_id ?? '-' }}</td>
                                    <td>{{ ucwords($tercourier->location) ?? '-' }}</td>
                                    <td>{{ $tercourier->company_name ?? '-' }}</td>
                                    <td>{{ $tercourier->amount ?? '-' }}</td>
                                    <td>{{ Helper::ShowFormatDate($tercourier->terfrom_date) }}</td>
                                    <td>{{ Helper::ShowFormatDate($tercourier->terto_date) }}</td>
                                    <?php if ($tercourier->payable_amount != "") { ?>
                                        <td>
                                            <?php echo $tercourier->payable_amount; ?>
                                            <!-- <input type="number" placeholder="Enter Amount" id="existing_amount" class="existing_amount" name="amount" value="<?php echo $tercourier->payable_amount; ?>" disabled /> -->
                                        </td>
                                    <?php  } else { ?>
                                        <td>
                                            <input type="number" placeholder="Enter Amount" v-on:keyup=check_amount_id(<?php echo $tercourier->id; ?>) id="amount" class="amount" name="amount"  />
                                        </td>
                                    <?php } ?>

                                    <?php if ($tercourier->voucher_code != "") { ?>
                                        <td>
                                            <?php echo $tercourier->voucher_code; ?>
                                            <!-- <input type="text" placeholder="Enter Coupan" id="existing_voucher_code" class="existing_voucher_code" name="voucher_code" value="<?php echo $tercourier->voucher_code; ?>" disabled /> -->
                                        </td>
                                    <?php  } else { ?>
                                        <td>
                                            <input type="text" placeholder="Enter Coupan" id="voucher_code" v-on:keyup=check_coupon_id(<?php echo $tercourier->id; ?>) name="voucher_code" class="voucher_code" />
                                        </td>
                                    <?php } ?>

                                    <?php if ($tercourier->voucher_code != "" && $tercourier->payable_amount != "") { ?>

                                        <td><input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box_filled" disabled /></td>
                                        <td><button type="button" class="btn btn-warning adddetails btn-sm" disabled>Save</button></td>
                                    <?php  } else { ?>

                                        <td><input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box" value="<?php echo $tercourier->id; ?>"></td>
                                        <td><button type="button" class="btn btn-warning adddetails btn-sm" v-on:click="add_details(<?php echo $tercourier->id; ?>,<?php echo $tercourier->amount; ?>)" value="<?php echo $tercourier->id; ?>">Save</button></td>

                                    <?php } ?>



                                    <!-- <td> <a href="{{ url('edit-tercourier/' . $tercourier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="delete-courier/{{ $tercourier->id }}" class="btn btn-danger btn-sm">Delete</a>
                                                </td> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <td colspan="6">
                                    <a href="javascript:;" class="btn btn-danger" id="addmore"><i class="fa fa-fw fa-plus-circle"></i> Add row</a>
                                    <button type="submit" name="save" id="save" value="save" class="btn btn-primary" hidden><i class="fa fa-fw fa-save"></i> Save</button>
                                </td>
                            </tr>
                        </tfoot> -->

                    </table>

                <?php  } else { ?>


                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" id="select_all" v-on:click="select_all_trx()" style="zoom: 2" />
                                </th>
                                <th>UN ID</th>
                                <th>Status</th>
                                <th>Date of Receipt</th>
                                <th>Sender Name</th>
                                <th>AX ID</th>
                                <th>Employee ID</th>
                                <th>Location</th>
                                <th>Company Name</th>
                                <th>TER Amount</th>
                                <th>TER Period From</th>
                                <th>TER Period To</th>
                                <th>Other Details</th>
                                <th width="200px;">Remarks</th>
                                <th>Given To</th>
                                <th>Handover Date</th>
                                <th>Courier Name</th>
                                <th>Docket No</th>
                                <th>Docket Date</th>
                                <!-- <th class="dt-no-sorting">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody id="tb">
                            <?php $i = 1;
                            foreach ($tercouriers as $key => $tercourier) {
                            ?>
                                <tr>
                                    <td><input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box" value="<?php echo $tercourier->id; ?>"></td>
                                    <td>{{ $tercourier->id }}</td>
                                    <?php
                                    if ($tercourier->status == 1) {
                                        $status = 'Received';
                                        $class = 'btn-success';
                                    } elseif ($tercourier->status == 2) {
                                        $status = 'Handover';
                                        $class = 'btn-warning';
                                    } elseif ($tercourier->status == 3) {

                                        $status = 'Unpaid';
                                        $class = 'btn-success';
                                    } else {
                                        $status = 'Cancel';
                                        $class = 'btn-danger';
                                    }
                                    ?>
                                    <td>
                                        @if ($tercourier->status == 1)
                                        <span class="btn {{ $class }}">{{ $status }}</span>
                                        @else
                                        <span class="btn {{ $class }}">{{ $status }}</span>
                                        <!-- <button type="button" class="btn btn-warning addvoucherbtn btn-sm">Add Voucher</button> -->
                                        @endif
                                    </td>
                                    <td>{{ Helper::ShowFormatDate($tercourier->date_of_receipt) }}</td>
                                    <td>{{ ucwords(@$tercourier->SenderDetail->name) ?? '-' }}</td>
                                    <td>{{ $tercourier->SenderDetail->ax_id ?? '-' }}</td>
                                    <td>{{ $tercourier->SenderDetail->employee_id ?? '-' }}</td>
                                    <td>{{ ucwords($tercourier->location) ?? '-' }}</td>
                                    <td>{{ $tercourier->company_name ?? '-' }}</td>
                                    <td>{{ $tercourier->amount ?? '-' }}</td>
                                    <td>{{ Helper::ShowFormatDate($tercourier->terfrom_date) }}</td>
                                    <td>{{ Helper::ShowFormatDate($tercourier->terto_date) }}</td>
                                    <td>{{ ucfirst($tercourier->details) ?? '-' }}</td>
                                    <td>{{ ucfirst($tercourier->remarks) ?? '-' }}</td>
                                    <td>{{ $tercourier->given_to ?? '-' }}</td>
                                    <td>{{ Helper::ShowFormatDate($tercourier->delivery_date) }}</td>
                                    <td>{{ ucwords(@$tercourier->CourierCompany->courier_name) ?? '-' }}</td>
                                    <td>{{ $tercourier->docket_no ?? '-' }}</td>
                                    <td>{{ Helper::ShowFormatDate($tercourier->docket_date) }}</td>
                                    <!-- <td> <a href="{{ url('edit-tercourier/' . $tercourier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="delete-courier/{{ $tercourier->id }}" class="btn btn-danger btn-sm">Delete</a>
                                                </td> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <a href="javascript:;" class="btn btn-danger" id="addmore"><i class="fa fa-fw fa-plus-circle"></i> Add row</a>
                                    <button type="submit" name="save" id="save" value="save" class="btn btn-primary" hidden><i class="fa fa-fw fa-save"></i> Save</button>
                                </td>
                            </tr>
                        </tfoot>


                    </table>
                <?php  } ?>

            </div>
        </div>

    </div>
</div>





<script>
    new Vue({
        el: '#divbox',
        // components: {
        //   ValidationProvider
        // },
        data: {
            unique_amount_id: "",
            unique_coupon_id: "",
        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
        },
        methods: {
            select_all_trx: function() {
                var x = this.$el.querySelector("#select_all");
                var y = this.$el.querySelectorAll(".selected_box");
                if (x.checked == true) {
                    for (var i = 0; i < y.length; i++) {
                        y[i].checked = true;
                    }
                } else {
                    for (i = 0; i < y.length; i++) {
                        y[i].checked = false;
                    }
                }
            },

            change_to_unpaid: function() {
                var x = this.$el.querySelector("#tb");
                var box = x.querySelectorAll(".selected_box");
                var y = x.querySelectorAll(".voucher_code");
                var z = x.querySelectorAll(".amount");
                var total_amount= x.querySelectorAll(".tamount");
                var id = "";
                var final_total="";

                for (var i = 0; i < box.length; i++) {
                    // console.log(y[i].value);
                    if (box[i].checked) {
                        if (id == "") {
                            id += box[i].value;
                        } else {
                            id += "|" + box[i].value;
                        }
                    }
                }

                var coupon = "";
                var amount = "";

                for (var i = 0; i < y.length; i++) {
                    //   alert(y[i].value);

                    if (y[i].value != "") {
                        if (coupon == "") {
                            coupon += y[i].value;
                        } else {
                            coupon += "|" + y[i].value;
                        }
                    }
                }

                for (var i = 0; i < z.length; i++) {
                    // console.log(z[i].value);
                    if (z[i].value != "") {
                        if (amount == "") {
                            amount += z[i].value;
                        } else {
                            amount += "|" + z[i].value;
                        }
                    }
                }

                const myArray1 = amount.split("|");
                const myArray2 = coupon.split("|");
                const myArray3 = id.split("|");
                if (myArray1 != "" && myArray2 != "" && myArray3 != "") {
                    if (myArray1.length === myArray2.length && myArray2.length === myArray3.length) {
                        axios.post('/add_multiple_data', {
                                'coupon_code': coupon,
                                'amount': amount,
                                'selected_id': id
                            })
                            .then(response => {
                                console.log(response.data);
                                if (response.data >= 1) {
                                    // alert('hello')
                                    location.reload();
                                } else {
                                    swal('error', "Either Record is already updated,not selected or greater payable amount", 'error')
                                }

                            }).catch(error => {

                                console.log(response)
                                this.apply_offer_btn = 'Apply';

                            })
                    } else {
                        swal('error', "Either Record is not selected or field is empty", 'error')
                    }
                } else {
                    swal('error', "Either Record is not selected or field is empty", 'error')
                }

            },

            change_to_handover: function() {
                var x = this.$el.querySelector("#tb");
                var y = x.querySelectorAll(".selected_box");
                var trx_str = "";

                for (var i = 0; i < y.length; i++) {
                    // console.log(y[i].value);
                    if (y[i].checked) {
                        if (trx_str == "") {
                            trx_str += y[i].value;
                        } else {
                            trx_str += "|" + y[i].value;
                        }
                    }
                }
                // alert(trx_str)

                axios.post('/change_status', {
                        'selected_value': trx_str
                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data >= 1) {
                            location.reload();
                        } else {
                            swal('error', "Either Record is already updated or not selected", 'error')
                        }

                    }).catch(error => {

                        console.log(response)
                        this.apply_offer_btn = 'Apply';

                    })
            },

            check_amount_id: function($value) {
                this.unique_amount_id = $value;
            },
            check_coupon_id: function($value) {
                this.unique_coupon_id = $value;
            },

            add_details: function($id, $total_amount) {
                var unique_id = $id;
                var x = this.$el.querySelector("#tb");
                var y = x.querySelectorAll(".voucher_code");
                var z = x.querySelectorAll(".amount");


                var coupon = "";
                var amount = "";
                try {
                    coupon = document.getElementById("voucher_code").value;
                    amount = document.getElementById("amount").value;
                } catch {
                    swal('error', "This Operation can not be done", 'error')
                }
                // alert($total_amount);
                // alert(amount)
                // return $total_amount;
                if ($total_amount >= amount) {
                    if (amount != "" && coupon != "") {

                        if (this.unique_amount_id === this.unique_coupon_id && this.unique_amount_id === unique_id) {
                            axios.post('/add_data', {
                                    'coupon_code': coupon,
                                    'amount': amount,
                                    'selected_id': unique_id
                                })
                                .then(response => {
                                    console.log(response.data);
                                    if (response.data >= 1) {
                                        amount = "";
                                        coupon = "";
                                        location.reload();
                                    } else {
                                        swal('error', "Either Record is already updated or not selected", 'error')
                                    }

                                }).catch(error => {

                                    console.log(response)
                                    this.apply_offer_btn = 'Apply';

                                })
                        } else {
                            swal('error', "This operation can't be done", 'error')
                        }
                    } else {
                        swal('error', "This operation can't be done", 'error')
                    }
                }
                else {
                    swal('error', "Amount can't be greater than total amount", 'error')
                }

            }
        }


    })
</script>

@endsection
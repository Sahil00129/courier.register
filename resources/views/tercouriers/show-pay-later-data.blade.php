@extends('layouts.main')
@section('title', 'Pay Later Courier List')
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

    /* #divbox{
        zoom: 75%;
    } */
</style>


<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="divbox">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Pay Later Courier List</a></li>
            </ol>
        </nav>
    </div>



    <button class="btn btn-success" v-on:click="group_pay_now()" disabled>Group Pay Now</button>


    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">

                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>UN IDs</th>
                            <th> <input type="checkbox" id="select_all" v-on:click="select_all_trx()" style="zoom: 2" />
                            </th>
                            <th>Status & Action</th>
                            <th>Response from finfect</th>
                            <th>Date of Receipt</th>
                            <th>Sender Name</th>
                            <th>AX ID</th>
                            <th>Employee ID</th>
                            <th>Location</th>
                            <th>Company Name</th>
                            <th>TER Amount</th>
                            <th>TER Period From</th>
                            <th>TER Period To</th>
                            <th>Handover Date</th>
                            <th>Courier Name</th>
                            <th>Docket No</th>
                            <th>Docket Date</th>
                            <th>AX Payble Amount</th>
                            <th>AX Voucher Code</th>

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
                                <td>
                                <?php 
                                    if ($tercourier->status == 3) { ?>
                                    <input type="checkbox" id="selectboxid" name="select_box[]" class="selected_boxes" disabled/>
                                    <?php   } else { ?>

                                        <input type="checkbox" id="selectboxid" name="select_box[]" class="selected_box" value="<?php echo $tercourier->id; ?>"/>
                                     <?php   }
                                ?></td>
                                <?php
                                    if ($tercourier->status == 1) {
                                        $status = 'Received';
                                        $class = 'btn-success';
                                    } elseif ($tercourier->status == 2) {
                                        $status = 'Handover';
                                        $class = 'btn-warning';
                                    } elseif ($tercourier->status == 3) {

                                        $status = 'Sent to Finfect';
                                        $class = 'btn-success';
                                    }elseif ($tercourier->status == 4) {

                                        $status = 'Pay';
                                        $class = 'btn-success';
                                    }
                                     else {
                                        $status = 'Repay';
                                        $class = 'btn-danger';
                                    }
                                    ?>
                                <td>
                                    <?php 
                                    if ($tercourier->status == 3) { ?>

                                        <button type="button" class="btn {{ $class }}" v-on:click="pay_now_ter(<?php echo $tercourier->id; ?>)" value="<?php echo $tercourier->id; ?> " disabled>{{ $status }}</button>
                                <?php   } else { ?>
    
                                    <button type="button" class="btn {{ $class }}" v-on:click="pay_now_ter(<?php echo $tercourier->id; ?>)" value="<?php echo $tercourier->id; ?>">{{ $status }}</button>
                             <?php   }
                                ?>
                                </td>
                                <td>{{$tercourier->finfect_response}}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->date_of_receipt) }}</td>
                                <td>{{ ucwords(@$tercourier->sender_name) ?? '-' }}</td>
                                <td>{{ $tercourier->ax_id ?? '-' }}</td>
                                <td>{{ $tercourier->employee_id ?? '-' }}</td>
                                <td>{{ ucwords($tercourier->location) ?? '-' }}</td>
                                <td>{{ $tercourier->company_name ?? '-' }}</td>
                                <td>{{ $tercourier->amount ?? '-' }}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->terfrom_date) }}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->terto_date) }}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->delivery_date) }}</td>
                                <td>{{ ucwords(@$tercourier->CourierCompany->courier_name) ?? '-' }}</td>
                                <td>{{ $tercourier->docket_no ?? '-' }}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->docket_date) }}</td>

                                <td>
                                    <?php echo $tercourier->payable_amount; ?>
                                    <!-- <input type="number" placeholder="Enter Amount" id="existing_amount" class="existing_amount" name="amount" value="<?php echo $tercourier->payable_amount; ?>" disabled /> -->
                                </td>



                                <td>
                                    <?php echo $tercourier->voucher_code; ?>
                                    <!-- <input type="text" placeholder="Enter Coupan" id="existing_voucher_code" class="existing_voucher_code" name="voucher_code" value="<?php echo $tercourier->voucher_code; ?>" disabled /> -->
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>

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

            group_pay_now: function() {
                var x = this.$el.querySelector("#tb");
                var box = x.querySelectorAll(".selected_box");
                var id = "";
 
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


                const id_array = id.split("|");
                if (id_array != "") {
                        axios.post('/group_pay_now', {
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

            },


            pay_now_ter: function($id,) {
                var unique_id = $id;
        
                            axios.post('/pay_later_ter_now', {
                                    'selected_id': unique_id
                                })
                                .then(response => {
                                    console.log(response.data);
                                    if (response.data == 1) {
                                      
                                        location.reload();
                                    } else {
                                        swal('error', "System Error", 'error')
                                    }

                                }).catch(error => {

                                    console.log(response)
                                    this.apply_offer_btn = 'Apply';

                                })

            }
        }


    })
</script>

@endsection
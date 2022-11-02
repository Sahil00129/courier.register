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
    /* #divbox{
        zoom: 75%;
    } */
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
    <?php }?>

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
                                <!-- <th> <input type="checkbox" id="select_all" v-on:click="select_all_trx()" style="zoom: 2" />
                                </th>
                                <th>Action</th> -->



                                <!-- <th class="dt-no-sorting">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody id="tb">
                            <?php $i = 1;
                            foreach ($tercouriers as $key => $tercourier) {
                                // echo'<pre>'; print_r($tercourier);
                            ?>
                                <tr>
                                <?php if($tercourier->status==1 || $tercourier->status==2 || $tercourier->status==0){?>
                                    <td style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" v-on:click="open_ter_modal(<?php echo $tercourier->id ?>)">{{ $tercourier->id }}</td>
                                    <?php } else if ($tercourier->status == 5) {?>
                                        <td style="cursor:pointer" data-toggle="modal" data-target="#partialpaidModal" v-on:click="open_partial_paid_modal(<?php echo $tercourier->id ?>)">{{ $tercourier->id }}</td>
                                  <?php }  else {?>
                                    <td>{{ $tercourier->id }}</td>
                                    <?php } ?>
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
                                    elseif ($tercourier->status == 5) {

                                        $status = 'Paid';
                                        $class = 'btn-success';
                                    }elseif ($tercourier->status == 6) {

                                        $status = 'Cancel';
                                        $class = 'btn-danger';
                                    }
                                    elseif ($tercourier->status == 7) {

                                        $status = 'Partially Paid';
                                        $class = 'btn-success';
                                    }
                                    elseif ($tercourier->status == 8) {

                                        $status = 'Rejected';
                                        $class = 'btn-danger';
                                    }
                                    elseif ($tercourier->status == 9) {

                                        $status = 'Pending at HR';
                                        $class = 'btn-warning';
                                    }
                                     else {
                                        $status = 'Failed';
                                        $class = 'btn-danger';
                                    }
                                    ?>
                                    <td>

                                        <span class="btn {{ $class }}">{{ $status }}</span>


                                    </td>
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
                                    <td>{{ $tercourier->payable_amount ?? '-' }}</td>
                                    <td>{{ $tercourier->voucher_code ?? '-' }}</td>
                            



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
                                    <?php if($tercourier->status==1 || $tercourier->status==2 || $tercourier->status==0 ){?>
                                    <td style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" v-on:click="open_ter_modal(<?php echo $tercourier->id ?>)">{{ $tercourier->id }}</td>
                                   <?php } else {?>
                                    <td>{{ $tercourier->id }}</td>
                                    <?php } ?>
                                   <?php
                                    if ($tercourier->status == 1) {
                                        $status = 'Received';
                                        $class = 'btn-success';
                                    }
                                    elseif ($tercourier->status == 2) {
                                        $status = 'Handover';
                                        $class = 'btn-warning';
                                    }elseif ($tercourier->status == 8) {
                                        $status = 'Handover';
                                        $class = 'btn-warning';
                                    }
                                    elseif ($tercourier->status == 9) {
                                        $status = 'Handover';
                                        $class = 'btn-warning';
                                    }
                                     elseif ($tercourier->status == 3) {

                                        $status = 'Unpaid';
                                        $class = 'btn-success';
                                    } elseif ($tercourier->status == 6) {

                                        $status = 'Cancel';
                                        $class = 'btn-danger';
                                    } else {
                                        $status = 'Cancel';
                                        $class = 'btn-danger';
                                    }
                                    ?>
                                    <td>
                                       
                                        <span class="btn {{ $class }}">{{ $status }}</span>
                                        <!-- <button type="button" class="btn btn-warning addvoucherbtn btn-sm">Add Voucher</button> -->
                                     
                                    </td>
                                    <td>{{ Helper::ShowFormatDate($tercourier->date_of_receipt) }}</td>
                                    <td>{{ ucwords(@$tercourier->sender_name) ?? '-' }}</td>
                                    <td>{{ $tercourier->ax_id ?? '-' }}</td>
                                    <td>{{ $tercourier->employee_id ?? '-' }}</td>
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
   <!-- Modal -->
   <div class="modal fade show" id="exampleModal"  v-if="ter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cancel TER</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="ter_modal=false;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Ter ID:</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="ter_id" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Remarks:</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="cancel_remarks">
                                        </div>
                                    </form>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" @click="cancel_ter()" data-dismiss="modal" >Save changes</button>
                                    <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Get Passbook</button> -->
                                    <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
                                </div>
                              
                            </div>
                        </div>
                    </div>
                       <!-- Partial Paid Modal -->
   <div class="modal fade show" id="partialpaidModal"  v-if="partial_paid_modal" tabindex="-1" role="dialog" aria-labelledby="partialpaidModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="partialpaidModalLabel">Partial Paid - TER ID: @{{ter_id}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="partial_paid_modal=false;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Remarks:</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="partial_remarks">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Payable Amount</label>
                                            <input type="number" class="form-control" id="recipient-name" v-model="payable_amount">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Voucher Code</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="voucher_code">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Upload File</label>
                                            <input type="file" accept=".jpg,.pdf" class="form-control-file" id="fileupload" v-on:change="upload_file($event)">
                                        </div>
                                    </form>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" @click="update_payment()" data-dismiss="modal" >Save changes</button>
                                    <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Get Passbook</button> -->
                                    <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
                                </div>
                              
                            </div>
                        </div>
                    </div>
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
            ter_modal:false,
            partial_paid_modal:false,
            ter_id:"",
            cancel_remarks:"",
            diff_amount:"",
            partial_remarks:"",
            payable_amount:"",
            voucher_code:"",
            file:"",
            actual_amount:"",
            prev_payable_sum:"",

        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
        },
        methods: {
            update_payment:function(){
                if(this.partial_remarks != "" && this.voucher_code !="" && this.payable_amount !="" && this.file !=null){
                    if(parseInt(this.diff_amount)>=this.payable_amount)
                    {
                        const config = {
                headers: {
                  'content-type': 'multipart/form-data',
                }
              }
          let formData = new FormData();
              formData.append('file', this.file);
              formData.append('ter_id', this.ter_id);
              formData.append('remarks', this.partial_remarks);
              formData.append('voucher_code', this.voucher_code);
              formData.append('payable_amount', this.payable_amount);
              formData.append('actual_amount', this.actual_amount);
              formData.append('prev_payable_sum', this.prev_payable_sum);
              formData.append('left_amount', this.diff_amount);


                axios.post('/update_ter_deduction',formData,config)
                    .then(response => {
                        if (response.data[0] === "duplicate_voucher") {
                                swal('error', "Voucher Code : " + response.data[1] + " has been Already used", 'error')
                            } 
                      else if (response.data) {
                            swal('success', "Ter Id :"+this.ter_id+" has been sent to HR for payment", 'success')
                            location.reload();
                        } else {
                            swal('error', "System Error", 'error')
                            this.partial_paid_modal=false;
                            this.ter_id="";
                            location.reload();
                        }

                    }).catch(error => {

                        swal('error', error , 'error')
                            this.partial_paid_modal=false;
                            this.ter_id="";
                    })
                }else{
                    swal('error', "Payable Amount = "+ this.payable_amount+" can't be greater than Total Amount = "+this.diff_amount, 'error')
                }
                }else{
                    swal('error', "Fields are Empty", 'error')
                }
            },
            cancel_ter:function(){
                if(this.cancel_remarks != ""){
                axios.post('/cancel_ter', {
                        'ter_id': this.ter_id,
                        'remarks':this.cancel_remarks
                    })
                    .then(response => {
                        if (response.data) {
                            swal('success', "Ter Id :"+this.ter_id+" has been cancelled", 'success')
                            location.reload();
                        } else {
                            swal('error', "System Error", 'error')
                            this.ter_modal=false;
                            this.ter_id="";
                        }

                    }).catch(error => {

                        swal('error', error , 'error')
                            this.ter_modal=false;
                            this.ter_id="";
                    })
                }else{
                    swal('error', "Remarks needs to be added", 'error')
                }
            },
            upload_file(e){
          this.file = e.target.files[0];    
        },
            open_ter_modal:function(ter_id){
                this.ter_id=ter_id;
                this.ter_modal = true;
            },
            open_partial_paid_modal:function(ter_id){
                this.partial_paid_modal = true;
                this.ter_id=ter_id;
                axios.post('/check_deduction', {
                        'ter_id': this.ter_id,
                    })
                    .then(response => {
                        if (response.data[0] == "success") {
                            this.diff_amount=response.data[1];
                            this.actual_amount=response.data[2];
                            this.prev_payable_sum=response.data[3];
                        } else {
                            swal('error', "All dues are paid", 'error')
                            this.partial_paid_modal=false;
                            $('#partialpaidModal').modal('hide');
                        }
                        this.partial_remarks="";
                        this.payable_amount="";
                        this.voucher_code="";
                     document.getElementById("fileupload").value="";

                    }).catch(error => {

                        swal('error', error , 'error')
                            this.ter_modal=false;
                            this.ter_id="";
                    })
                // this.partial_paid_modal = true;
            },
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
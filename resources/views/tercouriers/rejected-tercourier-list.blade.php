@extends('layouts.main')
@section('title', 'Rejected Courier List')
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
                <li class="breadcrumb-item"><a href="javascript:void(0);">Rejected Courier List</a></li>
            </ol>
        </nav>
    </div>

    <?php
    if ($role == "tr admin") { ?>
        <button class="btn btn-success" disabled>Group Pay Now</button>
    <?php   } else { ?>

        <button class="btn btn-success" v-on:click="group_pay_now()" disabled>Group Pay Now</button>
    <?php   }
    ?>


   


    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">

                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>UN IDs</th>
                            <th>Status & Action</th>
                            <th>Response from finfect</th>
                            <th>Sender Name</th>
                            <th>Employee ID</th>
                            <th>AX ID</th>
                            <th>TER Period From</th>
                            <th>TER Period To</th>
                            <th>Amount Received</th>
                            <th>Received Date</th>
                            <th>Book Date</th>
                            <th>Paid Date</th>
                            <th>Remarks</th>
                            <th>AX Payble Amount</th>
                            <th>AX Voucher Code</th>
                            <th>Uploaded File</th>

                            <!-- <th class="dt-no-sorting">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody id="tb">
                        <?php $i = 1;
                        foreach ($tercouriers as $key => $tercourier) {
                            // echo'<pre>'; print_r($tercourier);
                        ?>
                            <tr>
                            <?php if($tercourier->status == 8 && $tercourier->file_name=="" && $role!="Hr Admin"){?>
                                <td style="cursor:pointer" data-toggle="modal" data-target="#partialpaidModal" v-on:click="open_ter_modal(<?php echo $tercourier->id ?>)">{{ $tercourier->id }}</td>
                                    <?php } else {?>
                                    <td>{{ $tercourier->id }}</td>
                                    <?php } ?>
                                <?php
                                if($tercourier->file_name=="")
                                {
                                    $status = 'Missing Info';
                                    $class = 'btn-danger';
                                }
                            elseif ($tercourier->status == 8 && $tercourier->file_name!="") {

                                    $status = 'Pay';
                                    $class = 'btn-success';
                                }
                              elseif ($tercourier->status == 3) {

                                    $status = 'Sent to Finfect';
                                    $class = 'btn-success';

                                }elseif($tercourier->status == 0 && $tercourier->txn_type=='rejected_ter'){
                                    $status = 'Repay';
                                    $class = 'btn-danger';
                                }


                                ?>
                                <td>
                                    <?php
                                    if ($tercourier->status == 3 || $role == "tr admin") { ?>

                                        <button type="button" class="btn {{ $class }}" v-on:click="pay_now_ter(<?php echo $tercourier->id; ?>)" value="<?php echo $tercourier->id; ?> " disabled>{{ $status }}</button>
                                    <?php   } else { ?>

                                        <button type="button" class="btn {{ $class }}" v-on:click="pay_now_ter(<?php echo $tercourier->id; ?>)" value="<?php echo $tercourier->id; ?>">{{ $status }}</button>
                                    <?php   }
                                    ?>
                                </td>
                                <td>{{$tercourier->finfect_response}}</td>
                                <td>{{ ucwords(@$tercourier->sender_name) ?? '-' }}</td>
                                <td>{{ $tercourier->employee_id ?? '-' }}</td>
                                <td>{{ $tercourier->ax_id ?? '-' }}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->terfrom_date) }}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->terto_date) }}</td>
                                <td>{{ $tercourier->amount ?? '-' }}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->received_date) ?? '-' }}</td>
                                <td>{{ Helper::ShowFormatDate($tercourier->book_date) }}</td>
                                <td>{{ $tercourier->paid_date ?? '-' }}</td>
                                <td>{{ $tercourier->remarks ?? '-' }}</td>
                                <td>{{ $tercourier->payable_amount ?? '-' }}</td>
                                <td>{{ $tercourier->voucher_code ?? '-' }}</td>
                               <input type="hidden" :value=<?php echo $tercourier->amount; ?>  id="total_amount"/>
                                <?php if($tercourier->status == 8 && $tercourier->file_name!=""){?>
                                    <td>
                                    <a
                                    target="_blank"
                                    href="rejected_ter_uploads/<?php echo $tercourier->file_name; ?>"
                                    >View</a>           
                                </td>
                                    <?php } else {?>
                                    <td>File Not Uploaded</td>
                                    <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>

                                      <!-- Partial Paid Modal -->
   <div class="modal fade show" id="partialpaidModal"  v-if="ter_modal" tabindex="-1" role="dialog" aria-labelledby="partialpaidModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="partialpaidModalLabel"> TER ID: @{{ter_id}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="ter_modal=false;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Remarks:</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="ter_remarks">
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
            ter_id:"",
            ter_remarks:"",
            payable_amount:"",
            voucher_code:"",
            file:"",
            total_amount:"",
            
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
            upload_file(e){
          this.file = e.target.files[0];    
        },
        update_payment:function(){
            this.total_amount=document.getElementById('total_amount').value;
                if(this.ter_remarks != "" && this.voucher_code !="" && this.payable_amount !="" && this.file !=null){
                    if(parseInt(this.total_amount)>=this.payable_amount)
                    {
                        const config = {
                headers: {
                  'content-type': 'multipart/form-data',
                }
              }
          let formData = new FormData();
              formData.append('file', this.file);
              formData.append('ter_id', this.ter_id);
              formData.append('remarks', this.ter_remarks);
              formData.append('voucher_code', this.voucher_code);
              formData.append('payable_amount', this.payable_amount);


                axios.post('/update_rejected_ter',formData,config)
                    .then(response => {
                        if (response.data[0] === "duplicate_voucher") {
                                swal('error', "Voucher Code : " + response.data[1] + " has been Already used", 'error')
                            } 
                      else if (response.data) {
                            swal('success', "Ter Id :"+this.ter_id+" has been sent to HR for payment", 'success')
                            location.reload();
                        } else {
                            swal('error', "System Error", 'error')
                            this.ter_modal=false;
                            this.ter_id="";
                            location.reload();
                        }

                    }).catch(error => {

                        swal('error', error , 'error')
                            this.ter_modal=false;
                            this.ter_id="";
                    })
                }else{
                    swal('error', "Payable Amount = "+ this.payable_amount+" can't be greater than Total Amount = "+this.total_amount, 'error')
                }
                }else{
                    swal('error', "Fields are Empty", 'error')
                }
            },
            open_ter_modal:function(ter_id){
                this.ter_modal = true;
                this.ter_id=ter_id;
                // axios.post('/check_deduction', {
                //         'ter_id': this.ter_id,
                //     })
                //     .then(response => {
                //         if (response.data[0] == "success") {
                //             this.diff_amount=response.data[1];
                //             this.actual_amount=response.data[2];
                //             this.prev_payable_sum=response.data[3];
                //         } else {
                //             swal('error', "All dues are paid", 'error')
                //             this.partial_paid_modal=false;
                //             $('#partialpaidModal').modal('hide');
                //         }
                //         this.partial_remarks="";
                //         this.payable_amount="";
                //         this.voucher_code="";
                //      document.getElementById("fileupload").value="";

                //     }).catch(error => {

                //         swal('error', error , 'error')
                //             this.ter_modal=false;
                //             this.ter_id="";
                //     })
                // this.partial_paid_modal = true;
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


            pay_now_ter: function($id) {
                var unique_id = $id;
                this.ter_id=$id;
                axios.post('/pay_later_ter_now', {
                        'selected_id': unique_id
                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data == 1) {
                            swal('success', "Ter Id :"+this.ter_id+" has been sent to Finfect for Payment", 'success')
                            location.reload();
                        } else {
                            swal('error', "System Error", 'error')
                            this.ter_id="";
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
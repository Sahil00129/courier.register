@extends('layouts.main')
@section('title', "Employee Doesn't Exist Courier List")
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
                <li class="breadcrumb-item"><a href="javascript:void(0);">Employee Doesn't Exist Courier List</a></li>
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

                            <!-- <th class="dt-no-sorting">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody id="tb">
                        <?php $i = 1;
                        foreach ($tercouriers as $key => $tercourier) {
                            // echo'<pre>'; print_r($tercourier);
                        ?>
                            <tr>
                            <?php if($role=="Hr Admin"){?>
                                <td style="cursor:pointer" data-toggle="modal" data-target="#partialpaidModal" v-on:click="open_ter_modal(<?php echo $tercourier->id ?>)">{{ $tercourier->id }}</td>
                                    <?php } else {?>
                                    <td>{{ $tercourier->id }}</td>
                                    <?php } ?>
                                <?php
                                if($tercourier->employee_id==0)
                                {
                                    $status = 'Missing Info';
                                    $class = 'btn-danger';
                                }
                              elseif ($tercourier->status == 2) {

                                    $status = 'Handover';
                                    $class = 'btn-warning';

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
                                <label for="inputPassword4">From</label>
                                <div>Actual Entry - @{{this.all_data.employee_id}}: @{{this.all_data.sender_name}} : @{{this.all_data.ax_id}} </div>
                                <!-- <input type="text" class="form-control" name="from" :value="this.all_data.sender_detail.name"  disabled> -->
                                <input type="text" class="form-control" v-on:change="get_sender_data(sender_all_info)" v-model="sender_all_info" list="sender_data" />
                                <datalist class="select2-selection__rendered" id="sender_data">
                                    <option v-for="sender_all_info in senders_data" :key="sender_all_info.employee_id">

                                        @{{sender_all_info.employee_id}} : @{{sender_all_info.name}} : @{{sender_all_info.ax_id}} : @{{sender_all_info.status}}
                                    </option>
                                </datalist>
                                <!-- <select
                              class="form-control"
                              id="select_employee"
                              v-model="sender_all_info"
                            >
                            <option selected disabled>search..</option>
                              <option
                                v-for="sender in senders_data"
                                :key="sender.id"
                                :value="sender.id"
                              >
                              
                              @{{sender.id}}  @{{sender.name}} : @{{sender.ax_id}} : @{{sender.employee_id}} : @{{sender.status}}
                              </option>
                            </select> -->
                                <!-- <input type="text" class="form-control" name="from" :value="this.all_data.sender_detail.name" disabled> -->
                            </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Remarks:</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="ter_remarks">
                                        </div>
                                    </form>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" @click="update_emp_details()" data-dismiss="modal" >Save changes</button>
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
            ter_modal:false,
            ter_id:"",
            ter_remarks:"",
            all_data:{},
            senders_data:"",
            sender_all_info:"",
            
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
            get_sender_data: function(data) {
                const emp_id = data.split(" : ");
                axios.post('/get_employees', {
                        'emp_id': emp_id[0]
                    })
                    .then(response => {
                        if (response.data) {
                            this.sender_location = response.data.data.location;
                            this.sender_telephone = response.data.data.telephone_no;
                            this.sender_status = response.data.data.status;
                        } else {
                            swal('error', "Not able to fetch employee details", 'error')
                        }

                    }).catch(error => {
                        this.got_data = false;
                        this.update_ter_flag = false;
                        this.button_text = "Search";


                    })
            },
            get_emp_list: function() {
                this.all_data = {};

                //  alert(this.unique_id);

                axios.post('/get_emp_list', {
                        'id': this.ter_id
                    })
                    .then(response => {
                        console.log(response.data)
                        // this.ter_modal = true;
                        this.all_data = response.data[0];
                        this.senders_data = response.data.all_senders_data;
                    }).catch(error => {
                   


                    })
            },
  
        update_emp_details:function(){
                if(this.ter_remarks != "" && this.sender_all_info !=""){
                    const sender_data_split = this.sender_all_info.split(" : ");
                    sender_emp_id = sender_data_split[0];
                    sender_name = sender_data_split[1];
                    ax_code = sender_data_split[2];

                axios.post('/update_emp_details',{
                        'remarks':this.ter_remarks,
                        'emp_id': sender_emp_id,
                        'emp_name': sender_name,
                        'ax_id': ax_code,
                        'id':this.ter_id

                })
                    .then(response => {
                        if (response.data) {
                            swal('success', "Ter Id :"+this.ter_id+" has been successfully updated", 'success')
                            location.reload();
                            } 

                    }).catch(error => {

                        swal('error', error , 'error')
                            this.ter_modal=false;
                            this.ter_id="";
                    })
              
                }else{
                    swal('error', "Fields are Empty", 'error')
                }
            },
            open_ter_modal:function(ter_id){
                this.ter_modal = true;
                this.ter_id=ter_id;
               this.get_emp_list();
              
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
@extends('layouts.main')
@section('title', 'Employee Passbook')
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
                <li class="breadcrumb-item"><a href="javascript:void(0);">Employee Passbook</a></li>
            </ol>
        </nav>
        <button type="button" class="btn btn-primary"   style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" @click="open_emp_modal()">Add Advance</button>
    </div>
    <button type="button" class="btn btn-primary"   style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" @click="imprest_report=true;emp_ledger=false">Imprest Report</button>
    <button type="button" class="btn btn-primary"   style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" @click="imprest_report=false;emp_ledger=true">Employee Ledger</button>
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing" v-if="imprest_report">
            <div class="widget-content widget-content-area br-6">
                <div class="row">
                    <div class="col">
                        <h5>Imprest Report Employee Wise</h5>
                    <h6>Employee Name : {{$employee_name}}</h6>
                    <h6>Current Balance : {{$current_balance}}</h6>
                    </div>
                </div>
                <input type="hidden" value="{{$emp_id}}" id="emp_id" />
            <!-- <h6>Current Balance : {{$current_balance}}</h6> -->
                    <table id="html5" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SNo.</th>
                                <th>Txn Date</th>
                                <th>Payment</th>
                                <th>Expense</th>
                                <th>Balance</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody id="tb">
                            <?php $i = 0;
                            foreach ($employee_balance_data as $key => $data) {
                                $i++;
                                // echo'<pre>'; print_r($tercourier);
                            ?>
                                <tr>
                                   
                                    <td>{{ $i }}</td>
                                    <td>{{ Helper::ShowFormatDate($data->updated_date) }}</td>
                                    <!-- <td>{{ ucwords(@$data->action_done) ?? '-' }}</td> -->
                                    <?php
                                    if ($data->action_done == 'Advance') {
                                        $amount = $data->advance_amount;
                                    } else{
                                        $amount="";
                                    }
                                    ?>
                                    <td>{{$amount}}</td>
                                    <?php if($data->action_done == 'Utilize') {
                                        $amount =  $data->utilize_amount;
                                    }else{
                                        $amount="";
                                    } ?>
                                    <td>{{$amount}}</td>
                                    <td>{{$data->current_balance}}</td>
                                    <?php
                                    if ($data->action_done == 'Advance') {
                                        $status = 'Payment-Advance';
                                    } elseif ($data->action_done == 'Utilize') {
                                        $status = 'Expense-TER UNID- '.$data->ter_id;
                                    } 
                                    ?>
                                    <td>
                                       {{$status}}
                                    </td>

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

              

            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing" v-if="emp_ledger">
            <div class="widget-content widget-content-area br-6">
                <div class="row">
                    <div class="col">
                        <h5>Employee TER Ledger</h5>
                    <h6>Employee Name : {{$employee_name}}</h6>
                    <!-- <h6>Current Balance : {{$current_balance}}</h6> -->
                    </div>
                </div>
                <input type="hidden" value="{{$emp_id}}" id="emp_id" />
            <!-- <h6>Current Balance : {{$current_balance}}</h6> -->
                    <table id="html5" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SNo.</th>
                                <th>Txn Date</th>
                                <th>Payment</th>
                                <th>Expense</th>
                                <th>Balance</th>
                                <th>Description</th>
                                <th>AX Voucher Number</th>
                            </tr>
                        </thead>
                        <tbody id="tb">
                            <td>1</td>
                            <?php if ($created_date){
                                        $date_created = Helper::ShowFormatDate($created_date);
                                    }?>
                            <td>{{$date_created}}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>New Employee</td>
                            <?php $i = 0;
                            foreach ($employee_balance_data as $key => $data) {
                                $i++;
                                // echo'<pre>'; print_r($tercourier);
                            ?>
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ Helper::ShowFormatDate($data->updated_date) }}</td>
                                    <!-- <td>{{ ucwords(@$data->action_done) ?? '-' }}</td> -->
                                    <?php
                                    if ($data->action_done == 'Advance') {
                                        $amount = $data->advance_amount;
                                    } else{
                                        $amount="";
                                    }
                                    ?>
                                    <td>{{$amount}}</td>
                                    <?php if($data->action_done == 'Utilize') {
                                        $amount =  $data->ter_paid;
                                    }else{
                                        $amount="";
                                    } ?>
                                    <td>{{$amount}}</td>
                                    <?php if ($data->ter_expense_balance != "")
                                    {
                                        $ter_expense=$data->ter_expense_balance;
                                    }else{
                                        $ter_expense=$data->current_balance;
                                    }
                                    ?>
                                    <td>{{$ter_expense}}</td>
                                    <?php
                                    if ($data->action_done == 'Advance') {
                                        $status = 'Imprest-Advance';
                                    } elseif ($data->action_done == 'Utilize') {
                                        $status = 'TER Booked-UNID- '.$data->ter_id;
                                    } 
                                    ?>
                                    <td>
                                       {{$status}}
                                    </td>
                                    <td>{{$data->ax_voucher_number}}</td>

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

              

            </div>
        </div>

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
                                            <label for="message-text" class="col-form-label">Add Voucher:</label>
                                            <input type="text" class="form-control" id="recipient-name" v-model="emp_voucher_number">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Add Advance Amount:</label>
                                            <input type="number" class="form-control" id="recipient-name" v-model="emp_advance_amount">
                                        </div>
                                    </form>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary"  data-dismiss="modal" @click="add_advance_payment()">Save changes</button>
                                    <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="get_employee_passbook()">Get Passbook</button> -->
                                    <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button>
                                </div>
                              
                            </div>
                        </div>
                    </div>

    </div>
</div>





<script>
    new Vue({
        el: '#divbox',
        data: {
            emp_id: "",
            emp_name: "",
            emp_all_data: "",
            emp_modal: false,
            emp_advance_amount:"",
            unique_id:"",
            current_balance:"",
            imprest_report:true,
            emp_ledger:false,
            emp_voucher_number:"",
        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
            
            // alert(this.emp_id);
        },
        methods: {
            add_advance_payment(){
                if(this.emp_voucher_number !=""){
                axios.post('/add_advance_payment', {
                        'emp_advance_amount': this.emp_advance_amount,
                        'ax_voucher_number':this.emp_voucher_number,
                        'emp_id':this.emp_id
                    })
                    .then(response => {
                        if (response.data) {
                            swal('success', "Advance Added Successfully!!!", 'success')
                            this.emp_modal=false;
                            this.emp_advance_amount="";
                            location.reload();
                        } else {
                            this.emp_modal=false;
                            this.emp_advance_amount="";
                            swal('error', "System Error", 'error')
                        }

                    }).catch(error => {



                    })
                }
                else{
                    swal('error', "Voucher Code is Empty", 'error')
                }
            },
            open_emp_modal() {
                this.emp_id=document.getElementById('emp_id').value;
                this.emp_modal = true;
                axios.post('/get_emp_data', {
                        'sender_id': this.emp_id
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

@endsection
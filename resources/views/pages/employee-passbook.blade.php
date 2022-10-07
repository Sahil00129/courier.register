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
    </div>

    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="row">
                    <div class="col">
                    <h6>Employee Name : {{$employee_name}}</h6>
                    <h6>Current Balance : {{$current_balance}}</h6>
                    </div>
                </div>
           
            <!-- <h6>Current Balance : {{$current_balance}}</h6> -->
                    <table id="html5" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SNo.</th>
                                <th>Date</th>
                                <th>Entry Type</th>
                                <th>Amount</th>
                                <th>Updated Amount</th>
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
                                        $status = 'Payment-Advance';
                                    } elseif ($data->action_done == 'Utilize') {
                                        $status = 'Expense-TER UNID- '.$data->ter_id;
                                    } 
                                    ?>
                                    <td>
                                       {{$status}}
                                    </td>
                                    <?php
                                    if ($data->action_done == 'Advance') {
                                        $amount = '-'.$data->advance_amount;
                                    } elseif ($data->action_done == 'Utilize') {
                                        $amount =  '+'.$data->utilize_amount;
                                    } 
                                    ?>
                                    <td>{{$amount}}</td>
                                    <td>{{$data->current_balance}}</td>

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

    </div>
</div>





<script>
    new Vue({
        el: '#divbox',
        data: {
         
        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
        },
        methods: {
     
        }


    })
</script>

@endsection
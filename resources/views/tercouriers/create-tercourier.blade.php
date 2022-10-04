@extends('layouts.main')
@section('title', 'Create Courier')
@section('content')
<style>
.list-group{
    width: 500px !important;
   
    padding: 10px !important;
    list-style-type: none;
}
/* .list-group {
    max-height: 230px;
    overflow-y: auto;
    /* // prevent horizontal scrollbar / */
    /* overflow-x: hidden;
  } */
  .list-group {
    max-height: 439px;
    overflow-y: auto;
    overflow-x: scroll;
}
#product_list {
    position: absolute;
    background: #e2e2e2;
    z-index: 9999;
    margin-top: 10px;
}
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }
   li:hover{  
    color: #1f4eaf;
 }  
 .editlable{
   
    color: gray;

 }
 .list-group-item {
    position: relative;
    display: block;
    padding: 10px;
    background-color: #f7f2f2;
    border: 1pxsolidrgba(0,0,0,.125);
    color: #000;
}
 /* <meta name="csrf-token" content="{{ csrf_token() }}" /> */
</style>
<?php
// echo'<pre>'; print_r($lastdate->date_of_receipt); die;
?>
   
<div class="container">
    <div class="container">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Add New TERCourier</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="#">Create New</a></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">    
                            </div>         
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <h5><b>Sender Details</b></h5>
                        <form id="new_tercourier_create" method="post" class="specify-numbers-price">
                            @csrf
                            
                            <div class="form-row mb-2">
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">From</label>
                                    <!-- <input type="text" class="form-control" name="" id="select_employee" autocomplete="off"> -->
                                    <select class="form-control  basic" name="sender_id" id="select_employee">
                                        <option selected disabled>search..</option>
                                        @foreach($senders as $sender)
                                        <option value="{{$sender->employee_id}}">{{$sender->name}} : {{$sender->ax_id}} : {{$sender->employee_id}} : {{$sender->status}}</option>
                                      @endforeach
                                    </select>
                                    <!-- <div id="product_list"></div> -->
                                </div>
                                <!-- <input type="hidden" class="form-control" name="sender_id"  id="senderID"> -->
                                <!--------------- Date of Receipt ---------->
                                <div class="form-group col-md-6">
                                     <label for="inputPassword4">Date of Receipt</label>
                                    <input type="date" class="form-control" name="date_of_receipt" value="{{$lastdate->date_of_receipt}}" Required>
                                </div>
                                <!--------------- end ------------------>
                            </div>

                            <div class="form-row mb-2">
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" readonly="readonly">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Telephone No.</label>
                                    <input type="text" class="form-control mbCheckNm"  id="telephone_no" name="telephone_no" autocomplete="off" maxlength="10" readonly="readonly">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Status</label>
                                    <input type="text" class="form-control"  id="emp_status" name="emp_status" autocomplete="off" readonly="readonly">
                                </div>
                                <input type="hidden" class="form-control"  id="last_working_date" name="last_working_date">
                            </div>
                            
                            <h5><b>Courier Details</b></h5>
                            <div class="form-row mb-2">
                                <div class="form-group col-md-4">
                                    <label for="inputState">Courier Name</label>
                                    <select id="slct" name="courier_id" class="form-control" onchange="yesnoCheck(this);">
                                        <option selected disabled>Select..</option>
                                        @foreach($couriers as $courier)
                                        <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket No.</label>
                                    <input type="text" class="form-control" id="docket_no" name="docket_no" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket Date</label>
                                    <input type="date" class="form-control" id="docket_date" name="docket_date">
                                    <p class="docketdate_error text-danger" style="display: none; color: #ff0000; font-weight: 500;">Docket date invalid.</p>
                                </div>
                            </div>
                <!------------Document details --------->           
              <!--  <div class="insertRowAfter" style="border-bottom: 3px solid #ffa69e; margin-bottom: 10px;">    -->                 
                            <h5><b>Document Details</b></h5>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4">
                                    <label for="inputState">Location</label>
                                    <input type="text" class="form-control location1" id="locations" name="location" Required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Company Name</label>
                                    <select id="for" name="company_name" class="form-control" onchange="receveCheck(this);">
                                        <option selected disabled>Select...</option>
                                        <option value="FMC">FMC</option>
                                        <option value="Corteva">Corteva</option>
                                        <option value="Unit-HSB">Unit-HSB</option>
                                        <option value="Remainco">Remainco</option>
                                    </select>
                                </div> 
                                <div class="form-group col-md-4">
                                    <label for="inputState">TER Amount</label>
                                    <input type="text" class="form-control" id="amount" name="amount" Required>
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">TER Period From</label>
                                    <input type="date" class="form-control" id="terfrom_date" name="terfrom_date" Required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">TER Period To</label>
                                    <input type="date" class="form-control" id="terto_date" name="terto_date" Required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Other Details</label>
                                    <input type="text" class="form-control" id="details" name="details">
                                </div>
                            </div>
         
                        <!--------------- Remarks ---------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control" rows="1" cols="70"></textarea>
                                </div>
                            </div>
                        <!--------------- end ------------------>
                            <h5><b>Handover Details</b></h5>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="remarks">Given To</label>
                                    <select class="form-control" id="given_to" name="given_to">
                                        <!-- <option value="">Select</option> -->
                                        <option value="Veena">Veena</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="remarks">Delivery Date</label>
                                    <input type="date" class="form-control" id="delivery_date" name="delivery_date">
                                </div>
                            </div>
         
                            <button type="submit" class="btn btn-primary" id="save_ter_btn">
                                <span class="indicator-label">Save</span>
	                            <span class="indicator-progress" style="display: none;">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button> 
                        </form>     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#delivery_date').val(new Date().toJSON().slice(0, 10));
        //////////
        // $('#select_employee').on('keyup',function () {
             
        //         var query = $(this).val();
        //         //alert(query);
        //         $.ajax({
        //             url:'{{ url('autocomplete-search') }}',
        //             type:'GET',
        //             data:{'search':query},
        //             beforeSend:function () {
        //                 $('#product_list').empty();
                        
        //             },
        //             success:function (data) {
        //                 // console.log(data.fetch);
        //                 $('#location').val('');
        //                 $('.location1').val('');
        //                 $('#telephone_no').val('');
        //                 $('#emp_status').val('');
        //                 $('#senderID').val('');
        //                 $('#product_list').html(data);

        //             }
        //         });
        //     });

           
        //     $(document).on('click', 'li', function(){
        //         var value = $(this).text(); 
        //         //console.log(value);
        //         var location = value.split(':');         //break value in js split
        //         for(var i = 0; i < location.length; i++){
        //             //console.log(location);
        //             var slct = location[0]+':'+location[2]+':'+location[3]+':'+location[5] ;

        //         $('#select_employee').val(slct);
        //         $('#location').val(location[1]);
        //         $('.location1').val(location[1]);
        //         $('#telephone_no').val(location[4]);
        //         $('#emp_status').val(location[5]);
        //         $('#senderID').val(location[6]);
        //         $('#product_list').html("");
        //         }
        //     });
    /*   $('#search').on('keyup',function () {
                var query = $(this).val();
                $.ajax({
                    url:'{{ url('autocomplete-search') }}',
                    type:'GET',
                    data:{'search':query},
                    success:function (data) {
                        $('#product_list').html(data);
                    }
                });
            }); */

    //// get employee data on change
    $('#select_employee').on('change', function() {
        var emp_id = $(this).val();
        // alert(emp_id);
        
        $.ajax({
            type      : 'GET',
            url       : "/get_employees",
            data      : {emp_id:emp_id},
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType  : 'json',
            cache     :   false, 
            contentType : false,
            processData : true,
            
            success:function(res){   
                if(res.data){
                    //alert(res.data);
                    console.log(res.data);
                    if(res.data.location == null){
                        var location = '';
                    }else{
                        var location = res.data.location;
                    }
                    if(res.data.telephone_no == null){
                        var telephone_no = '';
                    }else{
                        var telephone_no = res.data.telephone_no;
                    }
                    if(res.data.status == null){
                        var status = '';
                    }else{
                        var status = res.data.status;
                    }
                    $("#location").val(location);
                    $("#telephone_no").val(telephone_no);
                    $("#emp_status").val(status);
                    $("#last_working_date").val(res.data.last_working_date);
                    $(".location1").val(location);
                }
            }
        });
    });

    
        

});  



</script>

@endsection
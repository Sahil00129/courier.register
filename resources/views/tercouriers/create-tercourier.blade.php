@extends('layouts.main')
@section('title', 'Create Courier')
@section('content')
<style>
.list-group{
    width: 300px !important;
   
    padding: 10px !important;
    list-style-type: none;
}
.list-group {
    max-height: 230px;
    overflow-y: auto;
    / prevent horizontal scrollbar /
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }
   li:hover{  
    color: blue;
 }  
 .editlable{
   
    color: gray;

 }

</style>
   
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
                                    <select class="form-control  basic" name="sender_id" id="new_search">
                                        <option selected disabled>search..</option>
                                        @foreach($senders as $sender)
                                        <option value="{{$sender->id}}">{{$sender->name}} : {{$sender->ax_id}} : {{$sender->employee_id}}</option>
                                      @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Date of Receipt</label>
                                    <input type="date" class="form-control" name="date_of_receipt" Required>
                                </div>
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
                                        <option>Other</option>
                                    </select>
                                </div>
                        
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket No.</label>
                                    <input type="text" class="form-control" id="docket_no" name="docket_no" autocomplete="off" Required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket Date</label>
                                    <input type="date" class="form-control" id="docket_date" name="docket_date" Required>
                                </div>
                            </div>
                <!------------Document details --------->           
              <!--  <div class="insertRowAfter" style="border-bottom: 3px solid #ffa69e; margin-bottom: 10px;">    -->                 
                            <h5><b>Document Details</b></h5>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4">
                                    <label for="inputState">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" Required>
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
                                        <option value="">Select</option>
                                        <option value="Veena">Veena</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="remarks">Delivery Date</label>
                                    <input type="date" class="form-control" id="delivery_date" name="delivery_date">
                                </div>
                            </div>
         
                            <button type="submit" class="btn btn-primary">
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
        $("#new_search").change(function(){
            var value = $(this).children("option:selected").val();
            var location = value.split(':');  
            //break value in js split
            for(var i = 0; i < location.length; i++){
                $('#search').val(value);
                $('#location').val(location[1]);
                $('#telephone_no').val(location[2]);
                $('#customer_type').val(location[3]);
                $('#product_list').html("");
            }
        });

});  

function yesnoCheck(that) {
    if (that.value == "Other") {
        document.getElementById("ifYes").style.display = "block";
    } else {
        document.getElementById("ifYes").style.display = "none";
    }
}

function receveCheck(that) {
    if (that.value == "Other") {
        document.getElementById("ifYes_receiving").style.display = "block";
    } else {
        document.getElementById("ifYes_receiving").style.display = "none";
    }
}

</script>

@endsection
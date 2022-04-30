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
                    <li class="breadcrumb-item"><a href="#">Add New Courier</a></li>
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
                        <form id="new_courier_create" method="post" class="specify-numbers-price">
                            @csrf
                            <div class="form-row mb-2">
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">From</label>
                                    <select class="form-control  basic" name="name_company" id="new_search">
                                        <option selected disabled>search..</option>
                                        @foreach($senders as $sender)
                                        <option>{{$sender->name}} : {{$sender->location}} : {{$sender->telephone_no}} : {{$sender->type}}</option>
                                      @endforeach
                                    </select>
                                    <!-- <a class="btn btn-outline-primary" href="{{url('add-sender')}}">Add Sender</a> -->
                                </div>
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
                                    <label for="inputPassword4">Type</label>
                                    <input type="text" class="form-control"  id="customer_type" name="customer_type" autocomplete="off" readonly="readonly">
                                </div>
                            </div>
                            <h5><b>Courier Details</b></h5>
                            <div class="form-row mb-2">
                                <div class="form-group col-md-4">
                                    <label for="inputState">Courier Name</label>
                                    <select id="slct" name="slct" class="form-control" onchange="yesnoCheck(this);">
                                        <option selected disabled>Select..</option>
                                        @foreach($couriers as $courier)
                                        <option value="{{$courier->courier_name}}">{{$courier->courier_name}}</option>
                                        @endforeach
                                        <option>Other</option>
                                    </select><br>
                                    <!--courier other field -->
                                    <div id="ifYes" style="display: none">
                                        <input type="text" class="form-control" id="other" name="other_courier" placeholder="Other" autocomplete="off">
                                    </div>
                                    <!-- end -->
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
                            <div class="form-row mb-2">
                                <div class="form-group col-md-6">
                                    <label for="inputState">Document Catagories</label>
                                    <select id="catagories" name="catagories[]" class="form-control" onchange="catagoriesCheck(this);" Required>
                                        <option selected disabled>Select...</option>
                                        @foreach($categorys as $category)
                                        <option value="{{$category->catagories}}">{{$category->catagories}}</option>
                                        @endforeach
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">Receiving Company</label>
                                    <select id="for" name="for[]" class="form-control" onchange="receveCheck(this);">
                                        <option selected disabled>Select...</option>
                                        @foreach($forcompany as $forcomp)
                                        <option value="{{$forcomp->for_company}}">{{$forcomp->for_company}}</option>
                                        @endforeach
                                        <option>Other</option>
                                    </select><br>
                                    <!--courier other field -->
                                    <div id="ifYes_receiving" style="display: none;">
                                        <input type="text" class="form-control" id="" name="other_receiving[]"  placeholder="Other Receiving Company" autocomplete="off">
                                    </div>
                                    <!-- end -->
                                </div> 
                            </div>
            <!-------  Distributor Agreements catagories  -------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4"  id="distributor_agreement" style="display: none;">
                                    <label for="inputState">Distributor Agreements</label>
                                    <select id="" name="distributor_agreement[]" class="form-control">
                                        <option selected disabled>Select...</option>
                                        <option value="Distributor Agreement Form and Documents (SD-1)">Distributor Agreement Form and Documents (SD-1)</option>
                                        <option value="Distributor Agreement Form and Documents (SD-3)">Distributor Agreement Form and Documents (SD-3)</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="distributor_name" style="display: none;">
                                    <label for="inputPassword4">Distributor Name</label>
                                    <input type="text" class="form-control" id="" name="distributor_name[]" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="distributor_location" style="display: none;">
                                    <label for="inputPassword4">Distributor Location</label>
                                    <input type="text" class="form-control" id="" name="distributor_location[]" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="document_type" style="display: none;">
                                    <label for="inputPassword4">Document Type</label>
                                    <select class="form-control tagging" name="document_type[]" multiple="multiple">
                                        <option value="Agreement">Agreement</option>
                                        <option value="Security Check">Security Check</option>
                                        <option value="Documents">Documents</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" id="remarks_distributor" style="display: none;">
                                    <label for="inputPassword4">Remarks</label>
                                    <input type="text" class="form-control" id="" name="remarks_distributor[]" autocomplete="off">
                                </div>
                            </div>
        <!--------- 1st end ----------->
        <!------- Ledgers catagories -------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6"  id="ledger_for" style="display: none;">
                                    <label for="inputState">Ledgers</label>
                                    <select id="" name="ledger_for[]" class="form-control">
                                        <option selected disabled>Select...</option>
                                        <option value="Customer Ledger (SD-1)">Customer Ledger (SD-1)</option>
                                        <option value="Customer Ledger (SD-3)">Customer Ledger (SD-3)</option>
                                        <option value="Vendor Ledgers">Vendor Ledgers</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" id="type_l" style="display: none;">
                                    <label for="inputPassword4">Type</label>
                                    <input type="text" class="form-control" id="" name="type_ledger[]" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="party_name" style="display: none;">
                                    <label for="inputPassword4">Party Name</label>
                                    <input type="text" class="form-control" id="" name="party_name[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6" id="year_l" style="display: none;">
                                    <label for="inputPassword4">Year</label>
                                    <input type="text" class="form-control" id="" name="year_l[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
         <!-------------- 2nd end----------------------->
         <!------------  Invoice Type catagories------------>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4"  id="invoice_t" style="display: none;">
                                    <label for="inputState">Invoice Type</label>
                                    <select id="catagories" name="invoice_type[]" class="form-control">
                                        <option selected disabled>Select...</option>
                                        <option value="Transport Invoices">Transport Invoices</option>
                                        <option value="Courier Invoices">Courier Invoices</option>
                                        <option value="Marketing Invoices and other Documents">Marketing Invoices and other Documents</option>
                                        <option value="Rent Invoices">Rent Invoices</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="invoice_number" style="display: none;">
                                    <label for="inputPassword4">Invoice Number</label>
                                    <input type="text" class="form-control" id="" name="invoice_number[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="amount_i" style="display: none;">
                                    <label for="inputPassword4">Amount</label>
                                    <input type="text" class="form-control" id="" name="amount_invoice[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="party_name_i" style="display: none;">
                                    <label for="inputPassword4">Party Name</label>
                                    <input type="text" class="form-control" id="" name="party_name_invoices[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="month_i" style="display: none;">
                                    <label for="inputPassword4">Month</label>
                                    <input type="text" class="form-control" id="" name="month_invoices[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="discription_i" style="display: none;">
                                    <label for="inputPassword4">Discription</label>
                                    <input type="text" class="form-control" id="" name="discription_i[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
<!----------------- 3rd end ---------------------->
<!----------------- Bills catagories ----------------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4"  id="bills_type" style="display: none;">
                                    <label for="inputState">Bills Type</label>
                                    <select id="" name="bills_type[]" class="form-control">
                                        <option selected disabled>Select...</option>
                                        <option value="Electricity & water Bills">Electricity & water Bills</option>
                                        <option value="Security Invoice" >Security Invoices</option>
                                        <option value="Labour Contractor Invoices">Labour Contractor Invoices</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="invoice_number_b" style="display: none;">
                                    <label for="inputPassword4">Invoice Number</label>
                                    <input type="text" class="form-control" id="" name="invoice_number_bills[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="amount_b" style="display: none;">
                                    <label for="inputPassword4">Amount</label>
                                    <input type="text" class="form-control" id="" name="amount_bills[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="form-group col-md-4" id="previouse_reading_b" style="display: none;">
                                    <label for="inputPassword4">Previouse reading</label>
                                    <input type="text" class="form-control" id="" name="previouse_reading_b[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="current_reading_b" style="display: none;">
                                    <label for="inputPassword4">current reading</label>
                                    <input type="text" class="form-control" id="" name="current_reading_b[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="for_month_b" style="display: none;">
                                    <label for="inputPassword4">for the Month/year</label>
                                    <input type="text" class="form-control" id="" name="for_month_b[]" placeholder="" autocomplete="off">
                                </div>
                            </div>

<!------------------ 4th end ----------------->
<!------------  Bank Documents & Bills & Cheques catagories -------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6"  id="bank_name" style="display: none;">
                                    <label for="inputPassword4">Bank Name</label>
                                    <input type="text" class="form-control" id="" name="bank_name[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6" id="document_type_c" style="display: none;">
                                    <label for="inputPassword4">Document Type</label>
                                    <input type="text" class="form-control" id="" name="document_type_cheques[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="acc_number" style="display: none;">
                                        <label for="inputPassword4">A/c Number</label>
                                        <input type="text" class="form-control" id="" name="acc_number[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="for_month_c" style="display: none;">
                                    <label for="inputPassword4">for the Month/year</label>
                                    <input type="text" class="form-control" id="" name="for_month_cheques[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="series" style="display: none;">
                                    <label for="inputPassword4">Series</label>
                                    <input type="text" class="form-control" id="" name="series[]" placeholder="" autocomplete="off">
                                </div>
                            </div>

<!------------- End ---------------------->
<!------------ Imprest Statement catagories ------------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="statement_no" style="display: none;">
                                    <label for="inputPassword4">Statement No.</label>
                                    <input type="text" class="form-control" id="" name="statement_no[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="amount_imperest" style="display: none;">
                                    <label for="inputPassword4">Amount</label>
                                    <input type="text" class="form-control" id="" name="amount_imperest[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="for_month_imprest" style="display: none;">
                                    <label for="inputPassword4">for the Month/year</label>
                                    <input type="text" class="form-control" id="" name="for_month_imprest[]" placeholder="" autocomplete="off">
                                </div>
                            </div>

                <!----------- End ---------------->
                <!------- Legal Department Documents catagories ------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="discription_legal" style="display: none;">
                                    <label for="inputPassword4">Discription</label>
                                    <input type="text" class="form-control" id="" name="discription_legal[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="company_name_legal" style="display: none;">
                                    <label for="inputPassword4">Company Name</label>
                                    <input type="text" class="form-control" id="" name="company_name_legal[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="person_name_legal" style="display: none;">
                                    <label for="inputPassword4">Person name</label>
                                    <input type="text" class="form-control" id="" name="person_name_legal[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
   <!----------------End--------------------->
   <!-------------Principle Certificate catagories ---------------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="number_of_pc" style="display: none;">
                                    <label for="inputPassword4">Nubmer of PC</label>
                                    <input type="text" class="form-control" id="" name="number_of_pc[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="discription_pc" style="display: none;">
                                    <label for="inputPassword4">Discription</label>
                                    <input type="text" class="form-control" id="" name="discription_pc[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="company_name_pc" style="display: none;">
                                    <label for="inputPassword4">Company name</label>
                                    <input type="text" class="form-control" id="" name="company_name_pc[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
        <!--------------- End ---------------->
        <!------------- Government Letterscatagories ------------>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="document_number_govt" style="display: none;">
                                    <label for="inputPassword4">Document Number</label>
                                    <input type="text" class="form-control" id="" name="document_number_govt[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6" id="Discription_govt" style="display: none;">
                                    <label for="inputPassword4">Discription</label>
                                    <input type="text" class="form-control" id="" name="Discription_govt[]" placeholder="" autocomplete="off">
                                </div>
                            </div>

        <!--------------- End ----------------->
        <!-----------------DDR catagories ------------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="DDR_type" style="display: none;">
                                    <label for="inputState">DDR Type</label>
                                    <select id="" name="DDR_type[]" class="form-control">
                                        <option selected disabled>Select...</option>
                                        <option value="Dupont DDR">Dupont DDR</option>
                                        <option value="FMC DDR">FMC DDR</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="number_of_DDR" style="display: none;">
                                    <label for="inputPassword4">Number of DDR</label>
                                    <input type="text" class="form-control" id="" name="number_of_DDR[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="party_name_ddr" style="display: none;">
                                    <label for="inputPassword4">Party Name</label>
                                    <input type="text" class="form-control" id="" name="party_name_ddr[]" placeholder="" autocomplete="off">
                                </div>
                            </div>

        <!----------- End ------------->
        <!----------- Physical stock report catagories ---------->
                           <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="physical_stock_report" style="display: none;">
                                    <label for="inputState">Physical stock report</label>
                                    <select id="" name="physical_stock_report[]" class="form-control">
                                        <option selected disabled>Select...</option>
                                        <option value="Physical stock report (SD-1)">Physical stock report (SD-1)</option>
                                        <option value="Physical stock report (SD-3)">Physical stock report (SD-3)</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="discription_physical" style="display: none;">
                                    <label for="inputPassword4">Discription</label>
                                    <input type="text" class="form-control" id="" name="discription_physical[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4" id="month_physical" style="display: none;">
                                    <label for="inputPassword4">Month</label>
                                    <input type="text" class="form-control" id="" name="month_physical[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
        <!------------ End ------------>
        <!------------ Affidavits & Agreements catagories -------->
                           <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="discription_affidavits" style="display: none;">
                                    <label for="inputPassword4">Discription</label>
                                    <input type="text" class="form-control" id="" name="discription_affidavits[]" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6" id="company_name_affidavits" style="display: none;">
                                    <label for="inputPassword4">Company name</label>
                                    <input type="text" class="form-control" id="" name="company_name_affidavits[]" placeholder="" autocomplete="off">
                                </div>
                            </div>

        <!--------------- End ------------->
        <!--------------- IT Documents/Material catagories ---------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-10" id="discription_it" style="display: none;">
                                    <label for="inputPassword4">Discription</label>
                                    <input type="text" class="form-control" id="" name="discription_it[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
        <!------------- End ------------->
        <!------------- other ----------->
                           <div class="form-row mb-0">
                                <div class="form-group col-md-12" id="other_last" style="display: none;">
                                    <label for="inputPassword4">Other</label>
                                    <input type="text" class="form-control" id="" name="other_last[]" placeholder="" autocomplete="off">
                                </div>
                            </div>
        <!--------------- end ------------------>
        <!--------------- Remarks ---------->
                            <div class="form-row mb-2">
                                <div class="form-group col-md-6">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" rows="4" cols="70"></textarea>
                                </div>
                            </div>
        <!--------------- end ------------------>
         <!--        </div>
                      <div class="row">
                       <div class="col">
                       <button class="btn btn-warning btn-sm addrow" style="float:right; border-radius: 30%;" type="button">add</button>

                   </div>
             </div>  -->
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
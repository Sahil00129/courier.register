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
                                         <div class="form-group col-md-3">
                                             <label for="inputEmail4">From </label>
                                             <input type="text" class="form-control" id="search" name="name_company"  placeholder=""                                  autocomplete="off">
                                             <div id="product_list"></div>
                                         </div>
                                         <div class="form-group col-md-3">
                                             <label for="inputPassword4">Location</label>
                                             <input type="text" class="form-control" id="location" name="location" placeholder="" readonly="readonly">
                                         </div>
                                         <div class="form-group col-md-3">
                                             <label for="inputPassword4">Telephone No.</label>
                                             <input type="text" class="form-control"  id="telephone_no" name="telephone_no" placeholder=""                                  autocomplete="off" readonly="readonly">
                                         </div>
                                         <div class="form-group col-md-3">
                                             <label for="inputPassword4">Type</label>
                                             <input type="text" class="form-control"  id="ctype" name="ctype" placeholder=""                                  autocomplete="off" readonly="readonly">
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
                                         <input type="text" class="form-control" id="other" name="other"  placeholder="Other" autocomplete="off">
                                    </div>
                                        <!-- end -->
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Docket No.</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Docket Date</label>
                                        <input type="date" class="form-control" id="docket_date" name="docket_date" placeholder="">
                                    </div>
                                </div>
                                
                                <h5><b>Document Details</b></h5>
                                <div class="form-row mb-2">
                                <div class="form-group col-md-6">
                                        <label for="inputState">Add Catagories</label>
                                        <select id="catagories" name="catagories[]" class="form-control" onchange="catagoriesCheck(this);">
                                            <option selected disabled>Select...</option>
                                            @foreach($categorys as $category)
                                            <option value="{{$category->catagories}}">{{$category->catagories}}</option>
                                              @endforeach
                                              <option>Other</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="inputState">For</label>
                                          <select id="for" name="for[]" class="form-control">
                                              <option selected>Select...</option>
                                              @foreach($forcompany as $forcomp)
                                              <option value="{{$forcomp->for_company}}">{{$forcomp->for_company}}</option>
                                              @endforeach
                                              <option>Other</option>
                                          </select>
                                      </div> 
                                  </div>
      <!--------------------------  Distributor Agreements catagories  --------------------------->
                                  <div class="form-row mb-0">
                                 <div class="form-group col-md-4"  id="distributor_agreement" style="display: none;">
                                        <label for="inputState">Distributor Agreements</label>
                                        <select id="catagories" name="catagories" class="form-control">
                                            <option selected disabled>Select...</option>
                                              <option>Distributor Agreement Form and Documents (SD-1)</option>
                                              <option>Distributor Agreement Form and Documents (SD-3)</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-4" id="distributor_name" style="display: none;">
                                        <label for="inputPassword4">Distributor Name</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="document_type" style="display: none;">
                                        <label for="inputPassword4">Document Type</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                 <div class="form-row mb-0">
                                    <div class="form-group col-md-4" id="distributor_location" style="display: none;">
                                        <label for="inputPassword4">Distributor Location</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                      </div>
                                      <div class="form-group col-md-4" id="security_check" style="display: none;">
                                        <label for="inputPassword4">Security Check</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="documents" style="display: none;">
                                        <label for="inputPassword4">Documents</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                </div>
     <!------------------------------------- 1st end------------------------------------------>
     <!-----------------------------------  Ledgers catagories---------------------------------- -->
                               <div class="form-row mb-0">
                                 <div class="form-group col-md-6"  id="ledger_for" style="display: none;">
                                        <label for="inputState">Ledgers</label>
                                        <select id="catagories" name="catagories" class="form-control">
                                            <option selected disabled>Select...</option>
                                              <option>Customer Ledger (SD-1)</option>
                                              <option>Customer Ledger (SD-3)</option>
                                              <option>Vendor Ledgers</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6" id="type_l" style="display: none;">
                                        <label for="inputPassword4">Type</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                   </div>
                                   <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="party_name" style="display: none;">
                                        <label for="inputPassword4">Party Name</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-6" id="year_l" style="display: none;">
                                        <label for="inputPassword4">Year</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    </div>
         <!------------------------------------------- 2nd end----------------------------------------->
         <!------------------------------------  Invoice Type catagories------------------------------->
                                <div class="form-row mb-0">
                                 <div class="form-group col-md-4"  id="invoice_t" style="display: none;">
                                        <label for="inputState">Invoice Type</label>
                                        <select id="catagories" name="catagories" class="form-control">
                                            <option selected disabled>Select...</option>
                                              <option>Transport Invoices</option>
                                              <option>Courier Invoices</option>
                                              <option>Marketing Invoices and other Documents</option>
                                              <option>Rent Invoices</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-4" id="invoice_number" style="display: none;">
                                        <label for="inputPassword4">Invoice Number</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="amount_i" style="display: none;">
                                        <label for="inputPassword4">Amount</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="party_name_i" style="display: none;">
                                        <label for="inputPassword4">Party Name</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="month_i" style="display: none;">
                                        <label for="inputPassword4">Month</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="discription_i" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                </div>
<!------------------------------------------- 3rd end----------------------------------------->
<!------------------------------------------- Bills catagories------------------------------------>
                        <div class="form-row mb-0">
                                 <div class="form-group col-md-4"  id="bills_type" style="display: none;">
                                        <label for="inputState">Bills Type</label>
                                        <select id="catagories" name="catagories" class="form-control">
                                            <option selected disabled>Select...</option>
                                              <option>Electricity & water Bills</option>
                                              <option>Security Invoices</option>
                                              <option>Labour Contractor Invoices</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-4" id="invoice_number_b" style="display: none;">
                                        <label for="inputPassword4">Invoice Number</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="amount_b" style="display: none;">
                                        <label for="inputPassword4">Amount</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                 <div class="form-row mb-2">
                                    <div class="form-group col-md-4" id="previouse_reading_b" style="display: none;">
                                        <label for="inputPassword4">Previouse reading</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                      </div>
                                      <div class="form-group col-md-4" id="current_reading_b" style="display: none;">
                                        <label for="inputPassword4">current reading</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="for_month_b" style="display: none;">
                                        <label for="inputPassword4">for the Month/year</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                </div>

<!------------------------------------------- 4th end----------------------------------------->
<!----------------------------  Bank Documents & Bills & Cheques catagories ---------------------->
                         <div class="form-row mb-0">
                                 <div class="form-group col-md-6"  id="bank_name" style="display: none;">
                                 <label for="inputPassword4">Bank Name</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                      </div>
                                      <div class="form-group col-md-6" id="document_type_c" style="display: none;">
                                        <label for="inputPassword4">Document Type</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                   </div>
                                   <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="acc_number" style="display: none;">
                                        <label for="inputPassword4">A/c Number</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="for_month_c" style="display: none;">
                                        <label for="inputPassword4">for the Month/year</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="series" style="display: none;">
                                        <label for="inputPassword4">Series</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    </div>

<!----------------------------------------------End------------------------------------------->
<!---------------------------------------Imprest Statement catagories---------------------------------->
                           <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="statement_no" style="display: none;">
                                        <label for="inputPassword4">Statement No.</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="amount_imperest" style="display: none;">
                                        <label for="inputPassword4">Amount</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="for_month_imprest" style="display: none;">
                                        <label for="inputPassword4">for the Month/year</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    </div>

<!----------------------------------------------End------------------------------------------->
<!------------------------------Legal Department Documents catagories -------------------------------->
                          <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="discription_legal" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="company_name_legal" style="display: none;">
                                        <label for="inputPassword4">Company Name</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="person_name_legal" style="display: none;">
                                        <label for="inputPassword4">Person name</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    </div>

<!----------------------------------------------End---------------------------------------------->
<!---------------------------------Principle Certificate catagories ---------------------------------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="number_of_pc" style="display: none;">
                                        <label for="inputPassword4">Nubmer of PC</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="discription_pc" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="company_name_pc" style="display: none;">
                                        <label for="inputPassword4">Company name</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    </div>
<!----------------------------------------------End------------------------------------------->
<!---------------------------------Government Letterscatagories ---------------------------------->
                        <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="document_number_govt" style="display: none;">
                                        <label for="inputPassword4">Document Number</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-6" id="Discription_govt" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    </div>

<!----------------------------------------------End------------------------------------------->
<!-----------------------------------------DDR catagories ---------------------------------->
                        <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="DDR_type" style="display: none;">
                                <label for="inputState">DDR Type</label>
                                        <select id="catagories" name="catagories" class="form-control">
                                            <option selected disabled>Select...</option>
                                              <option>Dupont DDR</option>
                                              <option>FMC DDR</option>
                                          </select>
                                    </div>
                                      <div class="form-group col-md-4" id="number_of_DDR" style="display: none;">
                                        <label for="inputPassword4">Number of DDR</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="party_name_ddr" style="display: none;">
                                        <label for="inputPassword4">Party Name</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    </div>

<!-----------------------------------------------------End----------------------------------------------->

<!-----------------------------------------Physical stock report catagories ----------------------------->
                           <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="physical_stock_report" style="display: none;">
                                <label for="inputState">Physical stock report</label>
                                        <select id="catagories" name="catagories" class="form-control">
                                            <option selected disabled>Select...</option>
                                              <option>Physical stock report (SD-1)</option>
                                              <option>Physical stock report (SD-3)</option>
                                          </select>
                                    </div>
                                      <div class="form-group col-md-4" id="discription_physical" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="month_physical" style="display: none;">
                                        <label for="inputPassword4">Month</label>
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="" autocomplete="off">
                                    </div>
                                    </div>
<!-------------------------------------------------End---------------------------------------------->
                                 <button type="submit" class="btn btn-primary mt-3">Submit</button>
                              </form>
                                      
                            </div>
                          </div>
                     </div>
                 </div>
      
                </div>
                </div>
                <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
                <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

                <script type="text/javascript">
       // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       $(document).ready(function(){
     // alert('h'); die;


       $('#search').on('keyup',function () {
                var query = $(this).val();
                $.ajax({
                    url:'{{ url('autocomplete-search') }}',
                    type:'GET',
                    data:{'search':query},
                    success:function (data) {
                        $('#product_list').html(data);
                    }
                });
            });
            $(document).on('click', 'li', function(){
                var value = $(this).text();        
                var location = value.split(':');         //break value in js split
                for(var i = 0; i < location.length; i++){
           

                $('#search').val(value);
                $('#location').val(location[1]);
                $('#telephone_no').val(location[2]);
                $('#ctype').val(location[3]);
                $('#product_list').html("");
                }
            });

});
</script>

<script>
     function yesnoCheck(that) {
    if (that.value == "Other") {
        document.getElementById("ifYes").style.display = "block";
    } else {
        document.getElementById("ifYes").style.display = "none";
    }
}
</script>
@endsection
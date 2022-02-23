@extends('layouts.main')
@section('title', 'Create Courier')
@section('content')
   
<div class="container">
                <div class="container">

                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Update Courier</a></li>
                                
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
                                <form  method="POST" action="{{'update-data/'.$sender->id}}">
                                @csrf
                                @method('PUT')
            
                                        <div class="form-row mb-2">
                                         <div class="form-group col-md-3">
                                             <label for="inputEmail4">From </label>
                                             <input type="text" class="form-control" id="" name="name_company"  placeholder=""                                  autocomplete="off" value="{{$sender->name_company}}">
                                             <div id="product_list"></div>
                                         </div>
                                         <div class="form-group col-md-3">
                                             <label for="inputPassword4">Location</label>
                                             <input type="text" class="form-control" id="location" name="location" placeholder="" value="{{$sender->location}}" readonly="readonly">
                                         </div>
                                         <div class="form-group col-md-3">
                                             <label for="inputPassword4">Telephone No.</label>
                                              <input type="text" class="form-control"  id="telephone_no" name="telephone_no" placeholder=""                                  autocomplete="off" value="{{$sender->telephone_no}}" readonly="readonly">
                                         </div>
                                         <div class="form-group col-md-3">
                                             <label for="inputPassword4">Type</label>
                                             <input type="text" class="form-control"  id="" name="customer_type" placeholder=""                                  autocomplete="off" value="{{$sender->customer_type}}" readonly="readonly">
                                         </div>
                                     </div>
                                 
                                 
                                     <h5><b>Courier Details</b></h5>
                                    <div class="form-row mb-2">
                                    
                                       <div class="form-group col-md-4">
                                               <label for="inputState">Courier Name</label>
                                                  <select id="slct" name="slct" class="form-control" onchange="yesnoCheck(this);">
                                                  <option value="{{$sender->courier_name}}" selected >{{$sender->courier_name}}</option>
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
                                        <input type="text" class="form-control" id="docket_no" name="docket_no" placeholder=""  value="{{$sender->docket_no}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Docket Date</label>
                                        <input type="date" class="form-control" id="docket_date" name="docket_date" value="{{$sender->docket_date}}" placeholder="">
                                    </div>
                                </div>
                                
                                <h5><b>Document Details</b></h5>
                                <div class="form-row mb-2">
                                <div class="form-group col-md-6">
                                        <label for="inputState">Add Catagories</label>
                                        <select id="catagories" name="catagories" class="form-control" onchange="catagoriesCheck(this);">
                                        <option value="{{$sender->catagories}}" selected >{{$sender->catagories}}</option>
                                        @foreach($categorys as $category)
                                     <option value="{{$category->catagories}}">{{$category->catagories}}</option>
                                          @endforeach 
                                              <option>Other</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="inputState">For</label>
                                          <select id="for" name="for" class="form-control">
                                          <option value="{{$sender->for}}" selected >{{$sender->for}}</option>
                                          @foreach($forcompany as $forcomp)
                                     <option value="{{$forcomp->for_company}}">{{$forcomp->for_company}}</option>
	                                    	@endforeach
                                              <option>Other</option>
                                          </select>
                                      </div> 
                                  </div>
      <!---------------------------------  Distributor Agreements catagories  ------------------------------->
      <div class="form-row mb-0">
                                 <div class="form-group col-md-4"  id="distributor_agreement" style="display: none;">
                                        <label for="inputState">Distributor Agreements</label>
                                        <select id="catagories" name="distributor_agreement" class="form-control">
                                        <option value="{{$sender->distributor_agreement}}" selected >{{$sender->distributor_agreement}}</option>

                                              <option value="Distributor Agreement Form and Documents (SD-1)">Distributor Agreement Form and Documents (SD-1)</option>
                                              <option value="Distributor Agreement Form and Documents (SD-3)">Distributor Agreement Form and Documents (SD-3)</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-4" id="distributor_name" style="display: none;">
                                        <label for="inputPassword4">Distributor Name</label>
                                        <input type="text" class="form-control" id="" name="distributor_name" placeholder="" value="{{$sender->distributor_name}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="distributor_location" style="display: none;">
                                        <label for="inputPassword4">Distributor Location</label>
                                        <input type="text" class="form-control" id="" name="distributor_location" placeholder="" value="{{$sender->distributor_location}}" autocomplete="off">
                                      </div>
                                </div>
                                 <div class="form-row mb-0">
                                   
                                      <div class="form-group col-md-6" id="document_type" style="display: none;">
                                        <label for="inputPassword4">Document Type</label>
                                        <select class="form-control tagging" name="document_type" multiple="multiple">
                                        <option value="{{$sender->document_type}}" selected >{{$sender->document_type}}</option>     
                                      <option value="Agreement">Agreement</option>
                                      <option value="Security Check">Security Check</option>
                                      <option value="Documents">Documents</option>
                                    </select>
                                    </div>
                                    <div class="form-group col-md-6" id="remarks_distributor" style="display: none;">
                                        <label for="inputPassword4">Remarks</label>
                                        <input type="text" class="form-control" id="" name="remarks_distributor" placeholder="" value="{{$sender->remarks_distributor}}" autocomplete="off">
                                      </div>
                                </div>
     <!------------------------------------- 1st end------------------------------------------>
     <!-----------------------------------  Ledgers catagories---------------------------------- -->
                               <div class="form-row mb-0">
                                 <div class="form-group col-md-6"  id="ledger_for" style="display: none;">
                                        <label for="inputState">Ledgers</label>
                                        <select id="catagories" name="ledger_for" class="form-control">
                                        <option value="{{$sender->ledger_for}}" selected >{{$sender->ledger_for}}</option>
                                              <option value="Customer Ledger (SD-1)">Customer Ledger (SD-1)</option>
                                              <option value="Customer Ledger (SD-3)">Customer Ledger (SD-3)</option>
                                              <option value="Vendor Ledgers">Vendor Ledgers</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6" id="type_l" style="display: none;">
                                        <label for="inputPassword4">Type</label>
                                        <input type="text" class="form-control" id="" name="type_ledger" placeholder="" value="{{$sender->type_ledger}}" autocomplete="off">
                                    </div>
                                   </div>
                                   <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="party_name" style="display: none;">
                                        <label for="inputPassword4">Party Name</label>
                                        <input type="text" class="form-control" id="" name="party_name" placeholder="" value="{{$sender->party_name}}" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-6" id="year_l" style="display: none;">
                                        <label for="inputPassword4">Year</label>
                                        <input type="text" class="form-control" id="" name="year_l" placeholder="" value="{{$sender->year_l}}" autocomplete="off">
                                    </div>
                                    </div>
         <!------------------------------------------- 2nd end----------------------------------------->
         <!------------------------------------  Invoice Type catagories------------------------------->
                                <div class="form-row mb-0">
                                 <div class="form-group col-md-4"  id="invoice_t" style="display: none;">
                                        <label for="inputState">Invoice Type</label>
                                        <select id="catagories" name="invoice_type" class="form-control">
                                        <option value="{{$sender->invoice_type}}" selected >{{$sender->invoice_type}}</option>
                                              <option value="Transport Invoices">Transport Invoices</option>
                                              <option value="Courier Invoices">Courier Invoices</option>
                                              <option value="Marketing Invoices and other Documents">Marketing Invoices and other Documents</option>
                                              <option value="Rent Invoices">Rent Invoices</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-4" id="invoice_number" style="display: none;">
                                        <label for="inputPassword4">Invoice Number</label>
                                        <input type="text" class="form-control" id="" name="invoice_number" placeholder="" value="{{$sender->invoice_number}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="amount_i" style="display: none;">
                                        <label for="inputPassword4">Amount</label>
                                        <input type="text" class="form-control" id="" name="amount_invoice" placeholder="" value="{{$sender->amount_invoice}}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="party_name_i" style="display: none;">
                                        <label for="inputPassword4">Party Name</label>
                                        <input type="text" class="form-control" id="" name="party_name_invoices" value="{{$sender->party_name_invoices}}" placeholder="" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="month_i" style="display: none;">
                                        <label for="inputPassword4">Month</label>
                                        <input type="text" class="form-control" id="" name="month_invoices" placeholder="" value="{{$sender->month_invoices}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="discription_i" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="" name="discription_i" placeholder="" value="{{$sender->discription_i}}" autocomplete="off">
                                    </div>
                                </div>
<!------------------------------------------- 3rd end----------------------------------------->
<!------------------------------------------- Bills catagories------------------------------------>
                        <div class="form-row mb-0">
                                 <div class="form-group col-md-4"  id="bills_type" style="display: none;">
                                        <label for="inputState">Bills Type</label>
                                        <select id="" name="bills_type" class="form-control">
                                        <option value="{{$sender->bills_type}}" selected >{{$sender->bills_type}}</option>
                                              <option value="Electricity & water Bills">Electricity & water Bills</option>
                                              <option value="Security Invoices">Security Invoices</option>
                                              <option value="Labour Contractor Invoices">Labour Contractor Invoices</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-4" id="invoice_number_b" style="display: none;">
                                        <label for="inputPassword4">Invoice Number</label>
                                        <input type="text" class="form-control" id="" name="invoice_number_bills" placeholder="" value="{{$sender->invoice_number_bills}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="amount_b" style="display: none;">
                                        <label for="inputPassword4">Amount</label>
                                        <input type="text" class="form-control" id="" name="amount_bills" placeholder="" value="{{$sender->amount_bills}}" autocomplete="off">
                                    </div>
                                </div>
                                 <div class="form-row mb-2">
                                    <div class="form-group col-md-4" id="previouse_reading_b" style="display: none;">
                                        <label for="inputPassword4">Previouse reading</label>
                                        <input type="text" class="form-control" id="" name="previouse_reading_b" placeholder="" value="{{$sender->previouse_reading_b}}" autocomplete="off">
                                      </div>
                                      <div class="form-group col-md-4" id="current_reading_b" style="display: none;">
                                        <label for="inputPassword4">current reading</label>
                                        <input type="text" class="form-control" id="" name="current_reading_b" placeholder="" value="{{$sender->current_reading_b}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="for_month_b" style="display: none;">
                                        <label for="inputPassword4">for the Month/year</label>
                                        <input type="text" class="form-control" id="" name="for_month_b" placeholder="" value="{{$sender->for_month_b}}" autocomplete="off">
                                    </div>
                                </div>

<!------------------------------------------- 4th end----------------------------------------->
<!----------------------------  Bank Documents & Bills & Cheques catagories ---------------------->
                         <div class="form-row mb-0">
                                 <div class="form-group col-md-6"  id="bank_name" style="display: none;">
                                 <label for="inputPassword4">Bank Name</label>
                                        <input type="text" class="form-control" id="" name="bank_name" placeholder="" value="{{$sender->bank_name}}" autocomplete="off">
                                      </div>
                                      <div class="form-group col-md-6" id="document_type_c" style="display: none;">
                                        <label for="inputPassword4">Document Type</label>
                                        <input type="text" class="form-control" id="" name="document_type_cheques" placeholder="" value="{{$sender->document_type_cheques}}" autocomplete="off">
                                    </div>
                                   </div>
                                   <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="acc_number" style="display: none;">
                                        <label for="inputPassword4">A/c Number</label>
                                        <input type="text" class="form-control" id="" name="acc_number" placeholder="" value="{{$sender->acc_number}}" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="for_month_c" style="display: none;">
                                        <label for="inputPassword4">for the Month/year</label>
                                        <input type="text" class="form-control" id="" name="for_month_cheques" placeholder="" value="{{$sender->for_month_cheques}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="series" style="display: none;">
                                        <label for="inputPassword4">Series</label>
                                        <input type="text" class="form-control" id="" name="series" placeholder="" value="{{$sender->series}}" autocomplete="off">
                                    </div>
                                    </div>

<!----------------------------------------------End------------------------------------------->
<!---------------------------------------Imprest Statement catagories---------------------------------->
                           <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="statement_no" style="display: none;">
                                        <label for="inputPassword4">Statement No.</label>
                                        <input type="text" class="form-control" id="" name="statement_no" placeholder="" value="{{$sender->statement_no}}" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="amount_imperest" style="display: none;">
                                        <label for="inputPassword4">Amount</label>
                                        <input type="text" class="form-control" id="" name="amount_imperest" placeholder="" value="{{$sender->amount_imperest}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="for_month_imprest" style="display: none;">
                                        <label for="inputPassword4">for the Month/year</label>
                                        <input type="text" class="form-control" id="" name="for_month_imprest" placeholder="" value="{{$sender->for_month_imprest}}" autocomplete="off">
                                    </div>
                                    </div>

<!----------------------------------------------End------------------------------------------->
<!------------------------------Legal Department Documents catagories -------------------------------->
                          <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="discription_legal" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="" name="discription_legal" placeholder="" value="{{$sender->discription_legal}}" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="company_name_legal" style="display: none;">
                                        <label for="inputPassword4">Company Name</label>
                                        <input type="text" class="form-control" id="" name="company_name_legal" placeholder="" value="{{$sender->company_name_legal}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="person_name_legal" style="display: none;">
                                        <label for="inputPassword4">Person name</label>
                                        <input type="text" class="form-control" id="" name="person_name_legal" placeholder="" value="{{$sender->person_name_legal}}" autocomplete="off">
                                    </div>
                                    </div>

<!----------------------------------------------End---------------------------------------------->
<!---------------------------------Principle Certificate catagories ---------------------------------->
                            <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="number_of_pc" style="display: none;">
                                        <label for="inputPassword4">Nubmer of PC</label>
                                        <input type="text" class="form-control" id="" name="number_of_pc" placeholder="" value="{{$sender->number_of_pc}}" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-4" id="discription_pc" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="" name="discription_pc" placeholder="" value="{{$sender->discription_pc}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="company_name_pc" style="display: none;">
                                        <label for="inputPassword4">Company name</label>
                                        <input type="text" class="form-control" id="" name="company_name_pc" placeholder="" value="{{$sender->company_name_pc}}" autocomplete="off">
                                    </div>
                                    </div>
<!----------------------------------------------End------------------------------------------->
<!---------------------------------Government Letterscatagories ---------------------------------->
                        <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="document_number_govt" style="display: none;">
                                        <label for="inputPassword4">Document Number</label>
                                        <input type="text" class="form-control" id="" name="document_number_govt" placeholder="" value="{{$sender->document_number_govt}}" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-6" id="Discription_govt" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="" value="{{$sender->Discription_govt}}" name="Discription_govt" placeholder="" autocomplete="off">
                                    </div>
                                    </div>

<!----------------------------------------------End------------------------------------------->
<!-----------------------------------------DDR catagories ---------------------------------->
                        <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="DDR_type" style="display: none;">
                                <label for="inputState">DDR Type</label>
                                        <select id="" name="DDR_type" class="form-control">
                                        <option value="{{$sender->DDR_type}}" selected >{{$sender->DDR_type}}</option>
                                              <option value="Dupont DDR">Dupont DDR</option>
                                              <option value="FMC DDR">FMC DDR</option>
                                          </select>
                                    </div>
                                      <div class="form-group col-md-4" id="number_of_DDR" style="display: none;">
                                        <label for="inputPassword4">Number of DDR</label>
                                        <input type="text" class="form-control" id="" name="number_of_DDR" placeholder="" value="{{$sender->number_of_DDR}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="party_name_ddr" style="display: none;">
                                        <label for="inputPassword4">Party Name</label>
                                        <input type="text" class="form-control" id="" name="party_name_ddr" placeholder="" value="{{$sender->party_name_ddr}}" autocomplete="off">
                                    </div>
                                    </div>

<!-----------------------------------------------------End----------------------------------------------->

<!-----------------------------------------Physical stock report catagories ----------------------------->
                           <div class="form-row mb-0">
                                <div class="form-group col-md-4" id="physical_stock_report" style="display: none;">
                                <label for="inputState">Physical stock report</label>
                                        <select id="" name="physical_stock_report" class="form-control">
                                        <option value="{{$sender->physical_stock_report}}" selected >{{$sender->physical_stock_report}}</option>
                                              <option value="Physical stock report (SD-1)">Physical stock report (SD-1)</option>
                                              <option value="Physical stock report (SD-3)">Physical stock report (SD-3)</option>
                                          </select>
                                    </div>
                                      <div class="form-group col-md-4" id="discription_physical" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="" name="discription_physical" placeholder="" value="{{$sender->discription_physical}}" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4" id="month_physical" style="display: none;">
                                        <label for="inputPassword4">Month</label>
                                        <input type="text" class="form-control" id="" name="month_physical" placeholder="" value="{{$sender->month_physical}}" autocomplete="off">
                                    </div>
                                    </div>
<!-------------------------------------------------End---------------------------------------------->
<!---------------------------------- Affidavits & Agreements catagories ------------------------------>
                           <div class="form-row mb-0">
                                <div class="form-group col-md-6" id="discription_affidavits" style="display: none;">
                                        <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="" name="discription_affidavits" placeholder="" value="{{$sender->discription_affidavits}}" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-6" id="company_name_affidavits" style="display: none;">
                                        <label for="inputPassword4">Company name</label>
                                        <input type="text" class="form-control" id="" name="company_name_affidavits" value="{{$sender->company_name_affidavits}}" placeholder="" autocomplete="off">
                                    </div>
                                    </div>


<!-----------------------------------------------------End----------------------------------------------->
<!-----------------------------------------IT Documents/Material catagories ------------------------------>
                     <div class="form-row mb-0">
                                <div class="form-group col-md-10" id="discription_it" style="display: none;">
                                         <label for="inputPassword4">Discription</label>
                                        <input type="text" class="form-control" id="" name="discription_it" placeholder="" value="{{$sender->discription_it}}" autocomplete="off">
                                    </div>             
                                    </div>
<!-----------------------------------------------------End----------------------------------------------->
<!--------------------------------other----------------------------------------------------------->
<div class="form-row mb-0">
                                <div class="form-group col-md-12" id="other_last" style="display: none;">
                                         <label for="inputPassword4">Other</label>
                                        <input type="text" class="form-control" id="" value="{{$sender->other_last}}" name="other_last" placeholder="" autocomplete="off">
                                    </div>
                                      
                                    </div>
<!---------------------------------end-------------------------------------->
<!-----------------------------------------------Update Field ------------------------------------->
                      <div class="form-row mb-0">
                                <div class="form-group col-md-6" >
                                        <label for="inputPassword4">Checked By</label>
                                        <input type="text" class="form-control" id="" name="checked_by" placeholder="" value="{{$sender->checked_by}}" autocomplete="off">
                                    </div>
                                      <div class="form-group col-md-6">
                                        <label for="inputPassword4">Given To</label>
                                        <input type="text" class="form-control" id="" name="given_to" placeholder="" value="{{$sender->given_to}}" autocomplete="off">
                                    </div>
                                    </div>
<!-----------------------------------------------------End----------------------------------------------->

                                 <button type="submit" class="btn btn-primary mt-3">Update</button>
                              </form>
                                      
                            </div>
                          </div>
                     </div>
                 </div>
      
                </div>
                </div>
                <script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
                </script>
<script>
     function receveCheck(that) {
    if (that.value == "Other") {
        document.getElementById("ifYes_receiving").style.display = "block";
    } else {
        document.getElementById("ifYes_receiving").style.display = "none";
    }
}
</script>
@endsection
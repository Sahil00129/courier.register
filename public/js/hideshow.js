function catagoriesCheck(that) {
    if (that.value == "Distributor Agreements") {
        document.getElementById("distributor_agreement").style.display = "block";
        document.getElementById("distributor_name").style.display = "block";
        document.getElementById("distributor_location").style.display = "block";
        document.getElementById("document_type").style.display = "block";
        document.getElementById("remarks_distributor").style.display = "block";
   
    } else{
        document.getElementById("distributor_agreement").style.display = "none";
        document.getElementById("distributor_name").style.display = "none";   
        document.getElementById("document_type").style.display = "none";
        document.getElementById("distributor_location").style.display = "none";  
        document.getElementById("remarks_distributor").style.display = "none";
          
    }

    if (that.value == "Ledger") {
        document.getElementById("ledger_for").style.display = "block";
        document.getElementById("type_l").style.display = "block";
        document.getElementById("party_name").style.display = "block";
        document.getElementById("year_l").style.display = "block";
        
    } else{
        document.getElementById("ledger_for").style.display = "none";
        document.getElementById("type_l").style.display = "none";   
        document.getElementById("party_name").style.display = "none";
        document.getElementById("year_l").style.display = "none";  
        
    }

    if (that.value == "Invoices Type") {
        document.getElementById("invoice_t").style.display = "block";
        document.getElementById("invoice_number").style.display = "block";
        document.getElementById("amount_i").style.display = "block";
        document.getElementById("party_name_i").style.display = "block";
        document.getElementById("month_i").style.display = "block";
        document.getElementById("discription_i").style.display = "block";
        
    } else{
        document.getElementById("invoice_t").style.display = "none";
        document.getElementById("invoice_number").style.display = "none";   
        document.getElementById("amount_i").style.display = "none";
        document.getElementById("party_name_i").style.display = "none";  
        document.getElementById("month_i").style.display = "none";
        document.getElementById("discription_i").style.display = "none";  
        
    }

    if (that.value == "Bills") {
        document.getElementById("bills_type").style.display = "block";
        document.getElementById("invoice_number_b").style.display = "block";
        document.getElementById("amount_b").style.display = "block";
        document.getElementById("previouse_reading_b").style.display = "block";
        document.getElementById("current_reading_b").style.display = "block";
        document.getElementById("for_month_b").style.display = "block";
        
    } else{
        document.getElementById("bills_type").style.display = "none";
        document.getElementById("invoice_number_b").style.display = "none";   
        document.getElementById("amount_b").style.display = "none";
        document.getElementById("previouse_reading_b").style.display = "none";  
        document.getElementById("current_reading_b").style.display = "none";
        document.getElementById("for_month_b").style.display = "none";  
        
    }

    if (that.value == "Bank Documents & Bills & Cheques") {
        document.getElementById("bank_name").style.display = "block";
        document.getElementById("document_type_c").style.display = "block";
        document.getElementById("acc_number").style.display = "block";
        document.getElementById("for_month_c").style.display = "block";
        document.getElementById("series").style.display = "block";
       
        
    } else{
        document.getElementById("bank_name").style.display = "none";
        document.getElementById("document_type_c").style.display = "none";   
        document.getElementById("acc_number").style.display = "none";
        document.getElementById("for_month_c").style.display = "none";  
        document.getElementById("series").style.display = "none";
            
    }

    if (that.value == "Imprest Statement") {
        document.getElementById("statement_no").style.display = "block";
        document.getElementById("amount_imperest").style.display = "block";
        document.getElementById("for_month_imprest").style.display = "block";
 
    } else{
        document.getElementById("statement_no").style.display = "none";
        document.getElementById("amount_imperest").style.display = "none";   
        document.getElementById("for_month_imprest").style.display = "none";
            
    }
    if (that.value == "Legal Department Documents") {
        document.getElementById("discription_legal").style.display = "block";
        document.getElementById("company_name_legal").style.display = "block";
        document.getElementById("person_name_legal").style.display = "block";
 
    } else{
        document.getElementById("discription_legal").style.display = "none";
        document.getElementById("company_name_legal").style.display = "none";   
        document.getElementById("person_name_legal").style.display = "none";
            
    }
    if (that.value == "Principle Certificate") {
        document.getElementById("number_of_pc").style.display = "block";
        document.getElementById("discription_pc").style.display = "block";
        document.getElementById("company_name_pc").style.display = "block";
 
    } else{
        document.getElementById("number_of_pc").style.display = "none";
        document.getElementById("discription_pc").style.display = "none";   
        document.getElementById("company_name_pc").style.display = "none";
            
    }
    if (that.value == "Government Letters") {
        document.getElementById("document_number_govt").style.display = "block";
        document.getElementById("Discription_govt").style.display = "block";
       
 
    } else{
        document.getElementById("document_number_govt").style.display = "none";
        document.getElementById("Discription_govt").style.display = "none";   
           
    }
    if (that.value == "DDR") {
        document.getElementById("DDR_type").style.display = "block";
        document.getElementById("number_of_DDR").style.display = "block";
        document.getElementById("party_name_ddr").style.display = "block";
 
    } else{
        document.getElementById("DDR_type").style.display = "none";
        document.getElementById("number_of_DDR").style.display = "none";   
        document.getElementById("party_name_ddr").style.display = "none";
            
    }

    if (that.value == "Physical stock report") {
        document.getElementById("physical_stock_report").style.display = "block";
        document.getElementById("discription_physical").style.display = "block";
        document.getElementById("month_physical").style.display = "block";
 
    } else{
        document.getElementById("physical_stock_report").style.display = "none";
        document.getElementById("discription_physical").style.display = "none";   
        document.getElementById("month_physical").style.display = "none";       
    }
    if (that.value == "Affidavits & Agreements") {
        document.getElementById("discription_affidavits").style.display = "block";
        document.getElementById("company_name_affidavits").style.display = "block";
       
    } else{
        document.getElementById("discription_affidavits").style.display = "none";
        document.getElementById("company_name_affidavits").style.display = "none";   
            
    }
    if (that.value == "IT Documents/Material") {
        document.getElementById("discription_it").style.display = "block";
     
       
    } else{
        document.getElementById("discription_it").style.display = "none";
           
            
    }
    if (that.value == "Other") {
        document.getElementById("other_last").style.display = "block";
     
       
    } else{
        document.getElementById("other_last").style.display = "none";
           
            
    }

    

}
function catagoriesCheck(that) {
    if (that.value == "Distributor Agreements") {
        document.getElementById("distributor_agreement").style.display = "block";
        document.getElementById("distributor_name").style.display = "block";
        document.getElementById("document_type").style.display = "block";
        document.getElementById("distributor_location").style.display = "block";
        document.getElementById("security_check").style.display = "block";
        document.getElementById("documents").style.display = "block";
   
    } else{
        document.getElementById("distributor_agreement").style.display = "none";
        document.getElementById("distributor_name").style.display = "none";   
        document.getElementById("document_type").style.display = "none";
        document.getElementById("distributor_location").style.display = "none";  
        document.getElementById("security_check").style.display = "none";
        document.getElementById("documents").style.display = "none";  
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

}
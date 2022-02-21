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

}
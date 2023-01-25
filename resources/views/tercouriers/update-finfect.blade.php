@extends('layouts.main')
@section('title', 'Create Courier')
@section('content')
<style>
    .list-group {
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

    li:hover {
        color: #1f4eaf;
    }

    .editlable {

        color: gray;

    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 10px;
        background-color: #f7f2f2;
        border: 1 pxsolidrgba(0, 0, 0, .125);
        color: #000;
    }

    .form-control-sm-30 {
        height: calc(2.8em + 2px) !important;
    }

    .form-group label,
    label {
        font-size: 12px;
        margin-bottom: 0;
    }

    .editTer .form-row {
        border-radius: 12px;
        padding: 1rem 8px 2px;
        position: relative;
    }

    .editTer .form-row h6 {
        font-size: 0.875rem;
        position: absolute;
        top: -0.5rem;
        left: 1rem;
        background: #dee2f4;
        padding: 1px 8px;
        border-radius: 7px;
        box-shadow: 0 2px 2px #83838350;
    }

    .addButton {
        height: 40px;
        width: 80px;
        padding: 0;
        border-radius: 8px;
    }

    .removeButton {
        padding: 0 3px;
        height: 20px;
        width: 60px;
        font-size: 12px;
        line-height: 12px;
    }
</style>


@if($name == "admin")
<div class="container" id="edit_ter">
    <div class="container">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Update Finfect Status to Handover</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="#">Search ID</a></li>
                </ol>
            </nav>


            <div id="html5-extension_filter" class="dataTables_filter d-flex align-items-center" style="gap: 4px;">
                <label>
                    <input type="text" class="form-control" placeholder="Enter UN ID" v-model="unique_id" aria-controls="html5-extension" style="height: 30px;">
                </label>
                <button class="btn btn-success" v-on:click="get_data_by_id()" style="height: 30px; width: 80px; padding: 0; border-radius: 8px"> @{{button_text}}
                </button>
            </div>


        </div>


    </div>
</div>
@else
<div>
    <h1>Not Allowed</h1>
</div>
@endif


<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>

<script>
    new Vue({
        el: '#edit_ter',
        // components: {
        //   ValidationProvider
        // },
        data: {
            got_data: "",
            unique_id: "",
            all_data: {},
            button_text: "Submit",
        },
        mounted: function() {
            this.button_text = "Submit";

        },
        methods: {

            get_data_by_id: function() {
                this.button_text = "Submiting...";
                // alert(this.unique_id);
                // return 1;

                axios.post('/update_unid_status', {
                        'unique_id': this.unique_id,
                    })
                    .then(response => {

                        // console.log(response.data);
                        // if voucher code and payable amount is not available in DB
                        if (response.data == "not_possible") {
                            this.button_text = "Submit";
                            swal('error', "UNID "+this.unique_id+" is not Sent to Finfect", 'error')
                        }
                        if(response.data == 1)
                        {
                            this.button_text = "Submit";
                        swal('success', "UNID "+this.unique_id+" has been changed to Handover", 'success')
                        }


                    }).catch(error => {
                        this.got_data = false;
                        this.flag = false;
                        this.update_ter_flag = false;
                        this.button_text = "Search";


                    })
            },
        }


    })
</script>

<script>
    function onChangePeriodType() {
        var forMonth = document.getElementById('for_month')
        var forPeiod = document.getElementById('for_period')
        if (forMonth.checked) {
            document.getElementById('terfrom_date').disabled = true;
            document.getElementById('terto_date').disabled = true;
            document.getElementById('month').disabled = false;
        }
        if (forPeiod.checked) {
            document.getElementById('terfrom_date').disabled = false;
            document.getElementById('terto_date').disabled = false;
            document.getElementById('month').disabled = true;
        }
    }

    function onSelectMonth() {
        const selectedMonth = document.getElementById('month').value
        const currentYear = new Date().getFullYear()
        if (selectedMonth == 1 || selectedMonth == 3 || selectedMonth == 5 || selectedMonth == 7 || selectedMonth == 8 || selectedMonth == 10 || selectedMonth == 12) {
            document.getElementById('terfrom_date').value = `${currentYear}-${selectedMonth}-01`;
            document.getElementById('terto_date').value = `${currentYear}-${selectedMonth}-31`;
        } else if (selectedMonth == 2) {
            document.getElementById('terfrom_date').value = `${currentYear}-${selectedMonth}-01`;
            document.getElementById('terto_date').value = `${currentYear}-${selectedMonth}-28`;
        } else {
            document.getElementById('terfrom_date').value = `${currentYear}-${selectedMonth}-01`;
            document.getElementById('terto_date').value = `${currentYear}-${selectedMonth}-30`;
        }
    }
</script>

@endsection
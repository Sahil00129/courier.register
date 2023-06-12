@extends('layouts.main')
@section('title', 'Create PO')
@section('content')

<style>
    .required:after {
        content: " * ";
        color: red;
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


    input[type="file"]::file-selector-button {
        background: #ecfff5;
        padding: 1px 10px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        color: #28a745;
        border: 2px solid #28a745;
        transition: 1s;
    }

    input[type="file"]::file-selector-button:hover {
        border: 2px solid #28a745;
    }

    input[type="file"] {
        border: none;
        padding: 3px 0;
    }

    .loadingBlock {
        position: fixed;
        left: 50%;
        top: 0;
        background: #00000070;
        width: 100vw;
        height: 100%;
        transform: translateX(-50%);
        color: #fff;
        z-index: 999999;
        font-size: 1.1rem;
    }

    .select2-container {
        margin-bottom: 0 !important;
    }

    .appendTable {
        background: #dee2f4;
        border-radius: 20px;
        padding: 1rem;
        width: 100%;
    }

    .appendTable table {
        width: inherit
    }

    .appendTable table th {
        text-align: center;
    }

    .appendButton {
        width: 100%;
        text-align: right;
        font-weight: 600;
        color: #515365;
        cursor: pointer;
    }

    .removeItem {
        height: 16px;
        width: 16px;
        cursor: pointer;

    }

    .removeItem:hover {
        color: darkred;
    }

    .amountInfoArea {
        margin-top: 3rem;
        background: #fff;
        padding: 1rem;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        text-align: right;
    }

    .amountInfo {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
    }

    .amountInfo p {
        margin-bottom: 0;
    }

    .amountInfo p span {
        font-size: 13px;
        margin-right: 8px;
    }
    .select2-container--default .select2-selection--multiple{
        padding: 5px 16px;
    }
    input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        display: none;
      }
</style>

<div class="layout-px-spacing" id="add_po">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Pos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Create PO</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6 editTer">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div class="breadcrumb-title pe-3"><h5>Create User</h5></div> -->
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox box ">
                        <form class="general_form row" method="POST" action="{{url('/pos')}}" id="createpo">
                            @csrf

                            <div class="form-row mb-4 pt-4" style="width: 100%">
                                <h6><b>Supplier Info</b></h6>
                                <div class="form-group col-md-5">
                                    <label for="exampleFormControlInput2">PO Unit</label>
                                    <select class="form-control" name="unit" v-model="unit" id="select_unit" required>
                                        <option value="">Select Unit</option>
                                        <option value="SD1">SD1</option>
                                        <option value="SD3">SD3</option>
                                        <option value="MA2">MA2</option>
                                        <option value="MA4">MA4</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 poInputToggle" style="display: none;">
                                    <label for="exampleFormControlInput2">Select Vendor Details</label>
                                    <select class="form-control form-control-sm my-select2" name="vendor_details" id="select_pos" required>
                                        <option selected disabled>search..</option>
                                    </select>
                                    <label id="vendorDetailss" class=""><span id="vendorname"></span> || Id: <span id="vendorunique_id"></span></label>
                                </div>
                            </div>
                            <input type="hidden" name="vendor_code" id="vendor_code" />
                            <input type="hidden" name="vendor_name" id="vendor_name" />

                            <input type="hidden" name="vendor_unique_id" id="vendor_unique_id" />



                            <div class="form-row mb-4 pt-4" style="width: 100%">
                                <h6><b>PO Value</b></h6>
                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Total Amount </label>
                                    <input type="number" class="form-control" name="po_value" id="po_value" placeholder="">
                                </div>

                                <!-- div class="appendTable">

                                    <table id="appendTable">
                                        <thead id="itemTable">
                                            <th style="width: 20%; text-align: left">Item Type</th>
                                            <th style="text-align: left">Item Description</th>
                                            <th style="width: 100px">Quantity</th>
                                            <th style="width: 100px">Unit Price</th>
                                            <th style="width: 140px">Total Amount</th>
                                            <th></th>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control" name="data[1][item_type]" id="item_type" required>
                                                        <option value="">Select Item Type</option>
                                                        <option value="Service">Service</option>
                                                        <option value="Product">Product</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control" name="data[1][item_desc]" /></td>
                                                <td><input type="number" class="form-control quantity" name="data[1][quantity]" required /></td>
                                                <td><input type="number" class="form-control unitPrice" name="data[1][unit_price]"  required /></td>
                                                <td><input type="number" class="form-control totalAmount" name="data[1][total_amount]"  readonly /></td>
                                                <td>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash" style="opacity: 0; pointer-events: none">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="appendButton"><span onclick="appendRow()">Add Item</span></div>

                                    <div class="amountInfoArea">
                                        <div class="d-flex flex-column align-items-start">
                                            <label for="exampleFormControlInput2">GST Rate </label>
                                            <input type="number" class="form-control" name="gst_rate" id="gst_rate" required placeholder="">
                                        </div>

                                        <div class="amountInfo">
                                            <p><span>GST Amount: </span> <span id="gstAmount"></span></p>
                                            <p><span>Total Taxable Amount: </span> <span id="totalTaxAmount"></span> </p>
                                            <p><span>Total PO Value Amount: </span> <span id="poAmount"></span></p>
                                        </div>

                                        <input type="hidden" name="total_tax_amount" id="total_tax_amount" />
                                        <input type="hidden" name="gst_amount" id="gst_amount" />
                                        <input type="hidden" name="po_value" id="po_value" />

                                    </div>
                                </div -->


                            </div>

                            <div class="form-row mb-4 pt-4" style="width: 100%">
                                <h6><b>Other PO Items</b></h6>

                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Source PO Number </label>
                                    <input type="number" class="form-control" name="source_po_num" id="source_po_num" placeholder="">
                                </div>

                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">ERP Number </label>
                                    <input type="number" class="form-control" name="erp_num" id="erp_num" placeholder="">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Po State</label>
                                    <select class="form-control tagging approvalReq" multiple="multiple" name="state[]">
                                        <option value="" disabled>--Select--</option>
                                        @foreach($state_json_data as $state_names)
                                        <option value="{{$state_names['state']}}">{{$state_names['state']}}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Crops</label>
                                    <select class="form-control tagging approvalReq" multiple="multiple" name="crop[]">
                                        <option value="" disabled>--Select--</option>
                                        @foreach($crop_json_data as $crop_data)
                                        <option value="{{$crop_data['crop_names']}}">{{$crop_data['crop_names']}}</option>
                                        @endforeach

                                    </select>
                                </div>



                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">AMM/AGM </label>
                                    <input type="text" class="form-control" name="amm_agm" id="amm_agm" placeholder="">
                                </div>

                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Product </label>
                                    <input type="text" class="form-control" name="product" id="product" placeholder="">
                                </div>
                            </div>



                            <div class="col-12 d-flex align-items-center justify-content-end" style="gap:1rem;">
                                <a class="btn btn-outline-primary" href="{{url('/pos') }}"> Back</a>
                                <button type="submit" class="mt-4 mb-4 btn btn-primary submit_po" id="submit_po">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>

<script>
    let tableRows = 2;
    const appendRow = () => {
        let node = ``;
        node += `<tr>
                    <td>
                        <select class="form-control" name="data[${tableRows}][item_type]" id="item_type">
                            <option value="">Select Item Type</option>
                            <option value="Service">Service</option>
                            <option value="Product">Product</option>
                        </select>
                    </td>
                    <td><input class="form-control" name="data[${tableRows}][item_desc]" /></td>
                    <td><input class="form-control quantity" name="data[${tableRows}][quantity]" /></td>
                    <td><input class="form-control unitPrice" name="data[${tableRows}][unit_price]" /></td>
                    <td><input class="form-control totalAmount" name="data[${tableRows}][total_amount]" readonly/></td>
                    <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash removeItem">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                    </td>
                </tr>`;
        $('#appendTable').find('tbody').append(node);
        tableRows++;
    }

    $(document).on("click", ".removeItem", function() {
        $(this).closest("tr").remove();
    });
</script>


<script>
    new Vue({
        el: '#add_po',
        // components: {
        //   ValidationProvider
        // },
        data: {

            word_amount: ".",
            po_value: "",
            unit: "",
            vendors_data: {},
            vendor_all_info: "",
            vendor_code: "",
            vendor_name: "",
            vendor_block: false,


        },
        created: function() {

        },
        mounted: function() {


        },
        methods: {

            set_vendor_data(vendor_all_info) {
                console.log(vendor_all_info)
                if (vendor_all_info != "") {
                    const vendor_data_split = this.vendor_all_info.split(" : ");
                    this.vendor_name = vendor_data_split[1];
                    this.vendor_code = vendor_data_split[2];
                } else {
                    this.vendor_code = "";
                    this.vendor_name = "";
                }
            },
            get_vendor_details(type) {
                if (type != "") {
                    this.vendor_all_info = "";
                    this.vendor_code = "";
                    this.vendor_name = "";
                    this.vendor_block = true;

                    axios.get('/get_vendors/' + type)
                        .then(response => {
                            if (response.data) {
                                if (response.data.length != 0) {
                                    this.vendors_data = response.data;

                                } else {
                                    this.vendor_block = false;
                                    this.vendor_name = "";
                                    this.vendor_code = "";
                                }
                            } else {

                                swal('error', "Unable to Fetch", 'error')

                            }

                        }).catch(error => {


                        })
                } else {
                    this.vendor_all_info = {};
                    this.vendor_code = "";
                    this.vendor_name = "";
                    this.vendor_block = false;
                }
            },

            inWords: function(num) {
                var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
                var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
                if ((num = num.toString()).length > 9) return 'overflow';
                n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
                if (!n) return;
                var str = '';
                str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
                str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
                str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
                str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
                str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
                return str;
            },
            amount_in_words: function(amount) {
                this.word_amount = this.inWords(amount);
                document.getElementById('amountInwords').style.textTransform = "capitalize";
            },
        }


    })
</script>
@endsection
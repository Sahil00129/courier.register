@extends('layouts.main')
@section('title', 'Create PO')
@section('content')

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
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div class="breadcrumb-title pe-3"><h5>Create User</h5></div> -->
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form class="general_form row" method="POST" action="{{url('/pos')}}" id="createpo">
                            @csrf
                        <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">PO Unit</label>
                                <select class="form-control" name="unit" v-model="unit" id="select_unit" >
                                    <option value="">Select Unit</option>
                                    <option value="SD1">SD1</option>
                                    <option value="SD3">SD3</option>
                                    <option value="MA2">MA2</option>
                                    <option value="MA4">MA4</option>
                                </select>
                                <!-- <input type="text" class="form-control" name="unit" id="unit" placeholder=""> -->
                            </div>

                                <div class="form-group mb-4 col-md-6 poInputToggle" style="display: none;" >
                                    <label for="exampleFormControlInput2">Select Vendor Details</label>
                                    <select class="form-control form-control-sm my-select2" name="po_id" id="select_pos" required>
                                        <option selected disabled>search..</option>
                                    </select>
                                </div>

                            <div class="form-group mb-4 col-md-6 poInputToggle"  style="display: none;">
                                <label for="exampleFormControlInput2">Vendor Code</label>
                                <input type="text" class="form-control" name="vendor_code" id="vendor_code"  placeholder="" readonly>
                            </div>

                            <input type="hidden" id="vendor_unique_id" name="vendor_unique_id" />
                     
                            <div class="form-group mb-4 col-md-6 poInputToggle"  style="display: none;">
                                <label for="exampleFormControlInput2">Vendor Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name"   placeholder="" readonly>
                            </div>

                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">PO Value (Including GST)</label>
                                <input type="number" class="form-control" name="po_value" id="po_value" v-model="po_value" placeholder=""  @keyup="amount_in_words(po_value)">
                                <span id="amountInwords" style="font-size: 12px;text-transform:capitalize;">@{{word_amount}}</span>
                            </div>

                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Activity </label>
                                <input type="text" class="form-control" name="activity" id="activity" placeholder="">
                            </div>
                      
                            
                            <div class="col-12 d-flex align-items-center justify-content-end" style="gap:1rem;">
                            <a class="btn btn-outline-primary" href="{{url('/pos') }}"> Back</a>
                                <button type="submit" class="mt-4 mb-4 btn btn-primary">Submit</button>
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    new Vue({
        el: '#add_po',
        // components: {
        //   ValidationProvider
        // },
        data: {
        
            word_amount: ".",
            po_value:"",
            unit:"",
            vendors_data:{},
            vendor_all_info:"",
            vendor_code:"",
            vendor_name:"",
            vendor_block:false,
      

        },
        created: function() {
      
        },
        mounted: function() {
        

        },
        methods: {
         
            set_vendor_data(vendor_all_info){
                console.log(vendor_all_info)
                if (vendor_all_info != "") {
                    const vendor_data_split = this.vendor_all_info.split(" : ");
                    this.vendor_name = vendor_data_split[1];
                    this.vendor_code = vendor_data_split[2];
                } else{
                   this.vendor_code="";
                   this.vendor_name="";
                }
            },
            get_vendor_details(type){
                if(type!=""){
                    this.vendor_all_info="";
                    this.vendor_code="";
                    this.vendor_name="";
                    this.vendor_block =true;
                
           axios.get('/get_vendors/'+type)
               .then(response => {
                   if (response.data) {
                    if(response.data.length != 0)
                    {
                        this.vendors_data=response.data;

                    }else{
                        this.vendor_block = false;
                        this.vendor_name="";
                        this.vendor_code="";
                    }
                   }else{
                      
                       swal('error', "Unable to Fetch", 'error')
                     
                   }

               }).catch(error => {


               })
            }
            else{
                this.vendor_all_info={};
                    this.vendor_code="";
                    this.vendor_name="";
                this.vendor_block=false;
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
@extends('layouts.mobile-main')
@section('title', 'Add Invoice')
@section('content')

<style>
    .list-group {
        width: 500px !important;

        padding: 10px !important;
        list-style-type: none;
    }

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

    * html .ui-autocomplete {
        height: 100px;
    }

    li:hover {
        color: #1f4eaf;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 10px;
        background-color: #f7f2f2;
        border: 1px solid rgba(0, 0, 0, .125);
        color: #000;
    }

    .select2 {
        margin-bottom: 0 !important;
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
        width: 100%;
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

    .imageBlock {
        /* width: 150px; */
        /* height: 150px; */
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .imageBlock img {
        margin: 10px;
        width: 140px;
        height: 140px;
        border-radius: 8px;
        object-fit: contain;
        background: #83838330;
        padding: 6px;
    }

    #imageUploadSection {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
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

    .appendedSection {
        position: relative;
    }

    .closeIconX {
        position: absolute;
        top: 10px;
        right: 0;
        cursor: pointer;
        outline: 1px solid;
        height: 1.2rem;
        width: 1.2rem;
        display: grid;
        place-items: center;
        border-radius: 50%;
        font-size: 14px;
        line-height: 14px;
    }
</style>

<div class="layout-px-spacing" id="divbox">
    <div class="row layout-top-spacing editTer">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div id="loadingBlock" class="loadingBlock justify-content-center align-items-center" style="display: none;">Submitting...</div>
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Invoices</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Add Invoice</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div class="breadcrumb-title pe-3"><h5>Create User</h5></div> -->
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form class="general_form row mx-0">

                            <div class="form-row mb-4">
                                <h6><b>Employee Details</b></h6>

                                <div class="form-group mb-4 col-md-6">
                                    <label for="exampleFormControlInput2">Registered Mobile Number</label>
                                    <input type="number" class="form-control form-control-sm" name="mobile_number" @keyup="s()" v-model="mobile_no" id="mobile_number" placeholder="e.g 00020,45805">
                                </div>
                            </div>

                            <div v-if="otp_flag">
                                <div class="form-row mb-4">
                                    <h6><b>Invoice Details</b></h6>

                                    <div class="form-group mb-4 col-md-3">
                                        <label for="exampleFormControlInput2">Invoice Date</label>
                                        <input type="date" class="form-control form-control-sm" name="invoice_date" id="invoice_date" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <h6><b>Invoice Details</b></h6>

                                    <div class="form-group mb-4 col-md-3">
                                        <label for="exampleFormControlInput2">Basic Amount(Before Tax)</label>
                                        <input type="number" class="form-control form-control-sm" name="basic_amount" id="basic_amount" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <h6><b>Invoice Details</b></h6>
                                    <div class="form-group mb-4 col-md-3">
                                        <label for="exampleFormControlInput2">Total Amount</label>
                                        <input type="number" class="form-control form-control-sm" name="total_amount" id="total_amount" placeholder="">
                                    </div>
                                </div>


                                <div id="imageUploadSection" class="row">
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label pb-0">Upload File</label>
                                        <input type="file" accept="image/png, image/jpg, image/jpeg" multiple name="scanning_file[]" class="amit form-control-file  form-control-file-sm" id="fileupload-0" required />
                                        <div class="imageBlock"></div>
                                    </div>
                                </div>
                                <button id="appendButtons" class="btn btn-outline-secondary" style="display: none;" onclick="appendImageSection()" type="button">Add More Image</button>
                            </div>

                            <div class="col-12 d-flex align-items-center justify-content-end" style="gap:1rem;">
                                <button type="button" class="mt-4 mb-4 btn btn-primary" @click="get_otp()">Get OTP</button>
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
        el: '#divbox',
        // components: {
        //   ValidationProvider
        // },
        data: {
            otp_flag: false,
            mobile_no: "",



        },
        created: function() {
            //   alert('hello');
            // var table=$('#html5-extension');
            // table.dataTable({dom : 'lrt'});
            // $('table').dataTable({bFilter: false, bInfo: false});
            // https://dpportal.s3.us-east-2.amazonaws.com/invoice_images/AUVuGTgPlYBC8LhDUUVr5LxfPdwmOib6JE5Kmmvk.jpg
        },
        methods: {
            s:function(){
                const len = this.mobile_no.length
                if (len > 10) {
                    // alert(this.mobile_no.length)
                    // e.preventDefault();
                   return false;
                }
                
            },
            get_otp: function() {
                const len = this.mobile_no.length
                if (len != 10) {
                    swal('error', "Mobile Number Length has been Exceeded", 'error')
                    return 1;
                }
                if (this.mobile_no != "") {
                    axios.post('/check_registered_mobile', {
                            'mobile_number': this.mobile_no,
                            'type': "ter"
                        })
                        .then(response => {
                            console.log(response.data);
                            if (!response.data.success) {
                                console.log()
                                swal('error', "" + response.data.errors.mobile_number + "", 'error')
                            } else {
                                console.log(response.error.mobile_number, 'ttt')
                            }
                        }).catch(error => {
                            console.log(error.message, 'ttt')
                        })
                } else {
                    swal('error', "Please Enter the Registered Mobile Number with Frontiers", 'error')

                }

            },



        }
    })
</script>

<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script>
    $("#basic_amount").blur(function() {
        if ($("#basic_amount").val() > parseInt($("#po_value").val())) {
            $("#basic_amount").val("");
            swal('error', "Basic Amount Can't be Greater than PO Value")
        }

    });
    $("#total_amount").blur(function() {
        // alert($("#po_value").val());
        // alert($("#total_amount").val());
        if ($("#total_amount").val() > parseInt($("#po_value").val())) {
            $("#total_amount").val("");
            swal('error', "Total Amount Can't be Greater than PO Value")
        }

    });




    const imageUploadSection = $('#imageUploadSection')
    let i = 1;

    const appendImageSection = () => {
        if (i < 5) {
            console.log('sss ', i);
            let sectionToAppend = ``;
            sectionToAppend += `<div class="form-group col-md-3 appendedSection">
                                    <label class="col-form-label pb-0">Upload File</label>
                                    <input type="file" accept="image/png, image/jpg, image/jpeg" multiple name="scanning_file[${i}]" class="amit form-control-file  form-control-file-sm" id="fileupload-${i}" required/>
                                    <div class="imageBlock"></div>
                                    <span class="closeIconX">x</span>
                                </div>`;
            imageUploadSection.append(sectionToAppend);
            i++;
        } else {
            swal('error', 'Maximum upload limit is 5', 'error');
        }
    }

    $(document).on("click", '.closeIconX', function(e) {
        let currentSection = $(this).closest('.appendedSection');
        console.log(currentSection);
        currentSection.remove();
    });


    $(document).on("change", '.amit', function(e) {
        let image = ``;
        let imageBlock = $(this).next('.imageBlock')[0];
        let imgSrc = URL.createObjectURL($(this)[0].files[0]);

        for (let i = 0; i < $(this)[0].files.length; i++) {
            let imgSrcw = URL.createObjectURL($(this)[0].files[i]);
            image += `<img src="` + imgSrcw + `" alt="your image">`;
        }
        imageBlock.innerHTML = image;
        // $('#appendButtons').show();
    });
</script>

@endsection
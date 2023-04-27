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

    /* new css */
    .initialHome {
        display: flex;
        flex-direction: column;
        /* justify-content: center; */
        align-items: center;
        min-height: 90vh;
        text-align: center;
    }

    .initialHome img.logoImg {
        max-height: 100px;
        /* margin-bottom: 4rem; */

    }

    .initialHome h2 {
        font-size: clamp(1.5rem, 10vw, 2.5rem);
        font-weight: 600;
    }

    .initialHome p {
        max-width: 500px;
        font-size: clamp(0.9rem, 5vw, 1rem)
    }

    .styledButton {
        min-width: 170px;
        height: 60px;
        font-size: 1.1rem;
        border-radius: 50vh;
    }
</style>

<div class="layout-px-spacing">
    <div class="row layout-top-spacing editTer">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <!-- <div class="nav-logo align-self-center">
                <a class="navbar-brand" href="{{url('home')}}">
                </a>
            </div> -->



            <div id="initialHome" class="initialHome">
                <img alt="logo" class="logoImg" src="{{asset('assets/img/f15.png')}}" />

                <div class="d-flex flex-column align-items-center justify-content-center" style="gap: 1rem; flex: 1;">
                    <h2>Some heading here</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="d-flex align-items-center mt-5" style="gap: 1rem;">
                        <button class="btn btn-primary styledButton">Generate</button>
                        <button class="btn btn-primary styledButton">Track</button>
                    </div>
                </div>
            </div>



            <div id="initialHome" class="generateUnid">
                <img alt="logo" class="logoImg" src="{{asset('assets/img/f15.png')}}" />

                <div class="d-flex flex-column align-items-center justify-content-center" style="gap: 1rem; flex: 1;">
                    <p>Enter </p>
                    <div class="d-flex align-items-center mt-5" style="gap: 1rem;">
                        <button class="btn btn-primary styledButton">Get Info</button>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<div class="layout-px-spacing" id="divbox">
    <div class="row layout-top-spacing editTer">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div id="loadingBlock" class="loadingBlock justify-content-center align-items-center" style="display: none;">Submitting...</div>
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Generate UNID</a></li>
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
                                    <div class="form-group mb-4 col-md-3">
                                        <label for="exampleFormControlInput2">Employee ID</label>
                                        <span>@{{employee_data.employee_id}}</span>
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="form-group mb-4 col-md-3">
                                        <label for="exampleFormControlInput2">Employee Name</label>
                                        <span>@{{employee_data.name}}</span>
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="form-group mb-4 col-md-3">
                                        <label for="exampleFormControlInput2">Designation</label>
                                        <span>@{{employee_data.designation}}</span>
                                    </div>
                                </div>


                                <div class="form-row mb-4" v-if="otp_field_flag">

                                    <div class="form-group mb-4 col-md-6">
                                        <label for="exampleFormControlInput2">Enter OTP</label>
                                        <input type="number" class="form-control form-control-sm" name="otp" v-model="otp" id="otp" placeholder="e.g 12345,323443">
                                    </div>
                                </div>

                            </div>

                            <div class="form-row mb-4" v-if="document_flag || true">

                                <!------------Document details --------->
                                <div class="form-row mb-4">
                                    <h6><b>Document Details</b></h6>


                                    <div class="form-group col-md-2">
                                        <label for="month">Select Month</label>
                                        <select id="month" class=" form-control form-control-sm" v-on:change="onSelectMonth()">
                                            <option>--Select Month--</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputPassword4">TER Period From *</label>
                                        <input type="date" class="form-control form-control-sm" id="terfrom_date" required name="terfrom_date" v-model="from_date">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputPassword4">TER Period To *</label>
                                        <input type="date" class="form-control form-control-sm" id="terto_date" required name="terto_date" v-model="to_date">
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="inputState">TER Amount *</label>
                                        <input class="form-control form-control-sm" type="number" id="amount" type="number" name="amount" v-model="amount" required>
                                        <span id="amountInwords" style="font-size: 12px;">Required</span>
                                    </div>
                                    <div id="imageUploadSection" class="row">
                                        <div class="form-group col-md-12">
                                            <label class="col-form-label pb-0">Upload File</label>
                                            <input type="file" accept="image/png, image/jpg, image/jpeg" v-on:change="upload_file($event)" name="scanning_file[]" class="amit form-control-file  form-control-file-sm" id="fileupload-0" required />
                                            <div class="imageBlock"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>




                            <div class="col-12 d-flex align-items-center justify-content-end" style="gap:1rem;">
                                <button type="button" class="mt-4 mb-4 btn btn-primary" @click="check_employee_exist()" v-if="!otp_flag">Get Employee Info</button>
                                <button type="button" class="mt-4 mb-4 btn btn-primary" @click="send_otp()" v-if="otp_flag && test_flag" id="send_otp">Send OTP</button>
                                <button type="button" class="mt-4 mb-4 btn btn-primary" @click="submit_otp()" v-if="otp_field_flag && submit_otp_btn_flag" id="submit_otp">Submit OTP</button>
                                <button type="button" class="mt-4 mb-4 btn btn-primary" @click="generate_unid()" v-if="document_flag || true" id="generate_unid">Generate UNID</button>

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
            employee_data: {},
            emp_id: "",
            otp_field_flag: false,
            otp: "",
            test_flag: true,
            submit_otp_btn_flag: true,
            document_flag: false,
            from_date: "",
            to_date: "",
            amount: "",
            file: "",
            currentYear: "",
            forMonth: "",
            forPeiod: "",



        },
        created: function() {
            //   alert('hello');
            // var table=$('#html5-extension');
            // table.dataTable({dom : 'lrt'});
            // $('table').dataTable({bFilter: false, bInfo: false});
            // https://dpportal.s3.us-east-2.amazonaws.com/invoice_images/AUVuGTgPlYBC8LhDUUVr5LxfPdwmOib6JE5Kmmvk.jpg
        },
        methods: {
            onSelectMonth: function() {
                this.selectedMonth = document.getElementById('month').value
                this.currentYear = new Date().getFullYear();
                // alert(`${this.currentYear}-${this.selectedMonth}-01`)
                if (this.selectedMonth == 1 || this.selectedMonth == 3 || this.selectedMonth == 5 || this.selectedMonth == 7 || this.selectedMonth == 8 || this.selectedMonth == 10 || this.selectedMonth == 12) {
                    this.from_date = `${this.currentYear}-${this.selectedMonth}-01`;
                    this.to_date = `${this.currentYear}-${this.selectedMonth}-31`;
                    // $("input[name='from_date1']").val(`${this.currentYear}-${this.selectedMonth}-01`);
                    // $("input[name='to_date1']").val(`${this.currentYear}-${this.selectedMonth}-31`);
                } else if (this.selectedMonth == 2) {
                    this.from_date = `${this.currentYear}-${this.selectedMonth}-01`;
                    this.to_date = `${this.currentYear}-${this.selectedMonth}-28`;
                    // $("input[name='from_date1']").val(`${this.currentYear}-${this.selectedMonth}-01`);
                    // $("input[name='to_date1']").val(`${this.currentYear}-${this.selectedMonth}-28`);
                } else {
                    this.from_date = `${this.currentYear}-${this.selectedMonth}-01`;
                    this.to_date = `${this.currentYear}-${this.selectedMonth}-30`;
                    // $("input[name='from_date1']").val(`${this.currentYear}-${this.selectedMonth}-01`);
                    // $("input[name='to_date1']").val(`${this.currentYear}-${this.selectedMonth}-30`);
                }
            },
            upload_file(e) {
                this.file = e.target.files[0];
            },
            generate_unid: function() {
                if (this.amount != "" && this.from_date != "" && this.to_date != "" && this.file != "") {

                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data',
                        }
                    }
                    let formData = new FormData();
                    formData.append('file', this.file);
                    formData.append('emp_id', this.emp_id);
                    formData.append('amount', this.amount);
                    formData.append('from_date', this.from_date);
                    formData.append('to_date', this.to_date);



                    axios.post('/create_unid', formData, config)
                        .then(response => {
                            if (response.data == "not_possible") {

                                swal('error', "UNID can not generate for this Employee Designation", 'error')
                            }
                            if (response.data[0] == "100") {

                                swal('success', "UNID generated Successfully UNID: " + " " + response.data[1], 'success')
                            }
                            if (response.data[0] == "unid_already_generated") {

                                swal('error', "UNID " + response.data[2] + " already generated for the month of " + " " + response.data[1], 'error')
                            }
                            if (response.data.errors.emp_id) {
                                swal('error', "" + response.data.errors.emp_id + "", 'error')
                            }
                            if (response.data.errors.amount) {
                                swal('error', "" + response.data.errors.amount + "", 'error')
                            }
                            if (response.data.errors.from_date) {
                                swal('error', "" + response.data.errors.from_date + "", 'error')
                            }
                            if (response.data.errors.to_date) {
                                swal('error', "" + response.data.errors.to_date + "", 'error')
                            }
                            if (response.data.errors.file) {
                                swal('error', "" + response.data.errors.file + "", 'error')
                            }


                        }).catch(error => {


                        })

                } else {
                    swal('error', "Fields are Empty", 'error')

                }

            },
            submit_otp: function() {
                const len = this.otp.length
                if (len != 6) {
                    swal('error', "OTP is not correct", 'error')
                    return 1;
                }
                if (this.otp != "") {
                    axios.post('/submit_otp', {
                            'emp_id': this.emp_id,
                            'otp': this.otp
                        })
                        .then(response => {
                            // console.log(response.data[0]);
                            if (response.data.errors) {
                                this.otp_field_flag = false;
                                this.document_flag = false;
                                if (response.data.errors.emp_id) {
                                    swal('error', "" + response.data.errors.emp_id + "", 'error')
                                }
                                if (response.data.errors.otp) {
                                    swal('error', "" + response.data.errors.otp + "", 'error')
                                }
                            }
                            if (response.data == "empty_array") {
                                this.otp_field_flag = false;
                                this.document_flag = false;

                                swal('error', "Employee Id mismatch..", 'error')
                            }

                            if (response.data == "otp_matched") {
                                this.otp_field_flag = false;
                                this.submit_otp_btn_flag = false;
                                this.document_flag = true;
                                swal('success', "OTP has been successfully verified..", 'success')
                            }
                            if (response.data == "invalid_otp") {
                                this.otp_field_flag = false;
                                this.document_flag = false;
                                swal('error', "Invalid OTP", 'error')
                            }

                        }).catch(error => {
                            this.otp_field_flag = false;

                        })

                } else {
                    swal('error', "Please Fill the OTP Field", 'error')

                }

            },
            s: function() {
                const len = this.mobile_no.length
                if (len > 10) {
                    // alert(this.mobile_no.length)
                    // e.preventDefault();
                    return false;
                }

            },
            send_otp: function() {
                // document.getElementById("#send_otp").disabled = true;
                axios.post('/send_otp', {
                        'emp_id': this.emp_id
                    })
                    .then(response => {
                        // console.log(response.data[0]);
                        if (response.data.errors) {
                            this.otp_field_flag = false;
                            swal('error', "" + response.data.errors.emp_id + "", 'error')
                        }
                        if (response.data == "empty_array") {
                            this.otp_field_flag = false;
                            swal('error', "Employee Id mismatch..", 'error')
                        }
                        if (response.data == "msg_sent") {
                            this.otp_field_flag = true;
                            this.test_flag = false;
                            swal('success', "OTP Sent Kindly Please Enter the OTP", 'success')
                        }
                        if (response.data == "msg_not_sent") {
                            this.otp_field_flag = false;
                            swal('error', "Message Not Sent Kindly Please Contact Frontiers", 'error')
                        }

                    }).catch(error => {
                        this.otp_field_flag = false;

                    })


            },
            check_employee_exist: function() {
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
                            // console.log(response.data[0]);
                            if (response.data == "empty_array") {
                                this.otp_flag = false;
                                swal('error', "Please Enter the Registered Mobile Number with Frontiers", 'error')
                            }
                            if (response.data.errors) {
                                this.otp_flag = false;
                                swal('error', "" + response.data.errors.mobile_number + "", 'error')
                            }

                            if (response.data[0] == "available") {
                                this.otp_flag = true;
                                this.employee_data = response.data[1][0];
                                this.emp_id = this.employee_data.employee_id;
                                // console.log(this.employee_data.employee_id)
                            }

                        }).catch(error => {
                            this.otp_flag = false;

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

<script>
    let selectedYear = new Date().getFullYear();
    const currentYear = document.getElementById('current_year')
    const lastYear = document.getElementById('last_year')
    const forMonth = document.getElementById('for_month')
    const forPeiod = document.getElementById('for_period')

    function onChangePeriodType() {

        if (forMonth.checked) {
            document.getElementById('terfrom_date').disabled = true;
            document.getElementById('terto_date').disabled = true;
            document.getElementById('month').disabled = false;
            $("input[name='terfrom_date']").val('');
            $("input[name='terto_date']").val('');
            document.getElementById('month').setAttribute("required", "true");
            currentYear.disabled = false;
            lastYear.disabled = false;
        }
        if (forPeiod.checked) {
            document.getElementById('terfrom_date').disabled = false;
            document.getElementById('terto_date').disabled = false;
            document.getElementById('month').disabled = true;
            document.getElementById('month').setAttribute("required", "false");
            document.getElementById('month').value = '00';

            currentYear.disabled = true;
            lastYear.disabled = true;
        }
    }

    function onSelectMonth() {
        const selectedMonth = document.getElementById('month').value
        const currentYear = lastYear.checked ? (selectedYear - 1) : selectedYear;
        // alert(currentYear)
        if (selectedMonth == 1 || selectedMonth == 3 || selectedMonth == 5 || selectedMonth == 7 || selectedMonth == 8 || selectedMonth == 10 || selectedMonth == 12) {
            $("input[name='terfrom_date']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date']").val(`${currentYear}-${selectedMonth}-31`);
            $("input[name='terfrom_date1']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date1']").val(`${currentYear}-${selectedMonth}-31`);
        } else if (selectedMonth == 2) {
            $("input[name='terfrom_date']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date']").val(`${currentYear}-${selectedMonth}-28`);
            $("input[name='terfrom_date1']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date1']").val(`${currentYear}-${selectedMonth}-28`);
        } else {
            $("input[name='terfrom_date']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date']").val(`${currentYear}-${selectedMonth}-30`);
            $("input[name='terfrom_date1']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date1']").val(`${currentYear}-${selectedMonth}-30`);
        }
        // const t = document.getElementById('terfrom_date').value;
        // const r = document.getElementById('terto_date').value;
        // alert(`${t}, ${r}`)
    }

    function testSubmit() {
        var timeConsumed = document.getElementById('time').innerText;
    }

    var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
    var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    function inWords(num) {
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
    }

    document.getElementById('amount').onkeyup = function() {
        document.getElementById('amountInwords').innerHTML = inWords(document.getElementById('amount').value);
        document.getElementById('amountInwords').style.textTransform = "capitalize";
    };
</script>

@endsection
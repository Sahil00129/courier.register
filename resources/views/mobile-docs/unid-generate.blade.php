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
        padding: 1rem;
        display: flex;
        flex-direction: column;
        /* justify-content: center; */
        align-items: center;
        min-height: min(100vh, 650px);
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
        align-items: center;
        justify-content: center;
    }

    .myCard {
        box-shadow: 0 3px 20px -3px #83838380;
        flex: 1;
        padding: 1rem;
        min-height: 435px;
        border-radius: 20px;
        border: none;
        width: 100%;
        max-width: 450px;
        position: relative;
    }

    .mobileNumber {
        max-width: 300px;
        border-radius: 50vh;
        padding-left: 36px !important;
    }

    .mobileInput {
        position: relative;
        width: 100%;
    }

    .mobileInput svg {
        position: absolute;
        left: 14px;
        top: 14px;
        height: 16px;
        width: 16px;

    }

    .empUser {
        height: 90px;
        width: 90px;
        background: #4361ee12;
        border-radius: 50vh;
        padding: 8px;
        color: #4361ee;
        outline: 2px solid #4361ee;
        outline-offset: 4px;
    }

    p.empId {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        margin-top: 2rem;
    }

    p.empName {
        font-size: 1.4rem;
        font-weight: 500;
        margin-bottom: 0;
    }

    p.empDes {
        font-weight: 600;
        font-size: 14px;
    }

    p.empStatus {
        background: #0080001c;
        padding: 2px 24px;
        color: green;
        border-radius: 50vh;
        outline: 2px solid;
        font-weight: 600;
    }

    .changeNumber {
        font-size: 12px;
        font-weight: 500;
        margin-top: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4px;
        pointer-events: all;
    }

    .changeNumber.disabled {
        pointer-events: none;
        color: #83838380;
    }

    .changeNumber.disabled:hover {
        pointer-events: none;
        color: #83838380;
    }

    .changeNumber:hover {
        cursor: pointer;
        color: #1f4eaf;
    }

    .changeNumber svg {
        height: 14px;
        width: 14px;
    }

    .activeItem {
        display: flex;
        opacity: 1;
        pointer-events: all;
        transform: translateY(0);
        transition: all 300ms ease-in-out;
    }

    .inActiveItem {
        display: none !important;
        opacity: 0;
        pointer-events: none;
        transform: translateY(30px);
        transition: all 300ms ease-in-out;
    }

    input::-webkit-file-upload-button {
        display: none;
    }

    input[type="file"] {
        padding-top: 10px !important;
    }

    .actionBar {
        min-height: 90px;
        margin-top: 1rem;
        width: 100%;
    }

    .userCard {
        display: flex;
        flex-flow: column;
        align-items: center;
        transition: all 300ms ease-in-out;
    }

    .userCard * {
        transition: all 300ms ease-in-out;
    }

    .empUser {
        height: 90px;
        width: 90px;
        background: #4361ee12;
        border-radius: 50vh;
        padding: 8px;
        color: #4361ee;
        outline: 2px solid #4361ee;
        outline-offset: 4px;
        transition: all 300ms ease-in-out;
    }

    .userCard.compact .empUser {
        height: 60px;
        width: 60px;
        margin-top: 1rem;
        transition: all 300ms ease-in-out;
    }

    p.empId {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        margin-top: 2rem;
    }

    .userCard.compact p.empId {
        margin-top: 0;
        font-size: 12px;
    }

    p.empName {
        font-size: 1.4rem;
        font-weight: 500;
        margin-bottom: 0;
    }

    .userCard.compact p.empName {
        font-size: 14px;
    }

    p.empDes {
        font-weight: 600;
        font-size: 14px;
    }

    .userCard.compact p.empDes {
        font-size: 12px;
        margin-bottom: 6px;
    }

    p.empStatus {
        background: #0080001c;
        padding: 2px 24px;
        color: green;
        border-radius: 50vh;
        outline: 2px solid;
        font-weight: 600;
        width: max-content;
        margin: 0 auto;
    }

    p.empStatus.error {
        background: #0080001c;
        color: red;
    }

    .userCard.compact p.empStatus {
        padding: 0px 24px;
        color: green;
        border-radius: 50vh;
        outline: 1px solid;
        font-weight: 600;
        font-size: 12px;
        margin: 0;
    }

    .inner {
        display: flex;
        flex-flow: column;
        align-items: center;
    }

    .userCard.compact {
        flex-flow: row;
        gap: 1rem;
        flex: 1;
        padding-top: 1.5rem;
        align-items: flex-start;
        margin-block: 1.4rem;
        background: #f1f1f1;
        padding: 1rem;
        border-radius: 20px 0;
    }

    .userCard.compact .inner {
        align-items: flex-start;
    }


    .stableClass {
        opacity: 1;
        transform: translateY(0);
        transition: all 350ms ease-in-out;
    }

    .enterClass {
        opacity: 0.4;
        transform: translateY(80px);
        transition: all 350ms ease-in-out;
    }

    .exitClass {
        opacity: 0.4;
        transform: translateY(-80px);
        transition: all 350ms ease-in-out;
    }


    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    #amountInwords {
        font-size: 11px;
        max-width: 300px;
        padding-left: 10px;
        text-align: left;
        text-transform: capitalize;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>



<div id="initialHome" class="initialHome animate__animated animate__fadeIn">
    <img alt="logo" class="logoImg" src="{{asset('assets/img/f15.png')}}" />

    <div class="d-flex flex-column align-items-center justify-content-center" style="gap: 1rem; flex: 1;">
        <h2>Some heading here</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <div class="d-flex align-items-center mt-5" style="gap: 1rem;">
            <button class="btn btn-primary styledButton" onclick="showGenerateUnid()">Generate</button>
            <button class="btn btn-primary styledButton">Track</button>
        </div>
    </div>
</div>



<div class="initialHome inActiveItem animate__animated animate__fadeIn" id="generateUnid">

    <div class="d-flex align-items-center justify-content-center" style="flex: 1; width: 100%">

        <div class="d-flex flex-column align-items-center justify-content-center myCard" style="flex: 1; min-height: min(90vh, 500px);">

            <img alt="logo" class="logoImg" src="{{asset('assets/img/f15.png')}}" />

            <div class="d-flex flex-column align-items-center justify-content-center" id="registrationInput" style="flex: 1; gap: 1.5rem ">
                <div class="d-flex flex-column align-items-center justify-content-end animate__animated animate__fadeIn" style="flex: 1;">


                    <!-- mobile input -->

                    <p class="registeration animate__animated animate__fadeIn" style="max-width: 250px">Enter your registered mobile number to continue.</p>

                    <div class="mobileInput animate__animated animate__fadeIn registeration">
                        <input type="number" class="form-control form-control-sm mobileNumber phone" name="mobile_number" @keyup="s()" v-model="mobile_no" id="mobile_number" placeholder="Your Mobile Number">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>

                    <!-- mobile input ends -->


                    <!-- user card -->
                    <div class="userCard inActiveItem animate__animated animate__fadeIn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user empUser">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>

                        <div class="inner">
                            <p class="empId">Employee Id - @{{employee_data.employee_id}}</p>
                            <p class="empName">@{{employee_data.name}}</p>
                            <p class="empDes">@{{employee_data.designation}}</p>

                            <p class="empStatus error" v-if="employee_data.status == 'Blocked'">@{{employee_data.status}}</p>
                            <p class="empStatus" v-if="employee_data.status == 'Active'">@{{employee_data.status}}</p>
                        </div>
                    </div>

                    <!-- userc card ends -->


                    <!-- verify Otp -->
                    <p class="otpVerificationSection inActiveItem animate__animated animate__fadeIn" style="max-width: 250px">Enter your registered mobile number to continue.</p>

                    <div class="mobileInput otpVerificationSection  animate__animated animate__fadeIn inActiveItem">
                        <input type="number" class="form-control form-control-sm mobileNumber" name="otp" v-model="otp" id="otp" placeholder="******">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <!-- verify Otp end -->




                    <!-- generate UNID -->
                    <div class="form-group mobileInput unidGenrationSection animate__animated animate__fadeIn inActiveItem">
                        <!-- <label for="month">Select Month</label> -->
                        <select id="month" class=" form-control form-control-sm mobileNumber" v-on:change="onSelectMonth()">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>

                    <input type="date" class="form-control form-control-sm" id="terto_date" required name="terto_date" v-model="to_date" style="display: none">
                    <input type="date" class="form-control form-control-sm" id="terfrom_date" required name="terfrom_date" v-model="from_date" style="display: none">


                    <div class="mobileInput unidGenrationSection animate__animated animate__fadeIn inActiveItem" style="flex-flow: column; align-items: flex-start">
                        <input class="form-control form-control-sm mobileNumber" type="number" id="amount" type="number" name="amount" v-model="amount" required placeholder="TER Amount">
                        <svg>
                            rs
                        </svg>
                        <span id="amountInwords">Required</span>

                    </div>

                    <div class="mobileInput mt-3 unidGenrationSection animate__animated animate__fadeIn inActiveItem">
                        <input class="form-control form-control-sm mobileNumber" type="file" accept="image/png, image/jpg, image/jpeg" v-on:change="upload_file($event)" name="scanning_file[]" class="amit form-control-file  form-control-file-sm" id="fileupload-0" required>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip">
                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                        </svg>
                    </div>

                    <!-- generate UNID ends -->


                    <!-- thank you section -->

                    <div id="thankYou" class="thankYou animate__animated animate__fadeIn inActiveItem" style="flex: 1">
                        Thank You
                    </div>


                </div>


                <div class="actionBar">

                    <button class="btn btn-primary styledButton registeration animate__animated animate__fadeIn" style="width: 100%;" @click="check_employee_exist()">Get Info</button>
                    <p class="changeNumber animate__animated animate__fadeIn" id="registeration"> </p>


                    <button class="btn btn-primary styledButton infoSection inActiveItem animate__animated animate__fadeIn" style="width: 100%;" @click="send_otp()">Send OTP</button>
                    <p class="changeNumber infoSection inActiveItem animate__animated animate__fadeIn" onclick="onClickChangeNumber()">
                        Change
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>+91-@{{mobile_no}}</span>
                    </p>


                    <button class="btn btn-primary styledButton otpVerificationSection inActiveItem animate__animated animate__fadeIn" style="width: 100%;" @click="submit_otp()">Verify OTP</button>
                    <p class="changeNumber disabled timer otpVerificationSection inActiveItem animate__animated animate__fadeIn" @click="send_otp()">Resend OTP <span id="timer">00</span></p>


                    <button class="btn btn-primary styledButton unidGenrationSection inActiveItem animate__animated animate__fadeIn" style="width: 100%;" @click="generate_unid()">Generate UNID</button>
                    <p class="changeNumber unidGenrationSection inActiveItem animate__animated animate__fadeIn"> </p>

                </div>
            </div>

        </div>

    </div>

</div>


</div>

<div class="layout-px-spacing" style="display: none">
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


<!-- new script -->
<script>
    function showGenerateUnid() {
        $('#initialHome').removeClass('activeItem');
        $('#initialHome').addClass('inActiveItem');
        $('#generateUnid').addClass('activeItem');
        $('#generateUnid').removeClass('inActiveItem');
    }

    function onClickGetInfo() {
        document.querySelectorAll('.infoSection').forEach((elm) => elm.classList.remove('inActiveItem'));
        document.querySelectorAll('.infoSection').forEach((elm) => elm.classList.add('activeItem'));

        document.querySelectorAll('.registeration').forEach((elm) => elm.classList.remove('activeItem'));
        document.querySelectorAll('.registeration').forEach((elm) => elm.classList.add('inActiveItem'));

        document.querySelectorAll('.userCard').forEach((elm) => elm.classList.add('activeItem'));
        document.querySelectorAll('.userCard').forEach((elm) => elm.classList.remove('inActiveItem'));
    }

    function onClickChangeNumber() {
        document.querySelectorAll('.registeration').forEach((elm) => elm.classList.remove('inActiveItem'));
        document.querySelectorAll('.registeration').forEach((elm) => elm.classList.add('activeItem'));

        document.querySelectorAll('.infoSection').forEach((elm) => elm.classList.remove('activeItem'));
        document.querySelectorAll('.infoSection').forEach((elm) => elm.classList.add('inActiveItem'));

        document.querySelectorAll('.userCard').forEach((elm) => elm.classList.remove('activeItem'));
        document.querySelectorAll('.userCard').forEach((elm) => elm.classList.add('inActiveItem'));

    }

    function runTmer() {
        var timeleft = 10;
        var downloadTimer = setInterval(function() {
            timeleft--;
            document.getElementById("timer").textContent = `in ${timeleft} seconds`;
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                $('#timer').hide();
                document.querySelectorAll('.timer').forEach((elm) => elm.classList.remove('disabled'));
            }
        }, 1000);
    }

    function resendOtp() {
        runTmer();
        $('#timer').show();
        document.querySelectorAll('.timer').forEach((elm) => elm.classList.add('disabled'));


    }

    function onOtpSend() {
        document.querySelectorAll('.userCard').forEach((elm) => elm.classList.add('compact'));

        document.querySelectorAll('.infoSection').forEach((elm) => elm.classList.remove('activeItem'));
        document.querySelectorAll('.infoSection').forEach((elm) => elm.classList.add('inActiveItem'));

        document.querySelectorAll('.otpVerificationSection').forEach((elm) => elm.classList.add('activeItem'));
        document.querySelectorAll('.otpVerificationSection').forEach((elm) => elm.classList.remove('inActiveItem'));

        runTmer();

    }

    function onOtpVerify() {
        document.querySelectorAll('.otpVerificationSection').forEach((elm) => elm.classList.remove('activeItem'));
        document.querySelectorAll('.otpVerificationSection').forEach((elm) => elm.classList.add('inActiveItem'));

        document.querySelectorAll('.unidGenrationSection').forEach((elm) => elm.classList.add('activeItem'));
        document.querySelectorAll('.unidGenrationSection').forEach((elm) => elm.classList.remove('inActiveItem'));
    }

    function onClickGenerate() {
        document.querySelectorAll('.actionBar').forEach((elm) => elm.classList.add('inActiveItem'));
        document.querySelectorAll('.userCard').forEach((elm) => elm.classList.remove('activeItem'));

        document.querySelectorAll('.thankYou').forEach((elm) => elm.classList.add('activeItem'));
        document.querySelectorAll('.thankYou').forEach((elm) => elm.classList.remove('inActiveItem'));

        document.querySelectorAll('.unidGenrationSection').forEach((elm) => elm.classList.remove('activeItem'));
        document.querySelectorAll('.unidGenrationSection').forEach((elm) => elm.classList.add('inActiveItem'));
    }
</script>
<!-- new script ends -->



<script>
    new Vue({
        el: '#generateUnid',
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
            otp_count: 0,



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
                                onClickGenerate();
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
                                onOtpVerify();
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
                this.otp_count += 1;
                // document.getElementById("#send_otp").disabled = true;
                axios.post('/send_otp', {
                        'emp_id': this.emp_id
                    })
                    .then(response => {
                        if (this.otp_count > 1) {
                            resendOtp();
                        }
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
                            onOtpSend();
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
            onClickGetInfo: function() {
                document.querySelectorAll('.infoSection').forEach((elm) => elm.classList.remove('inActiveItem'));
                document.querySelectorAll('.infoSection').forEach((elm) => elm.classList.add('activeItem'));

                document.querySelectorAll('.registeration').forEach((elm) => elm.classList.remove('activeItem'));
                document.querySelectorAll('.registeration').forEach((elm) => elm.classList.add('inActiveItem'));

                document.querySelectorAll('.userCard').forEach((elm) => elm.classList.add('activeItem'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.classList.remove('inActiveItem'));
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
                                onClickGetInfo();
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
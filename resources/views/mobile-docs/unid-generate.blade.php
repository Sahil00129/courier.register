<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <meta name="theme-color" content="#13c7a8"/>
    <meta name="description" content="TER process portal">
    <title>TER Process</title>
    <link href="{{asset('assets/css/sample-page.css')}}" rel="stylesheet" type="text/css"/>

    <!--    for animation-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!--    for external css-->
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.min.js"
            integrity="sha256-ngFW3UnAN0Tnm76mDuu7uUtYEcG3G5H1+zioJw3t+68=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vee-validate@2.2.15/dist/vee-validate.min.js"
            integrity="sha256-m+taJnCBUpRECKCx5pbA0mw4ckdM2SvoNxgPMeUJU6E=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"
            integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>

</head>

<body>

<main id="generateUnid">
    <section id="loading_screen" class="animate__animated animate__fadeIn">
        <div class="flex flex-wrap justify-center flex-col mx-auto text-center animate__animated animate__zoomIn"
             style="height: 100%; align-items: center; max-width: 900px;">
            <img src="{{asset('assets/img/ter-logo.png')}}" alt="sss"
                 class="terLogo loadingLogo animate__animated animate__fadeIn"/>
            <h2 class="gradientText md:block text-3xl font-bold tracking-tight text-center sm:text-4xl animate__animated animate__fadeIn">
                Finfect for TER
            </h2>
        </div>
    </section>

    <section id="landing_screen" class="animate__animated animate__fadeIn ">
        <div class="flex flex-wrap md:flex-nowrap justify-center flex-col md:flex-row mx-auto text-center"
             style="height: 100%; align-items: center; max-width: 900px; width: 100%; row-gap: 2rem">
            <img src="{{asset('assets/img/ter-long-logo.png')}}" alt="sss" class="md:hidden terLogo longLogo"/>

            <img src="{{asset('assets/img/hero-illustration.png')}}" alt="sss"
                 class="heroIllustration animate__animated animate__fadeIn"/>

            <div class="flex flex-col align-center justify-center mb-12 md:mb-0 flex-1">
                <img src="{{asset('assets/img/ter-logo.png')}}" alt="sss"
                     class="terLogo hidden md:flex animate__animated animate__slideInUp"/>

                <h2 class="gradientText hidden md:block text-3xl font-bold tracking-tight text-center sm:text-4xl animate__animated animate__slideInUp">
                    Finfect for TER
                </h2>
                <p class="mt-6 text-lg leading-8 text-center text-black-50 animate__animated animate__slideInUp">
                    Welcome to Finfect for TER!!<br/>
                    Generate and track your TER with a few clicks.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6 animate__animated animate__slideInUp">
                    <button class="flex justify-center themeButton" onClick="onClickGenerate()"
                            style="max-width: 170px">
                        Generate
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevrons-right normalSvg">
                            <polyline points="13 17 18 12 13 7"></polyline>
                            <polyline points="6 17 11 12 6 7"></polyline>
                        </svg>
                    </button>
                    <button class="flex justify-center themeButton reverse" onClick="onClickTrack()"
                            style="max-width: 170px">
                        Track
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevrons-right normalSvg">
                            <polyline points="13 17 18 12 13 7"></polyline>
                            <polyline points="6 17 11 12 6 7"></polyline>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </section>

    <section id="generate_unId" class="generateUnId animate__animated animate__fadeIn">
        <div class="flex flex-wrap md:flex-nowrap justify-center flex-col md:flex-row mx-auto text-center"
             style="flex: 1; height: 100%;">
            <div class="formBlock">
                <div class="illustrationContainer">
                    <img src="{{asset('assets/img/side-illustration.png')}}" alt="sss" class="sideIllustration"/>
                </div>

                <div class="formContainer animate__animated animate__fadeIn">

                    <div class="containerArea animate__animated animate__fadeIn">

                        <div class="loadingBox inActive">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-loader loadingSvg">
                                <line x1="12" y1="2" x2="12" y2="6"></line>
                                <line x1="12" y1="18" x2="12" y2="22"></line>
                                <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                <line x1="2" y1="12" x2="6" y2="12"></line>
                                <line x1="18" y1="12" x2="22" y2="12"></line>
                                <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                            </svg>
                        </div>

                        <img src="{{asset('assets/img/ter-logo.png')}}" alt="sss"
                             class="terLogo animate__animated animate__slideInUp"/>

                        <h2 class="gradientText text-3xl font-bold tracking-tight text-center sm:text-4xl animate__animated animate__slideInUp">
                            Finfect for TER
                        </h2>

                        <div class="midContent">
                            <img src="{{asset('assets/img/ill-2.svg')}}" alt="demo Illustration"
                                 class="mobileInputSection animate__animated animate__bounceIn inlineIllustration active"/>

                            <img src="{{asset('assets/img/done.svg')}}" alt="demo Illustration"
                                 class="thankYouSection animate__animated animate__bounceIn inlineIllustration inActive"/>

                            <div class="userCard compact animate__animated animate__fadeIn inActive">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-user empUser">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>

                                <div class="inner">
                                    <p class="empName">@{{employee_data.name}}</p>
                                    <p class="empDes">@{{employee_data.designation}}</p>
                                    <p class="empId">
                                        <span>Emp ID: @{{employee_data.employee_id}}</span>
                                        <span class="statusText" v-if="employee_data.status == 'Active'">Active</span>
                                        <span class="statusText" style="color: red" v-if="employee_data.status == 'Blocked'">Blocked</span>
                                    </p>
                                </div>
                            </div>

                            <p class="flexText mobileInputSection text-center text-black-50 animate__animated animate__slideInUp active">
                                Enter your registered mobile number.
                            </p>

                            <p class="verifyOtpSection text-sm leading-8 text-center animate__animated animate__bounceIn inActive"
                               style="color: green">
                                An OTP has been sent to +91-@{{mobile_no}}
                            </p>

                            <p class="thankYouSection flex-col text-sm text-center animate__animated animate__bounceIn inActive">
                                <span class="up">UNID</span>
                                <span class="unidText">@{{unid}}</span>
                                <span class="last">generated successfully</span>
                                <span style="margin-top: 10px;"><a style="cursor: pointer"
                                                                   onclick="reloadPage()">Home</a></span>
                            </p>
                        </div>

                        <div class="formItems">
                            <!-- get info section -->
                            <div class="mobileInputSection myInputBox animate__animated animate__fadeIn active">
                                <input type="number" name="mobile_number" id="mobile_number"
                                       placeholder="Your Mobile Number" v-model="mobile_no" class="myInput"
                                       onkeyup="enableButton()"/>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-phone">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <p class="errorLabel"></p>
                            </div>
                            <button id="getInfoButton"
                                    class="mobileInputSection themeButton animate__animated animate__slideInUp loadingButton active"
                                    disabled @click="check_employee_exist()">
                                <span class="normalText">Get Info</span>
                                <span class="loadingText">Fetching Info...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevrons-right normalSvg">
                                    <polyline points="13 17 18 12 13 7"></polyline>
                                    <polyline points="6 17 11 12 6 7"></polyline>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-loader loadingSvg">
                                    <line x1="12" y1="2" x2="12" y2="6"></line>
                                    <line x1="12" y1="18" x2="12" y2="22"></line>
                                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                    <line x1="2" y1="12" x2="6" y2="12"></line>
                                    <line x1="18" y1="12" x2="22" y2="12"></line>
                                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                                </svg>
                            </button>
                            <p class="mobileInputSection changeNumber animate__animated animate__slideInUp active justify-between">
                                <span onclick="reloadPage()">Home</span>
                                <span onclick="onClickTrackOldOne()">Track UNID</span>
                            </p>

                            <!-- send Otp section -->
                            <button id="sendOtpButton"
                                    class="sendOtpSection themeButton animate__animated animate__slideInUp loadingButton inActive"
                                    @click="send_otp()">
                                <span class="normalText">Send OTP</span>
                                <span class="loadingText">Sending...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevrons-right normalSvg">
                                    <polyline points="13 17 18 12 13 7"></polyline>
                                    <polyline points="6 17 11 12 6 7"></polyline>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-loader loadingSvg">
                                    <line x1="12" y1="2" x2="12" y2="6"></line>
                                    <line x1="12" y1="18" x2="12" y2="22"></line>
                                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                    <line x1="2" y1="12" x2="6" y2="12"></line>
                                    <line x1="18" y1="12" x2="22" y2="12"></line>
                                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                                </svg>
                            </button>
                            <p id="changeNumber"
                               class="sendOtpSection changeNumber animate__animated animate__slideInUp inActive"
                               @click="onClickChangeNumber()">
                                Change
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-phone">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>+91-@{{mobile_no}}</span>
                            </p>


                            <!-- verify otp section -->
                            <div class="verifyOtpSection myInputBox animate__animated animate__fadeIn inActive">
                                <input type="number" name="otp" id="otp" placeholder="******" v-model="otp"
                                       class="myInput" @change="enableSubmitButton()" @keyup="enableSubmitButton()"/>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <p class="errorLabel"></p>
                            </div>
                            <button id="verifyOtpButton"
                                    class="verifyOtpSection themeButton animate__animated animate__slideInUp loadingButton inActive"
                                    @click="submit_otp()" disabled>
                                <span class="normalText">Verify OTP</span>
                                <span class="loadingText">Verifying...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevrons-right normalSvg">
                                    <polyline points="13 17 18 12 13 7"></polyline>
                                    <polyline points="6 17 11 12 6 7"></polyline>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-loader loadingSvg">
                                    <line x1="12" y1="2" x2="12" y2="6"></line>
                                    <line x1="12" y1="18" x2="12" y2="22"></line>
                                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                    <line x1="2" y1="12" x2="6" y2="12"></line>
                                    <line x1="18" y1="12" x2="22" y2="12"></line>
                                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                                </svg>
                            </button>

                            <!-- <p class="changeNumber disabled timer otpVerificationSection inActiveItem animate__animated animate__fadeIn" @click="send_otp()">Resend OTP <span id="timer">00</span></p> -->

                            <p class="verifyOtpSection disabled timer changeNumber animate__animated animate__slideInUp inActive"
                               @click="send_otp()">
                                Resend OTP <span id="timer"></span>
                            </p>

                            <!-- generate Un Id section -->
                            <div class="generateUnIdSection myInputBox animate__animated animate__fadeIn inActive">
                                <select name="month" id="month" class="myInput unIdInput" required
                                        v-on:change="onSelectMonth()">
                                    <option selected disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--select
                                        month--
                                    </option>
                                    <option value="01" v-if="currentMonth >= 0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;January,
                                        @{{get_current_year}}
                                    </option>
                                    <option value="02" v-if="currentMonth >= 1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;February,
                                        @{{get_current_year}}
                                    </option>
                                    <option value="03" v-if="currentMonth >= 2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;March,
                                        @{{get_current_year}}
                                    </option>
                                    <option value="04" v-if="currentMonth >= 3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;April,
                                        @{{get_current_year}}
                                    </option>
                                    <option value="05" v-if="currentMonth >= 4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;May, @{{get_current_year}}
                                    </option>
                                    <option value="06" v-if="currentMonth >= 5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;June, @{{get_current_year}}
                                    </option>
                                    <option value="07" v-if="currentMonth >= 6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;July, @{{get_current_year}}
                                    </option>
                                    <option value="08" v-if="currentMonth >= 7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;August,
                                        @{{get_current_year}}
                                    </option>
                                    <option value="09" v-if="currentMonth >= 8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;September,
                                        @{{get_current_year}}
                                    </option>
                                    <option value="10" v-if="currentMonth >= 9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;October,
                                        @{{get_current_year}}
                                    </option>
                                    <option value="11" v-if="currentMonth >= 10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;November,
                                        @{{get_current_year}}
                                    </option>
                                    <option value="12" v-if="currentMonth >= 11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;December,
                                        @{{get_current_year}}
                                    </option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-calendar">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <p class="errorLabel"></p>
                            </div>

                            <input type="date" class="form-control form-control-sm" id="terto_date" required
                                   name="terto_date" v-model="to_date" style="display: none">
                            <input type="date" class="form-control form-control-sm" id="terfrom_date" required
                                   name="terfrom_date" v-model="from_date" style="display: none">

                            <div class="generateUnIdSection myInputBox animate__animated animate__fadeIn inActive">
                                <input type="number" name="amount" id="amount" placeholder="Enter TER Amount"
                                       @change="enableGenerateButton()" @keyup="check_amount();get_amount_in_words()"
                                       v-model="amount" class="myInput unIdInput" required/>
                                <span id="amountInwords" style="font-size: 12px;">Required</span>
                                <svg xmlns="http://www.w3.org/2000/svg" id="svg3611" viewBox="0 0 169.76 250.39"
                                     version="1.1">
                                    <g id="layer1" transform="translate(0 -801.97)">
                                        <path id="path4158"
                                              style="stroke:var(--primaryColor);stroke-width:.099084;fill:var(--primaryColor)"
                                              d="m99.017 1052.3-90.577-113.33 0.5232-22.46c42.51 2.93 75.559-1.57 83.248-41.78l-90.578-0.52 14.66-24.55 72.253 1.04c-11.009-22.88-41.286-25.7-88.484-24.02l16.231-24.03 153.41-0.22927-15.184 23.731h-42.409c7.7512 8.1823 13.424 17.597 13.613 25.591l43.98-0.52226-15.184 23.502-29.32 0.52229c-4.5772 35.058-36.787 55.815-77.489 60.584l91.184 116.44-39.874 0.022v0.0004z"></path>
                                    </g>
                                </svg>

                                <p class="errorLabel"></p>
                            </div>
                            <div class="generateUnIdSection myInputBox animate__animated animate__fadeIn inActive">
                                <input type="file" accept="capture=camera, image/png, image/jpg, image/jpeg"
                                       name="scanning_file[]" v-on:change="upload_file($event)" id="fileupload-0"
                                       class="myInput unIdInput" required/>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-paperclip">
                                    <path
                                        d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                </svg>
                                <p class="errorLabel"></p>
                            </div>
                            <button id="generateUnIdButton"
                                    class="generateUnIdSection themeButton disabled animate__animated animate__slideInUp loadingButton inActive"
                                    @click="generate_unid()">
                                <span class="normalText">Generate UNID</span>
                                <span class="loadingText">Generating...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevrons-right normalSvg">
                                    <polyline points="13 17 18 12 13 7"></polyline>
                                    <polyline points="6 17 11 12 6 7"></polyline>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-loader loadingSvg">
                                    <line x1="12" y1="2" x2="12" y2="6"></line>
                                    <line x1="12" y1="18" x2="12" y2="22"></line>
                                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                    <line x1="2" y1="12" x2="6" y2="12"></line>
                                    <line x1="18" y1="12" x2="22" y2="12"></line>
                                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                                </svg>
                            </button>
                            <p class="generateUnIdSection changeNumber animate__animated animate__slideInUp inActive"
                               id="lastSectionError" style="color: darkred">
                                &nbsp;
                            </p>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </section>


    <section id="track_unId" class="trackUnId animate__animated animate__fadeIn">
        <div class="flex flex-wrap md:flex-nowrap justify-center flex-col md:flex-row mx-auto text-center"
             style="flex: 1; height: 100%;">
            <div class="formBlock">
                <div class="formContainer animate__animated animate__fadeIn">

{{--                    <img src="{{asset('assets/img/ter-long-logo.png')}}" alt="sss" class="terLogo longLogo"/>--}}

                    <div class="containerArea animate__animated animate__fadeIn">

                        <img src="{{asset('assets/img/ter-logo.png')}}" alt="sss"
                             class="terLogo animate__animated animate__slideInUp"/>

                        <h2 class="gradientText text-3xl font-bold tracking-tight text-center sm:text-4xl animate__animated animate__slideInUp">
                            Finfect for TER
                        </h2>


                        <div class="loadingBox inActive">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-loader loadingSvg">
                                <line x1="12" y1="2" x2="12" y2="6"></line>
                                <line x1="12" y1="18" x2="12" y2="22"></line>
                                <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                <line x1="2" y1="12" x2="6" y2="12"></line>
                                <line x1="18" y1="12" x2="22" y2="12"></line>
                                <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                            </svg>
                        </div>

                        <img src="{{asset('assets/img/ill-1.svg')}}" alt="demo Illustration"
                             class="trackUnIdSection inlineIllustration active"/>

                        <p class="trackUnIdSection flexText text-center text-black-50 animate__animated animate__slideInUp active">
                            Please enter your UNID
                        </p>

                        <div class="unIdStatus trackingResultSection animate__animated animate__fadeIn inActive">
                            <img :src="src_img" alt="demo Illustration"
                                 class="trackingResultSection animate__animated animate__heartBeat thankYouIllustration inlineIllustration inActive"
                                 style="margin: 1rem auto"/>

                            <p class="item"><span>UNID </span> <span class="strong">: @{{tercourier_data.id}}</span></p>
                            <p class="item"><span>Submitted On </span> <span class="strong"
                                                                             v-if="tercourier_data.tercourier">: @{{ter_submit_date}}
                                    </span></p>
                            <p class="item"><span>For Month </span> <span class="strong">: @{{ter_month}}, @{{get_current_year}}</span>
                            </p>
                            <p class="item">
                                <span>TER Amount</span>
                                <span class="strong" id="word_amt">: @{{amount_in_words}}</span>
                            </p>


                            <div class="paymentReceiptBox" v-if="payment_receipt">
                                <a class="mailButton paymentReceiptSection animate__animated animate__slideInUp active"
                                   @click="sendPaymentOtp()">
                                    Generate Payment Receipt
                                </a>
                                @if(true)
                                    <div
                                        class="paymentOtpSection myInputBox animate__animated animate__slideInUp inActive">
                                        <input type="number" name="paymentOtp" id="paymentOtp"
                                               placeholder="Enter OTP received on Mobile" class="myInput"
                                               @keyup="enableMailButton()" v-model="payment_otp"/>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-lock">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                        <p class="errorLabel"></p>
                                    </div>

                                    <a class="paymentOtpSection mailButton animate__animated animate__slideInUp inActive disabled"
                                       @click="verify_pr_otp()">
                                        Payment Receipt on Mail
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-send">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                    </a>
                                @endif

                                <p class="emailSentSuccess text-sm text-center animate__animated animate__fadeIn inActive"
                                   style="color: green">
                                    Payment receipt has been<br/> sent to registered email address.
                                </p>
                            </div>


                            <a class="changeNumber" style="cursor: pointer" onclick="reloadPage()">Home</a>

                        </div>

                        <div class="formItems">
                            <!-- get info section -->
                            <div class="trackUnIdSection myInputBox animate__animated animate__fadeIn active">
                                <input type="number" name="unId" id="unId" placeholder="Enter UNID" class="myInput"
                                       v-model="unid_no" @keyup="enableTrackButton()"/>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-credit-card">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                <p class="errorLabel"></p>
                            </div>
                            <button id="trackUnIdButton"
                                    class="trackUnIdSection themeButton animate__animated animate__slideInUp loadingButton active"
                                    @click="trackunid()" disabled>
                                <span class="normalText">Track Un Id</span>
                                <span class="loadingText">Fetching Info...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevrons-right normalSvg">
                                    <polyline points="13 17 18 12 13 7"></polyline>
                                    <polyline points="6 17 11 12 6 7"></polyline>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-loader loadingSvg">
                                    <line x1="12" y1="2" x2="12" y2="6"></line>
                                    <line x1="12" y1="18" x2="12" y2="22"></line>
                                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                    <line x1="2" y1="12" x2="6" y2="12"></line>
                                    <line x1="18" y1="12" x2="22" y2="12"></line>
                                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                                </svg>
                            </button>
                            <p class="trackUnIdSection changeNumber animate__animated animate__slideInUp active justify-between">
                                <span onclick="reloadPage()">Home</span>
                                <span onclick="onClickGenerateNew()">Generate New</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="illustrationContainer">
                <img src="{{asset('assets/img/side-illustration.png')}}" alt="sss" class="sideIllustration"/>
            </div>

        </div>
    </section>


</main>

<script>
    let exitFlag = true

    window.onload = (event) => {
        $('#loading_screen').addClass('active');
    };

    setTimeout(() => {
        $('#landing_screen').addClass('active');
        $('#loading_screen').removeClass('active');
    }, 1500);

    const reloadPage = () => {
        exitFlag = false
        location.reload();
    }

    const onClickGenerate = () => {
        $('#generate_unId').addClass('active');
        $('#landing_screen').removeClass('active');
    }

    const onClickGenerateNew = () => {
        $('#track_unId').removeClass('active');
        $('#generate_unId').addClass('active');
    }

    const onClickTrack = () => {
        $('#track_unId').addClass('active');
        $('#landing_screen').removeClass('active');
    }

    const onClickTrackOldOne = () => {
        $('#track_unId').addClass('active');
        $('#generate_unId').removeClass('active');
    }

    // for enabling getInfoButton
    function enableButton() {
        if ($('#mobile_number').val().length == 10)
            $("#getInfoButton").removeAttr('disabled');
        else
            $("#getInfoButton").attr('disabled', true);
    }

    // function enableSubmitButton() {
    //     if ($('#otp').val().length == 6)
    //         $("#verifyOtpButton").removeAttr('disabled');
    //     else
    //         $("#verifyOtpButton").attr('disabled', true);
    // }


    function onClickGetInfo() {
        event.stopPropagation();
        event.stopImmediatePropagation();
        let regx = /^[6-9]\d{9}$/;
        if (regx.test($('#mobile_number').val())) {
            $('#mobile_number').siblings('.errorLabel').html('')
            $(this).addClass('functioning');
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('inActive'));
            setTimeout(() => {
                $(this).removeClass('functioning');
                document.querySelectorAll('.mobileInputSection').forEach((elm) => elm.removeClass('active'));
                document.querySelectorAll('.mobileInputSection').forEach((elm) => elm.addClass('inActive'));
                document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.removeClass('inActive'));
                document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.addClass('active'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.removeClass('inActive'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.addClass('active'));

                document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('active'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('inActive'));
            }, 1500)
        } else $('#mobile_number').siblings('.errorLabel').html('Enter a valid mobile number')
    }


    $("#getInfoButton").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        let regx = /^[6-9]\d{9}$/;
        if (regx.test($('#mobile_number').val())) {
            $('#mobile_number').siblings('.errorLabel').html('')
            $(this).addClass('functioning');
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('inActive'));
            setTimeout(() => {
                $(this).removeClass('functioning');
                document.querySelectorAll('.mobileInputSection').forEach((elm) => elm.removeClass('active'));
                document.querySelectorAll('.mobileInputSection').forEach((elm) => elm.addClass('inActive'));
                document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.removeClass('inActive'));
                document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.addClass('active'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.removeClass('inActive'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.addClass('active'));

                document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('active'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('inActive'));
            }, 1500)
        } else $('#mobile_number').siblings('.errorLabel').html('Enter a valid mobile number')
    });

    $("#sendOtpButton").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        $(this).addClass('functioning');
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('active'));
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('inActive'));
        setTimeout(() => {
            $(this).removeClass('functioning');
            document.querySelectorAll('.userCard').forEach((elm) => elm.addClass('compact'));

            document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.addClass('inActive'));
            document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.removeClass('active'));
            document.querySelectorAll('.verifyOtpSection').forEach((elm) => elm.removeClass('inActive'));
            document.querySelectorAll('.verifyOtpSection').forEach((elm) => elm.addClass('active'));

            document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('inActive'));
        }, 1500)

    });

    // for removing errors
    $(document).on("keyup", ".myInput", function () {
        if ($(this).siblings('.errorLabel').html().length > 2)
            $(this).siblings('.errorLabel').html("");
    })


    // for enabling verifyOtpButton
    $('#otp').on('keyup', function () {
        if ($(this).val().length > 5) {
            $("#verifyOtpButton").removeAttr('disabled');
        } else $("#verifyOtpButton").attr('disabled', true);
    })
    $("#verifyOtpButton").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        if ($('#otp').val().length == 6) {
            $('#otp').siblings('.errorLabel').html('')
            $(this).addClass('functioning');
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('inActive'));
            setTimeout(() => {
                $(this).removeClass('functioning');
                document.querySelectorAll('.verifyOtpSection').forEach((elm) => elm.removeClass('active'));
                document.querySelectorAll('.verifyOtpSection').forEach((elm) => elm.addClass('inActive'));
                document.querySelectorAll('.generateUnIdSection').forEach((elm) => elm.removeClass('inActive'));
                document.querySelectorAll('.generateUnIdSection').forEach((elm) => elm.addClass('active'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('active'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('inActive'));
            }, 1500)
        } else {
            $('#otp').siblings('.errorLabel').html('Enter a valid mobile number')
        }
    });

    // for enabling verifyOtpButton
    // $("#generateUnIdButton").on('click', function(event) {
    //     event.stopPropagation();
    //     event.stopImmediatePropagation();
    //     if ($('#otp').val().length == 6) {
    //         $('#otp').siblings('.errorLabel').html('')
    //         $(this).addClass('functioning');
    //         document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('active'));
    //         document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('inActive'));
    //         setTimeout(() => {
    //             $(this).removeClass('functioning');
    //             document.querySelectorAll('.generateUnIdSection').forEach((elm) => elm.removeClass('active'));
    //             document.querySelectorAll('.generateUnIdSection').forEach((elm) => elm.addClass('inActive'));
    //             document.querySelectorAll('.userCard').forEach((elm) => elm.removeClass('active'));
    //             document.querySelectorAll('.userCard').forEach((elm) => elm.addClass('inActive'));
    //             document.querySelectorAll('.thankYouSection').forEach((elm) => elm.addClass('active'));
    //             document.querySelectorAll('.thankYouSection').forEach((elm) => elm.removeClass('inActive'));
    //             document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('active'));
    //             document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('inActive'));
    //         }, 1500)
    //     } else {
    //         $('#otp').siblings('.errorLabel').html('Enter a valid mobile number')
    //     }
    // });


    // function enableTrackButton() {
    //     if ($('#unId').val().length < 1)
    //         $("#trackUnIdButton").removeAttr('disabled');
    //     else
    //         $("#trackUnIdButton").attr('disabled', true);
    // }


    // track unid
    // $("#trackUnIdButton").on('click', function(event) {
    //     event.stopPropagation();
    //     event.stopImmediatePropagation();
    //     $(this).addClass('functioning');
    //     document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('active'));
    //     document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('inActive'));
    //     setTimeout(() => {
    //         $(this).removeClass('functioning');
    //         document.querySelectorAll('.trackUnIdSection').forEach((elm) => elm.removeClass('active'));
    //         document.querySelectorAll('.trackUnIdSection').forEach((elm) => elm.addClass('inActive'));
    //         document.querySelectorAll('.trackingResultSection').forEach((elm) => elm.removeClass('inActive'));
    //         document.querySelectorAll('.trackingResultSection').forEach((elm) => elm.addClass('active'));

    //         document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('active'));
    //         document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('inActive'));
    //     }, 1500)
    // });


    // send Email
    // const sendEmail = () => {
    //     document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('inActive'));
    //     document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('active'));
    //     setTimeout(() => {
    //         document.querySelectorAll('.paymentOtpSection').forEach((elm) => elm.removeClass('active'));
    //         document.querySelectorAll('.paymentOtpSection').forEach((elm) => elm.addClass('inActive'));

    //         document.querySelectorAll('.emailSentSuccess').forEach((elm) => elm.removeClass('inActive'));
    //         document.querySelectorAll('.emailSentSuccess').forEach((elm) => elm.addClass('active'));

    //         document.querySelectorAll('.loadingBox').forEach((elm) => elm.removeClass('active'));
    //         document.querySelectorAll('.loadingBox').forEach((elm) => elm.addClass('inActive'));
    //     }, 1200)

    // }
    // send Email
    // const sendPaymentOtp = () => {
    //     $('.loadingBox').removeClass('inActive');
    //     $('.loadingBox').addClass('active');
    //     setTimeout(() => {
    //         $('.paymentReceiptSection').removeClass('active');
    //         $('.paymentReceiptSection').addClass('inActive');

    //         $('.paymentOtpSection').('inActive');
    //         $('.paymentOtpSection').addClass('active');

    //         $('.loadingBox').removeClass('active');
    //         $('.loadingBox').addClass('inActive');
    //     }, 1200)
    // }


    function runTmer() {
        var timeleft = 60;
        var downloadTimer = setInterval(function () {
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

    window.onbeforeunload = function (e) {
        if (exitFlag) {
            e = e || window.event;
            if (e) e.returnValue = 'Sure?';
            return 'Sure?';
        }
    }
</script>
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
            unid: "",
            unid_no: "",
            tercourier_data: {},
            src_img: "",
            payment_receipt: false,
            ter_month: "",
            ter_submit_date: "",
            amount_in_words: "",
            employee_id: "",
            payment_otp: "",
            ter_unid: "",
            get_current_year: "",
            currentMonth: new Date().getMonth()


        },

        created: function () {
            this.get_current_year = new Date().getFullYear();
            //   alert('hello');
            // var table=$('#html5-extension');
            // table.dataTable({dom : 'lrt'});
            // $('table').dataTable({bFilter: false, bInfo: false});
            // https://dpportal.s3.us-east-2.amazonaws.com/invoice_images/AUVuGTgPlYBC8LhDUUVr5LxfPdwmOib6JE5Kmmvk.jpg
        },


        methods: {
            enableSubmitButton: function () {
                if ($('#otp').val().length == 6)
                    $("#verifyOtpButton").removeAttr('disabled');
                else
                    $("#verifyOtpButton").attr('disabled', true);
            },
            enableMailButton: function () {
                if (this.payment_otp.length > 5) {
                    $('.mailButton').removeClass('disabled');
                } else {
                    $('.mailButton').addClass('disabled');
                }
            },
            verify_pr_otp: function () {
                if ($('#paymentOtp').val().length == 6) {
                    $('#paymentOtp').siblings('.errorLabel').html('');
                    $('.loadingBox').addClass('active');
                    $('.loadingBox').removeClass('inActive');
                } else {
                    $('#paymentOtp').siblings('.errorLabel').html('OTP is not correct')
                    return 1;
                }
                // else{
                //     $('#otp').siblings('.errorLabel').html('Enter a valid mobile number')
                // }
                if (this.payment_otp != "") {
                    axios.post('/verify_otp', {
                        'emp_id': this.employee_id,
                        'otp': this.payment_otp,
                        'ter_unid': this.ter_unid,
                    })
                        .then(response => {
                            // console.log(response.data[0]);
                            if (response.data.errors) {
                                if (response.data.errors.emp_id) {
                                    $('#otp').siblings('.errorLabel').html(response.data.errors.emp_id)
                                }
                                if (response.data.errors.otp) {
                                    $('#otp').siblings('.errorLabel').html(response.data.errors.otp)
                                }
                            }
                            if (response.data == "empty_array") {
                                $('#paymentOtp').siblings('.errorLabel').html('Employee Id mismatch..')
                            }

                            if (response.data == "otp_matched") {

                                $('.paymentOtpSection').removeClass('active');
                                $('.paymentOtpSection').addClass('inActive');

                                $('.emailSentSuccess').removeClass('inActive');
                                $('.emailSentSuccess').addClass('active');
                            }
                            if (response.data == "invalid_otp") {

                                $('#paymentOtp').siblings('.errorLabel').html('Invalid OTP')
                            }
                        }).catch(error => {

                    })
                        .finally(() => {
                            $('.loadingBox').removeClass('active');
                            $('.loadingBox').addClass('inActive');
                        })

                } else {
                    $('#paymentOtp').siblings('.errorLabel').html('Please Fill the OTP Field')
                }
            },
            sendPaymentOtp: function () {

                $('.loadingBox').addClass('active');
                $('.loadingBox').removeClass('inActive');

                axios.post('/send_otp', {
                    'emp_id': this.employee_id
                })
                    .then(response => {

                        // console.log(response.data[0]);
                        if (response.data.errors) {
                            return 1;
                        }
                        if (response.data == "empty_array") {
                            // this.otp_field_flag = false;
                        }
                        if (response.data == "msg_sent") {
                            // runTmer();
                            // this.otp_field_flag = true;
                            // this.test_flag = false;
                            $('.paymentReceiptSection').removeClass('active');
                            $('.paymentReceiptSection').addClass('inActive');

                            $('.paymentOtpSection').removeClass('inActive');
                            $('.paymentOtpSection').addClass('active');
                        }
                        if (response.data == "msg_not_sent") {
                            // this.otp_field_flag = false;
                        }

                    }).catch(error => {
                    // this.otp_field_flag = false;

                })
                    .finally(() => {
                        $('.loadingBox').removeClass('active');
                        $('.loadingBox').addClass('inActive');
                    })


            },
            get_month_name: function (month) {
                let day, month_num;
                month_num = month;
                //    alert(month_num);
                //    return 1;
                switch (month_num) {
                    case "01":
                        day = "January";
                        break;
                    case "02":
                        day = "February";
                        break;
                    case "03":
                        day = "March";
                        break;
                    case "04":
                        day = "April";
                        break;
                    case "05":
                        day = "May";
                        break;
                    case "06":
                        day = "June";
                        break;
                    case "07":
                        day = "July";
                        break;
                    case "08":
                        day = "August";
                        break;
                    case "09":
                        day = "September";
                        break;
                    case "10":
                        day = "October";
                        break;
                    case "11":
                        day = "November";
                        break;
                    case "12":
                        day = "December";

                }
                return day;
            },
            trackunid: function () {

                if (this.unid_no.length > 3) {
                    $('#trackUnIdButton').addClass('functioning');
                    $('.loadingBox').addClass('active');
                    $('.loadingBox').removeClass('inActive');
                } else {
                    return 1;
                }

                if (this.unid_no != "") {
                    axios.post('/track_unid', {
                        'unid': this.unid_no,
                    })
                        .then(response => {
                            // console.log(response.data[0]);


                            if (response.data == "unid_doesnot_exist") {
                                $('#unId').siblings('.errorLabel').html("Unid doesn't exist");

                            }
                            if (response.data[0] == "100") {
                                // console.log(response.data[1][0]);
                                this.tercourier_data = response.data[1][0];
                                // this.ter_submit_date = this.tercourier_data.tercourier.unid_generated_date;
                                if (this.tercourier_data != "") {
                                    const date_split = this.tercourier_data.tercourier.unid_generated_date.split("-");
                                    let day, month_num, ter_date, ter_month_name;
                                    month_num = date_split[1];
                                    day = this.get_month_name(month_num);
                                    ter_date = this.tercourier_data.terto_date.split("-");

                                    ter_month_name = this.get_month_name(ter_date[1]);


                                    this.ter_submit_date = date_split[2] + '-' + day + '-' + date_split[0];
                                    this.ter_month = ter_month_name;
                                    this.amount_in_words = inWords(this.tercourier_data.amount);
                                    document.getElementById('word_amt').style.textTransform = "capitalize";
                                    this.employee_id = this.tercourier_data.employee_id;
                                    this.ter_unid = this.tercourier_data.id;
                                } else {
                                    this.ter_submit_date = "";
                                    this.ter_month = "";
                                    this.amount_in_words = "";
                                }

                                if (this.tercourier_data.status == 5) {
                                    this.payment_receipt = true;
                                    this.src_img = "{{asset('assets/img/paid-1.png')}} ";
                                } else {
                                    this.payment_receipt = false;
                                    this.src_img = "{{asset('assets/img/processing-1.png')}} ";
                                }
                                $('.trackUnIdSection').removeClass('active');
                                $('.trackUnIdSection').addClass('inActive');
                                $('.trackingResultSection').removeClass('inActive');
                                $('.trackingResultSection').addClass('active');


                            }
                            if (response.data.errors.unid) {
                                $('#unId').siblings('.errorLabel').html("Invalid Unid");

                            }


                        }).catch(error => {
                        this.otp_field_flag = false;

                    })
                        .finally(() => {
                            $('#trackUnIdButton').removeClass('functioning');
                            $('.loadingBox').removeClass('active');
                            $('.loadingBox').addClass('inActive');
                        })

                }

            },
            enableTrackButton: function () {
                if ($('#unId').val().length > 3)
                    $("#trackUnIdButton").removeAttr('disabled');
                else
                    $("#trackUnIdButton").attr('disabled', true);
            },
            onClickChangeNumber: function () {
                $('.mobileInputSection').addClass('active');
                $('.mobileInputSection').removeClass('inActive');
                $('.sendOtpSection').addClass('inActive');
                $('.sendOtpSection').removeClass('active');
                $('.userCard').addClass('inActive');
                $('.userCard').removeClass('active');
            },
            check_amount: function () {
                if (this.amount > 100000) {
                    $('#amount').siblings('.errorLabel').html("Amount Can't be Greater than 1 Lakh");

                    this.amount = "";
                    document.getElementById('amountInwords').innerHTML = "";

                } else {
                    $('#amount').siblings('.errorLabel').html("");
                }
            },
            onSelectMonth: function () {
                this.selectedMonth = document.getElementById('month').value
                this.currentYear = new Date().getFullYear();
                this.enableGenerateButton()
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
                this.enableGenerateButton()
            },
            get_amount_in_words: function () {
                if (this.amount != "") {
                    document.getElementById('amountInwords').innerHTML = inWords(document.getElementById('amount').value);
                    document.getElementById('amountInwords').style.textTransform = "capitalize";
                } else {
                    document.getElementById('amountInwords').innerHTML = "";
                }
            },
            enableGenerateButton: function () {

                if (this.amount != "" && this.from_date != "" && this.to_date != "" && this.file != "") {
                    $("#generateUnIdButton").removeAttr('disabled');
                } else $("#generateUnIdButton").attr('disabled', true);

                this.check_amount();
            },
            generate_unid: function () {

                if (this.amount != "" && this.from_date != "" && this.to_date != "" && this.file != "") {
                    if (this.amount <= 100000) {


                        $('.loadingBox').addClass('active');
                        $('.loadingBox').removeClass('inActive');
                        $('#generateUnIdButton').addClass('functioning');


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

                                    // swal('error', "UNID can not generate for this Employee Designation", 'error')
                                    $('#lastSectionError').html("UNID can't generate");
                                }
                                if (response.data[0] == "100") {
                                    // swal('success', "UNID generated Successfully UNID: " + " " + response.data[1], 'success')
                                    // onClickGenerate();
                                    this.unid = response.data[1];
                                    $('#lastSectionError').html("UNID generated " + response.data[1]);
                                    $('.generateUnIdSection').removeClass('active');
                                    $('.generateUnIdSection').addClass('inActive');
                                    $('.userCard').removeClass('active');
                                    $('.userCard').addClass('inActive');
                                    $('.thankYouSection').addClass('active');
                                    $('.thankYouSection').removeClass('inActive');
                                    exitFlag = false
                                }
                                if (response.data[0] == "last_working_date") {
                                    $('#month').siblings('.errorLabel').html("Period exceeding last working date " + " " + response.data[1]);
                                }
                                if (response.data[0] == "unid_already_generated") {
                                    $('#lastSectionError').html("UNID " + response.data[2] + " already generated for month of " + " " + response.data[1]);
                                }
                                if (response.data.errors.emp_id) {
                                    $('#lastSectionError').html("Invalid employee Id");
                                }
                                if (response.data.errors.amount) {
                                    $('#amount').siblings('.errorLabel').html("Invalid amount");
                                }
                                if (response.data.errors.from_date) {
                                    $('#lastSectionError').html("Invalid date");
                                }
                                if (response.data.errors.to_date) {
                                    $('#lastSectionError').html("Invalid date");
                                }
                                if (response.data.errors.file) {
                                    $('#fileupload-0').siblings('.errorLabel').html("Invalid file");
                                }
                            }).catch(error => {
                            console.log('error')
                        }).finally(() => {
                            $('#generateUnIdButton').removeClass('functioning');
                            $('.loadingBox').removeClass('active');
                            $('.loadingBox').addClass('inActive');
                        })
                    } else {
                        $('#amount').siblings('.errorLabel').html("Amount Can't be greater than 1 Lakh");
                        document.getElementById('amountInwords').innerHTML = "";
                        this.amount = "";
                    }
                } else {
                    $('#lastSectionError').html("Fields are Empty");
                    // swal('error', "Fields are Empty", 'error')
                }

            },
            submit_otp: function () {
                // const len = this.otp.length
                // if (len != 6) {
                //     $('#otp').siblings('.errorLabel').html('OTP is not  fd correct')
                //     return 1;
                // }else{
                //     $('#otp').siblings('.errorLabel').html('')
                // }

                if ($('#otp').val().length == 6) {
                    $('#otp').siblings('.errorLabel').html('')
                    $('#verifyOtpButton').addClass('functioning');
                    $('.loadingBox').addClass('active');
                    $('.loadingBox').removeClass('inActive');
                } else {
                    $('#otp').siblings('.errorLabel').html('OTP is not correct')
                    return 1;
                }
                // else{
                //     $('#otp').siblings('.errorLabel').html('Enter a valid mobile number')
                // }
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
                                    $('#otp').siblings('.errorLabel').html(response.data.errors.emp_id)

                                    // swal('error', "" + response.data.errors.emp_id + "", 'error')
                                }
                                if (response.data.errors.otp) {
                                    $('#otp').siblings('.errorLabel').html(response.data.errors.otp)

                                    // swal('error', "" + response.data.errors.otp + "", 'error')
                                }
                            }
                            if (response.data == "empty_array") {
                                this.otp_field_flag = false;
                                this.document_flag = false;
                                $('#otp').siblings('.errorLabel').html('Employee Id mismatch..')

                                // swal('error', "Employee Id mismatch..", 'error')
                            }

                            if (response.data == "otp_matched") {
                                this.otp_field_flag = false;
                                this.submit_otp_btn_flag = false;
                                this.document_flag = true;
                                $('.verifyOtpSection').removeClass('active');
                                $('.verifyOtpSection').addClass('inActive');
                                $('.generateUnIdSection').removeClass('inActive');
                                $('.generateUnIdSection').addClass('active');
                                $('.loadingBox').removeClass('active');
                                $('.loadingBox').addClass('inActive');
                            }
                            if (response.data == "invalid_otp") {
                                this.otp_field_flag = false;
                                this.document_flag = false;
                                $('#otp').siblings('.errorLabel').html('Invalid OTP')

                                // swal('error', "Invalid OTP", 'error')
                            }

                        }).catch(error => {
                        this.otp_field_flag = false;

                    })
                        .finally(() => {
                            $('#verifyOtpButton').removeClass('functioning');
                            $('.loadingBox').removeClass('active');
                            $('.loadingBox').addClass('inActive');
                        })

                } else {
                    $('#otp').siblings('.errorLabel').html('Please Fill the OTP Field')

                    // swal('error', "Please Fill the OTP Field", 'error')

                }

            },
            s: function () {
                const len = this.mobile_no.length
                if (len > 10) {
                    // alert(this.mobile_no.length)
                    // e.preventDefault();
                    return false;
                }

            },
            send_otp: function () {
                this.otp_count += 1;
                // document.getElementById("#send_otp").disabled = true;
                $('#sendOtpButton').addClass('functioning');
                $('.loadingBox').addClass('active');
                $('.loadingBox').removeClass('inActive');
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
                        }
                        if (response.data == "msg_sent") {
                            runTmer();
                            this.otp_field_flag = true;
                            this.test_flag = false;
                            $('.userCard').addClass('compact');
                            $('.sendOtpSection').addClass('inActive');
                            $('.sendOtpSection').removeClass('active');
                            $('.verifyOtpSection').removeClass('inActive');
                            $('.verifyOtpSection').addClass('active');
                        }
                        if (response.data == "msg_not_sent") {
                            this.otp_field_flag = false;
                        }

                    }).catch(error => {
                    this.otp_field_flag = false;

                })
                    .finally(() => {
                        $('#sendOtpButton').removeClass('functioning');
                        $('.loadingBox').removeClass('active');
                        $('.loadingBox').addClass('inActive');
                    })


            },
            check_employee_exist: function () {
                // event.stopPropagation();
                // event.stopImmediatePropagation();
                let regx = /^[6-9]\d{9}$/;


                const len = this.mobile_no.length

                if (regx.test($('#mobile_number').val())) {
                    // console.log('amit')
                    $('#mobile_number').siblings('.errorLabel').html('')
                    $('#getInfoButton').addClass('functioning');
                    $('.loadingBox').addClass('active');
                    $('.loadingBox').removeClass('inActive');

                    axios.post('/check_registered_mobile', {
                        'mobile_number': this.mobile_no,
                        'type': "ter"
                    })
                        .then(response => {
                            // console.log(response.data[0]);
                            if (response.data == "empty_array") {
                                this.otp_flag = false;
                                $('#mobile_number').siblings('.errorLabel').html('Mobile number not registered')
                            }
                            if (response.data.errors) {
                                this.otp_flag = false;
                                $('#mobile_number').siblings('.errorLabel').html(response.data.errors.mobile_number)
                                // swal('error', "" + response.data.errors.mobile_number + "", 'error')
                            }

                            if (response.data[0] == "available") {
                                this.otp_flag = true;
                                this.employee_data = response.data[1][0];
                                this.emp_id = this.employee_data.employee_id;

                                $('#getInfoButton').removeClass('functioning');
                                $('.mobileInputSection').removeClass('active');
                                $('.mobileInputSection').addClass('inActive');
                                $('.sendOtpSection').removeClass('inActive');
                                $('.sendOtpSection').addClass('active');
                                $('.userCard').removeClass('inActive');
                                $('.userCard').addClass('active');
                            }

                        }).catch(error => {
                        this.otp_flag = false;

                    }).finally(() => {
                        $('#getInfoButton').removeClass('functioning');
                        $('.loadingBox').removeClass('active');
                        $('.loadingBox').addClass('inActive');
                    })
                } else $('#mobile_number').siblings('.errorLabel').html('Enter a valid mobile number')

            },
        }
    })
</script>

</body>

</html>

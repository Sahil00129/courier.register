<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <meta name="description" content="TER process portal">
    <title>TER Process</title>
    <link href="{{asset('assets/css/sample-page.css')}}" rel="stylesheet" type="text/css"/>

    <!--    for animation-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!--    for external css-->
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
            crossorigin="anonymous"></script>

</head>
<body>

<main>
    <section id="loading_screen" class="animate__animated animate__fadeIn">
        <div class="flex flex-wrap md:flex-nowrap justify-center flex-col md:flex-row mx-auto text-center"
             style="height: 100%; align-items: center; max-width: 900px; row-gap: 2rem">
            <img src="{{asset('assets/img/ter-long-logo.png')}}" alt="sss" class="terLogo longLogo"/>
        </div>
    </section>

    <section id="landing_screen" class="animate__animated animate__fadeIn ">
        <div class="flex flex-wrap md:flex-nowrap justify-center flex-col md:flex-row mx-auto text-center"
             style="height: 100%; align-items: center; max-width: 900px; row-gap: 2rem">
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
                    Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis
                    vel nulla.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6 animate__animated animate__slideInUp">
                    <button class="flex justify-center themeButton"
                            onClick="onClickGenerate()" style="max-width: 170px">
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
                                    <p class="empId"><span>E000044</span> <span class="statusText">Active</span></p>
                                    <p class="empName">Full Name</p>
                                    <p class="empDes">Designation</p>
                                    {{--                                <p class="empStatus">Active</p>--}}
                                </div>
                            </div>

                            <p class="flexText mobileInputSection text-sm leading-8 text-center text-black-50 animate__animated animate__slideInUp active">
                                Enter your registered mobile number.
                            </p>

                            <p class="verifyOtpSection text-sm leading-8 text-center animate__animated animate__bounceIn inActive"
                               style="color: green">
                                An OTP has been sent to +91-8529698369
                            </p>

                            <p class="thankYouSection flex-col text-sm text-center animate__animated animate__bounceIn inActive">
                                <span style="color: green; font-size: 18px; max-width: 38ch; margin-bottom: 8px">Thank You</span>
                                Dear Employee Name, Your UNID QWE1234 has been generated successfully.<br/>
                                <span style="margin-top: 10px;"><a style="cursor: pointer"
                                                                   onclick="reloadPage()">Home</a></span>
                            </p>
                        </div>

                        <div class="formItems">
                            <!-- get info section -->
                            <div class="mobileInputSection myInputBox animate__animated animate__fadeIn active">
                                <input type="number"
                                       name="mobile_number"
                                       id="mobile_number"
                                       placeholder="Your Mobile Number"
                                       class="myInput"/>
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
                                    disabled>
                                <span class="normalText">Get Info</span>
                                <span class="loadingText">Fetching Info...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-chevrons-right normalSvg">
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
                            <p class="mobileInputSection changeNumber animate__animated animate__slideInUp active"
                               onclick="onClickTrackOldOne()">
                                Track Un Id</p>

                            <!-- send Otp section -->
                            <button id="sendOtpButton"
                                    class="sendOtpSection themeButton animate__animated animate__slideInUp loadingButton inActive">
                                <span class="normalText">Send OTP</span>
                                <span class="loadingText">Sending...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-chevrons-right normalSvg">
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
                               class="sendOtpSection changeNumber animate__animated animate__slideInUp inActive">
                                Change
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-phone">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>+91-8529698369</span>
                            </p>


                            <!-- verify otp section -->
                            <div class="verifyOtpSection myInputBox animate__animated animate__fadeIn inActive">
                                <input type="number"
                                       name="otp"
                                       id="otp"
                                       placeholder="******"
                                       class="myInput"/>
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
                                    disabled>
                                <span class="normalText">Verify OTP</span>
                                <span class="loadingText">Verifying...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-chevrons-right normalSvg">
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
                            <p class="verifyOtpSection changeNumber animate__animated animate__slideInUp inActive">
                                Resend OTP
                            </p>

                            <!-- generate Un Id section -->
                            <div class="generateUnIdSection myInputBox animate__animated animate__fadeIn inActive">
                                <select name="month"
                                        id="month"
                                        class="myInput unIdInput" required>
                                    <option selected disabled>--Select Month--</option>
                                    <option value="01">January</option>
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
                            <div class="generateUnIdSection myInputBox animate__animated animate__fadeIn inActive">
                                <input type="number"
                                       name="amount"
                                       id="amount"
                                       placeholder="Enter TER Amount"
                                       class="myInput unIdInput" required/>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     id="svg3611"
                                     viewBox="0 0 169.76 250.39"
                                     version="1.1">
                                    <g id="layer1" transform="translate(0 -801.97)">
                                        <path
                                            id="path4158"
                                            style="stroke:var(--primaryColor);stroke-width:.099084;fill:var(--primaryColor)"
                                            d="m99.017 1052.3-90.577-113.33 0.5232-22.46c42.51 2.93 75.559-1.57 83.248-41.78l-90.578-0.52 14.66-24.55 72.253 1.04c-11.009-22.88-41.286-25.7-88.484-24.02l16.231-24.03 153.41-0.22927-15.184 23.731h-42.409c7.7512 8.1823 13.424 17.597 13.613 25.591l43.98-0.52226-15.184 23.502-29.32 0.52229c-4.5772 35.058-36.787 55.815-77.489 60.584l91.184 116.44-39.874 0.022v0.0004z"
                                        ></path>
                                    </g>
                                </svg>

                                <p class="errorLabel"></p>
                            </div>
                            <div class="generateUnIdSection myInputBox animate__animated animate__fadeIn inActive">
                                <input type="file" accept="image/png, image/jpg, image/jpeg" name="scanning_file[]"
                                       id="fileupload-0" class="myInput unIdInput" required capture="user"/>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-paperclip">
                                    <path
                                        d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                </svg>
                                <p class="errorLabel"></p>
                            </div>
                            <button id="generateUnIdButton"
                                    class="generateUnIdSection themeButton animate__animated animate__slideInUp loadingButton inActive">
                                <span class="normalText">Generate UNID</span>
                                <span class="loadingText">Generating...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-chevrons-right normalSvg">
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
                            <p class="generateUnIdSection changeNumber animate__animated animate__slideInUp inActive">
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

                    <img src="{{asset('assets/img/ter-long-logo.png')}}" alt="sss" class="terLogo longLogo"/>

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

                        <img src="{{asset('assets/img/ill-1.svg')}}" alt="demo Illustration"
                             class="trackUnIdSection inlineIllustration active"/>

                        <p class="trackUnIdSection text-sm leading-8 text-center text-black-50 animate__animated animate__slideInUp active">
                            Please enter Un Id to track.
                        </p>

                        <div class="unIdStatus trackingResultSection animate__animated animate__fadeIn inActive">
                            <img
                                src="@if(true) {{asset('assets/img/paid-1.png')}} @else {{asset('assets/img/processing-1.png')}} @endif"
                                alt="demo Illustration"
                                class="trackingResultSection animate__animated animate__fadeIn inlineIllustration inActive"
                                style="margin: 1rem auto"/>

                            <p class="item"><span>UNID </span> <span class="strong">: 1234567</span></p>
                            <p class="item"><span>Submitted On </span> <span class="strong">: 12 Jan 2023</span></p>
                            <p class="item"><span>For Month </span> <span class="strong">: January</span></p>
                            <p class="item">
                                <span>TER Amount</span>
                                <span class="strong">: One Thousand Two Hundred and Ninety rupees</span>
                            </p>


                            <div class="paymentReceiptBox">
                                <a class="mailButton paymentReceiptSection animate__animated animate__slideInUp active"
                                   onclick="sendPaymentOtp()">
                                    Generate Payment Receipt
                                </a>
                                @if(true)
                                    <div
                                        class="paymentOtpSection myInputBox animate__animated animate__slideInUp inActive">
                                        <input type="number"
                                               name="paymentOtp"
                                               id="paymentOtp"
                                               placeholder="Enter OTP received on Mobile"
                                               class="myInput"/>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round" class="feather feather-lock">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                        <p class="errorLabel"></p>
                                    </div>

                                    <a class="paymentOtpSection mailButton animate__animated animate__slideInUp inActive"
                                       onclick="sendEmail()">
                                        Payment Receipt on Mail
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round" class="feather feather-send">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                    </a>
                                @endif

                                <p class="emailSentSuccess text-sm text-center animate__animated animate__fadeIn inActive"
                                   style="color: green">
                                    Payment receipt has been sent to registered email address.
                                </p>
                            </div>


                            <a class="changeNumber" style="cursor: pointer" onclick="reloadPage()">Home</a>

                        </div>

                        <div class="formItems">
                            <!-- get info section -->
                            <div class="trackUnIdSection myInputBox animate__animated animate__fadeIn active">
                                <input type="number"
                                       name="unId"
                                       id="unId"
                                       placeholder="Un Id"
                                       class="myInput"/>
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
                                    disabled>
                                <span class="normalText">Track Un Id</span>
                                <span class="loadingText">Fetching Info...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-chevrons-right normalSvg">
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
                            <p class="trackUnIdSection changeNumber animate__animated animate__slideInUp active"
                               onclick="onClickGenerateNew()">
                                Generate New</p>
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
    const LoadingScreen = document.getElementById('loading_screen');
    const LandingScreen = document.getElementById('landing_screen');
    const generateUnId = document.getElementById('generate_unId');
    const trackUnId = document.getElementById('track_unId');

    window.onload = (event) => {
        LoadingScreen.classList.add('active');
    };

    setTimeout(() => {
        LandingScreen.classList.add('active');
        LoadingScreen.classList.remove('active');
    }, 1500);

    const reloadPage = () => location.reload();

    const onClickGenerate = () => {
        generateUnId.classList.add('active');
        LandingScreen.classList.remove('active');
    }

    const onClickGenerateNew = () => {
        trackUnId.classList.remove('active');
        generateUnId.classList.add('active');
    }

    const onClickTrack = () => {
        trackUnId.classList.add('active');
        LandingScreen.classList.remove('active');
    }

    const onClickTrackOldOne = () => {
        trackUnId.classList.add('active');
        generateUnId.classList.remove('active');
    }

    // for enabling getInfoButton
    $('#mobile_number').on('keyup', function () {
        if ($('#mobile_number').val().length == 10)
            $("#getInfoButton").removeAttr('disabled');
        else
            $("#getInfoButton").attr('disabled', true);
    });

    $("#getInfoButton").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        let regx = /^[6-9]\d{9}$/;
        if (regx.test($('#mobile_number').val())) {
            $('#mobile_number').siblings('.errorLabel').html('')
            $(this).addClass('functioning');
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('inActive'));
            setTimeout(() => {
                $(this).removeClass('functioning');
                document.querySelectorAll('.mobileInputSection').forEach((elm) => elm.classList.remove('active'));
                document.querySelectorAll('.mobileInputSection').forEach((elm) => elm.classList.add('inActive'));
                document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.classList.remove('inActive'));
                document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.classList.add('active'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.classList.remove('inActive'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.classList.add('active'));

                document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('active'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('inActive'));
            }, 1500)
        } else {
            $('#mobile_number').siblings('.errorLabel').html('Enter a valid mobile number')
        }
    });

    $("#sendOtpButton").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        $(this).addClass('functioning');
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('active'));
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('inActive'));
        setTimeout(() => {
            $(this).removeClass('functioning');
            document.querySelectorAll('.userCard').forEach((elm) => elm.classList.add('compact'));

            document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.classList.add('inActive'));
            document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.classList.remove('active'));
            document.querySelectorAll('.verifyOtpSection').forEach((elm) => elm.classList.remove('inActive'));
            document.querySelectorAll('.verifyOtpSection').forEach((elm) => elm.classList.add('active'));

            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('inActive'));
        }, 1500)

    });

    $("#changeNumber").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        document.querySelectorAll('.mobileInputSection').forEach((elm) => elm.classList.add('active'));
        document.querySelectorAll('.mobileInputSection').forEach((elm) => elm.classList.remove('inActive'));
        document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.classList.add('inActive'));
        document.querySelectorAll('.sendOtpSection').forEach((elm) => elm.classList.remove('active'));
        document.querySelectorAll('.userCard').forEach((elm) => elm.classList.add('inActive'));
        document.querySelectorAll('.userCard').forEach((elm) => elm.classList.remove('active'));
    });

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
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('inActive'));
            setTimeout(() => {
                $(this).removeClass('functioning');
                document.querySelectorAll('.verifyOtpSection').forEach((elm) => elm.classList.remove('active'));
                document.querySelectorAll('.verifyOtpSection').forEach((elm) => elm.classList.add('inActive'));
                document.querySelectorAll('.generateUnIdSection').forEach((elm) => elm.classList.remove('inActive'));
                document.querySelectorAll('.generateUnIdSection').forEach((elm) => elm.classList.add('active'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('active'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('inActive'));
            }, 1500)
        } else {
            $('#otp').siblings('.errorLabel').html('Enter a valid mobile number')
        }
    });

    // for enabling verifyOtpButton
    $("#generateUnIdButton").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        if ($('#otp').val().length == 6) {
            $('#otp').siblings('.errorLabel').html('')
            $(this).addClass('functioning');
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('inActive'));
            setTimeout(() => {
                $(this).removeClass('functioning');
                document.querySelectorAll('.generateUnIdSection').forEach((elm) => elm.classList.remove('active'));
                document.querySelectorAll('.generateUnIdSection').forEach((elm) => elm.classList.add('inActive'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.classList.remove('active'));
                document.querySelectorAll('.userCard').forEach((elm) => elm.classList.add('inActive'));
                document.querySelectorAll('.thankYouSection').forEach((elm) => elm.classList.add('active'));
                document.querySelectorAll('.thankYouSection').forEach((elm) => elm.classList.remove('inActive'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('active'));
                document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('inActive'));
            }, 1500)
        } else {
            $('#otp').siblings('.errorLabel').html('Enter a valid mobile number')
        }
    });


    // for enabling verifyOtpButton
    $('#unId').on('keyup', function () {
        if ($(this).val().length > 2) {
            $("#trackUnIdButton").removeAttr('disabled');
        } else $("#trackUnIdButton").attr('disabled', true);
    })

    // track unid
    $("#trackUnIdButton").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        $(this).addClass('functioning');
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('active'));
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('inActive'));
        setTimeout(() => {
            $(this).removeClass('functioning');
            document.querySelectorAll('.trackUnIdSection').forEach((elm) => elm.classList.remove('active'));
            document.querySelectorAll('.trackUnIdSection').forEach((elm) => elm.classList.add('inActive'));
            document.querySelectorAll('.trackingResultSection').forEach((elm) => elm.classList.remove('inActive'));
            document.querySelectorAll('.trackingResultSection').forEach((elm) => elm.classList.add('active'));

            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('inActive'));
        }, 1500)
    });


    // send Email
    const sendEmail = () => {
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('inActive'));
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('active'));
        setTimeout(() => {
            document.querySelectorAll('.paymentOtpSection').forEach((elm) => elm.classList.remove('active'));
            document.querySelectorAll('.paymentOtpSection').forEach((elm) => elm.classList.add('inActive'));

            document.querySelectorAll('.emailSentSuccess').forEach((elm) => elm.classList.remove('inActive'));
            document.querySelectorAll('.emailSentSuccess').forEach((elm) => elm.classList.add('active'));

            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('inActive'));
        }, 1200)

    }
    // send Email
    const sendPaymentOtp = () => {
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('inActive'));
        document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('active'));
        setTimeout(() => {
            document.querySelectorAll('.paymentReceiptSection').forEach((elm) => elm.classList.remove('active'));
            document.querySelectorAll('.paymentReceiptSection').forEach((elm) => elm.classList.add('inActive'));

            document.querySelectorAll('.paymentOtpSection').forEach((elm) => elm.classList.remove('inActive'));
            document.querySelectorAll('.paymentOtpSection').forEach((elm) => elm.classList.add('active'));

            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.remove('active'));
            document.querySelectorAll('.loadingBox').forEach((elm) => elm.classList.add('inActive'));
        }, 1200)
    }


</script>

</body>
</html>

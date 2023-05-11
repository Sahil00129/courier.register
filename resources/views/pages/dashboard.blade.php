@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <style>
        .widget-four .widget-content .w-summary-info .summary-count {
            display: block;
            font-weight: 600;
            color: #515365;
        }

        .widget-four .widget-content .w-summary-info h6 {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 0;
            color: #fbfbfc;
        }

        .widget-four .widget-content .summary-list:nth-child(1) .w-icon svg {
            color: #ffffff;
            fill: rgb(255 255 255 / 16%);
        }

        .widget-four .widget-content .w-icon {
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 38px;
            width: 50px;
            margin-right: 12px;
        }

        #chart-2 path {
            stroke: #ffffff;
        }

        .dashboard-widget {
            flex: 1;
            min-width: 300px;
            min-height: 80px;
            padding: 1rem;
            margin: 1.5rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 17px -4px #83838370;
            transition: all 250ms ease-in-out;
            cursor: pointer;
        }

        .dashboard-widget:hover {
            box-shadow: 0 10px 17px -4px #83838370;
            transform: translateY(-3px);
        }

        .dashboard-widget h6 {
            font-size: 1rem;
            font-weight: 600;
        }

        .dashboard-widget h6.handoverHeading {
            margin-bottom: 0;
        }

        .dashboard-widget h6.handoverHeading span {
            margin-left: 0;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: underline #0a58ca;
        }

        .dashboard-widget h6 span {
            margin-left: 8px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .dashboard-widget .detailsBlock {
            width: 100%;
            padding: 1rem;
            border-radius: 12px;
            flex: 1;
        }

        .dashboard-widget .detailsBlock .tb-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: -10px;
            border-bottom: 1px solid;
            font-weight: 700;
            color: #000;
            font-size: 13px;
        }

        .dashboard-widget .detailsBlock p {
            margin-bottom: 0;
            display: flex;
            width: 100%;
            justify-content: space-between;
            color: #000;
            font-weight: 600;
        }

        .dashboardActionButton {
            border-radius: 12px;
            width: 120px;
            font-size: 14px;
            padding: 0;
            height: 36px;
        }

    </style>



    <div class="layout-px-spacing">

        @if ($role == 'admin' || $role == 'reception')

            {{-- ---for reception--- --}}
            @if(false)
                <div class="row flex-wrap layout-top-spacing">
                    <div
                        class="d-flex flex-column col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing dashboard-widget">
                        <h6><strong>Average Time for TER Entry</strong></h6>
                        <div class="detailsBlock" style="background-color: #C4DFAA;">
                            <p>Today's Average<span>00:04:03 hrs</span></p>
                            <p>Month's Average<span>00:02:33 hrs</span></p>
                        </div>
                    </div>
                    <div
                        class="d-flex flex-column col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing dashboard-widget">
                        <h6><strong>Average Turn Around Time</strong></h6>
                        <div class="detailsBlock" style="background-color: #FFEBAD;">
                            <p>Today's Average<span>1 Day</span></p>
                            <p>Month's Average<span>1 Day</span></p>
                        </div>
                    </div>
                    <div
                        class="d-flex flex-column col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing dashboard-widget">
                        <h6><strong>Time Taken for TER Entry<span>(last 5 entries)</span></strong></h6>
                        <div class="detailsBlock" style="background-color: #ABD9FF;">
                            <div class="tb-head">UNID <span>Time taken</span></div>
                            <p>4465<span>00:04:35 hrs</span></p>
                            <p>4464<span>00:03:37 hrs</span></p>
                            <p>4463<span>00:03:00 hrs</span></p>
                            <p>4462<span>00:04:01 hrs</span></p>
                            <p>4461<span>00:02:54 hrs</span></p>
                        </div>
                    </div>

                    <div class="col-12 dashboard-widget d-flex align-items-center justify-content-between">
                        <h6 class="handoverHeading ml-lg-4"><span>10</span> Pending TER`s for Handover</h6>
                        <button class="btn btn-sm btn-primary mr-lg-4 dashboardActionButton">View</button>
                    </div>
                </div>
            @endif

        @elseif($role=="ter user" || $role=="admin user" || $role=="hr admin")
            {{-- ----for HR & TER user---- --}}

            @if(true)
            <div class="row layout-top-spacing">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget widget-four">
                        <div class="widget-content">

                            <div class="order-summary">

                                <div class="summary-list summary-income"
                                     style="background-color: #22beef; height: 81px;">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-shopping-bag">
                                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                                            </svg>
                                        </div>

                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6><span style="font-size: 23px;">{{$current_day_handover_ter_count}}(₹ {{Helper::rupee_format((int)$current_day_handover_ter_sum)}})</span><span
                                                        class="summary-count smry"> </span>Today Received TER</h6>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="summary-list summary-profit"
                                     style="background-color: #a2d200; height: 81px;">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-tag">
                                                <path
                                                    d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                                <line x1="7" y1="7" x2="7" y2="7"></line>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6><span style="font-size: 23px;">{{$current_month_handover_ter_count}}(₹ {{Helper::rupee_format((int)$current_month_handover_ter_sum)}})</span><span
                                                        class="summary-count smry"> </span>Current Month Received TER
                                                </h6>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget widget-four">
                        <div class="widget-content">

                            <div class="order-summary">

                                <div class="summary-list summary-income" style="background-color: #00a2ae;">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-shopping-bag">
                                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                                            </svg>
                                        </div>

                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6><span style="font-size: 23px;">{{$current_day_sent_to_finfect_ter_count}}(₹ {{Helper::rupee_format((int)$current_day_sent_to_finfect_ter_sum)}})</span><span
                                                        class="summary-count smry"> </span>Today Processed TER </h6>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="summary-list summary-profit" style="background-color: #ff4a43;">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-tag">
                                                <path
                                                    d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                                <line x1="7" y1="7" x2="7" y2="7"></line>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6><span style="font-size: 23px;">{{$current_month_sent_to_finfect_ter_count}}(₹ {{Helper::rupee_format((int)$current_month_sent_to_finfect_ter_sum)}})</span><span
                                                        class="summary-count smry"> </span>Current Month Processed TER
                                                </h6>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget widget-four">
                        <div class="widget-content">

                            <div class="order-summary">

                                <div class="summary-list summary-income" style="background-color: #8f44ad;">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-shopping-bag">
                                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                                            </svg>
                                        </div>

                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6><span style="font-size: 23px;">{{$current_day_paid_ter_count}}(₹ {{Helper::rupee_format((int)$current_day_paid_ter_sum)}})</span><span
                                                        class="summary-count smry"> </span>Today Paid TER</h6>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="summary-list summary-profit" style="background-color: #685aee;;">

                                    <div class="summery-info">

                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-tag">
                                                <path
                                                    d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                                <line x1="7" y1="7" x2="7" y2="7"></line>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">

                                            <div class="w-summary-info">
                                                <h6><span style="font-size: 23px;">{{$current_month_paid_ter_count}}(₹ {{Helper::rupee_format((int)$current_month_paid_ter_sum)}})</span><span
                                                        class="summary-count smry"> </span>Current Month Paid TER</h6>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                
                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-chart-one">
                        <div class="widget-heading">
                            <h5 class="">Current Month Work Performance: </h5>
                            <div class="task-action">

                            </div>
                        </div>

                        <div class="widget-content">
                            <div id="revenueMonthly"></div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-four">
                        <div class="widget-heading">
                            <h5 class="">User Wise TER Processed (Current Month)</h5>
                        </div>
                        <div class="widget-content">
                            <div class="vistorsBrowser">
                                <?php $i = 0;  $class = array('danger', 'success', 'info', 'warning'); ?>
                                @foreach($percentage as $key => $value)

                                    <div class="browser-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-chrome">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <circle cx="12" cy="12" r="4"></circle>
                                                <line x1="21.17" y1="8" x2="12" y2="8"></line>
                                                <line x1="3.95" y1="6.06" x2="8.54" y2="14"></line>
                                                <line x1="10.88" y1="21.94" x2="15.46" y2="14"></line>
                                            </svg>
                                        </div>
                                        <div class="w-browser-details">
                                            <div class="w-browser-info">
                                                <h6>{{$key}}</h6>
                                                <p class="browser-count">{{number_format($value[0] ,2)}}%</p>
                                            </div>
                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-{{$class[$i]}}"
                                                         role="progressbar"
                                                         style="width: {{number_format($value[0] ,2)}}%"
                                                         aria-valuenow="90"
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                    ?>
                                @endforeach

                            </div>

                        </div>

                    </div>
                </div>

         


                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-two">
                    <div class="widget-heading">
                        <h5 class="">Unprocessed TERs</h5>
                    </div>
                    <div class="widget-content">
                        <div id="chart-2" class=""></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-three">

                            <div class="widget-heading">
                                <h5 class="">TER Processed by Users (Current Month):</h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Users </div></th>
                                                <th><div class="th-content th-heading">Count of Today processed TER </div></th>
                                                <th><div class="th-content th-heading">Value of Today processed TER </div></th>
                                                <th><div class="th-content">Count of current month processed TER </div></th>
                                                <th><div class="th-content">Monthly Target achieved line </div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="td-content"><span class="pricing">Nitin</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">{{$user_today_processed_count['Nitin'][0]}}</span></div></td>
                                                <td><div class="td-content">{{$user_wise_processed_amount['Nitin'][0]}}</div></td>
                                                <td>{{$user_month_wise_processed_count['Nitin'][0]}}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                            <td><div class="td-content"><span class="pricing">Veena</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">{{$user_today_processed_count['Veena'][0]}}</span></div></td>
                                                <td><div class="td-content">{{$user_wise_processed_amount['Veena'][0]}}</div></td>
                                                <td>{{$user_month_wise_processed_count['Veena'][0]}}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                            <td><div class="td-content"><span class="pricing">Rameshwar</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">{{$user_today_processed_count['Rameshwar'][0]}}</span></div></td>
                                                <td><div class="td-content">{{$user_wise_processed_amount['Rameshwar'][0]}}</div></td>
                                                <td>{{$user_month_wise_processed_count['Rameshwar'][0]}}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                            <td><div class="td-content"><span class="pricing">Harpreet</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">{{$user_today_processed_count['Harpreet'][0]}}</span></div></td>
                                                <td><div class="td-content">{{$user_wise_processed_amount['Harpreet'][0]}}</div></td>
                                                <td>{{$user_month_wise_processed_count['Harpreet'][0]}}</td>
                                                <td></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              
            </div>
            @endif
       
        @endif
    </div>
@endsection

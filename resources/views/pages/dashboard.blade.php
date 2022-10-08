@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
<style>
    .widget-four .widget-content .w-summary-info .summary-count {
        display: block;
        / font-size: 16px; /
        margin-top: 4px;
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
</style>
<div class="layout-px-spacing">

    <div class="page-header">
        <!--  <div class="page-title">
        <h3>Analytics Dashboard</h3>
    </div>  -->

        <!-- <div class="toggle-switch">
        <label class="switch s-icons s-outline  s-outline-secondary">
            <input type="checkbox" checked="" class="theme-shifter">
            <span class="slider round">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
            </span>
        </label>
    </div>  -->
    </div>

    <div class="row layout-top-spacing">
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-four">
                            <div class="widget-content">

                                <div class="order-summary">

                                    <div class="summary-list summary-income" style="background-color: #22beef; height: 81px;">

                                        <div class="summery-info">

                                            <div class="w-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                            </div>

                                            <div class="w-summary-details">

                                                <div class="w-summary-info">
                                                    <h6><span  style="font-size: 23px;">{{$current_day_handover_ter_count}}(₹ {{$current_day_handover_ter_sum}})</span><span class="summary-count smry"> </span>Today Received TER</h6>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="summary-list summary-profit" style="background-color: #a2d200; height: 81px;">

                                        <div class="summery-info">

                                            <div class="w-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg>
                                            </div>
                                            <div class="w-summary-details">

                                                <div class="w-summary-info">
                                                    <h6><span  style="font-size: 23px;">{{$current_month_handover_ter_count}}(₹ {{Helper::rupee_format((int)$current_month_handover_ter_sum)}})</span><span class="summary-count smry"> </span>Current Month Received TER</h6>
                                                  
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                            </div>

                                            <div class="w-summary-details">

                                                <div class="w-summary-info">
                                                    <h6><span  style="font-size: 23px;">{{$current_day_sent_to_finfect_ter_count}}(₹ {{Helper::rupee_format((int)$current_day_sent_to_finfect_ter_sum)}})</span><span class="summary-count smry"> </span>Today Processed TER </h6>
                                                    
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="summary-list summary-profit" style="background-color: #ff4a43;">

                                        <div class="summery-info">

                                            <div class="w-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg>
                                            </div>
                                            <div class="w-summary-details">

                                                <div class="w-summary-info">
                                                    <h6><span  style="font-size: 23px;">{{$current_month_sent_to_finfect_ter_count}}(₹ {{Helper::rupee_format((int)$current_month_sent_to_finfect_ter_sum)}})</span><span class="summary-count smry"> </span>Current Month Processed TER </h6>
                                                   
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                            </div>

                                            <div class="w-summary-details">

                                                <div class="w-summary-info">
                                                    <h6><span  style="font-size: 23px;">{{$current_day_paid_ter_count}}(₹ {{Helper::rupee_format((int)$current_day_paid_ter_sum)}})</span><span class="summary-count smry"> </span>Today Paid TER</h6>
                                                    
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="summary-list summary-profit" style="background-color: #685aee;;">

                                        <div class="summery-info">

                                            <div class="w-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg>
                                            </div>
                                            <div class="w-summary-details">

                                                <div class="w-summary-info">
                                                    <h6><span  style="font-size: 23px;">{{$current_month_paid_ter_count}}(₹ {{Helper::rupee_format((int)$current_month_paid_ter_sum)}})</span><span class="summary-count smry"> </span>Current Month Paid TER</h6>
                                                    
                                                </div>

                                            </div>

                                        </div>

                                    </div>

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

                    <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-heading">
                                <h5 class="">User Wise TER Processed  	(Current Month)</h5>
                            </div>
                            <div class="widget-content">
                                <div class="vistorsBrowser">
                                    <?php $i=0;  $class = array('danger','success','info' ,'warning'); ?>
                                    @foreach($percentage as $key => $value)
                                   
                                    <div class="browser-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chrome"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="21.17" y1="8" x2="12" y2="8"></line><line x1="3.95" y1="6.06" x2="8.54" y2="14"></line><line x1="10.88" y1="21.94" x2="15.46" y2="14"></line></svg>
                                        </div>
                                        <div class="w-browser-details">
                                            <div class="w-browser-info">
                                                <h6>{{$key}}</h6>
                                                <p class="browser-count">{{number_format($value[0] ,2)}}%</p>
                                            </div>
                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-{{$class[$i]}}" role="progressbar" style="width: {{number_format($value[0] ,2)}}%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
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
                    </div> -->


    </div>
    @endsection
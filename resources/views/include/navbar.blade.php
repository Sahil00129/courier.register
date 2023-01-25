<style>
    li.menu > a > div {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    li.menu.active > a {
        background: none !important;
    }

    li.menu.active > a > div > svg, li.menu.active > a > div > span, li.menu:hover > a > div > span {
        color: #0ba360 !important;
    }

    li.menu > a > div > svg {
        height: 4px !important;
        width: 4px !important;
        background-color: black;
        border-radius: 50vh;
        transition: all 200ms ease-in-out;
    }

    li.menu.active > a > div > svg, li.menu > a:hover > div > svg {
        background-color: transparent;
        color: #0ba360 !important;
        border-radius: 0vh;
        height: 18px !important;
        width: 18px !important;
    }

    /* .dataTables_filter {
        display: none;
    }
    .dt--top-section {
        margin: 0 !important;
    } */
</style>

<a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
        <line x1="3" y1="12" x2="21" y2="12"></line>
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
</a>

<?php $authuser = Auth::user();
$currentURL = url()->current();
?>

<div class="nav-logo align-self-center">
    <a class="navbar-brand" href="{{url('home')}}">
        <img alt="logo" src="{{asset('assets/img/f15.png')}}"/>
    </a>
</div>

<ul id="topbar" class="navbar-item topbar-navigation flex-grow-1">

    <!--  BEGIN TOPBAR  -->
    <div class="topbar-nav header navbar" role="banner">
        <nav id="topbar">
            <ul class="navbar-nav theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="index.html">
                        <img src="assets/img/90x90.jpg" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="index.html" class="nav-link"> Frontiers </a>
                </li>
            </ul>

            <ul class="list-unstyled menu-categories" id="topAccordion">

                <li class="menu single-menu @if($currentURL == url('home')) active @endif">
                    <a href="{{url('home')}}">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>
                </li>

                @can('sender-table-show')
                    <li class="menu single-menu">
                        <a href="#employee_doc" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-layers">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>

                                <span>Senders</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <ul class="collapse submenu list-unstyled animated fadeInUp" id="employee_doc"
                            data-parent="#topAccordion">
                            <li><a href="{{url('sender-table')}}">Employees </a></li>
                            <!-- <li><a href="{{url('sender-table')}}">Vendors </a></li> -->
                        </ul>
                    </li>

                @endcan

                @can('document_list')
                <li class="menu single-menu @if(Str::contains($currentURL, 'admin_update_ter')) active @endif">
                        <a href="{{url('document_list')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>Handover Table</span>
                            </div>
                        </a>
                    </li>
                    @endcan

                    
                @can('update_status')
                <li class="menu single-menu @if(Str::contains($currentURL, 'admin_update_ter')) active @endif">
                        <a href="{{url('update_status')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>Update Status</span>
                            </div>
                        </a>
                    </li>
                    @endcan

                    

                @can('add-sender')
                    <li class="menu single-menu @if($currentURL == url('courier-company')) active @endif">
                        <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-layers">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>

                                <span>Dropdown Masters</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <ul class="collapse submenu list-unstyled animated fadeInUp" id="components"
                            data-parent="#topAccordion">
                            <li><a href="{{url('courier-company')}}"> Courier Companies </a></li>
                        </ul>
                    </li>

                 

                    {{--                    <li class="menu single-menu">--}}
                    {{--                        <a href="{{url('add-sender')}}">--}}
                    {{--                            <div class="">--}}
                    {{--                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
                    {{--                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
                    {{--                                     stroke-linejoin="round" class="feather feather-layout">--}}
                    {{--                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>--}}
                    {{--                                    <line x1="3" y1="9" x2="21" y2="9"></line>--}}
                    {{--                                    <line x1="9" y1="21" x2="9" y2="9"></line>--}}
                    {{--                                </svg>--}}

                    {{--                                <span>Add Sender</span>--}}
                    {{--                            </div>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                @endcan

                {{--                @can('create-courier')--}}
                {{--                    <li class="menu single-menu">--}}
                {{--                        <a href="{{url('create-courier')}}">--}}
                {{--                            <div class="">--}}
                {{--                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
                {{--                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
                {{--                                     stroke-linejoin="round" class="feather feather-cpu">--}}
                {{--                                    <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>--}}
                {{--                                    <rect x="9" y="9" width="6" height="6"></rect>--}}
                {{--                                    <line x1="9" y1="1" x2="9" y2="4"></line>--}}
                {{--                                    <line x1="15" y1="1" x2="15" y2="4"></line>--}}
                {{--                                    <line x1="9" y1="20" x2="9" y2="23"></line>--}}
                {{--                                    <line x1="15" y1="20" x2="15" y2="23"></line>--}}
                {{--                                    <line x1="20" y1="9" x2="23" y2="9"></line>--}}
                {{--                                    <line x1="20" y1="14" x2="23" y2="14"></line>--}}
                {{--                                    <line x1="1" y1="9" x2="4" y2="9"></line>--}}
                {{--                                    <line x1="1" y1="14" x2="4" y2="14"></line>--}}
                {{--                                </svg>--}}

                {{--                                <span>Add New Courier</span>--}}
                {{--                            </div>--}}
                {{--                        </a>--}}

                {{--                    </li>--}}
                {{--                @endcan--}}


                {{--                @can('courier-table')--}}
                {{--                    <li class="menu single-menu">--}}
                {{--                        <a href="{{url('courier-table')}}">--}}
                {{--                            <div class="">--}}
                {{--                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
                {{--                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
                {{--                                     stroke-linejoin="round" class="feather feather-file">--}}
                {{--                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>--}}
                {{--                                    <polyline points="13 2 13 9 20 9"></polyline>--}}
                {{--                                </svg>--}}

                {{--                                <span>Courier List</span>--}}
                {{--                            </div>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                @endcan--}}

                <!-- <li class="menu single-menu @if($currentURL == url('pos')) active @endif">
                        <a href="{{url('pos')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>PO List</span>
                            </div>
                        </a>
                    </li> -->

                    @can('tercouriers/create')
                       <!-- receive documents -->
                       <li class="menu single-menu">
                        <a href="#receives_doc" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-layers">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>

                                <span>Add Courier</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <ul class="collapse submenu list-unstyled animated fadeInUp" id="receives_doc"
                            data-parent="#topAccordion">
                            <!-- <li><a href="{{url('invoices/create')}}"> Add Invoice </a></li> -->
                            <li><a href=" {{url('tercouriers/create')}}"> Add TER </a></li>
                           
                        </ul>
                    </li>
                    @endcan

                @can('tercouriers')
                    <li class="menu single-menu @if($currentURL == url('tercouriers')) active @endif">
                        <a href="{{url('tercouriers')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>TER List</span>
                            </div>
                        </a>
                    </li>
                @endcan

              

                @can('hr_admin_edit_ter')
                <li class="menu single-menu @if($currentURL == url('show_emp_not_exist')) active @endif">
                        <a href="{{url('show_emp_not_exist')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>Unknown TER</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu single-menu @if(Str::contains($currentURL, 'admin_update_ter')) active @endif">
                        <a href="{{url('admin_update_ter/0')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>Edit TER</span>
                            </div>
                        </a>
                    </li>
                @endcan


                <!-- @can('tercouriers/create')
                    <li class="menu single-menu @if($currentURL == url('tercouriers/create')) active @endif">
                        <a href="{{url('tercouriers/create')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file-plus">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="12" y1="18" x2="12" y2="12"></line>
                                    <line x1="9" y1="15" x2="15" y2="15"></line>
                                </svg>
                                <span>Add TER</span>
                            </div>
                        </a>
                    </li>
                @endcan -->


                @can('edit-new-ter')
                    <li class="menu single-menu @if($currentURL == url('edit_ter_reception')) active @endif">
                        <a href="{{url('edit_ter_reception')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>

                                <span>Update UNID</span>
                            </div>
                        </a>
                    </li>
                @endcan

                @can('users')
                    <li class="menu single-menu @if($currentURL == url('tercouriers/create')) active @endif">
                        <a href="{{url('users')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file-plus">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="12" y1="18" x2="12" y2="12"></line>
                                    <line x1="9" y1="15" x2="15" y2="15"></line>
                                </svg>
                                <span>Users</span>
                            </div>
                        </a>
                    </li>
                @endcan

                @can('ter-bundles')
                    <li class="menu single-menu @if($currentURL == url('ter-bundles')) active @endif">
                        <a href="{{url('ter-bundles')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-box">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <span>TER Bundles</span>
                            </div>
                        </a>
                    </li>
                @endcan

                @can('ter_list_edit_user')
                    <li class="menu single-menu @if(Str::contains($currentURL, 'update_ter')) active @endif">
                    <!-- <li class="menu single-menu @if($currentURL == url('update_ter')) active @endif"> -->

                        <a href="{{url('update_ter/0')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-box">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <span>Verify TER</span>
                            </div>
                        </a>
                    </li>
                @endcan

                <!-- @can('pay-later-data')
                    <li class="menu single-menu @if($currentURL == url('show_pay_later_data')) active @endif">
                        <a href="{{url('show_pay_later_data')}}">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>

                                <span>Pay Later TER</span>
                            </div>
                        </a>

                    </li>
                @endcan -->


            <!-- @can('hr_admin_edit_ter')
                <li class="menu single-menu">
                    <a href="{{url('admin_update_ter')}}">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>Edit TER</span>
                        </div>
                    </a>
                </li>
                @endcan

                @can('hr_admin_edit_ter')
                <li class="menu single-menu">
                    <a href="#ter-components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-box">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>

                            <span>TER Options</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse submenu list-unstyled animated fadeInUp" id="ter-components"
                        data-parent="#topAccordion">
                        <li>
                            <a href="{{url('admin_update_ter')}}">Edit TER</a>
                            </li>
                            <li>
                                <a href="{{url('show_emp_not_exist')}}">Approval TER's</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                -->

            <!-- @can('full-and-final-data')
                <li class="menu single-menu">
                    <a href="{{url('show_full_and_final_data')}}">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>

                            <span>Full & Final TER</span>
                        </div>
                    </a>

                </li>
                @endcan -->

                @can('payment_sheet')
                    <li class="menu single-menu @if($currentURL == url('payment_sheet')) active @endif">
                        <a href="{{url('payment_sheet')}}">
                            <div class="">
                                <?xml version = "1.0" ?>
                                <svg width="64px" height="64px" viewBox="0 0 64 64" stroke="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g data-name="27 receipt" id="_27_receipt">
                                        <path
                                            d="M57.46,4.05H6.54A3.037,3.037,0,0,0,3.5,7.08V17.27A3.037,3.037,0,0,0,6.54,20.3h5.11V58.01a1,1,0,0,0,.68.95,1.023,1.023,0,0,0,1.12-.35,14.657,14.657,0,0,1,6.35-4.85,14.186,14.186,0,0,1,7.78-.74,14.873,14.873,0,0,1,3.99,1.33,17.809,17.809,0,0,1,2.39,1.53c.37.27.75.54,1.14.8a17.055,17.055,0,0,0,8.58,3.23c.53.03,1.06.05,1.61.05,1.08,0,2.22-.06,3.45-.17a12.37,12.37,0,0,0,2.12-.32c.99-.26,1.49-.75,1.49-1.46V20.3h5.11a3.037,3.037,0,0,0,3.04-3.03V7.08A3.037,3.037,0,0,0,57.46,4.05ZM11.65,14.23H9.57V10.12h2.08Zm38.7,43.3c-.02.01-.03.01-.05.02a10.143,10.143,0,0,1-1.73.25,34.3,34.3,0,0,1-4.78.12,15.237,15.237,0,0,1-7.58-2.9c-.37-.25-.73-.5-1.08-.76a19.293,19.293,0,0,0-2.67-1.7,16.483,16.483,0,0,0-4.52-1.51,16.258,16.258,0,0,0-8.88.85,16.52,16.52,0,0,0-5.41,3.48V10.12h36.7ZM58.5,17.27a1.037,1.037,0,0,1-1.04,1.03H52.35V16.23h3.08a1,1,0,0,0,1-1V9.12a1,1,0,0,0-1-1H8.57a1,1,0,0,0-1,1v6.11a1,1,0,0,0,1,1h3.08V18.3H6.54A1.037,1.037,0,0,1,5.5,17.27V7.08A1.037,1.037,0,0,1,6.54,6.05H57.46A1.037,1.037,0,0,1,58.5,7.08Zm-6.15-3.04V10.12h2.08v4.11Z"/>
                                        <path
                                            d="M24.85,14.21a1,1,0,0,1-1,1H17.74a1,1,0,0,1,0-2h6.11A1,1,0,0,1,24.85,14.21Z"/>
                                        <path
                                            d="M36.06,14.21a1,1,0,0,1-1,1H28.94a1,1,0,0,1,0-2h6.12A1,1,0,0,1,36.06,14.21Z"/>
                                        <path
                                            d="M47.26,14.21a1,1,0,0,1-1,1H40.15a1,1,0,0,1,0-2h6.11A1,1,0,0,1,47.26,14.21Z"/>
                                        <path
                                            d="M35.06,25.98A2.785,2.785,0,0,1,33,27.91v.54a1,1,0,1,1-2,0v-.7a7.81,7.81,0,0,1-1.29-.68c-.16-.1-.32-.2-.47-.28a1,1,0,0,1,.97-1.75c.18.1.37.21.56.33a3,3,0,0,0,1.53.64.89.89,0,0,0,.83-.55c.03-.12.03-.27-.21-.43l-2.45-1.64a2.494,2.494,0,0,1-1.1-1.67,2.3,2.3,0,0,1,.5-1.81A2.731,2.731,0,0,1,31,19.08v-.77a1,1,0,0,1,2,0v.67a2.81,2.81,0,0,1,.85.38l.98.65a1,1,0,0,1,.27,1.39.987.987,0,0,1-1.38.27l-.98-.65a1.06,1.06,0,0,0-1.31.13.321.321,0,0,0-.08.27.51.51,0,0,0,.23.31l2.46,1.64A2.345,2.345,0,0,1,35.06,25.98Z"/>
                                        <path
                                            d="M36.06,44.77a1,1,0,0,1-1,1H17.74a1,1,0,0,1,0-2H35.06A1,1,0,0,1,36.06,44.77Z"/>
                                        <path
                                            d="M47.26,32.55a1,1,0,0,1-1,1H40.15a1,1,0,1,1,0-2h6.11A1,1,0,0,1,47.26,32.55Z"/>
                                        <path
                                            d="M47.26,36.62a1,1,0,0,1-1,1H40.15a1,1,0,0,1,0-2h6.11A1,1,0,0,1,47.26,36.62Z"/>
                                        <path
                                            d="M47.26,40.69a1,1,0,0,1-1,1H40.15a1,1,0,0,1,0-2h6.11A1,1,0,0,1,47.26,40.69Z"/>
                                        <path
                                            d="M47.26,44.77a1,1,0,0,1-1,1H40.15a1,1,0,0,1,0-2h6.11A1,1,0,0,1,47.26,44.77Z"/>
                                        <path
                                            d="M36.06,40.69a1,1,0,0,1-1,1H17.74a1,1,0,1,1,0-2H35.06A1,1,0,0,1,36.06,40.69Z"/>
                                        <path
                                            d="M36.06,36.62a1,1,0,0,1-1,1H17.74a1,1,0,0,1,0-2H35.06A1,1,0,0,1,36.06,36.62Z"/>
                                        <path
                                            d="M36.06,32.55a1,1,0,0,1-1,1H17.74a1,1,0,1,1,0-2H35.06A1,1,0,0,1,36.06,32.55Z"/>
                                    </g>
                                </svg>
                                <span>Payment Sheet</span>
                            </div>
                        </a>

                    </li>
                @endcan

            <!--
                @can('full-and-final-data')
                <li class="menu single-menu">
                    <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-file">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                            <span>Final TER</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse submenu list-unstyled animated fadeInUp" id="components"
                        data-parent="#topAccordion">
                        <li>
                            <a href="{{url('show_full_and_final_data')}}">Full & Final TER</a>
                            </li>
                            <li>
                                <a href="{{url('show_settlement_deduction')}}">Setllement Deduction</a>
                            </li>
                            <li>
                                <a href="{{url('show_rejected_ter')}}">Rejected TER</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                -->

                <!--new added for payments holds-->
                @can('full-and-final-data')
                    <li class="menu single-menu @if($currentURL == url('show_full_and_final_data') || $currentURL == url('show_rejected_ter') || $currentURL == url('show_settlement_deduction')) active @endif">
                        <a href="#paymentsHold" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 511.999 511.999" stroke="currentColor"
                                     style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
<g>
    <g>
        <path d="M431.86,179.437l-77.982-36.963c11.912-12.286,16.971-29.64,13.235-46.65c-6.156-28.033-32.458-45.271-59.873-39.255
			c-1.052,0.231-2.018,0.64-2.885,1.175c-1.141-0.446-2.297-0.861-3.479-1.204c-14.645-4.255-29.895-0.132-41.834,11.315
			l-121.257,116.26c-13.106,12.568-20.91,24.083-26.094,38.503c-1.358,3.776-2.598,7.636-3.797,11.37
			c-3.96,12.328-7.728,24.016-15.353,32.565l-7.203-7.512c-4.265-4.448-10.02-6.968-16.206-7.1
			c-6.18-0.083-12.042,2.148-16.489,6.411L7.109,302.011c-9.203,8.823-9.512,23.492-0.687,32.694l160.977,167.895
			c4.264,4.448,10.02,6.968,16.206,7.099c0.168,0.003,0.334,0.005,0.501,0.005c6.002,0,11.662-2.268,15.989-6.416l26.419-25.331
			c3.714-3.561,3.838-9.457,0.277-13.171c-3.56-3.712-9.456-3.838-13.171-0.278L187.2,489.841c-1.154,1.107-2.496,1.233-3.204,1.232
			c-0.701-0.015-2.043-0.212-3.15-1.366l-38.543-40.2l52.022-49.878l38.543,40.2c3.561,3.714,9.458,3.838,13.171,0.278
			c3.714-3.561,3.838-9.458,0.277-13.171l-10.264-10.706l64.64-60.674c3.752-3.521,3.938-9.417,0.417-13.168
			c-3.521-3.752-9.416-3.939-13.168-0.417l-64.784,60.809L105.469,280.036c10.929-11.621,15.621-26.211,20.163-40.349
			c1.205-3.75,2.341-7.291,3.591-10.766c4.202-11.689,10.418-20.774,21.456-31.358l121.257-116.26
			c7.107-6.815,15.539-9.256,23.74-6.873c8.152,2.369,14.696,9.112,16.677,17.177c2.139,8.709-1.32,17.952-9.813,26.098L217,199.724
			c-3.714,3.561-3.838,9.457-0.278,13.171l6.534,6.815c5.259,5.486,8.068,12.691,7.908,20.289
			c-0.16,7.598-3.269,14.677-8.754,19.937l-27.26,26.136c-3.714,3.561-3.838,9.457-0.277,13.171c1.83,1.908,4.275,2.869,6.726,2.869
			c2.319,0,4.64-0.859,6.445-2.591l27.26-26.136c9.078-8.704,14.223-20.42,14.487-32.994c0.265-12.573-4.383-24.498-13.086-33.574
			l-0.088-0.091l69.248-66.395l118.016,55.939c1.288,0.61,2.646,0.901,3.983,0.901c3.488,0,6.831-1.967,8.424-5.328
			C438.491,187.196,436.509,181.64,431.86,179.437z M181.432,386.182L129.41,436.06L19.872,321.814
			c-1.688-1.76-1.626-4.67,0.132-6.354l45.534-43.658c1.154-1.107,2.504-1.22,3.204-1.232c0.701,0.015,2.043,0.212,3.15,1.366
			L181.432,386.182z M337.648,132.16c-0.661,0.54-1.22,1.156-1.692,1.818l-16.035-7.6c9.985-11.816,13.814-25.817,10.525-39.214
			c-1.074-4.373-2.9-8.52-5.313-12.302c11.519,2.747,20.952,12.066,23.784,24.958C351.575,111.925,347.257,124.318,337.648,132.16z"
        />
    </g>
</g>
                                    <g>
                                        <g>
                                            <path d="M414.876,17.441c-0.467-5.125-4.995-8.918-10.121-8.432L139.395,33.174c-5.471,0.498-10.428,3.106-13.957,7.343
			c-3.53,4.237-5.2,9.584-4.701,15.054l1.587,17.44c0.44,4.838,4.502,8.471,9.266,8.471c0.283,0,0.569-0.012,0.856-0.039
			c5.123-0.466,8.899-4.997,8.432-10.12l-1.587-17.441c-0.061-0.66,0.217-1.146,0.461-1.44c0.245-0.292,0.673-0.653,1.334-0.714
			l265.358-24.165C411.568,27.096,415.343,22.565,414.876,17.441z"/>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M511.913,152.815L499.915,21.039c-1.031-11.317-11.07-19.699-22.399-18.658l-22.465,2.046
			c-5.123,0.466-8.898,4.998-8.431,10.121c0.466,5.123,4.981,8.896,10.121,8.431l22.464-2.046c1.056-0.101,2.058,0.725,2.156,1.795
			l11.999,131.777c0.06,0.659-0.219,1.148-0.462,1.44s-0.672,0.655-1.333,0.714l-28.85,2.627c-5.123,0.466-8.898,4.997-8.431,10.121
			c0.44,4.836,4.502,8.471,9.266,8.469c0.283,0,0.569-0.012,0.854-0.039l28.851-2.627c5.47-0.498,10.428-3.106,13.957-7.343
			C510.742,163.632,512.412,158.285,511.913,152.815z"/>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M467.694,119.963c-14.711-0.694-26.813-12.3-28.152-26.998c-1.395-15.319,8.93-29.03,24.017-31.893
			c5.054-0.958,8.375-5.833,7.416-10.888c-0.958-5.055-5.84-8.378-10.888-7.416c-24.559,4.658-41.367,26.965-39.097,51.887
			c2.177,23.908,21.88,42.788,45.829,43.917c0.149,0.006,0.297,0.01,0.445,0.01c4.942,0,9.063-3.888,9.297-8.877
			C476.803,124.566,472.833,120.205,467.694,119.963z"/>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M215.721,76.022l-24.193-11.575c-10.254-4.907-22.586-0.555-27.491,9.699l-39.135,81.796
			c-2.221,4.64-0.258,10.203,4.383,12.424c1.297,0.621,2.665,0.914,4.013,0.914c3.475,0,6.81-1.954,8.41-5.297l39.135-81.796
			c0.465-0.97,1.676-1.397,2.644-0.934l24.191,11.575c4.643,2.222,10.205,0.257,12.424-4.382
			C222.324,83.806,220.361,78.243,215.721,76.022z"/>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M508.328,222.726c-1.836-5.2-5.574-9.37-10.53-11.741l-20.35-9.736c-4.641-2.222-10.203-0.258-12.424,4.382
			c-2.219,4.64-0.258,10.203,4.382,12.424l20.35,9.736c0.597,0.286,0.874,0.774,1.001,1.133c0.128,0.359,0.219,0.913-0.068,1.51
			l-57.108,119.361c-0.463,0.969-1.674,1.4-2.705,0.905l-157.204-73.873c-4.656-2.187-10.205-0.185-12.393,4.47
			c-2.187,4.656-0.186,10.205,4.469,12.393l157.148,73.845c2.862,1.37,5.885,2.017,8.864,2.017c7.693,0,15.09-4.324,18.628-11.715
			l57.108-119.363C509.867,233.52,510.161,227.927,508.328,222.726z"/>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M355.586,198.929c-4.558-12.921-13.875-23.294-26.234-29.209c-6.982-3.339-14.419-5.034-22.111-5.034
			c-19.649,0-37.825,11.449-46.302,29.166c-12.206,25.516-1.38,56.206,24.134,68.413c6.982,3.339,14.419,5.034,22.111,5.034
			c19.649,0,37.824-11.449,46.301-29.166C359.399,225.774,360.144,211.85,355.586,198.929z M336.678,230.091
			c-5.399,11.285-16.976,18.577-29.495,18.577c-4.886,0-9.618-1.079-14.069-3.209c-16.248-7.774-23.143-27.317-15.369-43.566
			c5.399-11.285,16.977-18.577,29.496-18.577c4.886,0,9.618,1.079,14.069,3.209c7.871,3.766,13.804,10.372,16.707,18.601
			C340.92,213.354,340.444,222.22,336.678,230.091z"/>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M462.163,236.769c-23.484-8.566-49.341,2.002-60.141,24.576c-10.362,21.657-3.093,47.96,16.907,61.183
			c1.581,1.047,3.366,1.546,5.13,1.546c3.023,0,5.987-1.469,7.779-4.178c2.838-4.292,1.659-10.07-2.632-12.909
			c-12.286-8.123-16.746-24.288-10.376-37.6c6.639-13.876,22.523-20.376,36.952-15.116c4.837,1.765,10.181-0.729,11.942-5.561
			C469.486,243.878,466.997,238.532,462.163,236.769z"/>
                                        </g>
                                    </g>
</svg>

                                <span>Payments Hold</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <ul class="collapse submenu list-unstyled animated fadeInUp" id="paymentsHold"
                            data-parent="#topAccordion" style="width: max-content">
                            <li><a href="{{url('show_full_and_final_data')}}"> Full & Final TER </a></li>
                            <li><a href="{{url('show_rejected_ter')}}"> Rejected TER </a></li>
                            @can('pay-later-data')
                            <li><a href="{{url('show_pay_later_data')}}"> Pay Later TER </a></li>
                            @endcan
                            <li><a href="{{url('show_settlement_deduction')}}"> Deduction Settlements TER </a></li>
                        </ul>
                    </li>
                @endcan

            <!--new added for reports-->
                @can('full-and-final-data')
                    <li class="menu single-menu">
                        <a href="#reports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-layers">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>
                                <span>Reports</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <ul class="collapse submenu list-unstyled animated fadeInUp" id="reports"
                            data-parent="#topAccordion">
                            <li><a href="{{url('/download_report/ter_timeline')}}"> TER Timeline </a></li>
                            <li><a href="{{url('/download_report/ter_cancel')}}"> Cancel TER </a></li>
                            <li><a href="{{url('/download_report/ter_updates')}}"> Updated TER </a></li>
                            <li><a href="{{url('/download_report/ter_user_wise')}}"> User wise Processed TER </a></li>
                            <li><a href="{{url('/download_report/emp_ledger')}}"> Employee TER Ledger </a></li>
                            <li><a href="{{url('/download_report/emp_list')}}"> Export Sender Table </a></li>
                            <li><a href="#"> Employee Advance Ledger </a></li>
                            <li><a href="#"> Employee Ledger Balance </a></li>
                        </ul>
                    </li>
                @endcan


            </ul>
        </nav>
    </div>
    <!--  END TOPBAR  -->
</ul>

<ul class="navbar-item flex-row ml-auto">
    <li>


    </li>
</ul>

<ul class="navbar-item flex-row nav-dropdowns">
    @can('admin_import_permission')
        <li class="nav-item dropdown notification-dropdown">
            <a href="{{url('import-Data')}}" class="nav-link dropdown-toggle user" aria-haspopup="true"
               aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-upload-cloud">
                    <polyline points="16 16 12 12 8 16"></polyline>
                    <line x1="12" y1="12" x2="12" y2="21"></line>
                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
                    <polyline points="16 16 12 12 8 16"></polyline>
                </svg>
            </a>
        </li>
    @endcan

    {{--    <li class="nav-item dropdown notification-dropdown">--}}
    {{--        <a href="{{url('reports')}}" class="nav-link dropdown-toggle user" aria-haspopup="true" aria-expanded="false">--}}
    {{--            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"--}}
    {{--                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"--}}
    {{--                 class="feather feather-box">--}}
    {{--                <path--}}
    {{--                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>--}}
    {{--                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>--}}
    {{--                <line x1="12" y1="22.08" x2="12" y2="12"></line>--}}
    {{--            </svg>--}}
    {{--        </a>--}}
    {{--    </li>--}}

    <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="user-profile-dropdown"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media" style="border-radius: 50vh; outline: 1px solid #00a859; padding: 4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-user" style="color: #00a859;">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
        </a>
        <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
            <div class="user-profile-section">
                <div class="media mx-auto">
                    <div class="media-body">
                        <h5>{{ucfirst($authuser->name ?? '-')}}</h5>
                    </div>
                </div>
            </div>
            <div class="dropdown-item">
                <a href="{{url('/logout')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-log-out">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Log Out</span>
                </a>
            </div>
        </div>
    </li>
</ul>

<script>
    $('#topbar #topAccordion li a').on('click', function () {
        if ($('#topbar #topAccordion li a').href.include('#') == false) {
            $('#topbar #topAccordion').find('li.active').removeClass('active');
            $(this).parent('li').addClass('active');
        }
    });
</script>

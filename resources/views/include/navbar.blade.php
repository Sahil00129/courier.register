<a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

<div class="nav-logo align-self-center">
    <a class="navbar-brand" href="{{url('home')}}}"><img alt="logo" src="{{asset('assets/img/f15.png')}}" style="margin-bottom:20px;"> </a>
</div>

<ul class="navbar-item topbar-navigation">
    
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
                    <a href="index.html" class="nav-link"> CORK </a>
                </li>
            </ul>

            <ul class="list-unstyled menu-categories" id="topAccordion">

                <li class="menu single-menu">
                    <a href="{{url('home')}}">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            
                            <span>Dashboard</span>
                        </div>
                       
                    </a>
                   
                </li>

                <li class="menu single-menu">
                    <a href="{{url('import-Data')}}">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                            
                            <span>Import Master</span>
                        </div>
                        </svg>
                    </a>
                    
                </li>
                
                <li class="menu single-menu">
                    <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            
                            <span>Tables</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="collapse submenu list-unstyled animated fadeInUp" id="components" data-parent="#topAccordion">
                    <li>
                                <a href="{{url('sender-table')}}"> Sender List </a>
                            </li>
                            <li>
                                <a href="{{url('courier-company')}}"> Courier Companies </a>
                            </li>
                            <li>
                                <a href="{{url('catagories')}}"> Catagories </a>
                            </li>
                            <li>
                                <a href="{{url('for-company')}}"> For </a>
                            </li>
                        </li>
                       
                    </ul>
                </li>

                <li class="menu single-menu">
                    <a href="{{url('add-sender')}}">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                            
                            <span>Add Sender</span>
                        </div>
                        </svg>
                    </a>
                    
                </li>

                <li class="menu single-menu">
                    <a href="{{url('create-courier')}}">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                            
                            <span>Add New Courier</span>
                        </div>
                        
                    </a>
                   
                </li>

                <li class="menu single-menu menu-extras">
                <a href="#more" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                               
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                    <ul class="collapse submenu list-unstyled animated fadeInUp" id="more" data-parent="#topAccordion">
                       
                        <li>
                            <a href="{{url('courier-table')}}"> Courier List</a>
                        </li>
                        <li>
                            <a href="widgets.html"> Widgets </a>
                        </li>
                        
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <!--  END TOPBAR  -->

</ul>

<ul class="navbar-item flex-row ml-auto">
    <li class="nav-item align-self-center search-animated">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <form class="form-inline search-full form-inline search" role="search">
            <div class="search-bar">
                <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
            </div>
        </form>
    </li>
</ul>

<ul class="navbar-item flex-row nav-dropdowns">
    <li class="nav-item dropdown language-dropdown more-dropdown">
        <div class="dropdown custom-dropdown-icon">
            <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/img/ca.png" class="flag-width" alt="flag">
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">
                <div class="search-dropdown">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <a class="dropdown-item" data-img-value="de" data-value="de" href="javascript:void(0);"><img src="assets/img/de.png" class="flag-width" alt="flag"> German</a>
                <a class="dropdown-item" data-img-value="jp" data-value="jp" href="javascript:void(0);"><img src="assets/img/jp.png" class="flag-width" alt="flag"> Japanese</a>
                <a class="dropdown-item" data-img-value="fr" data-value="fr" href="javascript:void(0);"><img src="assets/img/fr.png" class="flag-width" alt="flag"> French</a>
                <a class="dropdown-item" data-img-value="ca" data-value="en" href="javascript:void(0);"><img src="assets/img/ca.png" class="flag-width" alt="flag"> English</a>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown message-dropdown">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg><span class="badge badge-success"></span>
        </a>
        <div class="dropdown-menu p-0 position-absolute" aria-labelledby="messageDropdown">
            <div class="dropdown-menu-title">
                <h5>Messages</h5>
            </div>
            <div class="">
                <a class="dropdown-item unseen-msg">
                    <div class="">

                        <div class="media">
                            <div class="user-img">
                                <div class="avatar avatar-xl">
                                    <img src="assets/img/90x90.jpg" alt="admin-profile">
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="">
                                    <h5 class="usr-name">Kara Young</h5>
                                    <p class="msg-title">ACCOUNT UPDATE</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>
                <a class="dropdown-item">
                    <div class="">
                        <div class="media">
                            <div class="user-img">
                                <div class="avatar avatar-xl">
                                    <span class="avatar-title rounded-circle">DA</span>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="">
                                    <h5 class="usr-name">Daisy Anderson</h5>
                                    <p class="msg-title">ACCOUNT UPDATE</p>
                                </div>
                            </div>
                        </div>                                    
                    </div>
                </a>
                <a class="dropdown-item unseen-msg">
                    <div class="">

                        <div class="media">
                            <div class="user-img">
                                <div class="avatar avatar-xl">
                                    <!-- <span class="avatar-title rounded-circle">OG</span> -->
                                    <img src="assets/img/90x90.jpg" alt="admin-profile">
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="">
                                    <h5 class="usr-name">Oscar Garner</h5>
                                    <p class="msg-title">ACCOUNT UPDATE</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown notification-dropdown">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge badge-success"></span>
        </a>
        <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
            <div class="notification-scroll">

                <div class="dropdown-item">
                    <div class="media server-log">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="">Server Rebooted</h6>
                                <p class="">45 min ago</p>
                            </div>

                            <div class="icon-status">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown-item">
                    <div class="media ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="">Licence Expiring Soon</h6>
                                <p class="">8 hrs ago</p>
                            </div>

                            <div class="icon-status">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown-item">
                    <div class="media file-upload">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="">Kelly Portfolio.pdf</h6>
                                <p class="">670 kb</p>
                            </div>

                            <div class="icon-status">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="user-profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media">
                <img src="assets/img/90x90.jpg" class="img-fluid" alt="admin-profile">
            </div>
        </a>
        <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
            <div class="user-profile-section">
                <div class="media mx-auto">
                    <div class="media-body">
                        <h5>Shaun Park</h5>
                        <p>Project Leader</p>
                    </div>
                </div>
            </div>
            <div class="dropdown-item">
                <a href="user_profile.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>Profile</span>
                </a>
            </div>
            <div class="dropdown-item">
                <a href="apps_mailbox.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span>Inbox</span>
                </a>
            </div>
            <div class="dropdown-item">
                <a href="auth_lockscreen.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Lock Screen</span>
                </a>
            </div>
            <div class="dropdown-item">
                <a href="auth_login.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                </a>
            </div>
        </div>

    </li>
</ul>
<?php
/**
 * Created by PhpStorm.
 * User: Glinjos
 * Date: 08-02-2023
 * Time: 11:23
 */
?>










<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="icon" href="favicon.ico">-->
    <link rel="icon" href="{{ asset('assets/amica_logo.jpg') }}">
    <title>AmicaEduHub</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="../css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="../css/feather.css">
    <link rel="stylesheet" href="../css/select2.css">
    <link rel="stylesheet" href="../css/dropzone.css">
    <link rel="stylesheet" href="../css/uppy.min.css">
    <link rel="stylesheet" href="../css/jquery.steps.css">
    <link rel="stylesheet" href="../css/jquery.timepicker.css">
    <link rel="stylesheet" href="../css/quill.snow.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="../css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="../css/app-dark.css" id="darkTheme" disabled>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script>
        function deleteItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this item!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms the deletion, redirect to the delete URL
                    window.location.href = element.href;
                }
            });
        }
    </script>
    <style>
        .flex-wrapper{
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            justify-content: space-between;
        }

    </style>
    <style>
        .check-new {
            position: relative;
            width: 20px;
            height: 20px;
            border-radius: 2px;
            appearance: none;
            background-color: #bbb;
            transition: all .3s;
        }

        .check-new::before {
            content: '';
            position: absolute;
            border: solid #fff;
            display: block;
            width: .5em;
            height: .9em;
            border-width: 0 .2em .2em 0;
            z-index: 1;
            opacity: 0;
            right: calc(50% - .3em);
            top: calc(50% - .6em);
            transform: rotate(0deg);
            transition: all .3s;
            transform-origin: center center;
        }

        .check-new:checked {
            animation: a .4s ease-in forwards;
            background-color: rgb(120, 190, 120);
        }

        .check-new:checked::before {
            opacity: 1;
            transform: rotate(405deg);
        }

        @keyframes a {
            0% {
                opacity: 1;
                transform: scale(1) rotateY(0deg);
            }

            50% {
                opacity: 0;
                transform: scale(.8) rotateY(180deg);
            }

            100% {
                opacity: 1;
                transform: scale(1) rotateY(360deg);
            }
        }
    </style>
    
</head>
<body class="vertical  light  ">
<div class="wrapper">
    
    <header>
        <nav class="topnav navbar navbar-light">
            <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
                <i class="fe fe-menu navbar-toggler-icon"></i>
            </button>

            <ul class="nav">
                <li class="nav-item">
                    <!--<a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">-->
                    <!--    <i class="fe fe-sun fe-16"></i>-->
                    <!--</a>-->

                    
                   
                    {{-- <li class="dropdown-toggle nav-link" > --}}
                        <!--<a  href="{{ route('logout') }}"-->
                        <!--   onclick="event.preventDefault();-->
                        <!--                 document.getElementById('logout-form').submit();">-->
                        <!--    {{ __('Logout') }}-->
                        <!--</a>-->

                        <!--<form id="logout-form" action="{{ route('logout') }}" method="POST">-->
                        <!--    @csrf-->
                        <!--</form>-->
                    {{-- </li> --}}
                    
                     {{-- logut style --}}
                    <style>
                        .dropdown {
                            position: relative;
                            display: inline-block;
                        }
                    
                        .dropdown-content {
                            display: none;
                            position: absolute;
                            background-color: #f9f9f9;
                            min-width: 70px;
                            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                            padding: 8px;
                            z-index: 1;
                        }
                    
                        .dropdown:hover .dropdown-content {
                            display: block;
                        }
                    
                        .logout-button {
                            background-color: #e74c3c;
                            color: #fff;
                            border: none;
                            padding: 8px 10px;
                            font-size: 14px;
                            cursor: pointer;
                        }
                    
                        .logout-button:hover {
                            background-color: #c0392b;
                        }
                    </style>
                      {{-- end logout style                    --}}
                    {{-- <li class="dropdown-toggle nav-link" > --}}
                        <div class="dropdown">
                        <img class="dropdown-toggle" src="{{'/assets/userfakelogout_image.jpg'}}" width="30px" alt="Dropdown">
                        <div class="dropdown-content">
                        <a  href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                        </div>
                        </div>

                    {{-- </li> --}}
                    
                    
                   
                    
                    
                    
                    {{-- the logout end --}}
                   
                </li>

            </ul>
        </nav>
    </header>


    {{--Side bar--}}

    <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
        <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
            <i class="fe fe-x"><span class="sr-only"></span></i>
        </a>
        <nav class="vertnav navbar navbar-light">
            <!-- nav bar -->
            <div class="w-100 mb-4 d-flex">
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" >
                    <img src="../assets/images/logo.png" alt="amica_edu_hub_logo" class="avatar-img rounded-rectangle" width="128" height="72">
                </a>
            </div>
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="toggle nav-link">
                       
                        
             <a class="nav-link pl-3" href="/"> <i class="fe fe-home fe-16"></i>
                            <span class="ml-3 item-text">Dashboard</span></a>
                    </a>
                </li>
            </ul>


             <p class="text-muted nav-heading mt-4 mb-1">
                <span>Employees</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#employeetables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fa fa-user" style='font-size:18px'></i>
                        <span class="ml-3 item-text">Staff Management</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="employeetables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/add_employee"><span class="ml-1 item-text">Add Employee</span></a>
                        </li>
                    </ul>
                     <ul class="collapse list-unstyled pl-4 w-100" id="employeetables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/add_authorizer"><span class="ml-1 item-text">Add Authorizer</span></a>
                        </li>
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="employeetables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/add_admin_form"><span class="ml-1 item-text">Add Admin</span></a>
                        </li>
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="employeetables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/show_user-entered-quest"><span class="ml-1 item-text">User Entered Questions</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            
            
            
            
            
              <p class="text-muted nav-heading mt-4 mb-1">
                <span>Notifications</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#notifytables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fa fa-bell" style='font-size:18px'></i>
                        
                     <span class="ml-3 item-text">App Notification</span>
                        
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="notifytables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/sent-notification-back"><span class="ml-1 item-text">Sent Notification</span></a>
                        </li>
                        
                    </ul>
                </li>
            </ul>
            
            
            
            
            
            
             <p class="text-muted nav-heading mt-4 mb-1">
                <span>app plans</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#pvporttables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fa fa-calendar-plus-o" style='font-size:18px'></i>
                        <span class="ml-3 item-text">Plan Subscribers</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="pvporttables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/show_add_plan_form"><span class="ml-1 item-text">show app users plan</span></a>
                        </li>
                       
                    </ul>
                </li>
            </ul>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            


            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Question Bank</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#qbtables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp; <i class="fa fa-bank" style='font-size:18px'></i>
                        <span class="ml-3 item-text">Entry</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="qbtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/createModule"><span class="ml-1 item-text">Module</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/toSubmodule"><span class="ml-1 item-text">Sub Module</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/toQA"><span class="ml-1 item-text">Q & A</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/showQA"><span class="ml-1 item-text">View Q & A</span></a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link pl-3" href="/draftMainExam"><span class="ml-1 item-text">Draft Q & A</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/submodulewiseapproveqbmain"><span class="ml-1 item-text">Draft Filtered Q & A </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/submodulewiseqbmainexamad"><span class="ml-1 item-text">Show Filtered Questions</span></a>
                        </li>
                    </ul>
                </li>
            </ul>

            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Previous Questions</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#pqtables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fe fe-grid fe-16"></i>
                        <span class="ml-3 item-text">Previous Question </span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="pqtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/pqmain"><span class="ml-1 item-text">Exam Type</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/category"><span class="ml-1 item-text">Category</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/subcategory"><span class="ml-1 item-text">Sub Category</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/toPQA"><span class="ml-1 item-text">Q & A</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/showPQA"><span class="ml-1 item-text">View Q & A</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/draftPQA"><span class="ml-1 item-text">Draft Q & A</span></a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link pl-3" href="/draftfilterqapqsadmin"><span class="ml-1 item-text">Draft Filtered Q & A</span></a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link pl-3" href="/showpqfilter"><span class="ml-1 item-text">Show Filtered Questions</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/showtopperformes"><span class="ml-1 item-text">Top Performers</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/showdraftsuperadminimagePqa"><span class="ml-1 item-text">draft ImagePQA</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/showapprovedsuperadminimagePqa"><span class="ml-1 item-text">Show ImagePQA</span></a>
                        </li>
                    </ul>
                </li>
            </ul>



            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Video Classes</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#vctables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fa fa-play" style='font-size:18px'></i>
                        <span class="ml-3 item-text">Video Class</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="vctables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/vcmoduleform"><span class="ml-1 item-text">Add Module</span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="vctables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/vcchapterform"><span class="ml-1 item-text">Add Chapters</span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="vctables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/addvideos"><span class="ml-1 item-text">Add Videos</span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="vctables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/vcexamform"><span class="ml-1 item-text">Add Exam Q & A</span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="vctables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/vcshowexam"><span class="ml-1 item-text">Show Exam Q & A</span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="vctables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/draftVCQA"><span class="ml-1 item-text">Show Draft Exam Q & A</span></a>
                        </li>
                        
                    </ul>
                    
                     <ul class="collapse list-unstyled pl-4 w-100" id="vctables">
                        <li class="nav-item">
                               <a class="nav-link pl-3" href="/showfiltersuperadminsearchformvc"><span class="ml-1 item-text">Filtered Draft Questions</span></a>
                        </li>
                    </ul>
                    
                    
                    <ul class="collapse list-unstyled pl-4 w-100" id="vctables">
                     <li class="nav-item">
                            <a class="nav-link pl-3" href="/showfilterformvc"><span class="ml-1 item-text">Show Filtered Questions</span></a>
                     </li>
                    </ul>
                </li>
            </ul>
            
            
            
             <p class="text-muted nav-heading mt-4 mb-1">
                <span>Daily Model Exams</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#detables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fa fa-hourglass-start" style='font-size:18px'></i>
                        <span class="ml-3 item-text">Daily Exam</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="detables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/dailyexamform"><span class="ml-1 item-text">Add Daily Exam</span></a>
                        </li>
                        
                    </ul>
                    
                     <ul class="collapse list-unstyled pl-4 w-100" id="detables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/dailyexamwinnerform"><span class="ml-1 item-text">Daily Exam Winners</span></a>
                        </li>
                        
                    </ul>
                    
                </li>
            </ul>
            
            
            
             <p class="text-muted nav-heading mt-4 mb-1">
                <span>Question wise Model Exams</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#mexmtables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fas fa-award" style='font-size:18px'></i>
                        <span class="ml-3 item-text">Model Exam</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="mexmtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/modelexams-Form"><span class="ml-1 item-text">Add Model Exam</span></a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link pl-3" href="/addpercentagewisemodelexams-Form"><span class="ml-1 item-text">Add % wise Model Exam</span></a>
                        </li>
                        
                    </ul>
                    
                    
                    
                </li>
            </ul>
            
            
            
            
            
             <p class="text-muted nav-heading mt-4 mb-1">
                <span>Questions Error</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#reporttables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fa fa-bug" style='font-size:18px'></i>
                        <span class="ml-3 item-text">Reported Questions</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="reporttables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/show_report_form_sadmin"><span class="ml-1 item-text">View Reported Questions</span></a>
                        </li>
                       
                    </ul>
                </li>
            </ul>
            
            
            
            
            
            
            
            
            
            <p class="text-muted nav-heading mt-4 mb-1">
               <span>Chats And Suggestions</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#uchtables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<span class="fa fa-comment" style='font-size:18px'></span>
                        <span class="ml-3 item-text">Users Chat</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="uchtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/showuserdoubts"><span class="ml-1 item-text">Show Users Doubts</span></a>
                        </li>
                        
                         <li class="nav-item">
                            <a class="nav-link pl-3" href="/showquestionsformsupadmin"><span class="ml-1 item-text">Show User Questions</span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="uchtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/show_user_suggestions_i"><span class="ml-1 item-text">Show Users Suggestions</span></a>
                        </li>
                        
                    </ul>
                </li>
            </ul>
            
            
             <p class="text-muted nav-heading mt-4 mb-1">
                <span>Subscription</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#subtables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<span class="material-icons" style='font-size:18px'>subscriptions</span>
                        <span class="ml-3 item-text">Subscription</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="subtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/subscription"><span class="ml-1 item-text">Add Subscription</span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="subtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/showappplansubscribers"><span class="ml-1 item-text">Show Subscribers</span></a>
                        </li>
                        
                    </ul>
                     <ul class="collapse list-unstyled pl-4 w-100" id="subtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/showpaymenthist_sup"><span class="ml-1 item-text">Payment History</span></a>
                        </li>
                        
                    </ul>
                    
                </li>
            </ul>
            
            
            
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>User Analytics</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#usertables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fa fa-users" style='font-size:18px'></i>
                        
                     <span class="ml-3 item-text">Users Details</span>
                        
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="usertables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/usersShow"><span class="ml-1 item-text">View Users</span></a>
                        </li>
                        
                    </ul>
                </li>
            </ul>
            
            
            
            
             <p class="text-muted nav-heading mt-4 mb-1">
                <span>Crash Courses</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#cctables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="material-icons" style='font-size:18px'>assessment</i>
                        <span class="ml-3 item-text">Crash Course</span>
                    </a>
                    
                    
                      <ul class="collapse list-unstyled pl-4 w-100" id="cctables"> 
                        <li class="nav-item">
                           <a class="nav-link pl-3" href="/addcoursesupadmin"><span class="ml-1 item-text">Add Course</span></a>
                       </li>
                      
                   </ul>
                   <ul class="collapse list-unstyled pl-4 w-100" id="cctables"> 
                       <li class="nav-item">
                          <a class="nav-link pl-3" href="/addcoursesupadminbatch"><span class="ml-1 item-text">Add Batches</span></a>
                      </li>
                     
                  </ul>
                  <ul class="collapse list-unstyled pl-4 w-100" id="cctables"> 
                   <li class="nav-item">
                      <a class="nav-link pl-3" href="/addstunentsupadminstobatch"><span class="ml-1 item-text">Add Students To Batches</span></a>
                  </li>
                 
              </ul>
               <ul class="collapse list-unstyled pl-4 w-100" id="cctables"> 
                   <li class="nav-item">
                      <a class="nav-link pl-3" href="/addbatchdaysupadminsactivities"><span class="ml-1 item-text">Add Batch Activities</span></a>
                  </li>
                 
              </ul>

                    
                    
                    
                    
                    <ul class="collapse list-unstyled pl-4 w-100" id="cctables"> 
                         <li class="nav-item">
                            <a class="nav-link pl-3" href="/showcrashcoursehistory"><span class="ml-1 item-text">Show User Histories</span></a>
                        </li>
                       
                    </ul>
                    
                     <ul class="collapse list-unstyled pl-4 w-100" id="cctables"> 
                        <li class="nav-item">
                           <a class="nav-link pl-3" href="/showcrashcoursesubscribers"><span class="ml-1 item-text">Show Subscribers</span></a>
                       </li>
                      
                   </ul>
                   
                   
                    <ul class="collapse list-unstyled pl-4 w-100" id="cctables"> 
                     <li class="nav-item">
                       <a class="nav-link pl-3" href="/show_crash_payment_hist"><span class="ml-1 item-text">Payment History</span></a>
                     </li>
                  
                    </ul>
                   
                   
                   
                   
                   
                </li>
            </ul>
            
            
            
             
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>User Referral Data</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#Reftables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class='fas fa-link' style='font-size:18px'></i>
                        <span class="ml-3 item-text">Referred Users</span>
                    </a>  
                    <ul class="collapse list-unstyled pl-4 w-100" id="Reftables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/reffered_amount_form"><span class="ml-1 item-text">Show Reffer Amount</span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="Reftables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/user_payment_request"><span class="ml-1 item-text">User Payment Request</span></a>
                        </li>
                        
                    </ul>

                    <ul class="collapse list-unstyled pl-4 w-100" id="Reftables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/add_user_payment"><span class="ml-1 item-text">Add User Payment </span></a>
                        </li>
                        
                    </ul>
                    <ul class="collapse list-unstyled pl-4 w-100" id="Reftables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/show_total_user_payments"><span class="ml-1 item-text">User Payment Ledger </span></a>
                        </li>
                        
                    </ul>

                </li>
            </ul>
            
            
            
            
              <p class="text-muted nav-heading mt-4 mb-1">
                <span>Live Game Histories</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#lgtables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class='fas fa-dice' style='font-size:18px'></i>
                        <span class="ml-3 item-text">Live Game</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="lgtables"> 
                         <li class="nav-item">
                            <a class="nav-link pl-3" href="/showuserlivegamehist"><span class="ml-1 item-text">Show Live Game Histories</span></a>
                        </li>
                       
                    </ul>
                   
                </li>
            </ul>
            
            
            
            
            
            
            
            
             <p class="text-muted nav-heading mt-4 mb-1">
                <span>Advertisements</span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#adtables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        &nbsp;&nbsp;<i class="fa fa-audio-description" style='font-size:18px'></i>
                        <span class="ml-3 item-text">Advertisement</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="adtables">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="/advertisements"><span class="ml-1 item-text">Add Advertisement</span></a>
                        </li>
                        
                    </ul>
                </li>
            </ul>

            



        </nav>
    </aside>


    {{--write content here --}}
    <div class="flex-wrapper">
        <div class="container-fluid">

            @yield('adminpanel')



























        </div>
        </div>
        <!-- /.content -->

        <!-- Footer -->
        <div class="footer">
            <footer class="site-footer" >
                        <div class="col-sm-12 text-center">
                            Developed by <a href="https://glinjosinnovations.com">Glinjos Innovations Software Solutions LLP</a>
                        </div>

            </footer>
        </div>

    <!-- /.site-footer -->



</div>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!--<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>-->
<!--<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>-->

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!--<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">




<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src='js/daterangepicker.js'></script>
<script src='js/jquery.stickOnScroll.js'></script>
<script src="js/tinycolor-min.js"></script>
<!--<script src="js/config.js"></script>-->
<script src="js/d3.min.js"></script>
<script src="js/topojson.min.js"></script>
<script src="js/datamaps.all.min.js"></script>
<script src="js/datamaps-zoomto.js"></script>
<script src="js/datamaps.custom.js"></script>
<script src="js/Chart.min.js"></script>
<script>
    /* defind global options */
    Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
    Chart.defaults.global.defaultFontColor = colors.mutedColor;
</script>
<script src="js/gauge.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/apexcharts.min.js"></script>
<script src="js/apexcharts.custom.js"></script>
<script src='js/jquery.mask.min.js'></script>
<script src='js/select2.min.js'></script>
<script src='js/jquery.steps.min.js'></script>
<script src='js/jquery.validate.min.js'></script>
<script src='js/jquery.timepicker.js'></script>
<script src='js/dropzone.min.js'></script>
<script src='js/uppy.min.js'></script>
<script>
    $('.select2').select2(
        {
            theme: 'bootstrap4',
        });
    $('.select2-multi').select2(
        {
            multiple: true,
            theme: 'bootstrap4',
        });
    $('.drgpicker').daterangepicker(
        {
            singleDatePicker: true,
            timePicker: false,
            showDropdowns: true,
            locale:
                {
                    format: 'MM/DD/YYYY'
                }
        });
    $('.time-input').timepicker(
        {
            'scrollDefault': 'now',
            'zindex': '9999' /* fix modal open */
        });
    /** date range picker */
    if ($('.datetimes').length)
    {
        $('.datetimes').daterangepicker(
            {
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale:
                    {
                        format: 'M/DD hh:mm A'
                    }
            });
    }
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end)
    {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange').daterangepicker(
        {
            startDate: start,
            endDate: end,
            ranges:
                {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
        }, cb);
    cb(start, end);
    $('.input-placeholder').mask("00/00/0000",
        {
            placeholder: "__/__/____"
        });
    $('.input-zip').mask('00000-000',
        {
            placeholder: "____-___"
        });
    $('.input-money').mask("#.##0,00",
        {
            reverse: true
        });
    $('.input-phoneus').mask('(000) 000-0000');
    $('.input-mixed').mask('AAA 000-S0S');
    $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ',
        {
            translation:
                {
                    'Z':
                        {
                            pattern: /[0-9]/,
                            optional: true
                        }
                },
            placeholder: "___.___.___.___"
        });
    // editor
    var editor = document.getElementById('editor');
    if (editor)
    {
        var toolbarOptions = [
            [
                {
                    'font': []
                }],
            [
                {
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [
                {
                    'header': 1
                },
                {
                    'header': 2
                }],
            [
                {
                    'list': 'ordered'
                },
                {
                    'list': 'bullet'
                }],
            [
                {
                    'script': 'sub'
                },
                {
                    'script': 'super'
                }],
            [
                {
                    'indent': '-1'
                },
                {
                    'indent': '+1'
                }], // outdent/indent
            [
                {
                    'direction': 'rtl'
                }], // text direction
            [
                {
                    'color': []
                },
                {
                    'background': []
                }], // dropdown with defaults from theme
            [
                {
                    'align': []
                }],
            ['clean'] // remove formatting button
        ];
        var quill = new Quill(editor,
            {
                modules:
                    {
                        toolbar: toolbarOptions
                    },
                theme: 'snow'
            });
    }
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function()
    {
        'use strict';
        window.addEventListener('load', function()
        {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form)
            {
                form.addEventListener('submit', function(event)
                {
                    if (form.checkValidity() === false)
                    {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script>
    var uptarg = document.getElementById('drag-drop-area');
    if (uptarg)
    {
        var uppy = Uppy.Core().use(Uppy.Dashboard,
            {
                inline: true,
                target: uptarg,
                proudlyDisplayPoweredByUppy: false,
                theme: 'dark',
                width: 770,
                height: 210,
                plugins: ['Webcam']
            }).use(Uppy.Tus,
            {
                endpoint: 'https://master.tus.io/files/'
            });
        uppy.on('complete', (result) =>
        {
            console.log('Upload complete! We’ve uploaded these files:', result.successful)
        });
    }
</script>
<script src="js/apps.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag()
    {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
</script>

</body>
</html>
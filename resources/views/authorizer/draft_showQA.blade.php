@extends('authorizer.authorMaster')


@section('adminpanel')



    <div class="wrapper">
        <main role="main" class="main-content">
            <!-- table -->
            @if (session('success'))
                <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
            @endif
            @if (session('error'))
                <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
            @endif

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="mb-2 page-title"> Draft Questions & Answers</h2>
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <table class="table datatables" id="dataTable-1" >
                                            <thead>
                                            <tr style="background-color: lightgray;">
                                                <th style="color: black;"><b>SL NO</b></th>
                                                <th style="color: black;"><b>QUESTION CODE</b></th>
                                                <th style="color: black;"><b>MODULE</b></th>
                                                <th style="color: black;"><b>SUB MODULE</b></th>
                                                <th style="color: black;"><b>QUESTION</b></th>
                                                <th style="color: black;"><b></b>&nbsp;&nbsp;&nbsp;</th>
                                                <th style="color: black;"><b>ACTION</b></th>


                                            </tr>
                                            </thead>
                                            <tbody>


                                            <!-- TO SHOW LOADER FOR LOADING DATA MAKES MORE TIME  -->
                                            <div id="show_loader" style="display: none">
                                                <div class="row">
                                                    <div class="loader">
                                                        <div>
                                                            <ul>
                                                                <li>
                                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                                    </svg>
                                                                </li>
                                                                <li>
                                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                                    </svg>
                                                                </li>
                                                                <li>
                                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                                    </svg>
                                                                </li>
                                                                <li>
                                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                                    </svg>
                                                                </li>
                                                                <li>
                                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                                    </svg>
                                                                </li>
                                                                <li>
                                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                                    </svg>
                                                                </li>
                                                            </ul>
                                                        </div><span>SEARCHING</span>

                                                    </div>
                                                    <style>
                                                        .loader {
                                                            --background: linear-gradient(135deg, #23C4F8, #275EFE);
                                                            --shadow: rgba(39, 94, 254, 0.28);
                                                            --text: #6C7486;
                                                            --page: rgba(255, 255, 255, 0.36);
                                                            --page-fold: rgba(255, 255, 255, 0.52);
                                                            --duration: 3s;
                                                            width: 200px;
                                                            height: 140px;
                                                            position: relative;
                                                        }

                                                        .loader:before, .loader:after {
                                                            --r: -6deg;
                                                            content: "";
                                                            position: absolute;
                                                            bottom: 8px;
                                                            width: 120px;
                                                            top: 80%;
                                                            box-shadow: 0 16px 12px var(--shadow);
                                                            transform: rotate(var(--r));
                                                        }

                                                        .loader:before {
                                                            left: 4px;
                                                        }

                                                        .loader:after {
                                                            --r: 6deg;
                                                            right: 4px;
                                                        }

                                                        .loader div {
                                                            width: 100%;
                                                            height: 100%;
                                                            border-radius: 13px;
                                                            position: relative;
                                                            z-index: 1;
                                                            perspective: 600px;
                                                            box-shadow: 0 4px 6px var(--shadow);
                                                            background-image: var(--background);
                                                        }

                                                        .loader div ul {
                                                            margin: 0;
                                                            padding: 0;
                                                            list-style: none;
                                                            position: relative;
                                                        }

                                                        .loader div ul li {
                                                            --r: 180deg;
                                                            --o: 0;
                                                            --c: var(--page);
                                                            position: absolute;
                                                            top: 10px;
                                                            left: 10px;
                                                            transform-origin: 100% 50%;
                                                            color: var(--c);
                                                            opacity: var(--o);
                                                            transform: rotateY(var(--r));
                                                            -webkit-animation: var(--duration) ease infinite;
                                                            animation: var(--duration) ease infinite;
                                                        }

                                                        .loader div ul li:nth-child(2) {
                                                            --c: var(--page-fold);
                                                            -webkit-animation-name: page-2;
                                                            animation-name: page-2;
                                                        }

                                                        .loader div ul li:nth-child(3) {
                                                            --c: var(--page-fold);
                                                            -webkit-animation-name: page-3;
                                                            animation-name: page-3;
                                                        }

                                                        .loader div ul li:nth-child(4) {
                                                            --c: var(--page-fold);
                                                            -webkit-animation-name: page-4;
                                                            animation-name: page-4;
                                                        }

                                                        .loader div ul li:nth-child(5) {
                                                            --c: var(--page-fold);
                                                            -webkit-animation-name: page-5;
                                                            animation-name: page-5;
                                                        }

                                                        .loader div ul li svg {
                                                            width: 90px;
                                                            height: 120px;
                                                            display: block;
                                                        }

                                                        .loader div ul li:first-child {
                                                            --r: 0deg;
                                                            --o: 1;
                                                        }

                                                        .loader div ul li:last-child {
                                                            --o: 1;
                                                        }

                                                        .loader span {
                                                            display: block;
                                                            left: 0;
                                                            right: 0;
                                                            top: 100%;
                                                            margin-top: 20px;
                                                            text-align: center;
                                                            color: var(--text);
                                                        }

                                                        @keyframes page-2 {
                                                            0% {
                                                                transform: rotateY(180deg);
                                                                opacity: 0;
                                                            }

                                                            20% {
                                                                opacity: 1;
                                                            }

                                                            35%, 100% {
                                                                opacity: 0;
                                                            }

                                                            50%, 100% {
                                                                transform: rotateY(0deg);
                                                            }
                                                        }

                                                        @keyframes page-3 {
                                                            15% {
                                                                transform: rotateY(180deg);
                                                                opacity: 0;
                                                            }

                                                            35% {
                                                                opacity: 1;
                                                            }

                                                            50%, 100% {
                                                                opacity: 0;
                                                            }

                                                            65%, 100% {
                                                                transform: rotateY(0deg);
                                                            }
                                                        }

                                                        @keyframes page-4 {
                                                            30% {
                                                                transform: rotateY(180deg);
                                                                opacity: 0;
                                                            }

                                                            50% {
                                                                opacity: 1;
                                                            }

                                                            65%, 100% {
                                                                opacity: 0;
                                                            }

                                                            80%, 100% {
                                                                transform: rotateY(0deg);
                                                            }
                                                        }

                                                        @keyframes page-5 {
                                                            45% {
                                                                transform: rotateY(180deg);
                                                                opacity: 0;
                                                            }

                                                            65% {
                                                                opacity: 1;
                                                            }

                                                            80%, 100% {
                                                                opacity: 0;
                                                            }

                                                            95%, 100% {
                                                                transform: rotateY(0deg);
                                                            }
                                                        }

                                                    </style>
                                                </div>
                                            </div>

                                            <!--LOADER END HERE AFTER LOADING DATA -->



                                            @if(isset($question))

                                                @php $i=1; @endphp

                                                @foreach ($question as $item)

                                                    <tr style="color: black;">
                                                        <td width="65"><b>{{$i++}}</b></td>
                                                        <td id="qcodedetailed" width="100">
                                                            @php
                                                                $submodulecode=$item->subModuleCode;
                                                                $submodulecode = preg_replace('/[0-9]+/', '', $submodulecode);

                                                                echo $item->moduleCode.$submodulecode.$item->questionCode ;
                                                            @endphp
                                                        </td>
                                                        <td width="80">{{$item->moduleName}}</td>
                                                        <td width="80"><span id="sm{{$i}}" >{{ $item->subModuleName}}</span></td>
                                                        <td width="150" >
                                                            <span  id="que{{$i}}"style="word-wrap: break-word;" onmouseover="return showanswer(<?php echo $item->questionId; ?>)"
                                                                   onmouseout="return hideanswer(<?php echo $item->questionId; ?>)">{{$item->question}}</span>
                                                            <p name="answerover" id="answeronmousehover{{$item->questionId}}" style="width:400px;word-wrap: break-word; display: none;color:green;font-weight: bold;" >"answer is" </p>
                                                        </td>
                                                        <td width="20">
                                                            @if( $item->isAvail == 2)
                                                            <abbr style="text-decoration: none;"  title="Approve Question"><a href="{{url('ApproveauthormainexmMainexam/'.$item->questionId)}}" onclick="activeItem(event, this)" style="text-decoration: none;"><span class="fa fa-check-square-o" style="font-size:30px;color:green"></span></a></abbr>
                                                                    @endif
                                                                  @if( $item->isAvail == 0)
                                                          <abbr style="text-decoration: none;" title="Refuse Question"> <a href="{{url('RefuseauthormainexmMainExam/'.$item->questionId)}}"  onclick="inactiveItem(event, this)" style="text-decoration: none;"><span class="fa fa-check-square-o" style="font-size:30px;color:red"></span></a></abbr>
                                                                    @endif
                                                            </td>
                                                        <td width="75">

                                                            <abbr style="text-decoration: none;" title="ViewMore"><span onclick="return showq(<?php echo $item->questionId;?>)" style="color: green;" class="fe fe-24 fe-more-horizontal" ></span></abbr>

                                                            <abbr style="text-decoration: none;" title="Edit Question"><a href="{{url('updateauthormaindraftexmQuestion'.$item->questionId)}}" style="text-decoration: none;" onclick="editItem(event, this)"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                    
                                                            <abbr style="text-decoration: none;"  title="Delete Question"><a href="{{url('questionauthordraftmainDelete/'.$item->questionId)}}" style="text-decoration: none;" onclick="deActiveItem(event, this)"><span style="color: red;font-size: 26px;"class="fa fa-trash-o"></span></a></abbr>

                                                        </td>
                                                        <!-- data-target="#show_question"  data-toggle="modal" -->
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <script>
                                                    function editItem(event, element) {
                                                        event.preventDefault(); // prevent the default link behavior

                                                        // Show the SweetAlert confirmation dialog
                                                        Swal.fire({
                                                            title: 'Are you sure to edit this question?',
                                                            text: '',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Confirm',
                                                            cancelButtonText: 'Cancel',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                window.location.href = element.href;
                                                            }
                                                        });
                                                    }
                                             </script>
                                             <script>
                                                    function deActiveItem(event, element) {
                                                        event.preventDefault(); // prevent the default link behavior

                                                        // Show the SweetAlert confirmation dialog
                                                        Swal.fire({
                                                            title: 'Are you sure to delete this question?',
                                                            text: '',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Confirm',
                                                            cancelButtonText: 'Cancel',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                window.location.href = element.href;
                                                            }
                                                        });
                                                    }
                                             </script>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- simple table -->
                        </div> <!-- end section -->
                    </div> <!-- .col-12 -->
                </div> <!-- .row -->
            </div>





{{--Show question modal--}}

            <div class="modal fade" id="show_question" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="defaultModalLabel">View</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <table>
                                <tr> <input type="text" name="cqId" id="cqIdshowq" hidden></tr>
                                <tr>
                                    <br>
                                    <b style="color: black;">Module :</b>
                                    <p id="modulenameinview"  name="modulenameinview" style="font-weight: bold;color:blue;" disabled></p>
                                    <br>
                                </tr>
                                <tr>

                                    <b style="color: black;">Sub Module :</b>
                                    <p id="submodulenameinview"  name="submodulenameinview" style="font-weight: bold;color:blue;" disabled></p>
                                    <br>
                                </tr>
                                <tr>

                                    <b style="color: black;">QUESTION :</b>
                                    <p id="question1showq"  name="question" style="font-weight: bold;color:blue;" disabled></p>
                                    <br>
                                </tr>
                                <tr>
                                    <label for="option1"><b style="color: black;">Option A :</b> </label>

                                    <p type="text"  name="option1" id="option1showq" disabled></p>
                                    <br>
                                </tr>
                                <tr>
                                    <label for="option2"><b style="color: black;">Option B :</b> </label>

                                    <p type="text"  name="option2" id="option2showq" disabled></p>
                                    <br>
                                </tr>
                                <tr>
                                    <label for="option3"><b style="color: black;">Option C :</b> </label>

                                    <p type="text"  name="option3" id="option3showq" disabled></p>
                                    <br>
                                </tr>
                                <tr>
                                    <label for="option4"><b style="color: black;">Option D :</b> </label>
                                    <p type="text"  name="option4" id="option4showq" disabled></p>
                                    <br>
                                </tr>
                                <tr>
                                <div class="modal-footer">
                                   

                                </div>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>







   {{--Edit question modal--}}



            <div class="modal fade" id="edt_question" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">EDIT QUESTIONS</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/questionUpdate" method="post" >
                                @csrf
                                <br>
                                <input type="text" style="width:450px" name="cqId" id="cqId" hidden>
                                <input type="text" style="width:450px" name="qCode" id="qCode" hidden>

                                <div>
                                    <div id="show_modulename">
                                        <input type="text" style="width:450px" name="mId" id="mId" class="form-control" hidden><br>
                                        <label for="mname"><b style="color: black;">Module Name :</b> </label><br>
                                        <input type="text" style="width: 450px;" name="mName" id="mName" class="form-control" disabled><br>
                                        <h1 class="fe fe-24 fe-edit" style="color: #007bff" onclick="return showmoduleedit()"></h1>
                                    </div>
                                    <script>
                                        function showmoduleedit(){
                                            document.getElementById("show_modulename").style.display="none";
                                            var moduleid=document.getElementById("mId").value;
                                            $.ajax({
                                                url: "{{url('/Moduleshow')}}",
                                                type: "GET",
                                                data: {
                                                    mid: moduleid,
                                                    _token: '{{csrf_token()}}'
                                                },
                                                success: function(result)
                                                {
                                                    if (result) {

                                                        document.getElementById("edit_div_modulename").style.display="block";
                                                        document.getElementById("show_submodule").style.display="none";
                                                        $('#showmoduleedit').html('<option value="">--Select module--</option>');
                                                        $.each(result, function(key, value) {
                                                                $('#showmoduleedit').append('<option value="'+value.mId+'">' + value.mName + '</option>');

                                                            }
                                                        )
                                                    }
                                                }
                                            })}
                                    </script>

                                    <br>


                                    <div id="edit_div_modulename" style="display: none" class="form-control">
                                        <select name="" id="showmoduleedit"  onchange="return showsubmoduleedit()" class="form-control">

                                        </select>
                                        <br><br><br>
                                    </div>


                                    <div id="div_showsubmoduledropdown" style="display: none">
                                        <br><br><br>
                                        <select name="showsubmoduledropdown" id="showsubmoduledropdown"  class="form-control">

                                        </select>
                                    </div>
                                </div>


                                <meta name="viewport" content="width=device-width, initial-scale=1">
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                                <script>
                                    function showsubmoduleedit(){

                                        var moduleidfromdropdown = document.getElementById("showmoduleedit").value;
                                        var moduleidfrominput =document.getElementById("mId").value;

                                        if(moduleidfromdropdown==""){
                                            moduleid=moduleidfrominput;   //VALUE FROM INPUT MODULEID
                                            console.log(moduleid);
                                        }else{
                                            moduleid=moduleidfromdropdown; //VALUE FROM DROPDOWN MODULEID
                                        }
                                        $.ajax({
                                            url: "{{url('/subModuleCheck')}}",
                                            type: "GET",
                                            data: {
                                                mid: moduleid,
                                                _token: '{{csrf_token()}}'
                                            },
                                            success: function(result) {
                                                if (result) {
                                                    document.getElementById("show_submodule").style.display="none";
                                                    document.getElementById("div_showsubmoduledropdown").style.display="block";
                                                    $.each(result, function(key, value) {
                                                        $('#showsubmoduledropdown').append('<option value="'+value.smId+'">' + value.smName + '</option>');
                                                    })}}})}
                                </script>


                                <div id="show_submodule">
                                    <input type="text" style="width:450px" name="smId" id="smId" hidden><br>
                                    <label for="smId"><b style="color: black;">Submodule Name :</b> </label>
                                    <input type="text" style="width:450px" name="smName" id="smName" class="form-control"  disabled><br>
                                    <h1 class="fe fe-24 fe-edit" style="color: #007bff;" onclick=" return showsubmoduleedit()"></h1>
                                    <br>
                                    <br>
                                </div>





                                <div class="form-group">
                                    <label for="question" class="col-form-label"><b style="color: black;">Enter Question :</b> </label><br>
                                    <textarea id="question1"  name="question" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="option1" class="col-form-label"><b style="color: black;">Enter Option 1 :</b> </label><br>
                                    <input type="radio" id="answer1" name="answer" value="option1" class="check-new">
                                    <textarea type="text" style="width:450px" name="option1" id="option1" class="form-control"></textarea><br>
                                </div>
                                <div class="form-group">
                                    <label for="option2" class="col-form-label"><b style="color: black;">Enter Option 2 :</b> </label><br>
                                    <input type="radio" id="answer2" name="answer" value="option2" class="check-new">
                                    <textarea type="text" style="width:450px" name="option2" id="option2" class="form-control"></textarea><br>
                                </div>
                                <div class="form-group">
                                    <label for="option3" class="col-form-label"><b style="color: black;">Enter Option 3 :</b> </label><br>
                                    <input type="radio" id="answer3" name="answer" value="option3" class="check-new">
                                    <textarea type="text" style="width:450px" name="option3" id="option3" class="form-control"></textarea><br>
                                </div>
                                <div class="form-group">
                                    <label for="option4" class="col-form-label"><b style="color: black;">Enter Option 4 :</b> </label><br>
                                    <input type="radio" id="answer4" name="answer" value="option4" class="check-new">
                                    <textarea type="text" style="width:450px" name="option4" id="option4" class="form-control"></textarea><br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn mb-2 btn-primary" value="Save" onclick="return isUnitSelected()">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>










        </main> <!-- main -->
    </div> <!-- .wrapper -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>$('body').on('hidden.bs.modal', function () {
            if($('.modal.in').length > 0)
            {
                $('body').addClass('modal-open');
            }
        });</script>
    <script type="text/javascript">
        function isUnitSelected() {
            const radios = document.querySelectorAll('input[name="answer"]');
            const selected = [...radios].some(radio => radio.checked);
            if (!selected) {
                alert("Select Any Answer");
                return false;
            }

        }

    </script>



    <!-- EditModal -->

    <style>
        .arrow {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
        }
        .down {
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
        }
    </style>


    <!-- TO SHOw LAODER -->
    <script>
        //SHOW ANSWSER OVER THE QUESTION
        function showanswer(cqId){
            //document.getElementById("show_loader").style.display= 'block';
            $.ajax({
                url: "{{url('/questionauthorizermaindraftTake')}}",
                type: "GET",
                data: {
                    cqId: cqId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {

                    if (result) {
                        //document.getElementById("show_loader").style.display= 'none';

                        const answerover =document.getElementsByName("answerover");
                        answerover.forEach(button=>{button.style.display = 'none'; })


                        document.getElementById('answeronmousehover'+cqId).style.display= 'block';

                        if(result[0].ansA=="1"){

                            document.getElementById('answeronmousehover'+cqId).innerHTML=result[0].optA;
                        }
                        else if(result[0].ansB=="1"){
                            document.getElementById('answeronmousehover'+cqId).innerHTML=result[0].optB;
                        }
                        else if(result[0].ansC=="1"){
                            document.getElementById('answeronmousehover'+cqId).innerHTML=result[0].optC;
                        }
                        else if(result[0].ansD=="1"){
                            document.getElementById('answeronmousehover'+cqId).innerHTML=result[0].optD;
                        }
                    }
                }
            })
        }
        function hideanswer(cqId){
            document.getElementById('answeronmousehover'+cqId).innerHTML="";
            console.log("xdfghjknmi,op");
        }

        // SCRIPT TO SHOW QUESTION TO SHOW MODEL
        function showq(cqId) {

            $.ajax({
                url: "{{url('/questionauthorizermaindraftTake')}}",
                type: "GET",
                data: {
                    cqId: cqId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {

                    if (result) {
                        console.log(result);
                        document.getElementById("option1showq").style="color:black;";
                        document.getElementById("option2showq").style="color:black;";
                        document.getElementById("option3showq").style="color:black;";
                        document.getElementById("option4showq").style="color:black;";

                        document.getElementById("modulenameinview").innerHTML =result[0].mName;
                        document.getElementById("submodulenameinview").innerHTML =result[0].smName;
                        document.getElementById("cqIdshowq").value =result[0].cqId;
                        document.getElementById("question1showq").innerHTML =result[0].question;
                        document.getElementById("option1showq").innerHTML =result[0].optA;
                        document.getElementById("option2showq").innerHTML =result[0].optB;
                        document.getElementById("option3showq").innerHTML =result[0].optC;
                        document.getElementById("option4showq").innerHTML =result[0].optD;

                        if(result[0].ansA=="1"){
                            document.getElementById("option1showq").style="color:green;";
                        }
                        else if(result[0].ansB=="1"){
                            document.getElementById("option2showq").style="color:green;";
                        }
                        else if(result[0].ansC=="1"){
                            document.getElementById("option3showq").style="color:green;";
                        }
                        else if(result[0].ansD=="1"){
                            document.getElementById("option4showq").style="color:green;";
                        }
                        //show popupresult
                        // document.getElementById("show_question").style.display = "none";
                        $('#show_question').modal('show');
                        // data-target="#show_question"
                    }}
            })
        }
    </script>
    <!-- FORM FOR MODEL TO SHOW VALUES -->

    <script>
        // SCRIPT TO SHOW QUESTION TO EDIT MODEL

        function editq(cqId) {
            var cqId=document.getElementById("cqIdshowq").value;

            $.ajax({
                url: "{{url('/questionauthorizermaindraftTake')}}",
                type: "GET",
                data: {
                    cqId: cqId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {

                    if (result) {
                        document.getElementById("cqId").value =result[0].cqId;
                        document.getElementById("qCode").value =result[0].qCode;
                        document.getElementById("mId").value =result[0].mId;
                        document.getElementById("mName").value =result[0].mName;
                        document.getElementById("smId").value =result[0].smId;
                        document.getElementById("smName").value =result[0].smName;
                        document.getElementById("question1").value =result[0].question;
                        document.getElementById("option1").value =result[0].optA;
                        document.getElementById("option2").value =result[0].optB;
                        document.getElementById("option3").value =result[0].optC;
                        document.getElementById("option4").value =result[0].optD;
                        //document.getElementById("answer").innerHTML =value.answer;
                    }}
            })
        }
    </script>

    <script src='js/jquery.dataTables.min.js'></script>
    <script src='js/dataTables.bootstrap4.min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <script type="text/javascript">
        function isUnitSelected() {
            const radios = document.querySelectorAll('input[name="answer"]');
            const selected = [...radios].some(radio => radio.checked);
            if (!selected) {
                alert("Select Any Answer");
                return false;
            }
        }

    </script>
    <script src='js/jquery.dataTables.min.js'></script>
    <script src='js/dataTables.bootstrap4.min.js'></script>

    <script>
        $('#dataTable-1').DataTable(

            {
                autoWidth: true,
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ]
            });
    </script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
<script>
    function activeItem(event, element) {
        event.preventDefault(); // prevent the default link behavior

        // Show the SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you approve this Question?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms the deletion, redirect to the delete URL
                window.location.href = element.href;
            }
        });
    }
</script>

<script>
function inactiveItem(event, element) {
    event.preventDefault(); // prevent the default link behavior

    // Show the SweetAlert confirmation dialog
    Swal.fire({
        title: 'Are you refuse this Question?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user confirms the deletion, redirect to the delete URL
            window.location.href = element.href;
        }
    });
}
</script>


@endsection
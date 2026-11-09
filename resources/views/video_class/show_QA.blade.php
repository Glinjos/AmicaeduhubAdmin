@extends('admin.adminMaster')


@section('adminpanel')
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
    function exportToExcel() {
     var i = 1; 
        $.ajax({
            type: 'POST',
            url: '/excelgetvidepclassexamdwnld',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                try {
                    var transformedData = data.map(function (item) {
                        return {
                            "Sl No": i++,
                            "Exam Subject": item.vcModuleName,
                            "Exam Chapter": item.chapterName,
                            "Exam Title": item.videoHeading,
                            "Question": item.question,
                            "OptionA": item.optionA,
                            "OptionB": item.optionB,
                            "OptionC": item.optionC,
                            "OptionD": item.optionD,
                            "Answer": item.answer
                        };
                    });

                   
                    if (transformedData.length > 0) {
                        var worksheet = XLSX.utils.json_to_sheet(transformedData);
                        var workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1"); 

                        var filename = "reportVC.xlsx";
                        
                        try {
                            XLSX.writeFile(workbook, filename);
                        } catch (e) {
                            //console.error("Error saving workbook:", e);
                        }
                    } else {
                        //console.error("No data to convert to Excel.");
                    }


                } catch (e) {
                   // console.error("Error converting data to Excel:", e);
                }
            },
            error: function (xhr, status, error) {
                //console.error('Error: ' + error);
               // console.log('Status: ' + status);
                //console.log(xhr.responseText);
            }
        });
    }
</script>

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
                        <h2 class="mb-2 page-title">Video Class Questions & Answers</h2>
                        
                         <th>
                            <h4 align="right">
                                <abbr title="Excel Download"> <button id="btn_btn_btn_print" class="btn btn-primary btn-sm" onclick="exportToExcel()"><i class="fas fa-download"></i>&nbsp;Download</button></abbr>
                            </h4>
                          </th>
                          <style>
                            .btn.btn-primary.btn-sm {
                              width: 100px;
                              height: 25px;
                            }
                          </style>
                          
                          
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <table class="table datatables" id="dataTable-1" >
                                            <thead>
                                            <tr style="background-color: lightgray;">
                                                <th style="color: black;"><b>SL NO</b></th>
                                                {{-- <th style="color: black;"><b>Exam Type</b></th> --}}
                                                <th style="color: black;"><b>Exam Subject</b></th>
                                                <th style="color: black;"><b>Exam Chapter</b></th>
                                                <th style="color: black;"><b>Exam Title</b></th>
                                                <th style="color: black;"><b>QUESTIONS</b></th>
                                                <th style="color: black;"><b></b>&nbsp;&nbsp;&nbsp;</th>
                                                <th style="color: black;"><b>ACTIONS</b></th>

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

                                                    <tr  style=color:black;">
                                                        <td width="65"><b>{{$i++}}</b></td>

                                                        {{-- <td width="100">{{$item->VcmainName}}</td> --}}
                                                        <td width="100">{{$item->vcModuleName}}</td>
                                                        <td width="150"><span id="sm{{$i}}">{{ $item->chapterName}}</span></td>
                                                        <td width="150"><span id="sm{{$i}}">{{ $item->videoHeading}}</span></td>
                                                        <td width="300">
                                                            <span  id="que{{$i}}" style="word-wrap: break-word;" onmouseover="return showanswer(<?php echo $item->questionId; ?>)"
                                                                   onmouseout="return hideanswer(<?php echo $item->questionId; ?>)">{{$item->question}}</span>
                                                            <p name="answerover" id="answeronmousehover{{$item->questionId}}" style="width:400px;word-wrap: break-word; display: none;color:green;font-weight: bold;" >"answer is" </p>
                                                        </td>
                                                        <td width="30"><abbr style="text-decoration: none;" title="ViewMore"><span onclick="return  showq(<?php echo $item->questionId;?>)" style="color: green;" class="fe fe-24 fe-more-horizontal" ></span></abbr></td>
                                                        <td width="65">

                                                            <abbr style="text-decoration: none;" title="Edit Questions"><a href="{{url('updateVCQuestion'.$item->questionId)}}" style="text-decoration: none;" onclick="editItem(event, this)"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                    
                                                            <abbr style="text-decoration: none;"  title="Delete Question"><a href="{{url('VCQuestionDelete/'.$item->questionId)}}" style="text-decoration: none;" onclick="deActiveItem(event, this)"><span style="color: red;font-size: 26px;"class="fa fa-trash-o"></span></a></abbr>

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
                                {{-- <tr>
                                    <br>
                                    <b style="color: black;">Exam Type :</b>
                                    <p id="examnameinview"  name="examnameinview" style="font-weight: bold;color:blue;" disabled></p>
                                    
                                </tr> --}}
                                <tr>
                                    <br>
                                    <b style="color: black;">Subject :</b>
                                    <p id="modulenameinview"  name="modulenameinview" style="font-weight: bold;color:blue;" disabled></p>
                                    <br>
                                </tr>
                                <tr>

                                    <b style="color: black;">Chapter :</b>
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
                                <div class="modal-footer">
                                   

                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>







            {{--Edit question modal--}}



 




        </main> <!-- main -->
    </div> <!-- .wrapper -->


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>$('body').on('hidden.bs.modal', function () {
            if($('.modal.in').length > 0)
            {
                $('body').addClass('modal-open');
            }
        });</script>
    <script type="text/javascript">
        function isUnitSelected() {
            // alert(vcExamId);
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
        function showanswer(vcExamId){
            //document.getElementById("show_loader").style.display= 'block';
            $.ajax({
                url: "{{url('/VCquestionTake')}}",
                type: "GET",
                data: {
                    vcExamId: vcExamId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {
                    console.log(result);

                    if (result) {
                        //document.getElementById("show_loader").style.display= 'none';

                        const answerover =document.getElementsByName("answerover");
                        answerover.forEach(button=>{button.style.display = 'none'; })


                        document.getElementById('answeronmousehover'+vcExamId).style.display= 'block';

                        if(result[0].ansA=="1"){

                            document.getElementById('answeronmousehover'+vcExamId).innerHTML=result[0].optionA;
                        }
                        else if(result[0].ansB=="1"){
                            document.getElementById('answeronmousehover'+vcExamId).innerHTML=result[0].optionB;
                        }
                        else if(result[0].ansC=="1"){
                            document.getElementById('answeronmousehover'+vcExamId).innerHTML=result[0].optionC;
                        }
                        else if(result[0].ansD=="1"){
                            document.getElementById('answeronmousehover'+vcExamId).innerHTML=result[0].optionD;
                        }
                    }
                }
            })
        }
        function hideanswer(vcExamId){
            document.getElementById('answeronmousehover'+vcExamId).innerHTML="";
        }

        // SCRIPT TO SHOW QUESTION TO SHOW MODEL
        function showq(vcExamId) {

            $.ajax({
                url: "{{url('/VCquestionTake')}}",
                type: "GET",
                data: {
                    vcExamId: vcExamId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {

                    if (result) {
                       console.log(result);
                        document.getElementById("option1showq").style="color:black;";
                        document.getElementById("option2showq").style="color:black;";
                        document.getElementById("option3showq").style="color:black;";
                        document.getElementById("option4showq").style="color:black;";

                       // document.getElementById("examnameinview").innerHTML =result[0].pqmainName;
                        document.getElementById("modulenameinview").innerHTML =result[0].vcmName;
                        document.getElementById("submodulenameinview").innerHTML =result[0].vcChapterName;
                        document.getElementById("cqIdshowq").value =result[0].vcExamId;
                        document.getElementById("question1showq").innerHTML =result[0].question;
                        document.getElementById("option1showq").innerHTML =result[0].optionA;
                        document.getElementById("option2showq").innerHTML =result[0].optionB;
                        document.getElementById("option3showq").innerHTML =result[0].optionC;
                        document.getElementById("option4showq").innerHTML =result[0].optionD;

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

        function editq(vcExamId) {
            var vcExamId=document.getElementById("cqIdshowq").value;

            console.log(vcExamId);
            $.ajax({
                url: "{{url('/VCquestionTake')}}",
                type: "GET",
                data: {
                    vcExamId: vcExamId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {

                    // console.log(result);
                    if (result) {
                        document.getElementById("vcExamId").innerHTML.value =result[0].vcExamId;
                        document.getElementById("vcmId").value =result[0].vcmId;

                        document.getElementById("vcmName").value =result[0].vcmName;
                        document.getElementById("vcChapterId").value =result[0].vcChapterId;
                        document.getElementById("vcChapterName").value =result[0].vcChapterName;
                        document.getElementById("question1").value =result[0].question;
                        document.getElementById("option1").value =result[0].optionA;
                        document.getElementById("option2").value =result[0].optionB;
                        document.getElementById("option3").value =result[0].optionC;
                        document.getElementById("option4").value =result[0].optionD;
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
                   [50, 100, 200, -1],
                    [50, 100, 200, "All"]
                ]
            });
    </script>



@endsection
@extends('admin/adminMaster')

@section('adminpanel')
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-6">
                              <h2 class="page-title">Add Daily Exam Chapter Wise </h2>
                            </div>
                           
                          </div>

                          <style>
                            .custom-btn-height {
                              height: 30px;
                            }
                          
                          </style>
                          
                          
                              
                          
                          

                        <form action="{{ url('addDailyChapterExam') }}" id="mform" method="POST">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            <div class="card shadow mb-4">
                                @if (session('success'))
                                    <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                @endif
                                @if (session('error'))
                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Exam Name</b></label>
                                                <input type="text" id="dailyexamName" name="dailyexamName" value="{{old('dailyexamName')}}" onkeyup="return nameValidation()" placeholder="Enter exam name" class="form-control">
                                                @if ($errors->has('dailyexamName'))
                                                    <span class="text-danger">{{ $errors->first('dailyexamName') }}</span>
                                                @endif
                                                <span id="dailyexamName-error" class="text-danger"></span>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Exam Date</b></label>
                                                <input type="date" id="dailyexamDate" name="dailyexamDate" value="{{old('dailyexamDate')}}"  min="{{ date('Y-m-d') }}" onchange="return dateValidation()" class="form-control" >
                                                @if ($errors->has('dailyexamDate'))
                                                    <span class="text-danger">{{ $errors->first('dailyexamDate') }}</span>
                                                @endif
                                                <span id="dailyexamDate-error" class="text-danger"></span>
                                            </div>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                           const activedateInput = document.getElementById('dailyexamDate');
                                           const today = new Date().toISOString().split('T')[0]; // Get today's date in the format "YYYY-MM-DD"
                                           activedateInput.value = today;
                                       });
                                       </script>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Time From:</b></label>
                                                <input type="time" id="dailyexamTimeFrom" name="dailyexamTimeFrom" value="{{old('dailyexamTimeFrom')}}"  oninput="timeFromValidation();timeFromBLAHValidation();" placeholder="hh:mm" class="form-control"  >
                                                @if ($errors->has('dailyexamTimeFrom'))
                                                    <span class="text-danger">{{ $errors->first('dailyexamTimeFrom') }}</span>
                                                @endif
                                                <span id="dailyexamTimeFrom-error" class="text-danger"></span>
                                                <p id="errorMessage" style="color: red;"></p>
                                                <?php
                                                date_default_timezone_set("Asia/Calcutta");
                                                ?>
                                                
                                                <script>
                                                    function timeFromBLAHValidation() {
                                                        var inputDateElement = document.getElementById("dailyexamDate");
                                                        var inputTimeElement = document.getElementById("dailyexamTimeFrom");
                                                        var selectedDate = new Date(inputDateElement.value);
                                                        var selectedTime = inputTimeElement.value;
                                                        var currentTime = new Date();
                                                    
                                                        if (selectedDate.toDateString() === currentTime.toDateString()) {
                                                            // Selected date is equal to the current date, now validate the time
                                                            
                                                            var hours = currentTime.getHours();
                                                            var minutes = currentTime.getMinutes();
                                                            var selectedTimeParts = selectedTime.split(":");
                                                            var selectedHour = parseInt(selectedTimeParts[0]);
                                                    
                                                            if (selectedHour < hours) {
                                                                document.getElementById("errorMessage").textContent = "The selected time must be greater than the current time on the selected date.";
                                                                inputTimeElement.value = "";
                                                                return false;
                                                            } else {
                                                                document.getElementById("errorMessage").textContent = "";
                                                                return true;
                                                            }
                                                            
                                                        }
                                                        // Reset error message if the date is not today's date
                                                        document.getElementById("errorMessage").textContent = "";
                                                    }
                                                    </script>
                                                 
                                                    
                                                        
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Time To:</b></label>
                                                <input type="time" id="dailyexamTimeTo" name="dailyexamTimeTo" value="{{old('dailyexamTimeTo')}}"  oninput="timeToValidation();timeTOBLAHValidation();" placeholder="hh:mm" class="form-control" >
                                                @if ($errors->has('dailyexamTimeTo'))
                                                    <span class="text-danger">{{ $errors->first('dailyexamTimeTo') }}</span>
                                                @endif
                                                <span id="dailyexamTimeTo-error" class="text-danger"></span>
                                                <p id="errorToMessage" style="color: red;"></p>
                                               
                                            </div>
                                        </div>
                                        <?php
                                        date_default_timezone_set("Asia/Calcutta");
                                        ?>
                                        <script>
                                            function timeTOBLAHValidation() {
                                                var inputDateElement = document.getElementById("dailyexamDate");
                                                var inputTimeElement = document.getElementById("dailyexamTimeTo");
                                                var selectedDate = new Date(inputDateElement.value);
                                                var selectedTime = inputTimeElement.value;
                                                var currentTime = new Date();
                                            
                                                if (selectedDate.toDateString() === currentTime.toDateString()) {
                                                    // Selected date is equal to the current date, now validate the time

                                                    var hours = currentTime.getHours();
                                                    var minutes = currentTime.getMinutes();
                                                    var selectedTimeParts = selectedTime.split(":");
                                                    var selectedHour = parseInt(selectedTimeParts[0]);
                                                    
                                                    if (selectedHour < hours) {
                                                        document.getElementById("errorToMessage").textContent = "The selected time must be greater than the current time on the selected date.";
                                                        inputTimeElement.value = "";
                                                        return false;
                                                    } else {
                                                        document.getElementById("errorToMessage").textContent = "";
                                                        return true;
                                                    }
                                                }
                                                // Reset error message if the date is not today's date
                                                document.getElementById("errorToMessage").textContent = "";
                                            }
                                            </script>
                                        

                                    </div>








                                    @if(isset($module))
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="simpleinput"><b style="color: black;">Modules</b></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @php
                                                        $halfCount = ceil(count($module) / 2);
                                                    @endphp
                                                    @foreach($module as $index => $item)
                                                        @if($index < $halfCount)
                                                            <div class="form-check">
                                                                <input type="checkbox" id="moduleId_{{$item->mId}}" value="{{$item->mId}}" name="moduleId[]" onclick="checkboxSubmoduleValidation();checkboxValidation()" class="form-check-input">
                                                                <label for="moduleId_{{$item->mId}}" class="form-check-label">{{$item->mName}}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @if ($errors->has('moduleId'))
                                                        <span class="text-danger">{{ $errors->first('moduleId') }}</span>
                                                    @endif
                                                    <span id="moduleId-error" class="text-danger"></span>
                                                </div>
                                    
                                                <div class="col-md-6">
                                                    @foreach($module as $index => $item)
                                                        @if($index >= $halfCount)
                                                            <div class="form-check">
                                                                <input type="checkbox" id="moduleId_{{$item->mId}}" value="{{$item->mId}}" name="moduleId[]" onclick="checkboxSubmoduleValidation();checkboxValidation()" class="form-check-input">
                                                                <label for="moduleId_{{$item->mId}}" class="form-check-label">{{$item->mName}}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

              {{-- the main div closing the submodule --}}
                            <div id="mainsubmodulediv"style="display: none;"> 
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                            <label for="simpleinput"><b style="color: black;">Sub Modules</b></label>
                                        <div class="form-group mb-6">
                                            <div class="row">
                                                
                                               
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;<div id="submodulesDiv1" style="display: none;">
                                                        <!-- Display the submodules checkboxes -->
                                                    </div>&nbsp;&nbsp;
                                                    <div id="submodulesDiv2" style="display: none;">
                                                        <!-- Display the submodules checkboxes -->
                                                    </div>
                                            </div>
                                                    <span id="submodule__Id-error" class="text-danger"></span>                                        
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
               {{-- END the main div closing the submodule --}}
                    <style>
                        /* Add this CSS to your stylesheet */
                    .checkbox-right {
                        text-align: right;
                    }
                    .checkbox-right .form-check {
                        text-align: left;
                        display: inline-block;
                        margin-right: 20px; /* Adjust the margin as needed */
                    }
                    </style>                                    
 
                    <script>
                        function checkboxSubmoduleValidation() {
                        if ($('input[name="moduleId[]"]:checked').length > 0) {
                            var selectedModules = [];
                            var submoduleHTMLDiv1 = ''; //  first div
                            var submoduleHTMLDiv2 = ''; //  second div

                            $('input[name="moduleId[]"]:checked').each(function() {
                                selectedModules.push($(this).val());
                            });

                            var loadSubmodules = function(moduleIds) {
                                var allSubmodules = []; //  current request

                                if (moduleIds.length === 0) {
                                    return;
                                }

                                var moduleId = moduleIds.shift(); // first module ID

                                $.ajax({
                                    url: "{{url('/ChapterWiseDailyexmmodulecheck')}}",
                                    type: "POST",
                                    data: {
                                        mId: moduleId,
                                        _token: '{{csrf_token()}}'
                                    },
                                    success: function(result) {
                                        if (result) {
                                            allSubmodules = allSubmodules.concat(result);
                                        console.log(allSubmodules);
                                            $.each(allSubmodules, function(key, value) {
                                                if (key % 2 === 0) {
                                                    //  first div
                                                    submoduleHTMLDiv1 += '<div class="form-check">';
                                                    submoduleHTMLDiv1 += '<input type="checkbox" id="submoduleId_' + value.smId + '" value="' + value.smId + '" name="submoduleId[]" class="form-check-input" onclick="return checkboxValidation();">';
                                                    submoduleHTMLDiv1 += '<label for="submoduleId_' + value.smId + '" class="form-check-label">' + value.smName + '</label>';
                                                    submoduleHTMLDiv1 += '</div>';
                                                } else {
                                                    //  second div
                                                    submoduleHTMLDiv2 += '<div class="form-check">';
                                                    submoduleHTMLDiv2 += '<input type="checkbox" id="submoduleId_' + value.smId + '" value="' + value.smId + '" name="submoduleId[]" class="form-check-input" onclick="return checkboxValidation();">';
                                                    submoduleHTMLDiv2 += '<label for="submoduleId_' + value.smId + '" class="form-check-label">' + value.smName + '</label>';
                                                    submoduleHTMLDiv2 += '</div>';
                                                }
                                            });


                                            loadSubmodules(moduleIds);
                                        }
                                    },
                                    complete: function() {

                                        if (moduleIds.length === 0) {
                                            //  display the submodules
                                            $('#submodulesDiv1').html(submoduleHTMLDiv1);
                                            $('#submodulesDiv2').html(submoduleHTMLDiv2);
                                            $('#submodulesDiv1').show();
                                            $('#submodulesDiv2').show();
                                            document.getElementById("mainsubmodulediv").style.display = 'block';
                                        
                                        }
                                    }
                                });
                            };

                            loadSubmodules(selectedModules.slice()); 
                        } else {
                            // Hide the selected module display and submodules if no modules are selected
                            $('#submodulesDiv1').hide();
                            $('#submodulesDiv2').hide();
                            document.getElementById("mainsubmodulediv").style.display = 'none';
                        }
                    }
                    </script>
                                    
                                        
                                                                                
                                        

                                     {{-- // NUMBER OF QUESTION FOR THIS EXAM --}}

                                     <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="dailyexamQuest"><b style="color: black;">Number Of Questions:</b></label>
                                                <input type="text" id="dailyexamQuest" name="dailyexamQuest" value="{{ old('dailyexamQuest') }}" onkeyup="return questValidation()" placeholder="Enter No. Of Questions" class="form-control">
                                                @if ($errors->has('dailyexamQuest'))
                                                    <span class="text-danger">{{ $errors->first('dailyexamQuest') }}</span>
                                                @endif
                                                <span id="dailyexamQuest-error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    
                                        &nbsp;
                                        <div class="col-md-3 mb-1">
                                            <div class="form-group">
                                                <label for="dailyexampostiveMark"><b style="color: black;">Positive Mark:</b></label>
                                                <input type="text" id="dailyexampostiveMark" name="dailyexampostiveMark" value="{{ old('dailyexampostiveMark') }}" onkeyup="return postValidation()" placeholder="Enter positive mark" class="form-control">
                                                @if ($errors->has('dailyexampostiveMark'))
                                                    <span class="text-danger">{{ $errors->first('dailyexampostiveMark') }}</span>
                                                @endif
                                                <span id="dailyexampostiveMark-error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    
                                       
                                        <div class="col-md-3 mb-1">
                                            <div class="form-group">
                                                <label for="dailyexamnegativeMark"><b style="color: black;">Negative Mark:</b></label>
                                                <input type="text" id="dailyexamnegativeMark" name="dailyexamnegativeMark" value="{{ old('dailyexamnegativeMark') }}" onkeyup="return negativeValidation()" placeholder="Enter negative mark" class="form-control">
                                                @if ($errors->has('dailyexamnegativeMark'))
                                                    <span class="text-danger">{{ $errors->first('dailyexamnegativeMark') }}</span>
                                                @endif
                                                <span id="dailyexamnegativeMark-error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                



                                            <button type="submit" id="btn" onclick="mainValidation()"  class="btn btn-primary" disabled>SAVE</button>
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->
                    <br>

                    <div class="container-fluid">
                        <div class="row justify-content-center">

                            <div class="col-12">
                                <h2 class="page-title">Exams We Have</h2>
                                <div class="row my-4">
                                    <!-- Small table -->
                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            <div class="card-body">

                                                <!-- table -->
                                                <table class="table datatables" id="dataTable-1">
                                                    <thead>
                                                    <tr style="background-color: lightgray;">
                                                        <th style="color: black;"><b>SL NO</b></th>
                                                        {{-- <th></th> --}}
                                                        <th style="color: black;"><b>Exam Name</b></th>
                                                        <th style="color: black;"><b>Exam Date</b></th>
                                                        <th style="color: black;"><b>Exam From Time</b></th>
                                                        <th style="color: black;"><b>Exam To Time</b></th>
                                                        <th style="color: black;"><b>Module Name</b></th>
                                                        <th style="color: black;"><b>No.Of.Question</b></th>
                                                        <th style="color: black;"><b>Positive Mark</b></th>
                                                        <th style="color: black;"><b>Negative Mark</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($dailyExam))
                                                        @php $i=1 @endphp
                                                        @foreach ($dailyExam as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b>
                                                                </td>
                                                                {{-- <td  width="20" > @if( $item->isAvail==0)
                                                                        <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                    @endif
                                                                    @if( $item->isAvail==1)
                                                                        <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                    @endif
                                                                </td> --}}
                                                                <td width="100">{{ $item->examName }}</td>
                                                                <td width="80">{{ wordwrap($item->examdate,20,"\n",TRUE) }}</td>
                                                                <td width="80">{{ $item->timeFrom }}</td>
                                                                <td width="80">{{ $item->timeTo }}</td>
                                                                <td width="80">{{ wordwrap($item->moduleNames,20,"\n",TRUE) }}</td>
                                                                <td width="70">{{ wordwrap($item->noOfQuestions,20,"\n",TRUE) }}</td>
                                                                <td width="80">{{ $item->postiveMark }}</td>
                                                                <td width="80">{{ $item->negativeMark }}</td>
                                                                
                                                                <td width="65">
                                                                    <abbr style="text-decoration: none;"  title="Delete Exam"><a href="{{url('deletechapterwisetheexam/'.$item->dId)}}" style="text-decoration: none;" onclick="deleteItem(event, this)"><span style="color: red;font-size: 26px;"class="fa fa-trash-o"></span></a></abbr>
                                                                    &nbsp;
                                                                    {{-- @if( $item->isExpired==0)
                                                                            <abbr style="text-decoration: none;"  title="Expired Exam"><a href="{{url('examExpired/'.$item->dId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                        @endif
                                                                        @if( $item->isExpired==2)
                                                                            <abbr style="text-decoration: none;" title="Activate Exam"> <a href="{{url('examActive/'.$item->dId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                    @endif --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> <!-- simple table -->
                                </div> <!-- end section -->
                            </div> <!-- .col-12 -->
                        </div> <!-- .row -->
                    </div> <!-- .container-fluid -->


                </div>
            </div>
        </main> <!-- main -->
    </div>
   
    <script src="js/app.js"></script>
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

    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->
    <!---------------FORM JAVASCRIPT VALIDATION FOR Module Code-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <script>
        function dateValidation() {
            var dailyexamDate = document.getElementById('dailyexamDate').value;
            let shouldSubmitForm = true;
    
            if (dailyexamDate == null || dailyexamDate == "") {
                document.getElementById("dailyexamDate-error").innerHTML = "This field is required.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else {
                document.getElementById("dailyexamDate-error").innerHTML = "";
                $("#btn").attr("disabled", false);
            }
    
            return shouldSubmitForm;
        }
    </script>
    
    <script>
        function nameValidation() {
            var dailyexamName = document.getElementById('dailyexamName').value;
            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;
            let shouldSubmitForm = true;
    
            if (dailyexamName == null || dailyexamName == "") {
                document.getElementById("dailyexamName-error").innerHTML = "This field is required.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            }
            //  else if (dailyexamName.match(format)) {
            //     document.getElementById("dailyexamName-error").innerHTML = "Restriction for numbers and symbols.";
            //     shouldSubmitForm = false;
            //     $("#btn").attr("disabled", true);
            // } 
            else {
                document.getElementById("dailyexamName-error").innerHTML = "";
                $("#btn").attr("disabled", false);
            }
    
            return shouldSubmitForm;
        }
    </script>
   <script>
    function timeFromValidation() {
        var dailyexamTimeFrom = document.getElementById('dailyexamTimeFrom').value;
        var time = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?,]/;
        let shouldSubmitForm = true;

        if (dailyexamTimeFrom == null || dailyexamTimeFrom == "") {
            document.getElementById("dailyexamTimeFrom-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        // } else if (dailyexamTimeFrom.match(time)) {
        //     document.getElementById("dailyexamTimeFrom-error").innerHTML = "Restriction for symbols.";
        //     shouldSubmitForm = false;
        //     $("#btn").attr("disabled", true);
        } else {
            document.getElementById("dailyexamTimeFrom-error").innerHTML = "";
            $("#btn").attr("disabled", false);
        }

        return shouldSubmitForm;
    }
</script>


<script>
    function timeToValidation() {
        var dailyexamTimeTo = document.getElementById('dailyexamTimeTo').value;
        var time = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?,]/;
        let shouldSubmitForm = true;

        if (dailyexamTimeTo == null || dailyexamTimeTo == "") {
            document.getElementById("dailyexamTimeTo-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        // } else if (dailyexamTimeTo.match(time)) {
        //     document.getElementById("dailyexamTimeTo-error").innerHTML = "Restriction for symbols.";
        //     shouldSubmitForm = false;
        //     $("#btn").attr("disabled", true);
        } else {
            document.getElementById("dailyexamTimeTo-error").innerHTML = "";
            $("#btn").attr("disabled", false);
        }

        return shouldSubmitForm;
    }
</script>


<script>
    function checkboxValidation() {
        var checkboxes = document.querySelectorAll('input[name="moduleId[]"]:checked');
        var submoduleIds = document.querySelectorAll('input[name="submoduleId[]"]:checked');
            if (checkboxes.length === 0) {
                document.getElementById("moduleId-error").innerHTML = "Please select at least one module.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else {
                if(submoduleIds.length === 0){
                    document.getElementById("submodule__Id-error").innerHTML = "Please select at least one submodule.";
                    shouldSubmitForm = false;
                    $("#btn").attr("disabled", true);
                }else{
                    document.getElementById("submodule__Id-error").innerHTML = "";
                    $("#btn").attr("disabled", false);
                }
                document.getElementById("moduleId-error").innerHTML = "";
              //  $("#btn").attr("disabled", false);
            }
    
            if (shouldSubmitForm) {
                $("#btn").attr("disabled", true).html("Saving..."); // Disable and change button text on form submission
                $("#mform").submit();
            }
    }
</script>


<script>
    function questValidation() {
        var dailyexamQuest = document.getElementById('dailyexamQuest').value;
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,A-Z,a-z]/;
        if (dailyexamQuest == null || dailyexamQuest == "") {
            document.getElementById("dailyexamQuest-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        } 
        else if (dailyexamQuest.match(format)) {
            document.getElementById("dailyexamQuest-error").innerHTML = "Restriction for characters and symbols.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        }
        
        else {
            document.getElementById("dailyexamQuest-error").innerHTML = "";
            $("#btn").attr("disabled", false);
        }
    }
</script>
<script>
    function postValidation() {
        var dailyexampostiveMark = document.getElementById('dailyexampostiveMark').value;
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?,A-Z,a-z]/;

        if (dailyexampostiveMark == null || dailyexampostiveMark == "") {
            document.getElementById("dailyexampostiveMark-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        }
        // else if (dailyexampostiveMark.match(format)) {
        //     document.getElementById("dailyexampostiveMark-error").innerHTML = "Restriction for characters and symbols.";
        //     shouldSubmitForm = false;
        //     $("#btn").attr("disabled", true);
        // }
         else {
            document.getElementById("dailyexampostiveMark-error").innerHTML = "";
            $("#btn").attr("disabled", false);
        }
    }
</script>
<script>
    function negativeValidation() {
        var dailyexamnegativeMark = document.getElementById('dailyexamnegativeMark').value;
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?,A-Z,a-z]/;

        if (dailyexamnegativeMark == null || dailyexamnegativeMark == "") {
            document.getElementById("dailyexamnegativeMark-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        }
        // else if (dailyexamnegativeMark.match(format)) {
        //     document.getElementById("dailyexamnegativeMark-error").innerHTML = "Restriction for characters and symbols.";
        //     shouldSubmitForm = false;
        //     $("#btn").attr("disabled", true);
        // } 
        else {
            document.getElementById("dailyexamnegativeMark-error").innerHTML = "";
            $("#btn").attr("disabled", false);
        }
    }
</script>
    
    


<script>
    function mainValidation() {
        var dailyexamName = document.getElementById('dailyexamName').value;
        var dailyexamDate = document.getElementById('dailyexamDate').value;
        var dailyexamTimeFrom = document.getElementById('dailyexamTimeFrom').value;
        var dailyexamTimeTo = document.getElementById('dailyexamTimeTo').value;
        var dailyexamQuest = document.getElementById('dailyexamQuest').value;
        var dailyexampostiveMark = document.getElementById('dailyexampostiveMark').value;
        var dailyexamnegativeMark = document.getElementById('dailyexamnegativeMark').value;

        let shouldSubmitForm = true;

        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;
        var time = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?,]/;

        if (dailyexamName == null || dailyexamName == "") {
            document.getElementById("dailyexamName-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        } 
        // else if (dailyexamName.match(format)) {
        //     document.getElementById("dailyexamName-error").innerHTML = "Restriction for numbers and symbols.";
        //     shouldSubmitForm = false;
        //     $("#btn").attr("disabled", true);
        // }
         else {
            document.getElementById("dailyexamName-error").innerHTML = "";
        }

        if (dailyexamDate == null || dailyexamDate == "") {
            document.getElementById("dailyexamDate-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        } else {
            document.getElementById("dailyexamDate-error").innerHTML = "";
        }

        if (dailyexamTimeFrom == null || dailyexamTimeFrom == "") {
            document.getElementById("dailyexamTimeFrom-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        // } else if (dailyexamTimeFrom.match(time)) {
        //     document.getElementById("dailyexamTimeFrom-error").innerHTML = "Restriction for symbols.";
        //     shouldSubmitForm = false;
        //     $("#btn").attr("disabled", true);
        } else {
            document.getElementById("dailyexamTimeFrom-error").innerHTML = "";
        }

        if (dailyexamTimeTo == null || dailyexamTimeTo == "") {
            document.getElementById("dailyexamTimeTo-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        // } else if (dailyexamTimeTo.match(time)) {
        //     document.getElementById("dailyexamTimeTo-error").innerHTML = "Restriction for symbols.";
        //     shouldSubmitForm = false;
        //     $("#btn").attr("disabled", true);
        } else {
            document.getElementById("dailyexamTimeTo-error").innerHTML = "";
        }

        if (dailyexamQuest == null || dailyexamQuest == "") {
            document.getElementById("dailyexamQuest-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        } else {
            document.getElementById("dailyexamQuest-error").innerHTML = "";
        }

        if (dailyexampostiveMark == null || dailyexampostiveMark == "") {
            document.getElementById("dailyexampostiveMark-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        } else {
            document.getElementById("dailyexampostiveMark-error").innerHTML = "";
        }

        if (dailyexamnegativeMark == null || dailyexamnegativeMark == "") {
            document.getElementById("dailyexamnegativeMark-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;
            $("#btn").attr("disabled", true);
        } else {
            document.getElementById("dailyexamnegativeMark-error").innerHTML = "";
        }

        // Checkbox validation
        // var checkboxes = document.querySelectorAll('input[name="moduleId[]"]:checked');
        // if (checkboxes.length === 0) {
        //     document.getElementById("moduleId-error").innerHTML = "Please select at least one module.";
        //     shouldSubmitForm = false;
        // } else {
        //     document.getElementById("moduleId-error").innerHTML = "";
        // }

        // if (shouldSubmitForm) {
        //     $("#btn").attr("disabled", true).html("Saving..."); // Disable and change button text on form submission
        //     $("#mform").submit();
        // }
        var checkboxes = document.querySelectorAll('input[name="moduleId[]"]:checked');
        var submoduleIds = document.querySelectorAll('input[name="submoduleId[]"]:checked');
            if (checkboxes.length === 0) {
                document.getElementById("moduleId-error").innerHTML = "Please select at least one module.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else {
                if(submoduleIds.length === 0){
                    document.getElementById("submodule__Id-error").innerHTML = "Please select at least one submodule.";
                    shouldSubmitForm = false;
                    $("#btn").attr("disabled", true);
                }else{
                    document.getElementById("submodule__Id-error").innerHTML = "";
                    $("#btn").attr("disabled", false);
                }
                document.getElementById("moduleId-error").innerHTML = "";
              //  $("#btn").attr("disabled", false);
            }
    
            if (shouldSubmitForm) {
                $("#btn").attr("disabled", true).html("Saving..."); // Disable and change button text on form submission
                $("#mform").submit();
            }

    }
</script>


    
    
    {{-- <script>
        function mainValidation() {
            var dailyexamName = document.getElementById('dailyexamName').value;
            var dailyexamDate = document.getElementById('dailyexamDate').value;
            var dailyexamTimeFrom = document.getElementById('dailyexamTimeFrom').value;
            var dailyexamTimeTo = document.getElementById('dailyexamTimeTo').value;
            var dailyexamQuest = document.getElementById('dailyexamQuest').value;
            var dailyexampostiveMark = document.getElementById('dailyexampostiveMark').value;
            var dailyexamnegativeMark = document.getElementById('dailyexamnegativeMark').value;
    
            let shouldSubmitForm = true;
    
            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;
            var time = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?,]/;
    
            if (dailyexamName == null || dailyexamName == "") {
                document.getElementById("dailyexamName-error").innerHTML = "This field is required.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else if (dailyexamName.match(format)) {
                document.getElementById("dailyexamName-error").innerHTML = "Restriction for numbers and symbols.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else {
                document.getElementById("dailyexamName-error").innerHTML = "";
            }
    
            if (dailyexamDate == null || dailyexamDate == "") {
                document.getElementById("dailyexamDate-error").innerHTML = "This field is required.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else {
                document.getElementById("dailyexamDate-error").innerHTML = "";
            }
    
            if (dailyexamTimeFrom == null || dailyexamTimeFrom == "") {
                document.getElementById("dailyexamTimeFrom-error").innerHTML = "This field is required.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else if (dailyexamTimeFrom.match(time)) {
                document.getElementById("dailyexamTimeFrom-error").innerHTML = "Restriction for symbols.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else {
                document.getElementById("dailyexamTimeFrom-error").innerHTML = "";
            }
    
            if (dailyexamTimeTo == null || dailyexamTimeTo == "") {
                document.getElementById("dailyexamTimeTo-error").innerHTML = "This field is required.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else if (dailyexamTimeTo.match(time)) {
                document.getElementById("dailyexamTimeTo-error").innerHTML = "Restriction for symbols.";
                shouldSubmitForm = false;
                $("#btn").attr("disabled", true);
            } else {
                document.getElementById("dailyexamTimeTo-error").innerHTML = "";
            }
    
            if (shouldSubmitForm) {
                $("#btn").attr("disabled", true).html("Saving..."); // Disable and change button text on form submission
                $("#mform").submit();
            }
        }
    </script> --}}




    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this module?',
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
        function activeItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to Active this exam?',
                
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
                title: 'Are you sure to expired this exam time?',
               
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
    function deleteItem(event, element) {
        event.preventDefault(); // prevent the default link behavior

        // Show the SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure to delete this exam?',
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

@endsection
@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        
                         <div class="row">
                            <div class="col-6">
                               <h2 class="page-title">Add Students To Batches</h2>
                            </div>
                            <div class="col-6 text-right">
                                <a href="/addbatchdaysupadminsactivities" class="btn btn-primary custom-btn-height">create BATCHE DAY ACTIVITY</a>
                            </div> 
                          </div>

                          <style>
                            .custom-btn-height {
                              height: 30px;
                            }
                          
                          </style>
                                       @if (session('cbId'))
                                                    <script>
                                                        window.onload = function () {
                                                           // myExamFunction();
                                                            myFunction();
                                                            myUserFunction();  
                                                           
                                                            
                                                        };
                                                    </script>
                                                @endif

                        <form action="{{ url('/save_students_intothe_batch_superadmin') }}" id="cform" method="POST" >
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
                                        <div class="col-md-12">

                                            <div class="form-group mb-6">
                                                <label for="simpleinput"><b style="color: black;">Course Name</b></label>
                                                <select name="coursename" id="coursename" onchange="return myFunction()" class="form-control">
                                                    <option style="text-align: left" value="" disabled selected>--- Select course ---</option>
                                                    @if(isset($course_data))
                                                        @foreach($course_data as $data)
    
                                                            <option align="left" value="{{$data->cmId}}" {{ $data->cmId == session('cmid') ? 'selected' : '' }} id="cmId" align="center">
    
                                                            
                                                                {{ $data->coName}}</option>
    
                                                        @endforeach
                                                    @endif
    
                                                </select>
                                                @if ($errors->has('coursename'))
                                                    <span class="text-danger">{{ $errors->first('coursename') }}</span>
                                                @endif
                                                <span id="coursename-error" class="text-danger"></span>

                                            </div>

                                            <div class="form-group mb-6">
                                                <label for="simpleinput"><b style="color: black;">Batch Name</b></label>
                                                <select name="batchname" id="batchname" onchange="return myUserFunction()" class="form-control">
                                                    <option style="text-align: left" value="" disabled selected>--- Select batch ---</option>

                                                </select>
                                                
                                                @if ($errors->has('batchname'))
                                                    <span class="text-danger">{{ $errors->first('batchname') }}</span>
                                                @endif
                                                <span id="batchname-error" class="text-danger"></span>

                                            </div>

                                           
                                           
                                           

                                          

                                            {{-- <div class="row"> --}}


                                                <div class="form-group mb-6">
                                                    <label for="simpleinput"><b style="color: black;">User Name</b></label>
                                                    <select name="username" id="username" onchange="return userValidation()" class="form-control">
                                                        <option style="text-align: left" value="" disabled selected>--- Select user ---</option>
    
                                                    </select>
                                                    
                                                    @if ($errors->has('username'))
                                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                                    @endif
                                                    <span id="username-error" class="text-danger"></span>
                                                </div>




                                                {{-- <div class="col-md-2 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Active Date</b></label>
                                                        <input type="date" id="activedate" name="activedate" value="{{old('activedate')}}" onchange="return activedateValidation()" class="form-control" >
                                                        @if ($errors->has('activedate'))
                                                            <span class="text-danger">{{ $errors->first('activedate') }}</span>
                                                        @endif
                                                        <span id="activedate-error" class="text-danger"></span>
                                                    </div>
                                                </div> --}}

                                              
                                              
                                               

                                                
                                            {{-- </div> --}}





                                            <button type="submit" id="btn"  class="btn btn-primary" onclick="return MainValidation();">SAVE</button>
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <br>

                    <div class="container-fluid">
                        <div class="row justify-content-center">

                            <div class="col-12">
                                <h2 class="page-title">Students In Batches We Have</h2>
                                <div class="row my-4">
                                    <!-- Small table -->
                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            <div class="card-body">

                                                <!-- table -->
                                                <table class="table datatables" id="dataTable-1">
                                                    <thead>
                                                    <tr style="background-color: lightgray;">
                                                        <th style="color: black;"><b>Sl No</b></th>
                                                        <th></th>
                                                        <th style="color: black;"><b>Course Name</b></th>
                                                        
                                                        <th style="color: black;"><b>Batch Name</b></th>
                                                       
                                                        <th style="color: black;"><b>Total Students</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($students_in_batches))
                                                        @php $i=1 @endphp
                                                        @foreach ($students_in_batches as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b></td>
                                                                <td  width="10" > @if( $item->isActive==0)
                                                                    <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                                @if( $item->isActive==1)
                                                                    <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                            </td>
                                                                <td width="80">{{ wordwrap($item->coName,20,"\n",TRUE) }}</td>
                                                                <td width="90">{{ wordwrap($item->cbatchName,50,"\n",TRUE) }}</td>
                                                                <td width="70">{{ $item->total_students }} - STUDENTS</td>
                                                               
                                                                <td width="60">
                                                                 {{-- <abbr style="text-decoration: none;" title="ViewMore">
                                                                 <span onclick="return  showStudents(<?php echo $item->cbId;?>)" style="color: green;" class="fe fe-24 fe-more-horizontal" ></span>
                                                                </abbr> --}}
                                                                <abbr style="text-decoration: none;" title="ViewMore">
                                                                    
                                                                    <a href="{{url('studentssupadminaddedbatchtotalstudentsTake'.$item->cbId)}}" style="text-decoration: none;"><span  style="color: green;" class="fe fe-24 fe-more-horizontal" ></span></a></abbr>

                                                                  
                                                                &nbsp;
                                                                @if( $item->isActive==0)
                                                                <abbr style="text-decoration: none;"  title="Deactivate Batch"><a href="{{url('studentbatchdisable_supadmin/'.$item->cbId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                @endif
                                                                @if( $item->isActive==1)
                                                                    <abbr style="text-decoration: none;" title="Activate Batch"> <a href="{{url('studentbatchenable_supadmin/'.$item->cbId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                @endif
                                                                
                                                                  
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


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  {{-- VIEW MORE STUDENTS FULL IN THAT BATCH ADDED    --}}
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
                        
                        <tr>
                            <br>
                            <b style="color: black;">Course Name :</b>
                            <p id="coursenameinview"  name="coursenameinview" style="font-weight: bold;color:blue;" disabled></p>
                            
                        </tr>
                        <tr>
                            <br>
                            <b style="color: black;">Batch Name :</b>
                            <p id="batchnameinview"  name="batchnameinview" style="font-weight: bold;color:rgb(53, 134, 241);" disabled></p>
                            <br>
                        </tr>
                        <tr>

                            <b style="color: black;">Students :</b>
                            <p id="studentsinview"  name="studentsinview" style="font-weight: bold;color:rgb(177, 34, 34);" disabled></p>
                            <br>
                        </tr>
                       
                        <div class="modal-footer">
                           

                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
     {{--END VIEW MORE STUDENTS FULL IN THAT BATCH ADDED    --}}

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


<script>
     function showStudents(cbId) {

$.ajax({
    url: "{{url('/studentsaddedbatchtotalstudentsTake_supadmin')}}",
    type: "GET",
    data: {
        cbId: cbId,
        _token: '{{csrf_token()}}'
    },
    success: function(result) {

        if (result) {
            console.log(result);
           

            document.getElementById("coursenameinview").innerHTML =result[0].coName;
            document.getElementById("batchnameinview").innerHTML =result[0].cbatchName;
           // document.getElementById("studentsinview").innerHTML =result.name;
           let studentsText = "";
            for (let i = 0; i < result.length; i++) {
                studentsText += result[i].name;
                if (i < result.length - 1) {
                    studentsText += " , ";
                }
            }
            document.getElementById("studentsinview").innerHTML = studentsText;


            // document.getElementById("show_question").style.display = "none";
            $('#show_question').modal('show');
            // data-target="#show_question"
        }}
})
}
    </script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                function myUserFunction(){

                    $(document).ready(function() {

                        var batchname = document.getElementById('batchname').value;
                    // alert(coursename);

                        if (batchname == null || batchname == "") {
                            document.getElementById("batchname-error").innerHTML = "This field is required.";
                            return false;
                        } 
                        else{
                            document.getElementById("batchname-error").innerHTML = "";
                            MainValidation();
                        }

                });

                var coursename = document.getElementById('coursename').value;

                        var sel = null;


            $.ajax({

            url: "{{url('/checkingbatchnamewisesubscriber_supadmin')}}",

            type: "GET",

            data: {

                cmId: coursename,

                _token: '{{csrf_token()}}'

            },

            success: function(result) {

                if (result) {
                    
                    if(result.length>0){
                        
                        $('#username').empty();

                        $('#username').append('<option value="" disabled selected>--Select user name--</option>');

                                $.each(result, function(key, value) {

                                    // (value.cbId == cbId) ? sel="selected" :  sel="null";

                                    $('#username').append('<option value="'+value.uId+'"  '+sel+' >' + value.name + '</option>');

                                });

                                document.getElementById("username-error").innerHTML = "";

                                }else{

                                    $('#username').empty();
                            //alert("");
                            document.getElementById("username-error").innerHTML = "No User found for the selected course.";

                        }
            }}})


            }
            </script>
            <?php if(!empty(session('cbId'))){
                $batchid=session('cbId');
            // print_r($batchid);die;
            
            }
            else{
                $batchid="";
            }?>

        <script>
            function myFunction(){

                $(document).ready(function() {

                    var coursename = document.getElementById('coursename').value;
                // alert(coursename);

                    if (coursename == null || coursename == " ") {
                        document.getElementById("coursename-error").innerHTML = "This field is required.";
                        return false;
                    } 
                    else{
                        document.getElementById("coursename-error").innerHTML = "";
                        //MainValidation();
                    }

            });

            var coursename = document.getElementById('coursename').value;

                    var sel = null;
                    var cbid='<?php echo $batchid; ?>';

                $.ajax({

                url: "{{url('/checkingcoursenamewisebatch_supadmin')}}",

                type: "GET",

                data: {

                    cmId: coursename,

                    _token: '{{csrf_token()}}'

                },

                success: function(result) {
                        if (result && result.length > 0) {
                           // console.log(result);
                            $('#batchname').empty();

                            $('#batchname').append('<option value="" disabled selected>--Select batch name--</option>');
                $.each(result, function(key, value) {
                    (value.cbId == cbid) ? sel = "selected" : sel = "null";
                $('#batchname').append('<option value="' + value.cbId + '"  ' + sel + ' >' + value.cbatchName + '</option>');
                            });
                            document.getElementById("batchname-error").innerHTML = "";
                        } else {
                            $('#batchname').empty();
                            document.getElementById("batchname-error").innerHTML = "No batches found for the selected course.";
                            //alert("No batches found for the selected course.");
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors here if needed
                        console.log(xhr.responseText);
                    }
                });
            }
        </script>

















    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->

    <script>

        function userValidation()
        {
           
            var username = document.getElementById('username').value;

            if (username == null || username == "") {
                document.getElementById("username-error").innerHTML = "This field is required.";
                return false;
            } 
            else{
                document.getElementById("username-error").innerHTML = "";
                MainValidation();
            }
        }
       
        function activedateValidation()
        {
            var activedate = document.getElementById('activedate').value;

            if (activedate == null || activedate == "") {
                document.getElementById("activedate-error").innerHTML = "This field is required.";
                return false;
            } 
           
            else{
                document.getElementById("activedate-error").innerHTML = "";
                MainValidation();
            }
        }

      
        </script>


    <script>
        function MainValidation()
        {
            var coursename = document.getElementById('coursename').value;
            var batchname = document.getElementById('batchname').value;
            var username = document.getElementById('username').value;
           // var activedate = document.getElementById('activedate').value;
           
            
            if (coursename == null || coursename == "") {
                document.getElementById("coursename-error").innerHTML = "This field is required.";
                return false;
            } 
            if (batchname == null || batchname == "") {
                document.getElementById("batchname-error").innerHTML = "This field is required.";
                return false;
            }
            if (username == null || username == "") {
                document.getElementById("username-error").innerHTML = "This field is required.";
                return false;
            } 
            // if (activedate == null || activedate == "") {
            //     document.getElementById("activedate-error").innerHTML = "This field is required.";
            //     return false;
            // } 
                     
            
            else {
                return true;
                
            }
        }
        </script>





<script>
    // Get the current date
    const today = new Date().toISOString().split('T')[0];

    document.getElementById('activedate').setAttribute('min', today);
   
   // document.getElementById('enddate').setAttribute('min', today);
</script>






    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this batch?',
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
        function deleteItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to delete this batch?',
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
                title: 'Are you sure to activate batch?',
                text: 'Do you wish to activate this batch and the corresponding students.',
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
                title: 'Are you sure to deactivate this batch?',
                text: 'Do you wish to deactivate this batch and the corresponding students.',
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
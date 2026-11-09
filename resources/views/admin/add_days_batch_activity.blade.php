@extends('admin/adminMaster')

@section('adminpanel')
<style>
    #halfCheckbox {
  /* Hide the default checkbox */
  position: absolute;
  opacity: 0;

  /* Set the size of the custom checkbox */
  width: 20px;
  height: 20px;

  /* Define styles for the custom checkbox */
  border: 1px solid #000;
  background-color: #fff;

  /* Define the position for the "half" visual representation */
  background-image: linear-gradient(to right, black 50%, transparent 50%);
  background-size: 200% 100%;
  background-position: left;
  transition: background-position 0.4s;
}

/* Style for the "checked" state of the checkbox */
#halfCheckbox:checked {
  background-position: right;
}





.single-checkbox {
    appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 20px; /* Change this value to increase/decrease width */
        height: 20px; /* You can adjust the height as well */
        border: 2px solid red; /* Set the checkbox border color to red */
        border-radius: 4px; /* Add some border radius for a rounded appearance */
        outline: none; /* Remove the outline when the checkbox is focused */
        cursor: pointer; /* Show a pointer cursor on hover to indicate interactivity */
    }

    /* Style the checked state of the checkbox */
    .single-checkbox:checked {
        background-color: red; /* Set the background color to green when the checkbox is checked */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white' width='16px' height='16px'%3E%3Cpath d='M9.5 16.17L5.83 12.5 4.5 13.84 9.5 18.83 19.59 8.75 18.25 7.41z'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center; /* Center the checkmark icon */
    }

    /* Style the checkbox when it's checked and disabled */
    .single-checkbox:checked:disabled {
        background-color: red; /* Set a different background color for checked and disabled */
    }
    </style>



    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Batches To Day Activities </h2>
                                       @if (session('cbId'))
                                                    <script>
                                                        window.onload = function () {
                                                           // myExamFunction();
                                                            myFunction();
                                                            myModuleFunction();  
                                                            batchValidation();
                                                            
                                                        };
                                                    </script>
                                                @endif

                        <form action="{{ url('/save_batch_days_supadmin') }}" id="cform" method="POST" >
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
                                                <select name="batchname" id="batchname" onchange="return batchValidation()" class="form-control">
                                                    <option style="text-align: left" value="" disabled selected>--- Select batch ---</option>

                                                </select>
                                                
                                                @if ($errors->has('batchname'))
                                                    <span class="text-danger">{{ $errors->first('batchname') }}</span>
                                                @endif
                                                <span id="batchname-error" class="text-danger"></span>

                                            </div>

                                            <div class="form-group mb-6">
                                                <label for="simpleinput"><b style="color: black;">Module Name</b></label>
                                                <select name="modulename" id="modulename" onchange="return myModuleFunction()" class="form-control">
                                                    <option style="text-align: left" value="" disabled selected>--- Select module ---</option>
                                                    @if(isset($module_data))
                                                        @foreach($module_data as $data)
    
                                                            <option align="left" value="{{$data->mId}}" {{ $data->mId == session('mid') ? 'selected' : '' }} id="mId" align="center">
    
                                                            
                                                                {{ $data->mName}}</option>
    
                                                        @endforeach
                                                    @endif
    
                                                </select>
                                                
                                                @if ($errors->has('modulename'))
                                                    <span class="text-danger">{{ $errors->first('modulename') }}</span>
                                                @endif
                                                <span id="modulename-error" class="text-danger"></span>

                                            </div>
                       {{-- ---------------------------------------------------------------------------                     --}}
                                    
                                           
                                            <div class="form-group mb-6">
                                                <label for="simpleinput"><b style="color: black;">Sub Module Name</b></label>
                                                @if ($errors->has('submodule'))
                                                    <span class="text-danger">{{ $errors->first('submodule') }}</span>
                                                @endif
                                               
                                            </div>
                                            
                                            <div class="form-check">
                                                <input type="checkbox" id="halfCheckbox" onclick="return submoduleValidation()">
                                            </div>
                                            
                                            <div id="resultDiv">
                                                <!-- The checkboxes will be appended here -->
                                            </div>
                                            
                                            <span id="submodule-error" class="text-danger"></span>
                                            
                                            <br>

                                            
                                           

                        {{-- --------------------------------------------------------------------                   --}}

                                            <div class="row">

                                               
                                                
                                                <div class="col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Day Name</b></label>
                                                        <div class="input-group">
                                                            {{-- <div class="input-group-append">
                                                                <span class="input-group-text">DAY</span>
                                                            </div> --}}

                                                            <input type="text" id="dayname" name="dayname" value="{{old('dayname')}}" placeholder="Enter day" onkeyup="return dayValidation()" class="form-control">
                                                            
                                                        </div>
                                                        @if ($errors->has('dayname'))
                                                            <span class="text-danger">{{ $errors->first('dayname') }}</span>
                                                        @endif
                                                        <span id="dayname-error" class="text-danger"></span><br>
                                                        <span id="daynameLAST-error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                               
                                               
                                                <div class="col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Exam Day</b></label><br>
                                                        <input type="checkbox" name="isExam[]" id="isExam" value="1" class="single-checkbox"><br>
                                                
                                                        <span id="isExam-error"  class="text-danger">* use only for exam day.</span>
                                                    </div>
                                                </div>
                                                
                                                &nbsp;&nbsp;

                                                <div class="col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Date</b></label>
                                                        <input type="date" id="activedate" name="activedate" value="{{old('activedate')}}" onchange="return activedateValidation()" class="form-control" >
                                                        @if ($errors->has('activedate'))
                                                            <span class="text-danger">{{ $errors->first('activedate') }}</span>
                                                        @endif
                                                        <span id="activedate-error" class="text-danger"></span>
                                                    </div>
                                                </div>

                                              
                                              
                                               

                                                
                                            </div>





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
                                <h2 class="page-title"> Batches Wise Day Activities We Have</h2>
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
                                                        
                                                       
                                                        <th style="color: black;"><b>Course Name</b></th>
                                                        
                                                        <th style="color: black;"><b>Batch Name</b></th>
                                                        <th style="color: black;"><b>Duration</b></th>
                                                        {{-- <th style="color: black;"><b>Module Name</b></th>
                                                        <th style="color: black;"><b>Submodule Name</b></th> --}}
                                                        <th style="color: black;"><b>Added Days</b></th> 
                                                        
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($batch_days_details))
                                                        @php $i=1 @endphp
                                                        @foreach ($batch_days_details as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b></td>
                                                           
                                                               
                                                                <td width="80">{{ wordwrap($item->coName,20,"\n",TRUE) }}</td>
                                                                <td width="90">{{ wordwrap($item->cbatchName,50,"\n",TRUE) }}</td>
                                                                <td width="90">{{$item->duration}}  DAYS</td>
                                                                {{-- <td width="90">{{ wordwrap($item->mName,50,"\n",TRUE) }}</td>
                                                                <td width="90">{{ wordwrap($item->smName,50,"\n",TRUE) }}</td> --}}
                                                                <td width="90" >{{ $item->total_days }} - DAYS</td>
                                                                
                                                               
                                                                <td width="60">
                                                                    <abbr style="text-decoration: none;"  title="View More "><a href="{{url('viewmoredayssupadmin_act'.$item->cbId)}}" style="text-decoration: none;">View
                                                                    </a></abbr>
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



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
         document.addEventListener('DOMContentLoaded', function() {
        const activedateInput = document.getElementById('activedate');
        const today = new Date().toISOString().split('T')[0]; // Get today's date in the format "YYYY-MM-DD"
        activedateInput.value = today;
    });
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



<?php if(!empty(session('smId'))){
    $moduleid=session('smId');
// print_r($batchid);die;

}
else{
    $moduleid="";
}?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                function myModuleFunction(){

                    $(document).ready(function() {

                        var modulename = document.getElementById('modulename').value;
                   

                        if (modulename == null || modulename == "") {
                            document.getElementById("modulename-error").innerHTML = "This field is required.";
                            return false;
                        } 
                        else{
                            document.getElementById("modulename-error").innerHTML = "";
                           // MainValidation();
                        }

                });

                var modulename = document.getElementById('modulename').value;

                        var sel = null;
                        var smid='<?php echo $moduleid; ?>';
                        console.log(smid);


            $.ajax({

            url: "{{url('/checkingmodulewise_submodule_superadmin')}}",

            type: "GET",

            data: {

                mId: modulename,

                _token: '{{csrf_token()}}'

            },

            success: function(result) {

                if (result) {
            if (result.length > 0) {
                // Clear any existing error messages
                $('#submodule-error').empty();
                $("#resultDiv").empty();

                    var rowDiv;
                    var smidArray = smid.split(',');

                    $.each(result, function (key, value) {
                        // Create a new row div after every two checkboxes
                        if (key % 2 === 0) {
                            rowDiv = $("<div class='row mb-2'></div>");
                            $("#resultDiv").append(rowDiv);
                        }

                       
                        var checkbox = "<div class='col-md-6'><input type='checkbox' id='chk-" + key + "' name='submodule[]' value='" + value.smId + "' onclick='submoduleValidation()' /> " + value.smName + "</div>";
                        if (smidArray.includes(value.smId.toString())) {
                        checkbox = checkbox.replace("type='checkbox'", "type='checkbox' checked");
                         }
                        rowDiv.append(checkbox);
                    });
                    


                // Clear any previous error messages
                document.getElementById("submodule-error").innerHTML = "";
               
            }else{

                                    $('#submodule').empty();
                                    $("#resultDiv").empty();
                            //alert("");
                            document.getElementById("submodule-error").innerHTML = "No Sub Module found for the selected course.";

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

                url: "{{url('/checkingcoursenamewisebatch_days_superadmin')}}",

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


   <script>
     function batchValidation()
        {
            $(document).ready(function() {
           
            var batchname = document.getElementById('batchname').value;

            if (batchname == null || batchname == "") {
                document.getElementById("batchname-error").innerHTML = "This field is required.";
                return false;
            } 
            else{
                document.getElementById("batchname-error").innerHTML = "";
                
               // MainValidation();
            }
        });

        var batchname = document.getElementById('batchname').value;

           if(batchname=="")
           {
            var batchname='<?php echo $batchid; ?>';
           }
            

            $.ajax({

            url: "{{url('/lastaddeddayTake_superadmin')}}",

            type: "GET",

            data: {

            cbId: batchname,

            _token: '{{csrf_token()}}'

            },

            success: function(result) {
                if (result) {
   
          document.getElementById("daynameLAST-error").innerHTML = "Last added day name : "+ result.dayName + ".";

                   
                } else {
                  
                    document.getElementById("daynameLAST-error").innerHTML = "";
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

       
         
        function submoduleValidation() {
            var checkboxes = document.querySelectorAll('input[name="submodule[]"]:checked');
           // alert("hai");
            if (checkboxes.length === 0) {
                document.getElementById("submodule-error").innerHTML = "Please select at least one submodule.";
                return false; // To prevent form submission if validation fails
            } else {
                document.getElementById("submodule-error").innerHTML = "";
                MainValidation();
                //return true; // Allow form submission since validation passed
            }
        }

        function dayValidation()
        {
            var dayname = document.getElementById('dayname').value;

            if (dayname == null || dayname == "") {
                document.getElementById("dayname-error").innerHTML = "This field is required.";
                return false;
            } 
           
            else{
                document.getElementById("dayname-error").innerHTML = "";
                document.getElementById("daynameLAST-error").innerHTML = "";
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
            var modulename = document.getElementById('modulename').value;

            var checkboxes = document.querySelectorAll('input[name="submodule[]"]:checked');

            var dayname = document.getElementById('dayname').value;
            var activedate = document.getElementById('activedate').value;
           
            
            if (coursename == null || coursename == "") {
                document.getElementById("coursename-error").innerHTML = "This field is required.";
                return false;
            } 
            if (batchname == null || batchname == "") {
                document.getElementById("batchname-error").innerHTML = "This field is required.";
                return false;
            }
            if (modulename == null || modulename == "") {
                document.getElementById("modulename-error").innerHTML = "This field is required.";
                return false;
            } 
           
            if (checkboxes.length === 0) {
                document.getElementById("submodule-error").innerHTML = "Please select at least one submodule.";
                return false; // To prevent form submission if validation fails
            } 
            if (dayname == null || dayname == "") {
                document.getElementById("dayname-error").innerHTML = "This field is required.";
                return false;
            } 
            if (activedate == null || activedate == "") {
                document.getElementById("activedate-error").innerHTML = "This field is required.";
                return false;
            } 
                     
            
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
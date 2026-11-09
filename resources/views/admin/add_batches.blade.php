@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        
                         <div class="row">
                            <div class="col-6">
                               <h2 class="page-title">Add Batches</h2>
                            </div>
                            <div class="col-6 text-right">
                                <a href="/addstunentsupadminstobatch" class="btn btn-primary custom-btn-height">create STUDENTS TO BATCHES</a>
                            </div> 
                          </div>

                          <style>
                            .custom-btn-height {
                              height: 30px;
                            }
                          
                          </style>

                        <form action="{{ url('/save_batch_dta_superadmin') }}" id="cform" method="POST" >
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
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Course Name</b></label>
                                                <select name="coursename" id="coursename" onchange="return coursenameValidation()" class="form-control">
                                                    <option style="text-align: center" value="" disabled selected>--- Select course ---</option>
                                                    @if(isset($course_data))
                                                        @foreach($course_data as $data)
    
                                                            <option value="{{$data->cmId}}" {{ $data->cmId == session('cmid') ? 'selected' : '' }} id="cmId" align="center">
    
                                                            
                                                                {{ $data->coName}}</option>
    
                                                        @endforeach
                                                    @endif
    
                                                </select>
                                                @if ($errors->has('coursename'))
                                                    <span class="text-danger">{{ $errors->first('coursename') }}</span>
                                                @endif
                                                <span id="coursename-error" class="text-danger"></span>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Batch Name</b></label>
                                                <input type="text" id="batchname" name="batchname" value="{{old('batchname')}}" placeholder="Enter batch name" onkeyup="return batchnameValidation()"  class="form-control" >
                                                @if ($errors->has('batchname'))
                                                    <span class="text-danger">{{ $errors->first('batchname') }}</span>
                                                @endif
                                                <span id="batchname-error" class="text-danger"></span>

                                            </div>
                                           

                                          

                                            <div class="row">
                                                <div class="col-md-2 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Batch Start Date</b></label>
                                                        <input type="date" id="startdate" name="startdate" value="{{old('startdate')}}" onchange="return startdateValidation()" class="form-control" >
                                                        @if ($errors->has('startdate'))
                                                            <span class="text-danger">{{ $errors->first('startdate') }}</span>
                                                        @endif
                                                        <span id="startdate-error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            
                                                &nbsp;
                                                <div class="col-md-2 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Batch End Date</b></label>
                                                        <input type="date" id="enddate" name="enddate" value="{{old('enddate')}}" onchange="return enddateValidation()" class="form-control" >
                                                        @if ($errors->has('enddate'))
                                                            <span class="text-danger">{{ $errors->first('enddate') }}</span>
                                                        @endif
                                                        <span id="enddate-error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            
                                              
                                                <div class="col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Batch Duration</b></label>
                                                        <div class="input-group">
                                                            <input type="number" id="batchdays" name="batchdays" value="{{old('batchdays')}}" placeholder="Enter batch duration" onkeyup="return batchdaysValidation()" class="form-control">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Days</span>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('batchdays'))
                                                            <span class="text-danger">{{ $errors->first('batchdays') }}</span>
                                                        @endif
                                                        <span id="batchdays-error" class="text-danger"></span>
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
                                <h2 class="page-title">Batches We Have</h2>
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
                                                        <th style="color: black;"><b>Start Date</b></th>
                                                        <th style="color: black;"><b>End Date</b></th>
                                                        <th style="color: black;"><b>Duration</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($batch_details))
                                                        @php $i=1 @endphp
                                                        @foreach ($batch_details as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b>
                                                                </td>
                                                                <td  width="10" > @if( $item->isClosed==0)
                                                                        <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                    @endif
                                                                    @if( $item->isClosed==1)
                                                                        <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                    @endif
                                                                </td>
                                                                <td width="80">{{ wordwrap($item->coName,20,"\n",TRUE) }}</td>
                                                                <td width="90">{{ wordwrap($item->cbatchName,50,"\n",TRUE) }}</td>
                                                                <td width="60">{{ $item->cbatchStartDate }}</td>
                                                                <td width="60">{{ $item->cbatchEndDate }}</td>
                                                                <td width="60">{{ $item->cbatchDays }} Days</td>
                                                                <td width="60">

                                                                     @php 
                                                                     $encryptedId = Crypt::encrypt($item->cbId);
                                                                    @endphp

                                                                    <abbr style="text-decoration: none;" title="Edit Batch"><a href="{{url('updatesupadminbatch'.$encryptedId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                    &nbsp;

                                                                    @php 
                                                                    $cbId = Crypt::encrypt($item->cbId);
                                                                   @endphp

                                                                    @if( $item->isClosed==0)
                                                                        <abbr style="text-decoration: none;"  title="Deactivate Batch"><a href="{{url('batchdisable_superadmin/'.$cbId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                    @endif
                                                                    @if( $item->isClosed==1)
                                                                        <abbr style="text-decoration: none;" title="Activate Batch"> <a href="{{url('batchenable_superadmin/'.$cbId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                    @endif
                                                                    &nbsp;

                                                                    @php 
                                                                    $encrypted = Crypt::encrypt($item->cbId);
                                                                   @endphp
                                                                    <abbr style="text-decoration: none;"  title="Delete Batch "><a href="{{url('batchdelete_superadmin/'.$encrypted)}}" onclick="deleteItem(event, this)" style="text-decoration: none;"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i>
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







    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->

    <script>
        function coursenameValidation()
        {
            var coursename = document.getElementById('coursename').value;
           // alert(coursename);

            if (coursename == null || coursename == "") {
                document.getElementById("coursename-error").innerHTML = "This field is required.";
                return false;
            } 
            else{
                document.getElementById("coursename-error").innerHTML = "";
                MainValidation();
            }

        }

        function batchnameValidation()
        {
            var batchname = document.getElementById('batchname').value;

            if (batchname == null || batchname == "") {
                document.getElementById("batchname-error").innerHTML = "This field is required.";
                return false;
            }
            else{
                document.getElementById("batchname-error").innerHTML = "";
                MainValidation();
            }
        }

        function startdateValidation()
        {
            var startdate = document.getElementById('startdate').value;

            if (startdate == null || startdate == "") {
                document.getElementById("startdate-error").innerHTML = "This field is required.";
                return false;
            } 
           
            else{
                document.getElementById("startdate-error").innerHTML = "";
                MainValidation();
            }
        }

        function enddateValidation()
        {
            var enddate = document.getElementById('enddate').value;

            if (enddate == null || enddate == "") {
                document.getElementById("offerprice-error").innerHTML = "This field is required.";
                return false;
            } 
           
            else{
                document.getElementById("enddate-error").innerHTML = "";
                MainValidation();
            }
        }

        function batchdaysValidation()
        {
            var batchdays = document.getElementById('batchdays').value;

            if (batchdays == null || batchdays == "") {
                document.getElementById("batchdays-error").innerHTML = "This field is required.";
                return false;
            }  
            else{
                document.getElementById("batchdays-error").innerHTML = "";
                MainValidation();
            }

        }
        </script>


    <script>
        function MainValidation()
        {
            var coursename = document.getElementById('coursename').value;
            var batchname = document.getElementById('batchname').value;
            var startdate = document.getElementById('startdate').value;
            var enddate = document.getElementById('enddate').value;
            var batchdays = document.getElementById('batchdays').value;
            
            if (coursename == null || coursename == "") {
                document.getElementById("coursename-error").innerHTML = "This field is required.";
                return false;
            } 
            if (batchname == null || batchname == "") {
                document.getElementById("batchname-error").innerHTML = "This field is required.";
                return false;
            }
            if (startdate == null || startdate == "") {
                document.getElementById("startdate-error").innerHTML = "This field is required.";
                return false;
            } 
            if (enddate == null || enddate == "") {
                document.getElementById("enddate-error").innerHTML = "This field is required.";
                return false;
            } 
            if (batchdays == null || batchdays == "") {
                document.getElementById("batchdays-error").innerHTML = "This field is required.";
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

    document.getElementById('startdate').setAttribute('min', today);
   
    document.getElementById('enddate').setAttribute('min', today);
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
                title: 'Are you sure to deactivate this batch?',
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
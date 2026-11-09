@extends('staffAdmin.staffAdminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Course</h2>

                        <form action="{{ url('/save_course_dta') }}" id="cform" method="POST" >
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
                                                <input type="text" id="coursename" name="coursename" value="{{old('coursename')}}" placeholder="Enter course name" onkeyup="return coursenameValidation()" class="form-control" >
                                                @if ($errors->has('coursename'))
                                                    <span class="text-danger">{{ $errors->first('coursename') }}</span>
                                                @endif
                                                <span id="coursename-error" class="text-danger"></span>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Course Description</b></label>
                                                <textarea id="coursedesc" name="coursedesc" value="{{old('coursedesc')}}" placeholder="Enter description" rows="4" cols="40" onkeyup="return courseDescValidation()" class="form-control" ></textarea>
                                                @if ($errors->has('coursedesc'))
                                                    <span class="text-danger">{{ $errors->first('coursedesc') }}</span>
                                                @endif
                                                <span id="coursedesc-error" class="text-danger"></span>

                                            </div>
                                           

                                          

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Course Active Price</b></label>
                                                        <input type="text" id="activeprice" name="activeprice" value="{{old('activeprice')}}" placeholder="Enter active price" onkeyup="return courseactivepriceValidation()" class="form-control" >
                                                        @if ($errors->has('activeprice'))
                                                            <span class="text-danger">{{ $errors->first('activeprice') }}</span>
                                                        @endif
                                                        <span id="activeprice-error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            
                                                &nbsp;
                                                <div class="col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Course Offer Price</b></label>
                                                        <input type="text" id="offerprice" name="offerprice" value="{{old('offerprice')}}" placeholder="Enter offer price" onkeyup="return courseofferpriceValidation()" class="form-control" >
                                                        @if ($errors->has('offerprice'))
                                                            <span class="text-danger">{{ $errors->first('offerprice') }}</span>
                                                        @endif
                                                        <span id="offerprice-error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            
                                               
                                                {{-- <div class="col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Course Duration</b></label>
                                                        <input type="number" id="coursedays" name="coursedays" value="{{old('coursedays')}}" placeholder="Enter course duration" onkeyup="return courseDaysValidation()" class="form-control" ><b>Days</b>
                                                        @if ($errors->has('coursedays'))
                                                            <span class="text-danger">{{ $errors->first('coursedays') }}</span>
                                                        @endif
                                                        <span id="coursedays-error" class="text-danger"></span>
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Course Duration</b></label>
                                                        <div class="input-group">
                                                            <input type="number" id="coursedays" name="coursedays" value="{{old('coursedays')}}" placeholder="Enter course duration" onkeyup="return courseDaysValidation()" class="form-control">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Days</span>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('coursedays'))
                                                            <span class="text-danger">{{ $errors->first('coursedays') }}</span>
                                                        @endif
                                                        <span id="coursedays-error" class="text-danger"></span>
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
                                <h2 class="page-title">Course We Have</h2>
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
                                                        
                                                        <th style="color: black;"><b>Course Description</b></th>
                                                        <th style="color: black;"><b>Active Price</b></th>
                                                        <th style="color: black;"><b>Offer Price</b></th>
                                                        <th style="color: black;"><b>Duration</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($course_details))
                                                        @php $i=1 @endphp
                                                        @foreach ($course_details as $item)
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
                                                                <td width="150">{{ wordwrap($item->coDescription,50,"\n",TRUE) }}</td>
                                                                <td width="60" align="right"><i style="font-size:12px" class="fa">&#xf156;</i> {{ $item->coActivePrice }}</td>
                                                                <td width="60" align="right"><i style="font-size:12px" class="fa">&#xf156;</i> {{ $item->coOfferPrice }}</td>
                                                                <td width="60" align="center">{{ $item->coDays }} Days</td>
                                                                <td width="60">

                                                                     @php 
                                                                     $encryptedId = Crypt::encrypt($item->cmId);
                                                                    @endphp

                                                                    <abbr style="text-decoration: none;" title="Edit Course"><a href="{{url('updatecourse'.$encryptedId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                    &nbsp;

                                                                    @php 
                                                                    $cmId = Crypt::encrypt($item->cmId);
                                                                   @endphp

                                                                    @if( $item->isClosed==0)
                                                                        <abbr style="text-decoration: none;"  title="Deactivate Course"><a href="{{url('coursedisable/'.$cmId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                    @endif
                                                                    @if( $item->isClosed==1)
                                                                        <abbr style="text-decoration: none;" title="Activate Course"> <a href="{{url('courseenable/'.$cmId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                    @endif
                                                                    &nbsp;

                                                                    @php 
                                                                    $encrypted = Crypt::encrypt($item->cmId);
                                                                   @endphp
                                                                    <abbr style="text-decoration: none;"  title="Delete Course "><a href="{{url('coursedelete/'.$encrypted)}}" onclick="deleteItem(event, this)" style="text-decoration: none;"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i>
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
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
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

            if (coursename == null || coursename == "") {
                document.getElementById("coursename-error").innerHTML = "This field is required.";
                return false;
            } 
            else{
                document.getElementById("coursename-error").innerHTML = "";
                MainValidation();
            }

        }

        function courseDescValidation()
        {
            var coursedesc = document.getElementById('coursedesc').value;

            if (coursedesc == null || coursedesc == "") {
                document.getElementById("coursedesc-error").innerHTML = "This field is required.";
                return false;
            }
            else{
                document.getElementById("coursedesc-error").innerHTML = "";
                MainValidation();
            }
        }

        function courseactivepriceValidation()
        {
            var activeprice = document.getElementById('activeprice').value;

            if (activeprice == null || activeprice == "") {
                document.getElementById("activeprice-error").innerHTML = "This field is required.";
                return false;
            } 
            else if (!/^\d+(\.\d+)?$/.test(activeprice)) {
            document.getElementById('activeprice-error').innerText = 'Please enter a valid price.';
            return false;
           }
            else{
                document.getElementById("activeprice-error").innerHTML = "";
                MainValidation();
            }
        }

        function courseofferpriceValidation()
        {
            var offerprice = document.getElementById('offerprice').value;

            if (offerprice == null || offerprice == "") {
                document.getElementById("offerprice-error").innerHTML = "This field is required.";
                return false;
            } 
            else if (!/^\d+(\.\d+)?$/.test(offerprice)) {
            document.getElementById('offerprice-error').innerText = 'Please enter a valid price.';
            return false;
           }
            else{
                document.getElementById("offerprice-error").innerHTML = "";
                MainValidation();
            }
        }

        function courseDaysValidation()
        {
            var coursedays = document.getElementById('coursedays').value;

            if (coursedays == null || coursedays == "") {
                document.getElementById("coursedays-error").innerHTML = "This field is required.";
                return false;
            }  
            else{
                document.getElementById("coursedays-error").innerHTML = "";
                MainValidation();
            }

        }
        </script>


    <script>
        function MainValidation()
        {
            var coursename = document.getElementById('coursename').value;
            var coursedesc = document.getElementById('coursedesc').value;
            var activeprice = document.getElementById('activeprice').value;
            var offerprice = document.getElementById('offerprice').value;
            var coursedays = document.getElementById('coursedays').value;
            
            if (coursename == null || coursename == "") {
                document.getElementById("coursename-error").innerHTML = "This field is required.";
                return false;
            } 
            if (coursedesc == null || coursedesc == "") {
                document.getElementById("coursedesc-error").innerHTML = "This field is required.";
                return false;
            }
            if (activeprice == null || activeprice == "") {
                document.getElementById("activeprice-error").innerHTML = "This field is required.";
                return false;
            } 
            if (offerprice == null || offerprice == "") {
                document.getElementById("offerprice-error").innerHTML = "This field is required.";
                return false;
            } 
            if (coursedays == null || coursedays == "") {
                document.getElementById("coursedays-error").innerHTML = "This field is required.";
                return false;
            }            
            
            else {
                return true;
                
            }
        }
        </script>












    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this course?',
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
                title: 'Are you sure to delete this Course?',
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
                title: 'Are you sure to activate course?',
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
                title: 'Are you sure to deactivate this course?',
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
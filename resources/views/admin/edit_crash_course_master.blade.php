@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Course</h2>

                        <form action="{{ url('/update_course_supadmin_dta') }}" id="cform" method="POST" >
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            <div class="card shadow mb-4">
                                @if (session('success'))
                                    <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                @endif
                                @if (session('error'))
                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                @endif

                                @if(isset($select_course_single))
                                @foreach ($select_course_single as $item)

                                <input type="hidden" name="cmId" value="{{$item->cmId}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Course Name</b></label>
                                                <input type="text" id="coursename" name="coursename" value="{{$item->coName}}" placeholder="Enter course name" onkeyup="return coursenameValidation()" class="form-control" >
                                                @if ($errors->has('coursename'))
                                                    <span class="text-danger">{{ $errors->first('coursename') }}</span>
                                                @endif
                                                <span id="coursename-error" class="text-danger"></span>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Course Description</b></label>
                                                <textarea id="coursedesc" name="coursedesc"  placeholder="Enter description" rows="4" cols="40" onkeyup="return courseDescValidation()" class="form-control" >{{$item->coDescription}}</textarea>
                                                @if ($errors->has('coursedesc'))
                                                    <span class="text-danger">{{ $errors->first('coursedesc') }}</span>
                                                @endif
                                                <span id="coursedesc-error" class="text-danger"></span>

                                            </div>
                                           

                                          

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Course Active Price</b></label>
                                                        <input type="text" id="activeprice" name="activeprice" value="{{$item->coActivePrice}}" placeholder="Enter active price" onkeyup="return courseactivepriceValidation()" class="form-control" >
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
                                                        <input type="text" id="offerprice" name="offerprice" value="{{$item->coOfferPrice}}" placeholder="Enter offer price" onkeyup="return courseofferpriceValidation()" class="form-control" >
                                                        @if ($errors->has('offerprice'))
                                                            <span class="text-danger">{{ $errors->first('offerprice') }}</span>
                                                        @endif
                                                        <span id="offerprice-error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            
                                               
                                               
                                                <div class="col-md-3 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Course Duration</b></label>
                                                        <div class="input-group">
                                                            <input type="number" id="coursedays" name="coursedays" value="{{$item->coDays}}" placeholder="Enter course duration" onkeyup="return courseDaysValidation()" class="form-control">
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

                    
                    @endforeach
                    @endif


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
    
    

@endsection
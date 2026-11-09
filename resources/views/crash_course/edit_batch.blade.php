@extends('staffAdmin.staffAdminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Batches</h2>

                        <form action="{{ url('/update_batch_dta') }}" id="cform" method="POST" >
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            <div class="card shadow mb-4">
                                @if (session('success'))
                                    <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                @endif
                                @if (session('error'))
                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                @endif

                                @if(isset($select_batch_single))
                                @foreach($select_batch_single as $item)

                                <input type="hidden" name="cbId" value="{{$item->cbId}}">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Course Name</b></label>
                                                <select name="coursename" id="coursename" onchange="return coursenameValidation()" class="form-control">
                                                    <option style="text-align: center" value="" disabled selected>--- Select course ---</option>
                                                   @if(isset($select_course_details))
                                                   @foreach($select_course_details as $data)
    
                                                            <option value="{{$data->cmId}}"{{ $data->cmId == $item->cmId ? 'selected' : '' }} id="cmId" align="center"> {{ $data->coName}}</option>
    
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
                                                <input type="text" id="batchname" name="batchname" value="{{$item->cbatchName}}" placeholder="Enter batch name" onkeyup="return batchnameValidation()"  class="form-control" >
                                                @if ($errors->has('batchname'))
                                                    <span class="text-danger">{{ $errors->first('batchname') }}</span>
                                                @endif
                                                <span id="batchname-error" class="text-danger"></span>

                                            </div>
                                           

                                          

                                            <div class="row">
                                                <div class="col-md-2 mb-1">
                                                    <div class="form-group">
                                                        <label for="simpleinput"><b style="color: black;">Batch Start Date</b></label>
                                                        <input type="date" id="startdate" name="startdate" value="{{$item->cbatchStartDate}}" onchange="return startdateValidation()" class="form-control" >
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
                                                        <input type="date" id="enddate" name="enddate" value="{{$item->cbatchEndDate}}" onchange="return enddateValidation()" class="form-control" >
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
                                                            <input type="number" id="batchdays" name="batchdays" value="{{$item->cbatchDays}}" placeholder="Enter batch duration" onkeyup="return batchdaysValidation()" class="form-control">
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
      @endforeach
      @endif
                    <br>

                  

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





{{-- <script>
    // Get the current date
    const today = new Date().toISOString().split('T')[0];

    document.getElementById('startdate').setAttribute('min', today);
   
    document.getElementById('enddate').setAttribute('min', today);
</script> --}}






    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    

@endsection
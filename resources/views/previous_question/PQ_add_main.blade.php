@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Exam Type</h2>

                        <form action="{{ url('addpqmain') }}" id="cform" method="POST" onsubmit="return examValidation()">
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
                                                <input type="text" id="examName" name="examName" value="{{old('examName')}}" placeholder="Enter exam name" onkeyup="return examValidation()" class="form-control" >
                                                @if ($errors->has('examName'))
                                                    <span class="text-danger">{{ $errors->first('examName') }}</span>
                                                @endif
                                                <span id="pqmname-error" class="text-danger"></span>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Score</b></label>
                                                <input type="text" id="positiveMark" name="positiveMark" value="{{old('positiveMark')}}" placeholder="Enter exam score" onkeyup="return positiveMarkValidation()" class="form-control" required>
                                                @if ($errors->has('positiveMark'))
                                                    <span class="text-danger">{{ $errors->first('positiveMark') }}</span>
                                                @endif
                                                <span id="positiveMark-error" class="text-danger"></span>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Negative Score</b></label>
                                                <input type="text" id="negativeMark" name="negativeMark" value="{{old('negativeMark')}}" placeholder="Enter exam negative score" onkeyup="return negativeMarkValidation()" class="form-control" required >
                                                @if ($errors->has('negativeMark'))
                                                    <span class="text-danger">{{ $errors->first('negativeMark') }}</span>
                                                @endif
                                                <span id="negativeMark-error" class="text-danger"></span>

                                            </div>
                                            <button type="submit" id="btn"  class="btn btn-primary" disabled>SAVE</button>
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
                                                        <th></th>
                                                        <th style="color: black;"><b>EXAM NAME</b></th>
                                                        <th style="color: black;"><b>Score</b></th>
                                                        <th style="color: black;"><b>Negative Score</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($examtype))
                                                        @php $i=1 @endphp
                                                        @foreach ($examtype as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b>
                                                                </td>
                                                                <td  width="20" > @if( $item->isAvail==0)
                                                                        <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                    @endif
                                                                    @if( $item->isAvail==1)
                                                                        <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                    @endif
                                                                </td>
                                                                <td width="100">{{ wordwrap($item->pqmainName,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{ wordwrap($item->positiveMark,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{ wordwrap($item->negativeMark,20,"\n",TRUE) }}</td>
                                                                <td width="100">
                                                                    <abbr style="text-decoration: none;" title="Edit Exam Type"><a href="{{url('updatePQmain'.$item->pqmainId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                    &nbsp;
                                                                    @if( $item->isAvail==0)
                                                                        <abbr style="text-decoration: none;"  title="Deactivate Catagory"><a href="{{url('ExamTypeDisable/'.$item->pqmainId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                    @endif
                                                                    @if( $item->isAvail==1)
                                                                        <abbr style="text-decoration: none;" title="Activate Catagory"> <a href="{{url('ExamTypeEnable/'.$item->pqmainId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                    @endif
                                                                    &nbsp;
                                                                    <abbr style="text-decoration: none;"  title="Delete Exam "><a href="{{url('examMainDelete/'.$item->pqmainId)}}" onclick="deleteItem(event, this)" style="text-decoration: none;"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i>
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
    <!---------------FORM JAVASCRIPT VALIDATION FOR Module Code-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function examValidation() {
            $(document).ready(function () {
    
                let examName = document.getElementById('examName').value;
                let length2 = examName.length;
                var validationFailed = false;
    
                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]/;
    
                if (examName == null || examName == "") {
                    document.getElementById("pqmname-error").innerHTML = "This field is required.";
                    return false;
                } else {
                    document.getElementById("pqmname-error").innerHTML = "";
                }
    
                if (examName.match(format)) {
                    document.getElementById("pqmname-error").innerHTML = "Restriction for numbers and symbols.";
                    return false;
                } else if (length2 < 2) {
                    document.getElementById("pqmname-error").innerHTML = "At least 2 characters.";
                    return false;
                } else if (length2 > 50) {
                    document.getElementById("pqmname-error").innerHTML = "Only 50 characters.";
                    return false;
                } else {
                    document.getElementById("pqmname-error").innerHTML = "";
                }
    
                $.ajax({
                    url: "{{url('/pqmainNameCheck')}}",
                    type: "GET",
                    data: {
                        pqmainName: examName,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result && result[0] != null) {
                            //module name has a value to another module
                            document.getElementById("pqmname-error").innerHTML = "Exam name is already taken.";
                            //return false;
                            validationFailed = true;
                        } else {
                            // All validations passed
                            document.getElementById('btn').removeAttribute('disabled');
                        }
                    }
                });

                if (validationFailed) {
                    return false;  // Terminate the execution of the outer function
                }
                
    
            });
    
        }
    </script>
    <script>
    function positiveMarkValidation() {
        $(document).ready(function () {
    
            let positiveMark = document.getElementById('positiveMark').value;
            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?]/;
    
            if (positiveMark == null || positiveMark == "") {
                //alert(positiveMark);
                document.getElementById("positiveMark-error").innerHTML = "This field is required.";
                document.getElementById("btn").disabled = true; // Disable the save button
                return false;
            }
            if (positiveMark.match(format)) {
                document.getElementById("positiveMark-error").innerHTML = "Restriction for symbols.";
                document.getElementById("btn").disabled = true; // Disable the save button
                return false;
            }  else {
                document.getElementById("positiveMark-error").innerHTML = "";
                document.getElementById("btn").disabled = false; // Enable the save button
            }
        });
    }
    </script>
    
    <script>
        function negativeMarkValidation() {
            $(document).ready(function () {
    
               // let examName = document.getElementById('examName').value;
               // let positiveMark = document.getElementById('positiveMark').value;
                let negativeMark = document.getElementById('negativeMark').value;
                //let length2 = examName.length;
    
                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?]/;
 
                if (negativeMark == null || negativeMark == "") {
                    document.getElementById("negativeMark-error").innerHTML = "This field is required.";
                    document.getElementById("btn").disabled = true;
                    return false;
                } 
                if (negativeMark.match(format)) {
                document.getElementById("negativeMark-error").innerHTML = "Restriction for symbols.";
                document.getElementById("btn").disabled = true; // Disable the save button
                return false;
                } 
                else {
                    document.getElementById("negativeMark-error").innerHTML = "";
                    document.getElementById("btn").disabled = false;
                }
 
    
            });
    
        }
    </script>
    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this exam type?',
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
                title: 'Are you sure to delete this exam type?',
                text: 'All category and subcategory,questions will be deleted under this exam type!',
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
                title: 'Are you sure to activate exam type?',
                text: 'All category  will be activated under this exam type!',
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
                title: 'Are you sure to deactivate this exam type?',
                text: 'All category  will be deactivated under this exam type!',
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
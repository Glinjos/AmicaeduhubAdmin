@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Video Class Module</h2>

                        <form action="{{ url('addvcmodule') }}" id="cform" method="POST" onsubmit="return submitcheck()">
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
                                            {{-- <div class="form-group mb-3">
                                            <b style="color: black;">Exam Type</b>
                                            <select name="examType" id="examType" class="form-control" onchange="return submitcheck()">
                                                <option style="text-align: center" disabled selected value=" ">--- Select exam type---</option>
                                                @if(isset($select1))
                                                    @foreach($select1 as $data)

                                                        <option value="{{$data->pqmainId}}" {{ $data->pqmainId == session('pqmainId') ? 'selected' : '' }} id="demo" align="center">

                                                            {{ $data->pqmainName}}</option>

                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('examType'))
                                                    <span class="text-danger">{{ $errors->first('examType') }}</span>
                                                @endif
                                            <span id="pqmainname-error" class="text-danger"></span>
                                        </div> --}}
                                       
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Subject</b></label>
                                                <input type="text" id="subjectName" name="subjectName" value="{{old('subjectName')}}" placeholder="Enter subject name" onkeyup="return submitcheck()" class="form-control" >
                                                @if ($errors->has('subjectName'))
                                                    <span class="text-danger">{{ $errors->first('subjectName') }}</span>
                                                @endif
                                                <span id="vcmname-error" class="text-danger"></span>

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
                                <h2 class="page-title">Subjects We Have</h2>
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
                                                        {{-- <th style="color: black;"><b>EXAM TYPE</b></th> --}}
                                                        <th style="color: black;"><b>Subject Name</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                       
                                                    @if(isset($select2))
                                                   
                                                        @php $i=1 @endphp
                                                        @foreach ($select2 as $item)
                                                       
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
                                                                
                                                                {{-- <td width="300">{{ wordwrap($item->pqmainName,20,"\n",TRUE) }}</td> --}}
                                                                
                                                                <td width="300">{{ wordwrap($item->vcmName,20,"\n",TRUE) }}</td>
                                                                
                                                                
                                                                
                                                                <td width="100">
                                                                    <abbr style="text-decoration: none;" title="Edit Subject"><a href="{{url('updatesubject'.$item->vcmId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                    &nbsp;
                                                                    @if( $item->isAvail==0)
                                                                        <abbr style="text-decoration: none;"  title="Deactivate Subject"><a href="{{url('subjectDisable/'.$item->vcmId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                    @endif
                                                                    @if( $item->isAvail==1)
                                                                        <abbr style="text-decoration: none;" title="Activate Subject"> <a href="{{url('subjectEnable/'.$item->vcmId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                    @endif
                                                                    &nbsp;
                                                                    <abbr style="text-decoration: none;"  title="Delete Subject"><a href="{{url('subjectDelete/'.$item->vcmId)}}" onclick="deleteItem(event, this)" style="text-decoration: none;"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    {{-- <script>
        function categoryValidation()
        {
           $(document).ready(function () {

            // var examType = document.getElementById('examType').value; 
             subjectName = document.getElementById('subjectName').value;
           // console.log(examType);
           // console.log(subjectName);
           
            let length2 = subjectName.length;

           // var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;

            // if (examType == null||examType==" ") {
                 
            //      document.getElementById("pqmainname-error").innerHTML = "This field is required.";
            //      return false;
            //  } 
            //  else {
            // document.getElementById("pqmainname-error").innerHTML = "";
            // }
           if (subjectName == null||subjectName==""){
               document.getElementById("vcmname-error").innerHTML = "This field is required.";
               return false;
           }
 
            // else if( subjectName.match(format)){
            //     document.getElementById("vcmname-error").innerHTML = "Restriction for numbers and symbols.";
            //     return false;

            // }
            else if(length2<2){
                document.getElementById("vcmname-error").innerHTML = "At leas 2 characters.";
                return false;
            }else if(length2>50) {
                document.getElementById("vcmname-error").innerHTML = "Only 50 characters.";
                return false;
            }else{
                document.getElementById("vcmname-error").innerHTML = "";

            }
            
            $.ajax({
                url: "{{url('/vcmNameCheck')}}",
                type: "GET",
                data: {
                   // pqmainId : examType,
                    vcmName: subjectName,
                    _token: '{{csrf_token()}}'
                },
               success: function (result) {


                    if (result[0] != null) {

                        //module name have a value to another module
                        document.getElementById("vcmname-error").innerHTML = "Subject name is already taken.";
                        return false;
                    } else {
                        //have to go
                    }
                }
            });

                $("#btn").on("click", function() {
                    $(this).attr("disabled", "disabled");

                    //this method contains your logic
                    $(this).html("Saving...");

                    $("#cform").submit()


                });
            });


            
          

        }
    </script> --}}
    <script>
        function submitcheck(){
           // var examType = document.getElementById('examType').value; 
            subjectName = document.getElementById('subjectName').value;
            let length2 = subjectName.length;
           // var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;
        
            // if (examType == null || examType == " ") {
            //     document.getElementById("pqmainname-error").innerHTML = "This field is required.";
            //     return false;
            // } else {
            //     document.getElementById("pqmainname-error").innerHTML = "";
            // }
        
            if (subjectName == null || subjectName == "") {
                document.getElementById("vcmname-error").innerHTML = "This field is required.";
                return false;
            }
            //  else if (subjectName.match(format)) {
            //     document.getElementById("vcmname-error").innerHTML = "Restriction for numbers and symbols.";
            //     return false;
            // }
             else if (length2 < 2) {
                document.getElementById("vcmname-error").innerHTML = "At least 2 characters.";
                return false;
            } else if (length2 > 50) {
                document.getElementById("vcmname-error").innerHTML = "Only 50 characters.";
                return false;
            } else {
                document.getElementById("vcmname-error").innerHTML = "";
            }
        
            $.ajax({
                url: "{{url('/vcmNameCheck')}}",
                type: "GET",
                data: {
                    //pqmainId:examType,
                    vcmName: subjectName,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result[0] != null) {
                        document.getElementById("vcmname-error").innerHTML = "Subject name is already taken.";
                        document.getElementById('btn').disabled = true;

                        return false;
                    } else {
                        // All validations passed
                        document.getElementById('btn').removeAttribute('disabled');
                    }
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
                title: 'Are you sure to edit this subject?',
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
                title: 'Are you sure to delete this subject?',
                text: 'All chapters and questions will be deleted under this subject!',
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
                title: 'Are you sure to activate subject?',
                text: 'All chapters and questions will be activated under this subject!',
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
                title: 'Are you sure to deactivate this subject?',
                text: 'All chapters and questions will be deactivated under this subject!',
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
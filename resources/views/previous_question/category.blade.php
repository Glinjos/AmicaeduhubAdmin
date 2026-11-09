@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Category</h2>

                        <form action="{{ url('addCategory') }}" id="cform" method="POST" onsubmit="return submitcheck()">
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
                                        </div>
                                       
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Exam Year</b></label>
                                                <input type="text" id="CategoryName" name="CategoryName" value="{{old('CategoryName')}}" placeholder="Enter category name" onkeyup="return submitcheck()" class="form-control" >
                                                @if ($errors->has('CategoryName'))
                                                    <span class="text-danger">{{ $errors->first('CategoryName') }}</span>
                                                @endif
                                                <span id="pqmname-error" class="text-danger"></span>

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
                                <h2 class="page-title">Category We Have</h2>
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
                                                        <th style="color: black;"><b>EXAM TYPE</b></th>
                                                        <th style="color: black;"><b>Exam Year</b></th>
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
                                                                
                                                                <td width="250">{{ wordwrap($item->pqmainName,20,"\n",TRUE) }}</td>
                                                                
                                                                <td width="250">{{ wordwrap($item->pqmName,20,"\n",TRUE) }}</td>
                                                                
                                                                
                                                                
                                                                <td width="100">
                                                                    <abbr style="text-decoration: none;" title="Edit Category"><a href="{{url('updateCategory'.$item->pqmId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                    &nbsp;
                                                                    @if( $item->isAvail==0)
                                                                        <abbr style="text-decoration: none;"  title="Deactivate Catagory"><a href="{{url('CategoryDisable/'.$item->pqmId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                    @endif
                                                                    @if( $item->isAvail==1)
                                                                        <abbr style="text-decoration: none;" title="Activate Catagory"> <a href="{{url('CategoryEnable/'.$item->pqmId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                    @endif
                                                                    &nbsp;
                                                                    <abbr style="text-decoration: none;"  title="Delete Category"><a href="{{url('categoryDelete/'.$item->pqmId)}}" onclick="deleteItem(event, this)" style="text-decoration: none;"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i>
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


    <script>
      

        $(document).ready(function() {
                function handleModuleChange() {
                    var selectedVal = $('#examType').val();
                
                    if (selectedVal === null) {
                    return;
                    }
                   // var numericValue = selectedVal.match(/\d+/)[0];
                    var baseUrl = '{{ url('') }}';

                    $.ajax({
                        type: 'get',
                        url: baseUrl + '/searchexmtypecategory',
                        data: {
                            'selvalue': selectedVal
                        },
                        success: function(data) {
                            var tableBody = $('#dataTable-1 tbody');
                            tableBody.empty();

                            $.each(data, function(index, item) {
                                var row = $('<tr style="color: black;">');

                                row.append($('<td width="65">').text(item.slNo));
                                row.append($('<td width="20">').html('<b style="color: ' + item.isAvail + '; font-size: 30px">&#x2022;</b>'));
                                row.append($('<td width="300">').text(item.pqmainName));
                                row.append($('<td width="300">').text(item.pqmName));
                               
                                row.append($('<td width="100">').html(
                                    '<abbr style="text-decoration: none;" title="Edit Category">' +
                                    '<a href="' + item.editUrl + '" onclick="editItem(event, this)" style="text-decoration: none;">' +
                                    '<span class="fe fe-24 fe-edit"></span></a></abbr>' +
                                    
                                    ((item.deactivateUrl !== '') ?
                                        ('<abbr style="text-decoration: none;" title="Deactivate Category">' +
                                            '<a href="' + item.deactivateUrl + '" style="text-decoration: none;" onclick="inactiveItem(event, this)">' +
                                            '<span style="color: red;" class="fe fe-24 fe-minus-circle"></span></a></abbr>') : '') +
                                    ((item.activateUrl !== '') ?
                                        ('<abbr style="text-decoration: none;" title="Activate Category">' +
                                            '<a href="' + item.activateUrl + '" style="text-decoration: none;" onclick="activeItem(event, this)">' +
                                            '<span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>') : '') +

                                    '<abbr style="text-decoration: none;" title="Delete Sub Category">' +
                                    '<a href="' + item.deleteUrl + '" style="text-decoration: none;" onclick="deleteItem(event, this)">' +
                                    '<i class="fa fa-trash-o" style="font-size:26px;color:red"></i></a></abbr>'
                                ));

                                tableBody.append(row);
                            });

                            // console.log("success");
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }

                $('#examType').on('change', function() {
                    handleModuleChange();
                });

                // Execute the function when the document is ready
                handleModuleChange();
            });



        



        </script>












    <script>
        function categoryValidation()
        {
           $(document).ready(function () {

             var examType = document.getElementById('examType').value; 
            CategoryName = document.getElementById('CategoryName').value;
           // console.log(examType);
           // console.log(CategoryName);
           
            let length2 = CategoryName.length;

           // var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;

            if (examType == null||examType==" ") {
                 
                 document.getElementById("pqmainname-error").innerHTML = "This field is required.";
                 return false;
             } 
             else {
            document.getElementById("pqmainname-error").innerHTML = "";
            }
           if (CategoryName == null||CategoryName==""){
               document.getElementById("pqmname-error").innerHTML = "This field is required.";
               return false;
           }
 
            // else if( CategoryName.match(format)){
            //     document.getElementById("pqmname-error").innerHTML = "Restriction for numbers and symbols.";
            //     return false;

            // }
            else if(length2<2){
                document.getElementById("pqmname-error").innerHTML = "At leas 2 characters.";
                return false;
            }else if(length2>50) {
                document.getElementById("pqmname-error").innerHTML = "Only 50 characters.";
                return false;
            }else{
                document.getElementById("pqmname-error").innerHTML = "";

            }
            
            $.ajax({
                url: "{{url('/pqmNameCheck')}}",
                type: "GET",
                data: {
                    pqmainId : examType,
                    pqmName: CategoryName,
                    _token: '{{csrf_token()}}'
                },
               success: function (result) {


                    if (result[0] != null) {

                        //module name have a value to another module
                        document.getElementById("pqmname-error").innerHTML = "Category name is already taken.";
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
    </script>
    <script>
        function submitcheck(){
            var examType = document.getElementById('examType').value; 
            CategoryName = document.getElementById('CategoryName').value;
            let length2 = CategoryName.length;
           // var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;
        
            if (examType == null || examType == " ") {
                document.getElementById("pqmainname-error").innerHTML = "This field is required.";
                return false;
            } else {
                document.getElementById("pqmainname-error").innerHTML = "";
            }
        
            if (CategoryName == null || CategoryName == "") {
                document.getElementById("pqmname-error").innerHTML = "This field is required.";
                return false;
            }
            //  else if (CategoryName.match(format)) {
            //     document.getElementById("pqmname-error").innerHTML = "Restriction for numbers and symbols.";
            //     return false;
            // }
             else if (length2 < 2) {
                document.getElementById("pqmname-error").innerHTML = "At least 2 characters.";
                return false;
            } else if (length2 > 50) {
                document.getElementById("pqmname-error").innerHTML = "Only 50 characters.";
                return false;
            } else {
                document.getElementById("pqmname-error").innerHTML = "";
            }
        
            $.ajax({
                url: "{{url('/pqmNameCheck')}}",
                type: "GET",
                data: {
                    pqmainId:examType,
                    pqmName: CategoryName,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result[0] != null) {
                        document.getElementById("pqmname-error").innerHTML = "Category name is already taken.";
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
                title: 'Are you sure to edit this category?',
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
                title: 'Are you sure to delete this category?',
                text: 'All subcategory and questions will be deleted under this category!',
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
                title: 'Are you sure to activate Category?',
                text: 'All subcategory and questions will be activated under this category!',
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
                title: 'Are you sure to deactivate this category?',
                text: 'All subcategory and questions will be deactivated under this category!',
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
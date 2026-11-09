@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Sub Category</h2>

                        <form  class="state-form" id="scform" action="{{url('/addsubcategory')}}" method="post">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            <div class="card shadow mb-4">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                                @if (session('pqmId'))
                                                    <script>
                                                        window.onload = function () {
                                                            myExamFunction();
                                                            myFunction();
                                                           // handleModuleChange();  
                                                           
                                                            
                                                        };
                                                    </script>
                                                @endif

                                                @if (session('success'))
                                                <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                                @endif

                                                @if (session('error'))
                                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                                @endif



                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                           

                                            <label for="examtype"><b style="color: black">Exam Type</b></label>

                                            <select class="form-control" name="examtype" id="examtype" onChange="return myExamFunction()">

                                            <option value=" " disabled selected>--Select exam Type--</option>

                                            
                                            @foreach($select3 as $item)
                                                <option value="{{$item->pqmainId}}"  {{ $item->pqmainId == session('pqmainid') ? 'selected' : '' }} >{{$item->pqmainName}}</option>
                                            @endforeach

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select><br>


                                        <div id="category" style="display: none">  
                                             <b style="color: black;">Exam Year</b>
                                            <select name="module" id="module" onChange="return myFunction();" class="form-control">
                                              

                                            </select>
                                            <span id="category-error" class="text-danger"></span>
                                        </div>

                                            <!-- FORM---START -->
                                            <div id="btn" style="display: none">

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1"><b style="color: black;">Exam Name</b></label>
                                                    <input type="text" class="form-control" name="subCategory" id="subCategory" value="{{old('subCategory')}}" placeholder="Enter exam name"  onkeyup="return subcnameValidation()" required>
                                                    <span id="name-error" class="text-danger"></span>
                                                    @if ($errors->has('subCategory'))
                                                        <span class="text-danger">{{ $errors->first('subCategory') }}</span>
                                                    @endif
                                                </div>


                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary" id="save" type="submit" disabled>SAVE</button>



                                                </div>
                                            </div>
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->

                    &nbsp;&nbsp;&nbsp;
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <h2 class="mb-2 page-title">Sub Category We Have</h2>
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
                                                        <th style="color: black;"><b>EXAM YEAR</b></th>
                                                        <th style="color: black;"><b>EXAM NAME</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>

                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $i=1 @endphp
                                                    @foreach ($select as $item)
                                                   
                                                        <tr style="color: black;">

                                                            <td width="65"><b>{{$i++}}</b></td>
                                                            <td  width="20" > @if( $item->isAvail==0)
                                                                    <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                                @if( $item->isAvail==1)
                                                                    <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                            </td>

                                                            <td width="150">{{wordwrap($item->pqmainName,20,"\n",TRUE) }}</td>
                                                            <td width="150">{{wordwrap($item->pqmName,20,"\n",TRUE) }}</td>

                                                            <td width="250">{{ wordwrap($item->pqsmName,20,"\n",TRUE) }}</td>

                                                            <td width="100">

                                                                <abbr style="text-decoration: none;" title="Edit Sub Category"><a href="{{url('updateSubCategory'.$item->pqsmId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                &nbsp;
                                                                @if( $item->isAvail==0)
                                                                    <abbr style="text-decoration: none;"  title="Deactivate Sub Catagory"><a href="{{url('subCategoryDisable/'.$item->pqsmId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                @endif
                                                                @if( $item->isAvail==1)
                                                                    <abbr style="text-decoration: none;" title="Activate Sub Catagory"> <a href="{{url('subCategoryEnable/'.$item->pqsmId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                @endif
                                                                &nbsp;
                                                                <abbr style="text-decoration: none;"  title="Delete Sub Category"><a href="{{url('subCategoryDelete/'.$item->pqsmId)}}" style="text-decoration: none;" onclick="deleteItem(event, this)"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i></a></abbr>

                                                            </td>
                                                        </tr>
                                                    @endforeach
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

            <!-- FORM---END -->
        </main>
    </div>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
           
            function handleMainexamChange() {
               // var selectedValmodule = $('#module').val();
                var selectedValexamtype = $('#examtype').val();
    
                if (selectedValexamtype === null) {
                    return;
                }
                //console.log(selectedValmodule);
    
                $.ajax({
                    type: 'get',
                    url: '/searchmainexmsubcategory',
                    data: {
                        selvalueexamtype: selectedValexamtype,
                    },
                    success: function(data) {
                        var tableBody = $('#dataTable-1 tbody');
                        tableBody.empty();
                       // console.log(data);
    
                        $.each(data, function(index, item) {
                            var row = $('<tr style="color: black;">');
    
                            row.append($('<td width="65">').text(item.slNo));
                            row.append($('<td width="20">').html('<b style="color: ' + item.isAvail + '; font-size: 30px">&#x2022;</b>'));
                            row.append($('<td width="150">').text(item.pqmainName));
                            row.append($('<td width="150">').text(item.pqmName));
                            row.append($('<td width="200">').text(item.pqsmName));
                            row.append($('<td width="100">').html(
                                '<abbr style="text-decoration: none;" title="Edit Sub Category">' +
                                '<a href="' + item.editUrl + '" onclick="editItem(event, this)" style="text-decoration: none;">' +
                                '<span class="fe fe-24 fe-edit"></span></a></abbr>' +
                                (item.deactivateUrl ? (
                                    '<abbr style="text-decoration: none;" title="Deactivate Sub Category">' +
                                    '<a href="' + item.deactivateUrl + '" style="text-decoration: none;" onclick="inactiveItem(event, this)">' +
                                    '<span style="color: red;" class="fe fe-24 fe-minus-circle"></span></a></abbr>'
                                ) : '') +
                                (item.activateUrl ? (
                                    '<abbr style="text-decoration: none;" title="Activate Sub Category">' +
                                    '<a href="' + item.activateUrl + '" style="text-decoration: none;" onclick="activeItem(event, this)">' +
                                    '<span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>'
                                ) : '') +
                                '<abbr style="text-decoration: none;" title="Delete Sub Category">' +
                                '<a href="' + item.deleteUrl + '" style="text-decoration: none;" onclick="deleteItem(event, this)">' +
                                '<i class="fa fa-trash-o" style="font-size:26px;color:red"></i></a></abbr>'
                            ));
    
                            tableBody.append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
    
            $('#examtype').on('change', function() {
                handleMainexamChange();
            });

            handleMainexamChange();
           // console.log("hello world");
        });
    </script>
    
    <script>
        $(document).ready(function() {
           
            function handleModuleChange() {
                var selectedValmodule = $('#module').val();
                var selectedValexamtype = $('#examtype').val();
    
                if (selectedValexamtype === null || selectedValmodule === null) {
                    return;
                }
                //console.log(selectedValmodule);
    
                $.ajax({
                    type: 'get',
                    url: '/searchexamyearbasesubcategory',
                    data: {
                        selvalueexamtype: selectedValexamtype,
                        selvaluemodule: selectedValmodule
                    },
                    success: function(data) {
                        var tableBody = $('#dataTable-1 tbody');
                        tableBody.empty();
                       // console.log(data);
    
                        $.each(data, function(index, item) {
                            var row = $('<tr style="color: black;">');
    
                            row.append($('<td width="65">').text(item.slNo));
                            row.append($('<td width="20">').html('<b style="color: ' + item.isAvail + '; font-size: 30px">&#x2022;</b>'));
                            row.append($('<td width="150">').text(item.pqmainName));
                            row.append($('<td width="150">').text(item.pqmName));
                            row.append($('<td width="200">').text(item.pqsmName));
                            row.append($('<td width="100">').html(
                                '<abbr style="text-decoration: none;" title="Edit Sub Category">' +
                                '<a href="' + item.editUrl + '" onclick="editItem(event, this)" style="text-decoration: none;">' +
                                '<span class="fe fe-24 fe-edit"></span></a></abbr>' +
                                (item.deactivateUrl ? (
                                    '<abbr style="text-decoration: none;" title="Deactivate Sub Category">' +
                                    '<a href="' + item.deactivateUrl + '" style="text-decoration: none;" onclick="inactiveItem(event, this)">' +
                                    '<span style="color: red;" class="fe fe-24 fe-minus-circle"></span></a></abbr>'
                                ) : '') +
                                (item.activateUrl ? (
                                    '<abbr style="text-decoration: none;" title="Activate Sub Category">' +
                                    '<a href="' + item.activateUrl + '" style="text-decoration: none;" onclick="activeItem(event, this)">' +
                                    '<span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>'
                                ) : '') +
                                '<abbr style="text-decoration: none;" title="Delete Sub Category">' +
                                '<a href="' + item.deleteUrl + '" style="text-decoration: none;" onclick="deleteItem(event, this)">' +
                                '<i class="fa fa-trash-o" style="font-size:26px;color:red"></i></a></abbr>'
                            ));
    
                            tableBody.append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
    
            $('#module').on('change', function() {
                handleModuleChange();
            });

            handleModuleChange();
           // console.log("hello world");
        });
    </script>
    




















    <script>
        function activeItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this subcategory!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms the deletion, redirect to the delete URL
                    window.location.href = element.href;
                }
            });
        }
    </script>




    <!---------------Generating Sub Module JavaScript-------------->
    <script>
        function myFunction() {

            
            document.getElementById("btn").style.display = 'block';
            subcnameValidation();
           
        }

    </script>


<?php if(!empty(session('pqmId'))){
    $moduleid=session('pqmId');
   // print_r($moduleid);die;
   
 }
 else{
    $moduleid="";
 }?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    function myExamFunction(){

        $(document).ready(function() {
        let category = document.getElementById('module').value;
        $("#save").attr("disabled", true);
       // alert (category);
        let shouldSubmitForm = true;

        if (category == null || category === " ") {
            document.getElementById("category-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;            
            event.preventDefault();
            return false;
        } else {
            document.getElementById("category-error").innerHTML = "";
          //  $("#save").attr("disabled", false);
            return false;
        }

    });

        // alert("dfdbfjd");

              var examid=document.getElementById('examtype').value;

              // alert(examid);
                // var submid=null;
                var mid='<?php echo $moduleid; ?>';
               // alert(mid);
               

             var sel = null;


   $.ajax({

   url: "{{url('/pqModuleCheckformain')}}",

   type: "GET",

   data: {

    pqmainId: examid,

       _token: '{{csrf_token()}}'

   },

   success: function(result) {

       if (result) {
          
           if(result.length>0){
            //console.log(result)
            document.getElementById("category").style.display = 'block';

                       $('#module').html('<option value=" " disabled selected>--Select exam year--</option>');

                       $.each(result, function(key, value) {

                           (value.pqmId == mid) ? sel="selected" :  sel="null";

                           $('#module').append('<option value="'+value.pqmId+'"  '+sel+' >' + value.pqmName + '</option>');

                       });
                    }else{

                    document.getElementById("category").style.display="none";
                   
                    event.preventDefault(); // prevent the default link behavior

                // Show the SweetAlert confirmation dialog
                    Swal.fire({
                        title: 'No category found !',
                        text: 'Please add a category to the corresponding Exam Type',
                        icon: 'warning',
                     showCancelButton: true,
                        confirmButtonText: 'Add Now',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If the user confirms the deletion, redirect to the delete URL
                            window.location.href = "/category";
                        }else{
                            window.location.href = "/subcategory";
                        }
                    });

              }
}}})


}
</script>


    <!---------------FORM JAVASCRIPT VALIDATION FOR SUB MODULES on submit-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



   
    <!---------------FORM JAVASCRIPT VALIDATION FOR SUB MODULES-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function subcnameValidation()
        {
            $(document).ready(function () {

                let category = document.getElementById('module').value;
                let name = document.getElementById('subCategory').value;
            //console.log(name);
            let length = name.length;
            // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;

            $.ajax({
                url: "{{url('/subcAjNameCheck')}}",
                type: "GET",
                data: {
                    pqmId: category,
                    subcatname: name,

                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    console.log(result);


                    if (result[0] != null) {

                        //module name have a value to another module
                        document.getElementById("name-error").innerHTML = "Sub category name is already taken.";
                        document.getElementById("save").style.display = 'none';
                        return false;
                    } else {
                        document.getElementById("save").style.display = 'block';

                    }
                }
            });

            let shouldSubmitForm = true;

            if (category == null || category == "") {
            //document.getElementById("category-error").innerHTML = "This field is required.";
            shouldSubmitForm = false; // set variable to false if name field is null
            $("#save").attr("disabled", true); // disable the "Save" button
            } 

    if (name == null || name == "") {
      document.getElementById("name-error").innerHTML = "This field is required.";
      shouldSubmitForm = false; // set variable to false if name field is null
      $("#save").attr("disabled", true); // disable the "Save" button
    } else if (length < 3) {
      document.getElementById("name-error").innerHTML = "At least 3 characters.";
      shouldSubmitForm = false; // set variable to false if name field is too short
      $("#save").attr("disabled", true); // disable the "Save" button
    } else if (length > 100) {
      document.getElementById("name-error").innerHTML = "Only 100 characters.";
      shouldSubmitForm = false; // set variable to false if name field is too long
      $("#save").attr("disabled", true); // disable the "Save" button
    } else {
      document.getElementById("name-error").innerHTML = "";
      document.getElementById("category-error").innerHTML = "";
      $("#save").attr("disabled", false); // enable the "Save" button
    }

    // $("#save").on("click", function() {
    //   if (shouldSubmitForm) { // only submit form if variable is still true
    //     $(this).attr("disabled", "disabled");
    //     $(this).html("Saving...");
    //     $("#scform").submit();
    //   }
    // });

  });

        }

    </script>


    <!---------------FORM JAVASCRIPT VALIDATION FOR SUB MODULES-------------->
    <!-- Ajax START -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--END Ajax -->

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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this subcategory?',
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
                title: 'Are you sure to delete this subcategory?',
                text: 'All question will be deleted under this subcategory!',
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
                title: 'Are you sure to activate subcategory?',
                text: 'All question will be activated under this subcategory!',
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
                title: 'Are you sure to deactivate this subcategory?',
                text: 'All question will be deactivated under this subcategory!',
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
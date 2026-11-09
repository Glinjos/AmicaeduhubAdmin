@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Chapters</h2>

                        <form  class="state-form" id="scform" action="{{url('/addchapter')}}" method="post">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            <div class="card shadow mb-4">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                                @if (session('vcmId'))
                                                    <script>
                                                        window.onload = function () {
                                                           // myExamFunction();
                                                            myFunction();
                                                           
                                                            
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
                                           

                                            <label for="subject"><b style="color: black">Subject</b></label>

                                            <select name="module" id="module" onChange="return myFunction()" class="form-control">

                                            <option value=" " disabled selected>--Select subject--</option>

                                            
                                            @foreach($select1 as $item)
                                                <option value="{{$item->vcmId}}"  {{ $item->vcmId == session('vcmId') ? 'selected' : '' }} >{{$item->vcmName}}</option>
                                            @endforeach

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select><br>


                                        {{-- <div id="category" style="display: none">  
                                             <b style="color: black;">Subject</b>
                                            <select name="module" id="module" onChange="return myFunction()" class="form-control">
                                                {{-- <option style="text-align: center" disabled selected >--- Select category ---</option>
                                                @if(isset($select1))
                                                    @foreach($select1 as $data)

                                                        <option value="{{$data->vcmId}}" {{ $data->vcmId == session('vcmId') ? 'selected' : '' }} id="demo" align="center">

                                                            {{ $data->pqmName}}</option>

                                                    @endforeach
                                                @endif --}}

                                            {{-- </select>
                                            <span id="module-error" class="text-danger"></span>
                                        </div> --}} 

                                            <!-- FORM---START -->
                                            <div id="btn" style="display: none">

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1"><b style="color: black;">Chapter</b></label>
                                                    <input type="text" class="form-control" name="chapter" id="chapter" value="{{old('chapter')}}" placeholder="Enter chapter name"  onkeyup="return chapterValidation()" required>
                                                    <span id="name-error" class="text-danger"></span>
                                                    @if ($errors->has('chapter'))
                                                        <span class="text-danger">{{ $errors->first('chapter') }}</span>
                                                    @endif
                                                </div>


                                                {{-- chapter video link --}}
                                                {{-- &nbsp;&nbsp;&nbsp;&nbsp; --}}
                                                {{-- <div class="form-group">
                                                    <label for="exampleFormControlInput1"><b style="color: black;">Chapter Video</b></label>
                                                    <input type="text" class="form-control" name="chapterVideo" id="chapterVideo" value="{{old('chapterVideo')}}" placeholder="Enter chapter video link"  onkeyup="return chapterVideoValidation()" required>
                                                    <span id="chapterVideo-error" class="text-danger"></span>
                                                    @if ($errors->has('chapterVideo'))
                                                        <span class="text-danger">{{ $errors->first('chapterVideo') }}</span>
                                                    @endif
                                                </div> --}}

                                                {{-- chapter Description --}}
                                                {{-- &nbsp;&nbsp;&nbsp;&nbsp; --}}
                                                {{-- <div class="form-group">
                                                    <label for="exampleFormControlInput1"><b style="color: black;">Chapter Description</b></label>
                                                    <textarea class="form-control" name="chapterDescription" id="chapterDescription" placeholder="Enter chapter description" onkeyup="return chapterDescriptionValidation()" required style="width: 940px; height: 150px;">{{old('chapterDescription')}}</textarea>
                                                    <span id="chapterDescription-error" class="text-danger"></span>
                                                    @if ($errors->has('chapterDescription'))
                                                        <span class="text-danger">{{ $errors->first('chapterDescription') }}</span>
                                                    @endif
                                                </div> --}}


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
                                <h2 class="mb-2 page-title">Chapters We Have</h2>
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
                                                        <th style="color: black;"><b>SUBJECT</b></th>
                                                        <th style="color: black;"><b>CHAPTER</b></th>
                                                        {{-- <th style="color: black;"><b>CHAPTER VIDEO</b></th>
                                                        <th style="color: black;"><b>CHAPTER DESCRIPTION</b></th> --}}
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

                                                            {{-- <td width="100">{{wordwrap($item->pqmainName,20,"\n",TRUE) }}</td> --}}
                                                            <td width="100">{{wordwrap($item->vcmName,20,"\n",TRUE) }}</td>

                                                            <td width="100">{{ wordwrap($item->vcChapterName,20,"\n",TRUE) }}</td>
                                                            {{-- <td width="100">{{ wordwrap($item->vcChapterVideo,20,"\n",TRUE) }}</td>
                                                            <td width="150">{{ wordwrap($item->vcChapterDescription,20,"\n",TRUE) }}</td> --}}

                                                            <td width="100">

                                                                <abbr style="text-decoration: none;" title="Edit chapter"><a href="{{url('updatechapter'.$item->vcChapterId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                &nbsp;
                                                                @if( $item->isAvail==0)
                                                                    <abbr style="text-decoration: none;"  title="Deactivate chapter"><a href="{{url('chapterDisable/'.$item->vcChapterId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                @endif
                                                                @if( $item->isAvail==1)
                                                                    <abbr style="text-decoration: none;" title="Activate chapter"> <a href="{{url('chapterEnable/'.$item->vcChapterId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                @endif
                                                                &nbsp;
                                                                <abbr style="text-decoration: none;"  title="Delete chapter"><a href="{{url('chapterDelete/'.$item->vcChapterId)}}" style="text-decoration: none;" onclick="deleteItem(event, this)"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i></a></abbr>

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
    <script>
        function activeItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this chapter!',
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


<?php if(!empty(session('vcmId'))){
    $moduleid=session('vcmId');
   // print_r($moduleid);die;
   
 }
 else{
    $moduleid="";
 }?>














<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
      

    $(document).ready(function() {
            function handleModuleChange() {
                var selectedVal = $('#module').val();
            
                if (selectedVal === null) {
                return;
                }
              
                var baseUrl = '{{ url('') }}';

                $.ajax({
                    type: 'get',
                    url: baseUrl + '/searchsubjectwisechapter',
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
                            row.append($('<td width="100">').text(item.vcmName));
                            row.append($('<td width="100">').text(item.vcChapterName));
                           
                            row.append($('<td width="100">').html(
                                '<abbr style="text-decoration: none;" title="Edit chapter">' +
                                '<a href="' + item.editUrl + '" onclick="editItem(event, this)" style="text-decoration: none;">' +
                                '<span class="fe fe-24 fe-edit"></span></a></abbr>' +
                                
                                ((item.deactivateUrl !== '') ?
                                    ('<abbr style="text-decoration: none;" title="Deactivate chapter">' +
                                        '<a href="' + item.deactivateUrl + '" style="text-decoration: none;" onclick="inactiveItem(event, this)">' +
                                        '<span style="color: red;" class="fe fe-24 fe-minus-circle"></span></a></abbr>') : '') +
                                ((item.activateUrl !== '') ?
                                    ('<abbr style="text-decoration: none;" title="Activate chapter">' +
                                        '<a href="' + item.activateUrl + '" style="text-decoration: none;" onclick="activeItem(event, this)">' +
                                        '<span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>') : '') +

                                '<abbr style="text-decoration: none;" title="Delete chapter">' +
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

            $('#module').on('change', function() {
                handleModuleChange();
            });

            // Execute the function when the document is ready
            handleModuleChange();
        });



    



    </script>



























{{-- <script>
    function myExamFunction(){

        $(document).ready(function() {
        let category = document.getElementById('module').value;
        $("#save").attr("disabled", true);
       // alert (category);
        let shouldSubmitForm = true;

        if (category == null || category === " ") {
            document.getElementById("module-error").innerHTML = "This field is required.";
            shouldSubmitForm = false;            
            event.preventDefault();
            return false;
        } else {
            document.getElementById("module-error").innerHTML = "";
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

   url: "{{url('/vcModuleCheckformain')}}",

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

                       $('#module').html('<option value=" " disabled selected>--Select module--</option>');

                       $.each(result, function(key, value) {

                           (value.vcmId == mid) ? sel="selected" :  sel="null";

                           $('#module').append('<option value="'+value.vcmId+'"  '+sel+' >' + value.vcmName + '</option>');

                       });
                    }else{

                    document.getElementById("category").style.display="none";
                   
                    event.preventDefault(); // prevent the default link behavior

                // Show the SweetAlert confirmation dialog
                    Swal.fire({
                        title: 'No module found !',
                        text: 'Please add a module to the corresponding Exam Type',
                        icon: 'warning',
                     showCancelButton: true,
                        confirmButtonText: 'Add Now',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If the user confirms the deletion, redirect to the delete URL
                            window.location.href = "/vcmoduleform";
                        }else{
                            window.location.href = "/toPQA";
                        }
                    });

              }
}}})


}
</script> --}}


    <!---------------FORM JAVASCRIPT VALIDATION FOR SUB MODULES on submit-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



   
    <!---------------FORM JAVASCRIPT VALIDATION FOR SUB MODULES-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        function chapterValidation()
        {
            $(document).ready(function () {

            let category = document.getElementById('module').value;
            let name = document.getElementById('chapter').value;
            
            //alert(category);
            //alert(name);
            let length = name.length;
            // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;

            $.ajax({
            url: "{{url('/chapterAjNameCheck')}}",
            type: "GET",
            data: {
                vcmId: category,
                vcChapterName: name,

                _token: '{{csrf_token()}}'
            },
            success: function (result) {
               // console.log(result);


                if (result[0] != null) {

                    //module name have a value to another module
                    document.getElementById("name-error").innerHTML = "This chapter is already taken.";
                    document.getElementById("save").style.display = 'none';
                    return false;
                } else {
                    document.getElementById("save").style.display = 'block';

                }
            }
            });

            let shouldSubmitForm = true;

            // if (category == null || category == "") {
            // //document.getElementById("module-error").innerHTML = "This field is required.";
            // shouldSubmitForm = false; // set variable to false if name field is null
            // $("#save").attr("disabled", true); // disable the "Save" button
            // } 

           
            
            if (name == null || name == "") {
                document.getElementById("name-error").innerHTML = "This field is required.";
                shouldSubmitForm = false; // set variable to false if name field is null
                $("#save").attr("disabled", true); // disable the "Save" button
                } else if (length < 3) {
                document.getElementById("name-error").innerHTML = "At least 3 characters.";
                shouldSubmitForm = false; // set variable to false if name field is too short
                $("#save").attr("disabled", true); // disable the "Save" button
                }
                //  else if (length > 100) {
                // document.getElementById("name-error").innerHTML = "Only 100 characters.";
                // shouldSubmitForm = false; // set variable to false if name field is too long
                // $("#save").attr("disabled", true); // disable the "Save" button
                // }
                 else {
                document.getElementById("name-error").innerHTML = "";
                // document.getElementById("module-error").innerHTML = "";
                $("#save").attr("disabled", false); // enable the "Save" button
                }

   
           


            });

        }

    </script>
    {{-- <script>
        function chapterVideoValidation()
        {
            $(document).ready(function () {

               
                let chapterVideo = document.getElementById('chapterVideo').value;
                //console.log(name);
                let length = chapterVideo.length;
                // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;


            let shouldSubmitForm = true;

                    if (chapterVideo == null || chapterVideo == "") {
                    document.getElementById("chapterVideo-error").innerHTML = "This field is required.";
                    shouldSubmitForm = false; // set variable to false if name field is null
                    $("#save").attr("disabled", true); // disable the "Save" button
                    } 
                    // else if (length < 3) {
                    // document.getElementById("chapterVideo-error").innerHTML = "At least 3 characters.";
                    // shouldSubmitForm = false; // set variable to false if name field is too short
                    // $("#save").attr("disabled", true); // disable the "Save" button
                    // } else if (length > 100) {
                    // document.getElementById("chapterVideo-error").innerHTML = "Only 100 characters.";
                    // shouldSubmitForm = false; // set variable to false if name field is too long
                    // $("#save").attr("disabled", true); // disable the "Save" button
                    // }
                     else {
                    document.getElementById("chapterVideo-error").innerHTML = "";
                    // document.getElementById("module-error").innerHTML = "";
                    $("#save").attr("disabled", false); // enable the "Save" button
                    }

                

                });

        }

    </script>

<script>
    function chapterDescriptionValidation()
    {
        $(document).ready(function () {

           
            let chapterDescription = document.getElementById('chapterDescription').value;
            //console.log(name);
            let length = chapterDescription.length;
            // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;


        let shouldSubmitForm = true;

                if (chapterDescription == null || chapterDescription == "") {
                document.getElementById("chapterDescription-error").innerHTML = "This field is required.";
                shouldSubmitForm = false; // set variable to false if name field is null
                $("#save").attr("disabled", true); // disable the "Save" button
                } else if (length < 3) {
                document.getElementById("chapterDescription-error").innerHTML = "At least 3 characters.";
                shouldSubmitForm = false; // set variable to false if name field is too short
                $("#save").attr("disabled", true); // disable the "Save" button
                }
                //  else if (length > 100) {
                // document.getElementById("chapterDescription-error").innerHTML = "Only 100 characters.";
                // shouldSubmitForm = false; // set variable to false if name field is too long
                // $("#save").attr("disabled", true); // disable the "Save" button
                // }
                 else {
                document.getElementById("chapterDescription-error").innerHTML = "";
                // document.getElementById("module-error").innerHTML = "";
                $("#save").attr("disabled", false); // enable the "Save" button
                }

            

            });

    }

</script> --}}







    <script>
        function subcnameValidation()
        {
            $(document).ready(function () {

                let category = document.getElementById('module').value;
                let name = document.getElementById('chapter').value;
                let chapterVideo = document.getElementById('chapterVideo').value;
                let chapterDescription = document.getElementById('chapterDescription').value;
            //console.log(name);
            let length = name.length;
            // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;

            $.ajax({
                url: "{{url('/chapterAjNameCheck')}}",
                type: "GET",
                data: {
                    vcmId: category,
                    vcChapterName: name,

                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    console.log(result);


                    if (result[0] != null) {

                        //module name have a value to another module
                        document.getElementById("name-error").innerHTML = "This chapter is already taken.";
                        document.getElementById("save").style.display = 'none';
                        return false;
                    } else {
                        document.getElementById("save").style.display = 'block';

                    }
                }
            });

            let shouldSubmitForm = true;

            if (category == null || category == "") {
            //document.getElementById("module-error").innerHTML = "This field is required.";
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
    } 

                //    else if (chapterVideo == null || chapterVideo == "") {
                //     document.getElementById("chapterVideo-error").innerHTML = "This field is required.";
                //     shouldSubmitForm = false; // set variable to false if name field is null
                //     $("#save").attr("disabled", true); // disable the "Save" button
                //     } 
                //     else if (chapterDescription == null || chapterDescription == "") {
                //     document.getElementById("chapterDescription-error").innerHTML = "This field is required.";
                //     shouldSubmitForm = false; // set variable to false if name field is null
                //     $("#save").attr("disabled", true); // disable the "Save" button
                //     }
                    
                   
    
    
    
    
    else {
      document.getElementById("name-error").innerHTML = "";
      document.getElementById("module-error").innerHTML = "";
      document.getElementById("chapterVideo-error").innerHTML = "";
      document.getElementById("chapterDescription-error").innerHTML = "";
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
                title: 'Are you sure to edit this chapter?',
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
                title: 'Are you sure to delete this chapter?',
                text: 'All video classes and the corresponding video-based questions will be delete under this chapter.',
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
                title: 'Are you sure to activate chapter?',
                text: 'All video classes and the corresponding video-based questions will be activated under this chapter!',
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
                title: 'Are you sure to deactivate this chapter?',
                text: 'All video classes and the corresponding video-based questions will be deactivated under this chapter!',
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
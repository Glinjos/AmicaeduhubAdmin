@extends('admin/adminMaster')

@section('adminpanel')



<!-- STYLE FOR FULL DESCRIPTION VIEW-->

<style>
    .tooltip-pr {
    display: inline-block;
    width: 250px;
    height: 40px;
  
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }
  
  .tooltip-pr .tooltiptext-pr {
    //visibility: hidden;
    color: black;
    hyphens: auto;
  }
  
  .tooltip-pr:hover {
    cursor: pointer;
    height: 100%;
    white-space: initial;
    transition: height 0.2s ease-in-out;
  } 
  
  </style>





    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Videos</h2>

                        <form  class="state-form" id="scform" onsubmit="return validater();" action="{{url('/addvideodetails')}}" method="post">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            <div class="card shadow mb-4">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                                @if (session('vcmId'))
                                                    <script>
                                                        window.onload = function () {
                                                            myExamFunction();
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

                                            <select class="form-control" name="subject" id="subject" onChange="return myExamFunction()">

                                            <option value=" " disabled selected>--Select subject--</option>

                                            
                                            @foreach($select3 as $item)
                                                <option value="{{$item->vcmId}}"  {{ $item->vcmId == session('vcmId') ? 'selected' : '' }} >{{$item->vcmName}}</option>
                                            @endforeach

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select><br>


                                        <div id="category" style="display: none">  
                                             <b style="color: black;">Chapter</b>
                                            <select name="chapter" id="chapter" onChange="return myFunction()" class="form-control">
                                                {{-- <option style="text-align: center" disabled selected >--- Select category ---</option>
                                                @if(isset($select1))
                                                    @foreach($select1 as $data)

                                                        <option value="{{$data->pqmId}}" {{ $data->pqmId == session('pqmId') ? 'selected' : '' }} id="demo" align="center">

                                                            {{ $data->pqmName}}</option>

                                                    @endforeach
                                                @endif --}}

                                            </select>
                                            <span id="category-error" class="text-danger"></span>
                                        </div>

                                            <!-- FORM---START -->
                                            <div id="btn" style="display: none">

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1"><b style="color: black;">Video Heading</b></label>
                                                    <input type="text" class="form-control" name="videohead" id="videohead" value="{{old('videohead')}}" placeholder="Enter video heading"  onkeyup="return subcnameValidation()" required>
                                                    <span id="name-error" class="text-danger"></span>
                                                    @if ($errors->has('videohead'))
                                                        <span class="text-danger">{{ $errors->first('videohead') }}</span>
                                                    @endif
                                                </div>

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1"><b style="color: black;">Video Link</b></label>
                                                    <input type="text" class="form-control" name="videoLink" id="videoLink" value="{{old('videoLink')}}" placeholder="Enter video Link"  onkeyup="return videoLinkValidation()" required>
                                                    <span id="videoLink-error" class="text-danger"></span>
                                                    @if ($errors->has('videoLink'))
                                                        <span class="text-danger">{{ $errors->first('videoLink') }}</span>
                                                    @endif
                                                </div>

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1"><b style="color: black;">Description</b></label>
                                                    <br>
                                                    {{-- <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}" placeholder="Enter description"  onkeyup="return descriptionValidation()" required>
                                                    <span id="description-error" class="text-danger"></span>
                                                    @if ($errors->has('description'))
                                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                                    @endif --}}

                                            <!-- SCRIPT FOR DESCRIPTION TEXT AREA -->

                                            <textarea name="description" id="description" ></textarea> 
                                            <span id="description-error" class="text-danger"></span>
                                            {{-- <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script> --}}
                                            {{-- <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

                                            <script>
                                            CKEDITOR.replace( 'description' );

                                            CKEDITOR.instances['description'].on('change', function () {
                                                //alert("Please enter a description");
                                                var description = CKEDITOR.instances['description'].getData().trim();
                                                if (description === "") {
                                                document.getElementById("description-error").innerHTML = "Please enter a description";
                                                $("#save").attr("disabled", true);
                                                } else {
                                                document.getElementById("description-error").innerHTML = "";
                                                $("#save").attr("disabled", false); // enable the "Save" button
                                                }
                                            });
                                            </script>   --}}
                                            <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>
                                            <script>
                                                var descriptionEditor;
                                        
                                                function validater() {
                                                    var description = descriptionEditor.getData().trim();
                                                    if (description === "") {
                                                        document.getElementById("description-error").innerHTML = "Please enter a description";
                                                        return false; // Prevent form submission
                                                    } else {
                                                        document.getElementById("description-error").innerHTML = "";
                                                        return true; // Allow form submission
                                                    }
                                                }
                                        
                                                function initializeCKEditor(selector) {
                                                    return new Promise((resolve) => {
                                                        CKEDITOR.ClassicEditor.create(document.querySelector(selector), {
                                                            toolbar: {
                                                                items: [
                                                                    'heading', '|',
                                                                    'bold', 'italic', 'strikethrough', 'underline', '|',
                                                                    'bulletedList', 'numberedList', 'todoList', '|',
                                                                    'undo', 'redo', '|',
                                                                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                                                                    'alignment', '|',
                                                                    'link', 'uploadImage', 'blockQuote', 'insertTable', '|',
                                                                    'specialCharacters', 'horizontalLine', 'pageBreak'
                                                                ],
                                                                shouldNotGroupWhenFull: true
                                                            },
                                                            list: {
                                                                properties: {
                                                                    styles: true,
                                                                    startIndex: true,
                                                                    reversed: true
                                                                }
                                                            },
                                                            fontFamily: {
                                                                options: [
                                                                    'default',
                                                                    'Arial, Helvetica, sans-serif',
                                                                    'Courier New, Courier, monospace',
                                                                    'Georgia, serif',
                                                                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                                                                    'Tahoma, Geneva, sans-serif',
                                                                    'Times New Roman, Times, serif',
                                                                    'Trebuchet MS, Helvetica, sans-serif',
                                                                    'Verdana, Geneva, sans-serif'
                                                                ],
                                                                supportAllValues: true
                                                            },
                                                            fontSize: {
                                                                options: [10, 12, 14, 'default', 18, 20, 22],
                                                                supportAllValues: true
                                                            },
                                                            removePlugins: [
                                                                'CKBox',
                                                                'CKFinder',
                                                                'EasyImage',
                                                                'RealTimeCollaborativeComments',
                                                                'RealTimeCollaborativeTrackChanges',
                                                                'RealTimeCollaborativeRevisionHistory',
                                                                'PresenceList',
                                                                'Comments',
                                                                'TrackChanges',
                                                                'TrackChangesData',
                                                                'RevisionHistory',
                                                                'Pagination',
                                                                'WProofreader',
                                                                'MathType',
                                                                'SlashCommand',
                                                                'Template',
                                                                'DocumentOutline',
                                                                'FormatPainter',
                                                                'TableOfContents'
                                                            ]
                                                        }).then(editor => {
                                                            resolve(editor);
                                                        });
                                                    });
                                                }
                                        
                                                // Initialize CKEditor for description and attach change event listener
                                                initializeCKEditor('#description').then((editor) => {
                                                    descriptionEditor = editor;
                                                    editor.model.document.on('change:data', validater);
                                                });
                                            </script>
                                            
                                                 <!-- END SCRIPT FOR DESCRIPTION TEXT AREA -->



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
                                <h2 class="mb-2 page-title">Chapter Videos We Have</h2>
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
                                                        <th style="color: black;"><b>Subject</b></th>
                                                        <th style="color: black;"><b>Chapter</b></th>
                                                        <th style="color: black;"><b>Video Heading</b></th>
                                                        <th style="color: black;"><b>Video Link</b></th>
                                                        <th style="color: black;"><b>Video Description</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>

                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $i=1 @endphp
                                                    @foreach ($select as $item)
                                                   
                                                        <tr style="color: black;">

                                                            <td width="65"><b>{{$i++}}</b></td>
                                                            <td  width="20" > @if( $item->isPublished==0)
                                                                <b style="color: green;font-size:30px ">&#x2022;</b>

                                                             @endif
                                                             @if( $item->isPublished==1)
                                                             <b style="color: red;font-size:30px ">&#x2022;</b>

                                                             @endif
                                                            </td>

                                                            <td width="80">{{wordwrap($item->vcmName,20,"\n",TRUE) }}</td>
                                                            <td width="90">{{wordwrap($item->vcChapterName,20,"\n",TRUE) }}</td>

                                                            <td width="90">{{ wordwrap($item->videoHeading,20,"\n",TRUE) }}</td>
                                                            <td width="90">{{ wordwrap($item->videoLink,20,"\n",TRUE) }}</td>
                                                            <td >
                                                                <div class="tooltip-pr">
                                                                    <span class="tooltiptext-pr">
                                                                    {!! $item->description !!}
                                                                    </span>
                                                                    </div>
                                                                {{-- {{ wordwrap($item->description,20,"\n",TRUE) }} --}}
                                                            </td>

                                                            <td width="50">
                                                                <abbr style="text-decoration: none;" title="Edit Video"><a href="{{url('updatevideo'.$item->vcVDId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                &nbsp;
                                                               
                                                                <abbr style="text-decoration: none;"  title="Delete video"><a href="{{url('videoDelete/'.$item->vcVDId)}}" style="text-decoration: none;" onclick="deleteItem(event, this)"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i></a></abbr>

                                                                &nbsp;
                                                                 @if( $item->isPublished==0)
                                                                <abbr style="text-decoration: none;"  title="Disable video"><a href="{{url('vcvideoDisable/'.$item->vcVDId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                @endif
                                                                @if( $item->isPublished==1)
                                                                    <abbr style="text-decoration: none;" title="Activate video"> <a href="{{url('vcvideoEnable/'.$item->vcVDId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                @endif
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
                text: 'You want to delete this video!',
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


<?php if(!empty(session('vcChapterId'))){
    $moduleid=session('vcChapterId');
   // print_r($moduleid);die;
   
 }
 else{
    $moduleid="";
 }?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script>
    $(document).ready(function() {
       
        function handleChapterChange() {
            var selectedValchapter = $('#chapter').val();
            var selectedValsubject = $('#subject').val();

            if (selectedValsubject === null || selectedValchapter === null) {
                return;
            }
          // console.log(selectedValchapter);

            $.ajax({
                type: 'get',
                url: '/searchchapterbasevideo',
                data: {
                    selvaluesubject: selectedValsubject,
                    selvaluechapter: selectedValchapter
                },
                success: function(data) {
                    var tableBody = $('#dataTable-1 tbody');
                    tableBody.empty();
                   // console.log(data);

                    $.each(data, function(index, item) {
                        var row = $('<tr style="color: black;">');

                            row.append($('<td width="65">').text(item.slNo));
                            row.append($('<td width="20">').html('<b style="color: ' + item.isPublished + '; font-size: 30px">&#x2022;</b>'));
                            row.append($('<td width="80">').text(item.vcmName));
                            row.append($('<td width="90">').text(item.vcChapterName));
                            row.append($('<td width="100">').text(item.videoHeading));
                            row.append($('<td width="130">').text(item.videoLink));
                           // row.append($('<td width="300">').text(item.description));
                           
                            var tdDescription = $('<td width="300">').text(item.description);
                            var tooltipDiv = $('<div class="tooltip-pr">');
                            var tooltipSpan = $('<span class="tooltiptext-pr">').html(item.description);
                            tooltipDiv.append(tooltipSpan);
                            row.append(tooltipDiv);
                            
                            

                            row.append($('<td width="90">').html(
                                '<abbr style="text-decoration: none;" title="Edit chapter">' +
                                '<a href="' + item.editUrl + '" onclick="editItem(event, this)" style="text-decoration: none;">' +
                                '<span class="fe fe-24 fe-edit"></span></a></abbr>' +
                                
                            

                                '<abbr style="text-decoration: none;" title="Delete chapter">' +
                                '<a href="' + item.deleteUrl + '" style="text-decoration: none;" onclick="deleteItem(event, this)">' +
                                '<i class="fa fa-trash-o" style="font-size:26px;color:red"></i></a></abbr>'+
                         
                          ((item.deactivateUrl !== '') ?
                            ('<abbr style="text-decoration: none;" title="Disable video">' +
                            '<a href="' + item.deactivateUrl + '" style="text-decoration: none;" onclick="inactiveItem(event, this)">' +
                            '<i class="fe fe-24 fe-minus-circle" style="color: red;"></i></a></abbr>') : '') +
                            ((item.activateUrl !== '') ?
                            ('<abbr style="text-decoration: none;" title="Activate video">' +
                            '<a href="' + item.activateUrl + '" style="text-decoration: none;" onclick="activeItem(event, this)">' +
                            '<i class="fe fe-24 fe-check-circle" style="color: green;"></i></a></abbr>') : '')
                        ));

                        tableBody.append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        $('#chapter').on('change', function() {
            handleChapterChange();
        });

        handleChapterChange();
       // console.log("hello world");
    });
</script>













<script>
      

    $(document).ready(function() {
            function handleModuleChange() {
                var selectedVal = $('#subject').val();
            
                if (selectedVal === null) {
                return;
                }
              
                var baseUrl = '{{ url('') }}';

                $.ajax({
                    type: 'get',
                    url: baseUrl + '/searchsubjectwisevideos',
                    data: {
                        'selvalue': selectedVal
                    },
                    success: function(data) {
                        var tableBody = $('#dataTable-1 tbody');
                        tableBody.empty();

                        $.each(data, function(index, item) {
                            var row = $('<tr style="color: black;">');

                            row.append($('<td width="65">').text(item.slNo));
                            row.append($('<td width="20">').html('<b style="color: ' + item.isPublished + '; font-size: 30px">&#x2022;</b>'));
                            row.append($('<td width="80">').text(item.vcmName));
                            row.append($('<td width="90">').text(item.vcChapterName));
                            row.append($('<td width="100">').text(item.videoHeading));
                            row.append($('<td width="130">').text(item.videoLink));
                           // row.append($('<td width="300">').text(item.description));
                           
                            var tdDescription = $('<td width="300">').text(item.description);
                            var tooltipDiv = $('<div class="tooltip-pr">');
                            var tooltipSpan = $('<span class="tooltiptext-pr">').html(item.description);
                            tooltipDiv.append(tooltipSpan);
                            row.append(tooltipDiv);
                            
                            
                           
                            row.append($('<td width="90">').html(
                                '<abbr style="text-decoration: none;" title="Edit chapter">' +
                                '<a href="' + item.editUrl + '" onclick="editItem(event, this)" style="text-decoration: none;">' +
                                '<span class="fe fe-24 fe-edit"></span></a></abbr>' +
                                
                               

                                '<abbr style="text-decoration: none;" title="Delete chapter">' +
                                '<a href="' + item.deleteUrl + '" style="text-decoration: none;" onclick="deleteItem(event, this)">' +
                                '<i class="fa fa-trash-o" style="font-size:26px;color:red"></i></a></abbr>'+
                                
                                 ((item.deactivateUrl !== '') ?
                                ('<abbr style="text-decoration: none;" title="Disable video">' +
                                '<a href="' + item.deactivateUrl + '" style="text-decoration: none;" onclick="inactiveItem(event, this)">' +
                                '<i class="fe fe-24 fe-minus-circle" style="color: red;"></i></a></abbr>') : '') +
                                ((item.activateUrl !== '') ?
                                ('<abbr style="text-decoration: none;" title="Activate video">' +
                                '<a href="' + item.activateUrl + '" style="text-decoration: none;" onclick="activeItem(event, this)">' +
                                '<i class="fe fe-24 fe-check-circle" style="color: green;"></i></a></abbr>') : '')
                                
                                
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

            $('#subject').on('change', function() {
                handleModuleChange();
            });

            // Execute the function when the document is ready
            handleModuleChange();
        });



    



    </script>


















<script>
    function myExamFunction(){

        $(document).ready(function() {
        let category = document.getElementById('chapter').value;
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

              var examid=document.getElementById('subject').value;

              // alert(examid);
                // var submid=null;
                var mid='<?php echo $moduleid; ?>';
               // alert(mid);
               

             var sel = null;


   $.ajax({

   url: "{{url('/subjectCheckvideo')}}",

   type: "GET",

   data: {

    vcmId: examid,

       _token: '{{csrf_token()}}'

   },

   success: function(result) {

       if (result) {
          
           if(result.length>0){
            //console.log(result)
            document.getElementById("category").style.display = 'block';

                       $('#chapter').html('<option value=" " disabled selected>--Select chapter--</option>');

                       $.each(result, function(key, value) {

                           (value.vcChapterId == mid) ? sel="selected" :  sel="null";

                           $('#chapter').append('<option value="'+value.vcChapterId+'"  '+sel+' >' + value.vcChapterName + '</option>');

                       });
                    }else{

                    document.getElementById("category").style.display="none";
                   
                    event.preventDefault(); // prevent the default link behavior

                // Show the SweetAlert confirmation dialog
                    Swal.fire({
                        title: 'No subject found !',
                        text: 'Please add a chapter to the corresponding subject',
                        icon: 'warning',
                     showCancelButton: true,
                        confirmButtonText: 'Add Now',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If the user confirms the deletion, redirect to the delete URL
                            window.location.href = "/vcmoduleform";
                        }else{
                            window.location.href = "/addvideos";
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
        function descriptionValidation()
        {
            $(document).ready(function () {

                let category = document.getElementById('chapter').value;
                let description =  CKEDITOR.instances.description.getData().trim();
            //console.log(name);
            let length = name.length;
            // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;

           

            let shouldSubmitForm = true;

          

            if (category == null || category == "") {
            //document.getElementById("category-error").innerHTML = "This field is required.";
            shouldSubmitForm = false; // set variable to false if name field is null
            $("#save").attr("disabled", true); // disable the "Save" button
            } 

            if (description == null || description == "") {
            document.getElementById("description-error").innerHTML = "This field is required.";
            shouldSubmitForm = false; // set variable to false if name field is null
            $("#save").attr("disabled", true); // disable the "Save" button
           // alert('shit');
            }else {
               // alert('hai');
            document.getElementById("description-error").innerHTML = "";
            document.getElementById("category-error").innerHTML = "";
            $("#save").attr("disabled", false); // enable the "Save" button
            }

   

  });

        }

    </script>
    <script>
        function videoLinkValidation()
        {
            $(document).ready(function () {

                let category = document.getElementById('chapter').value;
                let name = document.getElementById('videoLink').value;
            //console.log(name);
            let length = name.length;
            // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;

           

            let shouldSubmitForm = true;

            if (category == null || category == "") {
            //document.getElementById("category-error").innerHTML = "This field is required.";
            shouldSubmitForm = false; // set variable to false if name field is null
            $("#save").attr("disabled", true); // disable the "Save" button
            } 

    if (name == null || name == "") {
      document.getElementById("videoLink-error").innerHTML = "This field is required.";
      shouldSubmitForm = false; // set variable to false if name field is null
      $("#save").attr("disabled", true); // disable the "Save" button
    }else {
      document.getElementById("videoLink-error").innerHTML = "";
      document.getElementById("category-error").innerHTML = "";
      descriptionValidation();
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
    <script>
        function subcnameValidation() {
            $(document).ready(function () {
                let category = document.getElementById('chapter').value;
                let name = document.getElementById('videohead').value;
                var description = CKEDITOR.instances['description'].getData().trim();
                let videoLink = document.getElementById('videoLink').value;
    
                let shouldSubmitForm = true;
    
                if (category == null || category == "") {
                    document.getElementById("category-error").innerHTML = "";
                    $("#save").attr("disabled", true);
                    shouldSubmitForm = false;
                } else if (name == null || name == "") {
                    document.getElementById("category-error").innerHTML = "";
                    document.getElementById("name-error").innerHTML = "This field is required.";
                    $("#save").attr("disabled", true);
                    shouldSubmitForm = false;
                } else if (videoLink == null || videoLink == "") {
                    document.getElementById("category-error").innerHTML = "";
                    document.getElementById("name-error").innerHTML = "";
                    document.getElementById("videoLink-error").innerHTML = "This field is required.";
                    $("#save").attr("disabled", true);
                    shouldSubmitForm = false;
                } else if (description == null || description == "") {
                    document.getElementById("category-error").innerHTML = "";
                    document.getElementById("name-error").innerHTML = "";
                    document.getElementById("videoLink-error").innerHTML = "";
                    document.getElementById("description-error").innerHTML = "This field is required.";
                    $("#save").attr("disabled", true);
                    shouldSubmitForm = false;
                } else {
                    // alert('hai');
                    document.getElementById("category-error").innerHTML = "";
                    document.getElementById("name-error").innerHTML = "";
                    document.getElementById("videoLink-error").innerHTML = "";
                    document.getElementById("description-error").innerHTML = "";
                    $("#save").attr("disabled", false);
                }
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
                title: 'Are you sure to edit this video?',
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
                title: 'Are you sure to delete this video?',
                text: 'All question will be deleted under this video!',
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
                title: 'Are you sure to activate video?',
                text: 'All question will be activated under this video!',
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
                title: 'Are you sure to disable this video?',
                text: 'All question will be disable under this video!',
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
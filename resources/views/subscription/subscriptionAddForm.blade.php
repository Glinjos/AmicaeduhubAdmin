@extends('admin/adminMaster')

@section('adminpanel')

<!-- STYLE FOR FULL DESCRIPTION VIEW-->

<style>
  .tooltip-pr {
  display: inline-block;
  width: 100px;
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


<!-- SUBSCRIPTION FORM -->


    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Subscription Plan</h2>

                        <form action="{{url('/subscription_add')}}" id="sub" enctype='multipart/form-data'  method="POST" onsubmit="return validater();" >
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
                                            
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Plan Name</b></label>
                                                <input type="text" id="planName" name="planName" placeholder="Enter plan name"  class="form-control"  onkeyup="return ValidationOnclick();" >
                                               
                                                @if ($errors->has('planName'))
                                                <div class="text-danger">{{ $errors->first('planName') }}</div>
                                            @endif

                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Description</b></label>
                                                <!-- <input type="text" id="description" name="description" placeholder="Enter offer price"  class="form-control"  onkeyup="return Validation_description()" > -->
                                                <br>



<!-- SCRIPT FOR DESCRIPTION TEXT AREA -->


                                                {{-- <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script> --}}
                                                <textarea name="planDescription" id="planDescription" onkeyup="return ValidationOnclick();" ></textarea> 
                                                <span id="planDescription-error" class="text-danger"></span>
                                                {{-- <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
                                                <script>
                                                CKEDITOR.replace( 'planDescription' );

                                                CKEDITOR.instances['planDescription'].on('change', function () {
                                                    //alert("Please enter a description");
                                                    var planDescription = CKEDITOR.instances['planDescription'].getData().trim();
                                                    if (planDescription === "") {
                                                    document.getElementById("planDescription-error").innerHTML = "Please enter a description";
                                                    } else {
                                                    document.getElementById("planDescription-error").innerHTML = "";
                                                    }
                                                });
                                                </script>  --}}
                                                <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>
                                                <script>
                                                    var descriptionEditor;
                                            
                                                    function validater() {
                                                        var planDescription = descriptionEditor.getData().trim();
                                                        
                                                        if (planDescription === "") {
                                                            document.getElementById("planDescription-error").innerHTML = "Please enter a description";
                                                            return false; // Prevent form submission
                                                        } else {
                                                            document.getElementById("planDescription-error").innerHTML = "";
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
                                                    initializeCKEditor('#planDescription').then((editor) => {
                                                        descriptionEditor = editor;
                                                        editor.model.document.on('change:data', validater);
                                                    });
                                                </script>
                                                

                                            </div>

                                            </div> <!-- /.col -->
                                            <div class="col-md-6">
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Actual Price</b></label>
                                                <input type="text" id="actualPrice" name="actualPrice" placeholder="Enter actual price"  class="form-control"  onkeyup="return ValidationOnclick();" >
                                               
                                                {{-- <span id="actualPrice-error" class="text-danger"></span> --}}
                                                @if ($errors->has('actualPrice'))
                                                <div class="text-danger">{{ $errors->first('actualPrice') }}</div>
                                            @endif
                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Offer Price</b></label>
                                                <input type="text" id="offerPrice" name="offerPrice" placeholder="Enter offer price"  class="form-control"  onkeyup="return ValidationOnclick();" >
                                               
                                                {{-- <span id="offerPrice-error" class="text-danger"></span> --}}
                                                @if ($errors->has('offerPrice'))
                                                <div class="text-danger">{{ $errors->first('offerPrice') }}</div>
                                            @endif
                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Plan Validity in Days</b></label>
                                                <input type="text" id="planValidity" name="planValidity" placeholder="Enter plan validity"  class="form-control"  onkeyup="return ValidationOnclick()"; >
                                               
                                                {{-- <span id="planValidity-error"  class="text-danger"></span> --}}
                                                @if ($errors->has('planValidity'))
                                                <div class="text-danger">{{ $errors->first('planValidity') }}</div>
                                            @endif
                                            </div>

                                            <div class="row">
                                            <div class="col-md-6">

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Previous Questions</b></label>
                                                <input type="checkbox" id="previousQuestion" name="previousQuestion" value="1" >
                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Video Classes</b></label>
                                                <input type="checkbox" id="videoClass" name="videoClass" value="1" >
                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Model Exams</b></label>
                                                <input type="checkbox" id="modelExams" name="modelExams" value="1" >
                                            </div>

                                            </div>
                                            <div class="col-md-6">

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Crash Course</b></label>
                                                <input type="checkbox" id="crashCourse" name="crashCourse" value="1" >
                                            </div>
                                            
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Game Zone</b></label>
                                                <input type="checkbox" id="gameZone" name="gameZone" value="1" >
                                            </div>

                                            </div>
                                            </div>
                                        
                                            <button class="btn btn-primary" id="bttnsubmit" type="submit" onclick="return ValidationOnclick();">Save</button>

                                    
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->
                    <br>
                </div>



<!-- SUBSCRIPTION DETAILS TABLE-->



                &nbsp;&nbsp;&nbsp;
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <h2 class="mb-2 page-title">Subscription Details</h2>
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
                                                        <th style="color: black;"><b>Plan Name</b></th>
                                                        <th style="color: black;"><b>Actual Price</b></th>
                                                       
                                                        <th style="color: black;"><b>Offer Price</b></th>
                                                        <th style="color: black;"><b>Description</b></th>
                                                        <th style="color: black;"><b>Plan Validity</b></th>
                                                       
                                                        <th style="color: black;"><b>Previous Questions</b></th>
                                                        <th style="color: black;"><b>Video Classes</b></th>
                                                        <th style="color: black;"><b>Crash Courses</b></th>
                                                        <th style="color: black;"><b>Game Zone</b></th>
                                                        <th style="color: black;"><b>Model Exams</b></th>

                                                        <th style="color: black;"><b>Action</b></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($subscription_details))
                                                    @php $i=1 @endphp
                                                    @foreach ($subscription_details as $item)
                                                        <tr style="color: black;">

                                                            <td width="65"><b>{{$i++}}</b></td>
                                                            <td width="20"> @if( $item->isExpired==0)
                                                                    <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                                @if( $item->isExpired==1)
                                                                    <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                            </td>
                                                            
                                                            <td>{{ $item->planName}}</td>
                                                            <td>{{ $item->actualPrice}}</td>
                                                            <td>{{ $item->offerPrice}}</td>
                                                            <td>
                                                            <div class="tooltip-pr">
                                                            <span class="tooltiptext-pr">
                                                            {!! $item->planDescription !!}
                                                            </span>
                                                            </div>
                                                            </td>


                                                            <td>{{ $item->planValidity}}</td>
                                                            
                                                            <td> @if( $item->previousQuestion==0)
                                                                <i class="fa fa-close" style="color:red" aria-hidden="true"></i>

                                                                @endif
                                                                @if( $item->previousQuestion==1)
                                                                <i class="fa fa-check" style="color:green" aria-hidden="true"></i>
                                                                @endif
                                                            </td>
                                                            <td> @if( $item->videoClass==0)
                                                                <i class="fa fa-close" style="color:red" aria-hidden="true"></i>

                                                                @endif
                                                                @if( $item->videoClass==1)
                                                                <i class="fa fa-check" style="color:green" aria-hidden="true"></i>
                                                                @endif
                                                            </td>
                                                            <td> @if( $item->crashCourse==0)
                                                                <i class="fa fa-close" style="color:red" aria-hidden="true"></i>

                                                                @endif
                                                                @if( $item->crashCourse==1)
                                                                <i class="fa fa-check" style="color:green" aria-hidden="true"></i>
                                                                @endif
                                                            </td>
                                                            <td> @if( $item->gameZone==0)
                                                                <i class="fa fa-close" style="color:red" aria-hidden="true"></i>

                                                                @endif
                                                                @if( $item->gameZone==1)
                                                                <i class="fa fa-check" style="color:green" aria-hidden="true"></i>
                                                                @endif
                                                            </td>
                                                            <td> @if( $item->modelExams==0)
                                                                <i class="fa fa-close" style="color:red" aria-hidden="true"></i>

                                                                @endif
                                                                @if( $item->modelExams==1)
                                                                <i class="fa fa-check" style="color:green" aria-hidden="true"></i>
                                                                @endif
                                                            </td>

                                                            <td width="250">
                                                            

                                                                <abbr style="text-decoration: none;" title="Edit Subscription"><a href="{{url('update_Subscription'.$item->planId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                @if( $item->isExpired==0)
                                                                    <abbr style="text-decoration: none;"  title="Deactivate Subscription"><a href="{{url('Inactive_Subscription/'.$item->planId)}}" style="text-decoration: none;" onclick="deActiveItem(event, this)"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                @endif
                                                                @if( $item->isExpired==1)
                                                                    <abbr style="text-decoration: none;" title="Activate Subscription"><a href="{{url('Active_Subscription/'.$item->planId)}}" style="text-decoration: none;" onclick="ActiveItem(event, this)"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                @endif
                                                                
                                                                
                                                               
                                                                
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


<!-- SCRIPTS -->



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- SCRIPT FOR DESCRIPTION FORM VALIDATION -->



    <script>
        ClassicEditor.create(document.querySelector('#planDescription'))
            .then(planDescription => {
                $('#bttnsubmit').click(function() {
                var editorData = planDescription.getData();
                if (editorData.trim() === '') {
                alert('Please enter some content');
                return;
                }
                // Validation passed, proceed with submitting the form or performing other actions
                });
                })
                .catch(error => {
                console.error(error);
                });
    </script>



<!-- SCRIPT FOR BUTTON CLICK VALIDATION -->


    <script>
    function ValidationOnclick()
    {
        var planDescription = CKEDITOR.instances.planDescription.getData().trim();
        
        
        
        let planName = document.getElementById('planName').value;
        let actualPrice = document.getElementById('actualPrice').value;
        let offerPrice = document.getElementById('offerPrice').value;
        let planValidity = document.getElementById('planValidity').value;
        // let planDescription = document.getElementById('planDescription').value;
        
        
         var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/,0-9?]/;
         var phoneformat = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/,A-Za-z?]/;






        if (planName == null || planName === ""){
            document.getElementById("planName-error").innerHTML = "Plan Name is required";      
            return false;
        }
        else {
          document.getElementById("planName-error").innerHTML = "";
        }

       if( planName.match(format)){
                document.getElementById("planName-error").innerHTML = "Restriction for numbers and symbols";
                return false;
        } else {
          document.getElementById("planName-error").innerHTML = "";
        }

         if (actualPrice == null || actualPrice === ""){
            document.getElementById("actualPrice-error").innerHTML = "Actual price is required";     
            return false;
        }
        else {
          document.getElementById("actualPrice-error").innerHTML = "";
        }
        if( actualPrice.match(phoneformat)){
                document.getElementById("actualPrice-error").innerHTML = "Restriction for Alphabets and symbols";
                return false;
        } else {
          document.getElementById("actualPrice-error").innerHTML = "";
        }



        if (offerPrice == null || offerPrice === ""){
            document.getElementById("offerPrice-error").innerHTML = "Offer price is required";     
            return false;
        }
        else {
          document.getElementById("offerPrice-error").innerHTML = "";
        }
        if( offerPrice.match(phoneformat)){
                document.getElementById("offerPrice-error").innerHTML = "Restriction for Alphabets and symbols";
                return false;
        } else {
          document.getElementById("offerPrice-error").innerHTML = "";
        }


        if (planDescription == null || planDescription === ""){
            document.getElementById("planDescription-error").innerHTML = "Plan description is required";     
            return false;
        }
        else {
          document.getElementById("planDescription-error").innerHTML = "";
        }
        



        if (planValidity == null || planValidity === ""){
            document.getElementById("planValidity-error").innerHTML = "Plan validity is required";     
            return false;
        }
        else {
          document.getElementById("planValidity-error").innerHTML = "";
        }
        if( planValidity.match(phoneformat)){
                document.getElementById("planValidity-error").innerHTML = "Restriction for Alphabets and symbols";
                return false;
        } else {
          document.getElementById("planValidity-error").innerHTML = "";
        }


        $("#bttnsubmit").on("click", function() {
                    $(this).attr("disabled", "disabled");

                    $(this).html("Saving...");

                    $("#sub").submit()


                });
        
        
       
             
        return true;


        

    }

</script>



<!-- SCRIPT FOR EDIT SUBSCRIPTION -->



    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this Plan?',
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



<!-- SCRIPT FOR DEACTIVATE SUBSCRIPTION -->


    <script>
        function deActiveItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to deactivate this Plan?',
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

<!-- SCRIPT FOR ACTIVATE SUBSCRIPTION -->


    <script>
        function ActiveItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to activate this Plan?',
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



<!-- SCRIPT FOR DATA TABLE -->

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

    






    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    
   

@endsection
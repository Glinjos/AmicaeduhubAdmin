@extends('admin/adminMaster')

@section('adminpanel')



    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Updation Subscription Plan</h2>
                        
                        @foreach ($subscription_details as $item)

<!-- SUBSCRIPTION ADD FORM -->
                        
                        <form action="{{url('Subscription_details_update/'.$item->planId)}}" id="sub" enctype='multipart/form-data'  method="POST">
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

<!-- PLAN NAME FORM FIELD --> 

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Plan Name</b></label>
                                                <input type="text" id="planName" name="planName" placeholder="Enter plan name" value="{{$item->planName}}" class="form-control"  onkeyup="return ValidationOnclick();" >
                                               
                                                {{-- <span id="planName-error" class="text-danger"></span> --}}
                                                @if ($errors->has('planName'))
                                                <div class="text-danger">{{ $errors->first('planName') }}</div>
                                            @endif
                                            </div>
<!-- DESCRIPTION FORM FIELD -->
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Description</b></label>
                                                <!-- <input type="text" id="description" name="description" placeholder="Enter offer price"  class="form-control"  onkeyup="return Validation_description()" > -->
                                                <br>
                                                <textarea name="planDescription" id="planDescription" onkeyup="return ValidationOnclick();">{!!$item->planDescription!!}</textarea> 
                                                <span id="planDescription-error" class="text-danger"></span>
                                                
<!-- SCRIPT FOR DECRIPTION FORM -->                                               
                                                {{-- <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
                                                <script>
                                                CKEDITOR.replace( 'planDescription' );
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

<!-- ACTUAL PRICE FORM FIELD -->

                                        <div class="col-md-6">
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Actual Price</b></label>
                                                <input type="text" id="actualPrice" name="actualPrice" placeholder="Enter actual price" value="{{$item->actualPrice}}"  class="form-control"  onkeyup="return ValidationOnclick();" >
                                               
                                                {{-- <span id="actualPrice-error" class="text-danger"></span> --}}
                                                @if ($errors->has('actualPrice'))
                                                <div class="text-danger">{{ $errors->first('actualPrice') }}</div>
                                            @endif
                                            </div>
<!-- OFFER PRICE FORM FIELD -->
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Offer Price</b></label>
                                                <input type="text" id="offerPrice" name="offerPrice" placeholder="Enter offer price" value="{{$item->offerPrice}}" class="form-control"  onkeyup="return ValidationOnclick();" >
                                               
                                                {{-- <span id="offerPrice-error" class="text-danger"></span> --}}
                                                @if ($errors->has('offerPrice'))
                                                <div class="text-danger">{{ $errors->first('offerPrice') }}</div>
                                            @endif
                                            </div>

<!-- PLAN VALIDITY FORM FIELD -->                                            
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Plan Validity In Days</b></label>
                                                <input type="text" id="planValidity" name="planValidity" placeholder="Enter plan validity" value="{{$item->planValidity}}" class="form-control"  onkeyup="return ValidationOnclick()"; >
                                               
                                                {{-- <span id="planValidity-error"  class="text-danger"></span> --}}
                                                @if ($errors->has('planValidity'))
                                                <div class="text-danger">{{ $errors->first('planValidity') }}</div>
                                            @endif
                                            </div>

                                    <div class="row">
                                            <div class="col-md-6">
<!-- CHECK BOXES FIELD -->
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Previous Questions</b></label>
                                                <input type="checkbox" id="previousQuestion" name="previousQuestion" value="1" {{ $item->previousQuestion==1 ? 'checked': '' }}>
                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Video Classes</b></label>
                                                <input type="checkbox" id="videoClass" name="videoClass" value="1" {{ $item->videoClass==1 ? 'checked': '' }}>
                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Model Exams</b></label>
                                                <input type="checkbox" id="modelExams" name="modelExams" value="1" {{ $item->modelExams==1 ? 'checked': '' }}>
                                            </div>

                                            </div>
                                            <div class="col-md-6">

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Crash Course</b></label>
                                                <input type="checkbox" id="crashCourse" name="crashCourse" value="1" {{ $item->crashCourse==1 ? 'checked': '' }}>
                                            </div>
                                            
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Game Zone</b></label>
                                                <input type="checkbox" id="gameZone" name="gameZone" value="1" {{ $item->gameZone==1 ? 'checked': '' }}>
                                            </div>

                                            </div>
                                            </div>

                                            <button class="btn btn-primary" id="bttnsubmit" type="submit" onclick="return ValidationOnclick();">Save</button>
                                        </div> <!-- /.col -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->
                    <br>
                </div>
            </div>
        </main> <!-- main -->
    </div>

<!-- SCRIPTS -->


<!-- SCRIPT FOR BUTTON CLICK VALIDATION -->
    <script>
    function ValidationOnclick()
    {
        
        
        let planName = document.getElementById('planName').value;
        let actualPrice = document.getElementById('actualPrice').value;
        let offerPrice = document.getElementById('offerPrice').value;
        let planDescription = document.getElementById('planDescription').value;
        let planValidity = document.getElementById('planValidity').value;
        
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
        
       
             
        return true;

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
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ]
            });
    </script>

    <!-- <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script> -->






    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    
   

@endsection
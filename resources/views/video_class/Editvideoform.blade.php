@extends('admin/adminMaster')


@section('adminpanel')

    <main role="main" class="main-content">
        <div class="container-fluid">
            @if (session('success'))
                <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
            @endif
            @if (session('error'))
                <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
            @endif
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="page-title">Update Video</h2>


                    @if(isset($video))

                        @foreach($video as $data)

                            <form action="/videoclsUpdateformdta/{{ $data->vcVDId }}" method="POST" onsubmit="return validater();" >
                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                                <input name="vcVDId" type="hidden" value="{{$data->vcVDId}}">
                                <input name="vcChapterId" type="hidden" value="{{$data->vcChapterId}}">

                                <div class="card shadow mb-4">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Video Heading</b></label>
                                                    <input type="hidden" id="videoheadNameOld"  value="{{$data->videoHeading}}" class="form-control" >
                                                    <input type="text" id="videohead" name="videohead" value="{{$data->videoHeading}}" placeholder="Enter video heading" onKeyup="return pqsmnameValidation()" class="form-control" >
                                                    @if ($errors->has('videohead'))
                                                        <span class="text-danger">{{ $errors->first('videohead') }}</span>
                                                    @endif
                                                    <span id="name-error" class="text-danger"></span>
                                                   

                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Video Link</b></label>
                                                    <input type="hidden" id="videoLinkOld"  value="{{$data->videoLink}}" class="form-control" >
                                                    <input type="text" id="videoLink" name="videoLink" value="{{$data->videoLink}}" placeholder="Enter video link" onKeyup="return videoLinkValidation()" class="form-control" >
                                                    @if ($errors->has('videoLink'))
                                                        <span class="text-danger">{{ $errors->first('videoLink') }}</span>
                                                    @endif
                                                    <span id="videoLink-error" class="text-danger"></span>
                                                   

                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Description</b></label>
                                                    {{-- <input type="hidden" id="descriptionOld"  value="{{$data->description}}" class="form-control" >
                                                    <input type="text" id="description" name="description" value="{{$data->description}}" placeholder="Enter description" onKeyup="return descriptionValidation()" class="form-control" >
                                                    @if ($errors->has('description'))
                                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                                    @endif
                                                    <span id="description-error" class="text-danger"></span> --}}

                                      <br>
                                                     <!-- SCRIPT FOR DESCRIPTION TEXT AREA -->


                                            {{-- <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script> --}}
                                            <input type="hidden" id="descriptionOld"  value="{{$data->description}}" class="form-control" >
                                            <textarea name="description" id="description" onkeyup="return descriptionValidation();" required>{{$data->description}}</textarea> 
                                            <span id="description-error" class="text-danger"></span>
                                            {{-- <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script> --}}
                                            {{-- <script>
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
                                            </script>  --}}
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
                                                

                                                <button type="submit" class="btn btn-primary">UPDATE</button>
                                            </div> <!-- /.col -->

                                        </div></div>
                                </div>
                               
                            </form>
                            @endforeach
                            @endif
                </div> <!-- / .card -->
            </div></div>



    </main> <!-- main -->




    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->

    <!---------------FORM JAVASCRIPT VALIDATION FOR NAME-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function pqsmnameValidation() {
            subCategoryNameOld = document.getElementById('videoheadNameOld').value;
            subCategoryName = document.getElementById('videohead').value;
           // alert(subCategoryName);
            let length = subCategoryName.length;
            if (subCategoryNameOld == subCategoryName) {

                //no change

            } else {

                // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/]/;

                if (subCategoryName == null || subCategoryName == "") {
                    document.getElementById("name-error").innerHTML = "This field is required.";
                }
               
                else {
                   // alert('subCategoryName');
                    document.getElementById("name-error").innerHTML = "";
                }
                // $.ajax({
                //     url: "{{url('/subcAjNameCheck')}}",
                //     type: "GET",
                //     data: {
                //         subcatname: subCategoryName,

                //         _token: '{{csrf_token()}}'
                //     },
                //     success: function (result) {


                //         if (result[0] != null) {

                //             //module name have a value to another module
                //             document.getElementById("pqsmname-error").innerHTML = "Subcategory name is already taken";
                //         } else {

                //         }
                //     }
                // });

            }
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
            subCategoryNameOld = document.getElementById('descriptionOld').value;
            subCategoryName = document.getElementById('description').value;
            let length = subCategoryName.length;
            if (subCategoryNameOld == subCategoryName) {

                //no change

            } else {

                // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/]/;

                if (subCategoryName == null || subCategoryName == "") {
                    document.getElementById("description-error").innerHTML = "This field is required.";
                }
                // else if( subCategoryName.match(format)){
                //     document.getElementById("pqsmname-error").innerHTML = "Subcategory Name field not contain any symbols!";
                //     return false;
                // }
                else {
                    document.getElementById("description-error").innerHTML = "";
                }
            }

        }

    </script>
    <script>
        function videoLinkValidation()
        {
            subCategoryNameOld = document.getElementById('videoLinkOld').value;
            subCategoryName = document.getElementById('videoLink').value;
            let length = subCategoryName.length;
            if (subCategoryNameOld == subCategoryName) {

                //no change

            } else {

                // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/]/;

                if (subCategoryName == null || subCategoryName == "") {
                    document.getElementById("videoLink-error").innerHTML = "This field is required.";
                }
                // else if( subCategoryName.match(format)){
                //     document.getElementById("pqsmname-error").innerHTML = "Subcategory Name field not contain any symbols!";
                //     return false;
                // }
                else {
                    document.getElementById("videoLink-error").innerHTML = "";
                }
            }

        }

    </script>

@endsection
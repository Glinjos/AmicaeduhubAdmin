@extends('admin/adminMaster')

@section('adminpanel')
<script src="path/to/ckeditor.js"></script>
<!-- Your CKEditor configurations and instances go here -->

    <style>
        .check-new {
            position: relative;
            width: 20px;
            height: 20px;
            border-radius: 2px;
            appearance: none;
            background-color: #bbb;
            transition: all .3s;
        }

        .check-new::before {
            content: '';
            position: absolute;
            border: solid #fff;
            display: block;
            width: .5em;
            height: .9em;
            border-width: 0 .2em .2em 0;
            z-index: 1;
            opacity: 0;
            right: calc(50% - .3em);
            top: calc(50% - .6em);
            transform: rotate(0deg);
            transition: all .3s;
            transform-origin: center center;
        }

        .check-new:checked {
            animation: a .4s ease-in forwards;
            background-color: rgb(120, 190, 120);
        }

        .check-new:checked::before {
            opacity: 1;
            transform: rotate(405deg);
        }

        @keyframes a {
            0% {
                opacity: 1;
                transform: scale(1) rotateY(0deg);
            }

            50% {
                opacity: 0;
                transform: scale(.8) rotateY(180deg);
            }

            100% {
                opacity: 1;
                transform: scale(1) rotateY(360deg);
            }
        }
    </style>

    <main role="main" class="main-content">

        <div class="container-fluid">



            <div class="row justify-content-center">

                <div class="col-12">

                    <div class="row">
                        <div class="col-6">
                            <h2>Add Previous Question & Answer</h2>
                        </div>
                        <div class="col-6 text-right">
                            <input type="button" onclick="window.location.href='/showPQA'" class="btn btn-primary btn-sm" style="background-color: rgb(6, 143, 153);" value="Show PQA">&nbsp;
                            <input type="button" onclick="window.location.href='/showapprovedsuperadminimagePqa'" class="btn btn-primary btn-sm" style="background-color: rgb(5, 78, 138);" value="Show ImagePQA">
                            &nbsp;
                            <input type="button" onclick="window.location.href='/showdraftsuperadminimagePqa'" class="btn btn-primary btn-sm" style="background-color: rgb(109, 10, 122);" value="Show Draft ImagePQA">
                        </div>
                       
                      </div>

                      <style>
                        .custom-btn-height {
                          height: 30px;
                        }
                      
                      </style>
                    
                    
                    
                    
                    
                    
                    
                    

                    <form action="/previousQuestionSave" id="pqform" method="post" onsubmit="return isUnitSelected();">

                        @csrf

                        <div class="card shadow mb-4">



                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-12">

                                        @if (session('success'))
                                            <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                        @endif
                                        
                                        @if (session('pqmid'))
                                       
                                        <script>
                                                window.onload = function  () {
                                                   
                                                     myExamFunction();
                                                     myFunction();
                                                    let smcode = document.getElementById("smcode").value;
                                                  //  console.log("test : "+smcode);
                                                          
                                                          document.getElementById("addQuestion").style.display = 'block';

                                                    
                                                         
                                                    //alert("my second time to show addquestion  loaded");
                                                };
                                            </script> 
                                       @endif

                                       
                                       
                                      
                                        @if (session('error'))
                                            <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                        @endif
                                        
                                        
                                        
                                         <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                                         
                                         
<!------------------------------------------------------------------------------------------------------------------------------------------>
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
                                       

<!------------------------------------------------------------------------------------------------------------------------------------------------------>
                                       <div id="category" style="display: none">  
                                           <label for="module"><b style="color: black">Exam Year</b></label>

                                            <select class="form-control" name="module" id="c_name" onChange="return myFunction()">

                                            {{-- <option value=" " disabled selected>--Select exam year--</option> --}}

                                            {{-- @foreach($categoryView as $item)
                                                <option value="{{$item->pqmId}}"  {{ $item->pqmId == session('pqmId') ? 'selected' : '' }} >{{$item->pqmName}}</option>
                                            @endforeach --}}

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select><br>

                                    </div>



                                        {{--DropDown for subModule--}}

                                        <div id="btn" style="display: none">

                                            <label for="submodule"><b style="color: black;" >Exam Name</b></label>

                                            <div class="form-group mb-3">

                                                <select id="smcode" class="form-control" name="smodule"  onchange="return addQuestion()">

                                                </select>

                                            </div>
                                      
                                    

                                        </div>



                                        {{--Question add form--}}

                                        <div id="addQuestion" style="display: none">



                                            <br>
                                            <label>
                                                <input type="radio" name="group1" id="normalRadio" value="07" onclick="questionMode();" checked>&nbsp;<b style="color: black;">Text Based</b>
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            
                                            <label>
                                                <input type="radio" name="group1" id="imageRadio" value="08" onclick="questionMode();">&nbsp;<b style="color: black;">Image Based</b>
                                            </label>
                                            
                                            <br>
                                            <script>
                                                function questionMode() {
                                                    var selectedValue = document.querySelector('input[name="group1"]:checked').value;
                                                    var normalValue = document.getElementById('normalRadio').value;
                                                    var imageValue = document.getElementById('imageRadio').value;
                                            
                                                    if (selectedValue === imageValue) {
                                                        document.getElementById('normal_quest').style.display = 'none';
                                                        document.getElementById('images_quest').style.display = 'block';
                                                    } else {
                                                        document.getElementById('normal_quest').style.display = 'block';
                                                        document.getElementById('images_quest').style.display = 'none';
                                                    }
                                                }
                                            </script>
                                        
                                        

                                            

<style>
    .flex-style{
        flex-wrap: nowrap;
        display: flex;
    }
    .check-new{
        width: 34px;
        height: 34px;
        margin-right:8px;
    }
</style>









        <br>

        <p><label for="question"><b style="color: black;">Question :</b> </label></p>

        {{-- this is the normal question insertion form --}}

                        <div style="display: block" id="normal_quest">
                            <textarea id="question" name="question" rows="4" cols="50" style="flex-wrap: wrap;" class="form-control"
                                placeholder="Enter question" onkeyup="return quesVal()" onblur="validate()"></textarea>
                            <span id="question-error" class="text-danger"></span>
                            @if ($errors->has('question'))
                            <span class="text-danger">{{ $errors->first('question') }}</span>
                            @endif <br><br>

                            <div class="col-12">

                                <p><label for="option1"><b style="color: black;">Option 1 :</b> </label></p>
                                <div class="flex-style">
                                    <input type="radio" id="option1" name="answer" value="option1" class="check-new">
                                    <input type="text" name="option1" id="option_1" class="form-control" placeholder="Enter option 1" onkeyup="return op1Val();" onblur="validate()">
                                  
                                    @if ($errors->has('option1'))
                                        <span class="text-danger">{{ $errors->first('option1') }}</span>
                                    @endif
                                </div>
                                <span id="option1-error" class="text-danger"></span>
                                <br><br>
                                


                                <p><label for="option2"><b style="color: black;">Option 2 :</b> </label></p>
                                <div class="flex-style">
                                    <input type="radio" id="option2" name="answer" value="option2" class="check-new">
                                    <input type="text" name="option2" id="option_2" class="form-control" placeholder="Enter option 2" onkeyup="return op2Val()" onblur="validate()">
                                   
                                    @if ($errors->has('option2'))
                                        <span class="text-danger">{{ $errors->first('option2') }}</span>
                                    @endif
                                </div>
                                <span id="option2-error" class="text-danger"></span>
                                <br><br>


                                <p><label for="option3"><b style="color: black;">Option 3 :</b> </label></p>
                                <div class="flex-style">
                                    <input type="radio" id="option3" name="answer" value="option3" class="check-new">
                                    <input type="text" name="option3" id="option_3" class="form-control" placeholder="Enter option 3" onkeyup="return op3Val()" onblur="validate()">
                                    
                                    @if ($errors->has('option3'))
                                        <span class="text-danger">{{ $errors->first('option3') }}</span>
                                    @endif
                                </div>
                                <span id="option3-error" class="text-danger"></span>
                                <br><br>

                                <p><label for="option4"><b style="color: black;">Option 4 :</b> </label></p>
                                <div class="flex-style">
                                    <input type="radio" id="option4" name="answer" value="option4" class="check-new">
                                    <input type="text" name="option4" id="option_4" class="form-control" placeholder="Enter option 4" onkeyup="return op4Val()" onblur="validate()">
                                   
                                    @if ($errors->has('option4'))
                                        <span class="text-danger">{{ $errors->first('option4') }}</span>
                                    @endif
                                </div>
                                <span id="option4-error" class="text-danger"></span>
                                <br><br>

                            </div>
                        </div>

                  {{-- nd  this is the normal question insertion form       --}}















<div style="display: none" id="images_quest">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>
    {{-- onkeyup="IMAGEquesVal()" onblur="validate()" --}}
   <textarea name="questionIMAGE" id="questionIMAGE" placeholder="Enter question" ></textarea>

{{-- <script>
    
    CKEDITOR.ClassicEditor.create(document.querySelector('#questionIMAGE'), {
        ckfinder: {
            uploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token()}}"
        },
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'undo', 'redo',
                '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'uploadImage', 'blockQuote', 'insertTable', '|',
                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
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
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
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
    }).then(question1imagepassValid => {
        // Attach an event listener to the CKEditor content change
        question1imagepassValid.model.document.on('change:data', () => {
            if (question1imagepassValid.getData().length > 0) {
                $('label[for="questionIMAGE"]').hide();
                document.getElementById("questionIMAGE-error").innerHTML = "";
                validate(question1imagepassValid);
            } else {
                $('label[for="questionIMAGE"]').show();
                document.getElementById("questionIMAGE-error").innerHTML = "Question cannot be empty";
                $("#savebutton").attr("disabled", true);
            }
        });
    });
    
    


   

</script> --}}



    <span id="questionIMAGE-error" class="text-danger"></span>
    @if ($errors->has('questionIMAGE'))
    <span class="text-danger">{{ $errors->first('questionIMAGE') }}</span>
    @endif <br><br>










    <div class="col-12">

        <p><label for="option1image"><b style="color: black;">Option 1 :</b> </label></p>
    <div class="flex-style">
        <input type="radio" id="option1image" name="answerImage" value="option1image" class="check-new">
        <textarea name="option_1image" id="option_1image"  placeholder="Enter option 1" ></textarea>
       
        @if ($errors->has('option_1image'))
            <span class="text-danger">{{ $errors->first('option_1image') }}</span>
        @endif
    </div>
    <span id="option_1image-error" class="text-danger"></span>
{{-- <script>
CKEDITOR.ClassicEditor.create( document.querySelector( '#option_1image' ), {

ckfinder:{
      uploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token()}}"

        },

  toolbar: {
      items: [

          'heading', '|',
          'bold', 'italic', 'strikethrough', 'underline', '|',
          'bulletedList', 'numberedList', 'todoList', '|',

          'undo', 'redo',
          '-',
          'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
          'alignment', '|',
          'link','uploadImage', 'blockQuote', 'insertTable',  '|',
          'specialCharacters', 'horizontalLine', 'pageBreak', '|',

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
      options: [ 10, 12, 14, 'default', 18, 20, 22 ],
      supportAllValues: true
  },



  link: {
      decorators: {
          addTargetToExternalLinks: true,
          defaultProtocol: 'https://',
          toggleDownloadable: {
              mode: 'manual',
              label: 'Downloadable',
              attributes: {
                  download: 'file'
              }
          }
      }
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
}).then(option1imagepassValid => {
        // Attach an event listener to the CKEditor content change
        option1imagepassValid.model.document.on('change:data', () => {
            if (option1imagepassValid.getData().length > 0) {
                $('label[for="option_1image"]').hide();
                document.getElementById("option_1image-error").innerHTML = "";
                validate(option1imagepassValid);
            } else {
                $('label[for="option_1image"]').show();
                document.getElementById("option_1image-error").innerHTML = "option cannot be empty";
                $("#savebutton").attr("disabled", true);
            }
        });
    });

       
    </script> --}}
        <br><br>
        


        <p><label for="option2image"><b style="color: black;">Option 2 :</b> </label></p>
        <div class="flex-style">
            <input type="radio" id="option2image" name="answerImage" value="option2image" class="check-new">
            <textarea name="option_2image" id="option_2image" placeholder="Enter option 2" ></textarea>
            
           
            @if ($errors->has('option_2image'))
                <span class="text-danger">{{ $errors->first('option_2image') }}</span>
            @endif
        </div>
        <span id="option_2image-error" class="text-danger"></span>
{{-- <script>
CKEDITOR.ClassicEditor.create( document.querySelector( '#option_2image' ), {

ckfinder:{
     uploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token()}}"

            },

  toolbar: {
      items: [

          'heading', '|',
          'bold', 'italic', 'strikethrough', 'underline', '|',
          'bulletedList', 'numberedList', 'todoList', '|',

          'undo', 'redo',
          '-',
          'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
          'alignment', '|',
          'link','uploadImage', 'blockQuote', 'insertTable',  '|',
          'specialCharacters', 'horizontalLine', 'pageBreak', '|',

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
      options: [ 10, 12, 14, 'default', 18, 20, 22 ],
      supportAllValues: true
  },



  link: {
      decorators: {
          addTargetToExternalLinks: true,
          defaultProtocol: 'https://',
          toggleDownloadable: {
              mode: 'manual',
              label: 'Downloadable',
              attributes: {
                  download: 'file'
              }
          }
      }
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
}).then(option2imagepassValid => {
        // Attach an event listener to the CKEditor content change
        option2imagepassValid.model.document.on('change:data', () => {
            if (option2imagepassValid.getData().length > 0) {
                $('label[for="option_2image"]').hide();
                document.getElementById("option_2image-error").innerHTML = "";
                validate(option2imagepassValid);
            } else {
                $('label[for="option_2image"]').show();
                document.getElementById("option_2image-error").innerHTML = "option cannot be empty";
                $("#savebutton").attr("disabled", true);
            }
        });
    });



          
        </script> --}}
        <br><br>


        <p><label for="option3image"><b style="color: black;">Option 3 :</b> </label></p>
        <div class="flex-style">
            <input type="radio" id="option3image" name="answerImage" value="option3image" class="check-new">
            <textarea name="option_3image" id="option_3image"  placeholder="Enter option 3" ></textarea>
            
            
            @if ($errors->has('option_3image'))
                <span class="text-danger">{{ $errors->first('option_3image') }}</span>
            @endif
        </div>
        <span id="option_3image-error" class="text-danger"></span>
{{-- <script>
CKEDITOR.ClassicEditor.create( document.querySelector( '#option_3image' ), {

ckfinder:{
     uploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token()}}"

          },

  toolbar: {
      items: [

          'heading', '|',
          'bold', 'italic', 'strikethrough', 'underline', '|',
          'bulletedList', 'numberedList', 'todoList', '|',

          'undo', 'redo',
          '-',
          'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
          'alignment', '|',
          'link','uploadImage', 'blockQuote', 'insertTable',  '|',
          'specialCharacters', 'horizontalLine', 'pageBreak', '|',

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
      options: [ 10, 12, 14, 'default', 18, 20, 22 ],
      supportAllValues: true
  },



  link: {
      decorators: {
          addTargetToExternalLinks: true,
          defaultProtocol: 'https://',
          toggleDownloadable: {
              mode: 'manual',
              label: 'Downloadable',
              attributes: {
                  download: 'file'
              }
          }
      }
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
}).then(option3imagepassValid => {
        // Attach an event listener to the CKEditor content change
        option3imagepassValid.model.document.on('change:data', () => {
            if (option3imagepassValid.getData().length > 0) {
                $('label[for="option_3image"]').hide();
                document.getElementById("option_3image-error").innerHTML = "";
                validate(option3imagepassValid);
            } else {
                $('label[for="option_3image"]').show();
                document.getElementById("option_3image-error").innerHTML = "option cannot be empty";
                $("#savebutton").attr("disabled", true);
            }
        });
    });



           
        </script> --}}
        <br><br>

        <p><label for="option4image"><b style="color: black;">Option 4 :</b> </label></p>
        <div class="flex-style">
            <input type="radio" id="option4image" name="answerImage" value="option4image" class="check-new">
            <textarea name="option_4image" id="option_4image"  placeholder="Enter option 4" ></textarea>
            
            
            @if ($errors->has('option_4image'))
                <span class="text-danger">{{ $errors->first('option_4image') }}</span>
            @endif
        </div>
        <span id="option_4image-error" class="text-danger"></span>
        
         
        <script>
            
            var editors = [];
            
          
        
            function validater() {
                var allContent = editors.map(editor => editor.getData().trim());
                var isEmpty = allContent.some(checkEmpty);
        
              //  console.log('Content values:', allContent);
        
                if (isEmpty) {
                   // console.log('At least one editor is empty');
                    $("#savebutton").attr("disabled", true);
                } else {
                  //  console.log('All editors have value');
                    $("#savebutton").attr("disabled", false);
                }
            }
        
            function checkEmpty(value) {
                return value === '';
            }
        
            function initializeCKEditor(selector) {
                return new Promise((resolve) => {
                    CKEDITOR.ClassicEditor.create(document.querySelector(selector), {
                        ckfinder: {
                  uploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token()}}"
                },
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
                  options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                  supportAllValues: true
                },
                link: {
                  decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                      mode: 'manual',
                      label: 'Downloadable',
                      attributes: {
                        download: 'file'
                      }
                    }
                  }
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
        
            
            Promise.all([
                initializeCKEditor('#questionIMAGE'),
                initializeCKEditor('#option_1image'),
                initializeCKEditor('#option_2image'),
                initializeCKEditor('#option_3image'),
                initializeCKEditor('#option_4image')
            ]).then((instances) => {
                editors = instances;
        
                
                editors.forEach(editor => {
                    editor.model.document.on('change:data', validater);
                });
            });
        </script>
       




        
        
          
  
  
{{-- <script>
CKEDITOR.ClassicEditor.create( document.querySelector( '#option_4image' ), {

ckfinder:{
   uploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token()}}"

       },

  toolbar: {
      items: [

          'heading', '|',
          'bold', 'italic', 'strikethrough', 'underline', '|',
          'bulletedList', 'numberedList', 'todoList', '|',

          'undo', 'redo',
          '-',
          'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
          'alignment', '|',
          'link','uploadImage', 'blockQuote', 'insertTable',  '|',
          'specialCharacters', 'horizontalLine', 'pageBreak', '|',

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
      options: [ 10, 12, 14, 'default', 18, 20, 22 ],
      supportAllValues: true
  },



  link: {
      decorators: {
          addTargetToExternalLinks: true,
          defaultProtocol: 'https://',
          toggleDownloadable: {
              mode: 'manual',
              label: 'Downloadable',
              attributes: {
                  download: 'file'
              }
          }
      }
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
}).then(option4imagepassValid => {
        // Attach an event listener to the CKEditor content change
        option4imagepassValid.model.document.on('change:data', () => {
            if (option4imagepassValid.getData().length > 0) {
                $('label[for="option_4image"]').hide();
                document.getElementById("option_4image-error").innerHTML = "";
                validate(option4imagepassValid);
            } else {
                $('label[for="option_4image"]').show();
                document.getElementById("option_4image-error").innerHTML = "option cannot be empty";
                $("#savebutton").attr("disabled", true);
            }
        });
    });


          
        </script> --}}
        <br><br>

    </div>
</div>
















                                                   

<input type="submit" id="savebutton"onClick="return isUnitSelected();this.form.submit(); this.disabled=true; this.value='Sending…'; " value="Save" class="btn mb-2 btn-primary" disabled="disabled">



   <script>
       document.querySelector('#pqform').addEventListener('submit', function() {
           document.querySelector('#savebutton').setAttribute('disabled', 'disabled');
       });
   </script>







                                                









                                        </div>



                                    </div> <!-- /.col -->



                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div> <!-- / .card -->

    </main> <!-- main -->

    <?php if(!empty(session('pqmid'))){
        $moduleid=session('pqmid');
       
     }
     else{
        $moduleid="";
     }?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <script>
        function myExamFunction(){
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
              //  console.log(result)
                document.getElementById("category").style.display = 'block';

                           $('#c_name').html('<option value="" disabled selected>--Select exam year--</option>');

                           $.each(result, function(key, value) {

                               (value.pqmId == mid) ? sel="selected" :  sel="null";

                               $('#c_name').append('<option value="'+value.pqmId+'"  '+sel+' >' + value.pqmName + '</option>');

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
                                window.location.href = "/toPQA";
                            }
                        });

                  }
    }}})}
</script>




    {{--View Submoduld ajax--}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script type="text/javascript">

        function isUnitSelected() {
            var selectedValue = document.querySelector('input[name="group1"]:checked').value;
             var normalValue = document.getElementById('normalRadio').value;
             var imageValue = document.getElementById('imageRadio').value;
                                            
             if (selectedValue === imageValue) {

                const radios = document.querySelectorAll('input[name="answerImage"]');

                const selected = [...radios].some(radio => radio.checked);

                if (!selected) {

                    event.preventDefault(); // prevent the default link behavior

                // Show the SweetAlert confirmation dialog
                        Swal.fire({
                        // title: 'Are you sure edit this submodule?',
                             text: 'Please select a currect answer',
                           // text: 'Please select image',
                            icon: 'warning',
                        // showCancelButton: true,
                            confirmButtonText: 'OK',
                            //cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // If the user confirms the deletion, redirect to the delete URL
                                window.location.href = element.href;
                            }
                        });


                }
                
             } else {
                
                const radios = document.querySelectorAll('input[name="answer"]');

                const selected = [...radios].some(radio => radio.checked);

                if (!selected) {

                    event.preventDefault(); // prevent the default link behavior

    // Show the SweetAlert confirmation dialog
                        Swal.fire({
                        // title: 'Are you sure edit this submodule?',
                            text: 'Please select a currect answer',
                            icon: 'warning',
                        // showCancelButton: true,
                            confirmButtonText: 'OK',
                            //cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // If the user confirms the deletion, redirect to the delete URL
                                window.location.href = element.href;
                            }
                        });


                }

               // console.log('normal_shit');
             }

           



        }


</script>

<?php if(!empty(session('pqsmid'))){
     $submoduleid=session('pqsmid');
    
  }
  else{
     $submoduleid="";
  }?>

 <script>
     
     function myFunction() {

            // console.log('myFunction() called');
             var categoryid=document.getElementById('c_name').value;
             var submid='<?php echo $submoduleid; ?>';
             var mid='<?php echo $moduleid; ?>';

             if(!categoryid)
             {
               categoryid = mid;
             }
             //alert(categoryid);
            // var submid=null;
             
            //alert(submid);
          

              var sel = null;

      
                $.ajax({

                    url: "{{url('/pqSubModuleCheck')}}",

                    type: "GET",

                    data: {

                        pqmid: categoryid,

                        _token: '{{csrf_token()}}'

                    },

                    success: function(result) {

                        if (result) {
                           // console.log(result);
                           
                            if(result.length>0){
                                        document.getElementById("btn").style.display = 'block';



                                        $('#smcode').html('<option value="" disabled selected>--Select exam name--</option>');

                                        $.each(result, function(key, value) {

                                            (value.pqsmId == submid) ? sel="selected" :  sel="null";

                                            $('#smcode').append('<option value="'+value.pqsmId+'"  '+sel+' >' + value.pqsmName + '</option>');

                                        });
                                    }else{

                                        document.getElementById("btn").style.display="none";
                                        document.getElementById("addQuestion").style.display = 'none';
                              // document.getElementById("text_smname").style.display = 'none';
                                                        //alert("please insert submodule");
                                                        
                                                       

                                  event.preventDefault(); // prevent the default link behavior

                                                        // Show the SweetAlert confirmation dialog
                                                                Swal.fire({
                                                                    title: 'No subcategory found !',
                                                                    text: 'Please add a subcategory to the corresponding category',
                                                                    icon: 'warning',
                                                                 showCancelButton: true,
                                                                    confirmButtonText: 'Add Now',
                                                                    cancelButtonText: 'Cancel',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // If the user confirms the deletion, redirect to the delete URL
                                                                        window.location.href = "/subcategory";
                                                                    }else{
                                                                        window.location.href = "/toPQA";
                                                                    }
                                                                });

                                    }
                            }
                    }
                });
            };
        

    </script>
<script>
#smcode {
    display: block !important;
}
</script>

    {{--View question add form javascript--}}

    <script>

        function addQuestion() {



            let smcode = document.getElementById("smcode").value;

            if(!smcode==""){
                //questionMode();
                document.getElementById("addQuestion").style.display = 'block';
              //  document.getElementById("normail_quest").style.display = 'block';
                

            }else{
               // questionMode();
                document.getElementById("addQuestion").style.display = 'none';
                //document.getElementById("normail_quest").style.display = 'none';
                

            }

        }



    </script>


   {{-- validation image --}}
   <script>
    

    function IMAGEop1Val(){
       // console.log('hai');
       // var option1 = document.getElementById('option_1image').value;
        var option1 = CKEDITOR.instances['option_1image'].getData().trim();
          // console.log(option1);
         //  console.log('hai');
        if (option1 == null||option1 == ""){
            document.getElementById("option_1image-error").innerHTML = "This field is required.";
            return false;
        } else {
            document.getElementById("option_1image-error").innerHTML = "";
            return true;
        }
    }

    function IMAGEop2Val(){
        let option2 = CKEDITOR.instances['option_2image'].getData().trim();
       // document.getElementById('option_2image').value;

        if (option2 == null||option2 == ""){
            document.getElementById("option_2image-error").innerHTML = "This field is required.";
            return false;
        } else {
            document.getElementById("option_2image-error").innerHTML = "";
            return true;
        }
    }

    function IMAGEop3Val(){
        let option3 = CKEDITOR.instances['option_3image'].getData().trim();
       // document.getElementById('option_3image').value;

        if (option3 == null||option3 == ""){
            document.getElementById("option_3image-error").innerHTML = "This field is required.";
            return false;
        } else {
            document.getElementById("option_3image-error").innerHTML = "";
            return true;
        }
    }

    function IMAGEop4Val(){
        let option4 = CKEDITOR.instances['option_4image'].getData().trim();
        //document.getElementById('option_4image').value;

        if (option4 == null||option4 == ""){
            document.getElementById("option_4image-error").innerHTML = "This field is required.";
            return false;
        } else {
            document.getElementById("option_4image-error").innerHTML = "";
            return true;
        }
    }

    // function ansVal(){
    //     let radios = document.getElementByName('answer').value;

    //     if(radios == null || radios == ""){
    //         alert("Must check some option!");
    //         return false;
    //     }
    // }

</script>

   {{-- end --}}









    {{--Javascript validation for normal form--}}
    <script>
        function quesVal(){
            var question = document.getElementById('question').value;

            if (question == null||question == ""){
                document.getElementById("question-error").innerHTML = "This field is required.";
                $("#savebutton").attr("disabled", true);
                return false;
            } else {
                document.getElementById("question-error").innerHTML = "";
                $("#savebutton").attr("disabled", false);
                return true;
            }
        }

        function op1Val(){
            var option1 = document.getElementById('option_1').value;
          //  console.log(option1);

            if (option1 == null||option1 == ""){
                document.getElementById("option1-error").innerHTML = "This field is required.";
                $("#savebutton").attr("disabled", true);
                return false;
            } else {
                document.getElementById("option1-error").innerHTML = "";
                $("#savebutton").attr("disabled", false);
                return true;
            }
        }

        function op2Val(){
            let option2 = document.getElementById('option_2').value;

            if (option2 == null||option2 == ""){
                document.getElementById("option2-error").innerHTML = "This field is required.";
                $("#savebutton").attr("disabled", true);
                return false;
            } else {
                document.getElementById("option2-error").innerHTML = "";
                $("#savebutton").attr("disabled", false);
                return true;
            }
        }

        function op3Val(){
            let option3 = document.getElementById('option_3').value;

            if (option3 == null||option3 == ""){
                document.getElementById("option3-error").innerHTML = "This field is required.";
                $("#savebutton").attr("disabled", true);
                return false;
            } else {
                document.getElementById("option3-error").innerHTML = "";
                $("#savebutton").attr("disabled", false);
                return true;
            }
        }

        function op4Val(){
            let option4 = document.getElementById('option_4').value;

            if (option4 == null||option4 == ""){
                document.getElementById("option4-error").innerHTML = "This field is required.";
                $("#savebutton").attr("disabled", true);
                return false;
            } else {
                document.getElementById("option4-error").innerHTML = "";
                $("#savebutton").attr("disabled", false);
                return true;
            }
        }

        // function ansVal(){
        //     let radios = document.getElementByName('answer').value;

        //     if(radios == null || radios == ""){
        //         alert("Must check some option!");
        //         return false;
        //     }
        // }

    </script>



  {{-- validation for question --}}
  <script>
    function questionVal(editor) {
        console.log('questionIMAGE ===');
        var questionIMAGE = editor.getData().trim();
        console.log(questionIMAGE);
    
        if (checkEmpty(questionIMAGE)) {
            console.log('Question image is empty');
            $("#savebutton").attr("disabled", true);
        } else {
            console.log('All images have values');
            option1Val();
        }
    }
    
    function option1Val(editor) {
        console.log('option_1image ===');
        var option_1image = editor.getData().trim();
        console.log(option_1image);
    
        if (checkEmpty(option_1image)) {
            console.log('Option 1 image is empty');
            $("#savebutton").attr("disabled", true);
        } else {
            console.log('All images have values');
            $("#savebutton").attr("disabled", false);
        }
    }
    </script>
    
  
 {{-- validation for option 1 --}}
 


    {{--Script to disable save button until all fields have values--}}
    <script>
         function checkEmpty(value) {
                return value === '';
            }
        function validate(editor) {
             var selectedValue = document.querySelector('input[name="group1"]:checked').value;
             var normalValue = document.getElementById('normalRadio').value;
             var imageValue = document.getElementById('imageRadio').value;
                         
             if (selectedValue === imageValue) {
                 
                // console.log('imageValue ==='); 
                // var questionIMAGE = editor.getData().trim();
                // var option_1image = editor.getData().trim();
                // var option_2image = editor.getData().trim();
                // var option_3image = editor.getData().trim();
                // var option_4image = editor.getData().trim();

                // console.log(questionIMAGE);

                // if (checkEmpty(questionIMAGE)) {
                // console.log('Question image is empty');
                // $("#savebutton").attr("disabled", true);
                // } else if (checkEmpty(option_1image)) {
                // console.log('Option 1 image is empty');
                // $("#savebutton").attr("disabled", true);
                // } else if (checkEmpty(option_2image)) {
                // console.log('Option 2 image is empty');
                // $("#savebutton").attr("disabled", true);
                // } else if (checkEmpty(option_3image)) {
                // console.log('Option 3 image is empty');
                // $("#savebutton").attr("disabled", true);
                // } else if (checkEmpty(option_4image)) {
                // console.log('Option 4 image is empty');
                // $("#savebutton").attr("disabled", true);
                // } else {
                // console.log('All images have values');
                // $("#savebutton").attr("disabled", false);
                // }
            

           


           

                
             } else {
                
              //  console.log('dhit');

                var valid = true;
                valid = checkEmpty($("#question")) && checkEmpty($("#option_1")) && checkEmpty($("#option_2")) && checkEmpty($("#option_3")) && checkEmpty($("#option_4"));

                $("#savebutton").attr("disabled",true);
                if(valid) {
                    $("#savebutton").attr("disabled",false);
                }

               // console.log('normal_shit');
             }

           
        
        }
        function checkEmpty(obj) {
            var name = $(obj).attr("name");
            $("."+name+"-validation").html("");
            $(obj).css("border","");
            if($(obj).val() == "") {
                $(obj).css("border","#FF0000 1px solid");
                $("."+name+"-validation").html("Required");
                return false;
            }

            return true;
        }
    </script>

@endsection
@extends('admin.adminMaster')

@section('adminpanel')
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

                    <h2>Update Image Base Added Previous Question & Answer</h2>

                    <form action="/approvedImagebasePreviousQuestionUpdate" method="post"  onsubmit="return isUnitSelected()">

                        @csrf


                        <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">

                        
                        <div class="card shadow mb-4">



                            <div class="card-body">

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

                                <div class="row">
                                
                                    <div class="col-md-12">
                                   
                                        @if (session('success'))
                                            <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                        @endif
                                        <!-- @if (session('mid'))
                                        <script>
                                                window.onload = function  () {
                                                     myFunction();
                                                    let smcode = document.getElementById("smcode").value;
                                                    console.log("test : "+smcode);
                                                          
                                                          document.getElementById("addQuestion").style.display = 'block';

                                                    // addQuestion();
                                                         
                                                    //alert("my second time to show addquestion  loaded");
                                                };
                                            </script> 
                                       @endif -->
                                      
                                       
                                        @if (session('error'))
                                            <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                        @endif
                                     
                                
                                        {{--DropDown for Module--}}
                                        
                            <div class="col-12">

                                        @foreach($allQuestions as $item)
                                        <!------------------------------------------EXAM TYPE---------------------------->
                                        <input type="text" style="width:450px" name="pqmainId" id="pqmainId" value="{{$item->pqmainId}}" class="form-control" hidden><br>

                                        <label for="examname"><b style="color: black;">Exam Type :</b> </label><br>
                                        <div class="flex-style">
                                        <abbr style="text-decoration: none;" title="Change Exam"><h1 class="fe fe-30 fe-edit" style="color: #007bff" onclick="return showExamedit()" id="examNameeditlogo"></h1></abbr>
                                        <input type="text"  name="examName" id="examName" class="form-control"  value="{{$item->pqmainName}}" disabled>
                                        </div>


                                        <!-- 

                                         -->
                                         <div id="edit_div_examname" style="display: none" >
                                            <select name="showexamdropdown" id="showexamdropdown" value="{{$item->pqmainId}}" onclick="return isUnitSelected();"  onchange="return showmoduleedit()" class="form-control">
                                            </select>
                                            <span id="examdrop-error" class="text-danger"></span>
                                        </div> 
                                   <script>
                                        function showExamedit(){
                                           
                                            var examidinput=document.getElementById("pqmainId").value;
                                            var examidfromdropdown = document.getElementById("showexamdropdown").value;

                                            if(examidfromdropdown==""){
                                                examid=examidinput;   //VALUE FROM INPUT MODULEID
                                            
                                            }else{
                                                examid=examidinput; //VALUE FROM DROPDOWN MODULEID
                                            }
                                            
                                            $.ajax({
                                                url: "{{url('/draftImageBasespExamTypeshow')}}",
                                                type: "GET",
                                                data: {
                                                    pqmainId: examid,
                                                    _token: '{{csrf_token()}}'
                                                },
                                            
                                               
                                                success: function(result)
                                                
                                                {
                                                   // console.log(result);
                                                    if (result) {

                                                        document.getElementById("edit_div_examname").style.display="block";
                                                        //document.getElementById("edit_div_modulename").style.display="block";
                                                        //document.getElementById("edit_div_submodulename").style.display="block";
                                                        document.getElementById("examName").style.display="none";
                                                        document.getElementById("mName").style.display="none";
                                                        document.getElementById("smName").style.display="none";
                                                        document.getElementById("examNameeditlogo").style.display="none";
                                                        document.getElementById("smNameeditlogo").style.display="none";
                                                        document.getElementById("mNameeditlogo").style.display="none";
                                                        document.getElementById("text_smname").style.display = 'none';
                                                        document.getElementById("text_mname").style.display = 'none';
                                                       
                                                        
                                                        $.each(result, function(key, value) {
                                                           // console.log(result);
                                                        // $("#showmoduledropdown option").remove();
                                                        $('#showexamdropdown').html('<option value=" " disabled selected>--Select category--</option>');
                                                            $.each(result, function(key, value) {
                                                                
                                                                $('#showexamdropdown').append('<option value="'+value.pqmainId+'">' + value.pqmainName + '</option>');
                                                                
                                                            })
                                                               // showmoduleedit();
                                                            }
                                                           
                                                        )
                                                    }
                                                }
                                            })}
                                    </script>
                            <!---------------------------Module start---------------------------------->
                            <input type="text" style="width:450px" name="pqmId" id="pqmId" value="{{$item->pqmId}}" class="form-control" hidden><br>

                            <label for="mname" id="text_mname"><b style="color: black;">Exam Year :</b> </label><br>
                            <div class="flex-style">
                            <abbr style="text-decoration: none;" title="Change Module"><h1 class="fe fe-30 fe-edit" style="color: #007bff"   onclick="return showmoduleedit()" id="mNameeditlogo"></h1></abbr>
                            <input type="text"  name="mName" id="mName" class="form-control"  value="{{$item->pqmName}}" disabled>
                            </div>
                            




                            {{--DropDown for Module--}}
                            <div id="edit_div_modulename" style="display: none" >
                            <select name="showmoduledropdown" id="showmoduledropdown" value="{{$item->pqmId}}" onClick="return isUnitSelected();" onchange="return showsubmoduleedit()" class="form-control">
                                <option id="optionmoduledropdown"></option>
                            </select>
                            <span id="moduledrop-error" class="text-danger"></span>
                            </div> 
                                    

                                    <script>
                                    function showmoduleedit(){
                                        var result=[];
                                       // console.log(result);
                                        var examidfromdropdown = document.getElementById("showexamdropdown").value;
                                        var moduleidfrominput =document.getElementById("pqmainId").value;
                                       // console.log('mainId');
                                      // console.log('whats'); console.log(examidfromdropdown);

                                        if(examidfromdropdown==""){
                                            moduleid=moduleidfrominput;   //VALUE FROM INPUT MODULEID
                                            
                                        }else{
                                            moduleid=examidfromdropdown; //VALUE FROM DROPDOWN MODULEID
                                        }
                                       // console.log(moduleid);
                                        $.ajax({
                                            url: "{{url('/draftImagebasespCategoryshow')}}",
                                            type: "GET",
                                            data: {
                                                pqmainId: moduleid,
                                                _token: '{{csrf_token()}}'
                                            },
                                            success: function(result) {
                                             
                                                if (result) {
                                                   
                                                    document.getElementById("mName").style.display="none";
                                                    document.getElementById("mNameeditlogo").style.display="none";
                                                    document.getElementById("edit_div_modulename").style.display="block";
                                                    document.getElementById("text_mname").style.display = 'block';
                                                    document.getElementById("text_smname").style.display = 'block';
                                                   // document.getElementById("smNameeditlogo").style.display="none";
                                                   // document.getElementById("smName").style.display="none";
                                                   // document.getElementById("edit_div_submodulename").style.display="block";
                                                 
                                                    if(result.length>0){

                                                       // console.log(result);
                                                        // $("#showmoduledropdown option").remove();
                                                        $('#showmoduledropdown').html('<option value=" " disabled selected>--Select category--</option>');
                                                    $.each(result, function(key, value) {
                                                        
                                                        $('#showmoduledropdown').append('<option value="'+value.pqmId+'">' + value.pqmName + '</option>');
                                                        
                                                     })
                                                    // showsubmoduleedit();
                                                    
                                                   }else{
                                                    
                                                        document.getElementById("edit_div_modulename").style.display="none";
                                                        document.getElementById("edit_div_submodulename").style.display="none";
                                                        document.getElementById("addQuestion").style.display = 'none';
                                                        document.getElementById("text_smname").style.display = 'none';
                                                        document.getElementById("text_mname").style.display = 'none';
                                                        //alert("please insert submodule");
                                                        
                                                       

                                                            event.preventDefault(); // prevent the default link behavior

                                                        // Show the SweetAlert confirmation dialog
                                                                Swal.fire({
                                                                    title: 'No category found !',
                                                                    text: 'Please add a category to the corresponding exam',
                                                                    icon: 'warning',
                                                                 showCancelButton: true,
                                                                    confirmButtonText: 'Add Now',
                                                                    cancelButtonText: 'Cancel',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // If the user confirms the deletion, redirect to the delete URL
                                                                        window.location.href = "/category";
                                                                    }else{
                                                                        window.location.href = "/showapprovedsuperadminimagePqa";
                                                                    }
                                                                });

                                                        
                                                   }
                                            }
                                        }
                                    })}
                                </script>

                               




                                        <!---------------------------END EXAM TYPE----------------------------------->



                                    <input type="text" style="width:450px" name="pqsmId" id="pqsmId" value="{{$item->pqsmId}}" class="form-control" hidden><br>

                                    <label for="smname" id="text_smname"><b style="color: black;">Exam Name :</b> </label><br>
                                    <div class="flex-style">
                                    <abbr style="text-decoration: none;" title="Change Sub Module"><h1 class="fe fe-30 fe-edit" style="color: #007bff" onclick="return showsubmoduleedit();" id="smNameeditlogo"></h1></abbr>
                                    <input type="text"  name="smName" id="smName" class="form-control"  value="{{$item->pqsmName}}" disabled>
                                    </div>
                                    

                                   {{--DropDown for subModule--}}
                                   <div id="edit_div_submodulename" style="display: none" >
                                    <select name="showsubmoduledropdown" id="showsubmoduledropdown"  value="{{$item->pqsmId}}" onClick="return isUnitSelected();" onchange="return addQuestion()" class="form-control">
                                         <option id="optionsubmoduledropdown"></option>
                                    </select>
                                    <span id="submoduledrop-error" class="text-danger"></span>
                                </div> 

                                <script>
                                    function showsubmoduleedit(){
                                        var result=[];
                                        var moduleidfromdropdown = document.getElementById("showmoduledropdown").value;
                                        var moduleidfrominput =document.getElementById("pqmId").value;

                                        if(moduleidfromdropdown==""){
                                            moduleid=moduleidfrominput;   //VALUE FROM INPUT MODULEID
                                            
                                        }else{
                                            moduleid=moduleidfromdropdown; //VALUE FROM DROPDOWN MODULEID
                                        }
                                       // console.log(moduleid);
                                        $.ajax({
                                            url: "{{url('/draftImagebasespsubCategoryshow')}}",
                                            type: "GET",
                                            data: {
                                                pqmId: moduleid,
                                                _token: '{{csrf_token()}}'
                                            },
                                            success: function(result) {
                                             
                                                if (result) {
                                                   
                                                    document.getElementById("smName").style.display="none";
                                                    document.getElementById("smNameeditlogo").style.display="none";
                                                    document.getElementById("edit_div_submodulename").style.display="block";
                                                    //document.getElementById("text_smName").style.display="block";
                                                   
                                                 
                                                    if(result.length>0){
                                                        // $("#showsubmoduledropdown option").remove();
                                                        $('#showsubmoduledropdown').html('<option value=" " disabled selected>--Select sub category--</option>');
                                                    $.each(result, function(key, value) {
                                                        
                                                        $('#showsubmoduledropdown').append('<option value="'+value.pqsmId+'">' + value.pqsmName + '</option>');
                                                        
                                                     })
                                                   }else{
                                                        document.getElementById("edit_div_submodulename").style.display="none";
                                                        document.getElementById("addQuestion").style.display = 'none';
                                                        document.getElementById("text_smname").style.display = 'none';
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
                                                                        window.location.href = "/showapprovedsuperadminimagePqa";
                                                                    }
                                                                });

                                                        
                                                   }
                                            }
                                        }
                                    })}
                                </script>

                                    <br>
                      <!---------------------------------MODULE END------------------------------>              


                                    <!-- 


                                     -->

                                            <!-- <label for="module"><b style="color: black;">Choose Module</b></label>

                                        <select class="form-control" name="pqmodule" id="pqm_name" onChange="return myFunction()">
                                       
                                           
                                            <option value='{{$item->pqmName}}'></option>

                                                 <option value="{{$item->pqmId}}"  {{ $item->pqmId == session('mid') ? 'selected' : '' }}>{{$item->pqmName}}</option> -->

                                            <!-- @endforeach

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif -->

                                        <!-- </select><br>  -->



                                       

                                        
                                        {{--View question add form javascript--}}

                                        <script>
                                            function addQuestion() {
                                                 let smcode = document.getElementById("showsubmoduledropdown").value;                                               
                                                if(!smcode==""){
                                                    document.getElementById("addQuestion").style.display = 'block';
                                                }else{                                            
                                                    document.getElementById("addQuestion").style.display = 'none';
                                                }
                                            }
                                        </script>

                                </div>
                                        {{--Question add form--}}

                                        <div id="addQuestion" style="display: block">





                                            


                                                <input type="text" style="width:450px" name="ipqId" id="ipqId" value="{{$item->ipqId}}" class="form-control" hidden><br>
                                                
                                              

                   <p><label for="question"><b style="color: black;">Question :</b> </label></p>
                             <textarea name="questionIMAGE" id="questionIMAGE" placeholder="Enter question" >{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $item->question) !!}</textarea>
                             <span id="questionIMAGE-error" class="text-danger"></span>
                             @if ($errors->has('questionIMAGE'))
                             <span class="text-danger">{{ $errors->first('questionIMAGE') }}</span>
                             @endif <br><br>

                             <div class="col-12">

                    <p><label for="option1image"><b style="color: black;">Option 1 :</b> </label></p>
                            <div class="flex-style">
                                <input type="radio" id="option1image" name="answerImage" value="option1image" {{ ($item->ansA=="1")? "checked" : "" }} class="check-new">
                                <textarea name="option_1image" id="option_1image"  placeholder="Enter option 1" >{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $item->optionA) !!}</textarea>
                               
                                @if ($errors->has('option_1image'))
                                    <span class="text-danger">{{ $errors->first('option_1image') }}</span>
                                @endif
                            </div>
                            <span id="option_1image-error" class="text-danger"></span>  
                            
                            <br><br>
            


                    <p><label for="option2image"><b style="color: black;">Option 2 :</b> </label></p>
                            <div class="flex-style">
                                <input type="radio" id="option2image" name="answerImage" value="option2image" {{ ($item->ansB=="1")? "checked" : "" }} class="check-new">
                                <textarea name="option_2image" id="option_2image" placeholder="Enter option 2" >{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $item->optionB) !!}</textarea>
                                
                            
                                @if ($errors->has('option_2image'))
                                    <span class="text-danger">{{ $errors->first('option_2image') }}</span>
                                @endif
                            </div>
                            <span id="option_2image-error" class="text-danger"></span>

                            <br><br>


                    <p><label for="option3image"><b style="color: black;">Option 3 :</b> </label></p>
                            <div class="flex-style">
                                <input type="radio" id="option3image" name="answerImage" value="option3image" {{ ($item->ansC=="1")? "checked" : "" }} class="check-new">
                                <textarea name="option_3image" id="option_3image"  placeholder="Enter option 3" >{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $item->optionC) !!}</textarea>
                                
                                
                                @if ($errors->has('option_3image'))
                                    <span class="text-danger">{{ $errors->first('option_3image') }}</span>
                                @endif
                            </div>
                            <span id="option_3image-error" class="text-danger"></span>

                    <p><label for="option4image"><b style="color: black;">Option 4 :</b> </label></p>
                            <div class="flex-style">
                                <input type="radio" id="option4image" name="answerImage" value="option4image" {{ ($item->ansD=="1")? "checked" : "" }} class="check-new">
                                <textarea name="option_4image" id="option_4image"  placeholder="Enter option 4" >{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $item->optionD) !!}</textarea>
                                
                                
                                @if ($errors->has('option_4image'))
                                    <span class="text-danger">{{ $errors->first('option_4image') }}</span>
                                @endif
                            </div>
                            <span id="option_4image-error" class="text-danger"></span>

                             </div>



                             <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                             <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>
                             <script>
                                 // Array to store CKEditor instances
                                 var editors = [];
                             
                                 function validater() {
                                     var allContent = editors.map(editor => editor.getData().trim());
                                     var isEmpty = allContent.some(checkEmpty);
                             
                                   //  console.log('Content values:', allContent);
                             
                                     if (isEmpty) {
                                      //   console.log('At least one editor is empty');
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
                             
                                 // Initialize all CKEditors and store instances in the 'editors' array
                                 Promise.all([
                                     initializeCKEditor('#questionIMAGE'),
                                     initializeCKEditor('#option_1image'),
                                     initializeCKEditor('#option_2image'),
                                     initializeCKEditor('#option_3image'),
                                     initializeCKEditor('#option_4image')
                                 ]).then((instances) => {
                                     editors = instances;
                             
                                     // Attach an event listener to each CKEditor content change
                                     editors.forEach(editor => {
                                         editor.model.document.on('change:data', validater);
                                     });
                                 });
                             </script>




                                                   

                                                    </div>
                                                    <br>

                                                    <input type="submit" id="savebutton" value="UPDATE"   onClick="return isUnitSelected();
                                                                                                                      this.form.submit(); 
                                                                                                                      this.disabled=true; 
                                                                                                                      this.value='Sending…'; " class="btn mb-2 btn-primary" >







                                                









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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>





    {{--View Submoduld ajax--}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script type="text/javascript">

        function isUnitSelected() {

            const radios = document.querySelectorAll('input[name="answerImage"]');

            const selected = [...radios].some(radio => radio.checked);

            var moduledrop = document.getElementById('showmoduledropdown').value;
            var submoduledrop = document.getElementById('showsubmoduledropdown').value;
            var examdrop = document.getElementById('showexamdropdown').value;

            // console.log("moduledrop"); console.log(moduledrop);
            // console.log("submoduledrop");console.log(submoduledrop);
            // console.log("examdrop");console.log(examdrop);

            if (examdrop == null || examdrop === " "){
                document.getElementById("examdrop-error").innerHTML = "This field is required.";
                $("#savebutton").attr("disabled", true);
            } else {
               // console.log('exam else');
                document.getElementById("examdrop-error").innerHTML = "";
            }

            if (moduledrop == null || moduledrop === " "){
                document.getElementById("moduledrop-error").innerHTML = "This field is required.";
                $("#savebutton").attr("disabled", true);
            } else {
                //console.log('module else');
                document.getElementById("moduledrop-error").innerHTML = "";
            }

            if (submoduledrop == null || submoduledrop === " "){
                document.getElementById("submoduledrop-error").innerHTML = "This field is required.";
                $("#savebutton").attr("disabled", true);
            } else {
                //console.log('submodule else');
                document.getElementById("submoduledrop-error").innerHTML = "";
            }

           // Enable save button if both dropdowns have values
            if (moduledrop !== " " && submoduledrop !== " " && examdrop !== " ") {
                $("#savebutton").attr("disabled", false);
            }
            // if (submoduledrop !== "") {
            //     $("#savebutton").attr("disabled", false);
            // }
            // if (examdrop !== "") {
            //     $("#savebutton").attr("disabled", false);
            // }


            if (!selected) {

                event.preventDefault(); // prevent the default link behavior

// Show the SweetAlert confirmation dialog
                    Swal.fire({
                    // title: '',
                        text: 'Please choose one correct answer',
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



        }



    </script>

   <?php if(!empty(session('smid'))){
        $submoduleid=session('smid');
     }
     else{
        $submoduleid="";
     }?>

    <script>
        
        function myFunction() {

                
                var moduleid=document.getElementById('m_name').value;
               // var submid=null;
                var submid='<?php echo $submoduleid; ?>';
 
                 var sel = null;
            

                $.ajax({

                    url: "{{url('/subModuleCheck')}}",

                    type: "GET",

                    data: {

                        mid: moduleid,

                        _token: '{{csrf_token()}}'

                    },



                    //dataType: ' ',

 

                    success: function(result) {

                        if (result) {

                            document.getElementById("btn").style.display = 'block';



                            $('#smcode').html('<option value="">--Select Submodule--</option>');

                           
                            $.each(result, function(key, value) {

                                
                                (value.smId == submid) ? sel="selected" :  sel="null";




                                $('#smcode').append('<option value="'+value.smId+'" '+sel+' >' + value.smName +  '</option>');


                            });
                        }
                    }
                });
            };

    </script>



  

    {{--Javascript validation for form--}}
    <script>
        function quesVal(){
            var question = document.getElementById('question').value;

            if (question == null||question == ""){
                document.getElementById("question-error").innerHTML = "This field is required!";
                return false;
            } else {
                document.getElementById("question-error").innerHTML = "";
                return true;
            }
        }

        function op1Val(){
            var option1 = document.getElementById('option1').value;

            if (option1 == null||option1 == ""){
                document.getElementById("option1-error").innerHTML = "This field is required!!";
                return false;
            } else {
                document.getElementById("option1-error").innerHTML = "";
                return true;
            }
        }

        function op2Val(){
            let option2 = document.getElementById('option2').value;

            if (option2 == null||option2 == ""){
                document.getElementById("option2-error").innerHTML = "This field is required!";
                return false;
            } else {
                document.getElementById("option2-error").innerHTML = "";
                return true;
            }
        }

        function op3Val(){
            let option3 = document.getElementById('option3').value;

            if (option3 == null||option3 == ""){
                document.getElementById("option3-error").innerHTML = "This field is required!";
                return false;
            } else {
                document.getElementById("option3-error").innerHTML = "";
                return true;
            }
        }

        function op4Val(){
            let option4 = document.getElementById('option4').value;

            if (option4 == null||option4 == ""){
                document.getElementById("option4-error").innerHTML = "This field is required!";
                return false;
            } else {
                document.getElementById("option4-error").innerHTML = "";
                return true;
            }
        }

        function ansVal(){
            let radios = document.getElementByName('answer').value;

            if(radios == null || radios == ""){
                alert("Please select a currect answer!");
                return false;
            }
        }

    </script>

    {{--Script to disable save button until all fields have values--}}
    <script>
        function validate() {

            var valid = true;
            valid = checkEmpty($("#question")) && checkEmpty($("#option1")) && checkEmpty($("#option2")) && checkEmpty($("#option3")) && checkEmpty($("#option4"));

            $("#savebutton").attr("disabled",true);
            if(valid) {
                $("#savebutton").attr("disabled",false);
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
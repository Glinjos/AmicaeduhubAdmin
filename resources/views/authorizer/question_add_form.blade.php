@extends('authorizer.authorMaster')

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

                    <h2>Add Question & Answer</h2>

                    <form action="/questionauthormainSave" id="qform" method="post" onsubmit="return isUnitSelected()">

                        @csrf

                        <div class="card shadow mb-4">

                          <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-12">

                                        @if (session('success'))
                                            <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                        @endif
                                        @if (session('mid'))
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
                                       @endif
                                      
                                       
                                        @if (session('error'))
                                            <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                        @endif

                                        {{--DropDown for Module--}}

                                            <label for="module"><b style="color: black;">Module</b></label>

                                        <select class="form-control" name="module" id="m_name" onChange="return myFunction()">

                                            <option value=" " disabled selected>--Select Module--</option>

                                            @foreach($module_view as $item)

                                                <option value="{{$item->mId}}"  {{ $item->mId == session('mid') ? 'selected' : '' }}>{{$item->mName}}</option>

                                            @endforeach

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select><br>



                                       

                                        {{--DropDown for subModule--}}

                                        <div id="btn" style="display: none">

                                            <label for="submodule"><b style="color: black;">Sub module</b></label>

                                            <div class="form-group mb-3">

                                                <select id="smcode" class="form-control" name="smodule"  onchange="return addQuestion()">

                                                </select>

                                            </div>

                                        </div>



                                        {{--Question add form--}}

                                        <div id="addQuestion" style="display: none">





                                            









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



                                                    <p><label for="question"><b style="color: black;">Question :</b> </label></p>

                                                    <textarea id="question" name="question" rows="4" cols="50" style="flex-wrap: wrap;" class="form-control" placeholder="Enter question" onkeyup="return quesVal()" onblur="validate()"></textarea>
                                                    <span id="question-error" class="text-danger"></span>
                                                    @if ($errors->has('question'))
                                                        <span class="text-danger">{{ $errors->first('question') }}</span>
                                                    @endif <br><br>
                                                    <p><label for="question"><b style="color: black;">Question level :</b> </label></p>
                                                  <div>
                                                    <select class="form-control" name="question_level" id="question_level" >  
                                                        <option value="1" >Easy</option>
                                                        <option value="2" selected >Medium</option>
                                                        <option value="3" >High</option>
                                                    </select>
                                                    </div><br><br>



                                                    <div class="col-12">

                                                        <p><label for="option1"><b style="color: black;">Option 1 :</b> </label></p>
                                                        <div class="flex-style">
                                                            <input type="radio" id="option1" name="answer" value="option1" class="check-new">
                                                            <input type="text" name="option1" id="option1" class="form-control" placeholder="Enter option 1" onkeyup="return op1Val()" onblur="validate()">
                                                            <span id="option1-error" class="text-danger"></span>
                                                            @if ($errors->has('option1'))
                                                                <span class="text-danger">{{ $errors->first('option1') }}</span>
                                                            @endif
                                                        </div>
                                                        <br><br>

                                                        <p><label for="option2"><b style="color: black;">Option 2 :</b> </label></p>

                                                        <div class="flex-style">
                                                            <input type="radio" id="option2" name="answer" value="option2" class="check-new">
                                                            <input type="text" name="option2" id="option2" class="form-control" placeholder="Enter option 2" onkeyup="return op2Val()" onblur="validate()">
                                                            <span id="option2-error" class="text-danger"></span>
                                                            @if ($errors->has('option2'))
                                                                <span class="text-danger">{{ $errors->first('option2') }}</span>
                                                            @endif
                                                        </div>
                                                        <br><br>


                                                        <p><label for="option3"><b style="color: black;">Option 3 :</b> </label></p>

                                                        <div class="flex-style">
                                                            <input type="radio" id="option3" name="answer" value="option3" class="check-new">
                                                            <input type="text" name="option3" id="option3" class="form-control" placeholder="Enter option 3" onkeyup="return op3Val()" onblur="validate()">
                                                            <span id="option3-error" class="text-danger"></span>
                                                            @if ($errors->has('option3'))
                                                                <span class="text-danger">{{ $errors->first('option3') }}</span>
                                                            @endif
                                                        </div>
                                                        <br><br>

                                                        <p><label for="option4"><b style="color: black;">Option 4 :</b> </label></p>
                                                        <div class="flex-style">
                                                            <input type="radio" id="option4" name="answer" value="option4" class="check-new">
                                                            <input type="text" name="option4" id="option4" class="form-control" placeholder="Enter option 4" onkeyup="return op4Val()" onblur="validate()">
                                                            <span id="option4-error" class="text-danger"></span>
                                                            @if ($errors->has('option4'))
                                                                <span class="text-danger">{{ $errors->first('option4') }}</span>
                                                            @endif
                                                        </div>
                                                        <br><br>
                                                    </div>

                                                    <input type="submit" id="savebutton" value="Save" onClick="return isUnitSelected()" class="btn mb-2 btn-primary" disabled="disabled">


                                                    <script>
                                                        document.querySelector('#qform').addEventListener('submit', function() {
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







    {{--View Submoduld ajax--}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">

        function isUnitSelected() {
            // $(document).ready(function () {

                const radios = document.querySelectorAll('input[name="answer"]');

            const selected = [...radios].some(radio => radio.checked);

            if (!selected) {

                event.preventDefault(); // prevent the default link behavior

// Show the SweetAlert confirmation dialog
                    Swal.fire({
                    // title: 'Are you sure edit this submodule?',
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

            //     $("#savebutton").on("click", function() {
            //         $(this).attr("disabled", "disabled");
            //
            //         //this method contains your logic
            //         $(this).html("Saving...");
            //
            //         $("#qform").submit()
            //
            //
            //     });
            // });



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

                    url: "{{url('/subModuleauthorCheck')}}",

                    type: "GET",

                    data: {

                        mid: moduleid,

                        _token: '{{csrf_token()}}'

                    },



                    //dataType: ' ',

 

                    success: function(result) {

                        if (result) {
                            console.log(result.length);
                            if(result.length>0){

                            document.getElementById("btn").style.display = 'block';



                            $('#smcode').html('<option value="" disabled selected>--Select sub module--</option>');

                           
                            $.each(result, function(key, value) {

                                
                                (value.smId == submid) ? sel="selected" :  sel="null";




                                $('#smcode').append('<option value="'+value.smId+'" '+sel+' >' + value.smName +  '</option>');


                            });
                        }else{
                                 document.getElementById("btn").style.display="none";
                                document.getElementById("addQuestion").style.display = 'none';
                              // document.getElementById("text_smname").style.display = 'none';
                                                        //alert("please insert submodule");
                                                        
                                                       

                                  event.preventDefault(); // prevent the default link behavior

                                                        // Show the SweetAlert confirmation dialog
                                                                Swal.fire({
                                                                title: 'No submodule found !',
                                                                    text: 'Please add a submodule to the corresponding module',
                                                                    icon: 'warning',
                                                                 showCancelButton: true,
                                                                    confirmButtonText: 'Add Now',
                                                                    cancelButtonText: 'Cancel',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // If the user confirms the deletion, redirect to the delete URL
                                                                        window.location.href = "/toauthormainexmQA";
                                                                    }else{
                                                                        window.location.href = "/toauthormainexmQA";
                                                                    }
                                                                });

                                                        
                                                   }
                    }
                    }
                });
            };

    </script>



    {{--View question add form javascript--}}

    <script>

        function addQuestion() {



            let smcode = document.getElementById("smcode").value;
            

            if(!smcode==""){
                

                document.getElementById("addQuestion").style.display = 'block';

            }else{
               
                document.getElementById("addQuestion").style.display = 'none';

            }

        }



    </script>

    {{--Javascript validation for form--}}
    <script>
        function quesVal(){
            var question = document.getElementById('question').value;

            if (question == null||question == ""){
                document.getElementById("question-error").innerHTML = "This field is required.";
                return false;
            } else {
                document.getElementById("question-error").innerHTML = "";
                return true;
            }
        }

        function op1Val(){
            var option1 = document.getElementById('option1').value;

            if (option1 == null||option1 == ""){
                document.getElementById("option1-error").innerHTML = "This field is required.";
                return false;
            } else {
                document.getElementById("option1-error").innerHTML = "";
                return true;
            }
        }

        function op2Val(){
            let option2 = document.getElementById('option2').value;

            if (option2 == null||option2 == ""){
                document.getElementById("option2-error").innerHTML = "This field is required.";
                return false;
            } else {
                document.getElementById("option2-error").innerHTML = "";
                return true;
            }
        }

        function op3Val(){
            let option3 = document.getElementById('option3').value;

            if (option3 == null||option3 == ""){
                document.getElementById("option3-error").innerHTML = "This field is required.";
                return false;
            } else {
                document.getElementById("option3-error").innerHTML = "";
                return true;
            }
        }

        function op4Val(){
            let option4 = document.getElementById('option4').value;

            if (option4 == null||option4 == ""){
                document.getElementById("option4-error").innerHTML = "This field is required.";
                return false;
            } else {
                document.getElementById("option4-error").innerHTML = "";
                return true;
            }
        }

        function ansVal(){
            let radios = document.getElementByName('answer').value;

            if(radios == null || radios == ""){
                alert("Must check some option!");
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
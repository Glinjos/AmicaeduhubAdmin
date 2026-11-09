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

                    <h2>Search Submodule Wise Question & Answer</h2>

                    <form action="/getdraftapprovingmainexam" id="qform" method="get" onclick="return Validation();">

                        @csrf

                        <div class="card shadow mb-4">



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

                                        <select class="form-control" name="module" id="m_name" onChange="myFunction();Validation();">

                                            <option value=" " disabled selected>--Select Module--</option>

                                            @foreach($module_view as $item)

                                                <option value="{{$item->mId}}"  {{ $item->mId == session('mid') ? 'selected' : '' }}>{{$item->mName}}</option>

                                            @endforeach

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select>
                                        <span id="modulewise-error" class="text-danger"></span>
                                        <br>



                                       

                                        {{--DropDown for subModule--}}

                                        <div id="btn" style="display: none">

                                            <label for="submodule"><b style="color: black;">Sub module</b></label>

                                            <div class="form-group mb-3">

                                                <select id="smcode" class="form-control" name="smodule"  onchange="viewsmQuestion();Validation();">

                                                </select>

                                            </div>
                                        <span id="submodulewise-error" class="text-danger"></span>
                                        </div>

                                        <div id="searchbuttonid" style="display: none"> {{-- search div --}}
                                            <div class="col-md-4">
                                                <label class="h6 large d-block text-uppercase"></label>
                                                   
                                                    <span class=" text-hide">!</span>
                                                    <div class="input-group">
                                                       <a href="/getdraftapprovingmainexam"> <button  name="" id="search" class="form-control btn btn-primary" style="width: 100px;" onsubmit="return Validation();" disabled>search</button><a>
                                                    </div>
                                                
                                            </div>
                            
    
                                    </div>{{-- search div end --}}

                                    <script>
                                        function viewsmQuestion()
                                        {
                                           // alert("hai"); 
                                            var result = [];
                                            var submoduleidfrominput = document.getElementById("smcode").value;
                                             
                                            if(!submoduleidfrominput=="")
                                            {
                                                  document.getElementById('searchbuttonid').style.display="block";
                                                 // alert(submoduleidfrominput);
                                            }
                                        }
                                        </script>

                                    </div> <!-- /.col -->

                                    <script>
                                        function Validation() {
                                          var submoduleidfromdrop = document.getElementById("smcode").value.trim();
                                          console.log(submoduleidfromdrop);                                         
                                          var moduleidfromdrop = document.getElementById('m_name').value.trim();
                                          console.log(moduleidfromdrop); 
                                          
                                          if (moduleidfromdrop === "") {
                                           // alert(moduleidfromdrop);
                                            document.getElementById("modulewise-error").innerHTML = "This field is required.";
                                            document.getElementById("search").disabled = true; // Disable the button
                                            return false;
                                          } else {
                                            document.getElementById("modulewise-error").innerHTML = "";
                                            document.getElementById("search").disabled = false;
                                          }
                                        
                                          if (submoduleidfromdrop === "") {
                                            //alert(submoduleidfromdrop);
                                            document.getElementById("submodulewise-error").innerHTML = "This field is required.";
                                            document.getElementById("search").disabled = true; // Disable the button
                                            return false;
                                          } else {
                                            document.getElementById("submodulewise-error").innerHTML = "";
                                            document.getElementById("search").disabled = false;
                                          }
                                        }
                                        </script>
                                        

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

                    url: "{{url('/subModulewiseauthorchekauthorCheck')}}",

                    type: "GET",

                    data: {

                        mid: moduleid,

                        _token: '{{csrf_token()}}'

                    },



                    //dataType: ' ',

 

                    success: function(result) {

                        if (result) {
                           // console.log(result.length);
                            if(result.length>0){

                            document.getElementById("btn").style.display = 'block';



                            $('#smcode').html('<option value="" disabled selected>--Select sub module--</option>');

                           
                            $.each(result, function(key, value) {

                                
                                (value.smId == submid) ? sel="selected" :  sel="null";

                                $('#smcode').append('<option value="'+value.smId+'" '+sel+' >' + value.smName +  '</option>');


                            });
                            
                            
                            viewsmQuestion();
                            
                            
                        }else{
                                 document.getElementById("btn").style.display="none";
                                document.getElementById("searchbuttonid").style.display = 'none';
                             
                                                      //  alert("please insert submodule");
                                                        
                                                       

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
                                                                        window.location.href = "/submodulewisemainexm";
                                                                    }else{
                                                                        window.location.href = "/submodulewisemainexm";
                                                                    }
                                                                });

                                                        
                                                   }
                    }
                    }
                });
            };

    </script>





@endsection
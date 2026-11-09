@extends('admin/adminMaster')

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

                    <h2>Search Video Exam Question & Answer</h2>

                    <form action="/searchfilterdquestvideoclass" id="pqform" method="get" onsubmit="return Validation()">

                        @csrf

                        <div class="card shadow mb-4">

                           <!-- Output the session ID in a Blade view using the Session facade -->                 
                        
                          

                            
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-12">

                                        @if (session('success'))
                                            <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                        @endif
                                        
                                        @if (session('vcmid'))
                                       
                                        <script>
                                                window.onload = function  () {
                                                   
                                                     myExamFunction();
                                                     myFunction();
                                                     document.getElementById("searchbuttonid").style.display = 'block';
                                                    // viewsearchbtn();
                                                    // Validation();
                                                 
                                                };
                                            </script> 
                                       @endif

                                       

                                       @if (!session('vcmid')) 
                                       <script>
                                        window.onload = function() {
                                          
                                          
                                            var examid=document.getElementById('subject').value;
                                          
                                            if (examid === " ") {
                                             
                                              // alert('failed');
                                            }
                                            else{
                                              
                                                myExamFunction();
                                            }
                                        };
                                    
                                    </script>
                                    @endif
                                       
                                       
                                      
                                        @if (session('error'))
                                            <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                        @endif

                                        <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
<!------------------------------------------------------------------------------------------------------------------------------------------>
                                        <label for="subject"><b style="color: black">Exam Subject</b></label>

                                            <select class="form-control" name="subject" id="subject" onchange="myExamFunction();subjectValidation();">

                                            <option value=" " disabled selected>--Select subject--</option>

                                            @foreach($categoryView as $item)
                                                <option value="{{$item->vcmId}}"  {{ $item->vcmId == session('vcmid') ? 'selected' : '' }} >{{$item->vcmName}}</option>
                                            @endforeach

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select>
                                        <span id="subject-error" class="text-danger"></span>
                                        <br>
                                       

<!------------------------------------------------------------------------------------------------------------------------------------------------------>
                                       <div id="category" style="display: none">  
                                           <label for="chapter"><b style="color: black">Exam Chapter</b></label>

                                            <select class="form-control" name="chapter" id="c_name" onchange="myFunction();chapterValidation();">

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select>
                                        <span id="c_name-error" class="text-danger"></span>
                                        <br>

                                    </div>



                                        {{--DropDown for subModule--}}

                                        <div id="btn" style="display: none">

                                            <label for="submodule"><b style="color: black;" >Exam video</b></label>

                                            <div class="form-group mb-3">

                                                <select id="smcode" class="form-control" name="video"  onchange="addQuestion();videoValidation();">

                                                </select>
                                                <span id="smcode-error" class="text-danger"></span>
                                            </div>

                                        </div>


                                        <div id="searchbuttonid" style="display: none"> {{-- search div --}}
                                            <div class="col-md-4">
                                                <label class="h6 large d-block text-uppercase"></label>
                                                   
                                                    <span class=" text-hide">!</span>
                                                    <div class="input-group">
                                                       <a href="/searchfilterdquestvideoclass"> <button  name="" id="search" class="form-control btn btn-primary" style="width: 100px;" onsubmit="return Validation();" >search</button><a>
                                                    </div>
                                                
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

    <script>
         function subjectValidation() {

                var subjectdrop = document.getElementById("subject").value;
               


                if (subjectdrop === "") {
                // alert(moduleidfromdrop);
                document.getElementById("subject-error").innerHTML = "This field is required.";
                //document.getElementById("search").disabled = true; // Disable the button
                return false;
                } else {
                document.getElementById("subject-error").innerHTML = "";
               // document.getElementById("search").disabled = false;
               chapterValidation();
                }
            }
            function chapterValidation() {

                var chapterdrop = document.getElementById("c_name").value;                      
               

                if (chapterdrop === "") {
               // alert(chapterdrop +  'this from chapter validation');
                document.getElementById("c_name-error").innerHTML = "This field is required.";
               // document.getElementById("search").disabled = true; // Disable the button
                return false;
                } else {
                document.getElementById("c_name-error").innerHTML = "";
                videoValidation();
                }
            }

            function videoValidation() {

                var videodrop = document.getElementById('smcode').value;

                if (videodrop === "") {
                //alert(submoduleidfromdrop);
                document.getElementById("smcode-error").innerHTML = "This field is required.";
               // document.getElementById("search").disabled = true; // Disable the button
                return false;
                } else {
                document.getElementById("smcode-error").innerHTML = "";
               // document.getElementById("search").disabled = false;
                //Validation();
                }
             }
        </script>
    <script>
        function Validation() {

          var subjectdrop = document.getElementById("subject").value;
          var chapterdrop = document.getElementById("c_name").value;                      
          var videodrop = document.getElementById('smcode').value;
         
          
          if (subjectdrop === "") {
           // alert(moduleidfromdrop);
            document.getElementById("subject-error").innerHTML = "This field is required.";
            //document.getElementById("search").disabled = true; // Disable the button
             return false;
          }
        
          else if (chapterdrop === " ") {
           // alert(chapterdrop + 'this from main validation');
            document.getElementById("c_name-error").innerHTML = "This field is required.";
           // document.getElementById("search").disabled = true; // Disable the button
            return false;
          }
          else if (videodrop === "") {
           // alert(submoduleidfromdrop);
            document.getElementById("smcode-error").innerHTML = "This field is required.";
           // document.getElementById("search").disabled = true; // Disable the button
            return false;
          } else {
            document.getElementById("subject-error").innerHTML = "";
            document.getElementById("c_name-error").innerHTML = "";
            document.getElementById("smcode-error").innerHTML = "";
           // document.getElementById("search").disabled = false;
           return true;
          }
        }
        </script>




    <?php if(!empty(session('vcChapterId'))){
        $moduleid=session('vcChapterId');
       
     }
     else{
        $moduleid="";
     }?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <script>
        function myExamFunction(){
            // alert("dfdbfjd");
                  var examid=document.getElementById('subject').value;
                  // alert(examid);
                    // var submid=null;
                    var mid='<?php echo $moduleid; ?>';
                   // alert(mid);
                   

                 var sel = null;


       $.ajax({

       url: "{{url('/vcChapterCheck')}}",

       type: "GET",

       data: {

        vcmid: examid,

           _token: '{{csrf_token()}}'

       },

       success: function(result) {

           if (result) {
              
               if(result.length>0){
                //console.log(result)
                document.getElementById("category").style.display = 'block';

                           $('#c_name').html('<option value=" " disabled selected>--Select chapter--</option>');

                           $.each(result, function(key, value) {

                               (value.vcChapterId == mid) ? sel="selected" :  sel="null";

                               $('#c_name').append('<option value="'+value.vcChapterId+'"  '+sel+' >' + value.vcChapterName + '</option>');

                           });
                        }else{

                        document.getElementById("category").style.display="none";
                       
                        event.preventDefault(); // prevent the default link behavior

                    // Show the SweetAlert confirmation dialog
                        Swal.fire({
                            title: 'No chapter found !',
                            text: 'Please add a chapter to the corresponding subject',
                            icon: 'warning',
                         showCancelButton: true,
                            confirmButtonText: 'Add Now',
                            cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // If the user confirms the deletion, redirect to the delete URL
                                window.location.href = "/vcchapterform";
                            }else{
                                window.location.href = "";
                            }
                        });

                  }
    }}})}
</script>






    {{--View Submoduld ajax--}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    

<?php if(!empty(session('vcVDId'))){
     $submoduleid=session('vcVDId');
    
  }
  else{
     $submoduleid="";
  }?>

 <script>
     
     function myFunction() {

           
             var categoryid=document.getElementById('c_name').value;
             var submid='<?php echo $submoduleid; ?>';
             var mid='<?php echo $moduleid; ?>';

             if(!categoryid)
             {
               categoryid = mid;
             }
           

              var sel = null;

      
                $.ajax({

                    url: "{{url('/videomoreCheck')}}",

                    type: "GET",

                    data: {

                        vcChapterId: categoryid,

                        _token: '{{csrf_token()}}'

                    },

                    success: function(result) {

                        if (result) {
                           // console.log(result);
                           
                            if(result.length>0){
                                        document.getElementById("btn").style.display = 'block';



                                        $('#smcode').html('<option value="" disabled selected>--Select video--</option>');

                                        $.each(result, function(key, value) {

                                            (value.vcVDId == submid) ? sel="selected" :  sel="null";

                                            $('#smcode').append('<option value="'+value.vcVDId+'"  '+sel+' >' + value.videoHeading + '</option>');

                                        });
                                    }else{

                                        document.getElementById("btn").style.display="none";
                                        document.getElementById("searchbuttonid").style.display = 'none';
                                        

                                  event.preventDefault(); // prevent the default link behavior

                                                        // Show the SweetAlert confirmation dialog
                                                                Swal.fire({
                                                                    title: 'No video found !',
                                                                    text: 'Please add a video to the corresponding chapter',
                                                                    icon: 'warning',
                                                                 showCancelButton: true,
                                                                    confirmButtonText: 'Add Now',
                                                                    cancelButtonText: 'Cancel',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // If the user confirms the deletion, redirect to the delete URL
                                                                        window.location.href = "/addvideos";
                                                                    }else{
                                                                        window.location.href = "";
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

                document.getElementById("searchbuttonid").style.display = 'block';

            }else{

                document.getElementById("searchbuttonid").style.display = 'none';

            }

        }



    </script>

    

@endsection
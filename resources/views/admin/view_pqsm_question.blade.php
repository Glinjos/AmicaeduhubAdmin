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
                    
                    <h2>Search Previous Question & Answer Exam Name Wise</h2>
                        
                        <th>
                           <h4 align="right">
                               <input type="button" onclick="window.location.href='/toPQA'" class="btn btn-primary btn-sm" style="background-color: rgb(153, 11, 6);" value="Add PQA">&nbsp;
                               <input type="button" onclick="window.location.href='/showPQA'" class="btn btn-primary btn-sm" style="background-color: rgb(6, 143, 153);" value="Show PQA">&nbsp;
                               <input type="button" onclick="window.location.href='/draftfilterqapqsadmin'" class="btn btn-primary btn-sm" style="background-color: rgb(6, 143, 153);" value="Filter draftPQA">&nbsp;
                              
                           </h4>
                         </th>
                         <style>
                           .btn.btn-primary.btn-sm {
                             width: 100px;
                             height: 25px;
                           }
                         </style>
                    
                    
                    
                    

                    <form action="/subcategorypqshowadmin" id="pqform" method="get" onclick="return Validation();">

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
                                                     viewsmQuestion();
                                                     document.getElementById('searchbuttonid').style.display="block";
                                                    // Validation();
                                                };
                                            </script> 
                                       @endif
                                       
                                       @if (!session('pqmid')) 
                                       <script>
                                        window.onload = function() {
                                          
                                            var examTypeSelect = document.getElementById('examtype');
                                            //  alert(examTypeSelect);
                                           
                                            if (examTypeSelect.value === " ") {
                                               //alert('nah');
                                               // myExamFunction();
                                               
                                            }
                                            else{
                                               // alert('btc');
                                                myExamFunction();
                                            }
                                        };
                                    
                                    </script>
                                    @endif
                                    
                                    
                                    
                                 
                                   
                                   


                                       
                                       
                                      
                                        @if (session('error'))
                                            <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                        @endif
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
                                        <span id="examtype-error" class="text-danger"></span>

<!------------------------------------------------------------------------------------------------------------------------------------------------------>
                                       <div id="category" style="display: none">  
                                           <label for="module"><b style="color: black">Exam Year</b></label>

                                            <select class="form-control" name="module" id="c_name" onChange="return myFunction();">

                                            {{-- <option value=" " disabled selected>--Select category--</option> --}}

                                            {{-- @foreach($categoryView as $item)
                                                <option value="{{$item->pqmId}}"  {{ $item->pqmId == session('pqmId') ? 'selected' : '' }} >{{$item->pqmName}}</option>
                                            @endforeach --}}

                                            @if (session('error'))
                                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                            @endif

                                        </select><br>
                                        <span id="examyear-error" class="text-danger"></span>
                                    </div>



                                        {{--DropDown for subModule--}}

                                        <div id="btn" style="display: none">

                                            <label for="submodule"><b style="color: black;" >Exam Name</b></label>

                                            <div class="form-group mb-3">

                                                <select id="smcode" class="form-control" value="{{$item->pqsmId}}" name="smodule"  onchange="return viewsmQuestion()">

                                                </select>

                                            </div>
                                            <span id="examname-error" class="text-danger"></span>
                                        </div>


                                    <div id="searchbuttonid" style="display: none"> {{-- search div --}}
                                        <div class="col-md-4">
                                            <label class="h6 large d-block text-uppercase"></label>
                                               
                                                <span class=" text-hide">!</span>
                                                <div class="input-group">
                                                   <a href="/authorsubcategorypq"> <button  name="" id="search" class="form-control btn btn-primary" style="width: 100px;" onclick="return Validation();" disabled>search</button><a>
                                                </div>
                                            
                                        </div>
                        

                                </div>{{-- search div end --}}
                                


                                        <script>
                                            function viewsmQuestion()
                                            {
                                               // alert("hai"); 
                                                var result = [];
                                                var moduleidfrominput = document.getElementById("smcode").value;
                                               // alert(moduleidfrominput); 
                                                if(!moduleidfrominput=="")
                                                {
                                                      document.getElementById('searchbuttonid').style.display="block";
                                                }
                                            }
                                            </script>

                                        {{--Question add form--}}

                                        <script>
                                            function Validation()
                                            {
                                                var moduleidfrominput = document.getElementById("smcode").value;
                                                var examid=document.getElementById('examtype').value;
                                                var categoryid=document.getElementById('c_name').value;

                                                // sessionStorage.setItem('examtype', examid);
                                                // sessionStorage.setItem('smcode', moduleidfrominput);
                                                // sessionStorage.setItem('smcode', categoryid);
                                              //  sessionStorage.setItem('selectedDropdown2', dropdown2Value);
                                               // alert(moduleidfrominput);
                                               if(moduleidfrominput==" ")
                                               {
                                               // alert(moduleidfrominput);
                                                document.getElementById("examname-error").innerHTML = "This field is required.";
                                                document.getElementById("search").disabled = true; // Disable the button
                                                return false;
                                               }
                                               else {
                                                    document.getElementById("examname-error").innerHTML = "";
                                                    document.getElementById("search").disabled = false;
                                                    }

                                            if(categoryid==" ")
                                               {
                                               // alert(moduleidfrominput);
                                                document.getElementById("examyear-error").innerHTML = "This field is required.";
                                                document.getElementById("search").disabled = true; // Disable the button
                                                return false;
                                               }
                                               else {
                                                    document.getElementById("examyear-error").innerHTML = "";
                                                    document.getElementById("search").disabled = false;
                                                    }  
                                                    
                                             if(examid==" ")
                                               {
                                               // alert(moduleidfrominput);
                                                document.getElementById("examtype-error").innerHTML = "This field is required.";
                                                document.getElementById("search").disabled = true; // Disable the button
                                                return false;
                                               }
                                               else {
                                                    document.getElementById("examtype-error").innerHTML = "";
                                                    document.getElementById("search").disabled = false;
                                                    }  


                                                    
                                            }

                                           

                                            </script>

            <div id="addQuestion" style="display: none">


               
                                               

                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                               

        </div>
    </div>
</div>



{{--Show question modal--}}









                          </div>

                                                    {{-- <input type="submit" id="savebutton"onClick="return isUnitSelected();this.form.submit(); this.disabled=true; this.value='Sending…'; " value="Save" class="btn mb-2 btn-primary" disabled="disabled">



                                                    <script>
                                                        document.querySelector('#pqform').addEventListener('submit', function() {
                                                            document.querySelector('#savebutton').setAttribute('disabled', 'disabled');
                                                        });
                                                    </script> --}}







                                                









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
                 //  alert(examid);
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
               // console.log(result)
                document.getElementById("category").style.display = 'block';

                           $('#c_name').html('<option value=" " disabled selected>--Select exam year--</option>');

                           $.each(result, function(key, value) {

                               (value.pqmId == mid) ? sel="selected" :  sel="null";

                               $('#c_name').append('<option value="'+value.pqmId+'"  '+sel+' >' + value.pqmName + '</option>');

                           });
                        }else{

                        document.getElementById("category").style.display="none";
                        document.getElementById("addQuestion").style.display = 'none';
                        
                       
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
                                window.location.href = "/showpqfilter";
                            }else{
                                window.location.href = "/showpqfilter";
                            }
                        });

                  }
    }}})}
</script>




    {{--View Submoduld ajax--}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   

<?php if(!empty(session('pqsmid'))){
     $submoduleid=session('pqsmid');
    
  }
  else{
     $submoduleid="";
  }?>

 <script>
     
     function myFunction() {

             //console.log('myFunction() called');
             var categoryid=document.getElementById('c_name').value;
             var submid='<?php echo $submoduleid; ?>';
             var mid='<?php echo $moduleid; ?>';

             if(!categoryid)
             {
               categoryid = mid;
             }
           

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
                            //console.log(result);
                           
                            if(result.length>0){
                                        document.getElementById("btn").style.display = 'block';



                                        $('#smcode').html('<option value=" " disabled selected>--Select exam name--</option>');

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
                                                                        window.location.href = "/showpqfilter";
                                                                    }
                                                                });

                                    }
                            }
                    }
                });
            };
        

    </script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

         
































          
                    
                
                    
                   


 



<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">     
            

             
    <!-- TO SHOw LAODER -->
    
    <!-- FORM FOR MODEL TO SHOW VALUES -->

 

    {{--Script to disable save button until all fields have values--}}
   

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


@endsection
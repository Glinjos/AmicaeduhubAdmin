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

                    <h2>Details of Top Performers</h2>

                    {{-- <form  id="pqform" method="get" onsubmit="return Validation();">

                        @csrf --}}

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

                                            <select class="form-control" name="examtype" id="examtype" onchange="return myExamFunction();">

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

                                            <select class="form-control" name="module" id="c_name" onchange="return myFunction();">

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

                                                <select id="smcode" class="form-control" value="{{$item->pqsmId}}" name="smodule"  onchange="return Validation();">

                                                </select>

                                            </div>
                                            <span id="examname-error" class="text-danger"></span>
                                        </div>

        <!--------------------------------------------------------------------------------------------->  
         <!--------------------------------------------------------------------------------------------->
          <!--------------------------------------------------------------------------------------------->                              


        <script>
          function Validation()
           {
                // alert('gao');   
             var moduleidfrominput = document.getElementById("smcode").value;
            // alert(moduleidfrominput);
             var examid=document.getElementById('examtype').value;
             var categoryid=document.getElementById('c_name').value;


                if(moduleidfrominput=="")
                {
                 document.getElementById("examname-error").innerHTML = "This field is required.";
                 document.getElementById('table-open').style.display = 'none';
                 return false;
                }
                else {
                     document.getElementById("examname-error").innerHTML = "";
                   
                     }

                if(categoryid==" ")
                {
                // alert(moduleidfrominput);
                 document.getElementById("examyear-error").innerHTML = "This field is required.";
                
                 return false;
                }
                else {
                     document.getElementById("examyear-error").innerHTML = "";
                  
                     }  

                if(examid==" ")
                {
                // alert(moduleidfrominput);
                 document.getElementById("examtype-error").innerHTML = "This field is required.";
              
                 return false;
                }
                else {
                     document.getElementById("examtype-error").innerHTML = "";
                  
                     }  

               // ajax working here--lets see
                 
               $.ajax({
                    url: "{{ url('/report_of_topstudents') }}",
                    type: "POST",
                    data: {
                        exam_type: examid,
                        exam_year: categoryid,
                        exam_name: moduleidfrominput,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (result) {
                        var table = $('#dataTable-1 tbody');
                        table.empty();

                        if (result && result.length > 0) {
                            //console.log(result);

                            result.forEach(function (item, index) {
                                table.append(
                                    `<tr>
                                        <td style="color: black; text-align: center;">${index + 1}</td>
                                        <td style="color: black;">${item.name}</td>
                                        <td style="color: black; text-align: center;">${item.dateAndTime}</td>
                                        <td style="color: black; text-align: center;">${item.totalQuestions}</td>
                                        <td style="color: black; text-align: center;">${item.QuestionsAttended}</td>
                                        <td style="color: black; text-align: center;">${item.rightAns}</td>
                                        <td style="color: black; text-align: center;">${item.wrongAns}</td>
                                        <td style="color: black; text-align: center;">${item.score}</td>
                                        <td style="color: black; text-align: center;">${Number(item.percentage).toFixed(2)}</td>
                                    </tr>`
                                );
                            });

                            $('#table-open').show();

                        } else {
                           // console.log("No data found");
                            table.append(
                                `<tr>
                                    <td style="color: black; text-align: left;" colspan="9">No data found</td>
                                </tr>`
                            );

                            // Show the table after populating data
                            $('#table-open').show();
                        }
                    },
                    error: function (xhr, status, error) {
                       // console.log("Error:", error);
                    }
                });


            }


                                                    
                                           
        </script>

{{-- the  table start  here --}}
<div id="table-open" style="display: none">
    <!--<div class="container-fluid">-->
    <!--    <div class="row justify-content-center">-->
    <!--        <div class="col-12">-->
    <!--            <div class="row my-4">-->
    <!--                <div class="col-md-12">-->
    <!--                    <div class="card shadow">-->
    <!--                        <div class="card-body">-->
    
                   <br><br>
                                <table class="datatables" width="100%" border="1px" style="background-color: white" id="dataTable-1">
                                    <thead>
                                        <tr style="background-color: rgb(122, 98, 179);">
                                            <th style="color: white; text-align: center;" colspan="9">
                                                <b>Details of Previous Exam Top Performers with Scores Above 75%</b>
                                            </th>
                                        </tr>
                                        <tr style="background-color: lightgray;">
                                            <th style="color: black; text-align: center;" colspan="1"><b>SL NO</b></th>
                                            <th style="color: black;" colspan="1"><b>Name</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>DateAndTime</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>TotalQuestion</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>AttendQuestion</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>RightAnswer</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>WrongAnswer</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>Score</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>Percentage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
</div>
{{-- the  table end  here --}}








                                        </div>
                                    </div> <!-- /.col -->
                                </div>
                            </div>
                        </div>
                    {{-- </form> --}}
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

                                    document.getElementById('table-open').style.display = 'none';


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
                                            window.location.href = "/showtopperformes";
                                        }else{
                                            window.location.href = "/showtopperformes";
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
                                                document.getElementById("table-open").style.display = 'none';
                                            }else{

                                                document.getElementById("btn").style.display="none";
                                                document.getElementById("addQuestion").style.display = 'none';
                                                // document.getElementById("table-open").style.display = 'none';
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
                                                                                window.location.href = "/showtopperformes";
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

{{-- <script>
    $('#dataTable-1').DataTable(

        {
            autoWidth: true,
            "lengthMenu": [
                [16, 32, 64, -1],
                [16, 32, 64, "All"]
            ]
        });
</script> --}}


@endsection
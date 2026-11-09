@extends('admin.adminMaster')


@section('adminpanel')


    <div class="wrapper">
        <main role="main" class="main-content">
            <!-- table -->
            @if (session('success'))
                <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
            @endif
            @if (session('error'))
                <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
            @endif

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="mb-2 page-title">View Users Questions Answers</h2>

                        {{-- <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}"> --}}

                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <table class="table datatables" id="dataTable-1" >
                                            <thead>
                                            <tr style="background-color: lightgray;">
                                                <th style="color: black;"><b>Sl No</b></th>
                                                {{-- <th style="color: black;"><b>Chat Type</b></th> --}}
                                                {{-- <th style="color: black;"><b>User Name</b></th> --}}
                                                <th style="color: black;"><b>Module Name</b></th>
                                                <th style="color: black;"><b>Questions</b></th>
                                                <th style="color: black;"><b>Chat Date and Time</b></th>
                                                <th style="color: black;"><b>Answerd At</b></th>
                                                <th style="color: black;"><b></b></th>
                                                {{-- <th style="color: black;"><b>ACTIONS</b></th> --}}

                                            </tr>
                                            </thead>
                                            <tbody>


                                           

                                            <!--LOADER END HERE AFTER LOADING DATA -->



                                            @if(isset($users_all_questions))

                                                @php $i=1; @endphp

                                                @foreach ($users_all_questions as $item)

                                                    <tr  style=color:black;">
                                                        <td width="65"><b>{{$i++}}</b></td>

                                                        {{-- <td width="90">{{$item->typeName}}</td>
                                                        <td width="90">{{$item->name}}</td> --}}
                                                        <td width="90">{{$item->mName}}</td>
                                                        {{-- <td width="150"><span id="qu{{$i}}" style="word-wrap: break-word;">{{ $item->question}}</span></td> --}}
                                                       
                                                 
                                                        
                                                        <td width="300">
                                                            <span  id="que{{$i}}" style="word-wrap: break-word;" onmouseover="return showanswer(<?php echo $item->chatQuestionAnsId; ?>)"
                                                                   onmouseout="return hideanswer(<?php echo $item->chatQuestionAnsId; ?>)">{{$item->question}}</span>
                                                            <p name="answerover" id="answeronmousehover{{$item->chatQuestionAnsId}}" style="width:400px;word-wrap: break-word; display: none;color:green;font-weight: bold;" >"answer is" </p>
                                                        </td>

                                                        <td width="100">{{$item->chatDateTime}}</td>
                                                        <td width="100">{{$item->updated_at}}</td>

                                                        <td width="10">
                                                            <abbr style="text-decoration: none;" title="ViewMore"><span onclick="return  showq(<?php echo $item->chatQuestionAnsId;?>)" style="color: green;" class="fe fe-24 fe-more-horizontal" ></span></abbr>
                                                        </td>
                                                        {{-- <td width="10">
                                                          @if($item->Answer=="")   --}}
                                                          {{-- <label class="h6 large d-block text-uppercase"></label>     
                                                          <span class=" text-hide">!</span>       
                                                          <button  name="" id="addanswerbutton" class="form-control btn btn-primary" style="width: 90px;" onclick="return addAnswer();" >Add Ans</button> --}}
                                                          {{-- <abbr style="text-decoration: none;" title="Add Answer">
                                                            <span onclick="return addAnswer();" style="font-size:26px;color: green;" class="material-icons control_point another_class">queue</span>
                                                          </abbr>
                                                          @else --}}
                                                          {{-- <label class="h6 large d-block text-uppercase"></label>     
                                                          <span class=" text-hide">!</span>        --}}
                                                          {{-- <button  name="" id="editanswerbutton" class="form-control btn btn-primary" style="width: 90px;background-color:red;" onclick="return editAnswer();" >Edit Ans</button> --}}
                                                          {{-- <abbr style="text-decoration: none;" title="Edit Answer">
                                                            <span onclick="return editAnswer();" style="font-size:26px;color: red;" class="fa fa-edit"></span>
                                                          </abbr>
                                                          
                                                          
                                                          @endif

                                                        </td>  --}}
                                                        


                                                    </tr>




                                                
                                               

                                                {{-- <script>
                                                    function addAnswer()
                                                    {
                                                        document.getElementById('addanswerform').style.display="block";
                                                    }
                                                </script>

                                                <script>
                                                    function editAnswer()
                                                    {
                                                        document.getElementById('editanswerform').style.display="block";
                                                    }
                                                </script> --}}

 {{-- Adding answer form --}}
 {{-- <div id="addanswerform" style="display: none"  class="modal">
    <form action="/addanswer" method="post">
      @csrf
     <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
     <input type="hidden" id="answerid" name="answerid" value="{{$item->chatQuestionAnsId}}">


             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalPopoversLabel">ADD ANSWER</h5>
                         <button type="button" class="close " data-dismiss="modal" aria-label="Close" onclick="hideForm()">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <div class="form-group">
                             <label for="place"><b style="color: black">Answer</b></label>
                             <textarea name="answer" id="answer"  class="form-control" placeholder="Enter question answer" onkeyup="return validationsavebtn()" width="100%"></textarea>
                             <span id="answernew_error" class="text-danger"></span>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <label class="h6 large d-block text-uppercase"></label>
                                                            
                         <span class=" text-hide">!</span>
                         
                         <input type="submit" name="Save" id="save" value="Save" class="form-control btn btn-primary" style="width: 90px; background-color:blueviolet" onsubmit="return validationsavebtn()" disabled>
                     </div>
                 </div>
             </div>
    </form>
  </div> --}}
 {{-- END---add form start --}}

   {{-- edit form start --}}

   {{-- <div id="editanswerform" style="display: none" class="modal">
    <form action="/updateanswerform" method="post">
      @csrf
     <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
     <input type="hidden" id="answerid" name="answerid" value="{{$item->chatQuestionAnsId}}">


             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalPopoversLabel">UPDATE ANSWER</h5>
                         <button type="button" class="close " data-dismiss="modal" aria-label="Close" onclick="hideForm()">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <div class="form-group">
                             <label for="place"><b style="color: black">Answer</b></label>
                             <textarea  id="answerOld" name="answerOld"  value="{{$item->Answer}}" hidden></textarea>
                             <textarea name="answer_update" id="answer_update"  class="form-control" placeholder="Enter question answer" onkeyup="return validationupdatebtn()" width="100%">{{$item->Answer}}</textarea>
                             <span id="answeredit_error" class="text-danger"></span>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <label class="h6 large d-block text-uppercase"></label>
                                                            
                         <span class=" text-hide">!</span>
                         
                      <button  name="" id="update" class="form-control btn btn-primary" style="width: 90px; background-color:blueviolet" >Update</button>
                     </div>
                 </div>
             </div>
    </form>
  </div> --}}
   
   {{-- edit form end --}}


                                           
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
            </div>



            <style>
                /* Styling for the modal */
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1050;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    overflow: hidden;
                    outline: 0;
                    background-color: rgba(0, 0, 0, 0.4);
                    display: flex;
                    align-items: center;
                    justify-content: center; /* Add this line to center horizontally and vertically */
                }
                
                .modal-dialog {
                    position: relative;
                    width: 600px; /* Adjust the width as per your preference */
                }
                
                .modal-content {
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    pointer-events: auto;
                    background-color: #fff;
                    background-clip: padding-box;
                    border: 1px solid rgba(0, 0, 0, 0.2);
                    border-radius: 0.3rem;
                    outline: 0;
                    width: 150%;
                    max-width: 700px; /* Add this line to limit the width */
                }
                
                .close {
                    color: #aaa;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }
                
                .close:hover,
                .close:focus {
                    color: black;
                    text-decoration: none;
                    cursor: pointer;
                }
                
                /* Increase the size of the form elements */
                .modal-content form input[type="text"],
                .modal-content form textarea {
                    width: 100%;
                    padding: 10px;
                    font-size: 16px;
                }
            </style>
            
            
            
            
            
            
            
          
         {{-- validation --}}
         {{-- <script>
            function validationsavebtn() {
              var answers = document.getElementById('answer').value;
              if (answers === "") {
                document.getElementById("answernew_error").innerHTML = "This field is required.";
                document.getElementById("save").disabled = true; // Prevent form submission
              } else {
                
                document.getElementById("answernew_error").innerHTML = "";
               // alert('hjbd');
                document.getElementById("save").disabled = false; // Allow form submission
              }
            }
          
          </script> --}}
          {{-- update validation --}}
          {{-- <script>
            function validationupdatebtn() {
              var answersedit = document.getElementById('answer_update').value;
              if (answersedit === "") {
                document.getElementById("answeredit_error").innerHTML = "This field is required.";
                document.getElementById("update").disabled = true; // Prevent form submission
              } else {
                
                document.getElementById("answeredit_error").innerHTML = "";
               // alert('hjbd');
                document.getElementById("update").disabled = false; // Allow form submission
              }
            }
          
            // Enable the button initially
           // document.getElementById("save").disabled = false;
          </script> --}}
           {{-- Adding form end --}}



          
                {{-- <script>
                    function hideForm() {
                        document.getElementById("addanswerform").style.display = "none";
                        location.reload();
                    }
                </script> --}}


             {{-- div none close      --}}

           
            






            {{--Edit question modal--}}

           

 




        </main> <!-- main -->
    </div> <!-- .wrapper -->


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   

    <script>
        //SHOW ANSWSER OVER THE QUESTION
        function showanswer(chatQuestionAnsId){
            //document.getElementById("show_loader").style.display= 'block';
           // alert(chatQuestionAnsId);
            $.ajax({
                url: "{{url('/questionadminTakeandAnswer')}}",
                type: "GET",
                data: {
                    chatQuestionAnsId: chatQuestionAnsId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {
                   // console.log(result);
                   // console.log(result[0].answer);
                   // alert(result[0].answer);
                    if (result) {
                        //document.getElementById("show_loader").style.display= 'none';

                        const answerover =document.getElementsByName("answerover");
                        answerover.forEach(button=>{button.style.display = 'none'; })


                        document.getElementById('answeronmousehover'+chatQuestionAnsId).style.display= 'block';

                        document.getElementById('answeronmousehover'+chatQuestionAnsId).innerHTML=result[0].Answer;
                    }
                }
            })
        }
        function hideanswer(chatQuestionAnsId){
            document.getElementById('answeronmousehover'+chatQuestionAnsId).innerHTML="";
        }

        // SCRIPT TO SHOW QUESTION TO SHOW MODEL
        function showq(chatQuestionAnsId) {

            $.ajax({
                url: "{{url('/adminquestionandAnswerview')}}",
                type: "GET",
                data: {
                    chatQuestionAnsId: chatQuestionAnsId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {

                    if (result) {
                      

                        document.getElementById("usernameinview").innerHTML =result[0].name;
                        document.getElementById("examnameinview").innerHTML =result[0].mName;
                        document.getElementById("modulenameinview").innerHTML =result[0].question;
                        document.getElementById("submodulenameinview").innerHTML =result[0].Answer;
                       
                         document.getElementById("submodulenameinview").style="color:green;";
                     
                        //show popupresult
                        // document.getElementById("show_question").style.display = "none";
                        $('#show_question').modal('show');
                        // data-target="#show_question"
                    }}
            })
        }
    </script>


 {{--Show question modal--}}

 

 <div class="new-modal fade" id="show_question" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="new-modal-dialog" role="document">
        <div class="new-modal-content">
            <div class="new-modal-header">
                <h5 class="new-modal-title" id="defaultModalLabel">View</h5>
                <button type="button" class="close" onclick="handleformhide();" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="new-modal-body">
                <table>
                    <tr>
                        <input type="text" name="cqId" id="cqIdshowq" hidden>
                    </tr>
                    <tr>
                        <br>
                        <b style="color: black;">User Name :</b>
                        <p id="usernameinview" name="usernameinview" style="font-weight: bold;color:blue;" disabled></p>
                    </tr>
                    <tr>
                        <br>
                        <b style="color: black;">Module Name :</b>
                        <p id="examnameinview" name="examnameinview" style="font-weight: bold;color:blue;" disabled></p>
                    </tr>
                    <tr>
                        <br>
                        <b style="color: black;">Question :</b>
                        <p id="modulenameinview" name="modulenameinview" style="font-weight: bold;color:blue;" disabled></p>
                        <br>
                    </tr>
                    <tr>
                        <b style="color: black;">Answer :</b>
                        <p id="submodulenameinview" name="submodulenameinview" style="font-weight: bold;color:blue;" disabled></p>
                        <br>
                    </tr>
                    <div class="new-modal-footer">
                    </div>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    // Function to handle click events outside of the modal
    function handleOutsideClick(event) {
        if (event.target === document.getElementById('show_question')) {
           // $('#show_question').modal('hide');
            document.getElementById('show_question').style.display="none";
            location.reload();
        }
    }

    // Add event listener to the document
    document.addEventListener('click', handleOutsideClick);
</script>

<script>
    function handleformhide()
    {
        document.getElementById('show_question').style.display="none";
            location.reload();
    }
    </script>

<style>
    .new-modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
}

.new-modal-dialog {
    position: relative;
    width: 800px; /* Adjust the width as per your preference */
    margin: 0.5rem auto;
    pointer-events: none;
    top: 8%;
}

.new-modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0.3rem;
    outline: 0;
}

.new-modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 0.5rem;
    border-bottom: 1px solid #e9ecef;
    border-top-left-radius: 0.3rem;
    border-top-right-radius: 0.3rem;
}

.new-modal-title {
    margin-bottom: 0;
    line-height: 1.5;
}

.new-modal-body {
    position: relative;
    flex: 1 1 auto;
    padding: 1rem;
}

.new-modal-footer {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-end;
    padding: 0.75rem;
    border-top: 1px solid #e9ecef;
    border-bottom-right-radius: 0.3rem;
    border-bottom-left-radius: 0.3rem;
}

.new-modal-footer>* {
    margin: 0.25rem;
}

   </style> 




    <!-- EditModal -->

    <style>
        .arrow {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
        }
        .down {
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
        }
    </style>


    <!-- TO SHOw LAODER -->
   
    <!-- FORM FOR MODEL TO SHOW VALUES -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <script src='js/dataTables.bootstrap4.min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    

{{-- 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}


    
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



@endsection
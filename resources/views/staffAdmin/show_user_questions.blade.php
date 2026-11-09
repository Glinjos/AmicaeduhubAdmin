@extends('staffAdmin.staffAdminMaster')


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
                        <h2 class="mb-2 page-title">View Users Questions</h2>

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
                                                <th style="color: black;"><b>Chat Type</b></th> 
                                                 <th style="color: black;"><b>User Name</b></th>
                                                <th style="color: black;"><b>Module Name</b></th>
                                                {{-- <th style="color: black;"><b>Questions</b></th>
                                                <th style="color: black;"><b>Chat Date and Time</b></th> --}}
                                                {{-- <th style="color: black;"><b></b></th> --}}
                                                <th style="color: black;"><b>ACTIONS</b></th>

                                            </tr>
                                            </thead>
                                            <tbody>


                                           

                                            <!--LOADER END HERE AFTER LOADING DATA -->



                                            @if(isset($users_all_questions))

                                                @php $i=1; @endphp

                                                @foreach ($users_all_questions as $item)

                                                    <tr  style=color:black;">
                                                        <td width="65"><b>{{$i++}}</b></td>

                                                        <td width="90">{{$item->typeName}}</td>
                                                        <td width="90">{{$item->name}}</td>
                                                        <td width="90">{{$item->mName}}</td>
                                                        {{-- <td width="150"><span id="qu{{$i}}" style="word-wrap: break-word;">{{ $item->question}}</span></td> --}}
                                                       
                                                       
                                                        
                                                        {{-- <td width="300">
                                                            <span  id="que{{$i}}" style="word-wrap: break-word;" onmouseover="return showanswer(<?php echo $item->chatQuestionId; ?>)"
                                                                   onmouseout="return hideanswer(<?php echo $item->chatQuestionId; ?>)">{{$item->question}}</span>
                                                            <p name="answerover" id="answeronmousehover{{$item->chatQuestionId}}" style="width:400px;word-wrap: break-word; display: none;color:green;font-weight: bold;" >"answer is" </p>
                                                        </td> --}}

                                                        {{-- <td width="100">{{$item->chatDateTime}}</td> --}}

                                                       
                                                        <td width="10">
                                                           
                     {{-- <abbr style="text-decoration: none;" title="ViewMore"><span onclick="return  showq(<?php echo $item->chatQuestionId;?>)"   style="font-size:26px;color: green;" class="material-icons">question_answer</span></abbr> --}}
                                                        
                                                        
                                                         
                 <abbr style="text-decoration: none;" title="Chats"> <a href="{{url('showchatsubquestions'.$item->chatQuestionId)}}"  style="text-decoration: none;"> <span  style="font-size:26px;color: green;" class="material-icons">question_answer</span></a></abbr>
                                                          

                                                        </td> 
                                                        


                                                    </tr>





                                           
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
                    width: 200%;
                    padding: 10px;
                    font-size: 16px;
                }
                 .textarea {
                    width: 100%; /* Adjust the width as per your preference */
                    height: 100px;
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
                .new-modal-content {
                overflow-y: auto;
                max-height: 650px; /* Adjust the maximum height as per your preference */
                }
            </style>
            
            
            
            
            
            
            
          
         {{-- validation --}}
         <script>
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
          
          </script>
          {{-- update validation --}}
          <script>
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
          </script>
           {{-- Adding form end --}}



          
                <script>
                    function hideForm() {
                         document.getElementById("show_question").style.display = "none";
                        // document.getElementById("editanswerform").style.display = "none";
                        
                         location.reload();
                    //     alert("bfygv");
                    //     document.getElementById("editanswerform").reset(); // Reset the form fields
                    //    $('#model').modal('hide'); 
                    }
                </script>


             {{-- div none close      --}}

           
            






            {{--Edit question modal--}}

           

 




        </main> <!-- main -->
    </div> <!-- .wrapper -->


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   

    <script>
        //SHOW ANSWSER OVER THE QUESTION
        function showanswer(chatQuestionId){
            //document.getElementById("show_loader").style.display= 'block';
            $.ajax({
                url: "{{url('/questionTakeandAnswer')}}",
                type: "GET",
                data: {
                    chatQuestionId: chatQuestionId,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {
                   // console.log(result);
                   // console.log(result[0].answer);
                    if (result) {
                        //document.getElementById("show_loader").style.display= 'none';

                        const answerover =document.getElementsByName("answerover");
                        answerover.forEach(button=>{button.style.display = 'none'; })


                        document.getElementById('answeronmousehover'+chatQuestionId).style.display= 'block';

                        document.getElementById('answeronmousehover'+chatQuestionId).innerHTML=result[0].Answer;
                    }
                }
            })
        }
        function hideanswer(chatQuestionId){
            document.getElementById('answeronmousehover'+chatQuestionId).innerHTML="";
        }

        // SCRIPT TO SHOW QUESTION TO SHOW MODEL
        // function showq(chatQuestionId) {

        //     $.ajax({
        //         url: "{{url('/questionTakeandAnswerview')}}",
        //         type: "GET",
        //         data: {
        //             chatQuestionId: chatQuestionId,
        //             _token: '{{csrf_token()}}'
        //         },
        //         success: function(result) {

        //             if (result) {
                      

        //                 document.getElementById("examnameinview").innerHTML =result[0].mName;
                       
  
        //                 var questmodulenameinview = document.getElementById("questmodulenameinview");
        //                     questmodulenameinview.innerHTML = ""; // Clear previous content

        //                     for (var i = 0; i < result.length; i++) {
        //                     var question = result[i].question;
        //                     var questionElement = document.createElement("p");
        //                     questionElement.innerHTML = question;
        //                     questionElement.classList.add("question-style"); // Add CSS class for styling
        //                     questmodulenameinview.appendChild(questionElement);

        //                     if (i !== result.length - 1) {
        //                         var divider = document.createElement("br");
        //                         questmodulenameinview.appendChild(divider);
        //                     }
                            
        //                     }





                        
        //                  document.getElementById("submodulenameinview").style="color:green;";
                     
        //                 //show popupresult
        //                 // document.getElementById("show_question").style.display = "none";
        //                 $('#show_question').modal('show');
        //                 // data-target="#show_question"
        //             }}
        //     })
        // }

        //check
        function showq(chatQuestionId) {
    $.ajax({
        url: "{{url('/questionTakeandAnswerview')}}",
        type: "GET",
        data: {
            chatQuestionId: chatQuestionId,
            _token: '{{csrf_token()}}'
        },
        success: function(result) {
            if (result) {
                document.getElementById("examnameinview").innerHTML = result[0].mName;

                var questmodulenameinview = document.getElementById("questmodulenameinview");
                questmodulenameinview.innerHTML = ""; // Clear previous content

                for (var i = 0; i < result.length; i++) {
                    var question = result[i].question;
                    var questionElement = document.createElement("p");
                    questionElement.innerHTML = question;
                    questionElement.classList.add("question-style"); // Add CSS class for styling
                    questmodulenameinview.appendChild(questionElement);

                    if (i !== result.length - 1) {
                        var divider = document.createElement("br");
                        questmodulenameinview.appendChild(divider);
                    }
                }

                // Set the answer input field value
                // var answerInput = document.getElementById("submodulenameinview");
                // answerInput.value = result[0].answer;

                // Show the modal
                $('#show_question').modal('show');
            }
        }
    });
}

    </script>
<style>
   .chat-container {
  margin-bottom: 10px;
}


.question-style {
  display: inline-block;
  border-radius: 40px;
  background-color: whitesmoke;
  padding: 10px;
  margin-bottom: 10px;
  font-weight: normal; /* Set the font weight to normal */
}

  </style>
  
  

 {{--Show question modal--}}

 

 <div class="new-modal fade" id="show_question" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="new-modal-dialog" role="document">
        <div class="new-modal-content">
            <div class="new-modal-header">
                <h5 class="new-modal-title" id="defaultModalLabel">Chats</h5>
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
                        <b style="color: black;">Module Name :</b>
                        <p id="examnameinview" name="examnameinview" style="font-weight: bold;color:blue;" disabled></p>
                    </tr>
                    <tr>
                        <b style="color: black;">Questions :</b>
                        <p id="questmodulenameinview" name="questmodulenameinview" class="chat-container" style="font-weight: bold;color:rgb(22, 19, 20);" disabled></p>
                       
                    </tr>
                    <tr>
                        <b style="color: black;">Answer :</b>
                        <textarea name="answer" id="answer" class="textarea"  placeholder="Enter question answer" onkeyup="return validationsavebtn()" ></textarea>
                             <span id="answernew_error" class="text-danger"></span>
                        <br>
                    </tr>
                    <tr>
                        <br>
                        <button type="button" id="close" class="btn btn-secondary" onclick="hideForm()" data-dismiss="modal">Close</button>
                         
                        <span style="margin-right: 10px;"></span>

                         <input type="submit" name="Save" id="save" value="Save" class="form-control btn btn-primary" style="width: 90px; background-color:blueviolet" onsubmit="return validationsavebtn()" disabled>
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
            $('#show_question').modal('hide');
                //document.getElementById('show_question').style.display="none";
                location.reload();
            }
        }

        // Add event listener to the document
        document.addEventListener('click', handleOutsideClick);
    </script>

    <script>
        function handleformhide() {
            var modal = document.getElementById('show_question');
            modal.style.display = "none";
            modal.className = modal.className.replace('new-modal fade', '');
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
            top: 0%;
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
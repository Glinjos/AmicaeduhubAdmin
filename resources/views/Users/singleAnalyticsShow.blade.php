@extends('admin/adminMaster')

@section('adminpanel')

<style>
    .custom-pagination-class .pagination {
  display: flex;
  justify-content: center;
    margin-top: 20px;
    }

    .custom-pagination-class .pagination .page-item {
    margin: 0 5px;
    }

    .custom-pagination-class .pagination .page-link {
    padding: 8px 16px;
    background-color: #f2f2f2;
    color: #333;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s;
    }

    .custom-pagination-class .pagination .page-link:hover {
    background-color: #e0e0e0;
    }

    .custom-pagination-class .pagination .page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    }

    .custom-pagination-class .pagination .page-item.disabled .page-link {
    opacity: 0.5;
    pointer-events: none;
    }

    .analytics-button {
    background-color: blue;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }


    .search-input {
  /* width: 30px; */
  padding: 10px;
  border: 1px solid #2e1818;
  border-radius: 1px;
  font-size: 16px;
}

.search-input:focus {
  outline: none;
  border-color: #1e333a;
}

.align-right {
  text-align: right;
}
.exam-details {
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f2f2f2;
}


    </style>
<main role="main" class="main-content">
  <div class="container-fluid">

      <div class="row justify-content-center">
          <div class="col-12">
            
            @if(isset($userAnalytics))
            @foreach($userAnalytics as $item)
            <h2 class="page-title">{{$item->name}} Analytics</h2>
            {{-- <h2 class="page-title">{{$item->name}} details</h2> --}}
            <br>
            @endforeach
           @endif
        
             
              
                   <script>
                    window.onload = function () {
                        @isset($SinglHistPQUlss)
                        showBlock();
                        @endisset
                        @isset($SinglHistMEXlss)
                        showMainExam();
                        @endisset
                        @isset($SinglHistGZOOlss)
                        showGameZone();
                        @endisset
                        @isset($SinglHistVDClss)
                        showVideoClass();
                        @endisset
                    };
                  </script>
                  
        
                
                
                
                 






                  
                {{-- the tables start here-------we go--- --}}

{{-- The table previous start Here --}}
<div id="previousQuest" style="display: none;"> 
  <div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-12">
            <h2 class="page-title">Previous Question Exam History</h2>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">

                            <!-- table -->
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr style="background-color: lightgray;">
                                    <th style="color: black;"><b>SL NO</b></th>
                                    
                                    {{-- <th style="color: black;"><b>EXAM TYPE</b></th> --}}
                                    <th style="color: black;"><b>Exam Date</b></th>
                                    <th style="color: black;"><b>Exam Type</b></th>
                                    <th style="color: black;"><b>Exam Year</b></th>
                                    <th style="color: black;"><b>Exam Name</b></th>
                                    <th style="color: black;"><b>Total Questions</b></th>
                                    <th style="color: black;"><b>Attended Questions</b></th>
                                    <th style="color: black;"><b>Right Answer</b></th>
                                    <th style="color: black;"><b>Wrong Answer</b></th>
                                    <th style="color: black;"><b>Total Score</b></th>
                                    <th style="color: black;"><b>Total Mark Percentage</b></th>




                                    <!-- <th>Action</th> -->
                                </tr>
                                </thead>
                                <tbody id="previousquestion">
                                         @if(isset($SinglHistPQUlss))  
                                  @php $i=1 @endphp
                                                  @foreach ($SinglHistPQUlss as $item)
                                                
                                                      <tr style="color: black;">

                                                          <td width="65"><b>{{$i++}}</b></td>
                                                         

                                                          {{-- <td width="100">{{wordwrap($item->pqmainName,20,"\n",TRUE) }}</td> --}}
                                                          <td width="100">{{wordwrap($item->dateAndTime,20,"\n",TRUE) }}</td>
                                                          <td width="100">{{wordwrap($item->pqmainName,20,"\n",TRUE) }}</td>
                                                          <td width="100">{{wordwrap($item->pqmName,20,"\n",TRUE) }}</td>
                                                          <td width="100">{{wordwrap($item->pqsmName,20,"\n",TRUE) }}</td>
                                                          <td width="100">{{wordwrap($item->totalQuestions,20,"\n",TRUE) }}</td>
                                                          <td width="100">{{wordwrap($item->QuestionsAttended,20,"\n",TRUE) }}</td>
                                                          <td width="100">{{wordwrap($item->rightAns,20,"\n",TRUE) }}</td>
                                                          <td width="100">{{wordwrap($item->wrongAns,20,"\n",TRUE) }}</td>
                                                          {{-- <td width="100">{{wordwrap($item->score,20,"\n",TRUE) }}</td> --}}
                                                          <td width="100">{{ round($item->score, 2) }}</td>

                                                          {{-- <td width="100">{{wordwrap($item->percentage,20,"\n",TRUE) }} %</td> --}}
                                                          <td width="100">{{ round($item->percentage ,2) }}%</td>

                                                         

                                                         
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
</div> <!-- .container-fluid -->
 
   </div>

   {{-- End here --}}

   {{-- main exam history showing table start here------the single user --}}
   <div id="mainExam" style="display: none;"> 
    <div class="container-fluid">
      <div class="row justify-content-center">

          <div class="col-12">
              <h2 class="page-title">Main Exam History</h2>
              <div class="row my-4">
                  <!-- Small table -->
                  <div class="col-md-12">
                      <div class="card shadow">
                          <div class="card-body">

                              <!-- table -->
                              <table class="table datatables" id="dataTable-2">
                                  <thead>
                                  <tr style="background-color: lightgray;">
                                      <th style="color: black;"><b>SL NO</b></th>
                                      
                                      {{-- <th style="color: black;"><b>EXAM TYPE</b></th> --}}
                                      <th style="color: black;"><b>Exam Date</b></th>
                                      <th style="color: black;"><b>Exam Module</b></th>
                                      <th style="color: black;"><b>Exam Sub Module</b></th>
                                      <th style="color: black;"><b>Exam Sub Module Code</b></th>
                                      <th style="color: black;"><b>Total Questions</b></th>
                                      <th style="color: black;"><b>Attended Questions</b></th>
                                      <th style="color: black;"><b>Right Answer</b></th>
                                      <th style="color: black;"><b>Wrong Answer</b></th>
                                      <th style="color: black;"><b>Total Score</b></th>
                                      <th style="color: black;"><b>Total Mark Percentage</b></th>




                                      <!-- <th>Action</th> -->
                                  </tr>
                                  </thead>
                                  <tbody id="previousquestion">
                                           @if(isset($SinglHistMEXlss))  
                                    @php $i=1 @endphp
                                                    @foreach ($SinglHistMEXlss as $item)
                                                  
                                                        <tr style="color: black;">

                                                            <td width="65"><b>{{$i++}}</b></td>
                                                           

                                                            {{-- <td width="100">{{wordwrap($item->pqmainName,20,"\n",TRUE) }}</td> --}}
                                                            <td width="100">{{wordwrap($item->dateAndTime,20,"\n",TRUE) }}</td>
                                                            <td width="100">{{wordwrap($item->mName,20,"\n",TRUE) }}</td>
                                                            <td width="100">{{wordwrap($item->smName,20,"\n",TRUE) }}</td>
                                                            <td width="100">{{wordwrap($item->smCode,20,"\n",TRUE) }}</td>
                                                            <td width="100">{{wordwrap($item->totalQuestions,20,"\n",TRUE) }}</td>
                                                            <td width="100">{{wordwrap($item->QuestionsAttended,20,"\n",TRUE) }}</td>
                                                            <td width="100">{{wordwrap($item->rightAns,20,"\n",TRUE) }}</td>
                                                            <td width="100">{{wordwrap($item->wrongAns,20,"\n",TRUE) }}</td>
                                                            {{-- <td width="100">{{wordwrap($item->score,20,"\n",TRUE) }}</td>
                                                            <td width="100">{{wordwrap($item->percentage,20,"\n",TRUE) }} %</td> --}}
                                                            <td width="100">{{ round($item->score, 2) }}</td>
                                                            <td width="100">{{ round($item->percentage ,2) }}%</td>
                                                           

                                                           
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
  </div> <!-- .container-fluid -->
   
     </div>
     {{-- main exam history showing table end here------the single user --}}


     {{-- AND the game zone are datatable start --}}

     <div id="gameZone" style="display: none;"> 
      <div class="container-fluid">
        <div class="row justify-content-center">
  
            <div class="col-12">
                <h2 class="page-title">Game Zone History</h2>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
  
                                <!-- table -->
                                <table class="table datatables" id="dataTable-3" >
                                    <thead>
                                    <tr style="background-color: lightgray;">
                                        <th style="color: black;"><b>SL NO</b></th>
                                        
                                       
                                        <th style="color: black;"><b>Game Date</b></th>
                                        <th style="color: black;"><b>Total Questions</b></th>
                                        <th style="color: black;"><b>Attended Questions</b></th>
                                        <th style="color: black;"><b>Right Ans</b></th>
                                      
                                        <th style="color: black;"><b>Wrong Ans</b></th>
                                        <th style="color: black;"><b>Score</b></th>
                                       
                                       
                                        <th style="color: black;"><b>Winner</b></th>
  
  
  
  
                                        <!-- <th>Action</th> -->
                                    </tr>
                                    </thead>
                                    <tbody id="previousquestion">
                                             @if(isset($SinglHistGZOOlss))  
                                      @php $i=1 @endphp
                                                      @foreach ($SinglHistGZOOlss as $item)
                                                    
                                                          <tr style="color: black;">
  
                                                              <td width="50"><b>{{$i++}}</b></td>
                                                             
  
                                                              
                                                                <td width="90">{{wordwrap($item->date_time,20,"\n",TRUE) }}</td>

                                                              

                                                                
                                                                <td width="90">{{wordwrap($item->totalQuestion,20,"\n",TRUE) }}</td>
                                                                <td width="90">{{wordwrap($item->attendedQuestions,20,"\n",TRUE) }}</td>
                                                               
                                                                <td width="80">{{ wordwrap($item->rightAns, 20,"\n",TRUE) }}</td>
                                                                <td width="90">{{ wordwrap($item->wrongAns, 20,"\n",TRUE) }} </td>
                                                               
                                                                <td width="80">{{ wordwrap($item->score, 20,"\n",TRUE) }}</td>

                                                                <td width="80">{{ wordwrap($item->winner_name, 20,"\n",TRUE) }}</td>
                                                               
                                                             
  
                                                               
                                                             
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
    </div> <!-- .container-fluid -->
     
       </div>

       {{-- END THE GAME ZONE TABLE SHOWING ----------AND START THE VIDEO CLASS HISTORY OF SINGLE USER --}}

       <div id="videoClass" style="display: none;"> 
        <div class="container-fluid">
          <div class="row justify-content-center">
    
              <div class="col-12">
                  <h2 class="page-title">Video Class Exam History</h2>
                  <div class="row my-4">
                      <!-- Small table -->
                      <div class="col-md-12">
                          <div class="card shadow">
                              <div class="card-body">
    
                                  <!-- table -->
                                  <table class="table datatables" id="dataTable-4">
                                      <thead>
                                      <tr style="background-color: lightgray;">
                                          <th style="color: black;"><b>SL NO</b></th>
                                          
                                          {{-- <th style="color: black;"><b>EXAM TYPE</b></th> --}}
                                          <th style="color: black;"><b>Exam Date</b></th>
                                          <th style="color: black;"><b>Exam Subject</b></th>
                                          <th style="color: black;"><b>Exam Chapter</b></th>
                                          <th style="color: black;"><b>Exam Video</b></th>
                                          <th style="color: black;"><b>Total Questions</b></th>
                                          <th style="color: black;"><b>Attended Questions</b></th>
                                          <th style="color: black;"><b>Right Answer</b></th>
                                          <th style="color: black;"><b>Wrong Answer</b></th>
                                          <th style="color: black;"><b>Total Score</b></th>
                                          <th style="color: black;"><b>Total Mark Percentage</b></th>
    
    
    
    
                                        
                                      </tr>
                                      </thead>
                                      <tbody id="videoclassTbody">
                                            
                                        @if(isset($SinglHistVDClss))  
                                        @php $i=1 @endphp
                                                        @foreach ($SinglHistVDClss as $item)
                                                      
                                                            <tr style="color: black;">
    
                                                                <td width="65"><b>{{$i++}}</b></td>
                                                               
    
                                                                {{-- <td width="100">{{wordwrap($item->pqmainName,20,"\n",TRUE) }}</td> --}}
                                                                <td width="100">{{wordwrap($item->dateAndTime,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{wordwrap($item->vcmName,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{wordwrap($item->vcChapterName,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{wordwrap($item->videoHeading,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{wordwrap($item->totalQuestions,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{wordwrap($item->QuestionsAttended,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{wordwrap($item->rightAns,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{wordwrap($item->wrongAns,20,"\n",TRUE) }}</td>
                                                                <td width="100">{{ round($item->score, 2) }}</td>
                                                                <td width="100">{{ round($item->percentage, 2) }} %</td>
                                                                
                                                               
    
                                                               
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
      </div> <!-- .container-fluid -->
       
         </div>



      
     <div class="row">

    {{-- GAME ZONE DIV --}}


         {{-- game zone --}}
         @if(isset($userAnalytics))
         @foreach($userAnalytics as $user)
         <div class="col-md-3 my-2">
          <div class="card shadow text-right">
              <div class="card-body">
                  <div class="row align-items-start">
                    <div class="spinner-grow mr-3 spinner-grow-sm" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <strong class="card-title">Game Zone</strong>
                      <div class="col" >
                       
                          <a href="{{ url('getGamezoneSingleHist' . $user->uId) }}">
                            <strong style="color: #5e95ff"> View More </strong>
                           </a>
                     
                          
                      </div>
                    
                      <script>
                        function showGameZone() {
                       
                        
                        document.getElementById('gameZone').style.display="block";
                        document.getElementById('dataTable-3');
                     
                          gameZone=dataTable-3;
                      document.addEventListener('click', function(e) {
                          if (!gameZone.contains(e.target) && e.target.getAttribute('href') !== "{{ url('/getGamezoneSingleHist'.$user->uId) }}") {
                              gameZone.style.display = 'none';
                          }
                      });
                       
                       }
                     </script>      

                      @endforeach
                      @endif
                  </div> <!-- /.row -->
              </div> <!-- /.card-body -->
          </div> <!-- /.card -->
      </div>
         {{-- game zone end --}}


               
     {{-- LIVE GAME START HERE --}}

         @if(isset($userAnalytics))
         @foreach($userAnalytics as $user)
         <div class="col-md-3 my-2">
          <div class="card shadow text-right">
              <div class="card-body">
                  <div class="row align-items-start">
                    <div class="spinner-grow mr-3 spinner-grow-sm" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <strong class="card-title">Live Game</strong>
                      <div class="col" >
                       
                          <a href="{{ url('getLiveGamesSingleHist' . $user->uId) }}">
                            <strong style="color: #5e95ff"> View More </strong>
                           </a>
                     
                          
                      </div>
                    
                      

                      @endforeach
                      @endif
                  </div> <!-- /.row -->
              </div> <!-- /.card-body -->
          </div> <!-- /.card -->
      </div>

      {{-- LIVE GAME END --}}
      
      
      
      
      
      {{-- Users Revisions START HERE --}}

      @if(isset($userAnalytics))
      @foreach($userAnalytics as $user)
      <div class="col-md-3 my-2">
       <div class="card shadow text-right">
           <div class="card-body">
               <div class="row align-items-start">
                 {{-- <div class="spinner-grow mr-3 spinner-grow-sm" role="status">
                   <span class="sr-only">Loading...</span>
                 </div> --}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 <strong class="card-title" style="text-align: center">Revision</strong>
                   <div class="col" >
                    
                       <a href="{{ url('getSingleUserRevisionsdetails' . $user->uId) }}">
                         <strong style="color: #5e95ff"> View More </strong>
                        </a>
                  
                       
                   </div>
                 
                   

                   @endforeach
                   @endif
               </div> <!-- /.row -->
           </div> <!-- /.card-body -->
       </div> <!-- /.card -->
   </div>

   {{-- REVISION END --}}
      
      
      

</div>
















                {{-- the tables end here----- --}}







                  
                
                    <div class="row">
                        <!-- Recent Activity -->
                        <div class="col-md-12 col-lg-4 mb-4">
                          <div class="card timeline shadow">
                            
                            <div class="card-header">
                              <strong class="card-title">Previous Exam</strong>
                              <p class="float-right small text-muted" >Recent</p>
                            </div>
                            <div class="card-body" data-simplebar style="height:380px; overflow-y: auto; overflow-x: hidden;">
                              {{-- <h6 class="text-uppercase text-muted mb-4">Today</h6> --}}
                              @if(isset($alluserPQDetails))
                                @if(count($alluserPQDetails) > 0)
                              @foreach($alluserPQDetails as $data) 
                              <div class="exam-details">
                                <!--<h6>Exam Date: {{$data->dateAndTime}}</h6>-->
                                  <h6>Exam Date:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;"><?php echo date('Y-m-d', strtotime($data->dateAndTime)); ?></span></h6>
                                  <h6>Exam Type:  <span style="color: red;">{{$data->pqmainName}}</span></h6>
                                  <h6>Exam Year:  <span style="color: red;">{{$data->pqmName}}</span></h6>
                                  <h6>Exam Name:  <span style="color: red;">{{$data->pqsmName}}</span></h6>
                                  <h6>Total Questions: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color: black;">{{$data->totalQuestions}}</span></h6>
                                  <h6>Attended Questions:  <span style="color: black;">{{$data->QuestionsAttended}}</span></h6>
                                  <h6>Right Answer: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;"> {{$data->rightAns}}</span></h6>
                                  <h6>Wrong Answer:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;">{{$data->wrongAns}}</span></h6>
                                  <h6>Total Score: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;"> {{$data->score}}</span></h6>
                                  <h6>Total Mark Percentage:  <span style="color: black;">{{ round($data->percentage, 2) }} %</span></h6>
                              </div>
              
                               
                                <a href="{{ url('getPrevQuestSingleHist' . $data->uId) }}">
                                 View More
                                </a>
                                
                               
                                

                                
                          
                          <script>
                            function showBlock() {
                           
                         //  alert("previous exam");
                           
                             document.getElementById('previousQuest').style.display="block";
                             document.getElementById('dataTable-1');
                                 
                             previousQuest=dataTable-1;
                             document.addEventListener('click', function(e) {
                               if (!previousQuest.contains(e.target) && e.target.getAttribute('href') !== "{{ url('/getPrevQuestSingleHist'.$data->uId) }}") {
                                 previousQuest.style.display = 'none';
                               }
                             });
                           
                           }
                         </script>
                         
                         
                          @endforeach
                          @else
                          <p>No data found.</p>
                      @endif
                          @endif
                            </div> <!-- / .card-body -->
                          </div> <!-- / .card -->
                        </div> <!-- / .col-md-6 -->
                        <!-- Striped rows -->

                       
                        <div class="col-md-12 col-lg-4 mb-4">
                          <div class="card timeline shadow">
                            
                            <div class="card-header">
                              <strong class="card-title">Main Exam</strong>
                              <p class="float-right small text-muted" >Recent</p>
                            </div>
                            <div class="card-body" data-simplebar style="height:380px; overflow-y: auto; overflow-x: hidden;">
                              {{-- <h6 class="text-uppercase text-muted mb-4">Today</h6> --}}
                              @if(isset($alluserMEDetails))
                              @if(count($alluserMEDetails) > 0)
                            @foreach($alluserMEDetails as $data) 
                            <div class="exam-details">
                              <!--<h6>Exam Date: {{$data->dateAndTime}}</h6>-->
                                <h6>Exam Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;"><?php echo date('Y-m-d', strtotime($data->dateAndTime)); ?></span></h6>
                                {{-- <h6>Exam Type: {{$data->pqmainName}}</h6> --}}
                                <h6>Exam Module: <span style="color: red;">{{$data->mName}}</span></h6>
                                <h6>Exam Sub Module: <span style="color: red;">{{$data->smName}}</span></h6>
                                <h6>Sub Module Code: <span style="color: red;">{{$data->smCode}}</span></h6>
                                <h6>Total Questions: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;">{{$data->totalQuestions}}</span></h6>
                                <h6>Attended Questions: <span style="color: black;">{{$data->QuestionsAttended}}</span></h6>
                                <h6>Right Answer: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;">{{$data->rightAns}}</span></h6>
                                <h6>Wrong Answer: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;">{{$data->wrongAns}}</span></h6>
                                <h6>Total Score: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color: black;">{{$data->score}}</span></h6>
                                <h6>Total Mark Percentage: <span style="color: black;">{{ round($data->percentage, 2) }} %</span></h6>
                            </div>


                            <a href="{{ url('getMainExmSingleHist' . $data->uId) }}">
                              View More
                             </a>

                             <script>
                              function showMainExam() {
                             
                              // alert("main exam");
                             
                               document.getElementById('mainExam').style.display="block";
                               document.getElementById('dataTable-2');
                                 
                               mainExam=dataTable-2;
                               document.addEventListener('click', function(e) {
                                 if (!mainExam.contains(e.target) && e.target.getAttribute('href') !== "{{ url('/getMainExmSingleHist'.$data->uId) }}") {
                                  mainExam.style.display = 'none';
                                 }
                               });
                             
                             }
                           </script>




                        @endforeach
                        @else
                        <p>No data found.</p>
                    @endif
                        @endif
                              
                              
                              
                            </div> <!-- / .card-body -->
                          </div> <!-- / .card -->
                        </div>


                        
                        <div class="col-md-12 col-lg-4 mb-4">
                          <div class="card timeline shadow">
                            
                            <div class="card-header">
                              <strong class="card-title">Video Class Exam</strong>
                              <p class="float-right small text-muted" >Recent</p>
                            </div>
                            <div class="card-body" data-simplebar style="height:380px; overflow-y: auto; overflow-x: hidden;">
                              {{-- <h6 class="text-uppercase text-muted mb-4">Today</h6> --}}
                              @if(isset($alluserVCDetails))
                              @if(count($alluserVCDetails) > 0)
                              @foreach($alluserVCDetails as $videocls) 
                              <div class="exam-details">
                                  <!--<h6>Exam Date: {{$videocls->dateAndTime}}</h6>-->
                                  <h6>Exam Date:    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;"><?php echo date('Y-m-d', strtotime($videocls->dateAndTime)); ?></span></h6>
                                  <h6>Exam Subject: <span style="color: red;">{{$videocls->vcmName}}</span></h6>
                                  <h6>Exam Chapter: <span style="color: red;">{{$videocls->vcChapterName}}</span></h6>
                                  <h6>Exam Video:   <span style="color: red;">{{$videocls->videoHeading}}</span></h6>
                                  <h6>Total Questions:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: black;">{{$videocls->totalQuestions}}</span></h6>
                                  <h6>Attended Questions: &nbsp;<span style="color: black;">{{$videocls->QuestionsAttended}}</span></h6>
                                  <h6>Right Answer:      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color: black;">{{$videocls->rightAns}}</span></h6>
                                  <h6>Wrong Answer:      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color: black;">{{$videocls->wrongAns}}</span></h6>
                                  <h6>Total Score:       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color: black;">{{$videocls->score}}</span></h6>
                                  <h6>Total Mark Percentage:&nbsp;&nbsp;&nbsp; <span style="color: black;">{{ round($videocls->percentage, 2) }} %</span></h6>
                              </div>


                              <a href="{{ url('getVideoclassSingleHist' . $videocls->uId) }}">
                                View More
                               </a>
  
                               <script>
                                function showVideoClass() {
                               
                                // alert("video class");
                               
                                 document.getElementById('videoClass').style.display="block";
                                 document.getElementById('dataTable-4');
                                 
                                 videoClass=dataTable-4;
                                 document.addEventListener('click', function(e) {
                                   if (!videoClass.contains(e.target) && e.target.getAttribute('href') !== "{{ url('/getVideoclassSingleHist'.$videocls->uId) }}") {
                                    videoClass.style.display = 'none';
                                   }
                                 });
                               
                               }
                             </script>







                          @endforeach
                          @else
                          <p>No data found.</p>
                      @endif
                              @endif
                              
                              
                              
                 </div> <!-- / .card-body -->
               </div> <!-- / .card -->
           </div> <!-- / .col-md-6 -->

                        {{-- <div class="row"> --}}




                          
                       



                            
                          </div>
                        </div> <!-- Striped rows -->
                      </div>
                    {{-- </div> --}}

   

     
  









                     
                        <!-- / .col-md-6 -->
                        <!-- Striped rows -->
                       
                     

                        {{-- The table Main start Here --}}
  

     {{-- End here --}}








{{-- The table Main start Here --}}




   

     {{-- End here --}}












                     
                     {{-- div closing previousQuest view more --}}
                    
                </div>
            </div>
        </div>
    </main>

                    
                    
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                      
                   
                    
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                
                
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src='js/jquery.dataTables.min.js'></script>
                    <script src='js/dataTables.bootstrap4.min.js'></script>
                   
  




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
    <script>
       $('#dataTable-2').DataTable(
           {
            autoWidth: true,
            "lengthMenu": [
              [16, 32, 64, -1],
              [16, 32, 64, "All"]
               ]
        });
     </script> 
     <script>
      $('#dataTable-3').DataTable(
       {
             autoWidth: true,
            "lengthMenu": [
            [16, 32, 64, -1],
            [16, 32, 64, "All"]
                   ]
       });
     </script> 

<script>
  $('#dataTable-4').DataTable(
      {
          autoWidth: true,
          "lengthMenu": [
              [16, 32, 64, -1],
              [16, 32, 64, "All"]
          ]
      });
</script>







    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    

@endsection
@extends('admin/adminMaster')

@section('adminpanel')



<div class="wrapper">
    <main role="main" class="main-content">
     

                <div class="container-fluid">
                    <div class="row justify-content-center">

                        <div class="col-12">
                            <h2 class="page-title">Main Exam Reported Question</h2>
                            <div class="row my-4">
                                <!-- Small table -->

                                @if(isset($report))
                                @php
                                    // Group the report data by questionId
                                    $groupedReports = collect($report)->groupBy('questionId');
                                @endphp
                            
                                @foreach ($groupedReports as $questionId => $questionReports)

                               
                                <div class="col-md-12">
                                    <div class="card shadow">
                                        <div class="card-body">



                                          
                                                <div class="col-12">
                                                    
                                                    <div class="row my-4">
                                                        <!-- First card -->
                                                        <div class="col-xl-8 grid-margin stretch-card">
                                                            <div class="card shadow">
                                                                <div class="card-body">
                                                                    <form action="/update_the_reported_question" method="post">
                                                                        @csrf

                                                                    <input type="hidden" id="examMode" name="examMode" value="{{ $questionReports[0]->examMode }}" >
                                                                    <input type="hidden" id="questionId" name="questionId" value="{{ $questionReports[0]->questionId }}" >
                                                                    <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">




                                                                    <p><label for="question"><b style="color: black;">Question :</b> </label></p>
                                                                    <textarea id="question" name="question" rows="4" cols="50" style="flex-wrap: wrap;color: rgb(19, 46, 202);" class="form-control" placeholder="Enter question" required>{{ $questionReports[0]->question }}</textarea>
                                                                    <span id="question-error" class="text-danger"></span>
                                                                    @if ($errors->has('question'))
                                                                        <span class="text-danger">{{ $errors->first('question') }}</span>
                                                                    @endif <br>

                                                                    <div class="col-12">

                                                                        <p><label for="option1"><b style="color: black;">Option 1 :</b> </label></p>
                                                                        <div class="flex-style">
                                                                            <input type="radio" id="option1" name="answer" value="option1" {{ ($questionReports[0]->ansA=="1")? "checked" : "" }}  class="check-new">
                                                                            <input type="text" name="option1" id="option1" value="{{$questionReports[0]->optA}}" class="form-control" style="color: rgb(19, 46, 202);" placeholder="Enter option 1" required>
                                                                            <span id="option1-error" class="text-danger"></span>
                                                                            @if ($errors->has('option1'))
                                                                                <span class="text-danger">{{ $errors->first('option1') }}</span>
                                                                            @endif
                                                                        </div>
                                                                        <br><br>
                
                                                                        <p><label for="option2"><b style="color: black;">Option 2 :</b> </label></p>
                
                                                                        <div class="flex-style">
                                                                            <input type="radio" id="option2" name="answer" value="option2" {{ ($questionReports[0]->ansB=="1")? "checked" : "" }}  class="check-new">
                                                                            <input type="text" name="option2" id="option2" value="{{$questionReports[0]->optB}}" class="form-control" style="color: rgb(19, 46, 202);" placeholder="Enter option 2" required>
                                                                            <span id="option2-error" class="text-danger"></span>
                                                                            @if ($errors->has('option2'))
                                                                                <span class="text-danger">{{ $errors->first('option2') }}</span>
                                                                            @endif
                                                                        </div>
                                                                        <br><br>
                
                
                                                                        <p><label for="option3"><b style="color: black;">Option 3 :</b> </label></p>
                
                                                                        <div class="flex-style">
                                                                            <input type="radio" id="option3" name="answer" value="option3" {{ ($questionReports[0]->ansC=="1")? "checked" : "" }}  class="check-new">
                                                                            <input type="text" name="option3" id="option3" value="{{$questionReports[0]->optC}}" class="form-control" style="color: rgb(19, 46, 202);" placeholder="Enter option 3" required>
                                                                            <span id="option3-error" class="text-danger"></span>
                                                                            @if ($errors->has('option3'))
                                                                                <span class="text-danger">{{ $errors->first('option3') }}</span>
                                                                            @endif
                                                                        </div>
                                                                        <br><br>
                
                                                                        <p><label for="option4"><b style="color: black;">Option 4 :</b> </label></p>
                                                                        <div class="flex-style">
                                                                            <input type="radio" id="option4" name="answer" value="option4" {{ ($questionReports[0]->ansD=="1")? "checked" : "" }}  class="check-new">
                                                                            <input type="text" name="option4" id="option4" value="{{$questionReports[0]->optD}}" class="form-control" style="color: rgb(19, 46, 202);" placeholder="Enter option 4"  required>
                                                                            <span id="option4-error" class="text-danger"></span>
                                                                            @if ($errors->has('option4'))
                                                                                <span class="text-danger">{{ $errors->first('option4') }}</span>
                                                                            @endif
                                                                        </div>
                                                                        <br><br>
                                                                    </div>
                                                                   
                
                                                                    <input type="submit" id="savebutton" value="Update"  class="btn mb-2 btn-primary" >
                
                                                                </form>















                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Second card -->
                                                        <div class="col-xl-4 grid-margin stretch-card" >
                                                            <div id="cardContainer">
                                                                @foreach ($questionReports as $report)
                                                                    @php
                                                                        $userNames = explode(',', $report->reportedUsers);
                                                                        $reasons = explode('/', $report->reportedReasons);
                                                                        $statuses = explode(',', $report->reportedStatuses);
                                                                        $dates = explode(',', $report->reportedDates);
                                                                    @endphp
                                                                    @for ($i = 0; $i < count($userNames); $i++)
                                                                        <div class="card mb-3" style="min-height: 100px; @if($i >= 4) display: none; @endif">
                                                                            <div class="card-body d-flex justify-content-between">
                                                                                <div>
                                                                                    <h5 class="card-title mb-3 text-left">{{ $userNames[$i] }}</h5>
                                                                                    <h6 class="card-title mb-3" style="color: rgb(202, 19, 19);">{{ $reasons[$i] }}</h6>
                                                                                    <p class="card-title mb-3">{{ $dates[$i] }}</p>
                                                                                    
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    @if($statuses[$i] == 1)
                                                                                        <span class="btn btn-success btn-sm">✔</span>
                                                                                    @else
                                                                                        <span class="btn btn-danger btn-sm">X</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endfor
                                                                @endforeach
                                                            </div>
                                                            <button id="viewAllBtn" class="btn btn-primary" style="display: none;" align="left">View All Reporters</button>
                                                            <button id="hideBtn" class="btn btn-primary" style="display: none;">Hide</button>
                                                        </div>
                                                        
                                                       
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                const cards = document.querySelectorAll('#cardContainer .card');
                                                                const viewAllBtn = document.getElementById('viewAllBtn');
                                                                const hideBtn = document.getElementById('hideBtn');
                                                        
                                                               
                                                                for (let i = 4; i < cards.length; i++) {
                                                                    cards[i].style.display = 'none';
                                                                }
                                                        
                                                               
                                                                if (cards.length > 4) {
                                                                    viewAllBtn.style.display = 'block';
                                                                }
                                                        
                                                                
                                                                viewAllBtn.addEventListener('click', function () {
                                                                    cards.forEach(card => {
                                                                        card.style.display = 'block';
                                                                    });
                                                                   
                                                                    viewAllBtn.style.display = 'none';
                                                                    hideBtn.style.display = 'block';
                                                                });
                                                        
                                                               
                                                                hideBtn.addEventListener('click', function () {
                                                                    for (let i = 4; i < cards.length; i++) {
                                                                        cards[i].style.display = 'none';
                                                                    }
                                                                   
                                                                    viewAllBtn.style.display = 'block';
                                                                    hideBtn.style.display = 'none';
                                                                });
                                                            });
                                                        </script>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                    </div>
                                                </div>
                                           
                                        
                                      
                                        </div>
                                    </div>
                                </div> <!-- simple table -->



                                @endforeach
                                @endif




                            </div> <!-- end section -->
                        </div> <!-- .col-12 -->

                       







                    </div> <!-- .row -->
                </div> <!-- .container-fluid -->


            </div>
        </div>
    </main> <!-- main -->
</div>








@endsection
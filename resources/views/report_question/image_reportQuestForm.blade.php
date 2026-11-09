@extends('admin/adminMaster')

@section('adminpanel')



<div class="wrapper">
    <main role="main" class="main-content">
     

                <div class="container-fluid">
                    <div class="row justify-content-center">

                        <div class="col-12">
                            <h2 class="page-title">Image Based Exam Reported Question</h2>
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
                                                                    <form action="/update_the_image_reported_question" method="post">
                                                                        @csrf

                                                                    <input type="hidden" id="examMode" name="examMode" value="{{ $questionReports[0]->examMode }}" >
                                                                    <input type="hidden" id="questionId" name="questionId" value="{{ $questionReports[0]->questionId }}" >
                                                                    <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">




                                                                    <p><label for="question"><b style="color: black;">Question :</b> </label></p>
                                                                    <textarea name="questionIMAGE" id="questionIMAGE" placeholder="Enter question" required>{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $questionReports[0]->question) !!}</textarea>
                                                                    <span id="questionIMAGE-error" class="text-danger"></span>
                                                                    @if ($errors->has('questionIMAGE'))
                                                                    <span class="text-danger">{{ $errors->first('questionIMAGE') }}</span>
                                                                    @endif <br><br>

                                                                    <div class="col-12">

                                                                   <p><label for="option1image"><b style="color: black;">Option 1 :</b> </label></p>
                                                                    <div class="flex-style">
                                                                        <input type="radio" id="option1image" name="answerImage" value="option1image" {{ ($questionReports[0]->ansA=="1")? "checked" : "" }} class="check-new">
                                                                        <textarea name="option_1image" id="option_1image"  placeholder="Enter option 1" required>{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $questionReports[0]->optA) !!}</textarea>
                                                                    
                                                                        @if ($errors->has('option_1image'))
                                                                            <span class="text-danger">{{ $errors->first('option_1image') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <span id="option_1image-error" class="text-danger"></span>  
                                                                    
                                                                    <br><br>
                                                    


                                                                    <p><label for="option2image"><b style="color: black;">Option 2 :</b> </label></p>
                                                                    <div class="flex-style">
                                                                        <input type="radio" id="option2image" name="answerImage" value="option2image" {{ ($questionReports[0]->ansB=="1")? "checked" : "" }} class="check-new">
                                                                        <textarea name="option_2image" id="option_2image" placeholder="Enter option 2" required>{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $questionReports[0]->optB) !!}</textarea>
                                                                        
                                                                    
                                                                        @if ($errors->has('option_2image'))
                                                                            <span class="text-danger">{{ $errors->first('option_2image') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <span id="option_2image-error" class="text-danger"></span>

                                                                    <br><br>


                                                                   <p><label for="option3image"><b style="color: black;">Option 3 :</b> </label></p>
                                                                    <div class="flex-style">
                                                                        <input type="radio" id="option3image" name="answerImage" value="option3image" {{ ($questionReports[0]->ansC=="1")? "checked" : "" }} class="check-new">
                                                                        <textarea name="option_3image" id="option_3image"  placeholder="Enter option 3" required>{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $questionReports[0]->optC) !!}</textarea>
                                                                        @if ($errors->has('option_3image'))
                                                                            <span class="text-danger">{{ $errors->first('option_3image') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <span id="option_3image-error" class="text-danger"></span>

                                                                    <p><label for="option4image"><b style="color: black;">Option 4 :</b> </label></p>
                                                                    <div class="flex-style">
                                                                        <input type="radio" id="option4image" name="answerImage" value="option4image" {{ ($questionReports[0]->ansD=="1")? "checked" : "" }} class="check-new">
                                                                        <textarea name="option_4image" id="option_4image"  placeholder="Enter option 4" required>{!! str_replace('<img ', '<img style="width:100px; height:auto;" ', $questionReports[0]->optD) !!}</textarea>
                                                                       @if ($errors->has('option_4image'))
                                                                            <span class="text-danger">{{ $errors->first('option_4image') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <span id="option_4image-error" class="text-danger"></span>

                                                                    </div><br>
                                                                   
                
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
                                  //  console.log('Initializing CKEditor for:', selector);
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
                                       // console.log('CKEditor initialized for:', selector);
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




                    </div> <!-- .row -->
                </div> <!-- .container-fluid -->


            </div>
        </div>
    </main> <!-- main -->
</div>








@endsection
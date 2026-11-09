@extends('admin/adminMaster')

@section('adminpanel') 


<style>
                       
    .checkbox-right {
        text-align: right;
    }
    .checkbox-right .form-check {
        text-align: left;
        display: inline-block;
        margin-right: 20px; 
    }
    .small-input {
     width: 90px;  /* Adjust the width as needed */
    }

</style> 

 <style>
    .custom-btn-height {
            height: 30px;
    }
 </style>





    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-6">
                              <h2 class="page-title">Add Model Exam Percentage Wise</h2>
                            </div>
                            <div class="col-6 text-right">
                                <a href="/modelexams-Form" class="btn btn-primary custom-btn-height">create MODEL EXAM</a>
                            </div>
                        </div>

                         
                          
                          
                              
                          
                          

                        {{-- <form action="{{ url('addpercentModel_Exam') }}" id="mform" method="POST"> --}}
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            <div class="card shadow mb-4">
                                @if (session('success'))
                                    <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                @endif
                                @if (session('error'))
                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                @endif
    
                                <div class="row">
                                    <div class="col-md-6">               
                                    <div class="card-body">

                                       
                                                <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Exam Name</b></label>
                                                    <input type="text" id="percentModelexamName" name="percentModelexamName" value="{{old('percentModelexamName')}}"  placeholder="Enter exam name" class="form-control">
                                                    @if ($errors->has('percentModelexamName'))
                                                        <span class="text-danger">{{ $errors->first('percentModelexamName') }}</span>
                                                    @endif
                                                    <span id="percentModelexamName-error" class="text-danger"></span>
                                                </div>
                                           
                                                <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Exam Description</b></label>
                                                    <textarea  id="modelexamDesc" name="modelexamDesc" placeholder="Exam Descriptions" value="{{old('modelexamDesc')}}"   rows="4" cols="50" style="flex-wrap: wrap;" class="form-control" ></textarea>
                                                    @if ($errors->has('modelexamDesc'))
                                                        <span class="text-danger">{{ $errors->first('modelexamDesc') }}</span>
                                                    @endif
                                                    <span id="modelexamDesc-error" class="text-danger"></span>
                                                </div>
                                           

                                       
                                                <div class="form-group">
                                                    <label for="percModelexamQuest"><b style="color: black;">Number Of Questions:</b></label>
                                                    <input type="text" id="percModelexamQuest" name="percModelexamQuest"    placeholder="Enter No. Of Questions" class="form-control">
                                                    @if ($errors->has('percModelexamQuest'))
                                                        <span class="text-danger">{{ $errors->first('percModelexamQuest') }}</span>
                                                    @endif
                                                    <span id="percModelexamQuest-error" class="text-danger"></span>
                                                    {{-- value="{{ old('percModelexamQuest') }}" --}}
                                                </div>
                                           

                                      <div class="row">

                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-group mb-3">
                                                    <label for="percModelexampostiveMark"><b style="color: black;">Positive Mark:</b></label>
                                                    <input type="text" id="percModelexampostiveMark" name="percModelexampostiveMark" value="{{ old('percModelexampostiveMark') }}"  placeholder="Enter positive mark" class="form-control">
                                                    @if ($errors->has('percModelexampostiveMark'))
                                                        <span class="text-danger">{{ $errors->first('percModelexampostiveMark') }}</span>
                                                    @endif
                                                    <span id="percModelexampostiveMark-error" class="text-danger"></span>
                                                </div>
                                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-group">
                                                    <label for="percModelexamnegativeMark"><b style="color: black;">Negative Mark:</b></label>
                                                    <input type="text" id="percModelexamnegativeMark" name="percModelexamnegativeMark" value="{{ old('percModelexamnegativeMark') }}"  placeholder="Enter negative mark" class="form-control">
                                                    @if ($errors->has('percModelexamnegativeMark'))
                                                        <span class="text-danger">{{ $errors->first('percModelexamnegativeMark') }}</span>
                                                    @endif
                                                    <span id="percModelexamnegativeMark-error" class="text-danger"></span>
                                                </div>
                                            </div>

                                        @if(isset($module))
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Modules</b></label>
                                                    <select class="form-control" name="moduleId" id="moduleId" onchange="checkboxSubmoduleValidation();checkboxValidation();">
                                                     <option value=""  disabled selected>--Select modules--</option>
                                                       @foreach($module as $item)
                                                        <option  value="{{$item->mId}}" >{{$item->mName}}</option>
                                                       @endforeach
                                                    </select>
                                                            
                                             <span id="moduleId-error" class="text-danger"></span>           
                                            </div>
                                        @endif

                                                <!-- the main div closing the submodule -->
                                                <div id="mainsubmodulediv" style="display: none;"> 
                                           
                                                    <div class="form-group mb-6">
                                                        <label for="simpleinput"><b style="color: black;">Sub Modules</b></label>
                                                        <div style="font-weight: bold; text-align: right;">
                                                            {{-- <input type="button" class="btn btn-danger" style="background-color: rgb(240, 14, 14);" value="Preview of Selected Questions" onclick="return previewQuestions()"> --}}
                                                            <div class="form-group mb-4">
                                                                <div class="row">
                                                                    <div id="submodulesDiv1" style="display: none;">
                                                                        <!-- Display the submodules checkboxes -->
                                                                    </div>
                                                                    <div id="submodulesDiv2" style="display: none;">
                                                                        <!-- Display the submodules checkboxes -->
                                                                    </div>
                                                                </div>
                                                                <span id="submodule__Id-error" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                           
                                           </div>
                                    </div>
                                    <div class="col-md-6" id="ques" style="display: none;">
                                          <div id="myModal" >
                                            <br>
                                            <p id="modalContent" style="color: rgba(221, 14, 49, 0.945); font-weight: bold; ">QUESTIONS</p>
                                            <p id="modalCount" style="color: rgba(34, 27, 28, 0.945); font-weight: bold; ">Question Count</p>
                                            <ul id="modalList" style="color: rgb(8, 7, 8); font-weight: bold; "></ul>
                                          </div>
                                          <button type="submit" id="btn" onclick="return saveThatData();"  class="btn btn-primary">SAVE</button>
                                    </div>
                                </div>





                                















                        
                    </div>
                </div>
            </div>


            <div class="container-fluid">
                <div class="row justify-content-center">
        
                    <div class="col-12">
                        <h2 class="page-title">We Have Model Exams Organized By Percentage</h2>
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
                                                {{-- <th></th> --}}
                                                <th style="color: black;"><b>Exam Name</b></th>
                                                <th style="color: black;"><b>Description</b></th>
                                               
                                                <th style="color: black;"><b>No.Of.Question</b></th>
                                                <th style="color: black;"><b>Positive Mark</b></th>
                                                <th style="color: black;"><b>Negative Mark</b></th>
                                                <th style="color: black;"><b>ACTION</b></th>
        
        
        
                                                <!-- <th>Action</th> -->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($getPercModelexam))
                                                @php $i=1 @endphp
                                                @foreach ($getPercModelexam as $item)
                                                    <tr style="color: black;">
        
                                                        <td width="65"><b>{{$i++}} </b>
                                                        </td>
                                                       
                                                        <td width="100">{{ $item->meName }}</td>
                                                        <td width="80">{{ wordwrap($item->meDescription,20,"\n",TRUE) }}</td>
                                                       
                                                        <td width="70">{{ wordwrap($item->noOfQuestions,20,"\n",TRUE) }}</td>
                                                        <td width="80">{{ $item->positiveMark }}</td>
                                                        <td width="80">{{ $item->negativeMark }}</td>
                                                        
                                                        <td width="65">
                                                            <abbr style="text-decoration: none;"  title="Delete Exam"><a href="{{url('deletethePercentModel_exam/'.$item->meId)}}" style="text-decoration: none;" onclick="deleteItem(event, this)"><span style="color: red;font-size: 26px;"class="fa fa-trash-o"></span></a></abbr>
                                                            &nbsp;
                                                           
                                                            
                                                            {{-- <abbr style="text-decoration: none;"  title="view Exam Questions"><a href="{{url('view_exam_questions'.$item->meId)}}" style="text-decoration: none;" ><span style="color: rgb(9, 61, 110);font-size: 26px;"class="fa fa-eye"></span></a></abbr> --}}
                                                        
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
            </div> <!-- .container-fluid -->
        </main>
    </div>   




   



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function saveThatData(){
        var modalList = document.getElementById("modalList");
        
        if (modalList.children.length === 0) {
            alert("There are no questions to save.");
            return false; 
        }
        var listItems = modalList.querySelectorAll("li");
        var cqIdArray = [];

        listItems.forEach(function(listItem) {
            var cqId = listItem.getAttribute('data-cqId');
            var smId = listItem.getAttribute('data-smId');
            var ansA = listItem.getAttribute('data-ansA');
            var ansB = listItem.getAttribute('data-ansB');
            var ansC = listItem.getAttribute('data-ansC');
            var ansD = listItem.getAttribute('data-ansD');
            var questionText = listItem.textContent;

            var data = {
                cqId: cqId    
            };
            cqIdArray.push(data);
        });

       // console.log("Cqid:", cqIdArray);
        var perExamName = document.getElementById('percentModelexamName').value;
        var perDesc = document.getElementById('modelexamDesc').value;
        var nofq = document.getElementById('percModelexamQuest').value;
        var positive = document.getElementById('percModelexampostiveMark').value;
        var negative = document.getElementById('percModelexamnegativeMark').value;
        if (perExamName == "" || perExamName == null) {
            alert('Please enter exam name.');
            return;
        }
        if (perDesc == "" || perDesc == null) {
            alert('Please enter description.');
            return;
        }
        if (nofq == "" || nofq == null) {
            alert('Please Enter Number Of Questions.');
            return;
        }
        if (positive == "" || positive == null) {
            alert('Please enter positive mark.');
            return;
        }
        if (negative == "" || negative == null) {
            alert('Please enter negative mark.');
            return;
        }

    
               

        var modalCountElement = document.getElementById("modalCount");
        if (modalList && modalCountElement) {
           if(modalList.children.length == nofq ){
            Swal.fire({
            title: 'Are you sure to submit this exam?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {

            $.ajax({
                    url: "{{url('/savepercentage_wisemodelexam')}}",
                    type: "post",
                    data: {
                        cqIdArrays: cqIdArray,
                        examname: perExamName,
                        decription: perDesc,
                        numberQ: nofq,
                        positive: positive,
                        negative: negative,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        //console.log('success');
                        alert('Model Exam Added.');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                       // console.error("Error:", error);
                    
                        alert('Error occurred .');
                    }
                });
                }//confirm
            });

           }else{

            alert("The number of questions selected (" + nofq + ") doesn't match the expected count.");
            return false;
           }
        }
        

       

    }

   
    
    function modelistCount() {
            var modalList = document.getElementById("modalList");

            if (modalList) {
                var questions = modalList.querySelectorAll("li");
                var serialNumber = 1;

                questions.forEach(function(question) {
                    // Set the serial number text to red
                    var serialNumberSpan = question.querySelector('.serial-number');
                    if (!serialNumberSpan) {
                        serialNumberSpan = document.createElement('span');
                        serialNumberSpan.className = 'serial-number';
                        serialNumberSpan.style.color = 'red';
                        question.insertBefore(serialNumberSpan, question.firstChild);
                    }
                    serialNumberSpan.textContent = serialNumber + ". ";

                    // Check if the question already has a remove icon
                    var existingRemoveIcon = question.querySelector('.remove-icon');
                    if (!existingRemoveIcon) {
                        // Create and configure the remove icon
                        var removeIcon = document.createElement('span');
                        removeIcon.textContent = 'X';
                        removeIcon.style.cursor = 'pointer';
                        removeIcon.style.marginLeft = '20px';
                        removeIcon.style.color = 'red';
                        removeIcon.className = 'remove-icon';

                        // Add click event listener to remove the question from the modal
                        removeIcon.addEventListener('click', function() {
                            // Remove the list item from the modal
                            question.parentNode.removeChild(question);

                            // Update the question count and serial numbers after removal
                            modelistCount();
                        });

                        // Append remove icon to the list item
                        question.appendChild(removeIcon);
                    }

                    serialNumber++;
                });
            }

            var modalCountElement = document.getElementById("modalCount");
            if (modalList && modalCountElement) {
                modalCountElement.textContent = "Question Count: " + modalList.children.length;
            }
    }


    
</script>


<script>
    // Clear local storage data when the page loads
    window.onload = function() {
        localStorage.removeItem('submoduleData');
        localStorage.removeItem('new_submoduleData');
    };
</script>

<script>
    var shouldSubmitForm;

    function checkboxSubmoduleValidation() {
        shouldSubmitForm = true;
        clearErrorMessages();

        var selectedModules = getSelectedModuleIds();

        if (selectedModules.length > 0) {
            loadSubmodules(selectedModules.slice());
        } else {
            hideSubmodules();
        }
    }

    function checkboxValidation() {
        shouldSubmitForm = true;
        clearErrorMessages();

        var checkboxes = document.getElementById("moduleId");
        var submoduleCheckboxes = document.querySelectorAll('input[name="submoduleId[]"]:checked');

        if (checkboxes.value === "") {
            displayErrorMessage("moduleId-error", "Please select at least one module.");
            shouldSubmitForm = false;
        }

        if (submoduleCheckboxes.length === 0) {
            displayErrorMessage("submodule__Id-error", "Please select at least one submodule.");
            shouldSubmitForm = false;
        } else {
            validatePercentFields(submoduleCheckboxes);
        }

        if (shouldSubmitForm) {
            disableButtonAndSubmitForm();
        }
    }

    function clearErrorMessages() {
        document.getElementById("moduleId-error").innerHTML = "";
        document.getElementById("submodule__Id-error").innerHTML = "";
    }

    function getSelectedModuleIds() {
        var selectedModules = [];
        $("#moduleId option:selected").each(function () {
            selectedModules.push($(this).val());
        });
        return selectedModules;
    }

    function loadSubmodules(moduleIds) {
        var submoduleHTMLDiv1 = '';
        var submoduleHTMLDiv2 = '';

        var loadSubmodulesRecursive = function (moduleIds) {
            var allSubmodules = [];

            if (moduleIds.length === 0) {
                return;
            }

            var moduleId = moduleIds.shift();
            

            $.ajax({
                url: "{{url('/percentagewisemodelexamexmmodulecheck')}}",
                type: "POST",
                data: {
                    mId: moduleId,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result) {
                        allSubmodules = allSubmodules.concat(result);
                        $.each(allSubmodules, function (key, value) {
                            var storedData = localStorage.getItem('submoduleData');
                           // console.log('Local each stored data:', storedData);
                            var isStored = false; 
                            var storedPercentage = ''; 

                            if (storedData) {
                                var parsedData = JSON.parse(storedData);
                                var storedSubmodule = parsedData.find(function (item) {
                                    return item.submodule_id === value.smId.toString();
                                });
                                if (storedSubmodule) {
                                    isStored = true;
                                    storedPercentage = storedSubmodule.percentage;
                                }
                            }

                            if (key % 2 === 0) {
                                submoduleHTMLDiv1 += '<div class="form-check d-flex align-items-center">';
                                submoduleHTMLDiv1 += '<input type="checkbox" id="submoduleId_' + value.smId + '" value="' + value.smId + '" name="submoduleId[]" class="form-check-input" onclick="return checkboxValidation();"' + (isStored ? ' checked' : '') + '>';
                                submoduleHTMLDiv1 += '<label for="submoduleId_' + value.smId + '" class="form-check-label">' + value.smName + '</label>';
                                submoduleHTMLDiv1 += '<input type="number" id="percent_' + value.smId + '" name="percent[]" value="' + storedPercentage + '" style="margin-left: 6px;width: 80px;" placeholder="percent" class="form-control small-input" onkeyup="checkboxValidation(); previewQuestions(' + value.smId + ');">';
                                submoduleHTMLDiv1 += '</div>';
                            } else {
                                submoduleHTMLDiv2 += '<div class="form-check d-flex align-items-center">';
                                submoduleHTMLDiv2 += '<input type="checkbox" id="submoduleId_' + value.smId + '" value="' + value.smId + '" name="submoduleId[]" class="form-check-input" onclick="return checkboxValidation();"' + (isStored ? ' checked' : '') + '>';
                                submoduleHTMLDiv2 += '<label for="submoduleId_' + value.smId + '" class="form-check-label">' + value.smName + '</label>';
                                submoduleHTMLDiv2 += '<input type="number" id="percent_' + value.smId + '" name="percent[]" value="' + storedPercentage + '" style="margin-left: 6px;width: 80px;" placeholder="percent" class="form-control small-input" onkeyup="checkboxValidation(); previewQuestions(' + value.smId + ');">';
                                submoduleHTMLDiv2 += '</div>';
                            }
                        });
                    }
                },

                complete: function () {
                    if (moduleIds.length === 0) {
                        $('#submodulesDiv1').html(submoduleHTMLDiv1);
                        $('#submodulesDiv2').html(submoduleHTMLDiv2);
                        $('#submodulesDiv1').show();
                        $('#submodulesDiv2').show();
                        document.getElementById("mainsubmodulediv").style.display = 'block';
                    }
                }
            });
        };

        loadSubmodulesRecursive(moduleIds);
    }

    function hideSubmodules() {
        $('#submodulesDiv1').hide();
        $('#submodulesDiv2').hide();
        document.getElementById("mainsubmodulediv").style.display = 'none';
    }

    function displayErrorMessage(elementId, message) {
        document.getElementById(elementId).innerHTML = message;
        shouldSubmitForm = false;
    }

  

    
    function validatePercentFields(submoduleCheckboxes) {
   
        var existingData = localStorage.getItem('submoduleData');
        var data = [];

    
        if (existingData) {
            data = JSON.parse(existingData);
        }

        for (var i = 0; i < submoduleCheckboxes.length; i++) {
            var checkbox = submoduleCheckboxes[i];
            var submoduleIndex = checkbox.value;
            var percentInput = document.getElementById("percent_" + submoduleIndex);
            var percentageValue = percentInput.value.trim(); // Retrieve the percentage value

        // console.log('hai: the percentage is:', percentageValue);

            if (percentageValue === "") {
                displayErrorMessage("submodule__Id-error", "Please enter a value for the percent field of selected submodule");
                $("#btn").attr("disabled", true);
                return;
            }

        
            var existingSubmodule = data.find(function(item) {
                return item.submodule_id === submoduleIndex;
            });

            if (existingSubmodule) {
            
                existingSubmodule.percentage = percentageValue;
            } else {
            
                data.push({
                    submodule_id: submoduleIndex,
                    percentage: percentageValue
                });
            }
        }

       
        localStorage.setItem('submoduleData', JSON.stringify(data));

        var newData = [];
      

        for (var i = 0; i < submoduleCheckboxes.length; i++) {
            var check_box = submoduleCheckboxes[i];
            var submodule_Index = check_box.value;
           // console.log('submodule_Index:',submodule_Index);
            var percent_Input = document.getElementById("percent_" + submodule_Index);
            var percentage_Value = percent_Input.value.trim(); 

            if (percentage_Value === "") {
                displayErrorMessage("submodule__Id-error", "Please enter a value for the percent field of selected submodule");
                $("#btn").attr("disabled", true);
                return;
            }

            
            var existing_Submodule = newData.find(function(item) {
                //console.log('item:',item.submodule_id);
               // item.submodule_id === submodule_Index;
                newData.pop(function(item){
                    item.submodule_id === submodule_Index && item.percentage === percentage_Value;
                });
                 
            });

            
           
            // var existing_Submodule = newData.find(function(item) {
            //     // return item.submodule_id === submodule_Index && item.percentage === percentage_Value;
            //     return item.submodule_id = submodule_Index;
            // });


            if (!existing_Submodule) {
                newData.push({
                    submodule_id: submodule_Index,
                    percentage: percentage_Value
                });
            }
        }

        localStorage.setItem('new_submoduleData', JSON.stringify(newData));
      //  console.log('newData:',newData);

        

        disableButtonAndSubmitForm();
   }


    
    function disableButtonAndSubmitForm() {
        $("#btn").attr("disabled", false);
    }
</script>




<script>
    function previewQuestions(smId) {
        var perExamName = document.getElementById('percentModelexamName').value;
        var perDesc = document.getElementById('modelexamDesc').value;
        var nofq = document.getElementById('percModelexamQuest').value;
        var positive = document.getElementById('percModelexampostiveMark').value;
        var negative = document.getElementById('percModelexamnegativeMark').value;

       
    
        if (nofq == "" || nofq == null) {
            alert('Please Enter Number Of Questions.');
            return;
        }
        
        var moduleIdArray = [];
        $('input[name="moduleId[]"]:checked').each(function() {
            moduleIdArray.push($(this).val());
        });
    
        var newData = [];
        var newstoredData = localStorage.getItem('new_submoduleData');
        var submodule_IdArray = [];
        var percentage_Array = [];

        // Update submodule_IdArray and percentage_Array with data from newData
        if (newstoredData) {
            var newsubmoduleData = JSON.parse(newstoredData);
            newsubmoduleData.forEach(function(item) {
                var submodule_id = item.submodule_id;
                var percentage = item.percentage;

                submodule_IdArray.push(submodule_id);
                percentage_Array.push(percentage);
            });
        }

        // Update submodule_IdArray and percentage_Array with data from newData
        newData.forEach(function(item) {
            var submodule_id = item.submodule_id;
            var percentage = item.percentage;

            // Check if submodule_id already exists in submodule_IdArray
            var index = submodule_IdArray.indexOf(submodule_id);

            if (index !== -1) {
                // If exists, update the percentage
                percentage_Array[index] = percentage;
            } else {
                // If not exists, push new data
                submodule_IdArray.push(submodule_id);
                percentage_Array.push(percentage);
            }
        });



    
        
        if (submodule_IdArray.length === 0 || percentage_Array.length === 0) {
            alert('Please select at least one submodule and its corresponding percentage.');
            return; 
        }
    
       
        var myModal = document.getElementById('myModal');
        var lastSerialNumber = 0;
        var displayedQuestions = [];

        if (myModal) {
            myModal.style.display = 'block';

          
            
            var displayedSubmodules = []; // Keep track of displayed submodules
         //   console.log('submodule_IdArray:',submodule_IdArray);
          //  console.log('percentage_Array:',percentage_Array);

            var percentInput = document.getElementById("percent_" + smId);
            var percentage = percentInput.value;
            if (!percentage || percentage.trim() === "") {
            
                percentage = 0;
            }
          //  console.log("Updated percentage for submodule ID " + smId + ": " + percentage);
            if(percentage == 0){

               // console.log('hai');
                var questionsToRemove = modalList.querySelectorAll(`li[data-smId="${smId}"]`);
                questionsToRemove.forEach(function(questionToRemove) {
                    modalList.removeChild(questionToRemove);
                });
                modelistCount();

            }else{
              

            $.ajax({
                url: "{{url('/getSubmoduleIdandPercentagematchQuestion')}}",
                type: "get",
                data: {
                    submoduleId: smId,
                    percent: percentage,
                    TotalQuestion: nofq, // Pass the initially specified number of questions
                    _token: '{{csrf_token()}}'
                },
                success: function(response) {
                    if (response && Array.isArray(response) && response.length > 0) {
                      // console.log('res:',response);
                        displayedQuestions.forEach(function(question) {
                            var listItemToRemove = modalList.querySelector('[data-cqId="' + question.smId + '"]');
                            if (listItemToRemove) {
                                modalList.removeChild(listItemToRemove); // Remove corresponding list item from the modal
                            }
                        });
                        displayedQuestions = [];

                        // Filter out questions for already displayed submodules
                        var newQuestionsToShow = response.filter(function(item) {
                            return !displayedSubmodules.includes(item.smId);
                        });

                        // Ensure that only the specified number of questions are displayed
                        var questionsToShow = newQuestionsToShow.slice(0, nofq);
                        

                       

                        questionsToShow.forEach(function(item, index) {
                            var listItem = document.createElement('li');
                           
                            listItem.setAttribute('data-cqId', item.cqId); 
                            listItem.setAttribute('data-smId', item.smId); 
                            listItem.setAttribute('data-ansA', item.ansA); 
                            listItem.setAttribute('data-ansB', item.ansB); 
                            listItem.setAttribute('data-ansC', item.ansC); 
                            listItem.setAttribute('data-ansD', item.ansD); 
                            listItem.textContent = item.question;


                            // Create and configure the remove icon
                           

                       
                            modalList.appendChild(listItem);

                            displayedQuestions.push(item);
                            displayedSubmodules.push(item.smId);
                           
                           
                           
                        });

                        modelistCount();

                        document.getElementById('ques').style.display = 'block';
                        
                       // console.log('modalList:', modalList);
                        //console.log('questionsToShow:', questionsToShow);
                       
                    } else {
                        alert('There are no questions.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                   
                    alert('Error occurred while fetching questions.');
                }
            });
              
         }
         
        } else {
            console.error("Modal element not found.");
        }

    }
</script>

    
    













@endsection








    


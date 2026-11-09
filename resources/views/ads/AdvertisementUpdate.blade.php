@extends('admin/adminMaster')

@section('adminpanel')



    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Update Advertisement</h2>
                        @foreach($advertisements as $data)
                    
 <!-- ADVERTISEMENT UPDATE FORM -->

                        <form action="{{ url('AdvertisementUpdate/'.$data->adId) }}" id="ads" enctype='multipart/form-data'  method="POST">
                            @csrf
                            
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            
                            
                            <div class="card shadow mb-4">
                                @if (session('success'))
                                    <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                @endif
                                @if (session('error'))
                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
 
<!-- HEADING FORM FIELD -->

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Heading</b></label>
                                                <input type="text" id="heading" name="heading" placeholder="Enter The Heading" value="{{$data->heading}}" class="form-control"  onkeyup="return headingOnKeyupValidation()" >
                                               
                                                <span id="name-error" class="text-danger"></span>

                                            </div>

<!-- CONTENT TYPE FORM FIELD -->

                                            <div class="form-group mb-3">
                                                <label for="example-select"><b style="color: black;">Content Type</label>
                                                <select class="form-control"  name="contentType"  id="contentType" onChange="return myFunction()" >

                                                @foreach($advertisements as $data)
                                                <option selected value="{{ $data->contentType }}" disabled>------Select------</option>
                                                <option value="{{ $data->contentType }}" {{ $data->contentType == $data->contentType ? 'selected' : '' }}>
                                                        @if($data->contentType==0)
                                                            
                                                            Image

                                                            @else

                                                            Video

                                                        @endif
                                                    
                                                </option>
                                                @endforeach
                                                
                                                @if($data->contentType==0)
                                                        <option value="1">Video</option>
                                                
                                                           
                                                        @else

                                                        <option value="0">Image</option>

                                                        @endif
                                                
                                                </select>
                                            </div>

<!-- VIDEO LINK FORM FIELD -->

                                                @if($data->videos==0)

                                                    <div id="addvideos"  style="display: none">
                                                
                                                        <div class="form-group mb-3">
                                                                <label for="simpleinput"><b style="color: black;">Video Link</b></label>
                                                                <input type="text" id="video"  name="videos" placeholder="Enter the video link" value="{{$data->videos}}"  class="form-control"  onkeyup="return videoOnKeyupValidation()" >
                                                            
                                                                <span id="vname-error" class="text-danger"></span>

                                                        </div> 
                                                    </div>

                                                @else

                                                    <div id="addvideos"  style="display: block">
                                                
                                                        <div class="form-group mb-3">
                                                            <label for="simpleinput"><b style="color: black;">Video</b></label>
                                                            <input type="text" id="video"  name="videos" placeholder="Enter the video link" value="{{$data->videos}}"  class="form-control"  onkeyup="return videoOnKeyupValidation()" >
                                                            
                                                            <span id="vname-error" class="text-danger"></span>

                                                        </div>
                                                    </div>
                                                @endif

<!-- ADD TYPE FORM FIELD -->


                                                @if($data->addType==1)

                                                    <div id="addimage"  style="display: none">
                                                        
                                                        <div class="col-md-3 mb-3">
                                                            <label for="validationCustom04">Add Type</label>
                                                            <select class="custom-select" name="addType" value="{{$data->addType}}" id="id_addtype"  onChange="return validateaddtype()">
                                                            <option value="{{ $data->addType }}" {{ $data->addType == $data->addType ? 'selected' : '' }}>
                                                                @if($data->addType==0)

                                                                    Top
                                                                        
                                                                @else

                                                                    Bottom

                                                                @endif
                                                            </option>
                                                                        
                                                                @if($data->addType==0)

                                                                    <option value="1">Bottom</option>
                                                                        
                                                                @else

                                                                    <option value="0">Top</option>

                                                                @endif 
                                                            
                                                            </select>

                                                                <div class="invalid-feedback"> Please select a valid type </div>

                                                            </div>
                                                        </div>

                                                @else
                                                            
                                                    <div id="addimage"  style="display: block">
                                                        <div class="col-md-3 mb-3">
                                                            <label for="validationCustom04">Add Type</label>
                                                            <select class="custom-select" name="addType" value="{{$data->addType}}" id="id_addtype"  onChange="return validateaddtype()">
                                                            <option value="{{ $data->addType }}" {{ $data->addType == $data->addType ? 'selected' : '' }}>
                                                                @if($data->addType==0)

                                                                    Top
                                                                        
                                                                @else

                                                                    Bottom

                                                                @endif

                                                            </option>

                                                                @if($data->addType==0)

                                                                    <option value="1">Bottom</option>
                                                                        
                                                                @else

                                                                    <option value="0">Top</option>

                                                                @endif            
                                                            
                                                            
                                                            </select>
                                                            <div class="invalid-feedback"> Please select a valid type </div>
                                                        </div>
                                                    </div>

                                                @endif
                                        
                                        
                                            <div id="buttomsubmit">
                                                <button type="save" id='bttnsubmit' value="save" class="btn btn-primary" onclick="return ValidationOnclick();">SAVE</button>
                                            </div>
                                      
                                        </div>
<!-- IMAGE FILE UPLOAD FORM -->

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                        <label for="customFile"><b style="color: black;">Image</label>
                                                        
                                                        <div class="custom-file">
                                                        @if($data->image==0)
                                                        
                                                        @else
                                                        <img src="/public/assets/ad_images/{{ $data->image}}"  height="100"><div><br></div>       
                                                        @endif
                                                        
                                                        <!-- <input type="text" name="image" class="form-control" placeholder="" value="{{ $data->image}}"> -->
                                                        <input type="file" name="image" value="{{ $data->image}}" id="customFile" class="form-control-file" onchange="fileValidation()">
                                                        <label for="example-fileinput">Choose an Image</label>
                                                        <span style="color: grey">Accepted image format is jpg,png or jpeg.</span>
                                                        <span id="file-error" class="text-danger"></span>
                                                        
                                                        </div>
                                            </div>
                                            @endforeach
                                        </div> <!-- /.col -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->
                    <br>
                </div>
            </div>
        </main> <!-- main -->
    </div>


<!-- SCRIPT FOR BUTTON ONCLICK VALIDATION -->

    <script>
        function ValidationOnclick()
    {
        
        let planName = document.getElementById('customFile').value;
        
    if(contentType == '0')   
    {
        if (planName == null || planName === ""){
            document.getElementById("file-error").innerHTML = "Image is required";      
            return false;
        }
        else {
          document.getElementById("file-error").innerHTML = "";
        }

            
        return true;
    } 
        

    }
    </script>



    
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>




<!-- SCRIPT FOR EDIT SUBSCRIPTION -->

    
 <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this advertisement?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms the deletion, redirect to the delete URL
                    window.location.href = element.href;
                }
            });
        }
    </script>



<!-- SCRIPT FOR ADD TYPE VALIDATION -->



<script>
    function validateaddtype(){
       
       var addtype= document.getElementById("id_addtype").value;
       console.log(addtype);
       if(addtype){
        document.getElementById("buttomsubmit").style.display = 'block';
       }else{
        alert("please selecrt addtype");
       }
    }
    
</script>




<!-- SCRIPT FOR FILE VALIDATION -->

    <script>
        function fileValidation()
        {
    var fileInput = document.getElementById('customFile').value;
    //console.log(fileInput);
    
   
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(fileInput)){
        alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
        }
    }
    </script>



<!-- SCRIPT FOR FORM VALIDATION -->

    <script>
        function myFunction() {

            var contentType=document.getElementById('contentType').value;
            console.log(contentType);
           
            if(contentType==0){
                document.getElementById("addvideos").style.display = 'none';
                document.getElementById("addimage").style.display = 'block';
                //document.getElementById("buttomsubmit").style.display = 'none';
                
            }else{
                document.getElementById("addvideos").style.display = 'block';
                document.getElementById("addimage").style.display = 'none';
                //document.getElementById("buttomsubmit").style.display = 'block';
                
                
            }

            

        }

    </script>


<!-- SCRIPT FOR HEADING VALIDATION -->

<script>
        function headingOnKeyupValidation()
        {
            $(document).ready(function () {

                heading = document.getElementById('heading').value;
            let length2 = heading.length;

            console.log(heading);
            

            if (heading == null||heading==""){
                document.getElementById("name-error").innerHTML = "This field is required.";
                return false;
            }
            else if(length2<3){
                document.getElementById("name-error").innerHTML = "At least 3 characters.";
                return false;
            }else if(length2>1000) {
                document.getElementById("name-error").innerHTML = "Only 1000 characters.";
                return false;
            }else{
                document.getElementById("name-error").innerHTML = "";

            }
            

            $("#save").on("click", function() {
                $(this).attr("disabled", "disabled");

                //this method contains your logic
                $(this).html("Saving...");

                $("#ads").submit()


            });
        });

        }
    </script>


<!-- SCRIPT FOR VIDEO LINK VALIDATION -->


<script>
        function videoOnKeyupValidation()
        {
            $(document).ready(function () {

                heading = document.getElementById('video').value;
            let length2 = heading.length;

            console.log(heading);
            

            if (heading == null||heading==""){
                document.getElementById("vname-error").innerHTML = "This field is required.";
                return false;
            }
            else if(length2<3){
                document.getElementById("vname-error").innerHTML = "At least 3 characters.";
                return false;
            }else if(length2>1000) {
                document.getElementById("vname-error").innerHTML = "Only 1000 characters.";
                return false;
            }else{
                document.getElementById("vname-error").innerHTML = "";

            }
            

            $("#save").on("click", function() {
                $(this).attr("disabled", "disabled");

                //this method contains your logic
                $(this).html("Saving...");

                $("#ads").submit()


            });
        });

        }
    </script>


@endsection
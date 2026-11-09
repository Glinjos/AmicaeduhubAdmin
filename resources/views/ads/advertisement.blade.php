@extends('admin/adminMaster')

@section('adminpanel')





    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Advertisement</h2>

                        <form action="/addadvertisements" id="ads" enctype='multipart/form-data'  method="POST">
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
                                            
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Heading</b></label>
                                                <input type="text" id="heading" name="heading" placeholder="Enter The Heading"  class="form-control"  onkeyup="return headingOnKeyupValidation()" >
                                               
                                                <span id="name-error" class="text-danger"></span>

                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="example-select"><b style="color: black;">Content Type</label>
                                                <select class="form-control" name="contentType" id="contentType" onChange="return myFunction()" >
                                                <option selected disabled>------Select------</option>
                                                <option value="0">Image</option>
                                                <option value="1">Video</option>
                                                </select>
                                            </div>
                                            
                                            </div>
 


                                            
                                            <div class="col-md-6">

                                            


                                 <div id="addvideos"  style="display: none">


                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Video</b></label>
                                                <input type="text" id="video"  name="videos" placeholder="Enter the video link"  class="form-control"  onkeyup="return videoOnKeyupValidation(),toggleButton(this,'bttnsubmit');" >
                                               
                                                <span id="vname-error" class="text-danger"></span>

                                            </div>
                                            

                                            

                                    </div>
                                    
                                      

                                            

                                        <div class="form-group mb-3">
                                                <label for="customFile"><b style="color: black;">Image</label>
                                                <div class="custom-file">
                                                <input type="file" name="image"  id="customFile" class="form-control-file" onchange="fileValidation()">
                                                <label for="example-fileinput">Choose an Image</label>
                                                <span style="color: grey">Accepted image format is jpg,png or jpeg.</span><br>
                                                <span id="file-error" class="text-danger"></span>
                                                
                                                
                                                </div>
                                        </div>

                                            
                                        <div id="addimage"  style="display: none">


                                            <div>
                                            <label for="validationCustom04">Add Type</label>
                                            <select class="custom-select" name="addType" id="id_addtype"  onChange="return validateaddtype(),toggleButton(this,'bttnsubmit');">
                                            <option selected disabled value="">Choose...</option>
                                            <option value="0">Top</option>
                                            <option value="1">Bottom</option>
                                            </select>
                                            <div class="invalid-feedback"> Please select a valid type </div>
                                            </div>



                                        </div>

                                    <div id="buttomsubmit">
                                        <button type="save" disabled='disabled' id='bttnsubmit' value="save" class="btn btn-primary" onclick="return ValidationOnclick();">SAVE</button>
                                    </div>
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->
                    <br>

                    


                </div>



                &nbsp;&nbsp;&nbsp;
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <h2 class="mb-2 page-title">Advertisements</h2>
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
                                                        <th></th>
                                                        <th style="color: black;"><b>HEADING</b></th>
                                                        <th style="color: black;"><b>CONTENT TYPE</b></th>
                                                        <th style="color: black;"><b>IMAGE</b></th>
                                                        <th style="color: black;"><b>VIDEO</b></th>
                                                        <th style="color: black;"><b>ADD TYPE</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>

                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($select))
                                                    @php $i=1 @endphp
                                                    @foreach ($select as $item)
                                                        <tr style="color: black;">

                                                            <td width="65"><b>{{$i++}}</b></td>
                                                            <td width="20"> @if( $item->isAvail==0)
                                                                    <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                                @if( $item->isAvail==1)
                                                                    <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                            </td>
                                                            
                                                            <td width="150">{{ $item->heading}}</td>
                                                            
                                                            @if($item->contentType!=0)
                                                            <td width="150">Video</td>
                                                           
                                                            @else
                                                            <td width="150">Image</td>
                                                            @endif


                                                            <!-- src="http://127.0.0.1:8000/storage/assets/ad_images/{{ $item->image}}" -->
                                                            @if($item->image==0)
                                                            <td width="250"></td>
                                                           
                                                            @else
                                                            <td width="250"><img src="/public/assets/ad_images/{{ $item->image}}"  height="50"></td>
                                                            @endif
                                                           
                                                            
                                                            @if($item->videos==0)
                                                            <td width="150"></td>
                                                           
                                                            @else
                                                            <td width="250">{{$item->videos}}</td>
                                                            @endif

                                                            @if($item->addType==0)
                                                            <td width="250">Top</td>
                                                           
                                                            @else
                                                            <td width="250">Bottom</td>
                                                            @endif
                                                            
                                                            
                                                            

                                                            <td width="250">
                                                            

                                                                <abbr style="text-decoration: none;" title="Edit Advertisement"><a href="{{url('updateAdvertisement'.$item->adId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                @if( $item->isAvail==0)
                                                                    <abbr style="text-decoration: none;"  title="Deactivate Advertisement"><a href="{{url('advertisementInactive/'.$item->adId)}}" style="text-decoration: none;" onclick="deActiveItem(event, this)"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                @endif
                                                                @if( $item->isAvail==1)
                                                                    <abbr style="text-decoration: none;" title="Activate Advertisement"><a href="{{url('advertisementActive/'.$item->adId)}}" style="text-decoration: none;" onclick="ActiveItem(event, this)"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                @endif
                                                                
                                                                
                                                                <abbr style="text-decoration: none;"  title="Delete Advertisement"><a href="{{url('advertisementDelete/'.$item->adId)}}" style="text-decoration: none;" onclick="deleteItem(event, this)"><span style="color: red;font-size: 26px;"class="fa fa-trash-o"></span></a></abbr>
                                                                
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
                </div>
            </div>
        </main> <!-- main -->
    </div>










    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    
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


    <script>
                                                    function deleteItem(event, element) {
                                                        event.preventDefault(); // prevent the default link behavior

                                                        // Show the SweetAlert confirmation dialog
                                                        Swal.fire({
                                                            title: 'Are you sure to delete this advertisement?',
                                                            text: '',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Confirm',
                                                            cancelButtonText: 'Cancel',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                window.location.href = element.href;
                                                            }
                                                        });
                                                    }
    </script>

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

    <script>
        function toggleButton(ref,bttnID)
        {
        document.getElementById(bttnID).disabled= ((ref.value !== ref.defaultValue) ? false : true);
        }
    </script>



    <script>
        function fileValidation()
        {
            var fileInput = document.getElementById('customFile').value;
            //console.log(fileInput);
    
   
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if(!allowedExtensions.exec(fileInput))
            {
                alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
                fileInput.value = '';
                return false;
            }
        }
    </script>





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

    <script>
        function deActiveItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to deactivate this advertisement?',
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
    <script>
        function ActiveItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to activate this advertisement?',
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
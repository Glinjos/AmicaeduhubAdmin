@extends('admin/adminMaster')

@section('adminpanel')
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">SENT NOTIFICATION</h2>

                        <form action="{{ url('store_notify_datas') }}" enctype='multipart/form-data' id="mform" method="POST">
                            @csrf
                            <div class="card shadow mb-4">
                                @if (session('success'))
                                    <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                @endif
                                @if (session('error'))
                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">TITLE</b><span style="color: red;">*</span></label>
                                                <input type="text" id="notifyTitle" name="notifyTitle" value="{{old('notifyTitle')}}" placeholder="Enter your title" onkeyup="return titvalidation();" class="form-control" >
                                                @if ($errors->has('notifyTitle'))
                                                    <span class="text-danger">{{ $errors->first('notifyTitle') }}</span>
                                                @endif
                                                <span id="notifyTitle-error" class="text-danger"></span>

                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">DESCRIPTION</b><span style="color: red;">*</span></label>
                                                <textarea  id="notifyDescription"  name="notifyDescription" value="{{old('notifyDescription')}}" placeholder="Enter your description" onkeyup="return descvalidation();" class="form-control" ></textarea>
                                                @if ($errors->has('notifyDescription'))
                                                    <span class="text-danger">{{ $errors->first('notifyDescription') }}</span>
                                                @endif
                                                <span id="notifyDescription-error" class="text-danger"></span>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">IMAGE</b></label>
                                                <input type="file" id="notifyImage" name="notifyImage" value="{{old('notifyImage')}}" class="form-control"  onchange="return fileValidation();" >
                                                @if ($errors->has('notifyImage'))
                                                    <span class="text-danger">{{ $errors->first('notifyImage') }}</span>
                                                @endif
                                               

                                            </div>
                                            <br>
                                           
                                            <button type="submit" align="center" id="btn" onclick="return mainValidation();"  class="btn btn-primary" form="mform">SEND</button>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <script src="js/app.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag()
        {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>

    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->
    <!---------------FORM JAVASCRIPT VALIDATION FOR Module Code-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

      <script>
        function fileValidation()
        {
            var fileInput = document.getElementById('notifyImage').value;
            //console.log(fileInput);
    
   
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            if(!allowedExtensions.exec(fileInput))
            {
                alert('Please upload file having extensions .jpeg/.jpg/.png only.');
                document.getElementById('notifyImage').value = '';
                return false;
            }
        }
    </script>









    <script>
        function mainValidation(){
            var title       = document.getElementById('notifyTitle').value;
            var description = document.getElementById('notifyDescription').value;
            

            if(title == "" || title == null){
              //  alert(title);
                document.getElementById('notifyTitle-error').innerHTML = "This field is required.";
                return false;
            }
            if(description == "" || description == null){
                document.getElementById('notifyDescription-error').innerHTML = "This field is required.";
                return false;
            }
            else{
                document.getElementById("notifyTitle-error").innerHTML = "";
                document.getElementById("notifyDescription-error").innerHTML = "";
            }
        }

        // ONKEY UP FUNCTIONS
        function titvalidation(){
            var title       = document.getElementById('notifyTitle').value;
           
            if(title == "" || title == null){
             
                document.getElementById('notifyTitle-error').innerHTML = "This field is required.";
                return false;
            }
           
            else{
                document.getElementById("notifyTitle-error").innerHTML = "";
               
            }
        }

        function descvalidation(){
           
            var description = document.getElementById('notifyDescription').value;
            
            if(description == "" || description == null){
                document.getElementById('notifyDescription-error').innerHTML = "This field is required.";
                return false;
            }
            else{
               
                document.getElementById("notifyDescription-error").innerHTML = "";
            }
        }
    </script>
   

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
   

@endsection
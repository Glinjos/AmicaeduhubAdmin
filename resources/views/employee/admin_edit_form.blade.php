@extends('admin/adminMaster')

@section('adminpanel')



    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Update Admin</h2>
                        @foreach($emloyee_detail as $data)
                    
                        
                        <form action="{{ url('admin_details_update/'.$data->id) }}" id="employee_id"   method="POST">
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
                                        <div class="col-md-6">
                                            
                                           
                                       

                                       
                                            
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Name</b></label>
                                                <input type="text" id="name" name="name" placeholder="Enter name" value="{{$data->name}}" class="form-control"  onkeyup="return Validation_name()" >
                                               
                                                <span id="name-error" class="text-danger"></span>

                                            </div>


                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">email</b></label>
                                                <input type="text" id="admin_email" name="admin_email" placeholder="Enter email" value="{{$data->email}}" class="form-control"  onkeyup="return Validation_admin_email()" >
                                               
                                                <span id="admin_email-error" class="text-danger"></span>

                                            </div>


                                            
                                                <input type="hidden" id="name" name="admin_old_password"  value="{{$data->password}}" class="form-control">
                                               
                                              

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">password</b></label>
                                                <input type="password" id="admin_password_1" name="admin_new_password" placeholder="Enter admin password" value="{{$data->password}}" class="form-control" onkeyup="return validation_admin_password()" >
                                               
                                                <span id="admin_password_1-error" class="text-danger"></span>

                                            </div>
                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">confirm password</b></label>
                                                <input type="password" id="admin_password_2" name="admin_new_password" placeholder="Enter admin password" value="{{$data->password}}" class="form-control"  onkeyup="return validation_admin_password()" >
                                               
                                                <span id="admin_password_2-error" class="text-danger"></span>

                                            </div>
 
                                        @endforeach
                                        
                                    <div id="buttomsubmit">
                                        <button type="submit"  id='bttnsubmit' disabled='disabled' value="save" class="btn btn-primary">SAVE</button>
                                    </div>
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


    <script>
         window.onload = function() {
                // alert('ai');
                Validation_name();
                Validation_admin_email();
                validation_admin_password();
                };

        function Validation_name()
                    {
                        name = document.getElementById('name').value;
                        if (name == null||name==""){
                            document.getElementById("name-error").innerHTML = "This field is required.";
                            disableButton();
                            return false;
                        }else{
                            document.getElementById("name-error").innerHTML = "";
                            enableButton();
                        }
                    }
    
        function Validation_admin_email()
        {
            email = document.getElementById('admin_email').value;
            if (email == null||email==""){
                document.getElementById("admin_email-error").innerHTML = "This field is required.";
                disableButton();
                return false;
            }else{
                document.getElementById("admin_email-error").innerHTML = "";
                enableButton();
            }
        
        }
   
        function validation_admin_password(){
            password_1 = document.getElementById('admin_password_1').value;
            password_2 = document.getElementById('admin_password_2').value;
                
            
            if(password_1==null || password_1==""){
                document.getElementById("admin_password_1-error").innerHTML = "This field is required.";
                disableButton();
                return false;
            }else if(password_2==null || password_2==""){
                document.getElementById("admin_password_2-error").innerHTML = "This field is required.";
                disableButton();
                return false;

            }else if(password_1 != password_2){
                document.getElementById("admin_password_2-error").innerHTML = "confirm password doesn't match";
                disableButton();
                return false;
            }else{
                enableButton();
                Validation_name();
                Validation_admin_email();
                document.getElementById("admin_password_1-error").innerHTML = "";
                document.getElementById("admin_password_2-error").innerHTML = "";
            }
        }
    
        function enableButton() {
            const myButton = document.getElementById('bttnsubmit');
                myButton.disabled = false;
                }
        function disableButton() {
            const myButton = document.getElementById('bttnsubmit');
                myButton.disabled = true;
                }
    </script>









    
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    
 
@endsection
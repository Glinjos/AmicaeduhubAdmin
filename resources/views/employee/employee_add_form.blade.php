@extends('admin/adminMaster')

@section('adminpanel')





    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Emplyee</h2>

                        <form action="{{url('/employee_add')}}" id="ads" enctype='multipart/form-data'  method="POST">
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
                                                <input type="text" id="name" name="name" placeholder="Enter employee name"  class="form-control"  onkeyup="return Validation_name()" >
                                               
                                                <span id="name-error" class="text-danger"></span>

                                            </div>


                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">Email</b></label>
                                                <input type="email" id="employee_email" name="employee_email" placeholder="Enter email"  class="form-control"  onkeyup="return Validation_employee_email()" >
                                               
                                                <span id="employee_email-error" class="text-danger"></span>

                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">password</b></label>
                                                <input type="password" id="employee_password_1" name="employee_password" placeholder="Enter password"  class="form-control" onkeyup="return validation_employee_password()">
                                                <span id="employee_password_1-error" class="text-danger"></span>

                                            </div>

                                            <div class="form-group mb-3" >
                                                <label for="simpleinput"><b style="color: black;">confirm password</b></label>
                                                <input type="password" id="employee_password_2" name="employee_password_2" placeholder="Enter password"  class="form-control"  onkeyup="return validation_employee_password()" >
                                               
                                                <span id="employee_password_2-error" class="text-danger"></span>

                                            </div>
                                           
                                            
                                        

                                    <div id="buttomsubmit">
                                        <input type="submit" id='bttnsubmit'  disabled='disabled' value="save" class="btn btn-primary">
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
                                <h2 class="mb-2 page-title">Employees</h2>
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
                                                        <th style="color: black;"><b>Name</b></th>
                                                        <th style="color: black;"><b>Email</b></th>
                                                       
                                                        <th style="color: black;"><b>ACTION</b></th>

                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($emloyee_details))
                                                    @php $i=1 @endphp
                                                    @foreach ($emloyee_details as $item)
                                                        <tr style="color: black;">

                                                            <td width="65"><b>{{$i++}}</b></td>
                                                            <td width="20"> @if( $item->isactive==0)
                                                                    <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                                @if( $item->isactive==1)
                                                                    <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                            </td>
                                                            
                                                            <td width="150">{{ $item->name}}</td>
                                                            
                                                           
                                                            <td width="250">{{ $item->email}}</td>
                                                            
                                                          
                                                            
                                                            
                                                            

                                                            <td width="250">
                                                            

                                                                <abbr style="text-decoration: none;" title="Edit Employee"><a href="{{url('update_Employee'.$item->id)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                @if( $item->isactive==0)
                                                                    <abbr style="text-decoration: none;"  title="Deactivate Employee"><a href="{{url('Inactive_Employee/'.$item->id)}}" style="text-decoration: none;" onclick="deActiveItem(event, this)"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                @endif
                                                                @if( $item->isactive==1)
                                                                    <abbr style="text-decoration: none;" title="Activate Employee"><a href="{{url('Active_Employee/'.$item->id)}}" style="text-decoration: none;" onclick="ActiveItem(event, this)"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                @endif
                                                                
                                                                
                                                               
                                                                
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

    <script>
        function Validation_name()
                    {
                        name = document.getElementById('name').value;
                        if (name == null||name==""){
                            document.getElementById("name-error").innerHTML = "This field is required.";
                            disableButton();
                            return false;
                        }else{
                            document.getElementById("name-error").innerHTML = "";
                        }
                    }
    
        function Validation_employee_email()
        {
            email = document.getElementById('employee_email').value;
            if (email == null||email==""){
                document.getElementById("employee_email-error").innerHTML = "This field is required.";
                disableButton();
                return false;
            }else{
                document.getElementById("employee_email-error").innerHTML = "";
            }
        
        }
   
        function validation_employee_password(){
            password_1 = document.getElementById('employee_password_1').value;
            password_2 = document.getElementById('employee_password_2').value;
                
            
            if(password_1==null || password_1==""){
                document.getElementById("employee_password_1-error").innerHTML = "This field is required.";
                disableButton();
                return false;
            }else if(password_2==null || password_2==""){
                document.getElementById("employee_password_2-error").innerHTML = "This field is required.";
                disableButton();
                return false;

            }else if(password_1 != password_2){
                document.getElementById("employee_password_2-error").innerHTML = "confirm password doesn't match";
                disableButton();
                return false;
            }else{
                enableButton();
                Validation_name();
                Validation_employee_email();
                document.getElementById("employee_password_1-error").innerHTML = "";
                document.getElementById("employee_password_2-error").innerHTML = "";
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




    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this Employee?',
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
        function deActiveItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to deactivate this Employee?',
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
                title: 'Are you sure to activate this Employee?',
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





    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    
   

@endsection
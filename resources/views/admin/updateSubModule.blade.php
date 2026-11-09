@extends('admin/adminMaster')


@section('adminpanel')

    <main role="main" class="main-content">
        <div class="container-fluid">
            @if (session('success'))
                <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
            @endif
            @if (session('error'))
                <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
            @endif
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="page-title">Update Sub Module</h2>


                    @if(isset($subModule))

                        @foreach($subModule as $data)

                            <form action="/subModuleUpdate/{{ $data->smId }}" method="POST">
                                @csrf

                                <input name="smId" type="hidden" value="{{$data->smId}}">

                                <div class="card shadow mb-4">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Sub Module Name</b></label>
                                                    <input type="hidden" id="subModuleNameOld"  value="{{$data->smName}}"  class="form-control" >
                                                    <input type="text" id="subModuleName" name="smName" value="{{$data->smName}}" placeholder="Enter sub module name" onKeyup="return smnameValidation()" class="form-control" >
                                                    @if ($errors->has('subModuleName'))
                                                        <span class="text-danger">{{ $errors->first('subModuleName') }}</span>
                                                    @endif
                                                    <span id="smname-error" class="text-danger"></span>
                                                    @endforeach
                                                    @endif

                                                </div>
                                                <button type="submit" class="btn btn-primary">UPDATE</button>
                                            </div> <!-- /.col -->

                                        </div></div>
                                </div></form>
                </div> <!-- / .card -->
            </div></div>



    </main> <!-- main -->



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->

    <!---------------FORM JAVASCRIPT VALIDATION FOR NAME-------------->
    <script>
        function smnameValidation() {
            subModuleNameOld = document.getElementById('subModuleNameOld').value;
            subModuleName = document.getElementById('subModuleName').value;
            let length = subModuleName.length;
            if (subModuleNameOld == subModuleName) {

                //no change

            } else {

                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/,0-9]/;

                if (subModuleName == null || subModuleName == "") {
                    document.getElementById("smname-error").innerHTML = "This field is required.";
                }
                // else if (subModuleName.match(format)) {
                //     document.getElementById("smname-error").innerHTML = "Restriction for Numbers and symbols.";
                // } 
                else if (length < 3) {
                    document.getElementById("name-error").innerHTML = "At leas 3 characters.";
                }
                //  else if (length > 100) {
                //     document.getElementById("smname-error").innerHTML = "Only 100 characters.";
                // } 
                else {
                    document.getElementById("smname-error").innerHTML = "";
                }
                $.ajax({
                    url: "{{url('/submNameCheck')}}",
                    type: "GET",
                    data: {
                        submodule: subModuleName,

                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {


                        if (result[0] != null) {

                            //module name have a value to another module
                            document.getElementById("smname-error").innerHTML = "Sub module name is already taken.";
                        } else {
                            //
                        }
                    }
                });

            }
        }
    </script>

@endsection
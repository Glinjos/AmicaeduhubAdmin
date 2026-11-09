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
                    <h2 class="page-title">Update Module</h2>

                    @if(isset($module))

                        @foreach($module as $data)

                            <form action="{{ url('ModuleUpdate/'.$data->mId) }}" method="POST">

                                @csrf
                                <input name="mId" type="hidden" value="{{$data->mId}}">

                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">

                                                    <label for="simpleinput"><b style="color: black;">Module Code</b></label>
                                                    <input type="hidden" id="ModuleCodeold"  value="{{$data->mCode}}" class="form-control">
                                                    <input type="text" id="ModuleCode" name="ModuleCode" value="{{$data->mCode}}" onKeyup="return moduleValidation()" placeholder="Enter module code" class="form-control">

                                                    @if ($errors->has('ModuleCode'))
                                                        <span class="text-danger">{{ $errors->first('ModuleCode') }}</span>
                                                    @endif

                                                    <span id="mcode-error" class="text-danger"></span>
                                                </div>

                                                <div class="form-group mb-3">

                                                    <label for="simpleinput"><b style="color: black;">Module Name</b></label>
                                                    <input type="hidden" id="ModuleNameold"  value="{{$data->mName}}" class="form-control">
                                                    <input type="text" id="ModuleName" name="ModuleName" value="{{$data->mName}}" placeholder="Enter module name" onChange="return moduleValidation()" class="form-control" >

                                                    @if ($errors->has('ModuleName'))
                                                        <span class="text-danger">{{ $errors->first('ModuleName') }}</span>
                                                    @endif

                                                    <span id="mname-error" class="text-danger"></span>

                                                    @endforeach

                                                    @endif

                                                </div>

                                                <button type="submit" id="btn" onclick="return moduleValidation()" class="btn btn-primary">UPDATE</button>


                                            </div> <!-- /.col -->

                                        </div></div>

                                </div></form>

                </div> <!-- / .card -->

            </div></div>

    </main> <!-- main -->


    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->

    <!---------------FORM JAVASCRIPT VALIDATION FOR Module Code-------------->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



    <script>

        function moduleValidation()

        {

            ModuleCodeold = document.getElementById('ModuleCodeold').value;

            ModuleCode = document.getElementById('ModuleCode').value;
            let length1 = ModuleCode.length;

            if(ModuleCodeold==ModuleCode){

                //no change

            }else{

                //ajax  checkk

                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;

                if (ModuleCode == null||ModuleCode==""){

                    document.getElementById("mcode-error").innerHTML = "This field is required.";
                }

                else if( ModuleCode.match(format)){

                    document.getElementById("mcode-error").innerHTML = "Restriction for numbers and symbols.";

                } else if(length1<2){
                    document.getElementById("mcode-error").innerHTML = "At leas 2 characters.";
                }else if(length1>5) {
                    document.getElementById("mcode-error").innerHTML = "Only 5 characters.";
                }else{
                    document.getElementById("mcode-error").innerHTML = "";
                }

                $.ajax({

                    url: "{{url('/mCodeCheck')}}",

                    type: "GET",

                    data: {

                        mCode: ModuleCode,

                        _token: '{{csrf_token()}}'

                    },

                    success: function(result) {

                        // console.log(result);



                        if(result[0]!=null){

                            //module code have a value to anothr module

                            document.getElementById("mcode-error").innerHTML = "Module code is already exist.";

                        }else{

                            //have to go

                        }

                    }

                });

            }


            ModuleNameold = document.getElementById('ModuleNameold').value;

            ModuleName = document.getElementById('ModuleName').value;
            let length2 = ModuleName.length;


            if(ModuleNameold==ModuleName){

                //no change

            }else {



                //ajax  checkk

                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;



                if (ModuleName == null || ModuleName == "") {

                    document.getElementById("mname-error").innerHTML = "This field is required.";

                }

                else if (ModuleName.match(format)) {

                    document.getElementById("mname-error").innerHTML = "Module name field not contain any numbers and symbols.";

                }else if(length2<3){
                    document.getElementById("mname-error").innerHTML = "At leas 3 characters.";

                }else if(length2>50) {
                    document.getElementById("mname-error").innerHTML = "Only 50 characters.";
                } else {

                    document.getElementById("mname-error").innerHTML = "";

                }

                $.ajax({

                    url: "{{url('/mNameCheck')}}",

                    type: "GET",

                    data: {

                        mName: ModuleName,

                        _token: '{{csrf_token()}}'

                    },

                    success: function (result) {



                        if (result[0] != null) {

                            //module name have a value to another module

                            document.getElementById("mname-error").innerHTML = "Module name is already exist.";

                        } else {

                            //have to go

                        }

                    }

                });

            }

        }

    </script>



@endsection
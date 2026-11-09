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
                    <h2 class="page-title">Update Subject</h2>

                    @if(isset($subject))

                        @foreach($subject as $data)

                            <form action="{{ url('subjectUpdate/'.$data->vcmId) }}" method="POST">

                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                                {{-- <input name="pqmainId" id="pqmainId" type="hidden" value="{{$data->pqmainId}}"> --}}
                                <input name="vcmId" id="vcmId" type="hidden" value="{{$data->vcmId}}">

                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">

                                                    <label for="simpleinput"><b style="color: black;">Subject Name</b></label>
                                                    <input type="hidden" id="subjectNameold"  value="{{$data->vcmName}}" class="form-control">
                                                    <input type="text" id="subjectName" name="subjectName" value="{{$data->vcmName}}" placeholder="Enter subject name" onkeyup="return categoryValidation()" class="form-control" >

                                                    @if ($errors->has('subjectName'))
                                                        <span class="text-danger">{{ $errors->first('subjectName') }}</span>
                                                    @endif

                                                    <span id="vcmname-error" class="text-danger"></span>

                                                    @endforeach

                                                    @endif

                                                </div>

                                                <button type="submit" id="btn" onclick="return categoryValidation()" class="btn btn-primary">UPDATE</button>


                                            </div> <!-- /.col -->

                                        </div></div>

                                </div></form>

                </div> <!-- / .card -->

            </div></div>

    </main> <!-- main -->


    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->

    <!---------------FORM JAVASCRIPT VALIDATION FOR Module Code-------------->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        function categoryValidation()
        {
            subjectNameold = document.getElementById('subjectNameold').value;

            subjectName = document.getElementById('subjectName').value;
           // pqmainId = document.getElementById('pqmainId').value;
            vcmId = document.getElementById('vcmId').value;
            
            let length2 = subjectName.length;

            if(subjectNameold==subjectName){

                //no change

            }else {

                //ajax  checkk

               // var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;



                if (subjectName == null || subjectName == "") {

                    document.getElementById("vcmname-error").innerHTML = "This field is required.";

                }

                // else if (subjectName.match(format)) {

                //     document.getElementById("vcmname-error").innerHTML = "Restriction for numbers and symbols.";

                // }
                else if(length2<2){
                    document.getElementById("vcmname-error").innerHTML = "At leas 2 characters.";

                }else if(length2>50) {
                    document.getElementById("vcmname-error").innerHTML = "Only 50 characters.";
                } else {

                    document.getElementById("vcmname-error").innerHTML = "";

                }

                $.ajax({
                url: "{{url('/vcmUpdateNameCheck')}}",
                type: "GET",
                data: {
                    vcmId:vcmId,
                    //pqmainId:pqmainId,
                    vcmName: subjectName,
                    _token: '{{csrf_token()}}'
                },
               success: function (result) {


                    if (result[0] != null) {

                        //module name have a value to another module
                        document.getElementById("vcmname-error").innerHTML = "Subject name is already taken.";
                        return false;
                    } else {
                        //have to go
                       
                    }
                }
            });

            }

        }

    </script>

@endsection
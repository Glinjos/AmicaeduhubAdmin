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
                    <h2 class="page-title">Update Exam Type</h2>

                    @if(isset($examtype))

                        @foreach($examtype as $data)

                            <form action="{{ url('examMainUpdate/'.$data->pqmainId) }}" method="POST">

                                @csrf
                                <input name="pqmainId" type="hidden" value="{{$data->pqmainId}}">
                                <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">

                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">

                                                    <label for="simpleinput"><b style="color: black;">Exam Name</b></label>
                                                    <input type="hidden" id="CategoryNameold"  value="{{$data->pqmainName}}" class="form-control">
                                                    <input type="text" id="examName" name="examName" value="{{$data->pqmainName}}" placeholder="Enter exam name" onkeyup="return examValidation()" class="form-control" >

                                                    @if ($errors->has('examName'))
                                                        <span class="text-danger">{{ $errors->first('examName') }}</span>
                                                    @endif

                                                    <span id="pqmname-error" class="text-danger"></span>

                                                  

                                                </div>
                                                <div class="form-group mb-3">

                                                    <label for="simpleinput"><b style="color: black;">Score</b></label>
                                                    <input type="hidden" id="positiveMarkold"  value="{{$data->positiveMark}}" class="form-control">
                                                    <input type="text" id="positiveMark" name="positiveMark" value="{{$data->positiveMark}}" placeholder="Enter score" onkeyup="return positiveMarkValidation()" class="form-control" >

                                                    @if ($errors->has('positiveMark'))
                                                        <span class="text-danger">{{ $errors->first('positiveMark') }}</span>
                                                    @endif

                                                    <span id="positiveMark-error" class="text-danger"></span>

                                                  

                                                </div>
                                                <div class="form-group mb-3">

                                                    <label for="simpleinput"><b style="color: black;">Negative Score</b></label>
                                                    <input type="hidden" id="negativeMarkold"  value="{{$data->negativeMark}}" class="form-control">
                                                    <input type="text" id="negativeMark" name="negativeMark" value="{{$data->negativeMark}}" placeholder="Enter negative score" onkeyup="return negativeMarkValidation()" class="form-control" >

                                                    @if ($errors->has('negativeMark'))
                                                        <span class="text-danger">{{ $errors->first('negativeMark') }}</span>
                                                    @endif

                                                    <span id="negativeMark-error" class="text-danger"></span>

                                                   

                                                </div>
                                                @endforeach

                                                @endif

                                                <button type="submit" id="btn" onclick="return examValidation()" class="btn btn-primary">UPDATE</button>


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

        function positiveMarkValidation()
        {
           

            positiveMarkold = document.getElementById('positiveMarkold').value;
            positiveMark = document.getElementById('positiveMark').value;

           

           // let length2 = examName.length;

            if(positiveMarkold==positiveMark){

                //no change

            }else {

                //ajax  checkk

                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?,]/;



                if (positiveMark == null || positiveMark == "") {

                    document.getElementById("positiveMark-error").innerHTML = "This field is required.";
                    document.getElementById("btn").disabled = true;
                   return false;

                }

                else if (positiveMark.match(format)) {

                    document.getElementById("positiveMark-error").innerHTML = "Restriction for  symbols.";
                    document.getElementById("btn").disabled = true;
                   return false;

                }else {

                    document.getElementById("positiveMark-error").innerHTML = "";
                    document.getElementById("btn").disabled = false;
                   return true;

                }
                

               

            }

        }

    </script>

<script>

    function negativeMarkValidation()
    {
     

        negativeMarkold = document.getElementById('negativeMarkold').value;
        negativeMark = document.getElementById('negativeMark').value;

       

        if(negativeMarkold==negativeMark){

            //no change

        }else {

            //ajax  checkk

            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?,]/;



            if (negativeMark == null || negativeMark == "") {

                document.getElementById("negativeMark-error").innerHTML = "This field is required.";
                document.getElementById("btn").disabled = true;
                return false;

            }

            else if (negativeMark.match(format)) {

                document.getElementById("negativeMark-error").innerHTML = "Restriction for  symbols.";
                document.getElementById("btn").disabled = true;
                return false;

            } else {

                document.getElementById("negativeMark-error").innerHTML = "";
                document.getElementById("btn").disabled = false;
                return true;

            }
            

            

        }

    }

</script>

    <script>

        function examValidation()
        {
            CategoryNameold = document.getElementById('CategoryNameold').value;
            examName = document.getElementById('examName').value;

           
            let length2 = examName.length;

            if(CategoryNameold==examName){

                //no change

            }else {

                //ajax  checkk

                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;



                if (examName == null || examName == "") {

                    document.getElementById("pqmname-error").innerHTML = "This field is required.";

                }

                else if (examName.match(format)) {

                    document.getElementById("pqmname-error").innerHTML = "Restriction for numbers and symbols.";

                }else if(length2<2){
                    document.getElementById("pqmname-error").innerHTML = "At leas 2 characters.";

                }else if(length2>50) {
                    document.getElementById("pqmname-error").innerHTML = "Only 50 characters.";
                } else {

                    document.getElementById("pqmname-error").innerHTML = "";

                }
                

                $.ajax({

                    url: "{{url('/pqmainNameCheck')}}",

                    type: "GET",

                    data: {

                        pqmainName: examName,

                        _token: '{{csrf_token()}}'

                    },

                    success: function (result) {



                        if (result[0] != null) {

                            //module name have a value to another module

                            document.getElementById("pqmname-error").innerHTML = "Exam name is already exist";
                           // alert('hello world');

                        } else {

                            //have to go

                        }

                    }

                });

            }

        }

    </script>

@endsection
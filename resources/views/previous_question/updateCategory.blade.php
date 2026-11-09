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
                    <h2 class="page-title">Update Category</h2>

                    @if(isset($category))

                        @foreach($category as $data)

                            <form action="{{ url('categoryUpdate/'.$data->pqmId) }}" method="POST">

                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                                <input name="pqmId" type="hidden" value="{{$data->pqmId}}">

                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">

                                                    <label for="simpleinput"><b style="color: black;">Exam Year</b></label>
                                                    <input type="hidden" id="CategoryNameold"  value="{{$data->pqmName}}" class="form-control">
                                                    <input type="text" id="CategoryName" name="CategoryName" value="{{$data->pqmName}}" placeholder="Enter exam year" onChange="return categoryValidation()" class="form-control" >

                                                    @if ($errors->has('CategoryName'))
                                                        <span class="text-danger">{{ $errors->first('CategoryName') }}</span>
                                                    @endif

                                                    <span id="pqmname-error" class="text-danger"></span>

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



    <script>

        function categoryValidation()
        {
            CategoryNameold = document.getElementById('CategoryNameold').value;

            CategoryName = document.getElementById('CategoryName').value;
            let length2 = CategoryName.length;

            if(CategoryNameold==CategoryName){

                //no change

            }else {

                //ajax  checkk

               // var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;



                if (CategoryName == null || CategoryName == "") {

                    document.getElementById("pqmname-error").innerHTML = "This field is required.";

                }

                // else if (CategoryName.match(format)) {

                //     document.getElementById("pqmname-error").innerHTML = "Restriction for numbers and symbols.";

                // }
                else if(length2<2){
                    document.getElementById("pqmname-error").innerHTML = "At leas 2 characters.";

                }else if(length2>50) {
                    document.getElementById("pqmname-error").innerHTML = "Only 50 characters.";
                } else {

                    document.getElementById("pqmname-error").innerHTML = "";

                }

                $.ajax({

                    url: "{{url('/pqmNameCheck')}}",

                    type: "GET",

                    data: {

                        mName: CategoryName,

                        _token: '{{csrf_token()}}'

                    },

                    success: function (result) {



                        if (result[0] != null) {

                            //module name have a value to another module

                            document.getElementById("pqmname-error").innerHTML = "Category name is already exist";

                        } else {

                            //have to go

                        }

                    }

                });

            }

        }

    </script>

@endsection
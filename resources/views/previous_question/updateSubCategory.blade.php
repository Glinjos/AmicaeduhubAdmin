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
                    <h2 class="page-title">Update Sub Category</h2>


                    @if(isset($subcategory))

                        @foreach($subcategory as $data)

                            <form action="/subCategoryUpdate/{{ $data->pqsmId }}" method="POST">
                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                                <input name="pqsmId" type="hidden" value="{{$data->pqsmId}}">

                                <div class="card shadow mb-4">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Exam Name</b></label>
                                                    <input type="hidden" id="subCategoryNameOld"  value="{{$data->pqsmName}}" class="form-control" >
                                                    <input type="text" id="subCategoryName" name="pqsmName" value="{{$data->pqsmName}}" placeholder="Enter exam name" onKeyup="return pqsmnameValidation()" class="form-control" >
                                                    @if ($errors->has('subModuleName'))
                                                        <span class="text-danger">{{ $errors->first('subCategoryName') }}</span>
                                                    @endif
                                                    <span id="pqsmname-error" class="text-danger"></span>
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




    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->

    <!---------------FORM JAVASCRIPT VALIDATION FOR NAME-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function pqsmnameValidation() {
            subCategoryNameOld = document.getElementById('subCategoryNameOld').value;
            subCategoryName = document.getElementById('subCategoryName').value;
            let length = subCategoryName.length;
            if (subCategoryNameOld == subCategoryName) {

                //no change

            } else {

                // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/]/;

                if (subCategoryName == null || subCategoryName == "") {
                    document.getElementById("pqsmname-error").innerHTML = "This field is required.";
                }
                // else if( subCategoryName.match(format)){
                //     document.getElementById("pqsmname-error").innerHTML = "Subcategory Name field not contain any symbols!";
                //     return false;
                // }
                else if (length < 3) {
                    document.getElementById("pqsmname-error").innerHTML = "At leas 3 characters.";
                } else if (length > 100) {
                    document.getElementById("pqsmname-error").innerHTML = "Only 100 characters.";
                } else {
                    document.getElementById("pqsmname-error").innerHTML = "";
                }
                $.ajax({
                    url: "{{url('/subcAjNameCheck')}}",
                    type: "GET",
                    data: {
                        subcatname: subCategoryName,

                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {


                        if (result[0] != null) {

                            //module name have a value to another module
                            document.getElementById("pqsmname-error").innerHTML = "Subcategory name is already taken";
                        } else {

                        }
                    }
                });

            }
        }
    </script>

@endsection
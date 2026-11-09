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
                    <h2 class="page-title">Update Chapter</h2>


                    @if(isset($chapter))

                        @foreach($chapter as $data)

                            <form action="/chapterUpdate/{{ $data->vcChapterId }}" method="POST">
                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                                <input name="vcChapterId" id="vcChapterId" type="hidden" value="{{$data->vcChapterId}}">
                                <input name="vcmId" id="vcmId" type="hidden" value="{{$data->vcmId}}">

                                <div class="card shadow mb-4">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Chapter</b></label>
                                                    <input type="hidden" id="chapterOld"  value="{{$data->vcChapterName}}" class="form-control" >
                                                    <input type="text" id="chapter" name="chapter" value="{{$data->vcChapterName}}" placeholder="Enter chapter" onKeyup="return chapterValidation()" class="form-control" >
                                                    @if ($errors->has('chapter'))
                                                        <span class="text-danger">{{ $errors->first('chapter') }}</span>
                                                    @endif
                                                    <span id="name-error" class="text-danger"></span>
                                                   

                                                 </div>

                                               {{-- <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Chapter Video</b></label>
                                                    <input type="hidden" id="chapterVideoOld"  value="{{$data->vcChapterVideo}}" class="form-control" >
                                                    <input type="text" id="chapterVideo" name="chapterVideo" value="{{$data->vcChapterVideo}}" placeholder="Enter chapter video link" onKeyup="return chapterVideoValidation()" class="form-control" >
                                                    @if ($errors->has('chapterVideo'))
                                                        <span class="text-danger">{{ $errors->first('chapterVideo') }}</span>
                                                    @endif
                                                    <span id="chapterVideo-error" class="text-danger"></span>
                                                   

                                                </div> --}}


                                                {{-- <div class="form-group mb-3">
                                                    <label for="simpleinput"><b style="color: black;">Chapter Description</b></label>
                                                    <input type="hidden" id="chapterDescriptionOld"  value="{{$data->vcChapterDescription}}" class="form-control" >
                                                    {{-- <input type="text" id="chapterDescription" name="chapterDescription" placeholder="Enter chapter Description" onKeyup="" class="form-control" > --}}
                                                    {{-- <textarea class="form-control" name="chapterDescription"
                                                     id="chapterDescription" placeholder="Enter chapter description" 
                                                     onkeyup="return chapterDescriptionValidation()" required style="width: 940px; height: 150px;">{{$data->vcChapterDescription}}</textarea>
                                                    @if ($errors->has('chapterDescription'))
                                                        <span class="text-danger">{{ $errors->first('chapterDescription') }}</span>
                                                    @endif
                                                    <span id="chapterDescription-error" class="text-danger"></span>
                                                    @endforeach
                                                    @endif

                                                </div>  --}}
                                                

                                                <button type="submit" class="btn btn-primary">UPDATE</button>
                                            </div> <!-- /.col -->

                                        </div></div>
                                </div>
                                @endforeach
                                @endif
                            </form>
                </div> <!-- / .card -->
            </div></div>



    </main> <!-- main -->




    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->

    <!---------------FORM JAVASCRIPT VALIDATION FOR NAME-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function pqsmnameValidation() {
            chapterOld = document.getElementById('chapterOld').value;
            chapter = document.getElementById('chapter').value;
            let length = chapter.length;
            if (chapterOld == chapter) {

                //no change

            } else {

                // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/]/;

                if (chapter == null || chapter == "") {
                    document.getElementById("chapter-error").innerHTML = "This field is required.";
                }
                // else if( chapter.match(format)){
                //     document.getElementById("chapter-error").innerHTML = "Subcategory Name field not contain any symbols!";
                //     return false;
                // }
                else if (length < 3) {
                    document.getElementById("chapter-error").innerHTML = "At leas 3 characters.";
                } else if (length > 100) {
                    document.getElementById("chapter-error").innerHTML = "Only 100 characters.";
                } else {
                    document.getElementById("chapter-error").innerHTML = "";
                }
                $.ajax({
                    url: "{{url('/chapterUpdateAjNameCheck')}}",
                    type: "GET",
                    data: {
                        subcatname: chapter,

                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {


                        if (result[0] != null) {

                            //module name have a value to another module
                            document.getElementById("chapter-error").innerHTML = "chapter name is already taken";
                        } else {

                        }
                    }
                });

            }
        }
    </script>

<script>
    function chapterValidation()
    {
        $(document).ready(function () {

        let category = document.getElementById('vcmId').value;
        let name = document.getElementById('chapter').value;
        let vcChapterId = document.getElementById('vcChapterId').value;
        
        
        //console.log(name);
        let length = name.length;
        // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;

        $.ajax({
        url: "{{url('/chapterUpdateAjNameCheck')}}",
        type: "GET",
        data: {
            vcChapterId:vcChapterId,
            vcmId: category,
            vcChapterName: name,

            _token: '{{csrf_token()}}'
        },
        success: function (result) {
            console.log(result);


            if (result[0] != null) {

                //module name have a value to another module
                document.getElementById("name-error").innerHTML = "This chapter is already taken.";
                document.getElementById("save").style.display = 'none';
                return false;
            } else {
                document.getElementById("save").style.display = 'block';

            }
        }
        });

        let shouldSubmitForm = true;

        if (category == null || category == "") {
        //document.getElementById("module-error").innerHTML = "This field is required.";
        shouldSubmitForm = false; // set variable to false if name field is null
        $("#save").attr("disabled", true); // disable the "Save" button
        } 

        if (name == null || name == "") {
        document.getElementById("name-error").innerHTML = "This field is required.";
        shouldSubmitForm = false; // set variable to false if name field is null
        $("#save").attr("disabled", true); // disable the "Save" button
        } else if (length < 3) {
        document.getElementById("name-error").innerHTML = "At least 3 characters.";
        shouldSubmitForm = false; // set variable to false if name field is too short
        $("#save").attr("disabled", true); // disable the "Save" button
        } else if (length > 100) {
        document.getElementById("name-error").innerHTML = "Only 100 characters.";
        shouldSubmitForm = false; // set variable to false if name field is too long
        $("#save").attr("disabled", true); // disable the "Save" button
        } 








        else {
        document.getElementById("name-error").innerHTML = "";
        document.getElementById("module-error").innerHTML = "";
        $("#save").attr("disabled", false); // enable the "Save" button
        }

        // $("#save").on("click", function() {
        //   if (shouldSubmitForm) { // only submit form if variable is still true
        //     $(this).attr("disabled", "disabled");
        //     $(this).html("Saving...");
        //     $("#scform").submit();
        //   }
        // });

        });

    }

</script>
{{-- <script>
    function chapterVideoValidation()
    {
        $(document).ready(function () {

           
            let chapterVideo = document.getElementById('chapterVideo').value;
            //console.log(name);
            let length = chapterVideo.length;
            // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;


        let shouldSubmitForm = true;

                if (chapterVideo == null || chapterVideo == "") {
                document.getElementById("chapterVideo-error").innerHTML = "This field is required.";
                shouldSubmitForm = false; // set variable to false if name field is null
                $("#save").attr("disabled", true); // disable the "Save" button
                } 
                // else if (length < 3) {
                // document.getElementById("chapterVideo-error").innerHTML = "At least 3 characters.";
                // shouldSubmitForm = false; // set variable to false if name field is too short
                // $("#save").attr("disabled", true); // disable the "Save" button
                // } else if (length > 100) {
                // document.getElementById("chapterVideo-error").innerHTML = "Only 100 characters.";
                // shouldSubmitForm = false; // set variable to false if name field is too long
                // $("#save").attr("disabled", true); // disable the "Save" button
                // }
                 else {
                document.getElementById("chapterVideo-error").innerHTML = "";
                // document.getElementById("module-error").innerHTML = "";
                $("#save").attr("disabled", false); // enable the "Save" button
                }

            

            });

    }

</script>

<script>
function chapterDescriptionValidation()
{
    $(document).ready(function () {

       
        let chapterDescription = document.getElementById('chapterDescription').value;
        //console.log(name);
        let length = chapterDescription.length;
        // var format = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/,?]/;


    let shouldSubmitForm = true;

            if (chapterDescription == null || chapterDescription == "") {
            document.getElementById("chapterDescription-error").innerHTML = "This field is required.";
            shouldSubmitForm = false; // set variable to false if name field is null
            $("#save").attr("disabled", true); // disable the "Save" button
            } else if (length < 3) {
            document.getElementById("chapterDescription-error").innerHTML = "At least 3 characters.";
            shouldSubmitForm = false; // set variable to false if name field is too short
            $("#save").attr("disabled", true); // disable the "Save" button
            }
            //  else if (length > 100) {
            // document.getElementById("chapterDescription-error").innerHTML = "Only 100 characters.";
            // shouldSubmitForm = false; // set variable to false if name field is too long
            // $("#save").attr("disabled", true); // disable the "Save" button
            // }
             else {
            document.getElementById("chapterDescription-error").innerHTML = "";
            // document.getElementById("module-error").innerHTML = "";
            $("#save").attr("disabled", false); // enable the "Save" button
            }

        

        });

}

</script> --}}

@endsection
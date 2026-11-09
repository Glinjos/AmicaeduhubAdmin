@extends('admin/adminMaster')

@section('adminpanel')
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Module</h2>

                        <form action="{{ url('addModule') }}" id="mform" method="POST">
                            @csrf
                            
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            
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
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Module Code</b></label>
                                                <input type="text" id="ModuleCode" name="ModuleCode" value="{{old('ModuleCode')}}" onkeyup="return moduleValidation()" placeholder="Enter module code" class="form-control">
                                                @if ($errors->has('ModuleCode'))
                                                    <span class="text-danger">{{ $errors->first('ModuleCode') }}</span>
                                                @endif
                                                <span id="mcode-error" class="text-danger"></span>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Module Name</b></label>
                                                <input type="text" id="ModuleName" name="ModuleName" value="{{old('ModuleName')}}" placeholder="Enter module name" onkeyup="return moduleValidation()" class="form-control" >
                                                @if ($errors->has('ModuleName'))
                                                    <span class="text-danger">{{ $errors->first('ModuleName') }}</span>
                                                @endif
                                                <span id="mname-error" class="text-danger"></span>

                                            </div>
                                            <button type="button" id="btn" onclick="return moduleValidation()" class="btn btn-primary">SAVE</button>
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->
                    <br>

                    <div class="container-fluid">
                        <div class="row justify-content-center">

                            <div class="col-12">
                                <h2 class="page-title">Modules We Have</h2>
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
                                                        <th style="color: black;"><b>MODULE CODE</b></th>
                                                        <th style="color: black;"><b>MODULE NAME</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($module))
                                                        @php $i=1 @endphp
                                                        @foreach ($module as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b>
                                                                </td>
                                                                <td  width="20" > @if( $item->isAvail==0)
                                                                        <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                    @endif
                                                                    @if( $item->isAvail==1)
                                                                        <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                    @endif
                                                                </td>
                                                                <td width="100">{{ $item->mCode }}</td>
                                                                <td width="300">{{ wordwrap($item->mName,20,"\n",TRUE) }}</td>
                                                                <td width="65">
                                                                    <abbr style="text-decoration: none;" title="Edit Module"><a href="{{url('updateModule'.$item->mId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                    &nbsp;
                                                                    @if( $item->isAvail==0)
                                                                            <abbr style="text-decoration: none;"  title="Deactivate Module"><a href="{{url('ModuleDisable/'.$item->mId)}}" onclick="inactiveItem(event, this)" style="text-decoration: none;"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                        @endif
                                                                        @if( $item->isAvail==1)
                                                                            <abbr style="text-decoration: none;" title="Activate Module"> <a href="{{url('ModuleEnable/'.$item->mId)}}"  onclick="activeItem(event, this)" style="text-decoration: none;"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='js/jquery.dataTables.min.js'></script>
    <script src='js/dataTables.bootstrap4.min.js'></script>
    <script>
        $('#dataTable-1').DataTable(
            {
                autoWidth: true,
                "lengthMenu": [
                   [50, 100, 200, -1],
                    [50, 100, 200, "All"]
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

        function moduleValidation(){
            $(document).ready(function () {
                ModuleCode = document.getElementById('ModuleCode').value;
                let length1 = ModuleCode.length;

                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;

                if (ModuleCode == null||ModuleCode==""){
                    document.getElementById("mcode-error").innerHTML = "This field is required.";
                    return false;
                }
                else if( ModuleCode.match(format)){
                    document.getElementById("mcode-error").innerHTML = "Restriction for numbers and symbols.";
                    return false;

                }else if(length1<3){
                    document.getElementById("mcode-error").innerHTML = "At leas 3 characters.";
                    return false;
                }else if(length1>5) {
                    document.getElementById("mcode-error").innerHTML = "Only 5 characters.";
                    return false;
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

                        if(result[0]!=null){

                            //module code have a value to anothr module
                            document.getElementById("mcode-error").innerHTML = "Module code is already taken.";
                            return false;
                        }else{
                            //have to go
                        }
                    }
                });



                ModuleName = document.getElementById('ModuleName').value;
                let length2 = ModuleName.length;

                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;

                if (ModuleName == null||ModuleName==""){
                    document.getElementById("mname-error").innerHTML = "This field is required.";
                    return false;
                }
                else if( ModuleName.match(format)){
                    document.getElementById("mname-error").innerHTML = "Restriction for numbers and symbols.";
                    return false;

                }else if(length2<3){
                    document.getElementById("mname-error").innerHTML = "At leas 3 characters.";
                    return false;
                }else if(length2>50) {
                    document.getElementById("mname-error").innerHTML = "Only 50 characters.";
                    return false;
                }else{
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
                            document.getElementById("mname-error").innerHTML = "Module name already taken";
                            return false;
                        } else {
                            //have to go

                        }
                    }
                });

                $("#btn").on("click", function() {
                    $(this).attr("disabled", "disabled");

                     //this method contains your logic
                    $(this).html("Saving...");

                    $("#mform").submit()


                });
            });
        }




        // function moduleValidation(event)
        // {
            {{--ModuleCode = document.getElementById('ModuleCode').value;--}}
            {{--let length1 = ModuleCode.length;--}}


            {{--// this.form.submit(); this.disabled=true; this.value='Sending…';--}}

            {{--var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;--}}

            {{--if (ModuleCode == null||ModuleCode==""){--}}
                {{--document.getElementById("mcode-error").innerHTML = "This field is required.";--}}
                {{--return false;--}}
            {{--}--}}
            {{--else if( ModuleCode.match(format)){--}}
                {{--document.getElementById("mcode-error").innerHTML = "Restriction for numbers and symbols.";--}}
                {{--return false;--}}

            {{--}else if(length1<3){--}}
                {{--document.getElementById("mcode-error").innerHTML = "At leas 3 characters.";--}}
                {{--return false;--}}
            {{--}else if(length1>5) {--}}
                {{--document.getElementById("mcode-error").innerHTML = "Only 5 characters.";--}}
                {{--return false;--}}
            {{--}else{--}}
                {{--document.getElementById("mcode-error").innerHTML = "";--}}

            {{--}--}}
            {{--$.ajax({--}}
                {{--url: "{{url('/mCodeCheck')}}",--}}
                {{--type: "GET",--}}
                {{--data: {--}}
                    {{--mCode: ModuleCode,--}}
                    {{--_token: '{{csrf_token()}}'--}}
                {{--},--}}
                {{--success: function(result) {--}}

                    {{--if(result[0]!=null){--}}

                        {{--//module code have a value to anothr module--}}
                        {{--document.getElementById("mcode-error").innerHTML = "Module code is already taken.";--}}
                        {{--return false;--}}
                    {{--}else{--}}
                        {{--//have to go--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}



            {{--ModuleName = document.getElementById('ModuleName').value;--}}
            {{--let length2 = ModuleName.length;--}}

            {{--var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;--}}

            {{--if (ModuleName == null||ModuleName==""){--}}
                {{--document.getElementById("mname-error").innerHTML = "This field is required.";--}}
                {{--return false;--}}
            {{--}--}}
            {{--else if( ModuleName.match(format)){--}}
                {{--document.getElementById("mname-error").innerHTML = "Restriction for numbers and symbols.";--}}
                {{--return false;--}}

            {{--}else if(length2<3){--}}
                {{--document.getElementById("mname-error").innerHTML = "At leas 3 characters.";--}}
                {{--return false;--}}
            {{--}else if(length2>50) {--}}
                {{--document.getElementById("mname-error").innerHTML = "Only 50 characters.";--}}
                {{--return false;--}}
            {{--}else{--}}
                {{--document.getElementById("mname-error").innerHTML = "";--}}

            {{--}--}}
            {{--$.ajax({--}}
                {{--url: "{{url('/mNameCheck')}}",--}}
                {{--type: "GET",--}}
                {{--data: {--}}
                    {{--mName: ModuleName,--}}
                    {{--_token: '{{csrf_token()}}'--}}
                {{--},--}}
                {{--success: function (result) {--}}


                    {{--if (result[0] != null) {--}}

                        {{--//module name have a value to another module--}}
                        {{--document.getElementById("mname-error").innerHTML = "Module name already taken";--}}
                        {{--return false;--}}
                    {{--} else {--}}
                        {{--//have to go--}}

                    {{--}--}}
                {{--}--}}
            {{--});--}}

            {{--var btn =document.getElementById("btn");--}}
            {{--var mf =document.getElementById("mform");--}}

            {{--// mf.form.submit(); btn.disabled=true;--}}
            {{--btn.form.submit();--}}
            {{--this.value='Sending…';--}}
            {{--this.disabled=true;--}}
            {{--// $("#btn").on("click", function(event){--}}
            {{--//     event.preventDefault();--}}
            {{--// });--}}
            {{--//   event.preventDefault();--}}

        {{--}--}}
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this module?',
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
        function activeItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to activate this module?',
                text: 'All submodule will be activated under this module!',
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
        function inactiveItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to deactivate this module?',
                text: 'All submodule will be deactivated under this module!',
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

@endsection
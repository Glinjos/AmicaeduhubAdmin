@extends('admin/adminMaster')


@section('adminpanel')
    {{--<style>--}}
    {{--abbr[title]{--}}
    {{--border-bottom: 1px dotted;--}}
    {{--background: yellow;--}}
    {{--}--}}

    {{--</style>--}}

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Sub Module</h2>

                        <form  class="state-form" id="smform" action="{{url('/addsub')}}" method="post">
                            @csrf
                            
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            
                            <div class="card shadow mb-4">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                        @if (session('success'))                                                                          
                                            <h6 class="alert alert-success">{{ session('success') }}</h6>
                                        @endif
                                        @if(session('mid'))
                                        <script>
                                                window.onload = function () {
                                                    myFunction();
                                                };
                                            </script>
                                        @endif
                                            @if (session('error'))
                                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                                @endif

                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

                                            <b style="color: black;">Module</b>
                                            <select name="module" id="module" onChange="return myFunction()" class="form-control">
                                                <option style="text-align: center" disabled selected>--- Select module ---</option>
                                                @if(isset($select1))
                                                    @foreach($select1 as $data)

                                                        <option value="{{$data->mId}}{{$data->mCode}}" {{ $data->mId == session('mid') ? 'selected' : '' }} id="demo" align="center">

                                                        <!-- <p value="{{$data->mid}}.{{$data->mCode}}" >{{$data->mCode}}</p> -->
                                                            {{ $data->mName}}</option>

                                                    @endforeach
                                                @endif

                                            </select>

                                            <!-- FORM---START -->
                                            <div id="btn" style="display: none">

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1"><b style="color: black;">Sub Module</b></label>
                                                    <input type="text" class="form-control" name="submodule" id="submdle" value="{{old('submodule')}}" placeholder="Enter sub module"  onkeyup="return submnameOnKeyupValidation()" required>
                                                    <span id="name-error" class="text-danger"></span>
                                                    @if ($errors->has('submodule'))
                                                        <span class="text-danger">{{ $errors->first('submodule') }}</span>
                                                    @endif
                                                </div>


                                                <div class="form-group">

                                                    <abbr title="Generated code for Sub Module"> <label id="demo3" ></label></abbr>
                                                    <p id="demo1"></p>
                                                    <p id="demo2"></p>

                                                    <input type="hidden" id="submcode" name="submcode">
                                                    <input type="hidden" id="mid" name="mid">

                                                </div>


                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary" id="save" type="submit" onclick="return submnameOnClickValidation()">SAVE</button>



                                                </div>
                                            </div>
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->

                    &nbsp;&nbsp;&nbsp;
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <h2 class="mb-2 page-title">Sub Modules We Have</h2>
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
                                                        <th style="color: black;"><b>MODULE NAME</b></th>
                                                        <th style="color: black;"><b>SUB MODULE CODE</b></th>
                                                        <th style="color: black;"><b>SUB MODULE NAME</b></th>
                                                        <th style="color: black;"><b>ACTION</b></th>

                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $i=1 @endphp
                                                    @foreach ($select as $item)
                                                        <tr style="color: black;">

                                                            <td width="65"><b>{{$i++}}</b></td>
                                                            <td width="20"> @if( $item->isAvail==0)
                                                                    <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                                @if( $item->isAvail==1)
                                                                    <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                            </td>
                                                            <td width="150">{{wordwrap($item->mName,20,"\n",TRUE) }}</td>
                                                            <td width="150">{{ $item->smCode }}</td>
                                                            <td width="250">{{ wordwrap($item->smName,20,"\n",TRUE) }}</td>

                                                            <td width="65">

                                                                <abbr style="text-decoration: none;" title="Edit Sub Module"><a href="{{url('updateSubModule'.$item->smId)}}" onclick="editItem(event, this)" style="text-decoration: none;"><span class="fe fe-24 fe-edit"></span></a></abbr>
                                                                @if( $item->isAvail==0)
                                                                    <abbr style="text-decoration: none;"  title="Deactivate Sub Module"><a href="{{url('subModuleInactive/'.$item->smId)}}" style="text-decoration: none;" onclick="deActiveItem(event, this)"><span style="color: red;"class="fe fe-24 fe-minus-circle"></span></a></abbr>
                                                                @endif
                                                                @if( $item->isAvail==1)
                                                                    <abbr style="text-decoration: none;" title="Activate Sub Module"><a href="{{url('subModuleActive/'.$item->smId)}}" style="text-decoration: none;" onclick="ActiveItem(event, this)"><span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>
                                                                @endif


                                                            </td>
                                                        </tr>
                                                    @endforeach
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

            <!-- FORM---END -->
        </main>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script>
        function editItem(event, element) {
            event.preventDefault(); // prevent the default link behavior

            // Show the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to edit this submodule?',
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
                title: 'Are you sure to deactivate this submodule?',
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
                title: 'Are you sure to activate this submodule?',
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
        //  ---- first -work ---

        // $(document).ready(function() {
        //     $('#module').on('change', function() {
        //         var selectedVal = $(this).val();
        //         var numericValue = selectedVal.match(/\d+/)[0];//the out put of selectdVal(module is ex:2BB) converted to numeric value(2)
        //         var baseUrl = '{{ url('') }}';

        //         $.ajax({
        //             type: 'get',
        //             url: baseUrl + '/searchmodulewisesubmshow',
        //             data: {
        //                 'selvalue': numericValue
        //             },
        //             success: function(data) {
        //                 var tableBody = $('#dataTable-1 tbody');
        //                 tableBody.empty(); // Clear the existing table rows

        //                 // Populate the table with the received data
        //                 $.each(data, function(index, item) {
        //                     var row = $('<tr style="color: black;">');

        //                     row.append($('<td width="65">').text(item.slNo));
        //                     row.append($('<td width="20">').html('<b style="color: ' + item.isAvail + '; font-size: 30px">&#x2022;</b>'));
        //                     row.append($('<td width="150">').text(item.moduleName));
        //                     row.append($('<td width="150">').text(item.subModuleCode));
        //                     row.append($('<td width="250">').text(item.subModuleName));
        //                     row.append($('<td width="65">').html(
        //                         '<abbr style="text-decoration: none;" title="Edit Sub Module">' +
        //                         '<a href="' + item.editUrl + '" onclick="editItem(event, this)" style="text-decoration: none;">' +
        //                         '<span class="fe fe-24 fe-edit"></span></a></abbr>' +
        //                         ((item.deactivateUrl !== '') ?
        //                             ('<abbr style="text-decoration: none;" title="Deactivate Sub Module">' +
        //                                 '<a href="' + item.deactivateUrl + '" style="text-decoration: none;" onclick="deActiveItem(event, this)">' +
        //                                 '<span style="color: red;" class="fe fe-24 fe-minus-circle"></span></a></abbr>') : '') +
        //                         ((item.activateUrl !== '') ?
        //                             ('<abbr style="text-decoration: none;" title="Activate Sub Module">' +
        //                                 '<a href="' + item.activateUrl + '" style="text-decoration: none;" onclick="ActiveItem(event, this)">' +
        //                                 '<span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>') : '')
        //                     ));

        //                     tableBody.append(row);
        //                 });

        //             // console.log("success");
        //             },
        //             error: function(xhr, status, error) {
        //                 console.log(xhr.responseText);
        //             }
        //         });
        //     });
        // });

        // second--work---

        $(document).ready(function() {
                function handleModuleChange() {
                    var selectedVal = $('#module').val();
                //  alert(selectedVal);
                    var numericValue = selectedVal.match(/\d+/)[0];
                    var baseUrl = '{{ url('') }}';

                    $.ajax({
                        type: 'get',
                        url: baseUrl + '/searchmodulewisesubmshow',
                        data: {
                            'selvalue': numericValue
                        },
                        success: function(data) {
                            var tableBody = $('#dataTable-1 tbody');
                            tableBody.empty();

                            $.each(data, function(index, item) {
                                var row = $('<tr style="color: black;">');

                                row.append($('<td width="65">').text(item.slNo));
                                row.append($('<td width="20">').html('<b style="color: ' + item.isAvail + '; font-size: 30px">&#x2022;</b>'));
                                row.append($('<td width="150">').text(item.moduleName));
                                row.append($('<td width="150">').text(item.subModuleCode));
                                row.append($('<td width="250">').text(item.subModuleName));
                                row.append($('<td width="65">').html(
                                    '<abbr style="text-decoration: none;" title="Edit Sub Module">' +
                                    '<a href="' + item.editUrl + '" onclick="editItem(event, this)" style="text-decoration: none;">' +
                                    '<span class="fe fe-24 fe-edit"></span></a></abbr>' +
                                    ((item.deactivateUrl !== '') ?
                                        ('<abbr style="text-decoration: none;" title="Deactivate Sub Module">' +
                                            '<a href="' + item.deactivateUrl + '" style="text-decoration: none;" onclick="deActiveItem(event, this)">' +
                                            '<span style="color: red;" class="fe fe-24 fe-minus-circle"></span></a></abbr>') : '') +
                                    ((item.activateUrl !== '') ?
                                        ('<abbr style="text-decoration: none;" title="Activate Sub Module">' +
                                            '<a href="' + item.activateUrl + '" style="text-decoration: none;" onclick="ActiveItem(event, this)">' +
                                            '<span style="color: green;" class="fe fe-24 fe-check-circle"></span></a></abbr>') : '')
                                ));

                                tableBody.append(row);
                            });

                            // console.log("success");
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }

                $('#module').on('change', function() {
                    handleModuleChange();
                });

                // Execute the function when the document is ready
                handleModuleChange();
            });



        



        </script>



    <!---------------Generating Sub Module JavaScript-------------->
    <script>
        function myFunction(e) {

            var module_code=document.getElementById('module').value;
            var mid = module_code.match(/\d+/g)[0];
            var modulecode = module_code.match(/[a-zA-Z]+/g)[0];

            $.ajax({
                url: "{{url('/smcodecheck')}}",
                type: "GET",
                data: {
                    mcCode: modulecode,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {
                    var c=result[0]["smCode"];



                    if (c==null){
                        var subCode = "A1001" ;
                        var code=modulecode+subCode;
                    }else{
                        //console.log('notnull condition');
                        var num = c.match(/\d+/g);
                        var l =  c.match(/[a-zA-Z]+/g);
                        ///console.log(num+l);
                        if (num == 9001 || l==""){
                            if(l==""){
                                //console.log("chr is null");
                                var letter='A';
                                var num=1001;
                            }else{
                                //console.log("number is 9000 letter need update");
                                var letter=String.fromCharCode(c.charCodeAt(0) + 1);
                                var num=1001;
                            }
                        }else{
                            var letter=l;
                            //console.log("iam here");
                            num = parseInt(num) + 1000;
                        }
                        var subCode=letter+num;
                        var code=modulecode+subCode;
                    }

                    console.log(mid);
                    document.getElementById("demo3").innerHTML = code;
                    document.getElementById("submcode").value = subCode;
                    document.getElementById("mid").value = mid;
                    document.getElementById("btn").style.display = 'block';

                }})


        }

    </script>


    <!---------------FORM JAVASCRIPT VALIDATION FOR SUB MODULES on submit-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function submnameOnKeyupValidation()
        {
            $(document).ready(function () {

            ModuleName = document.getElementById('submdle').value;
            let length2 = ModuleName.length;

           // console.log(ModuleName);
            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?,0-9]/;

            

            if (ModuleName == null||ModuleName==""){
                document.getElementById("name-error").innerHTML = "This field is required.";
                return false;
            }
            // else if( ModuleName.match(format)){
            //     document.getElementById("name-error").innerHTML = "Restriction for numbers and symbols.";
            //     return false;

            // }
            else if(length2<3){
                document.getElementById("name-error").innerHTML = "At leas 3 characters.";
                return false;
            }
            // else if(length2>100) {
            //     document.getElementById("name-error").innerHTML = "Only 100 characters.";
            //     return false;
            // }
            else{
                document.getElementById("name-error").innerHTML = "";

            }
            $.ajax({
                url: "{{url('/submNameCheck')}}",
                type: "GET",
                data: {
                    submodule: ModuleName,

                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    / console.log(result); /


                    if (result[0] != null) {

                        //module name have a value to another module
                        document.getElementById("name-error").innerHTML = "Sub module name is already taken.";
                        document.getElementById("save").style.display = 'none';
                        return false;
                    } else {
                        document.getElementById("save").style.display = 'block';

                    }
                }
            });

            $("#save").on("click", function() {
                $(this).attr("disabled", "disabled");

                //this method contains your logic
                $(this).html("Saving...");

                $("#smform").submit()


            });
        });

        }
    </script>

    <!---------------FORM JAVASCRIPT VALIDATION FOR SUB MODULES-------------->
    <script>
        function submnameOnClickValidation()
        {
            let name = document.getElementById('submdle').value;
            let length = name.length;
            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/,0-9?]/;

           

            if (name == null||name==""){
                document.getElementById("name-error").innerHTML = "This field is required.";
                return false;
            }
            else{
                // if(name.match(format)){
                //     document.getElementById("name-error").innerHTML = "Restriction for numbers and symbols.";
                //     return false;
                //     }else
                if(length<3){
                        document.getElementById("name-error").innerHTML = "At leas 3 characters.";
                        return false;
                }
                // else if(length>100) {
                //     document.getElementById("name-error").innerHTML = "Only 100 characters.";
                //     return false;
                // }
                else{
                    document.getElementById("name-error").innerHTML = "";
                    return true;
                }
            }

        }

    </script>

    <!---------------FORM JAVASCRIPT VALIDATION FOR SUB MODULES-------------->
    <!-- Ajax START -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--END Ajax -->

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

@endsection
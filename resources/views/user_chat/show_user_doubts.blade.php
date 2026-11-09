@extends('admin.adminMaster')


@section('adminpanel')


    <div class="wrapper">
        <main role="main" class="main-content">
            <!-- table -->
            @if (session('success'))
                <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
            @endif
            @if (session('error'))
                <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
            @endif

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="mb-2 page-title">Assign Users Questions</h2>

                        {{-- <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}"> --}}

                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <table class="table datatables" id="dataTable-1" >
                                            <thead>
                                            <tr style="background-color: lightgray;">
                                                <th style="color: black;"><b>Sl No</b></th>
                                                <th style="color: black;"><b>Chat Type</b></th>
                                                <th style="color: black;"><b>User Name</b></th>
                                                <th style="color: black;"><b>Module Name</b></th>
                                                {{-- <th style="color: black;"><b>Questions</b></th>
                                                <th style="color: black;"><b>Chat Date and Time</b></th> --}}
                                                <th style="color: black;"><b>ACTIONS</b></th>

                                            </tr>
                                            </thead>
                                            <tbody>


                                           

                                            <!--LOADER END HERE AFTER LOADING DATA -->



                                            @if(isset($user_all_questions))

                                                @php $i=1; @endphp

                                                @foreach ($user_all_questions as $item)

                                                    <tr  style=color:black;">
                                                        <td width="65"><b>{{$i++}}</b></td>

                                                        <td width="90">{{$item->typeName}}</td>
                                                        <td width="90">{{$item->name}}</td>
                                                        <td width="90">{{$item->mName}}</td>
                                                        {{-- <td width="150"><span id="qu{{$i}}" style="word-wrap: break-word;">{{ $item->question}}</span></td>
                                                        <td width="100">{{$item->chatDateTime}}</td> --}}
                                                       
                                                        
                                                        {{-- <td width="300">
                                                            <span  id="que{{$i}}" style="word-wrap: break-word;" onmouseover="return showanswer(<?php echo $item->questionId; ?>)"
                                                                   onmouseout="return hideanswer(<?php echo $item->questionId; ?>)">{{$item->question}}</span>
                                                            <p name="answerover" id="answeronmousehover{{$item->questionId}}" style="width:400px;word-wrap: break-word; display: none;color:green;font-weight: bold;" >"answer is" </p>
                                                        </td>
                                                        <td width="30"><abbr style="text-decoration: none;" title="ViewMore"><span onclick="return  showq(<?php echo $item->questionId;?>)" style="color: green;" class="fe fe-24 fe-more-horizontal" ></span></abbr></td> --}}
                                                        <td width="65">
                                                            @if($item->assigned == 0) 
                                                            <?php $parameter=Crypt::encrypt($item->chatQuestionId); ?>                                                               
                                                            <abbr style="text-decoration: none;" title="Assign Question">
                                                                <a href="{{ url('userquestionassign/'.$parameter) }}" style="text-decoration: none;" onclick="AssignItem(event, this)">
                                                                    <span style="display: inline-block; width: 26px; height: 26px; line-height: 26px; text-align: center; border-radius: 50%; background-color: red;">
                                                                        <span style="color: white; font-size: 16px;">&#10004;</span>
                                                                    </span>
                                                                </a>
                                                            </abbr>
                                                        @else
                                                        <?php $parameter=Crypt::encrypt($item->chatQuestionId); ?>   
                                                            <abbr style="text-decoration: none;" title="Unassign Question">
                                                                <a href="{{ url('userquestionunassign/'.$parameter) }}" style="text-decoration: none;" onclick="unAssignItem(event, this)">
                                                                    <span style="display: inline-block; width: 26px; height: 26px; line-height: 26px; text-align: center; border-radius: 50%; background-color: rgb(17, 59, 6);">
                                                                        <span style="color: white; font-size: 16px;">&#10006;</span>
                                                                    </span>
                                                                </a>
                                                            </abbr>
                                                        @endif
                                                        
                                                        
                                                        </td>
                                                        <!-- data-target="#show_question"  data-toggle="modal" -->


                                                    </tr>
                                                @endforeach
                                            @endif


                                           
                                         <script>
                                                function AssignItem(event, element) {
                                                    event.preventDefault(); // prevent the default link behavior

                                                    // Show the SweetAlert confirmation dialog
                                                    Swal.fire({
                                                        title: 'Are you sure to assign admin this question?',
                                                        text: '',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Confirm',
                                                        cancelButtonText: 'Cancel',
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = element.href;
                                                        }
                                                    });
                                                }
                                         </script>

<script>
    function unAssignItem(event, element) {
        event.preventDefault(); // prevent the default link behavior

        // Show the SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure to unassign admin this question?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = element.href;
            }
        });
    }
</script>


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- simple table -->
                        </div> <!-- end section -->
                    </div> <!-- .col-12 -->
                </div> <!-- .row -->
            </div>





            {{--Show question modal--}}

           







            {{--Edit question modal--}}



 




        </main> <!-- main -->
    </div> <!-- .wrapper -->


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   



    <!-- EditModal -->

    <style>
        .arrow {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
        }
        .down {
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
        }
    </style>


    <!-- TO SHOw LAODER -->
   
    <!-- FORM FOR MODEL TO SHOW VALUES -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    

   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    
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
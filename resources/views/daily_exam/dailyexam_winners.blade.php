@extends('admin.adminMaster')


@section('adminpanel')


    <div class="wrapper">
        <main role="main" class="main-content">
            <!-- table -->

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="mb-2 page-title">Daily Exam Winners</h2>
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <table class="table datatables" id="dataTable-1" >
                                            <thead>
                                            <tr style="background-color: lightgrey">
                                                <th style="color: black;"><b>SL NO</b></th>
                                                <th style="color: black;"><b>Exam Date</b></th>
                                                <th style="color: black;"><b>Exam Name</b></th>
                                                <th style="color: black;"><b>Exam Winner</b></th>
                                                
                                                <th style="color: black;"><b>View More</b>&nbsp;&nbsp;&nbsp;</th>
                                               

                                            </tr>
                                            </thead>

                                   {{-- tbody   --}}
                                            <tbody>

                                            @if(isset($winners))

                                                @php $i=1; @endphp

                                                @foreach ($winners as $item)

                                                    <tr  style="color:black;">
                                                        <td width="65"><b>{{$i++}}</b></td>

                                                        <td width="140">{{$item->examDate}}</td>
                                                        <td width="200">{{$item->examName}}</td>
                                                        <td width="150">{{$item->name}}</td>
                                                        
                                                        {{-- the td call a function and showing winners popup --}}
                                                        <td width="100"><abbr style="text-decoration: none;" title="View More"><span onclick="return showAllWinners('{{ $item->dId }}')" style="color: green;" class="fe fe-24 fe-more-horizontal" ></span></abbr></td>
                                                     
                                                        <!-- data-target="#show_winners"  data-toggle="modal" -->
                                                        {{-- div id is #show_winners --}}
                                                    </tr>

                                                @endforeach

                                            @endif

                                            </tbody>
                                  {{-- end -- tbody   --}}


                                        </table>

                                    </div>
                                </div>
                            </div> <!-- simple table -->
                        </div> <!-- end section -->
                    </div> <!-- .col-12 -->
                </div> <!-- .row -->
            </div>





            {{--Show winners modal--}}

            <div class="modal fade" id="show_winners" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="defaultModalLabel">Top Ten Winners</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <table>
                               
                                <tr>
                                    <br>
                                    <b style="color: black;">Exam Date :</b>
                                    <p id="examdateinview"  name="examdateinview" style="font-weight: bold;color:rgb(138, 10, 110);" disabled></p>
                                    
                                </tr>
                                <tr>
                                    <br>
                                    <b style="color: black;">Exam Name :</b>
                                    <p id="examNameinview"  name="examNameinview" style="font-weight: bold;color:rgb(138, 10, 110);" disabled></p>
                                    <br>
                                </tr>
                                <tr>

                                    <b style="color: black;">Exam Winners :</b>
                                    <p id="examwinnerNameinview"  name="examwinnerNameinview" style="font-weight: bold;color:rgb(24, 3, 100);" disabled></p>
                                    <br>
                                </tr>
                               
                                <div class="modal-footer">
                                   

                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

             {{-- End --Show winners modal--}}




        </main> <!-- main -->
    </div> <!-- .wrapper -->


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>$('body').on('hidden.bs.modal', function () {
            if($('.modal.in').length > 0)
            {
                $('body').addClass('modal-open');
            }
        });</script>
   




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


        <script>
            // SCRIPT TO SHOW WINNERS TO SHOW MODEL
            function showAllWinners(dId) {
            
                //alert(examdate);

                    $.ajax({
                        url: "{{url('/toptenwinners')}}",
                        type: "GET",
                        data: {
                            dId: dId,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(result) {

                            if (result) {
                        
                                document.getElementById("examdateinview").innerHTML =result[0].examdate;
                                document.getElementById("examNameinview").innerHTML =result[0].examName;
                                //     result.forEach(function(item) {
                                //     document.getElementById("examwinnerNameinview").innerHTML =item.name;
                                // });
                                var names = "";
                                var i=1;
                                
                                result.forEach(function(item) {

                                    names +="<br>"+i+'. '+ item.name + "<br>";
                                    i++;
                                });

                                document.getElementById("examwinnerNameinview").innerHTML = names;
                            

                                $('#show_winners').modal('show');
                            
                            }}
                    })
                    }
        </script>

    <script src='js/jquery.dataTables.min.js'></script>
    <script src='js/dataTables.bootstrap4.min.js'></script>
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
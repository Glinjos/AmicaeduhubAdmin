@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

    

                    <div class="container-fluid">
                        <div class="row justify-content-center">
                           @if(isset($user_name))
                           @foreach($user_name as $name)
                            <div class="col-12">
                                <h2 class="page-title">{{$name->name}}'s Live Game Histories </h2>
                               @endforeach
                               @endif
                              
                                <div class="row my-4">
                                    <!-- Small table -->
                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            <div class="card-body">

                                                <!-- table -->
                                                <table class="table datatables" id="dataTable-1">
                                                    <thead>
                                                    <tr style="background-color: lightgray;">
                                                        <th style="color: black;"><b>Sl No</b></th>
                                                       
                                                        <th style="color: black;"><b>Date</b></th> 
                                                        
                                                        <th style="color: black;"><b>TotalQuestions</b></th>
                                                        <th style="color: black;"><b>AttendedQuestions</b></th>
                                                        <th style="color: black;"><b>RightAns</b></th>
                                                        <th style="color: black;"><b>WrongAns</b></th>
                                                        <th style="color: black;"><b>Score</b></th>
                                                        <th style="color: black;"><b>Opponent Player</b></th>
                                                        <th style="color: black;"><b>Winner</b></th>
                                                       
                                                       
                



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($user_single_history))
                                                        @php $i=1 @endphp
                                                        @foreach ($user_single_history as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b></td>
                                                                <td width="90">{{ $item->dateTime }}</td>
                                                                <td width="90" align="center">{{ $item->totalQuestions }}</td>
                                                                <td width="90" align="center">{{ $item->attendedQuestions }}</td>
                                                                
                                                                <td width="90" align="center">{{ $item->rightAns }}</td>
                                                                <td width="90" align="center">{{ $item->wrongAns }}</td>
                                                                <td width="90" align="center">{{ $item->score }}</td>
                                                                
                                                                <td width="90" >
                                                                    <abbr style="text-decoration: none; color: rgb(15, 161, 137);" title="ViewMore">
                                                                        <span onclick="return  showq(<?php echo $item->OpponentId;?>,<?php echo $item->lgmId;?>)"> {{ $item->OpponentName }}</span>
                                                                       </abbr>
                                                             
                                                                </td>
                                                                
                                                                <td width="90" >{{ $item->winnerName }} </td>
                                                               
                                                                
                                                              
                                                               
                                                               
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


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



    <div class="modal fade" id="show_question" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">View</h5><p id="nameinview"  name="nameinview">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
    
                    <table>
                       
                      
                        <tr>
                            <br>
                            <b style="color: black;">Date :</b>
                            <p id="Dateinview"  name="Dateinview" style="font-weight: bold;color:blue;" disabled></p>
                            
                        </tr>
                        <tr>
                            <br>
                            <b style="color: black;">TotalQuestions :</b>
                            <p id="TotalQuestionsinview"  name="TotalQuestionsinview" style="font-weight: bold;color:blue;" disabled></p>
                            <br>
                        </tr>
                        <tr>
                            <br>
                            <b style="color: black;">AttendedQuestions :</b>
                            <p id="attendedQuestionsinview"  name="attendedQuestionsinview" style="font-weight: bold;color:blue;" disabled></p>
                            <br>
                        </tr>
                        <tr>
    
                            <b style="color: black;">RightAns :</b>
                            <p id="RightAnsinview"  name="RightAnsinview" style="font-weight: bold;color:blue;" disabled></p>
                            <br>
                        </tr>
                        <tr>
    
                            <b style="color: black;">WrongAns :</b>
                            <p id="WrongAnsinview"  name="WrongAnsinview" style="font-weight: bold;color:blue;" disabled></p>
                            <br>
                        </tr>

                        <tr>
    
                            <b style="color: black;">Score :</b>
                            <p id="Scoreinview"  name="Scoreinview" style="font-weight: bold;color:blue;" disabled></p>
                            <br>
                        </tr>
                        
                        <div class="modal-footer">
                           
    
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function showq(OpponentId,lgmId) {
      // alert(OpponentId);
      // alert(lgmId);
        $.ajax({
            url: "{{url('/Opponent_details')}}",
            type: "GET",
            data: {
                OpponentId: OpponentId,
                lgmId: lgmId,
                _token: '{{csrf_token()}}'
            },
            success: function(result) {

                if (result) {

                    const dateString = result[0].dateTime;
                    const dateObject = new Date(dateString);
                    const formattedDate = dateObject.toISOString().split('T')[0];
                    document.getElementById("Dateinview").innerHTML = formattedDate;

                    document.getElementById("nameinview").innerHTML =result[0].OpponentName;
                    document.getElementById("TotalQuestionsinview").innerHTML =result[0].totalQuestions;
                    document.getElementById("attendedQuestionsinview").innerHTML =result[0].attendedQuestions;
                    
                    document.getElementById("RightAnsinview").innerHTML =result[0].rightAns;
                    document.getElementById("WrongAnsinview").innerHTML =result[0].wrongAns;
                    document.getElementById("Scoreinview").innerHTML =result[0].score;
                   

                   
                    //show popupresult
                    // document.getElementById("show_question").style.display = "none";
                    $('#show_question').modal('show');
                    // data-target="#show_question"
                }}
        })
    }
</script>

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




@endsection
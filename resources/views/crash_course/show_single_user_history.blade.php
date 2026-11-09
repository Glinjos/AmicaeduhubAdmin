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
                                <h2 class="page-title">{{$name->name}}'s Crash Course Histories </h2>
                               @endforeach
                               @endif
                               @if(isset($course_name))
                               @foreach($course_name as $Cname)
                               
                                <h5 class="page-title">{{$Cname->coName}}   </h5>
                               @endforeach
                               @endif
                               @if(isset($batch_name))
                               @foreach($batch_name as $Bname)
                               
                                <h5 class="page-title">{{$Bname->cbatchName}}   </h5>
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
                                                        
                                                        <th style="color: black;"><b>totalQuestions</b></th>
                                                        <th style="color: black;"><b>QuestionsAttended</b></th>
                                                        <th style="color: black;"><b>rightAns</b></th>
                                                        <th style="color: black;"><b>wrongAns</b></th>
                                                        <th style="color: black;"><b>score</b></th>
                                                        <th style="color: black;"><b>percentage</b></th>
                                                       
                                                       
                



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($user_history))
                                                        @php $i=1 @endphp
                                                        @foreach ($user_history as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b></td>
                                                                <td width="90">{{ $item->dateAndTime }}</td>
                                                                <td width="90" align="center">{{ $item->totalQuestions }}</td>
                                                                <td width="90" align="center">{{ $item->QuestionsAttended }}</td>
                                                                <td width="90" align="center">{{ $item->rightAns }}</td>
                                                                <td width="90" align="center">{{ $item->wrongAns }}</td>
                                                                <td width="90" align="center">{{ $item->score }}</td>
                                                                <td width="90" align="center">{{ round($item->percentage, 2) }} %</td>
                                                               
                                                                
                                                              
                                                               
                                                               
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
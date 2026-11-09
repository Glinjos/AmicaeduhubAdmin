@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

    

                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            
                           @if(isset($plan_name))
                           @foreach($plan_name as $name)
                            <div class="col-12">
                                <h4 class="page-title">SUBSCRIBERS </h4>
                                <h2 class="page-title">{{ wordwrap($name->planName,10,"\n",TRUE) }}  </h2>
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
                                                       
                                                        <th style="color: black;"><b>User Name</b></th> 
                                                        <th style="color: black;"><b>User Mobile</b></th> 
                                                        
                                                        <th style="color: black;"><b>Plan Start Date</b></th>
                                                        <th style="color: black;"><b>Plan End Date</b></th>
                                                      
                                                       
                                                       
                



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($app_plan_subscribers))
                                                        @php $i=1 @endphp
                                                        @foreach ($app_plan_subscribers as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b></td>
                                                                <td width="90">{{ $item->name }}</td>
                                                                <td width="90">{{ $item->mobile }}</td>
                                                                <td width="90">{{ $item->startDate }}</td>
                                                                <td width="90">{{ $item->endDate }}</td>
                                                           
                                                               
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
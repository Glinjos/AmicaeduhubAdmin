@extends('admin/adminMaster')

@section('adminpanel')

<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
    function exportToExcel() {
       
        var table = document.getElementById("dataTable-1");
        var workbook = XLSX.utils.table_to_book(table);
        var filename = "report.xlsx";
        XLSX.writeFile(workbook, filename);
      }
    </script>
    
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

    

                    <div class="container-fluid">
                        <div class="row justify-content-center">
                           
                            <div class="col-12">
                                <h2 class="page-title">USERS PAYMENT HISTORY</h2>
                                
                                 <th>
                                    <h4 align="right">
                                        <abbr title="Excel Download"> <button id="btn_btn_btn_print" class="btn btn-primary btn-sm" onclick="exportToExcel()"><i class="fas fa-download"></i>&nbsp;Download</button></abbr>
                                    </h4>
                                  </th>
                                  <style>
                                    .btn.btn-primary.btn-sm {
                                      width: 100px;
                                      height: 25px;
                                    }
                                  </style>
                               
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
                                                        <th style="color: black;"><b>Transaction Number</b></th> 
                                                        <th style="color: black;"><b>Users Name</b></th>
                                                        <th style="color: black;"><b>Subscription Name</b></th>
                                                        <th style="color: black;"><b>Paid Amount</b></th>
                                                       
                



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($payment_his))
                                                        @php $i=1 @endphp
                                                        @foreach ($payment_his as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b></td> 
                                                                <td width="100">{{ $item->startDate }}</td>
                                                                <td width="100">{{ $item->transactionNumber }}</td>
                                                                <td width="100" ><span style="color: rgb(32, 35, 233)">{{ $item->name }}</span>&nbsp;&nbsp;(<b>{{ $item->mobile }}</b>)</td>
                                                                <td width="100">{{ $item->planName }}</td>
                                                                
                                                                <td width="80" align="center">{{ number_format(round( $item->netPayableAmount),2)}}</td>
                                                          
                                                                
                                                            
                                                               
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
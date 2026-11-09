@extends('admin.adminMaster')


@section('adminpanel')


<style>
     .analytics-button {
      background-color: rgb(207, 47, 247);
      color: white;
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    </style>

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
                        <h2 class="mb-2 page-title">Refer Amount</h2>

                        {{-- <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}"> --}}

                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-10">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <table class="table datatables" id="dataTable-1" >
                                            <thead>
                                            <tr style="background-color: lightgray;">
                                                <th style="color: black;"><b>SL NO</b></th>
                                                <th style="color: black;"><b>Refer Amount</b></th>
            
                                                <th style="color: black;"><b>Action</b></th>
                                              

                                            </tr>
                                            </thead>
                                            <tbody>


                                           

                                            <!--LOADER END HERE AFTER LOADING DATA -->



                                            @if(isset($reffer_amount))

                                                @php $i=1; @endphp

                                                @foreach ($reffer_amount as $item)

                                                    <tr  style=color:black;">
                                                        <td width="55"><b>{{$i++}}</b></td>

                                                       

                                                        <td width="45" align="">{{ number_format(round($item->ref_amount, 2), 2) }}
                                                        </td>
                                                      
                                                      
                                                         <td width="55">
                                                         
                                                                <a href="{{url('referamountupdate'.$item->refamount_Id)}}"><button type="button" class="analytics-button">EDIT</button></a>
                                                           
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
            </div>





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
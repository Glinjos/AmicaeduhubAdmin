@extends('staffAdmin.staffAdminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

    

                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            @if(isset($batch_name))
                           
                            @foreach ($batch_name as $item)
                            <div class="col-12">
                                <h2 class="page-title">{{$item->cbatchName}} Batche Day Activities </h2>
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
                                                        <th></th>
                                                        <th style="color: black;"><b>Date</b></th> 
                                                        <th style="color: black;"><b>Course Name</b></th>
                                                        
                                                        <th style="color: black;"><b>Batch Name</b></th>
                                                        <th style="color: black;"><b>Module Name</b></th>
                                                        <th style="color: black;"><b>Submodule Name</b></th>
                                                        <th style="color: black;"><b>Day Name </b></th>
                                                        
                                                        
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($batch_days_details))
                                                        @php $i=1 @endphp
                                                        @foreach ($batch_days_details as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b></td>
                                                            <td  width="10" >
                                                                 {{-- @if( $item->isActive==0)
                                                                    <b style="color: green;font-size:30px ">&#x2022;</b>

                                                                @endif
                                                                @if( $item->isActive==1)
                                                                    <b style="color: red;font-size:30px ">&#x2022;</b>

                                                                @endif --}}
                                                            </td>
                                                                <td width="80">{{ $item->Date}}</td>
                                                                <td width="80">{{ wordwrap($item->coName,20,"\n",TRUE) }}</td>
                                                                <td width="90">{{ wordwrap($item->cbatchName,50,"\n",TRUE) }}</td>
                                                                <td width="90">{{ wordwrap($item->mName,50,"\n",TRUE) }}</td>
                                                                <td width="90">{{ wordwrap($item->smName,50,"\n",TRUE) }}</td>
                                                                <td width="90">{{ $item->dayName }}</td>
                                                                
                                                               
                                                                <td width="60">
                                                                    <abbr style="text-decoration: none;"  title="Delete Day "><a href="{{url('day_ac_delete/'.$item->cbdId)}}" onclick="deleteItem(event, this)" style="text-decoration: none;"><i class="fa fa-trash-o" style="font-size:26px;color:red"></i>
                                                                    </a></abbr>
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
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
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

<script>
    function deleteItem(event, element) {
        event.preventDefault(); // prevent the default link behavior

        // Show the SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure to delete this DAY?',
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



@endsection
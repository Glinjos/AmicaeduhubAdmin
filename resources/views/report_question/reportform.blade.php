@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                @if (session('success'))
                <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
            @endif
            @if (session('error'))
                <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
            @endif
    

                    <div class="container-fluid">
                        <div class="row justify-content-center">
                           
                            <div class="col-12">
                                <h2 class="page-title">User Reported Questions</h2>
                              
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
                                                        <th style="color: black;"><b>Questions</b></th> 
                                                        
                                                        <th style="color: black;"><b>Reporters</b></th>
                                                        
                                                        
                                                        <th style="color: black;"><b>ACTION</b></th>



                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($report))
                                                        @php $i=1 @endphp
                                                        @foreach ($report as $item)
                                                            <tr style="color: black;">

                                                                <td width="65"><b>{{$i++}} </b></td>
                                                          
                                                                @if($item->status == 0)
                                                                <td width="80" style="color: blue">{{ $item->question}}</td>
                                                                @else
                                                                <td width="80">{{ $item->question}}</td>
                                                                @endif
                                                                
                                                                <td width="80">{{ wordwrap($item->usercount,20,"\n",TRUE) }}</td>
                                                               
                                                                
                                                               @if($item->examMode == 3)
                                                                <td width="60">
                                                                    <abbr style="text-decoration: none;"  title="report response"><a href="{{url('show_report_response/'.$item->questionId)}}" style="text-decoration: none;">view
                                                                    </a></abbr>
                                                                    {{-- @if($item->status == 1)
                                                                    <h6 style="color: green">Updated</h6>
                                                                    @endif --}}
                                                                </td>
                                                                @elseif($item->examMode == 2)
                                                                <td width="60">
                                                                    <abbr style="text-decoration: none;"  title="report response"><a href="{{url('show_image_report_response/'.$item->questionId)}}" style="text-decoration: none;">view
                                                                    </a></abbr>
                                                                   
                                                                </td>
                                                                @elseif($item->examMode == 1)
                                                                <td width="60">
                                                                    <abbr style="text-decoration: none;"  title="report response"><a href="{{url('show_previous_report_response/'.$item->questionId)}}" style="text-decoration: none;">view
                                                                    </a></abbr>
                                                                   
                                                                </td>
                                                                @endif
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
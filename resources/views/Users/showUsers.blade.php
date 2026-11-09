@extends('admin/adminMaster')

@section('adminpanel')

<style>
    .custom-pagination-class .pagination {
  display: flex;
  justify-content: center;
    margin-top: 20px;
    }

    .custom-pagination-class .pagination .page-item {
    margin: 0 5px;
    }

    .custom-pagination-class .pagination .page-link {
    padding: 8px 16px;
    background-color: #f2f2f2;
    color: #333;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s;
    }

    .custom-pagination-class .pagination .page-link:hover {
    background-color: #e0e0e0;
    }

    .custom-pagination-class .pagination .page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    }

    .custom-pagination-class .pagination .page-item.disabled .page-link {
    opacity: 0.5;
    pointer-events: none;
    }

   


    .search-input {
  /* width: 30px; */
  padding: 10px;
  height: 40%;
  width: 30%;
    margin-top:4%; 
  border: 1px solid #2e1818;
  border-radius: 1px;
  font-size: 16px;
}

.search-input:focus {
  outline: none;
  border-color: #1e333a;
}

.align-right {
  text-align: right;
}



    </style>

<div class="wrapper">
    <main role="main" class="main-content">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="page-title">Users Details</h2>
                    

                        <div class="col-11">
                            
                                <div class="row">
                                    <div class="input-group" >
                                        <input placeholder="  Search Here..." id="searchUser" name="searchUser" class="search-input" type="text">
                                   
                                    <div class="col-md-6 my-4" >
                                        
                                        <div class="card shadow" style="margin-left: 10%;">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <strong class="card-title">TOTAL USERS</strong>
                                                    </div>
                                                    <p class="small mb-0">
                                                        <strong>
                                                            <span class="{{ $count_users && $count_users->count_of_users > 0 ? 'text-success' : 'text-danger' }}" style="width: 100px; display: inline-block;">
                                                                {{ $count_users ? $count_users->count_of_users : 0 }}
                                                            </span>
                                                        </strong>
                                                    </p>
                                                    <div class="col-4 text-right">
                                                        <span class="sparkline inlineline"></span>
                                                    </div>
                                                </div> <!-- /.row -->
                                            </div> <!-- /.card-body -->
                                        </div> <!-- /.card -->
                                    </div> <!-- /.col-md-4 -->
                                </div>
                            </div>


                            



                       

                        
                    </div>
                    
                    
            
                   
                    <style>
                        .card {
                            max-height: 270px; /* Adjust this value to your desired height */
                           
                        }
                    
                        .card-body {
                            padding: 10px; /* Add some padding to the card body */
                        }
                    </style>
                           
                           <style>
                            .text-muted {
                                font-size: 12px; /* Adjust the font size as needed */
                            }

                            /* .analytics-button {
                            background-color: blue;
                            color: white;
                            padding: 5px 8px;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            } */
                            .analytics-button {
                            background-color: blue;
                            color: white;
                            padding: 5px 10px;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            }
                            
                        </style>
                        

                    
                   
                    
                    
                    
                     
                        <div id="bresult">
                            @if(isset($Users))
                                <div class="row items-align-baseline">
                                    

                                    @foreach($Users as $userDetails)
                                        <div class="col-md-3 col-lg-2"> <!-- Adjust column size as needed -->
                                            <div class="card shadow eq-card mb-2">
                                                <div class="card-body">
                                                    <div class="chart-box mx-3 text-center">
                                                        @if(!empty($userDetails->userImage))
                                                            <img src="{{ asset('public/assets/userImage/' . $userDetails->userImage) }}" alt="" width="50" height="50" class="circle">
                                                        @else
                                                            <img src="{{ asset('assets/userImage/defaultUserImage.png') }}" alt="" width="50" height="50" class="circle">
                                                        @endif
                                                    </div>
                                                    <div class="row items-align-baseline">
                                                        <div class="col-md-12 my-3 text-center">
                                                            <h6>{{ $userDetails->name}}</h6>
                                                            <p class="text-muted">{{$userDetails->userEmail}} <br> {{$userDetails->mobile}} <br>{{ $userDetails->dob }}
                                                                @if(isset($selectdistrict))
                                                                    @foreach($selectdistrict as $dist)
                                                                        @if($userDetails->district_Id == $dist->district_Id)
                                                                            <br>   {{$dist->district_name}}
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                <br>  OTP - {{ $userDetails->otp }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="border-top py-2 text-center">
                                                    <a href="{{url('analyticsShow'.$userDetails->uId)}}"><button type="button" class="analytics-button">Analytics</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                </div>
                           
                        </div>
                        
                        
                        
                    
                            <div class="d-flex justify-content-center">
                                <div class="pagination custom-pagination-class">
                                    {{ $Users->onEachSide(2)->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    
                    
                        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="{{ asset('path/to/jquery-3.6.0.min.js') }}"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

                        <!-- or -->

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
                        <script src="{{ asset('path/to/jquery-3.6.0.min.js') }}"></script>
                        {{-- <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/js/all.min.js" crossorigin="anonymous"></script> --}}


                
                        <script>
                            $(document).ready(function() {
                                $('#searchUser').on('keyup', function() {
                                    var selectedVal = $(this).val();
                                    //alert(selectedVal);
                                    var baseUrl = '{{ url('') }}'; // Update to use Blade syntax for the base URL
                        
                                    $.ajax({
                                        type: 'get',
                                        url: baseUrl + '/searchusers',
                                        data: {
                                            'selvalue': selectedVal
                                        },
                                        success: function(data) {
                                           // alert(data);
                                            $('#bresult').html(data);
                                        },
                                        error: function(xhr, status, error) {
                                            console.log(xhr.responseText); // Log the error response for debugging
                                        }
                                    });
                                });
                            });
                        </script>
                        
                    
                    
                    
  




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







    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    

@endsection
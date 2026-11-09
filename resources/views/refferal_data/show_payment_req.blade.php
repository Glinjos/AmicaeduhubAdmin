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
                        <h2 class="mb-2 page-title">Payment Requests</h2>

                        <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">

                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-10">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <table class="table datatables" id="dataTable-1" >
                                            <thead>
                                            <tr style="background-color: lightgray;">
                                                <th style="color: black;"><b>SL NO</b></th>
                                                <th style="color: black;"><b>Date</b></th>
                                                <th style="color: black;"><b>User Name</b></th>
                                                <th style="color: black;"><b>Coins</b></th>
                                                <th style="color: black;"><b>Remark</b></th>
            
                                                <th style="color: black;"><b>Action</b></th>
                                              

                                            </tr>
                                            </thead>
                                            <tbody>


                                           

                                            <!--LOADER END HERE AFTER LOADING DATA -->



                                            @if(isset($pay_req))

                                                @php $i=1; @endphp

                                                @foreach ($pay_req as $item)

                                                    <tr  style=color:black;">
                                                        <td width="55"><b>{{$i++}}</b></td>

                                                       

                                                       
                                                        <td width="45" align="">{{ date('Y-m-d', strtotime($item->req_date)) }}</td>
                                                        
                                                        <td width="45" align="">{{ $item->name }}</td>
                                                        <td width="45" align="">{{ $item->req_coin }}</td>
                                                        <td width="45" align="">{{ $item->remark }}</td>
                                                      
                                                      
                                                         <td width="55">
                                                         
                                                            @if($item->isRequested ==0)


                                                                <abbr style="text-decoration: none;" title="Approve">
                                                                    <a href="{{ url('userrequestapprove/'.$item->request_Id.session('user_id')) }}" style="text-decoration: none;" onclick="activeItem(event, this)">
                                                                        <span style="display: inline-block; width: 26px; height: 26px; line-height: 26px; text-align: center; border-radius: 50%; background-color: green;">
                                                                            <span style="color: white; font-size: 16px;">&#10004;</span>
                                                                        </span>
                                                                    </a>
                                                                </abbr>

                                                             @else
                                                             

                                                            <abbr style="text-decoration: none;" title="Accepted">
                                                                <span style="display: inline-block; width: 26px; height: 26px; line-height: 26px; text-align: center; border-radius: 50%; background-color: green;">
                                                                    <span style="color: white; font-size: 16px;">👍</span>
                                                                </span>
                                                                
                                                                                                             
                                                            </abbr>
                    
                                                           
                                                            @endif
                                                                &nbsp;&nbsp;
                                                           {{-- <abbr style="text-decoration: none;" title="View More"><span onclick="return userBankDetails('{{ $item->req_user_Id }}')" style="color: green;" class="fe fe-24 fe-more-horizontal" ></span></abbr>
                                                      --}}
                                                      <abbr style="text-decoration: none;" title="Bank Details">
                                                      <a href="javascript:void(0);" onclick="return userBankDetails('{{ $item->req_user_Id }}')" style="text-decoration: none; color: blue;">View</a>       
                                                      </abbr>
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





            

            {{--User Bnk modal--}}

            <div class="modal fade" id="user_bank_details" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="defaultModalLabel">BANK DETAILS</h5><p id="nameinview"  name="nameinview">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <table>
                               
                                <div style="display: none">
                                    
                                    <p id="bnk-details"  name="bnk-details" style="font-weight: bold;color:rgb(224, 65, 65);" disabled></p>
                                    
                                </div>
                                <tr>
                                    <br>
                                    <b style="color: black;">AC HOLDER NAME :</b>
                                    <p id="acholdername"  name="acholdername" style="font-weight: bold;color:rgb(224, 65, 65);" disabled></p>
                                    
                                </tr>
                                <tr>
                                    <br>
                                    <b style="color: black;">ACCOUNT NUMBER :</b>
                                    <p id="acnumber"  name="acnumber" style="font-weight: bold;color:rgb(224, 65, 65);" disabled></p>
                                    <br>
                                </tr>
                                <tr>

                                    <b style="color: black;">UPI NUMBER :</b>
                                    <p id="upinumber"  name="upinumber" style="font-weight: bold;color:rgb(224, 65, 65);" disabled></p>
                                    <br>
                                </tr>

                                <tr>

                                    <b style="color: black;">UPI ID :</b>
                                    <p id="upiId"  name="upiId" style="font-weight: bold;color:rgb(224, 65, 65);" disabled></p>
                                    <br>
                                </tr>

                                <tr>

                                    <b style="color: black;">UPI CODE :</b>
                                    <p id="upicode"  name="upicode" style="font-weight: bold;color:rgb(224, 65, 65);" disabled></p>
                                    <br>
                                </tr>

                                <tr>

                                    <b style="color: black;">REMARKS :</b>
                                    <p id="remark"  name="remark" style="font-weight: bold;color:rgb(90, 134, 190);" disabled></p>
                                    <br>
                                </tr>
                               
                                <div class="modal-footer">
                                   

                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

             {{-- End --User Bnk modal--}}


               {{--NULL User Bnk modal--}}

            <div class="modal fade" id="null_user_bank_details" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="defaultModalLabel">BANK DETAILS</h5><p id="nameinview"  name="nameinview">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <table>
                               
                                <table>
                                    <tr>
                                        <td colspan="colspan_value">
                                            <p style="font-weight: bold; color:rgb(224, 65, 65);" disabled>
                                                User didn't send bank details
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                
                                
                               
                                <div class="modal-footer">
                                   

                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

             {{-- End --NULL User Bnk modal--}}






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


<script>
    function activeItem(event, element) {
        event.preventDefault(); // prevent the default link behavior

        // Show the SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure to Approve this User Request?',
            text : 'If you verify that the users bank details are correct, then confirm and approve. There should be no possibility of a comeback.',
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

<script>
    function inactiveItem(event, element) {
        event.preventDefault(); // prevent the default link behavior

        // Show the SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure to Refuse this User Request?',
           
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


    

<script>
    // SCRIPT TO SHOW WINNERS TO SHOW MODEL
    function userBankDetails(req_user_Id) {
    
        //alert(req_user_Id);

            $.ajax({
                url: "{{url('/users_details_bnk')}}",
                type: "GET",
                data: {
                    req_user_Id: req_user_Id,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {

                    if (result)
                    {
                            if (result.length > 0) {
                                document.getElementById("acholdername").innerHTML = result[0].ac_holder_name;
                                document.getElementById("acnumber").innerHTML = result[0].ac_number;
                                document.getElementById("upinumber").innerHTML = result[0].upi_number;
                                document.getElementById("upiId").innerHTML = result[0].upi_id;
                                document.getElementById("upicode").innerHTML = result[0].ifc_code;
                                document.getElementById("remark").innerHTML = result[0].remark;
                                document.getElementById("nameinview").innerHTML = result[0].name;

                                $('#user_bank_details').modal('show');

                            } else {
                               // alert('hai');
                               var bnkDetailsElement = document.getElementById("bnk-details");
                                  // bnkDetailsElement.style.display = 'block'; 
                                   // bnkDetailsElement.innerHTML = "User didn't send bank details";

                                $('#null_user_bank_details').modal('show');
                            }
                    }

                   
                
                }
            })
            }
</script>



@endsection
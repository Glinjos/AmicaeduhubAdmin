@extends('admin/adminMaster')

@section('adminpanel')





    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <h2 class="mb-2 page-title">Users Added Questions Count</h2>
                <div class="row justify-content-center">
                    <div class="col-12">
                       
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-md-4" >
                                          <label style="color: black;">
                                            From Date
                                            <span class="text-danger">*</span>
                                          </label>
                                          <div class="input-group">
                                            <input type="date" name="" id="from_search" class="form-control" max="{{date('Y-m-d')}}">
                                            <script>
                                                var today = new Date();
                                                today.setDate(1); // Set the day to 1
                                                today.setMonth(today.getMonth() - 1);
                                                var formattedDate = today.toISOString().substr(0, 10);
                                                document.getElementById('from_search').value = formattedDate;
                                            </script>
                                          </div>
                                          <span id="from_date_error" class="text-danger"></span>
                                        </div>
                        
                                        <div class="col-md-4">
                                            <label style="color: black;">
                                              To Date
                                              <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                              <input type="date" name="" id="to_search" class="form-control" value="{{date('Y-m-d')}}">
                                            </div>
                                        </div>
                         
                                        <div class="col-md-2">
                                            <label class="h6 large d-block text-uppercase"></label>
                                               
                                                <span class=" text-hide">!</span>
                                                <div class="input-group">
                                                    <button  name="" id="" class="form-control btn btn-primary" onclick="return report_monthly();" >search</button>
                                                </div>
                                            
                                        </div>
                                    
                
                                      
                                    </div> <!-- /.row -->
                                </div>
                            </div>
                       
                    </div> <!-- / .card -->
                </div>
                
                <script>
                   
                    window.onload = function() {
                        report_monthly();
                    };

                    function report_monthly()
                    {
                       
                        var from_search = document.getElementById("from_search").value;
                        var to_search = document.getElementById("to_search").value;

                        
                        if(from_search =="" || to_search ==""){

                            document.getElementById('from_date_error').innerHTML="please select a date";

                        }else{
                            document.getElementById('from_date_error').innerHTML="";


                        $.ajax({
                            url: "{{url('/report_useraddedquest_monthwise')}}",
                            type: "POST",
                            data: {
                                from_search   : from_search,
                                to_search     : to_search,
                                _token: '{{csrf_token()}}'
                            },
                            success: function(result)
                            {
                                if (result) {
                                    // Clear the table body
                                    $('#dataTable-1 tbody').empty();

                                   
                                   
                                //    var reportHeader =`<tr style="background-color: white;">
                                //             <th style="color: black;"><b></b></th>
                                //             <th style="color: black;"><b></b></th>
                                //             <th style="color: black;"><b> REPORT on ${from_search} to ${to_search}</b></th>
                                //             <th style="color: black;"><b></b></th>
                                //             <th style="color: black;"><b></b></th>
                                //         </tr>`
                                var reportHeader = '<tr><td style="text-align: center; border: none;" colspan="9"><h4>REPORT on ' + from_search + ' to ' + to_search + '</h4></td></tr>';
                                    var newTableHeader = `
                                        <tr style="background-color: lightgray;">
                                            <th style="color: black; text-align: center;" colspan="1"><b>SL NO</b></th>
                                            <th style="color: black;" colspan="2"><b>Name</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>Main Exam</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>ME Approved</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>Previous Exam</b></th>
                                             <th style="color: black; text-align: center;" colspan="1"><b>PQ Approved</b></th>
                                            <th style="color: black; text-align: center;" colspan="1"><b>Video Class Exam</b></th>
                                             <th style="color: black; text-align: center;" colspan="1"><b>VC Approved</b></th>
                                        </tr>`;

                                   
                                    $('#dataTable-1 thead').html(reportHeader + newTableHeader);

                                    result.forEach(function (item, index) {
                                        $('#dataTable-1 tbody').append(
                                            '<tr>' +
                                            '<td style="color: black; text-align: center;" colspan="1">' + (index + 1) + '</td>' +
                                            '<td style="color: black;" colspan="2">' + item.name + '</td>' +
                                            '<td style="color: black; text-align: center;" colspan="1">' + item.cq_count + '</td>' +
                                            '<td style="color: black; text-align: center;" colspan="1">' + item.mexam_approved + '</td>' +
                                            '<td style="color: black; text-align: center;" colspan="1">' + item.pq_count + '</td>' +
                                            '<td style="color: black; text-align: center;" colspan="1">' + item.pq_approved + '</td>' +
                                            '<td style="color: black; text-align: center;" colspan="1">' + item.vcq_count + '</td>' +
                                            '<td style="color: black; text-align: center;" colspan="1">' + item.vcq_approved + '</td>' +
                                            '</tr>'
                                        );
                                    });//result
                                }//if(result)
                            }//successs

                            })
                        }
                }//final
                    
                </script>


                </div>


                &nbsp;&nbsp;&nbsp;
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                
                                <div class="row my-4" >
                                    <!-- Small table -->
                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <!-- table -->
                                              
                                                <table class="datatables" width="100%" border="1px" style="background-color:white" id="dataTable-1">
                                                   
                                                    <thead>
                                                   
                                                    </thead>
                                                    <tbody>
                                                   
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







    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='js/jquery.dataTables.min.js'></script>
    <script src='js/dataTables.bootstrap4.min.js'></script>
    {{-- <script>
        $('#dataTable-1').DataTable(
            {
                autoWidth: true,
                "lengthMenu": [
                    [50, 100, 200, -1],
                    [50, 100, 200, "All"]
                ]
            });
    </script> --}}





    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    
   

@endsection
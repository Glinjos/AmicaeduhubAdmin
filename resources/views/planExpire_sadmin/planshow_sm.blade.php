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
                    <h2 class="page-title">Users Plan Expires</h2>
                    <div id="alert"></div>

                    

                        <div class="col-11">
                            
                                <div class="row">
                                    <div class="input-group" >
                                        <input placeholder="  Search Here..." id="searchUser" name="searchUser" class="search-input" type="text" >
                                   
                                    
                                </div>
                            </div>


                          



                       

                        
                    </div>
                    
                    
            
                   
                
                        
          <br><br>
                    <div style="overflow-x: auto;">
                        <table class="datatables" width="100%" border="1px" style="background-color:white; display: none;" id="dataTable-1" >
                                                   
                            <thead>
                                <tr style="background-color: lightgray;">
                                    <th style="color: black; text-align: center;" colspan="1"><b>SL NO</b></th>
                                    <th style="color: black;" colspan="1"><b>Name</b></th>
                                    <th style="color: black;" colspan="1"><b>Mobile</b></th>
                                    <th style="color: black; text-align: center;" colspan="1"><b>Plan Name</b></th>
                                    <th style="color: black; text-align: center;" colspan="1"><b>From Date</b></th>
                                    <th style="color: black; text-align: center;" colspan="1"><b>To Date</b></th>
                                    <th style="color: black; text-align: center;" colspan="1"><b>Expired</b></th>
                                    <th style="color: black; text-align: center;" colspan="1"><b>Action</b></th>
                                </tr>
                           
                            </thead>
                            <tbody>
                           
                            </tbody>
                        </table>
                    </div>
                   
                    
                    
                    
                     
                    
                    
                     
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                      

                
                       
                        <script>
                           $(document).ready(function() {
                            $('#searchUser').on('keyup', function() {
                                var selectedVal = $(this).val();
                                var baseUrl = '{{ url('') }}';

                                $.ajax({
                                    type: 'get',
                                    url: baseUrl + '/searchusersplans',
                                    data: {
                                        'selvalue': selectedVal
                                    },
                                    success: function(result) {
                                       // console.log(result);

                                        var $dataTable = $('#dataTable-1 tbody');
                                        $dataTable.empty();
                                        $('#dataTable-1').show();
                                        if (selectedVal !== '' && result.checkUser.length > 0) {
                                            result.checkUser.forEach(function(item, index) {
                                                //console.log(item);

                                                $dataTable.append(
                                                    '<tr>' +
                                                    '<td style="color: black; text-align: center;" colspan="1">' + (index + 1) + '</td>' +
                                                    
                                                    '<td style="color: darkblue;" colspan="1">' + item.name + '</td>' +
                                                    '<td style="color: darkblue; text-align:center;" colspan="1">' + item.mobile + '</td>' +
                                                    '<td style="color: black;text-align:center;" colspan="1">' +
                                                        '<select name="planId" id="planId_' + item.apsId +'" class="plan-name-dropdown">' +
                                                            generatePlanOptions(result.planNames, item.planName) +
                                                        '</select>' +
                                                    '</td>' +

                                                    '<td style="color: black; text-align: center;" colspan="1">' +
                                                    '<input type="date" name="startDate" id="startDate_' + item.apsId + '" value="' + item.startDate + '" min="' + getCurrentDate() + '">' +
                                                    '</td>' +
                                                    '<td style="color: black; text-align: center;" colspan="1">' +
                                                    '<input type="date" name="endDate" id="endDate_' + item.apsId + '" value="' + item.endDate + '" min="' + getCurrentDate() + '">' +
                                                    '</td>' +
                                                    '<td id="statuscell_' + item.apsId + '"   style="color: ' + (item.isExpired == 0 ? 'green' : 'red') + '; text-align: center;" colspan="1">' +
                                                        (item.isExpired == 0 ? 'Active' : 'Expired') +
                                                    '</td>' +
                                                    '<td style="color: black; text-align: center;" colspan="1">' +
                                                        '<button class="button" style="background-color:blue;color:white;"  onclick="updateval(event, this, \'' + item.name + '\', \'' + item.apsId + '\',document.getElementById(\'planId_' + item.apsId + '\').value ,document.getElementById(\'startDate_' + item.apsId + '\').value,document.getElementById(\'endDate_' + item.apsId + '\').value)">Update</button>' +
                                                    '</td>'+
                                                    
                                                    '<input type="hidden" name="apsId" id="apsIds" value="' + item.apsId + '">' +
                                                   
                                                    '</tr>'
                                                );
                                            });
                                        } else {
                                           // console.log('No data found.');
                                           
                                            $('#dataTable-1').hide();
                                            $dataTable.empty();
                                           //alert('No data found.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                       // console.log(xhr.responseText);
                                        //$dataTable.empty();
                                    }
                                });
                            });
                        });
                        function generatePlanOptions(planNames, selectedPlan) {
                            let options = '<option value="" disabled>Select a Plan</option>';

                            planNames.forEach(function(plan) {
                                options += '<option value="' + plan.planId + '"' + (selectedPlan === plan.planName ? ' selected' : '') + '>' + plan.planName + '</option>';
                            });

                            return options;
                        }

                     
                            function getCurrentDate() {
                                var today = new Date();
                                var dd = String(today.getDate()).padStart(2, '0');
                                var mm = String(today.getMonth() + 1).padStart(2, '0'); 
                                var yyyy = today.getFullYear();

                                return yyyy + '-' + mm + '-' + dd;
                            }
                        



                        </script>
                    
                    
                    
 



                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function updateval(event, element, selectedName ,selectedApsId,selectedPlanId,selectedstartDate,selectedendDate) {
            event.preventDefault(); 
            
            var name = selectedName; 
            var apsId = selectedApsId;
            var planId =selectedPlanId;
            var startDate =selectedstartDate;
            var endDate =selectedendDate;
           // alert(apsIds);
          
            Swal.fire({
                title: 'Are you sure to Extend this plan?',
                text: 'Double-check the plan and dates because the update process is going to activate '+ name +'s plan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    // var planId =document.getElementById('planId').value;
                    // var startDate =document.getElementById('startDate').value;
                    // var endDate =document.getElementById('endDate').value;
                   // var apsId =document.getElementById('apsId').value;
                  // alert(planId);
                    // console.log('planId'+planId);
                    // console.log(startDate);
                    // console.log(endDate);
                    //  console.log('apsId'+apsId);
                    if(planId == "" || planId == null){
                        alert('please select a plan.');
                        return false;
                    }else if(startDate == "" || startDate == null){
                        alert('please select a start date.');
                        return false;
                    }else if(endDate == "" || endDate == null){
                        alert('please select a end date.');
                        return false;
                    }else if(apsId == "" || apsId == null){
                        alert('updation failed.');
                        return false;
                    }else{

                    var baseUrl = '{{ url('') }}';

                   ///////
                    $.ajax({
                        type: 'get',
                        url: baseUrl + '/update_user_plan_extend',
                        data: {
                            'planId': planId,
                            'startDate': startDate,
                            'endDate': endDate,
                            'apsId': apsId,
                        },
                        success: function(result) {
                            // console.log(result.getAPPplanExpirestatus);
                            // console.log('AJAX response:', result.status);
                            if ($('#alert').length) {
                                if (result.status === 'success') {
                                   
                                    $('#alert').html('<h6 class="alert alert-success" id="alert">' +
                                        '<button type="button" class="close" data-dismiss="alert">x</button>' +
                                        'Update successful</h6>');
                                } else {
                                    
                                    $('#alert').html('<h6 class="alert alert-danger" id="alert">' +
                                        '<button type="button" class="close" data-dismiss="alert">x</button>' +
                                        'Update failed</h6>');
                                }
                            } else {
                               // console.log('not found');
                            }
                       
                        var updatedStatusColor = result.getAPPplanExpirestatus.isExpired == 0 ? 'red' : 'green';
                        var updatedStatusText = result.getAPPplanExpirestatus.isExpired == 0 ? 'Expired' : 'Active';
                        var $updatedStatusCell = $('#statuscell_' + apsId);


                       // console.log('apsId'+apsId);
                       // console.log(updatedStatusText);
                        $updatedStatusCell.css('color', updatedStatusColor);
                        $updatedStatusCell.html(updatedStatusText);

                        },
                        error: function(xhr, status, error) {
                           // console.log(xhr.responseText);
                            //$dataTable.empty();
                      }
                 });

                    }
                    
                   

                }               
            });
        }
    </script>

   









@endsection
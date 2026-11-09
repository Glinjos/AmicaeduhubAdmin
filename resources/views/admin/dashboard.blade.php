@extends('admin/adminMaster')

@section('adminpanel')



        {{--<img src="../assets/images/dashboard.jpg" alt="dashboard"  width="1330" height="650">--}}

        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="row align-items-center mb-2">
                            <div class="col">
                                <h2 class="h2 page-title">Welcome &nbsp; {{session('name')}}</h2>
                            </div>
                            
                            
                            
                             @if(isset($checkNotification) && $checkNotification[0]->unanswered_questions > 0)
                            <abbr title="Notification" class="notification-icon-container" onclick="showPopupNotification()" data-toggle="modal" data-target="#listViewModal">
                                <span class="fa-stack">
                                    <span class="fa fa-bell"></span>
                                    <span id="notification-dot" class="fa fa-circle fa-stack-2x" style="font-size: 10px; top: 8px; right: 6px;"></span>
                                </span>
                            </abbr>
                        @else
                            <abbr style="text-decoration: none;" title="Notification" onclick="showPopupNotification()" data-toggle="modal" data-target="#listViewModal">
                                <span style="color: rgb(160, 157, 157); font-size: 25px;" class="fa fa-bell"></span>
                            </abbr>
                        @endif


                        <!-- Include jQuery -->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        
                        <!-- The Modal -->
                        <div class="modal" id="listViewModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                        
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h6 class="modal-title">Chat Notifications</h6>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                        
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <ul id="listView"></ul>
                                    </div>
                        
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fetch data using jQuery AJAX -->
                        <script>
                            $(document).ready(function(){
                              //  console.log('Document ready');
                                $.ajax({
                                    url: "/show-list-view-latest-questions",
                                    type: "GET",
                                    success: function(response) {
                                        //console.log('Ajax success:', response);
                        
                                        // Check if response is an array
                                        if (response && Array.isArray(response)) {
                                           // console.log('Type of response:', typeof response);
                        
                                            var listView = $("#listView");
                        
                                            $.each(response, function(index, item) {
                                                // Log each item to check the data
                                               // console.log('Item:', item);
                        
                                                // Attempt to append data
                                               // listView.append("<li><strong>" + item.name + "</strong><br> " + item.unanswered + " Message</li>");
                                               listView.append("<li><strong style='font-size: 16px;'>" + item.name + "</strong><br> " + item.unanswered + " Message</li>");
                        
                        
                                            });
                                        } else {
                                           // console.log('Invalid response format or missing data property.');
                                        }
                                    },
                                    error: function(error) {
                                       // console.log('Ajax error:', error);
                                    }
                                });
                            });
                        </script>
                        
                        
                        
                        
                        
                        
                        <!-- Include Bootstrap JS after jQuery -->
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <script>
                            window.onload = function() {
                                showPopupNotification();
                            };
                        </script>
                        

                        
                        <div id="popup-notification" class="popup">
                            <span class="popup-content">
                                <!-- Add your notification content here -->
                                You have {{$checkNotification[0]->unanswered_questions}} unanswered questions.
                            </span>
                        </div>

                        <script>
                            function showPopupNotification() {
                                var popup = document.getElementById('popup-notification');
                                popup.classList.toggle('show');
                                setTimeout(function() {
                                    popup.classList.remove('show');
                                }, 2000);
                                
                                 }

                        </script>

                        
                        <style>
                            /* Add some basic styling for the popup */
                            .popup {
                                display: none;
                                position: fixed;
                                bottom: 10px;
                                right: 10px;
                                background-color: #333;
                                color: white;
                                padding: 10px;
                                border-radius: 5px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            }

                            .popup.show {
                                display: block;
                            }

                        </style>
                        
                        
                        <style>
                            .notification-container {
                            position: relative;
                        }
                
                        .notification-icon-container {
                            color: rgb(14, 12, 12);
                            font-size: 25px;
                        }
                
                        #notification-dot {
                            color: red;
                            position: absolute;
                            top: 0;
                            right: 0;
                        }
                        </style>
                            
                            
                            
                            
                            

                        </div>











                       
                        <div class="mb-2 align-items-center">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <h5 style="color:blue">&nbsp;MAIN EXAM</h5>
                                    <div class="row mt-1 align-items-center">
                                        @if(isset($module))
                                        @foreach ($module as $item)
                                        <div class="faq-card" style="background-color: navy;color:#f9f9f9; ">
                                            <div class="faq-question">
                                                <h3 style="color:#f9f9f9; font-size: 16px;">{{$item->mName}}</h3>&nbsp;
                                                <i class="fas fa-caret-down" style="padding: 5px; font-size: 22px;" onclick="toggleAdditionalData('faq-data-{{$item->mId}}')"></i>
                                            </div>
                                            <div class="additional-data" id="faq-data-{{$item->mId}}" style="display: none">
                                                <!-- Additional data related to the FAQ goes here -->
                                                <p class="appent_data"></p>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            function toggleAdditionalData(id) {
                                var additionalData = $("#" + id);
                        
                                if (additionalData.is(":visible")) {
                                    additionalData.hide();
                                } else {
                                    $(".additional-data").hide();
                                    additionalData.show();
                        
                                    // Check if the data is already loaded; if not, fetch it
                                    if (!additionalData.data("loaded")) {
                                        $.ajax({
                                            url: "{{url('/main_exam_totalcount_geting')}}",
                                            type: "GET",
                                            data: {
                                                m_Id: id.match(/\d+/)[0],
                                                _token: '{{csrf_token()}}'
                                            },
                                            success: function(result) {
                                                if (result && result.counts !== undefined && result.total_count !== undefined) {
                                                    const counts = result.counts;
                                                    const total_count = result.total_count;
                        
                                                    var dataToAppend = '<table>';
                        
                                                    if (total_count[0].total_approved === 0 && total_count[0].total_pending === 0) {
                                                        alert('No data or unexpected data received');
                                                    } else {
                                                        dataToAppend += '<thead><tr><th>Sub Module</th><th>Approved</th><th></th><th></th><th>UnApproved</th></tr></thead>';
                                                        dataToAppend += '<tbody>';
                        
                                                        counts.forEach(function(item) {
                                                            dataToAppend += '<tr>';
                                                            dataToAppend += '<td>' + item.smName + '</td>';
                                                            dataToAppend += '<td align="center">' + item.question_approved + '</td>';
                                                            dataToAppend += '<td></td>';
                                                            dataToAppend += '<td></td>';
                                                            dataToAppend += '<td align="center">' + item.question_pending + '</td>';
                                                            dataToAppend += '</tr>';
                                                        });
                        
                                                        dataToAppend += '<tr>';
                                                        dataToAppend += '<td><b>TOTAL</b></td>';
                                                        dataToAppend += '<td align="center"><b>' + total_count[0].total_approved + '</b></td>';
                                                        dataToAppend += '<td></td>';
                                                        dataToAppend += '<td></td>';
                                                        dataToAppend += '<td align="center"><b>' + total_count[0].total_pending + '</b></td>';
                                                        dataToAppend += '</tr>';
                                                    }
                        
                                                    dataToAppend += '</tbody>';
                                                    dataToAppend += '</table>';
                        
                                                    additionalData.find(".appent_data").html(dataToAppend);
                        
                                                    // Mark as loaded to avoid reloading on subsequent clicks
                                                    additionalData.data("loaded", true);
                                                } else {
                                                    alert('No data or unexpected data received');
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                // Handle AJAX error here
                                                alert('Error occurred during your request: ' + error);
                                            }
                                        });
                                    }
                                }
                            }
                        </script>
                        
                        <style>
                            /* styles.css */
                            .faq-card {
                                border: 1px solid #ccc;
                                margin: 5px;
                                padding: 5px;
                                background-color: #f9f9f9;
                            }
                        
                            .faq-question {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                            }
                        
                            .toggle-answer {
                                background-color: #007bff;
                                color: white;
                                border: none;
                                padding: 5px 10px;
                                cursor: pointer;
                            }
                        
                            .faq-answer {
                                display: none;
                            }
                        </style>
                        
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5 style="color:blue">PREVIOUS EXAM (CSEB)</h5>
                                <div class="row mt-1 align-items-center">
                                    @if(isset($pqcseb))
                                    @foreach ($pqcseb as $item)
                                    <div class="faq-card" style="background-color: navy;color:#f9f9f9; ">
                                        <div class="faq-question">
                                            <h3 style="color:#f9f9f9; font-size: 16px;">{{$item->pqmName}}</h3>&nbsp;
                                            <i class="fas fa-caret-down" style="padding: 5px; font-size: 22px;" onclick="toggleAdditionalDataCseb('faq-data-cseb-{{$item->pqmId}}')"></i>
                                        </div>
                                        <div class="additional-data-pqcseb" id="faq-data-cseb-{{$item->pqmId}}" style="display: none">
                                            <!-- Additional data related to the FAQ goes here -->
                                            <p class="appent_data_cseb"></p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            function toggleAdditionalDataCseb(id) {
                                var additionalData = $("#" + id);
                        
                                if (additionalData.is(":visible")) {
                                    additionalData.hide();
                                } else {
                                    $(".additional-data-pqcseb").hide();
                                    additionalData.show();
                        
                                    // Check if the data is already loaded; if not, fetch it
                                    if (!additionalData.data("loaded")) {
                                        $.ajax({
                                            url: "{{url('/pqcseb_totalcount_geting')}}",
                                            type: "GET",
                                            data: {
                                                pqmId_cseb_Id: id.match(/\d+/)[0],
                                                _token: '{{csrf_token()}}'
                                            },
                                            success: function(result) {
                                                if (result && result.counts_cseb !== undefined && result.total_count_cseb !== undefined) {
                                                    const counts_cseb = result.counts_cseb;
                                                    const total_count_cseb = result.total_count_cseb;
                        
                                                    var dataToAppend = '<table>';
                        
                                                    if (total_count_cseb[0].total_approved === 0 && total_count_cseb[0].total_pending === 0) {
                                                        alert('No data or unexpected data received');
                                                    } else {
                                                        dataToAppend += '<thead><tr><th>Category</th><th>Approved</th><th></th><th></th><th>UnApproved</th></tr></thead>';
                                                        dataToAppend += '<tbody>';
                        
                                                        counts_cseb.forEach(function(item) {
                                                            dataToAppend += '<tr>';
                                                            dataToAppend += '<td>' + item.pqsmName + '</td>';
                                                            dataToAppend += '<td align="center">' + item.question_approved_cseb + '</td>';
                                                            dataToAppend += '<td></td>';
                                                            dataToAppend += '<td></td>';
                                                            dataToAppend += '<td align="center">' + item.question_pending_cseb + '</td>';
                                                            dataToAppend += '</tr>';
                                                        });
                        
                                                        dataToAppend += '<tr>';
                                                        dataToAppend += '<td><b>TOTAL</b></td>';
                                                        dataToAppend += '<td align="center"><b>' + total_count_cseb[0].total_approved + '</b></td>';
                                                        dataToAppend += '<td></td>';
                                                        dataToAppend += '<td></td>';
                                                        dataToAppend += '<td align="center"><b>' + total_count_cseb[0].total_pending + '</b></td>';
                                                        dataToAppend += '</tr>';
                                                    }
                        
                                                    dataToAppend += '</tbody>';
                                                    dataToAppend += '</table>';
                        
                                                    additionalData.find(".appent_data_cseb").html(dataToAppend);
                        
                                                    // Mark as loaded to avoid reloading on subsequent clicks
                                                    additionalData.data("loaded", true);
                                                } else {
                                                    alert('No data or unexpected data received');
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                // Handle AJAX error here
                                                alert('Error occurred during your request: ' + error);
                                            }
                                        });
                                    }
                                }
                            }
                        </script>
                        
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5 style="color:blue">PREVIOUS EXAM (PSC)</h5>
                                <div class="row mt-1 align-items-center">
                                    @if(isset($pqpsc))
                                    @foreach ($pqpsc as $item)
                                    <div class="faq-card" style="background-color: navy;color:#f9f9f9; ">
                                        <div class="faq-question">
                                            <h3 style="color:#f9f9f9; font-size: 16px;">{{$item->pqmName}}</h3>&nbsp;
                                            <i class="fas fa-caret-down" style="padding: 5px; font-size: 22px;" onclick="toggleAdditionalDataPsc('faq-data-psc-{{$item->pqmId}}')"></i>
                                        </div>
                                        <div class="additional-data-pqpsc" id="faq-data-psc-{{$item->pqmId}}" style="display: none">
                                            <!-- Additional data related to the FAQ goes here -->
                                            <p class="appent_data_psc"></p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        function toggleAdditionalDataPsc(id) {
                            var additionalData = $("#" + id);
                    
                            if (additionalData.is(":visible")) {
                                additionalData.hide();
                            } else {
                                $(".additional-data-pqpsc").hide();
                                additionalData.show();
                    
                                // Check if the data is already loaded; if not, fetch it
                                if (!additionalData.data("loaded")) {
                                    $.ajax({
                                        url: "{{url('/pqpsc_totalcount_geting')}}",
                                        type: "GET",
                                        data: {
                                            pqmId_psc_Id: id.match(/\d+/)[0],
                                            _token: '{{csrf_token()}}'
                                        },
                                        success: function(result) {
                                            if (result && result.counts_psc !== undefined && result.total_count_psc !== undefined) {
                                                const counts_psc = result.counts_psc;
                                                const total_count_psc = result.total_count_psc;
                    
                                                var dataToAppend = '<table>';
                    
                                                if (total_count_psc[0].total_approved === 0 && total_count_psc[0].total_pending === 0) {
                                                    alert('No data or unexpected data received');
                                                } else {
                                                    dataToAppend += '<thead><tr><th>Category</th><th>Approved</th><th></th><th></th><th>UnApproved</th></tr></thead>';
                                                    dataToAppend += '<tbody>';
                    
                                                    counts_psc.forEach(function(item) {
                                                        dataToAppend += '<tr>';
                                                        dataToAppend += '<td>' + item.pqsmName + '</td>';
                                                        dataToAppend += '<td align="center">' + item.question_approved_psc + '</td>';
                                                        dataToAppend += '<td></td>';
                                                        dataToAppend += '<td></td>';
                                                        dataToAppend += '<td align="center">' + item.question_pending_psc + '</td>';
                                                        dataToAppend += '</tr>';
                                                    });
                    
                                                    dataToAppend += '<tr>';
                                                    dataToAppend += '<td><b>TOTAL</b></td>';
                                                    dataToAppend += '<td align="center"><b>' + total_count_psc[0].total_approved + '</b></td>';
                                                    dataToAppend += '<td></td>';
                                                    dataToAppend += '<td></td>';
                                                    dataToAppend += '<td align="center"><b>' + total_count_psc[0].total_pending + '</b></td>';
                                                    dataToAppend += '</tr>';
                                                }
                    
                                                dataToAppend += '</tbody>';
                                                dataToAppend += '</table>';
                    
                                                additionalData.find(".appent_data_psc").html(dataToAppend);
                    
                                                additionalData.data("loaded", true);
                                            } else {
                                                alert('No data or unexpected data received');
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            alert('Error occurred during your request: ' + error);
                                        }
                                    });
                                }
                            }
                        }
                    </script>
                        












                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div>

                    </div>
                </div>
            </div>
        </main>


@endsection
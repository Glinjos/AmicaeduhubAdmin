@extends('admin/adminMaster')

@section('adminpanel')
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Add Users Payments</h2>

                        <form action="{{ url('save_user_payment_ami') }}" id="mform" method="POST">
                            @csrf
                            <div class="card shadow mb-4">
                                @if (session('success'))
                                    <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                @endif
                                @if (session('error'))
                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">User Name</b></label>
                                                <select name="user_name_pay" id="user_name_pay" class="form-control" onchange="return userPayAmountCheck()">
                                                    <option align="center" disabled selected value=" ">--- Request Accepted Users---</option>
                                                    @if(isset($get_pay_request_user))
                                                        @foreach($get_pay_request_user as $data)
    
                                                            <option value="{{$data->request_Id}}" id="demo" > {{ $data->name}}</option>
                                                               
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span id="user_name_pay-error" class="text-danger"></span>

                                            </div>

                                            <input type="hidden" id="req_user_Id" name="req_user_Id" value="">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="simpleinput"><b style="color: black;">Amount</b></label>
                                                       
                                                        <input  id="user_pay_amount" name="user_pay_amount" placeholder="Credit Amount"  value=""  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" readonly>
                                   
                                                        <span id="user_pay_amount-error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="simpleinput"><b style="color: black;">Date</b></label>
                                                        <input type="date" id="user_pay_date" name="user_pay_date" value="{{ date('Y-m-d') }}" placeholder="Enter module name"  class="form-control">
                                                        @if ($errors->has('user_pay_date'))
                                                            <span class="text-danger">{{ $errors->first('user_pay_date') }}</span>
                                                        @endif
                                                        <span id="user_pay_date-error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            

                                            <button type="button" id="btn" onclick="return saveBtnvalidation()" class="btn btn-primary">SAVE</button>
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- / .card -->
                    <br>

                    


                </div>
            </div>
        </main> <!-- main -->
    </div>
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

    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->
    <!---------------FORM JAVASCRIPT VALIDATION FOR Module Code-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>

        function userPayAmountCheck(){

            $(document).ready(function () {
                user_name_pay = document.getElementById('user_name_pay').value;
               
                if (user_name_pay == null||user_name_pay==""){
                    document.getElementById("user_name_pay-error").innerHTML = "This field is required.";
                    return false;
               
                }else{
                    document.getElementById("user_name_pay-error").innerHTML = "";

                }
                $.ajax({
                    url: "{{url('/check_user_credit_amount')}}",
                    type: "GET",
                    data: {
                        user_name_pay: user_name_pay,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(result) {

                        if (result) {
                        var reqCoin = result[0].req_coin;
                        var req_user_Id = result[0].req_user_Id;
                        
                        $("#user_pay_amount").prop('readonly', true).val(reqCoin);

                        $("#req_user_Id").prop('readonly', true).val(req_user_Id);

                        } else {
                            alert('Your Request Is Failed Check Later.')
                        }
                       
                            
                    },
                    error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }

                });



              

                $("#btn").on("click", function() {
                    $(this).attr("disabled", "disabled");

                     //this method contains your logic
                    $(this).html("Saving...");

                    $("#mform").submit()


                });
            });
        }

</script>

   <script>
        function saveBtnvalidation()
        {
            user_name_pay = document.getElementById('user_name_pay').value;
            user_pay_amount = document.getElementById('user_pay_amount').value;
            user_pay_date = document.getElementById('user_pay_date').value;

                if (user_name_pay == null||user_name_pay==" "){
                    document.getElementById("user_name_pay-error").innerHTML = "This field is required.";
                    return false;
               
                }else{
                    document.getElementById("user_name_pay-error").innerHTML = "";

                }
                if (user_pay_amount == null||user_pay_amount==""){
                    document.getElementById("user_pay_amount-error").innerHTML = "This field is required.";
                    return false;
               
                }else{
                    document.getElementById("user_pay_amount-error").innerHTML = "";

                }
                if (user_nauser_pay_dateme_pay == null||user_name_pay==""){
                    document.getElementById("user_pay_date-error").innerHTML = "This field is required.";
                    return false;
               
                }else{
                    document.getElementById("user_pay_date-error").innerHTML = "";

                }

        }

    </script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
   

@endsection
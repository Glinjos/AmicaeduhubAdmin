@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                        <h2 class="page-title">Edit Refer Amount</h2>

                        <form action="{{ url('updateamountrefer') }}" id="cform" method="POST" >
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                            <div class="card shadow mb-4">
                                @if (session('success'))
                                    <h6 class="alert alert-success" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('success') }}</h6>
                                @endif
                                @if (session('error'))
                                    <h6 class="alert alert-danger" id="alert"><button type="button" class="close" data-dismiss="alert">x</button>{{ session('error') }}</h6>
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                           @if(isset($update_refamount))
                                           @foreach($update_refamount as $item)
                                            <div class="form-group mb-3">
                                                <label for="simpleinput"><b style="color: black;">Amount</b></label>
                                                <input type="number" id="ref_amount" name="ref_amount" value="{{$item->ref_amount}}" onkeyup="return amountvalidation();" placeholder="Enter Amount" class="form-control" >
                                                @if ($errors->has('ref_amount'))
                                                    <span class="text-danger">{{ $errors->first('ref_amount') }}</span>
                                                @endif
                                                <span id="ref_amount-error" class="text-danger"></span>

                                            </div>
                                            <input type="hidden" id="refamount_Id" name="refamount_Id" value="{{ $item->refamount_Id }}">
                                            @endforeach
                                            @endif
                                            <button type="submit" id="btn" onclick="return validation();"  class="btn btn-primary" >SAVE</button>
                                        </div> <!-- /.col -->

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                 

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

    function validation()
    {
        var amount = document.getElementById('ref_amount').value;

        if(amount == "")
        {
            document.getElementById("ref_amount-error").innerHTML = "This field is required.";
            return false;
        }
        else
        {
            document.getElementById("ref_amount-error").innerHTML = "";
            return true;
        }

   
    }

    function amountvalidation()
    {
        var amount = document.getElementById('ref_amount').value;

        if(amount == "")
        {
            document.getElementById("ref_amount-error").innerHTML = "This field is required.";
            return false;
        }
        else
        {
            document.getElementById("ref_amount-error").innerHTML = "";
            return true;
        }
    }

</script>


    




@endsection
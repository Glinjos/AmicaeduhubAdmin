@extends('admin/adminMaster')

@section('adminpanel')

    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-12">

                       

                        @if(isset($user_name))
                        @foreach($user_name as $namess)

                        <h4 class="page-title">{{$namess->name}}</h4>

                        @endforeach

                        <h2 class="page-title">Payments History</h2>
                            
                        @endif


                       
                    </div>

                    <br>

                    <style>
                        .dataTable th {
                            text-align: center;
                        }
                    </style>

                    <div class="container-fluid">
                        <div class="row justify-content-center">

                            <div class="col-12">
                                <h2 class="page-title"></h2>
                                <div class="row my-4">
                                    <!-- Small table -->
                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            <div class="card-body">

                                                <!-- table -->
                                                <table  class="dataTable" border="2px" style="display:block" id="table_sales">
                                                    <thead>
                                                        <tr style="background-color: rgb(85, 19, 129)">
                                                            <th align="center"  width="5%"  style="color: rgb(255, 255, 255)"><b>Sl No</b></th>
                                                            <th align="center"  width="20%"  style="color: rgb(255, 255, 255)"><b>Date</b></th>
                                                            <th align="center"  width="25%" style="color: rgb(255, 255, 255)"><b>Debit</b></th>
                                                            <th align="center" width="25%"  style="color: rgb(255, 255, 255)"><b>Credit</b></th>
                                                            <th align="center" width="15%" style="color: rgb(255, 255, 255)"><b>Remark</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table_sales_body">
                                                        @if(isset($ledger))
                                                        @php $i=1 @endphp
                                                        @foreach ($ledger as $item)
                                                            <tr style="color: black;">

                                                                <td width="65" align="center"><b>{{$i++}} </b></td>
                                                               
                                                                <!--<td width="100" align="center">{{ $item->date }}</td>-->
                                                                <td width="100" align="center">{{ date('Y-m-d', strtotime($item->date)) }}</td>
                                                                
                                                                <td width="60" align="right">{{ number_format(round($item->user_debit),2) }}</td>
                                                                <td width="50" align="right">{{ number_format(round($item->user_credit),2) }}</td>
                                                                <td width="70" align="center">{{ wordwrap($item->remark ,20,"\n",TRUE) }}</td>
                                                               
                                                                
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

    <!---------------FORM JAVASCRIPT VALIDATIONS----------------------->
    <!---------------FORM JAVASCRIPT VALIDATION FOR Module Code-------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        
    {{-- <script>
        function user_payments_monthly_report(){
           
            var from_date_sale = document.getElementById("from_date_sale").value;
            var to_date_sale   = document.getElementById("to_date_sale").value;
            
            $.ajax({
                url: "{{url('/search_report_sales')}}",
                type: "PUT",
                data: {
                    from_date_sale   : from_date_sale,
                    to_date_sale     : to_date_sale,
                    _token: '{{csrf_token()}}'
                },
            
                
                success: function(result)
                {
                    if (result) {
                        
                      
                        var totalprice=bank_balance=cash_balance=credit_balance=price=total_quantity=0;
                        
                         document.getElementById('table_sales').style.display= "";
                         const tableBody=document.getElementById('table_sales_body');

                                tableBody.innerHTML = "";

                                result.forEach((data, index) => {

                                    var total      = parseFloat(data.total_price);
                                    var unit_price = parseFloat(data.unit_price);
                                    var total_qty  = parseFloat(data.quantity);
                                    
                                    const row = document.createElement("tr");

                                    const cell_date         = document.createElement("td");
                                    const cell_product_name = document.createElement("td");
                                    const cell_seller_name  = document.createElement("td");
                                    const cell_unit_price   = document.createElement("td");
                                    const cell_qty          = document.createElement("td");
                                    const cell_total_price  = document.createElement("td");
                                    const cell_bank         = document.createElement("td");
                                    const cell_cash         = document.createElement("td");
                                    const cell_credit       = document.createElement("td");

                                    cell_date.textContent         = data.sale_date;
                                    cell_product_name.textContent = data.get_product_name[0].product_name;
                                    cell_seller_name.textContent  = data.get_seller_name[0].seller_name;
                                    cell_unit_price.textContent   = data.unit_price;
                                    cell_qty.textContent          = data.quantity;
                                    cell_total_price.textContent  = data.total_price;
                                    var bank = cash = credit = 0;
                                    if(data.payment_mode == 1){
                                        var bank = data.total_price ? data.total_price : '';
                                      cell_bank.textContent         =bank;
                                      
                                    }else if(data.payment_mode == 0){
                                        var cash = data.total_price ? data.total_price : ''; 
                                      cell_cash.textContent         = cash;
                                      
                                    }else{
                                        var credit=data.total_price ? data.total_price : '';
                                       cell_credit.textContent       = credit;
                                      
                                    }

                                    cell_unit_price.style.textAlign = "right";
                                    cell_qty.style.textAlign = "right";
                                    cell_total_price.style.textAlign = "right";
                                    cell_cash.style.textAlign = "right";
                                    cell_bank.style.textAlign = "right";
                                    cell_credit.style.textAlign = "right";

                                    row.appendChild(cell_date);
                                    row.appendChild(cell_product_name);
                                    row.appendChild(cell_seller_name);
                                    row.appendChild(cell_unit_price);
                                    row.appendChild(cell_qty);
                                    row.appendChild(cell_total_price);
                                    row.appendChild(cell_bank);
                                    row.appendChild(cell_cash);
                                    row.appendChild(cell_credit);

                                tableBody.appendChild(row);

                                price          = parseFloat(price)         + parseFloat(unit_price);
                                total_quantity = parseFloat(total_quantity)+ parseFloat(total_qty);
                                totalprice     = parseFloat(totalprice)    + parseFloat(total);
                                bank_balance   = parseFloat(bank_balance)  + parseFloat(bank);
                                cash_balance   = parseFloat(cash_balance)  + parseFloat(cash);
                                credit_balance = parseFloat(credit_balance)+ parseFloat(credit);
                                });

                                //console.log(totalprice);
                                const row2                 = document.createElement("tr");
                                const cell1                = document.createElement("td");
                                const cell2                = document.createElement("td");
                                const cell3                = document.createElement("td");
                                const cell_sum_unitprice   = document.createElement("td");
                                const cell_sum_qty         = document.createElement("td");
                                const cell_total_price     = document.createElement("td");
                                const cell_bank_balance    = document.createElement("td");
                                const cell_cash_balance    = document.createElement("td");
                                const cell_credit_balance  = document.createElement("td");

                                cell3.textContent                = "TOTAL";
                                cell_sum_unitprice.textContent   = "";
                                cell_sum_qty.textContent         = total_quantity;
                                cell_total_price.textContent     = totalprice;
                                cell_bank_balance.textContent    = bank_balance;
                                cell_cash_balance.textContent    = cash_balance;
                                cell_credit_balance.textContent  = credit_balance;

                                cell_sum_unitprice.style.textAlign  = "right";
                                cell_sum_qty.style.textAlign        = "right";
                                cell_total_price.style.textAlign    = "right";
                                cell_bank_balance.style.textAlign   = "right";
                                cell_cash_balance.style.textAlign   = "right";
                                cell_credit_balance.style.textAlign = "right";
                               
                               row2.appendChild(cell1);
                               row2.appendChild(cell2);
                               row2.appendChild(cell3);
                               row2.appendChild(cell_sum_unitprice);
                               row2.appendChild(cell_sum_qty);
                               row2.appendChild(cell_total_price);
                               row2.appendChild(cell_bank_balance);
                               row2.appendChild(cell_cash_balance);
                               row2.appendChild(cell_credit_balance);

                               tableBody.appendChild(row2);
                               priceseparator();
                      
                    }
                }
            })}
    </script> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.js"></script>
   

@endsection
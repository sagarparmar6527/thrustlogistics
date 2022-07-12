<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OUTSTANDING RECEIVABLES</title>
    <link rel="stylesheet" href="{{asset('admin/css/horizontal-layout-light/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/stylelogindash.css')}}">
</head>
<body>
    <div class="container-fluid back-white">
        <div class="row justify-content-between">
           <div class="col-lg-4 col-md-4 col-12">
              <div class="logoblock-pdf">
                 <a class="navbar-brand brand-logo"
                    ><img src="{{asset('admin/images/logo.png')}}" alt="logo"
                    /></a>
              </div>
           </div>
           <div class="col-lg-4 col-md-4 col-6">
              <p>
                 TEL: (416) 293 0008 <br>
                 Email: accounting@thrustlogistics.com<br>
                 Web: www.thrustlogics.com<br>
                 Date: 2022-04-04
              </p>
           </div>
        </div>
        <div class="row mt-4">
           <h4 class="text-center">
              OUTSTANDING RECEIVABLES
           </h4>
           <div class="col-lg-12 mt-3">
              <table class="table table-responsive table-oustanding">
                 <thead>
                    <tr>
                       <th>Invoice ID</th>
                       <th>Invoice Date</th>
                       <th>Days</th>
                       <th>Amount (CAD)</th>
                       <th>Amount (USD)</th>
                    </tr>
                 </thead>
                 <tbody>
                    @foreach ($receivable as $customer => $invoice)
                        @php 
                           $arrKey = json_decode($customer);
                        @endphp
                        <tr class="company-row">
                           <td colspan="3">{{ $arrKey->company }}</td>
                           <td>{{ $arrKey->phone }}</td>
                           <td>{{ $arrKey->fax }}</td>
                        </tr>
                        @php
                        $amount = 0;
                        @endphp
                        @foreach ($invoice as $info)
                           @php 
                              $amount += $info['amount'];
                           @endphp
                           <tr class="details-row">
                              <td>{{ $info['id'] }}</td>
                              <td>{{ $info['invoice_date'] }}</td>
                              <td>-{{ $info['days'] }}</td>
                              <td>${{ $info['amount'] }}</td>
                              <td>---</td>
                           </tr>   
                        @endforeach
                        
                        <tr class="company-footer">
                           <td colspan="3"></td>
                           <td >${{ $amount }}</td>
                           <td >$0.00</td>
                        </tr>   
                    @endforeach
                 </tbody>
                 <tr>
                 </tr>
                 </tbody>
              </table>
           </div>
        </div>
     </div>
</body>
</html>
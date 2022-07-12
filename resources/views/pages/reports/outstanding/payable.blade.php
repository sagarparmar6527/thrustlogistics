<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OUTSTANDING PAYABLES</title>
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
                 Date: {{ date('Y-m-d') }}
              </p>
           </div>
        </div>
        <div class="row mt-4">
           <h4 class="text-center">
              OUTSTANDING PAYABLES
           </h4>
           <div class="col-lg-12 mt-3">
              <table class="table table-responsive table-oustanding">
                 <thead>
                    <tr>
                       <th>Invoice Date</th>
                       <th>Invoice No</th>
                       <th>Category</th>
                       <th>Amount (CAD)</th>
                       <th>Amount (USD)</th>
                    </tr>
                 </thead>
                 <tbody>
                    @foreach ($payable as $payableName => $payment)
                        <tr class="company-row">
                           <td colspan="3">{{ $payableName }}</td>
                        </tr>
                        @php
                        $cadTotal = 0.00;
                        $usdTotal = 0.00;
                        @endphp
                        @foreach ($payment as $info)
                            @if($info['currency'] == "CAD")
                                @php $cadTotal += $info['invoice_total']; @endphp
                            @else
                                @php $usdTotal += $info['invoice_total']; @endphp
                            @endif
                           <tr class="details-row">
                              <td>{{ $info['invoice_date'] }}</td>
                              <td>{{ $info['invoice_no'] }}</td>
                              <td>-{{ $info['category'] }}</td>
                              <td>{{ ($info['currency'] == "CAD") ? '$'.$info['invoice_total'] : '---' }}</td>
                              <td>{{ ($info['currency'] == "USD") ? '$'.$info['invoice_total'] : '---' }}</td>
                           </tr>   
                        @endforeach
                        
                        <tr class="company-footer">
                           <td colspan="3"></td>
                           <td >${{ $cadTotal }}</td>
                           <td >${{ $usdTotal }}</td>
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
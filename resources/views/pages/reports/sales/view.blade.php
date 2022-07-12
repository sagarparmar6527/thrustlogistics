<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SALES REPORT</title>
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
                    TEL: (416) 293 0008<br />
                    FAX: accounting@thrustlogistics.com<br />
                    thrustlogistics.com<br />
    
                    Date: {{ date('Y-m-d') }}
                </p>
            </div>
        </div>
    
        <div class="row mt-4">
            <h4 class="text-center">
                SALES REPORT
                <span class="date">(from {{ $from_date }} to {{ $to_date }})</span>
            </h4>
            <div class="col-lg-12 mt-3">
                <table class="table table-responsive table-oustanding">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Invoice Date</th>
                            <th style="width: 50%">Customer</th>
                            <th>Currency</th>
                            <th>Sub Total</th>
                            <th>GST</th>
                            <th>HST</th>
                            <th>Fuel</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $cadSubTotal = 0.00;
                            $cadGst = 0.00;
                            $cadHst = 0.00;
                            $cadFuel = 0.00;
                            $cadTotal = 0.00;

                            $usdSubTotal = 0.00;
                            $usdGst = 0.00;
                            $usdHst = 0.00;
                            $usdFuel = 0.00;
                            $usdTotal = 0.00;
                        @endphp
                        @foreach($sales as $value)
                            @php
                                $subTotal = (($value->charge_total) - ($value->charge_gst + $value->charge_hst + $value->charge_fuel));
                            @endphp
                            @if($value->currency->code == "CAD")
                                @php
                                    $cadSubTotal += $subTotal;
                                    $cadGst += $value->charge_gst;
                                    $cadHst += $value->charge_hst;
                                    $cadFuel += $value->charge_fuel;
                                    $cadTotal += $value->charge_total;
                                @endphp
                            @else
                                @php
                                    $usdSubTotal += $subTotal;
                                    $usdGst += $value->charge_gst;
                                    $usdHst += $value->charge_hst;
                                    $usdFuel += $value->charge_fuel;
                                    $usdTotal += $value->charge_total;
                                @endphp
                            @endif
                            <tr class="details-row">
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->invoice_date }}</td>
                                <td>{{ $value->customer->company }}</td>
                                <td>{{ $value->currency->code }}</td>
                                <td>${{ number_format($subTotal,2) }}</td>
                                <td>${{ $value->charge_gst }}</td>
                                <td>${{ $value->charge_hst }}</td>
                                <td>${{ $value->charge_fuel }}</td>
                                <td>${{ $value->charge_total }}</td>
                            </tr>
                        @endforeach
                        <tr class="details-row">
                            <td colspan="4"><b>CAD</b></td>
                            <td>${{ number_format($cadSubTotal,2) }}</td>
                            <td>${{ number_format($cadGst,2) }}</td>
                            <td>${{ number_format($cadHst,2) }}</td>
                            <td>${{ number_format($cadFuel,2) }}</td>
                            <td>${{ number_format($cadTotal,2) }}</td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="4"><b>USD</b></td>
                            <td>${{ number_format($usdSubTotal,2) }}</td>
                            <td>${{ number_format($usdGst,2) }}</td>
                            <td>${{ number_format($usdHst,2) }}</td>
                            <td>${{ number_format($usdFuel,2) }}</td>
                            <td>${{ number_format($usdTotal,2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
</body>
</html>
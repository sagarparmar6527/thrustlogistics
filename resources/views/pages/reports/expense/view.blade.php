<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>EXPENSE REPORT</title>
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
                            <th>Invoice Date</th>
                            <th style="width: 50%">Payable Name</th>
                            <th>Category</th>
                            <th>Cheque</th>
                            <th>Currency</th>
                            <th>Sub Total</th>
                            <th>GST</th>
                            <th>HST</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $cadSubTotal = 0.00;
                            $cadGst = 0.00;
                            $cadHst = 0.00;
                            $cadTotal = 0.00;

                            $usdSubTotal = 0.00;
                            $usdGst = 0.00;
                            $usdHst = 0.00;
                            $usdTotal = 0.00;
                        @endphp
                        @foreach($expense as $value)
                            @php
                                $subTotal = (($value->charge_total) - ($value->charge_gst + $value->charge_hst));
                            @endphp
                            @if($value->currency->code == "CAD")
                                @php
                                    $cadSubTotal += $subTotal;
                                    $cadGst += ($value->invoice_tax_type == 'GST') ? $value->invoice_tax : 0.00;
                                    $cadHst += ($value->invoice_tax_type == 'HST') ? $value->invoice_tax : 0.00;
                                    $cadTotal += $value->invoice_total;
                                @endphp
                            @else
                                @php
                                    $usdSubTotal += $subTotal;
                                    $usdGst += $value->charge_gst;
                                    $usdHst += $value->charge_hst;
                                    $usdTotal += $value->invoice_total;
                                @endphp
                            @endif
                            <tr class="details-row">
                                <td>{{ $value->invoice_date }}</td>
                                <td>{{ (isset($value->payable->company)) ? $value->payable->company : ''; }}</td>
                                <td>{{ (isset($value->category->name)) ? $value->category->name : ''; }}</td>
                                <th>{{ $value->paid_chq }}</th>
                                <td>{{ $value->currency->code }}</td>
                                <td>${{ number_format($subTotal,2) }}</td>
                                <td>${{ ($value->invoice_tax_type == 'GST') ? $value->invoice_tax : 0.00; }}</td>
                                <td>${{ ($value->invoice_tax_type == 'HST') ? $value->invoice_tax : 0.00 }}</td>
                                <td>${{ $value->invoice_total }}</td>
                            </tr>
                        @endforeach
                        <tr class="details-row">
                            <td colspan="5"><b>CAD</b></td>
                            <td>${{ number_format($cadSubTotal,2) }}</td>
                            <td>${{ number_format($cadGst,2) }}</td>
                            <td>${{ number_format($cadHst,2) }}</td>
                            <td>${{ number_format($cadTotal,2) }}</td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="5"><b>USD</b></td>
                            <td>${{ number_format($usdSubTotal,2) }}</td>
                            <td>${{ number_format($usdGst,2) }}</td>
                            <td>${{ number_format($usdHst,2) }}</td>
                            <td>${{ number_format($usdTotal,2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
</body>
</html>
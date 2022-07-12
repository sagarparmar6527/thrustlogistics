<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INVOICE PRINT</title>
    <link rel="stylesheet" href="{{asset('admin/css/horizontal-layout-light/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/stylelogindash.css')}}">
</head>
<body>
    <div class="container-fluid back-white">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-4 col-md-4 col-12">
                <div class="logoblock-pdf">
                    <a class="navbar-brand brand-logo"
                        ><img src="{{asset('admin/images/logo.png')}}" alt="logo"
                    /></a>
                </div>
            </div>
    
            <div class="col-lg-4 col-md-4 col-6">
                <p>
                    PO Box# 95078<br/>
                    Stouffville, ON, L4A 1J1<br/>
                    CANADA<br/>
                    TEL: (416) 293 0008 <br />
                    Email: accounting@thrustlogistics.com
                </p>
            </div>
            <div class="col-lg-4 col-md-4 col-6">
                <h4>Invoice</h4>
            </div>
        </div>
    
        <div class="row mt-4">
            <div class="col-lg-6 col-md-6 col-12 mt-3">
                <table class="table table-responsive table-oustanding">
                    <tbody>
                        <tr class="details-row">
                            <td><b>Bill To:</b></td>
                            <td>
                                <b>{{ $objData->customer->company }} </b><br />
                                {{ $objData->customer->address }}<br />
                                {{ $objData->customer->city }}, {{ $objData->customer->state }}, {{ $objData->customer->postal }}<br/>
                                {{ $objData->customer->country->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mt-3">
                <table
                    class="table table-responsive table-oustanding table-carrier"
                >
                    <thead>
                        <tr>
                            <th>Invoice Date:</th>
                            <th>Invoice #:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="details-row">
                            <td>{{ $objData->invoice_date }}</td>
                            <td>{{ $objData->id }}</td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="2">HST # 683473465 7365348 745</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4 justify-content-end">
            <div class="col-lg-1 col-md-1 col-3 mt-3">
                <table class="table table-responsive table-oustanding">
                    <tbody>
                        <tr class="details-row">
                            <td>
                                <b>Terms:</b>
                            </td>
                        </tr>
                        <tr class="details-row">
                            <td>NET {{ $objData->terms }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-12 mt-3">
                <div class="table-block-here">
                    <table class="table table-responsive table-oustanding">
                        <thead>
                            <tr>
                                <th>Date:</th>
                                <th>Order Id:</th>
                                <th>Pcs:</th>
                                <th>Service:</th>
                                <th>Waybill/Ref:</th>
                                <th style="width: 200px">Adjustments:</th>
                                <th>Amount:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="details-row">
                                <td>{{ date('Y-m-d',strtotime($objData->order->order_datetime)) }}</td>
                                <td>{{ $objData->order->id }}</td>
                                <td>{{ $objData->order->pcs }}</td>
                                <td>{{ $objData->order->service->name }}</td>
                                <td>{{ $objData->order->ref_number }}</td>
                                <td>{{ $objData->order->adjustments }}</td>
                                <td>${{ $objData->order->total_charges }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mt-1">
                <p>Thanks for your business</p>
                <p>Please visit us at www.assurecartage.com</p>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mt-1">
                <div class="table-block-here">
                    <table class="table table-responsive table-oustanding">
                        <thead>
                            <tr>
                                <th>Sub Total</th>
                                <th>HST</th>
                                <th>Fuel Charge</th>
                                <th>Total</th>
                                <th>Currency</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="details-row">
                                <td>${{ number_format(($objData->charge_total - ($objData->charge_hst + $objData->charge_fuel))) }}</td>
                                <td>${{ $objData->charge_hst }}</td>
                                <td>${{ $objData->charge_fuel }}</td>
                                <td>${{ $objData->charge_total }}</td>
                                <td>{{ $objData->currency->code }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    
            <div class="col-12 mt-1">
                <p class="bottom-p">
                    Terms: {{ $objData->terms }} net days. Due Date: {{ date('Y-m-d', strtotime($objData->invoice_date. ' + '.$objData->terms.' day')) }}. Interest of 2% per
                    month (24% per annum) on off past due accounts.
                </p>
            </div>
        </div>
    </div>          
</body>
</html>
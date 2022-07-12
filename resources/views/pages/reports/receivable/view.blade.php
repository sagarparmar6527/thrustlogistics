<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ACCOUNTS RECEIVABLE AGING REPORT</title>
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
                    TEL: (416) 293 0008 <br />
                    FAX: accounting@thrustlogistics.com <br />
                    thrustlogistics.com Date: {{ date('Y-m-d') }}
                </p>
            </div>
        </div>
    
        <div class="row mt-4">
            <h4 class="text-center">ACCOUNTS RECEIVABLE AGING REPORT</h4>
            <div class="col-lg-12 mt-3">
                <table class="table table-responsive table-oustanding">
                    <thead>
                        <tr>
                            <th style="width: 60%">Customer Name</th>
                            <th>Total Accts. Rec.</th>
                            <th>Current</th>
                            <th>1-30 Days Past Due</th>
                            <th>31-60 Days Past Due</th>
                            <th>Over 60 Days Past Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $total = 0.00;
                        @endphp
                        @foreach($receivable as $value)
                            @php 
                                $total += $value['charge_total'];
                            @endphp
                            <tr class="details-row">
                                <td>{{ $value['customer'] }}</td>
                                <td>${{ $value['charge_total'] }}</td>
                                <td>${{ $value['charge_total'] }}</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="details-row">
                            <td><b>Total (CAD):</b></td>
                            <td>${{ $total }}</td>
                            <td>${{ $total }}</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>     
</body>
</html>
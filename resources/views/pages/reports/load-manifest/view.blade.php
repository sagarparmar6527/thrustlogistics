<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LOAD MANIFEST</title>
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
            <div class="col-lg-2 col-md-4 col-6">
                <h5>Please deliver to:</h5>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <p>
                    1st Drop:<br />
                    @if($drop1)
                        {{ $drop1->company }}<br />
                        {{ $drop1->address }}<br />
                        {{ $drop1->city }} {{ $drop1->state }} {{ $drop1->postal }}<br />
                        Tel.: {{ $drop1->phone }}<br />
                        Fax.: {{ $drop1->fax }}
                    @else
                        N/A	
                    @endif
                </p>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <p>
                    2st Drop:<br />
                    @if($drop2)
                        {{ $drop2->company }}<br />
                        {{ $drop2->address }}<br />
                        {{ $drop2->city }} {{ $drop2->state }} {{ $drop2->postal }}<br />
                        Tel.: {{ $drop2->phone }}<br />
                        Fax.: {{ $drop2->fax }}
                    @else
                        N/A	
                    @endif
                </p>
            </div>
        </div>
    
        <div class="row mt-4">
            <h4 class="text-center">
                LOAD MANIFEST -
                <span class="id">{{ $ref_number }}</span>
            </h4>
            <div class="col-lg-12 mt-3">
                <table class="table table-responsive table-oustanding">
                    <thead>
                        <tr>
                            <th>Load</th>
                            <th>Del. Date</th>
                            <th style="width: 30%">Consignee</th>
                            <th>Phone No.</th>
                            <th>Skids</th>
                            <th>Weight</th>
                            <th style="width: 70%">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalLb = 0.00;
                        @endphp
                        @foreach($loadManifest as $value)
                        <tr class="details-row">
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->from_date }}</td>
                            <td>{{ $value->to_company }} / {{ $value->to_city }} , {{ $value->to_state }}</td>
                            <td>{{ $value->to_phone }}</td>
                            <td>{{ $value->pcs }}</td>
                            <td>{{ $value->weight }}</td>
                            <td>{{ $value->comments }}</td>
                        </tr>
                        @php 
                            $totalLb += $value->weight;
                        @endphp
                        @endforeach
                        <tr class="details-row">
                            <td colspan="4"></td>
                            <td>Total (lb.)	</td>
                            <td>{{ $totalLb }}</td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="2">RECEIVED BY</td>
                            <td colspan="3"></td>
                            <td>Date</td>
                            <td colspan="1"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</body>
</html>
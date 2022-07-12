<form id="submit-form" action="javascript:void(0)" class="form-customer" method="POST" autocomplete="off">
    <div class="container-fluid">
       <div class="row">
          <div class="col-12">
             <div class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center">
                <h3 class="card-title m-0">{{ $pageName }}</h3>
                <div class="d-flex topbtns">
                  <button type="button" class="ms-3 goBack">Back</button> 
                </div>
             </div>
             <h5 class="form-details">Payment Details</h5>
          </div>
          <div class="col-md-6">
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Customer:</label>
                <div class="col-9">
                   <b>{{ $objData->ipayment->customer->company }}</b>
                </div>
             </div>
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Payment Date / Type:</label>
                <div class="col-9">
                   {{ $objData->ipayment->payment_date }}
                   {{ $objData->ipayment->payment_type->abbreviation }}
                </div>
             </div>
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Payment Details (like ChqNo):</label>
                <div class="col-9">
                   {{ $objData->ipayment->payment_desc }}
                </div>
             </div>
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Comments:</label>
                <div class="col-9">
                   {{ $objData->ipayment->payment_comments }}
                </div>
             </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Payment Amount:</label>
                <div class="col-9">
                   {{ $objData->paid_amount }} <b>{{ $objData->ipayment->currency->code }}</b>
                </div>
            </div>
          </div>
          <div class="col-md-12">
            <table id="carrierstable" class="display expandable-table" style="width: 100%">
                <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Date</th>
                    <th>Amount Paid</th>
                    <th>Exchange Rate</th>
                    <th>Total Amt Paid</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $objData->invoice_id }}</td>
                        <td>{{ $objData->invoice->invoice_date }}</td>
                        <td>{{ $objData->paid_amount }} <b>{{ $objData->ipayment->currency->code }}</b></td>
                        <td>x 1.000000</td>
                        <td>{{ $objData->paid_amount }} <b>{{ $objData->ipayment->currency->code }}</b></td>
                    </tr>
                    <td><b>Total:</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>{{ $objData->paid_amount }} {{ $objData->ipayment->currency->code }}</b></td>
                </tr>
                </tbody>
            </table>
        </div>
       </div>
    </div>
 </form>

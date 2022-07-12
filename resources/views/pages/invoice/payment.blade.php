<form id="submit-form" action="{{ $action }}" class="form-customer" method="POST" autocomplete="off">
    @csrf
    <input type="hidden" name="customer_id" value="{{ $objData->customer_id }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center">
                <h3 class="card-title m-0">{{ $pageName }}</h3>
                <div class="d-flex topbtns">
                    <button>Save</button>
                    <button type="button" class="ms-3 goBack">Cancel</button>
                </div>
                </div>
                <h5 class="form-details">{{ $pageName }} Details</h5>
            </div>
            <div class="col-md-8">
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-3">Customer:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <b>{{ $objData->customer->company }}</b>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="payment_date" class="col-lg-3 col-md-3 col-3 require">Payment Date / Type:</label>
                    <div class="col-lg-5 col-md-5 col-5">
                        <input type="date" class="form-control" id="payment_date" name="payment_date" required/>
                    </div>
                    <div class="col-lg-4 col-md-4 col-4">
                        <select name="payment_type_id">
                            @foreach ($paymentType as $value)
                                <option value="{{ $value->id }}">{{ $value->abbreviation }}</option>        
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="payment_desc" class="col-lg-3 col-md-3 col-3 require">Payment Details (like ChqNo):</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="payment_desc" name="payment_desc" placeholder="Payment Desc" required/>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
             <div class="form-group row">
                <label for="paid_amt" class="col-lg-3 col-md-3 col-3">Payment Amount:</label>
                <div class="col-lg-5 col-md-5 col-5">
                    <input type="text" class="form-control" id="paid_amt" name="paid_amt" value="{{ $objData->charge_total }}" placeholder="Payment Amount" required/>
                </div>
                <div class="col-lg-4 col-md-4 col-4">
                    <select id="paid_currency_id" name="paid_currency_id" class="form-control">
                        @foreach ($currency as $value)
                            <option @if($objData->currency_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->code }}</option>        
                        @endforeach
                    </select>
                </div>
             </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="payment_comments" class="col-lg-2 col-md-2 col-2">Comments:</label>
                    <div class="col-lg-10 col-md-10 col-10">
                        <textarea class="form-control" id="payment_comments" rows="3" name="payment_comments"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <table id="carrierstable" class="display expandable-table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>Amount Due</th>
                        <th>Amount Paid</th>
                        <th>Exchange Rate</th>
                        <th>Total Amt Paid</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $objData->id }}</td>
                            <td>{{ $objData->invoice_date }}</td>
                            <td>{{ $objData->charge_total }} <b>{{ $objData->currency->code }}</b></td>
                            <td>{{ $objData->charge_total }} <b>{{ $objData->currency->code }}</b></td>
                            <td>x 1.000000</td>
                            <td>{{ $objData->charge_total }} <b>{{ $objData->currency->code }}</b></td>
                        </tr>
                        <tr>
                        <td><b>Total:</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{ $objData->charge_total }} {{ $objData->currency->code }}</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 </form>
 <script>
     /* JQuery Validations */
     $("#submit-form").validate();
 </script>
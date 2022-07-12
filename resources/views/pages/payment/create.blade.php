<form id="submit-form" action="{{ $action }}" class="form-customer" method="POST" autocomplete="off">
    <div class="container-fluid">
       <div class="row">
          @csrf
          <div class="col-12">
             <div class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center">
                <h3 class="card-title m-0">{{ $pageName }}</h3>
                <div class="d-flex topbtns">
                   <button>Save</button>
                   <button type="button" class="ms-3 goBack">Cancel</button>
                </div>
                  
               </div>
            <h5 class="form-details">Invoice Details</h5>
            <div class="form-check-top" style="float: right">
               <div class="row">
                  <div class="col-12">
                     <div class="d-flex float-right">
                           <div class="d-flex">
                              <input class="form-check-input" type="checkbox" value="1" @if(isset($objData->is_paid) && $objData->is_paid == 1) checked @endif name="is_paid" id="is_paid"/>
                              <label for="is_paid" class="col-lg-12 col-md-12 col-12 ms-2" >This invoice was paid</label>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
          </div>
          <div class="col-md-6">
             <div class="form-group row">
                <label for="invoice_date" class="col-lg-3 col-md-3 col-3 require">Invoice Date:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <input type="date" class="form-control" id="invoice_date" name="invoice_date" value="@if(isset($objData->invoice_date)){{ $objData->invoice_date }}@endif" placeholder="Invoice Date" required autofocus>
                </div>
             </div>
             <div class="form-group row">
                <label for="invoice_no" class="col-lg-3 col-md-3 col-3 require">Invoice No:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <input type="text" class="form-control" id="invoice_no" name="invoice_no" value="@if(isset($objData->invoice_no)){{ $objData->invoice_no }}@endif" placeholder="Invoice No" required>
                </div>
             </div>
             <div class="form-group row">
                <label for="currency_id" class="col-lg-3 col-md-3 col-3">Currency:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <select id="currency_id" name="currency_id">
                   @foreach ($currency as $value)
                   <option @if(isset($objData->currency_id) && $objData->currency_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->code }}</option>        
                   @endforeach
                   </select>
                </div>
             </div>
             <div class="form-group row">
                <label for="invoice_tax" class="col-lg-3 col-md-3 col-3 require">Invoice Tax:</label>
                <div class="col-7">
                   <input type="number" class="form-control" id="invoice_tax" name="invoice_tax" value="@if(isset($objData->invoice_tax)){{ $objData->invoice_tax }}@endif" placeholder="Invoice Tax" required>
                </div>
                <div class="col-2">
                   <select id="invoice_tax_type" name="invoice_tax_type">
                   <option @if(isset($objData->invoice_tax_type) && $objData->invoice_tax_type == "HST") selected @endif value="HST">HST</option>        
                   <option @if(isset($objData->invoice_tax_type) && $objData->invoice_tax_type == "GST") selected @endif value="GST">GST</option>        
                   </select>
                </div>
             </div>
             <div class="form-group row">
                <label for="invoice_total" class="col-lg-3 col-md-3 col-3 require">Total:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <input type="number" class="form-control" id="invoice_total" name="invoice_total" value="@if(isset($objData->invoice_total)){{ $objData->invoice_total }}@endif" placeholder="Invoice Total" required>
                </div>
             </div>
          </div>
          <div class="col-md-6">
             <div class="form-group row">
                <label for="invoice_category" class="col-lg-3 col-md-3 col-3">Category:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <select id="invoice_category" name="invoice_category">
                   @foreach ($category as $value)
                   <option @if(isset($objData->invoice_category) && $objData->invoice_category == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                   @endforeach
                   </select>
                </div>
             </div>
             <div class="form-group row">
                <label for="invoice_payable_id" class="col-lg-3 col-md-3 col-3">Payable Name:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <select id="invoice_payable_id" name="invoice_payable_id">
                   @foreach ($payables as $value)
                   <option @if(isset($objData->invoice_payable_id) && $objData->invoice_payable_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->company }}</option>        
                   @endforeach
                   </select>
                </div>
             </div>
             <div class="form-group row">
                <label for="invoice_carrier_id" class="col-lg-3 col-md-3 col-3">Carrier Name:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <select id="invoice_carrier_id" name="invoice_carrier_id">
                   @foreach ($carriers as $value)
                   <option @if(isset($objData->invoice_carrier_id) && $objData->invoice_carrier_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->company }}</option>        
                   @endforeach
                   </select>
                </div>
             </div>
             <div class="form-group row">
                <label for="invoice_orders" class="col-lg-3 col-md-3 col-3">Paid Orders:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <textarea name="invoice_orders" id="invoice_orders" class="form-control">@if(isset($objData->invoice_orders)){{ $objData->invoice_orders }}@endif</textarea>
                </div>
             </div>
          </div>
          <div class="col-md-12">
             <div class="form-group row">
                <label for="invoice_comments" class="col-lg-1 col-md-1 col-1">Comments:</label>
                <div class="col-lg-11 col-md-11 col-11">
                   <textarea name="invoice_comments" id="invoice_comments" class="form-control">@if(isset($objData->invoice_comments)){{ $objData->invoice_comments }}@endif</textarea>
                </div>
             </div>
          </div>
          <div class="col-12">
            <h5 class="form-details">Payment Details</h5>
         </div>
         <div class="col-lg-6 col-md-6 col-12">
            <div class="form-group row">
                <label for="paid_chq_date" class="col-lg-3 col-md-3 col-3">Cheque Date:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <input type="date" class="form-control" id="paid_chq_date" name="paid_chq_date" value="@if(isset($objData->paid_chq_date)){{ $objData->paid_chq_date }}@endif" placeholder="Cheque Date">
                </div>
             </div>
         </div>
         <div class="col-lg-6 col-md-6 col-12">
            <div class="form-group row">
                <label for="paid_chq" class="col-lg-3 col-md-3 col-3">Cheque No:</label>
                <div class="col-lg-9 col-md-9 col-9">
                   <input type="text" class="form-control" id="paid_chq" name="paid_chq" value="@if(isset($objData->paid_chq)){{ $objData->paid_chq }}@endif" placeholder="Cheque No">
                </div>
             </div>
         </div>
         <div class="col-md-12">
            <div class="form-group row">
               <label for="paid_comments" class="col-lg-1 col-md-1 col-1">Comments:</label>
               <div class="col-lg-11 col-md-11 col-11">
                  <textarea name="paid_comments" id="paid_comments" class="form-control">@if(isset($objData->paid_comments)){{ $objData->paid_comments }}@endif</textarea>
               </div>
            </div>
         </div>
        </div>
    </div>
 </form>
 <script>
    /* JQuery Validations */
    $("#submit-form").validate({
     rules: {
         password: {
             minlength: 5
         },
         verify_password: {
             minlength: 5,
             equalTo: "#password"
         }
     }
    });
 </script>
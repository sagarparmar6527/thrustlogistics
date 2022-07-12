<form id="submit-form" action="javascript:void(0)" class="form-customer" method="POST" autocomplete="off">
    <div class="container-fluid">
       <div class="row">
          <div class="col-12">
             <div class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center">
                <h3 class="card-title m-0">{{ $pageName }}</h3>
                <div class="d-flex topbtns">
                  <button type="button" class="ms-3 goBack">Back</button> 
                  @if(!$objData->ipayment_item)
                     @if(!$objData->credit_by)
                        <button type="button" class="ms-3" id="enter-payment" data-payment-href="{{ $payment }}">Enter Payment</button>
                        <button type="button" class="ms-3" id="add-credit-note" data-credit-note-href="{{ $creditNote }}" data-msg="Add">Add Credit Note</button>
                     @else
                        <button type="button" class="ms-3" id="add-credit-note" data-credit-note-href="{{ $creditNote }}" data-msg="Remove">Remove Credit Note</button>
                     @endif
                  @endif
                  <a target="_Blank" href="{{ $print }}" class="ms-3">Re-print</a>
                </div>
             </div>
             <h5 class="form-details">Customer Info</h5>
          </div>
          <div class="col-md-6">
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Customer:</label>
                <div class="col-9">
                   <b>{{ $objData->customer->company }}</b>
                </div>
             </div>
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Phone:</label>
                <div class="col-9">
                   {{ $objData->customer->phone }}
                </div>
             </div>
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Fax:</label>
                <div class="col-9">
                   {{ $objData->customer->fax }}
                </div>
             </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Created:</label>
                <div class="col-9">
                   {{ $objData->invoice_date }}
                </div>
             </div>
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Printed:</label>
                <div class="col-9">
                    @if($objData->printed)
                        <img src="{{ asset('admin/images/enabled.png') }}" class="printed" alt="Printed">
                    @else
                        <img src="{{ asset('admin/images/disabled.png') }}" class="printed" alt="Printed">
                    @endif
                </div>
             </div>
             <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-3">Amount Due:</label>
                <div class="col-9">
                   {{ ($objData->credit_by) ? '0.00' : $objData->charge_total; }} <b>{{ $objData->currency->code }}</b>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="container-fluid form-tabs mt-4">
        <div class="row">
           <div class="col-9">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                 <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="orders-tab"  data-bs-toggle="tab"  data-bs-target="#orders"  type="button"  role="tab"  aria-controls="orders"  aria-selected="true">Orders</button>
                 </li>
                 <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payments-tab"  data-bs-toggle="tab"  data-bs-target="#payments"  type="button"  role="tab"  aria-controls="payments"  aria-selected="false">Payments</button>
                 </li>
                 @if($objData->credit_by)
                 <li class="nav-item" role="presentation">
                     <button class="nav-link" id="credit-note-tab"  data-bs-toggle="tab"  data-bs-target="#credit-note"  type="button"  role="tab"  aria-controls="credit-note"  aria-selected="false">Credit Note</button>
                  </li>
                 @endif
              </ul>
           </div>
           <div class="col-12">
            <div class="tab-content px-0" id="myTabContent">
               <div
                  class="tab-pane fade show active"
                  id="orders"
                  role="tabpanel"
                  aria-labelledby="orders-tab"
                  >
                  <table id="carrierstable" class="display expandable-table" style="width: 100%">
                    <thead>
                       <tr>
                          <th>OrderID</th>
                          <th>PickUp Date</th>
                          <th>Service</th>
                          <th>PCS</th>
                          <th>Sub Total</th>
                          <th>HST</th>
                          <th>Fuel</th>
                          <th>Total</th>
                          <th>Curr</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $objData->order->id }}</td>
                            <td>{{ $objData->order->from_date }}</td>
                            <td>{{ $objData->order->service->abbreviation }}</td>
                            <td>{{ $objData->order->pcs }}</td>
                            <td>{{ round(($objData->charge_total) - ($objData->charge_hst + $objData->charge_fuel),2) }}</td>
                            <td>{{ $objData->charge_hst }}</td>
                            <td>{{ $objData->charge_fuel }}</td>
                            <td>{{ $objData->charge_total }}</td>
                            <td>{{ $objData->currency->code }}</td>
                        </tr>
                    </tbody>
                 </table>
               </div>
               <div
                   class="tab-pane fade"
                   id="payments"
                   role="tabpanel"
                   aria-labelledby="payments-tab"
                   >
                   <table id="carrierstable" class="display expandable-table" style="width: 100%">
                      <thead>
                         <tr>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Details</th>
                            <th>Amount Paid</th>
                            <th>Exchange Rate</th>
                            <th>Total Amt Paid</th>
                         </tr>
                      </thead>
                      <tbody>
                           @if($objData->ipayment_item)
                              <tr>
                                 <td>{{ $objData->ipayment_item->ipayment->id }}</td>
                                 <td>{{ $objData->ipayment_item->ipayment->payment_date }}</td>
                                 <td>{{ $objData->ipayment_item->ipayment->payment_type->abbreviation }}</td>
                                 <td>{{ $objData->ipayment_item->ipayment->payment_desc }}</td>
                                 <td>{{ $objData->ipayment_item->paid_amount }}</td>
                                 <td>{{ $objData->ipayment_item->paid_exch_rate }}</td>
                                 <td>{{ $objData->ipayment_item->paid_amount }}</td>
                              </tr>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td><b>Total:</b></td>
                                 <td><b>{{ $objData->ipayment_item->paid_amount }}</b></td>
                                 <td><b>{{ $objData->ipayment_item->ipayment->currency->code }}</b></td>
                                 <td></td>
                                 <td></td>
                              </tr>
                           @else
                              <tr>
                                 <td>No payments yet</td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                              </tr>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td><b>Total:</b></td>
                                 <td><b>0.00</b></td>
                                 <td><b>{{ $objData->currency->code }}</b></td>
                                 <td></td>
                                 <td></td>
                              </tr>
                           @endif
                      </tbody>
                   </table>
                </div>
                @if($objData->credit_by)
                <div
                   class="tab-pane fade"
                   id="credit-note"
                   role="tabpanel"
                   aria-labelledby="credit-note-tab"
                   >
                   <div class="col-12">
                     <h5 class="form-details">Customer Info</h5>
                  </div>
                   <div class="col-md-6">
                     <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-3">Employee:</label>
                        <div class="col-9">
                           <b>{{ $objData->credit_employee->name }}</b>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-3">Date/time:</label>
                        <div class="col-9">
                           {{ $objData->credit_time }}
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-3">Amount:</label>
                        <div class="col-9">
                           {{ $objData->credit_amt }}
                        </div>
                     </div>
                  </div>
                </div>
                @endif
            </div>
        </div>
        </div>
    </div>
 </form>
 <script>
    jQuery('body').on('click','#add-credit-note',function(){
      var action = $(this).data('credit-note-href');
      var msg = $(this).data('msg');
      Swal.fire({
         title: "Are you sure you want to "+msg+" a credit note?",
         icon: "warning",
         showCancelButton: true,
         confirmButtonText: "Yes, "+msg+" credit note!",
         cancelButtonText: "No, cancel!",
         reverseButtons: true
      }).then(function(result) {
         if (result.value) {
               $.ajax({
                  url: action,
                  success: function (response) {
                     if((response.success)){
                        $.ajax({
                           url: response.action,
                           success: function (response) {
                              if((response.error)){
                                 errorFun(response.error);
                              }else{
                                 $('#content-form').html(response);
                              }
                           },
                           error: function (error) {
                              warningFun();
                           }
                        });
                        Swal.fire("Success!", response.success, "success");
                     }else{
                        Swal.fire("Oops!", response.error, "warning");
                     }
                  },error: function (response) {
                     Swal.fire("Oops!", response.error, "warning");
                  }
               });
         } else if (result.dismiss === "cancel") {
               Swal.fire("Cancelled","Your records are not "+msg+" credit :)","error");
         }
      });
    });

    jQuery('body').on('click','#enter-payment',function(){
      var action = $(this).data('payment-href');
      $.ajax({
         url: action,
         success: function (response) {
            if((response.error)){
               errorFun(response.error);
            }else{
               $('#content-form').html(response);
            }
         },
         error: function (error) {
            warningFun();
         }
      });
    });
 </script>
 {{-- The following amount has been credited: $176.49 --}}

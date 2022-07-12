<form id="submit-order-form" action="{{ $action }}" class="form-customer" method="POST" autocomplete="off">
    @csrf
    <input type="hidden" value="@if(isset($objData->status_id)){{ $objData->status_id }}@else{{ __('1') }}@endif" name="status_id" id="status-id">
    <div class="container-fluid form-tabs">
       <div class="row">
          <div class="col-12">
             <div class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center">
                <h3 class="card-title m-0">{{ $pageName }} @isset($objData)# {{ $objData->id }} ({{ $objData->status->name }})@endif</h3>
                <div class="d-flex btn-submit-orders">
                    @if(Auth::user()->dataEntry())
                        @if(isset($objData))
                            @if($objData->status_id == 1)
                                <button class="ms-3 submit-form" data-status="2">Submit Order</button>
                            @elseif($objData->status_id == 2)
                                <button class="ms-3 submit-form" data-status="3">Dispatched</button>
                            @elseif($objData->status_id == 3)
                                <button class="ms-3 submit-form" data-status="4">Delivered</button>
                            @endif
                            <a href="{{ $print }}" target="_Blank" class="ms-3">Print</a>
                            <button class="ms-3">Save</button>
                        @else
                            <button class="ms-3 submit-form" data-status="2">Submit Order</button>
                            <button class="ms-3 submit-form" data-status="1">Save</button>
                        @endif
                    @endif
                    <button type="button" class="ms-3 goBack">Cancel</button>
                </div>
             </div>
          </div>
          <div class="col-9">
             <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                   <button class="nav-link @if(!isset($is_carrier)) active @endif" id="general-tab"  data-bs-toggle="tab"  data-bs-target="#general"  type="button"  role="tab"  aria-controls="general"  aria-selected="true">General</button>
                </li>
                <li class="nav-item" role="presentation">
                   <button class="nav-link @if(isset($is_carrier)) active @endif" id="carriers-tab"  data-bs-toggle="tab"  data-bs-target="#carriers"  type="button"  role="tab"  aria-controls="carriers"  aria-selected="false">Carriers</button>
                </li>
                <li class="nav-item" role="presentation">
                   <button  class="nav-link"  id="payment-tab"  data-bs-toggle="tab"  data-bs-target="#payment"  type="button"  role="tab"  aria-controls="payment" aria-selected="false">Payment</button>
                </li>
                <li class="nav-item" role="presentation">
                   <button  class="nav-link"  id="bills-tab"  data-bs-toggle="tab"  data-bs-target="#bills"  type="button"  role="tab"  aria-controls="bills"  aria-selected="false">Bill of landing</button>
                </li>
             </ul>
          </div>
          @if(isset($objData) && $objData->isDelivered())
            <div class="col-3">
                <div class="form-check-top">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="d-flex">
                                    <input class="form-check-input" type="checkbox" value="1" @if(isset($objData->is_invoice_ready) && $objData->is_invoice_ready == 1) checked @endif name="is_invoice_ready" id="is_invoice_ready"/>
                                    <label for="is_invoice_ready" class="col-lg-12 col-md-12 col-12 ms-2" >Ready to be invoiced</label>
                                </div>
                                <div class="d-flex ms-3">
                                    <input class="form-check-input" type="checkbox" value="1" @if(isset($objData->is_invoice_rush) && $objData->is_invoice_rush == 1) checked @endif name="is_invoice_rush" id="is_invoice_rush"/>
                                    <label for="is_invoice_rush" class="col-lg-12 col-md-12 col-12 ms-2">Rush billing</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          @endif
          <div class="col-12">
            <div class="tab-content px-0" id="myTabContent">
               <div
                  class="tab-pane fade @if(!isset($is_carrier)) show active @endif"
                  id="general"
                  role="tabpanel"
                  aria-labelledby="general-tab"
                  >
                  <div class="px-0">
                     <div class="row">
                        <div class="col-12">
                           <h5 class="form-details">Order Details</h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="form-group row mt-1">
                              <label for="exampleInputUsername1" class="col-lg-3 col-md-3 col-3">Order ID:</label>
                              <div class="col-9">
                                 <p>@if(isset($objData))<b>{{ $objData->id }}</b> @else New Order @endif</p>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="name" class="col-lg-3 col-md-3 col-3 require">Customer:</label>
                              <div class="col-9">
                                 <select id="customer_id" name="customer_id" class="form-control" autofocus required>
                                    <option value="">Select Customer</option>
                                    @foreach ($customer as $value)
                                        <option @if(isset($objData->customer_id) && $objData->customer_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->company }}</option>        
                                    @endforeach
                                </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="name" class="col-lg-3 col-md-3 col-3 require">Service Type:</label>
                              <div class="col-9">
                                 <select id="service_id" name="service_id" class="form-control" required>
                                    <option value="">Select Service Type</option>
                                    @foreach ($serviceType as $value)
                                        <option @if(isset($objData->service_id) && $objData->service_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                                    @endforeach
                                </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="ref_number" class="col-lg-3 col-md-3 col-3">Ref Number:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                  <input type="text" class="form-control" id="ref_number" name="ref_number" value="@if(isset($objData->ref_number)){{ $objData->ref_number }}@endif" placeholder="Ref Number"/>
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="form-group row">
                              <label for="exampleInputUsername1" class="col-lg-3 col-md-3 col-3">Created On:</label>
                              <div class="col-9">
                                 <p>@if(isset($objData))<b>{{ $objData->order_datetime }}</b> @else Today Date @endif</p>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="ref_number" class="col-lg-3 col-md-3 col-3">Comments:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <textarea class="form-control" id="comments" name="comments" placeholder="comments"/>@if(isset($objData->comments)){{ $objData->comments }}@endif</textarea>
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="form-details d-flex align-items-center">
                              <h5 class="m-0">Consignor</h5>
                              <div class="d-flex ms-4 align-items-center">
                                 <div>
                                    <select id="consignor_id" class="form-control" style="width: 500px;margin-right: 22px;">
                                        <option value=""></option>
                                    </select>
                                 </div>
                                 <label style="cursor: pointer" id="consignor_fill">Fill</label>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="from_company" class="col-lg-3 col-md-3 col-3 require">Company:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                  <input type="text" class="form-control" id="from_company" name="from_company" value="@if(isset($objData->from_company)){{ $objData->from_company }}@endif" placeholder="Company" required/>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="from_contact" class="col-lg-3 col-md-3 col-3">Contact:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="from_contact" name="from_contact" value="@if(isset($objData->from_contact)){{ $objData->from_contact }}@endif" placeholder="Contact"/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="from_phone" class="col-lg-3 col-md-3 col-3">Phone:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="from_phone" name="from_phone" value="@if(isset($objData->from_phone)){{ $objData->from_phone }}@endif" placeholder="Phone"/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="from_address" class="col-lg-3 col-md-3 col-3 require">Address:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="from_address" name="from_address" value="@if(isset($objData->from_address)){{ $objData->from_address }}@endif" placeholder="Address" required/>
                              </div>
                              <label for="from_address" class="col-lg-3 col-md-3 col-3"></label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="from_address2" name="from_address2" value="@if(isset($objData->from_address2)){{ $objData->from_address2 }}@endif" placeholder="Address 2"/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="from_city" class="col-lg-3 col-md-3 col-3 require">City:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="from_city" name="from_city" value="@if(isset($objData->from_city)){{ $objData->from_city }}@endif" placeholder="City" required/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="from_state" class="col-lg-3 col-md-3 col-3 require">Province / State:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="from_state" name="from_state" value="@if(isset($objData->from_state)){{ $objData->from_state }}@endif" placeholder="Province / State" required/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="from_postal" class="col-lg-3 col-md-3 col-3 require">Postal / Zip Code:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="from_postal" name="from_postal" value="@if(isset($objData->from_postal)){{ $objData->from_postal }}@endif" placeholder="Postal / Zip Code" required/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="from_country_id" class="col-lg-3 col-md-3 col-3 require">Country:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                  <select id="from_country_id" name="from_country_id">
                                      @foreach ($country as $value)
                                          <option @if(isset($objData->from_country_id) && $objData->from_country_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="from_date" class="col-lg-3 col-md-3 col-3 require">Pickup Date:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="date" class="form-control" id="from_date" name="from_date" value="@if(isset($objData->from_date)){{ $objData->from_date }}@endif" placeholder="Pickup Date" required/>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="form-details d-flex align-items-center">
                              <h5 class="m-0">Consignee</h5>
                              <div class="d-flex ms-4 align-items-center">
                                <div>
                                   <select id="consignee_id" class="form-control" style="width: 500px;margin-right: 22px;">
                                       <option value=""></option>
                                   </select>
                                </div>
                                <label style="cursor: pointer" id="consignee_fill">Fill</label>
                             </div>
                           </div>
                           <div class="form-group row">
                              <label for="to_company" class="col-lg-3 col-md-3 col-3 require">Company:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                  <input type="text" class="form-control" id="to_company" name="to_company" value="@if(isset($objData->to_company)){{ $objData->to_company }}@endif" placeholder="Company" required/>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="to_contact" class="col-lg-3 col-md-3 col-3">Contact:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="to_contact" name="to_contact" value="@if(isset($objData->to_contact)){{ $objData->to_contact }}@endif" placeholder="Contact"/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="to_phone" class="col-lg-3 col-md-3 col-3">Phone:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="to_phone" name="to_phone" value="@if(isset($objData->to_phone)){{ $objData->to_phone }}@endif" placeholder="Phone"/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="to_address" class="col-lg-3 col-md-3 col-3 require">Address:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="to_address" name="to_address" value="@if(isset($objData->to_address)){{ $objData->to_address }}@endif" placeholder="Address" required/>
                              </div>
                              <label for="to_address" class="col-lg-3 col-md-3 col-3"></label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="to_address2" name="to_address2" value="@if(isset($objData->to_address2)){{ $objData->to_address2 }}@endif" placeholder="Address 2"/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="to_city" class="col-lg-3 col-md-3 col-3 require">City:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="to_city" name="to_city" value="@if(isset($objData->to_city)){{ $objData->to_city }}@endif" placeholder="City" required/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="to_state" class="col-lg-3 col-md-3 col-3 require">Province / State:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="to_state" name="to_state" value="@if(isset($objData->to_state)){{ $objData->to_state }}@endif" placeholder="Province / State" required/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="to_postal" class="col-lg-3 col-md-3 col-3 require">Postal / Zip Code:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="to_postal" name="to_postal" value="@if(isset($objData->to_postal)){{ $objData->to_postal }}@endif" placeholder="Postal / Zip Code" required/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="to_country_id" class="col-lg-3 col-md-3 col-3 require">Country:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                  <select id="to_country_id" name="to_country_id">
                                      @foreach ($country as $value)
                                          <option @if(isset($objData->to_country_id) && $objData->to_country_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="to_date" class="col-lg-3 col-md-3 col-3 require">Pickup Date:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="date" class="form-control" id="to_date" name="to_date" value="@if(isset($objData->to_date)){{ $objData->to_date }}@endif" placeholder="Pickup Date" required/>
                              </div>
                           </div>
                        </div>
                        <div class="col-12">
                           <h5 class="form-details">Freight Details</h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="form-group row">
                              <label for="pcs" class="col-lg-3 col-md-3 col-3">Pieces:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="number" class="form-control" id="pcs" name="pcs" value="@if(isset($objData->pcs)){{ $objData->pcs }}@endif" placeholder="Pieces" required/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="weight" class="col-lg-3 col-md-3 col-3">Weight(lb):</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="number" class="form-control" id="weight" name="weight" value="@if(isset($objData->weight)){{ $objData->weight }}@endif" placeholder="Weight(lb)" required/>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="form-group row">
                              <label for="content" class="col-lg-3 col-md-3 col-3">Content:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="text" class="form-control" id="content" name="content" value="@if(isset($objData->content)){{ $objData->content }}@endif" placeholder="Content" required/>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="value" class="col-lg-3 col-md-3 col-3">Value:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                 <input type="number" class="form-control" id="value" name="value" value="@if(isset($objData->value)){{ $objData->value }}@endif" placeholder="Value" required/>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div
                   class="tab-pane fade @if(isset($is_carrier)) show active @endif""
                   id="carriers"
                   role="tabpanel"
                   aria-labelledby="carriers-tab"
                   >
                   <table id="carrierstable" class="display expandable-table" style="width: 100%">
                      <thead>
                         <tr>
                            <th>#</th>
                            <th>Carrier</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Agreed Price</th>
                            <th>Actions</th>
                         </tr>
                      </thead>
                      <tbody>
                          @if(isset($objData->carrier) && $objData->carrier)
                            @foreach ($objData->carrier as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><b>{{ $value->carrier->company }}</b><br>Contact: 
                                        {{ $value->carrier->contact }}<br>Phone: {{ $value->carrier->phone }}</td>
                                    <td>{{ $objData->from_address }}<br>{{ $objData->from_address1 }}<br>{{ $objData->from_city }},<br>{{ $objData->from_state }},<br>{{ $objData->from_country->name }}</td>
                                    <td>{{ $value->to_address }}<br>{{ $value->to_address1 }}<br>{{ $value->to_city }},<br>{{ $value->to_state }},<br>{{ $value->to_country->name }}</td>
                                    <td>${{ $value->agreed_price }}<b>{{ $value->currency->code }}</b></td>
                                    <td class="edit-list"><span><a href="javascript:void(0)" class="edit-btns green open-carrier-form" data-href="{{ $editCarrier }}" data-id="{{ $value->id }}"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="edit-btns red deleteCarrier" data-href="{{ $deleteCarrier }}" data-id="{{ $value->id }}"><i class="fa-solid fa-trash-can"></i></a>&nbsp;&nbsp;<a target="_Blank" href="{{ $carrierPrint }}/{{ $value->id }}" class="edit-btns green "><i class="fa-solid fa-print"></i></a></span></td>
                                </tr>
                            @endforeach
                          @endif
                      </tbody>
                   </table>
                   <div class="col-12 p-5 text-center">
                    @if(!isset($objData->carrier) || !$objData->carrier)
                    <p>Carriers was not assigned yet.</p>
                    @endif
                    @if(isset($objData->carrier))
                        <button type="button" class="open-carrier-form" data-href="{{ $createCarrier }}" data-order-id="{{ $objData->id }}">Assign New Carrier</button>
                    @else
                        <button class="submit-form" data-status="carrier">Assign New Carrier</button>
                    @endif
                   </div>
                </div>
                <div
                   class="tab-pane fade"
                   id="payment"
                   role="tabpanel"
                   aria-labelledby="payment-tab"
                   >
                   <table id="paymenttable" class="display expandable-table" style="width: 100%">
                      <thead>
                         <tr>
                            <th class="item">Item</th>
                            <th class="amount">Amount</th>
                            <th class="desc">Description</th>
                         </tr>
                      </thead>
                      <tbody>
                         <tr>
                            <td>Service:</td>
                            <td><input type="number" class="form-control payment-info" id="service-charge" name="service_charge" value="@if(isset($objData->service_charge)){{ $objData->service_charge }}@else{{ __('0.00') }}@endif" id="adjustments"></td>
                            <td></td>
                         </tr>
                         <tr>
                            <td>Adjustments:</td>
                            <td><input type="number" class="form-control payment-info" id="adjustment-charge" name="adjustments_charge" value="@if(isset($objData->adjustments_charge)){{ $objData->adjustments_charge }}@else{{ __('0.00') }}@endif" id="adjustments_charge"></td>
                            <td><textarea row="4" name="adjustments">@if(isset($objData->adjustments)){{ $objData->adjustments }}@endif</textarea></td>
                         </tr>
                         <tr>
                            <td>Fuel:</td>
                            <td>
                               <p id="fuel-amt">@if(isset($objData->fuel_charge)){{ $objData->fuel_charge }}@else 0.00 @endif</p>
                               <input type="hidden" id="fuel-charge" name="fuel_charge" value="@if(isset($objData->fuel_charge)){{ $objData->fuel_charge }}@else{{ __('0.00') }}@endif">
                            </td>
                            <td>
                              <select class="payment-info" id="fuel_id" name="fuel_id">
                                 @foreach ($chargesFuel as $value)
                                     <option @if(isset($objData->fuel_id) && $objData->fuel_id == $value->id) selected @endif value="{{ $value->id }}" data-percent="{{ $value->percent }}">{{ $value->name }}</option>        
                                 @endforeach
                             </select>
                            </td>
                         </tr>
                         <tr>
                            <td>HST:</td>
                            <td>
                               <p id="hst-amt">@if(isset($objData->hst_charge)){{ $objData->hst_charge }}@else 0.00 @endif</p>
                               <input type="hidden" id="hst-charge" name="hst_charge" value="@if(isset($objData->hst_charge)){{ $objData->hst_charge }}@else{{ __('0.00') }}@endif">
                            </td>
                            <td>
                              <select class="payment-info" id="hst_id" name="hst_id">
                                 @foreach ($chargesHst as $value)
                                     <option @if(isset($objData->hst_id) && $objData->hst_id == $value->id) selected @endif value="{{ $value->id }}" data-percent="{{ $value->percent }}">{{ $value->name }}</option>        
                                 @endforeach
                             </select>
                            </td>
                         </tr>
                         <tr class="footertr">
                            <td><b>Total:</b></td>
                            <td>
                               <p id="total-amt">@if(isset($objData->total_charges)){{ $objData->total_charges }}@else 0.00 @endif</p>
                               <input type="hidden" id="total-charge" name="total_charges" value="@if(isset($objData->total_charges)){{ $objData->total_charges }}@else{{ __('0.00') }}@endif">
                            </td>
                            <td>
                              <select id="currency_id" name="currency_id">
                                 @foreach ($currency as $value)
                                     <option @if(isset($objData->currency_id) && $objData->currency_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->code }}</option>        
                                 @endforeach
                             </select>
                            </td>
                         </tr>
                      </tbody>
                   </table>
                </div>
                <div
                   class="tab-pane fade"
                   id="bills"
                   role="tabpanel"
                   aria-labelledby="bills-tab"
                   >
                   <div class="row">
                     <div class="col-12">
                         <h5 class="form-details mb-2">Bill of Landing</h5>
                     </div>
                     <div class="col-lg-8 col-md-8 col-12">
                         <div class="form-check-top">
                             <div class="row">
                                 <div class="col-6">
                                     <div class="d-flex">
                                         <div class="d-flex">
                                             <input class="form-check-input" type="checkbox" value="1" @if(isset($objData->is_local) && $objData->is_local == 1) checked @endif name="is_local" id="is_local"/>
                                             <label for="is_local" class="col-lg-3 col-md-2 col-4 ms-2" >Local</label>
                                         </div>
                                         <div class="d-flex ms-3">
                                             <input class="form-check-input" type="checkbox" value="1" @if(isset($objData->is_domestic) && $objData->is_domestic == 1) checked @endif name="is_domestic" id="is_domestic"/>
                                             <label for="is_domestic" class="col-lg-3 col-md-2 col-4 ms-2">Domestic</label>
                                         </div>
                                         <div class="d-flex ms-3">
                                             <input class="form-check-input" type="checkbox" value="1" name="is_international" @if(isset($objData->is_international) && $objData->is_international == 1) checked @endif id="is_international"/>
                                             <label for="is_international" class="col-lg-3 col-md-2 col-4 ms-2" >International</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div> 
                     <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-check-top">
                            <div class="row">
                                <div class="col-4">
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            @if(Auth::user()->dataEntry())
                                                @if(isset($objData))
                                                    <div class="d-flex btn-submit-orders">
                                                        <a href="{{ $billPrint }}" target="_Blank" class="ms-3">Print</a>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                 
                     <hr class="hr-form" />
                 
                     <div class="row">
                         <div class="col-lg-3 col-md-6 col-6">
                             <div class="form-group row">
                                 <div class="col-1">
                                     <input
                                         class="form-check-input"
                                         type="checkbox"
                                         value="1" name="is_prepaid" @if(isset($objData->is_prepaid) && $objData->is_prepaid == 1) checked @endif
                                         id="is_prepaid"
                                     />
                                 </div>
                                 <label
                                     for="is_prepaid"
                                     class="col-lg-5 col-md-2 col-4"
                                     >Prepaid</label
                                 >
                             </div>
                             <div class="form-group row">
                                 <div class="col-1">
                                     <input
                                         class="form-check-input"
                                         type="checkbox"
                                         value="1" name="is_collect" @if(isset($objData->is_collect) && $objData->is_collect == 1) checked @endif
                                         id="is_collect"
                                     />
                                 </div>
                                 <label
                                     for="is_collect"
                                     class="col-lg-5 col-md-2 col-4"
                                     >Collect</label
                                 >
                             </div>
                             <div class="form-group row">
                                 <div class="col-1">
                                     <input
                                         class="form-check-input"
                                         type="checkbox"
                                         value="1" name="is_thirdparty" @if(isset($objData->is_thridparty) && $objData->is_thridparty == 1) checked @endif
                                         id="is_thirdparty"
                                     />
                                 </div>
                                 <label
                                     for="is_thirdparty"
                                     class="col-lg-5 col-md-2 col-4"
                                     >Third Party</label
                                 >
                             </div>
                             <div class="form-group row">
                                 <div class="col-1">
                                     <input
                                         class="form-check-input"
                                         type="checkbox"
                                         value="1" name="is_cod" @if(isset($objData->is_cod) && $objData->is_cod == 1) checked @endif
                                         id="is_cod"
                                     />
                                 </div>
                                 <label
                                     for="is_cod"
                                     class="col-lg-5 col-md-2 col-4"
                                     >COD</label
                                 >
                             </div>
                         </div>
                 
                         <div class="col-lg-3 col-md-6 col-6">
                             <div class="form-group row">
                                 <div class="col-1">
                                     <input
                                         class="form-check-input"
                                         type="checkbox"
                                         value="1" name="is_ground" @if(isset($objData->is_ground) && $objData->is_ground == 1) checked @endif
                                         id="is_ground"
                                     />
                                 </div>
                                 <label
                                     for="is_ground"
                                     class="col-lg-5 col-md-2 col-4"
                                     >Ground</label
                                 >
                             </div>
                             <div class="form-group row">
                                 <div class="col-1">
                                     <input
                                         class="form-check-input"
                                         type="checkbox"
                                         value="1" name="is_air" @if(isset($objData->is_air) && $objData->is_air == 1) checked @endif
                                         id="is_air"
                                     />
                                 </div>
                                 <label
                                     for="is_air"
                                     class="col-lg-5 col-md-2 col-4"
                                     >Air</label
                                 >
                             </div>
                             <div class="form-group row">
                                 <div class="col-1">
                                     <input
                                         class="form-check-input"
                                         type="checkbox"
                                         value="1" name="is_insurance" @if(isset($objData->is_insurance) && $objData->is_insurance == 1) checked @endif
                                         id="is_insurance"
                                     />
                                 </div>
                                 <label
                                     for="is_insurance"
                                     class="col-lg-5 col-md-2 col-4"
                                     >Insurance</label
                                 >
                             </div>
                             <div class="form-group row">
                                 <div class="col-lg-4 col-md-5 col-8">
                                     <input class="form-control" type="number" name="cod_amt" value="@if(isset($objData->cod_amt)){{ $objData->cod_amt }}@else{{ __('0.00') }}@endif" />
                                 </div>
                             </div>
                         </div>
                 
                         <div class="col-lg-6 col-md-6 col-12">
                             <div class="form-group row">
                                 <label
                                     for="lading_shiperno"
                                     class="col-lg-2 col-md-2 col-4"
                                     >Shipper's A/C #:</label
                                 >
                                 <div class="col-lg-10 col-md-10 col-8">
                                     <input type="text" class="me-2 form-control" id="lading_shiperno" name="lading_shiperno" value="@if(isset($objData->lading_shiperno)){{ $objData->lading_shiperno }}@endif"/>
                                 </div>
                             </div>
                             <div class="form-group row">
                                 <label for="lading_customerno" class="col-lg-2 col-md-2 col-4"
                                     >Customer PO #:</label
                                 >
                                 <div class="col-lg-10 col-md-10 col-8">
                                     <input type="text" class="me-2 form-control" id="lading_customerno" name="lading_customerno" value="@if(isset($objData->lading_customerno)){{ $objData->lading_customerno }}@endif"/>
                                 </div>
                             </div>
                             <div class="form-group row">
                                 <label for="lading_orderno" class="col-lg-2 col-md-2 col-4"
                                     >Order No:</label
                                 >
                                 <div class="col-lg-10 col-md-10 col-8">
                                     <input type="text" class="me-2 form-control" id="lading_orderno" name="lading_orderno" value="@if(isset($objData->lading_orderno)){{ $objData->lading_orderno }}@endif"/>
                                 </div>
                             </div>
                             <div class="form-group row">
                                 <label for="lading_noteno" class="col-lg-2 col-md-2 col-4"
                                     >Note No:</label
                                 >
                                 <div class="col-lg-10 col-md-10 col-8">
                                     <input type="text" class="me-2 form-control" id="lading_noteno" name="lading_noteno" value="@if(isset($objData->lading_noteno)){{ $objData->lading_noteno }}@endif"/>
                                 </div>
                             </div>
                             <div class="form-group row">
                                 <label for="lading_acsprono" class="col-lg-2 col-md-2 col-4"
                                     >ACS Pro No:</label
                                 >
                                 <div class="col-lg-10 col-md-10 col-8">
                                     <input type="text" class="me-2 form-control" id="lading_acsprono" name="lading_acsprono" value="@if(isset($objData->lading_acsprono)){{ $objData->lading_acsprono }}@endif"/>
                                 </div>
                             </div>
                         </div>
                     </div>
                 
                     <hr class="hr-form" />
                 
                     <div class="row">
                         <div class="col-lg-2 col-md-3 col-12">
                             <label for="lading_pcs">Pieces</label>
                 
                             <textarea
                                 class="form-control"
                                 id="lading_pcs"
                                 rows="5" name="lading_pcs"
                             >@if(isset($objData->lading_pcs)){{ $objData->lading_pcs }}@endif</textarea>
                         </div>
                 
                         <div class="col-lg-6 col-md-6 col-12">
                             <label for="lading_desc">Description / Special Instructions</label>
                 
                             <textarea
                                 class="form-control"
                                 id="lading_desc"
                                 rows="5" name="lading_desc"
                             >@if(isset($objData->lading_desc)){{ $objData->lading_desc }}@endif</textarea>
                         </div>
                 
                         <div class="col-lg-2 col-md-3 col-12">
                             <label for="lading_weight">Weight lbs./Kg.</label>
                 
                             <textarea
                                 class="form-control"
                                 id="lading_weight"
                                 rows="5" name="lading_weight"
                             >@if(isset($objData->lading_weight)){{ $objData->lading_weight }}@endif</textarea>
                         </div>
                 
                         <div class="col-lg-2 col-md-3 col-12">
                             <label for="lading_dim">Dimensions</label>
                 
                             <textarea
                                 class="form-control"
                                 id="lading_dim"
                                 rows="5" name="lading_dim"
                             >@if(isset($objData->lading_dim)){{ $objData->lading_dim }}@endif</textarea>
                         </div>
                     </div>
                 </div>
                </div>
            </div>
        </div>
       </div>
    </div>
 </form>
 <script>
    $("#submit-order-form").validate();
    jQuery('body').on('keyup','.payment-info',function(){
      calculateFun();
    });

    jQuery('body').on('change','.payment-info',function(){
        calculateFun();
    });

    function calculateFun(){
        var serviceCharge = ($('#service-charge').val()) ? $('#service-charge').val() : 0;
        var adjustmentCharge = ($('#adjustment-charge').val()) ? $('#adjustment-charge').val() : 0;
        
        // console.log('serviceCharge :- '+serviceCharge);
        // console.log('adjustmentCharge :- '+adjustmentCharge);
        // console.log('fuelId :- '+fuelId);
        // console.log('hstId :- '+hstId);

        var total = parseInt(serviceCharge)+parseInt(adjustmentCharge);

        var fuelId = $("#fuel_id option:selected").data('percent');
        var hstId = $("#hst_id option:selected").data('percent');

        var fuelCharge = ((parseInt(total)*parseInt(fuelId))/100).toFixed(2);
        var hstCharge = ((parseInt(total)*parseInt(hstId))/100).toFixed(2);

        $("#fuel-charge").val(fuelCharge);
        $("#hst-charge").val(hstCharge);
        $("#fuel-amt").html(fuelCharge);
        $("#hst-amt").html(hstCharge);

        var total = (parseInt(total)+parseInt(fuelCharge)+parseInt(hstCharge)).toFixed(2);

        $("#total-charge").val(total);
        $("#total-amt").html(total);
   }

   jQuery('body').on('click','.submit-form',function(){
        var status = $(this).data('status');
        $('#status-id').val(status);
    });

    jQuery('body').on('change','#customer_id',function(){
        var id = $(this).val();

        $.ajax({
            url: "{{ url('orders/get-address') }}/"+id,
            dataType: "json",
            success: function (response) {
                console.log(response);
                var htmlData = '<option value=""></option>';
                $.each(response, function (indexInArray, valueOfElement) { 
                    htmlData += '<option value="'+valueOfElement.id+'" address_name="'+valueOfElement.address_name+'" company="'+valueOfElement.company+'" contact="'+valueOfElement.contact+'" phone="'+valueOfElement.phone+'" address="'+valueOfElement.address+'" address2="'+valueOfElement.address2+'" city="'+valueOfElement.city+'" state="'+valueOfElement.state+'" postal="'+valueOfElement.postal+'">'+valueOfElement.address_name+'</option>';
                });

                $("#consignor_id, #consignee_id").html(htmlData);
            }
        });
    });

    jQuery('body').on('click','#consignor_fill',function(){
        var element = $("#consignor_id").find('option:selected');
        if(element){
            $("#from_company").val(element.attr("company"));
            $("#from_contact").val(element.attr("contact"));
            $("#from_phone").val(element.attr("phone"));
            $("#from_address").val(element.attr("address"));
            $("#from_address2").val(element.attr("address2"));
            $("#from_city").val(element.attr("city"));
            $("#from_state").val(element.attr("state"));
            $("#from_postal").val(element.attr("postal"));
        }
    });

    jQuery('body').on('click','#consignee_fill',function(){
        var element = $("#consignee_id").find('option:selected');
        if(element){
            $("#to_company").val(element.attr("company"));
            $("#to_contact").val(element.attr("contact"));
            $("#to_phone").val(element.attr("phone"));
            $("#to_address").val(element.attr("address"));
            $("#to_address2").val(element.attr("address2"));
            $("#to_city").val(element.attr("city"));
            $("#to_state").val(element.attr("state"));
            $("#to_postal").val(element.attr("postal"));
        }
    });
 </script>
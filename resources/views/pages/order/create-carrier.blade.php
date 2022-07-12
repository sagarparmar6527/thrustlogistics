<form id="submit-carrier-form" action="{{ $action }}" class="form-customer" method="POST" autocomplete="off">
    @csrf
    <input type="hidden" value="{{ $objOrder->id }}" name="order_id">
    <div class="container-fluid form-tabs">
       <div class="row">
          <div class="col-12">
             <div class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center">
                <h3 class="card-title m-0">{{ $pageName }} (Order # {{ $objOrder->id }})</h3>
                <div class="d-flex btn-submit-orders">
                    <button class="ms-3 submit-form" data-status="1">Save</button>
                    <button type="button" class="ms-3 orderGoBack" data-href="{{ $goBack }}">Cancel</button>
                </div>
             </div>
          </div>
          <div class="col-9">
             <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                   <button class="nav-link active" id="carrier-tab"  data-bs-toggle="tab"  data-bs-target="#carrier"  type="button"  role="tab"  aria-controls="carrier"  aria-selected="true">Carrier</button>
                </li>
                <li class="nav-item" role="presentation">
                   <button class="nav-link" id="addresses-tab"  data-bs-toggle="tab"  data-bs-target="#addresses"  type="button"  role="tab"  aria-controls="addresses"  aria-selected="false">Addresses</button>
                </li>
             </ul>
          </div>
          <div class="col-12">
            <div class="tab-content px-0" id="myTabContent">
               <div
                  class="tab-pane fade show active"
                  id="carrier"
                  role="tabpanel"
                  aria-labelledby="carrier-tab"
                  >
                  <div class="px-0">
                     <div class="row">
                        <div class="col-12">
                           <h5 class="form-details">Carrier Details</h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="form-group row">
                              <label for="name" class="col-lg-3 col-md-3 col-3 require">Carrier:</label>
                              <div class="col-9">
                                 <select id="carrier_id" name="carrier_id" class="form-control" required>
                                    <option value="">Select carrier</option>
                                    @foreach ($carrier as $value)
                                        <option @if(isset($objData->carrier_id) && $objData->carrier_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->company }}</option>        
                                    @endforeach
                                </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="carrier_contact" class="col-lg-3 col-md-3 col-3">Contact:</label>
                              <div class="col-lg-9 col-md-9 col-9">
                                  <input type="text" class="form-control" id="carrier_contact" name="carrier_contact" value="@if(isset($objData->carrier_contact)){{ $objData->carrier_contact }}@endif" placeholder="Contact"/>
                              </div>
                            </div>
                            <div class="form-group row">
                                <label for="carrier_equipment" class="col-lg-3 col-md-3 col-3">Equipment:</label>
                                <div class="col-lg-9 col-md-9 col-9">
                                    <input type="text" class="form-control" id="carrier_equipment" name="carrier_equipment" value="@if(isset($objData->carrier_equipment)){{ $objData->carrier_equipment }}@endif" placeholder="Equipment"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group row">
                                <label for="carrier_phone" class="col-lg-3 col-md-3 col-3">Phone:</label>
                                <div class="col-lg-9 col-md-9 col-9">
                                    <input type="text" class="form-control" id="carrier_phone" name="carrier_phone" value="@if(isset($objData->carrier_phone)){{ $objData->carrier_phone }}@endif" placeholder="Phone"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="carrier_fax" class="col-lg-3 col-md-3 col-3">Fax:</label>
                                <div class="col-lg-9 col-md-9 col-9">
                                    <input type="text" class="form-control" id="carrier_fax" name="carrier_fax" value="@if(isset($objData->carrier_fax)){{ $objData->carrier_fax }}@endif" placeholder="Fax"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="agreed_price" class="col-lg-3 col-md-3 col-3 require">Agreed price:</label>
                                <div class="col-lg-7 col-md-7 col-7">
                                    <input type="number" class="form-control" id="agreed_price" name="agreed_price" value="@if(isset($objData->agreed_price)){{ $objData->agreed_price }}@endif" placeholder="Agreed price" required/>
                                </div>
                                <div class="col-lg-2 col-md-2 col-2">
                                    <select id="agreed_price_currency" name="agreed_price_currency">
                                        @foreach ($currency as $value)
                                        <option @if(isset($objData->agreed_price_currency) && $objData->agreed_price_currency == $value->id) selected @endif value="{{ $value->id }}">{{ $value->code }}</option>        
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex">
                                    <input class="form-check-input" type="checkbox" value="1" @if(isset($objData->is_all_inclusive) && $objData->is_all_inclusive == 1) checked @endif name="is_all_inclusive" id="is_all_inclusive"/>
                                    <label for="is_all_inclusive" class="col-lg-3 col-md-2 col-4 ms-2" >All Inclusive</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                               <label for="from_instructions" class="col-lg-3 col-md-3 col-3">Pickup Instructions:</label>
                               <div class="col-lg-9 col-md-9 col-9">
                                  <textarea name="from_instructions" id="from_instructions" class="form-control">@if(isset($objData->from_instructions)){{ $objData->from_instructions }}@endif</textarea>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="form-group row">
                               <label for="to_instructions" class="col-lg-3 col-md-3 col-3">Delivery Instructions:</label>
                               <div class="col-lg-9 col-md-9 col-9">
                                  <textarea name="to_instructions" id="to_instructions" class="form-control">@if(isset($objData->to_instructions)){{ $objData->to_instructions }}@endif</textarea>
                               </div>
                            </div>
                         </div>
                        <div class="col-12">
                           <h5 class="form-details">Dispatcher Details</h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group row">
                                <label for="dispatched" class="col-lg-3 col-md-3 col-3">Dispatcher:</label>
                                <div class="col-lg-9 col-md-9 col-9">
                                   <select id="dispatched" name="dispatched">
                                   @foreach ($dispatcher as $value)
                                   <option @if(isset($objData->dispatched) && $objData->dispatched == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                                   @endforeach
                                   </select>
                                </div>
                             </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group row">
                                <label for="dispatched_time" class="col-lg-3 col-md-3 col-3 require">Date:</label>
                                <div class="col-lg-9 col-md-9 col-9">
                                   <input type="datetime-local" class="form-control" id="dispatched_time" name="dispatched_time" value="@if(isset($objData->dispatched_time)){{ \Carbon\Carbon::parse($objData->dispatched_time)->format('Y-m-d\TH:i'); }}@endif" placeholder="Date" required>
                                </div>
                             </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div
                   class="tab-pane fade"
                   id="addresses"
                   role="tabpanel"
                   aria-labelledby="addresses-tab"
                   >
                   <div class="px-0">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-details d-flex align-items-center">
                            <h5 class="m-0">From</h5>
                            </div>
                            <div class="form-group row">
                            <label for="from_company" class="col-lg-3 col-md-3 col-3 require">Company:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="from_company" name="from_company" value="@if(isset($objOrder->from_company)){{ $objOrder->from_company }}@endif" placeholder="Company" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="from_contact" class="col-lg-3 col-md-3 col-3">Contact:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="from_contact" name="from_contact" value="@if(isset($objOrder->from_contact)){{ $objOrder->from_contact }}@endif" placeholder="Contact"/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="from_phone" class="col-lg-3 col-md-3 col-3">Phone:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="from_phone" name="from_phone" value="@if(isset($objOrder->from_phone)){{ $objOrder->from_phone }}@endif" placeholder="Phone"/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="from_address" class="col-lg-3 col-md-3 col-3 require">Address:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="from_address" name="from_address" value="@if(isset($objOrder->from_address)){{ $objOrder->from_address }}@endif" placeholder="Address" required/>
                            </div>
                            <label for="from_address" class="col-lg-3 col-md-3 col-3"></label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="from_address2" name="from_address2" value="@if(isset($objOrder->from_address2)){{ $objOrder->from_address2 }}@endif" placeholder="Address 2"/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="from_city" class="col-lg-3 col-md-3 col-3 require">City:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="from_city" name="from_city" value="@if(isset($objOrder->from_city)){{ $objOrder->from_city }}@endif" placeholder="City" required/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="from_state" class="col-lg-3 col-md-3 col-3 require">Province / State:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="from_state" name="from_state" value="@if(isset($objOrder->from_state)){{ $objOrder->from_state }}@endif" placeholder="Province / State" required/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="from_postal" class="col-lg-3 col-md-3 col-3 require">Postal / Zip Code:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="from_postal" name="from_postal" value="@if(isset($objOrder->from_postal)){{ $objOrder->from_postal }}@endif" placeholder="Postal / Zip Code" required/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="from_country_id" class="col-lg-3 col-md-3 col-3 require">Country:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <select id="from_country_id" name="from_country_id">
                                    @foreach ($country as $value)
                                        <option @if(isset($objOrder->from_country_id) && $objOrder->from_country_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="from_date" class="col-lg-3 col-md-3 col-3 require">Pickup Date:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="date" class="form-control" id="from_date" name="from_date" value="@if(isset($objOrder->from_date)){{ $objOrder->from_date }}@endif" placeholder="Pickup Date" required/>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-details d-flex align-items-center">
                            <h5 class="m-0">To</h5>
                            </div>
                            <div class="form-group row">
                            <label for="to_company" class="col-lg-3 col-md-3 col-3 require">Company:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="to_company" name="to_company" value="@if(isset($objData->to_company)){{ $objData->to_company }}@else{{ $objOrder->to_company }}@endif" placeholder="Company" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="to_contact" class="col-lg-3 col-md-3 col-3">Contact:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="to_contact" name="to_contact" value="@if(isset($objData->to_contact)){{ $objData->to_contact }}@else{{ $objOrder->to_contact }}@endif" placeholder="Contact"/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="to_phone" class="col-lg-3 col-md-3 col-3">Phone:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="to_phone" name="to_phone" value="@if(isset($objData->to_phone)){{ $objData->to_phone }}@else{{ $objOrder->to_phone }}@endif" placeholder="Phone"/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="to_address" class="col-lg-3 col-md-3 col-3 require">Address:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="to_address" name="to_address" value="@if(isset($objData->to_address)){{ $objData->to_address }}@else{{ $objOrder->to_address }}@endif" placeholder="Address" required/>
                            </div>
                            <label for="to_address" class="col-lg-3 col-md-3 col-3"></label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="to_address2" name="to_address2" value="@if(isset($objData->to_address2)){{ $objData->to_address2 }}@else{{ $objOrder->to_address2 }}@endif" placeholder="Address 2"/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="to_city" class="col-lg-3 col-md-3 col-3 require">City:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="to_city" name="to_city" value="@if(isset($objData->to_city)){{ $objData->to_city }}@else{{ $objOrder->to_city }}@endif" placeholder="City" required/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="to_state" class="col-lg-3 col-md-3 col-3 require">Province / State:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="to_state" name="to_state" value="@if(isset($objData->to_state)){{ $objData->to_state }}@else{{ $objOrder->to_state }}@endif" placeholder="Province / State" required/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="to_postal" class="col-lg-3 col-md-3 col-3 require">Postal / Zip Code:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="text" class="form-control" id="to_postal" name="to_postal" value="@if(isset($objData->to_postal)){{ $objData->to_postal }}@else{{ $objOrder->to_postal }}@endif" placeholder="Postal / Zip Code" required/>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="to_country_id" class="col-lg-3 col-md-3 col-3 require">Country:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <select id="to_country_id" name="to_country_id">
                                    @foreach ($country as $value)
                                        <option @if(isset($objData->to_country_id) && $objData->to_country_id == $value->id) selected  @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="to_date" class="col-lg-3 col-md-3 col-3 require">Pickup Date:</label>
                            <div class="col-lg-9 col-md-9 col-9">
                                <input type="date" class="form-control" id="to_date" name="to_date" value="@if(isset($objData->to_date)){{ $objData->to_date }}@else{{ $objOrder->to_date }}@endif" placeholder="Pickup Date" required/>
                            </div>
                            </div>
                        </div>
                    </div>
                    </div>
               </div>
            </div>
        </div>
       </div>
    </div>
 </form>
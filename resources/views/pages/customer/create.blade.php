<form id="submit-form" action="{{ $action }}" class="form-customer" method="POST" autocomplete="off">
    @csrf
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
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="company" class="col-lg-3 col-md-3 col-3 require">Company:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="company" name="company" value="@if(isset($objData->company)){{ $objData->company }}@endif" placeholder="Company" maxlength="50" required autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contact" class="col-lg-3 col-md-3 col-3">Contact:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="contact" name="contact" value="@if(isset($objData->contact)){{ $objData->contact }}@endif" placeholder="Contact"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-lg-3 col-md-3 col-3">Phone:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="phone" name="phone" value="@if(isset($objData->phone)){{ $objData->phone }}@endif" placeholder="Phone"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone_other" class="col-lg-3 col-md-3 col-3">Phone other:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="phone_other" name="phone_other" value="@if(isset($objData->phone_other)){{ $objData->phone_other }}@endif" placeholder="Phone other"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fax" class="col-lg-3 col-md-3 col-3">Fax:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="fax" name="fax" value="@if(isset($objData->fax)){{ $objData->fax }}@endif" placeholder="Fax"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-lg-3 col-md-3 col-3">Email:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="email" class="form-control" id="email" name="email" value="@if(isset($objData->email)){{ $objData->email }}@endif" placeholder="Email"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="charge_hst_id" class="col-lg-3 col-md-3 col-3">HST:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <select id="charge_hst_id" name="charge_hst_id">
                            @foreach ($chargesHst as $value)
                                <option @if(isset($objData->charge_hst_id) && $objData->charge_hst_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="charge_fuel_id" class="col-lg-3 col-md-3 col-3">Fuel:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <select id="charge_fuel_id" name="charge_fuel_id">
                            @foreach ($chargesFuel as $value)
                                <option @if(isset($objData->charge_fuel_id) && $objData->charge_fuel_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                            @endforeach
                        </select>
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
                    <label for="terms" class="col-lg-3 col-md-3 col-3">Payment terms:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <select id="terms" name="terms">
                            <option @if(isset($objData->terms) && $objData->terms == '15') selected @endif value="15">15 days</option>
                            <option @if(isset($objData->terms) && $objData->terms == '30') selected @endif value="30">30 days</option>
                            <option @if(isset($objData->terms) && $objData->terms == '60') selected @endif value="60">60 days</option>
                            <option @if(isset($objData->terms) && $objData->terms == '90') selected @endif value="90">90 days</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="comments" class="col-lg-3 col-md-3 col-3">Comments:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <textarea class="form-control" id="comments" name="comments" placeholder="Comments"/>@if(isset($objData->comments)){{ $objData->comments }}@endif</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="form-details">Mailing Address</h5>
                <div class="form-group row">
                    <label for="address" class="col-lg-3 col-md-3 col-3 require">Address:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="address" name="address" value="@if(isset($objData->address)){{ $objData->address }}@endif" placeholder="Address" required/><br>
                    </div>
                    <label for="address" class="col-lg-3 col-md-3 col-3"></label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="address2" name="address2" value="@if(isset($objData->address2)){{ $objData->address2 }}@endif" placeholder="Address 2"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-lg-3 col-md-3 col-3 require">City:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="city" name="city" value="@if(isset($objData->city)){{ $objData->city }}@endif" placeholder="City" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-lg-3 col-md-3 col-3 require">Province / State:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="state" name="state" value="@if(isset($objData->state)){{ $objData->state }}@endif" placeholder="Province / State" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postal" class="col-lg-3 col-md-3 col-3 require">Postal / Zip Code:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="postal" name="postal" value="@if(isset($objData->postal)){{ $objData->postal }}@endif" placeholder="Postal / Zip Code" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="country_id" class="col-lg-3 col-md-3 col-3 require">Country:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <select id="country_id" name="country_id">
                            @foreach ($country as $value)
                                <option @if(isset($objData->country_id) && $objData->country_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="form-details">Billing Address</h5>
                <div class="form-group row">
                    <label for="bill_address" class="col-lg-3 col-md-3 col-3 require">Address:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="bill_address" name="bill_address" value="@if(isset($objData->bill_address)){{ $objData->bill_address }}@endif" placeholder="Billing Address" required/><br>
                    </div>
                    <label for="bill_address" class="col-lg-3 col-md-3 col-3"></label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="bill_address2" name="bill_address2" value="@if(isset($objData->bill_address2)){{ $objData->bill_address2 }}@endif" placeholder="Billing Address 2"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bill_city" class="col-lg-3 col-md-3 col-3 require">City:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="bill_city" name="bill_city" value="@if(isset($objData->bill_city)){{ $objData->bill_city }}@endif" placeholder="Billing City" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bill_state" class="col-lg-3 col-md-3 col-3 require">Province / State:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="bill_state" name="bill_state" value="@if(isset($objData->bill_state)){{ $objData->bill_state }}@endif" placeholder="Billing Province / State" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bill_postal" class="col-lg-3 col-md-3 col-3 require">Postal / Zip Code:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <input type="text" class="form-control" id="bill_postal" name="bill_postal" value="@if(isset($objData->bill_postal)){{ $objData->bill_postal }}@endif" placeholder="Billing Postal / Zip Code" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bill_country_id" class="col-lg-3 col-md-3 col-3 require">Country:</label>
                    <div class="col-lg-9 col-md-9 col-9">
                        <select id="bill_country_id" name="bill_country_id">
                            @foreach ($country as $value)
                                <option @if(isset($objData->bill_country_id) && $objData->bill_country_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
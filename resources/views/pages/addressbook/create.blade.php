<form id="submit-form" action="{{ $action }}" class="form-customer" method="POST" autocomplete="off">
   <div class="container-fluid">
      <div class="row">
         @csrf
         <div class="col-12">
            <div class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center">
               <h3 class="card-title m-0">{{ $pageName }}</h3>
               <div class="d-flex topbtns">
                  @if(Auth::user()->isEmployee() && Auth::user()->dataEntry())
                  <button>Save</button>
                  @endif
                  <button type="button" class="ms-3 goBack">Cancel</button>
               </div>
            </div>
            <h5 class="form-details">{{ $pageName }} Details</h5>
         </div>
         <div class="col-md-6">
            <div class="form-group row">
               <label for="name" class="col-lg-3 col-md-3 col-3 require">Customer:</label>
               <div class="col-9">
                  <select id="customer_id" name="customer_id" class="form-control" autofocus>
                     @foreach ($customer as $value)
                         <option @if(isset($objData->customer_id) && $objData->customer_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->company }}</option>        
                     @endforeach
                 </select>
               </div>
            </div>
            <div class="form-group row">
               <label for="address_name" class="col-lg-3 col-md-3 col-3 require">Address Name:</label>
               <div class="col-9">
                  <input type="text" class="form-control" id="address_name" name="address_name" value="@if(isset($objData->address_name)){{ $objData->address_name }}@endif" placeholder="Address Name" maxlength="50" required>
               </div>
            </div>
            <div class="form-group row">
               <label for="company" class="col-lg-3 col-md-3 col-3 require">Company:</label>
               <div class="col-9">
                  <input type="text" class="form-control" id="company" name="company" value="@if(isset($objData->company)){{ $objData->company }}@endif" placeholder="Company" required/>
               </div>
            </div>
            <div class="form-group row">
               <label for="contact" class="col-lg-3 col-md-3 col-3">Contact:</label>
               <div class="col-9">
                  <input type="text" class="form-control" id="contact" name="contact" value="@if(isset($objData->contact)){{ $objData->contact }}@endif" placeholder="Contact"/>
               </div>
            </div>
            <div class="form-group row">
               <label for="phone" class="col-lg-3 col-md-3 col-3">Phone:</label>
               <div class="col-9">
                  <input type="text" class="form-control" id="phone" name="phone" value="@if(isset($objData->phone)){{ $objData->phone }}@endif" placeholder="Phone"/>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group row">
               <label for="address" class="col-lg-2 col-md-2 col-4 require">Address:</label>
               <div class="col-lg-10 col-md-10 col-8">
                   <input type="text" class="form-control" id="address" name="address" value="@if(isset($objData->address)){{ $objData->address }}@endif" placeholder="Address" required/><br>
               </div>
               <label for="address" class="col-lg-2 col-md-2 col-4"></label>
               <div class="col-lg-10 col-md-10 col-8">
                  <input type="text" class="form-control" id="address2" name="address2" value="@if(isset($objData->address2)){{ $objData->address2 }}@endif" placeholder="Address 2"/>
              </div>
           </div>
           <div class="form-group row">
               <label for="city" class="col-lg-2 col-md-2 col-4 require">City:</label>
               <div class="col-lg-10 col-md-10 col-8">
                   <input type="text" class="form-control" id="city" name="city" value="@if(isset($objData->city)){{ $objData->city }}@endif" placeholder="City" required/>
               </div>
           </div>
           <div class="form-group row">
               <label for="state" class="col-lg-2 col-md-2 col-4 require">Province / State:</label>
               <div class="col-lg-10 col-md-10 col-8">
                   <input type="text" class="form-control" id="state" name="state" value="@if(isset($objData->state)){{ $objData->state }}@endif" placeholder="Province / State" required/>
               </div>
           </div>
           <div class="form-group row">
               <label for="postal" class="col-lg-2 col-md-2 col-4 require">Postal / Zip Code:</label>
               <div class="col-lg-10 col-md-10 col-8">
                   <input type="text" class="form-control" id="postal" name="postal" value="@if(isset($objData->postal)){{ $objData->postal }}@endif" placeholder="Postal / Zip Code" required/>
               </div>
           </div>
           <div class="form-group row">
               <label for="country_id" class="col-lg-2 col-md-2 col-4 require">Country:</label>
               <div class="col-lg-10 col-md-10 col-8">
                   <select id="country_id" name="country_id">
                       @foreach ($country as $value)
                           <option @if(isset($objData->country_id) && $objData->country_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>        
                       @endforeach
                   </select>
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
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
            <h5 class="form-details">{{ $pageName }} Details</h5>
         </div>
         <div class="col-md-6">
            <div class="form-group row">
               <label for="name" class="col-lg-3 col-md-3 col-3 require">Customer:</label>
               <div class="col-lg-9 col-md-9 col-9">
                  <select id="customer_id" name="customer_id" class="form-control" autofocus>
                     @foreach ($customer as $value)
                         <option @if(isset($objData->customer_id) && $objData->customer_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->company }}</option>        
                     @endforeach
                 </select>
               </div>
            </div>
            <div class="form-group row">
               <label for="name" class="col-lg-3 col-md-3 col-3 require">User Name:</label>
               <div class="col-lg-9 col-md-9 col-9">
                  <input type="text" class="form-control" id="name" name="name" value="@if(isset($objData->name)){{ $objData->name }}@endif" placeholder="User Name" maxlength="50" required>
               </div>
            </div>
            <div class="form-group row">
               <label for="username" class="col-lg-3 col-md-3 col-3 require">Login ID:</label>
               <div class="col-lg-9 col-md-9 col-9">
                  <input type="text" class="form-control" id="username" name="username" value="@if(isset($objData->username)){{ $objData->username }}@endif" placeholder="Login ID" maxlength="25" required/>
               </div>
            </div>
            <div class="form-group row">
               <label for="password" class="col-lg-3 col-md-3 col-3">New password:</label>
               <div class="col-lg-9 col-md-9 col-9">
                  <input type="password" class="form-control" id="password" name="password"/>
               </div>
            </div>
            <div class="form-group row">
               <label for="verify_password" class="col-lg-3 col-md-3 col-3">Verify password:</label>
               <div class="col-lg-9 col-md-9 col-9">
                  <input type="password" class="form-control" id="verify_password" name="verify_password"/>
               </div>
            </div>
            <div class="form-group row">
               <label for="is_stystem" class="col-lg-3 col-md-3 col-3">System Account:</label>
               <div class="col-lg-9 col-md-9 col-9">
                  <select name="is_stystem" class="form-control" id="is_stystem" @if(isset($objData) && $objData->is_system == 1)) disabled @endif>
                     <option @if(isset($objData->is_stystem) && $objData->is_stystem == 0) selected @endif value="0">No</option>
                     <option @if(isset($objData->is_stystem) && $objData->is_stystem == 1) selected @endif value="1">Yes</option>
                  </select>
               </div>
            </div>
            <div class="form-group row">
               <label for="is_block" class="col-lg-3 col-md-3 col-3">Block User:</label>
               <div class="col-lg-9 col-md-9 col-9">
                  <select name="is_block" class="form-control" id="is_block" @if(isset($objData) && $objData->is_system == 1)) disabled @endif>
                     <option @if(isset($objData->is_block) && $objData->is_block == 0) selected @endif value="0">No</option>
                     <option @if(isset($objData->is_block) && $objData->is_block == 1) selected @endif value="1">Yes</option>
                  </select>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group row">
               <label for="name" class="col-lg-3 col-md-3 col-3">Access Control:</label>
               <div class="col-lg-9 col-md-9 col-9">
                  <input type="checkbox" name="permission[]" @if(isset($objData) && $objData->is_system == 1)) disabled @endif @if(isset($objData->permission) && in_array('Data entry',json_decode($objData->permission))) checked @endif value="Data entry">&nbsp;Data entry<br>
                  <input type="checkbox" name="permission[]" @if(isset($objData) && $objData->is_system == 1)) disabled @endif @if(isset($objData->permission) && in_array('Invoicing',json_decode($objData->permission))) checked @endif value="Invoicing">&nbsp;Invoicing<br>
                  <input type="checkbox" name="permission[]" @if(isset($objData) && $objData->is_system == 1)) disabled @endif @if(isset($objData->permission) && in_array('Manage Users',json_decode($objData->permission))) checked @endif value="Manage Users">&nbsp;Manage Users<br>
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
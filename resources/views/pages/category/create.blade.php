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
         <div class="col-md-12 mt-4">
            <div class="form-group row">
               <label for="name" class="col-lg-3 col-md-3 col-3 require">Name:</label>
               <div class="col-9">
                  <input type="text" class="form-control" id="name" name="name" value="@if(isset($objData->name)){{ $objData->name }}@endif" placeholder="Name" maxlength="50" required autofocus>
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
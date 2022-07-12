@extends('layouts.master')

@section('styles')
<!------------------------New css for datatable-------------------------------------------->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-fluid form-filter">
       <div class="row back-white p-3" id="content-table">
          <div class="col-12">
             <div
                class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center"
                >
                <h3 class="card-title m-0">{{ $pageName }}</h3>
             </div>
          </div>
          <hr class="main-hr-table">
        <form action="javascript:void(0)" id="filter-form">
           <div class="col-12 mb-3">
              <div class="row align-items-center">
                 <div class="col-lg-8 col-md-10 col-12">
                    <div class="form-group row mb-1">
                       <div class="col-lg-2 col-md-2 col-12">
                          <p>Date from:</p>
                       </div>
                       <div class="col-lg-3 col-md-3 col-5">
                          <input type="date" class="form-control" name="start_date"/>
                       </div>
                       <div class="col-lg-1 col-md-1 col-2">
                          <p>To:</p>
                       </div>
                       <div class="col-lg-3 col-md-3 col-5">
                          <input type="date" class="form-control" name="end_date"/>
                       </div>
                    </div>
                    <div class="form-group row mb-1">
                          <div class="col-lg-2 col-md-2 col-12">
                             <p>Filter by:</p>
                          </div>
                          <div class="col-lg-3 col-md-3 col-6">
                             <select name="filter_by">
                                <option value="">--- Select a field ---</option>
                                <option value="carrier">Carrier</option>
                                <option value="order_id">Order Id</option>
                                <option value="currency">Currency</option>
                             </select>
                          </div>

                          <input class="col-lg-7 col-md-7 col-6" type="text" placeholder="Search Value" name="filter"/>
                    </div>
                 </div>
                 <div class="col-lg-4 col-md-12 col-12">
                    <div class="d-flex align-items-center">
                     <div class="form-checkbox">
                           <div class="row">
                              <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group d-flex align-items-center mb-0">
                                       <input type="checkbox" name="outstanding" id="outstanding" value="1" />
                                       <label class="mb-0 ms-2">Outstanding</label>
                                    </div>
                              </div>
                              <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group d-flex align-items-center mb-0">
                                       <input type="checkbox" name="invoiced" id="invoiced" value="1"  />
                                       <label class="mb-0 ms-2">Invoiced</label>
                                    </div>
                              </div>
                           </div>
                        </div>
                        <div class="btns">
                           <button type="button" id="search-filter">Search</button>
                           <button type="button" id="clear-filter">Cancel</button>
                        </div>
                    </div>
                 </div>
              </div>
           </div>
        </form>
     <hr class="main-hr-table">
          <div class="col-12 table-responsive">
             <table id="dataTable" class="table table-responsive" data-table-ajax="true" data-table-href="{{ $dataTables }}" data-edit-href="{{ $edit }}" data-order-href="{{ $order }}" data-create-href="{{ $create }}">
                <thead>
                   <tr>
                      <th>#</th>
                      <th>Carrier</th>
                      <th>Order ID</th>
                      <th>PCS</th>
                      <th>Order Status</th>
                      <th>Delivery Date</th>
                      <th>Agreed Price</th>
                      <th>Curr</th>
                      <th>Payment ID</th>
                   </tr>
                </thead>
             </table>
          </div>
       </div>
       <div class="row back-white p-3" id="content-form" style="display: none">
            
       </div>
    </div>
 </div>
@endsection

@section('js')
<!--New js files for datatable ---------------------------------->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="{{ asset('admin/custom.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function() {
        table.DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
               url: table.data('table-href'),
               data: function (d) {
                  d.start_date = $("input[name=start_date]").val(),
                  d.end_date = $("input[name=end_date]").val(),
                  d.filter_by = $("select[name=filter_by]").val(),
                  d.filter = $("input[name=filter]").val()
               },
            },
            columns: [
               {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return meta.row+1;
                    }
                },
                {data: 'carrier', name: 'carrier'},
                {data: 'order_id', name:'order_id',
                    "render": function ( data, type, row, meta ) {
                        return '<a href="javascript:void(0)" class="open-custom namelink" data-id="'+row.order_id+'">'+row.order_id+'</a>';
                    }
                },
                {data: 'pcs', name: 'pcs'},
                {data: 'status', name: 'status'},
                {data: 'delivery_date', name: 'delivery_date'},
                {data: 'agreed_price', name: 'agreed_price'},
                {data: 'currency', name: 'currency'},
                {data: 'payment_id', name:'payment_id',
                    "render": function ( data, type, row, meta ) {
                        if(row.payment_id){
                           return '<a href="javascript:void(0)" class="open-form namelink" data-type="order" data-id="'+row.payment_id+'">'+row.payment_id+'</a>';
                        }else{
                           return '<a href="javascript:void(0)" class="open-custom namelink" data-type="create" data-id="'+row.id+'">Enter Payment</a>';
                        }
                    }
                },
            ]
        });
   } );

   jQuery('body').on('click','.open-custom',function(){
      if($(this).data('type') == 'order'){
         var link = table.data('order-href')+'/'+$(this).data('id');
      }else{
         var link = table.data('create-href')+'/'+$(this).data('id');
      }
      
      $.ajax({
         url: link,
         success: function (response) {
               if((response.error)){
                  errorFun(response.error);
               }else{
                  $('#content-form, #content-table').toggle();
                  $('#content-form').html(response);
               }
         },
         error: function (error) {
               warningFun();
         }
      });
   });
</script>
@endsection
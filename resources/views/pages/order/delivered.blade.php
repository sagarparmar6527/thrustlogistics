@extends('layouts.master')

@section('styles')
<!------------------------New css for datatable-------------------------------------------->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
   .is_ready{width: 12px !important;height: 12px !important;}
</style>
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
                <div class="d-flex topbtns">
                   <a href="javascript:void(0)" class="ms-3 btn-link btn-top-link" id="invoice-orders" data-invoice-href={{ $invoice }}>Invoice Orders</a>
                </div>
             </div>
          </div>
          <hr class="main-hr-table">
            <form action="javascript:void(0)" id="filter-form">
               <div class="col-12 mb-3">
                  <div class="row align-items-center">
                     <div class="col-lg-9 col-md-10 col-12">
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
                                    <option value="order_id">Order ID</option>
                                    <option value="customer">Customer</option>
                                    <option value="ref_number">Ref.No</option>
                                    <option value="currency">Currency</option>
                                 </select>
                              </div>

                              <input class="col-lg-7 col-md-7 col-6" type="text" placeholder="Search Value" name="filter"/>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex align-items-center">
                              <div class="form-checkbox">
                                 <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                          <div class="form-group d-flex align-items-center mb-0">
                                             <input type="checkbox" name="is_invoice_ready" id="is_invoice_ready" value="1" />
                                             <label class="mb-0 ms-2">Ready to be invoiced</label>
                                          </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                          <div class="form-group d-flex align-items-center mb-0">
                                             <input type="checkbox" name="is_invoice_rush" id="is_invoice_rush" value="1"  />
                                             <label class="mb-0 ms-2">Rush billing</label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="btns">
                                 <button type="button" id="search-filter">Search</button>
                                 <button type="button" id="clear-filter" class="mt-3">Cancel</button>
                              </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         <hr class="main-hr-table">
          <div class="col-12 table-responsive">
             <table id="dataTable" class="table table-responsive" data-table-ajax="true" data-table-href="{{ $dataTables }}" data-edit-href="{{ $edit }}">
                <thead>
                   <tr>
                      <th>#</th>
                      <th>Customer</th>
                      <th>Ready</th>
                      <th>PickUp Date</th>
                      <th>OrderID</th>
                      <th>PCS</th>
                      <th>Service</th>
                      <th>Amt</th>
                      <th>Adj</th>
                      <th>GST</th>
                      <th>HST</th>
                      <th>Fuel</th>
                      <th>Total</th>
                      <th>Curr</th>
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
                  d.filter = $("input[name=filter]").val(),
                  d.is_invoice_ready = $("#is_invoice_ready:checked").val(),
                  d.is_invoice_rush = $("#is_invoice_rush:checked").val(),
                  d.status_id = JSON.stringify(['4'])
               },
            },
            columns: [
               {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return meta.row+1;
                    }
                },
                {data: 'customer.company', name:'customer.company', class:'tooltip-td',
                    "render": function ( data, type, row, meta ) {
                        return row.customer.company;
                    }
                },
                {data: 'is_invoice_ready', name:'is_invoice_ready',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                0: {'src': 'disabled.png', 'alt': 'Disabled'},
                                1: {'src': 'enabled.png', 'alt': 'Enabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.is_invoice_ready].src + '" class="is_ready" border="0" alt="'+status[row.is_invoice_ready].src +'">';
                    }
                },
                {data: 'from_date', name: 'from_date'},
                {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return '<a href="javascript:void(0)" class="open-form namelink" data-id="'+row.id+'">'+row.id+'</a>';
                    }
                },
                {data: 'pcs', name: 'pcs'},
                {data: 'service', name: 'service'},
                {data: 'service_charge', name: 'service_charge'},
                {data: 'adjustments_charge', name: 'adjustments_charge'},
                {data: 'gst_charge', name: 'gst_charge'},
                {data: 'hst_charge', name: 'hst_charge'},
                {data: 'fuel_charge', name: 'fuel_charge'},
                {data: 'total_charges', name: 'total_charges'},
                {data: 'currency', name: 'currency'}
            ]
        });

         jQuery("body").on("click","#invoice-orders",function(){
            var action = $(this).data('invoice-href');
            Swal.fire({
               title: "Are you sure you want to invoice the listed orders?",
               text: "Note :- Not ready orders will be skipped!",
               icon: "warning",
               showCancelButton: true,
               confirmButtonText: "Yes, Invoice Orders!",
               cancelButtonText: "No, cancel!",
               reverseButtons: true
            }).then(function(result) {
               if (result.value) {
                     $.ajax({
                        url: action,
                        success: function (response) {
                           if((response.error)){
                              Swal.fire("Oops!", response.error, "warning");
                           }else{
                              window.location.replace(response.success);
                           }
                        },error: function (response) {
                           Swal.fire("Oops!", "something went wrong!", "warning");
                        }
                     });
               } else if (result.dismiss === "cancel") {
                     Swal.fire("Cancelled","Your records are not invoiced :)","error");
               }
            });
         });
   } );
</script>
@endsection
@extends('layouts.master')

@section('styles')
<!------------------------New css for datatable-------------------------------------------->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
   .printed{width: 12px !important;height: 12px !important;}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-fluid form-filter">
       <div class="row back-white p-3" id="content-table">
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
                                <option value="invoice_id">Invoice ID</option>
                                <option value="customer">Customer</option>
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
                                         <input type="checkbox" name="printed" id="printed" value="0" />
                                         <label class="mb-0 ms-2">Not printed</label>
                                      </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                      <div class="form-group d-flex align-items-center mb-0">
                                         <input type="checkbox" name="withdrawn" id="outstanding" value="0"  />
                                         <label class="mb-0 ms-2">Outstanding</label>
                                      </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group d-flex align-items-center mb-0">
                                       <input type="checkbox" name="withdrawn" id="withdrawn" value="0"  />
                                       <label class="mb-0 ms-2">Withdrawn</label>
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
                      <th>Invoice</th>
                      <th>Date</th>
                      <th>Customer</th>
                      <th>GST</th>
                      <th>HST</th>
                      <th>Fuel</th>
                      <th>Total</th>
                      <th>Curr</th>
                      <th>Printed</th>
                      <th>Paid</th>
                      <th>Amount</th>
                      <th>Credit</th>
                      <th>Amt Due</th>
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
                  d.printed = $("#printed:checked").val(),
                  d.withdrawn = $("#withdrawn:checked").val()
               },
            },
            columns: [
               {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return meta.row+1;
                    }
                },
                {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return '<a href="javascript:void(0)" class="open-form namelink" data-id="'+row.id+'">'+row.id+'</a>';
                    }
                },
                {data: 'invoice_date', name: 'invoice_date'},
                {data: 'customer', name:'customer', class:'tooltip-td',
                    "render": function ( data, type, row, meta ) {
                        return row.customer;
                    }
                },
                {data: 'charge_gst', name: 'charge_gst'},
                {data: 'charge_hst', name: 'charge_hst'},
                {data: 'charge_fuel', name: 'charge_fuel'},
                {data: 'charge_total', name: 'charge_total'},
                {data: 'currency', name: 'currency'},
                {data: 'printed', name:'printed',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                0: {'src': 'disabled.png', 'alt': 'Disabled'},
                                1: {'src': 'enabled.png', 'alt': 'Enabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.printed].src + '" class="printed" border="0" alt="'+status[row.printed].src +'">';
                    }
                },
                {data: 'is_paid', name:'is_paid',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                0: {'src': 'disabled.png', 'alt': 'Disabled'},
                                1: {'src': 'enabled.png', 'alt': 'Enabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.is_paid].src + '" class="printed" border="0" alt="'+status[row.is_paid].src +'">';
                    }
                },
                {data: 'paid_amt', name: 'paid_amt'},
                {data: 'credit_amt', name: 'credit_amt'},
                {data: 'amt_due', name: 'amt_due'},
                {data: 'currency', name: 'currency'}
            ]
        });
   } );
</script>
@endsection
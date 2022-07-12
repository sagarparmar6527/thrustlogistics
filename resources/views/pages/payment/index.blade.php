@extends('layouts.master')

@section('styles')
<!------------------------New css for datatable-------------------------------------------->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    .is_paid{width: 12px !important;height: 12px !important;}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
       <div class="row back-white p-3" id="content-table">
          <div class="col-12">
             <div
                class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center"
                >
                <h3 class="card-title m-0">{{ $pageName }}</h3>
                <div class="d-flex topbtns">
                   <a href="javascript:void(0)" class="ms-3 open-form btn-link" data-create-href={{ $create }}>New Payment</a>
                </div>
             </div>
          </div>
          <div class="col-12 table-responsive">
             <table id="dataTable" class="table table-responsive" data-table-ajax="true" data-table-href="{{ $dataTables }}" data-delete-href="{{ $delete }}" data-edit-href="{{ $edit }}">
                <thead>
                   <tr>
                      <th>#</th>
                      <th>Payment</th>
                      <th>Payable Name</th>
                      <th>Category</th>
                      <th>Invoice No</th>
                      <th>Invoice Date</th>
                      <th>GST</th>
                      <th>HST</th>
                      <th>Total</th>
                      <th>Curr</th>
                      <th>Paid</th>
                      <th>Cheque No</th>
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
            ajax: table.data('table-href'),
            columns: [
               {data: 'data_entry', name:'data_entry',
                    "render": function ( data, type, row, meta ) {
                        return meta.row+1;
                    }
                },
                {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return '<a href="javascript:void(0)" class="open-form namelink" data-id="'+row.id+'">'+row.id+'</a>';
                    }
                },
                {data: 'invoice_payable', name:'invoice_payable'},
                {data: 'invoice_category', name:'invoice_category'},
                {data: 'invoice_no', name:'invoice_no'},
                {data: 'invoice_date', name:'invoice_date'},
                {data: 'gst', name:'gst'},
                {data: 'hst', name:'hst'},
                {data: 'total', name:'total'},
                {data: 'currency', name:'currency'},
                {data: 'is_paid', name:'is_paid',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                0: {'src': 'enabled.png', 'alt': 'Enabled'},
                                1: {'src': 'disabled.png', 'alt': 'Disabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.is_paid].src + '" class="is_paid" border="0" alt="'+status[row.is_paid].src +'">';
                    }
                },
                {data: 'paid_chq', name:'paid_chq'}
            ]
        });
   } );
</script>
@endsection
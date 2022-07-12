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
             </div>
          </div>
          <hr class="main-hr-table">
            <form action="javascript:void(0)" id="filter-form">
               <div class="col-12 mb-3">
                  <div class="row align-items-center">
                     <div class="col-lg-10 col-md-10 col-12">
                        <div class="form-group row mb-1">
                              <div class="col-lg-2 col-md-2 col-12">
                                 <p>Object:</p>
                              </div>
                              <div class="col-lg-3 col-md-3 col-6">
                                 <select name="filter_by">
                                    <option value="order_id">Order ID</option>
                                 </select>
                              </div>

                              <input class="col-lg-7 col-md-7 col-6" type="text" placeholder="Order Id" name="order_id"/>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-flex align-items-center">
                              <div class="btns">
                                 <button type="button" id="search-filter">Search</button>
                                 <button type="button" id="clear-filter" >Cancel</button>
                              </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         <hr class="main-hr-table">
          <div class="col-12 table-responsive">
             <table id="dataTable" class="table table-responsive" data-table-ajax="true" data-table-href="{{ $dataTables }}" data-permanent-delete-href="{{ $permanentDelete }}" data-restore-href="{{ $restore }}">
                <thead>
                   <tr>
                      <th>#</th>
                      <th>Deleted On</th>
                      <th>Deleted By</th>
                      <th>Comments</th>
                      <th>OrderID</th>
                      <th>Customer</th>
                      <th>Service</th>
                      <th>Status</th>
                      <th>Action</th>
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
                  d.order_id = $("input[name=order_id]").val()
               },
            },
            columns: [
               {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return meta.row+1;
                    }
                },
                {data: 'deleted_at', name: 'deleted_at'},
                {data: 'deleted_by', name: 'deleted_by'},
                {data: 'deleted_comments', name: 'deleted_comments'},
                {data: 'id', name: 'id'},
                {data: 'customer', name: 'customer'},
                {data: 'service', name: 'service'},
                {data: 'status', name: 'status'},
                {data: 'id', name:'id',searchable: false,class:'edit-list',
                    "render": function ( data, type, row, meta ) {
                        return '<span><a href="javascript:void(0)" class="edit-btns green restore" data-id="'+row.id+'"><i class="fa-solid fa-undo"></i></a>&nbsp;&nbsp<a href="javascript:void(0)" class="edit-btns red permanent-delete" data-id="'+row.id+'"><i class="fa-solid fa-trash-can"></i></a></span>';
                    }
                },
            ]
        });
   } );

   /* Delete And Restore Record */
    jQuery('body').on('click','.permanent-delete',function(){
        var $this = $(this);
        var action = table.data('permanent-delete-href');
        var id = $this.data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this records!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: action+'/'+id,
                    success: function (response) {
                        $this.parents('tr').remove();
                        Swal.fire("Deleted!",data,"success");
                    },error: function (response) {
                        Swal.fire("Oops!", "something went wrong!", "warning");
                    }
                });
            } else if (result.dismiss === "cancel") {
                Swal.fire("Cancelled","Your records is safe :)","error");
            }
        });
    });

    jQuery('body').on('click','.restore',function(){
        var $this = $(this);
        var action = table.data('restore-href');
        var id = $this.data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "Once Restore, record visible in order listing",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, restore it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: action+'/'+id,
                    success: function (response) {
                        $this.parents('tr').remove();
                        Swal.fire("Deleted!",data,"success");
                    },error: function (response) {
                        Swal.fire("Oops!", "something went wrong!", "warning");
                    }
                });
            } else if (result.dismiss === "cancel") {
                Swal.fire("Cancelled","Your records is not restore :)","error");
            }
        });
    });
</script>
@endsection
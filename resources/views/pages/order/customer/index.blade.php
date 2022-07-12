@extends('layouts.master')

@section('styles')
<!------------------------New css for datatable-------------------------------------------->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
   .is_carrier{width: 12px !important;height: 12px !important;}
   .tooltip-img {width: 20px !important;height: 20px !important;}
   .tooltip-btn {cursor: pointer;position: relative;width: fit-content;background-color: transparent;border: none;}
   .tooltip-td {position: relative;}
   .classic {position: absolute;width: 200px;height: 70px;word-wrap: break-word;background-color: white;border-radius: 10px;padding-left: 20px;padding-top: 10px;display: none;top: 10px;z-index: 999;border: 1px solid #2896d3;}
   .gh {position: absolute;width: 200px;height: 70px;word-wrap: break-word;background-color: white;border-radius: 10px;padding-left: 20px;padding-top: 10px;top: 10px;left: 60px;z-index: 999;border: 1px solid #2896d3;display: block;}
   .view {width: 14px !important;height: 14px !important;margin-right: 6px;}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-fluid form-filter">
       <div class="row back-white p-3" id="content-table">
         @if(Auth::user()->dataEntry())
          <div class="col-12">
             <div
                class="d-lg-flex d-md-flex d-block my-3 justify-content-between align-items-center"
                >
                <h3 class="card-title m-0">{{ $pageName }}</h3>
                <div class="d-flex topbtns">
                   <a href="javascript:void(0)" class="ms-3 open-form btn-link" data-create-href={{ $create }}>New</a>
                </div>
             </div>
          </div>
          @endif
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
                              <input type="date" class="form-control" name="start_date" value="@if(isset($posts)){{ $posts['start_date'] }}@endif"/>
                           </div>
                           <div class="col-lg-1 col-md-1 col-2">
                              <p>To:</p>
                           </div>
                           <div class="col-lg-3 col-md-3 col-5">
                              <input type="date" class="form-control" name="end_date" value="@if(isset($posts)){{ $posts['end_date'] }}@endif"/>
                           </div>
                        </div>
                        <div class="form-group row mb-1">
                              <div class="col-lg-2 col-md-2 col-12">
                                 <p>Filter by:</p>
                              </div>
                              <div class="col-lg-3 col-md-3 col-6">
                                 <select name="filter_by">
                                    <option value="">--- Select a field ---</option>
                                    <option @if(isset($posts) && $posts['filter_by'] == 'order_id') selected @endif value="order_id">Order ID</option>
                                    <option @if(isset($posts) && $posts['filter_by'] == 'ref_number') selected @endif value="ref_number">Ref.No</option>
                                 </select>
                              </div>

                              <input class="col-lg-7 col-md-7 col-6" type="text" name="filter" value="@if(isset($posts)){{ $posts['filter'] }}@endif"/>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-12 col-12">
                        <div class="d-flex align-items-center">
                              <div class="form-checkbox">
                                 <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                          <div class="form-group d-flex align-items-center mb-0">
                                             <input type="checkbox" name="status_id[]" class="status_id" value="1" @if(isset($posts['status_id']) && in_array('1',$posts['status_id'])) checked @endif />
                                             <label class="mb-0 ms-2">Draft</label>
                                          </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                          <div class="form-group d-flex align-items-center mb-0">
                                             <input type="checkbox" name="status_id[]" class="status_id" value="2"  @if(isset($posts['status_id']) && in_array('2',$posts['status_id'])) checked @endif/>
                                             <label class="mb-0 ms-2">Submitted</label>
                                          </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                          <div class="form-group d-flex align-items-center mb-0">
                                             <input type="checkbox" name="status_id[]" class="status_id" value="3" @if(isset($posts['status_id']) && in_array('3',$posts['status_id'])) checked @endif />
                                             <label class="mb-0 ms-2">Dispatched</label>
                                          </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                          <div class="form-group d-flex align-items-center mb-0">
                                             <input type="checkbox" name="status_id[]" class="status_id" value="4"  @if(isset($posts['status_id']) && in_array('4',$posts['status_id'])) checked @endif/>
                                             <label class="mb-0 ms-2">Delivered</label>
                                          </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                          <div class="form-group d-flex align-items-center mb-0">
                                             <input type="checkbox" name="status_id[]" class="status_id" value="5"  @if(isset($posts['status_id']) && in_array('5',$posts['status_id'])) checked @endif/>
                                             <label class="mb-0 ms-2">Invoiced</label>
                                          </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                          <div class="form-group d-flex align-items-center mb-0">
                                             <input type="checkbox" name="status_id[]" class="status_id" value="6" @if(isset($posts['status_id']) && in_array('6',$posts['status_id'])) checked @endif/>
                                             <label class="mb-0 ms-2">Canceled</label>
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
             <table id="dataTable" class="table table-responsive" data-table-ajax="true" data-table-href="{{ $dataTables }}" data-delete-href="{{ $delete }}" data-edit-href="{{ $edit }}">
                <thead>
                   <tr>
                      <th>#</th>
                      <th>OrderID</th>
                      <th>PickUp Date</th>
                      <th>Service</th>
                      <th>Consignor</th>
                      <th>Consignee</th>
                      <th>Ref.No</th>
                      <th>PCS</th>
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
                  d.start_date = $("input[name=start_date]").val(),
                  d.end_date = $("input[name=end_date]").val(),
                  d.filter_by = $("select[name=filter_by]").val(),
                  d.filter = $("input[name=filter]").val(),
                  d.status_id = JSON.stringify($('.status_id:checked').map(function () {
                                    return this.value;
                                 }).get())
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
                {data: 'to_date', name: 'to_date'},
                {data: 'service', name: 'service'},
                {data: 'consignor', name: 'consignor'},
                {data: 'consignee', name: 'consignee'},
                {data: 'ref_number', name: 'ref_number'},
                {data: 'pcs', name: 'pcs'},
                {data: 'status', name: 'status'},
                {data: 'id', name:'id',searchable: false,class:'edit-list',
                    "render": function ( data, type, row, meta ) {
                     var isDelete = '';
                        @if(Auth::user()->isEmployee() && Auth::user()->dataEntry())
                        var isDelete = '<a href="javascript:void(0)" class="edit-btns red delete" data-id="'+row.id+'"><i class="fa-solid fa-trash-can"></i></a>';
                        @endif
                        return '<span><a href="javascript:void(0)" class="edit-btns green open-form" data-id="'+row.id+'"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;&nbsp;'+isDelete+'</span>';
                    }
                },
            ]
        });

         jQuery("body").on("mouseover", ".tooltip-btn",function () {
            $(this).parent().find(".detailss").toggleClass("classic gh");
         });
   } );
</script>
@endsection
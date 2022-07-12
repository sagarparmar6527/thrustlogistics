@extends('layouts.master')

@section('styles')
<!------------------------New css for datatable-------------------------------------------->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    .is_carrier{width: 12px !important;height: 12px !important;}
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
                   <a href="javascript:void(0)" class="ms-3 open-form btn-link" data-create-href={{ $create }}>New</a>
                </div>
             </div>
          </div>
          <hr class="main-hr-table">
            <form action="javascript:void(0)" id="filter-form">
               <div class="col-12 mb-3">
                  <div class="row align-items-center">
                     <div class="col-lg-10 col-md-12 col-12">
                        <div class="form-group row mb-1">
                           <div class="col-lg-3 col-md-3 col-6">
                              <select name="is_carrier">
                                 <option value="">--- Payable type ---</option>
                                 <option value="1">Carriers only</option>
                                 <option value="0">Other payables</option>
                              </select>
                           </div>
                           <div class="col-lg-3 col-md-3 col-6">
                              <select name="filter_by">
                                 <option value="">--- Filter by ---</option>
                                 <option value="company">Company</option>
                                 <option value="contact">Contact</option>
                                 <option value="phone">Phone Number</option>
                                 <option value="fax">Fax Number</option>
                              </select>
                           </div>
                           <input class="col-lg-6 col-md-6 col-6" type="text" placeholder="Search value" name="name"/>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-flex align-items-right">
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
             <table id="dataTable" class="table table-responsive" data-table-ajax="true" data-table-href="{{ $dataTables }}" data-delete-href="{{ $delete }}" data-edit-href="{{ $edit }}">
                <thead>
                   <tr>
                      <th>#</th>
                      <th>Company</th>
                      <th>Carrier</th>
                      <th>Contact</th>
                      <th>Phone</th>
                      <th>Fax</th>
                      <th>Currency</th>
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
                    d.is_carrier = $("select[name=is_carrier]").val(),
                    d.filter_by = $("select[name=filter_by]").val(),
                    d.name = $("input[name=name]").val()
               },
            },
            columns: [
               {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return meta.row+1;
                    }
                },
                {data: 'company', name:'company',
                    "render": function ( data, type, row, meta ) {
                        return '<a href="javascript:void(0)" class="open-form namelink" data-id="'+row.id+'">'+row.company+'</a>';
                    }
                },
                {data: 'is_carrier', name:'is_carrier',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                0: {'src': 'disabled.png', 'alt': 'Disabled'},
                                1: {'src': 'enabled.png', 'alt': 'Enabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.is_carrier].src + '" class="is_carrier" border="0" alt="'+status[row.is_carrier].src +'">';
                    }
                },
                {data: 'contact', name: 'contact'},
                {data: 'phone', name: 'phone'},
                {data: 'fax', name: 'fax'},
                {data: 'currency.name', name: 'currency.name'},
                {data: 'id', name:'id',searchable: false,class:'edit-list',
                    "render": function ( data, type, row, meta ) {
                        return '<span><a href="javascript:void(0)" class="edit-btns green open-form" data-id="'+row.id+'"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;&nbsp;\
                                <a href="javascript:void(0)" class="edit-btns red delete" data-id="'+row.id+'"><i class="fa-solid fa-trash-can"></i></a></span>';
                    }
                },
            ]
        });
   } );
</script>
@endsection
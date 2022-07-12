@extends('layouts.master')

@section('styles')
<!------------------------New css for datatable-------------------------------------------->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    .is_block{width: 12px !important;height: 12px !important;}
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
                              <div class="col-lg-1 col-md-1 col-12">
                                 <p>Customer:</p>
                              </div>
                              <div class="col-lg-5 col-md-5 col-6">
                                 <select name="customer_id">
                                    @foreach ($customer as $value)
                                        <option value="{{ $value->id }}">{{ $value->company }}</option>        
                                    @endforeach
                                 </select>
                              </div>
                              <input class="col-lg-6 col-md-6 col-6" type="text" placeholder="User Name" name="name"/>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-flex align-items-center">
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
                      <th>Enabled</th>
                      <th>User Name</th>
                      <th>Login ID</th>
                      <th>Data Entry</th>
                      <th>Invoicing</th>
                      <th>Manage Users</th>
                      <th>Last Visit</th>
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
                    d.customer_id = $("select[name=customer_id]").val(),
                    d.name = $("input[name=name]").val()
               },
            },
            columns: [
               {data: 'id', name:'id',
                    "render": function ( data, type, row, meta ) {
                        return meta.row+1;
                    }
                },
                {data: 'is_block', name:'is_block',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                0: {'src': 'enabled.png', 'alt': 'Enabled'},
                                1: {'src': 'disabled.png', 'alt': 'Disabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.is_block].src + '" class="is_block" border="0" alt="'+status[row.is_block].src +'">';
                    }
                },
                {data: 'name', name:'name',
                    "render": function ( data, type, row, meta ) {
                        return '<a href="javascript:void(0)" class="open-form namelink" data-id="'+row.id+'">'+row.name+'</a>';
                    }
                },
                {data: 'username', name: 'username',
                    "render": function ( data, type, row, meta ) {
                        var system = (row.is_system) ? '&nbsp;<div class="btn btn-primary">(system account)</div>' :'';
                       return row.username + system;
                    }
                },
                {data: 'data_entry', name:'data_entry',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                false: {'src': 'disabled.png', 'alt': 'Disabled'},
                                true: {'src': 'enabled.png', 'alt': 'Enabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.data_entry].src + '" class="is_block" border="0" alt="'+status[row.data_entry].src +'">';
                    }
                },
                {data: 'invoicing', name:'invoicing',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                false: {'src': 'disabled.png', 'alt': 'Disabled'},
                                true: {'src': 'enabled.png', 'alt': 'Enabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.invoicing].src + '" class="is_block" border="0" alt="'+status[row.data_entry].src +'">';
                    }
                },
                {data: 'manage_users', name:'manage_users',
                    "render": function ( data, type, row, meta ) {
                        var status = {
                                false: {'src': 'disabled.png', 'alt': 'Disabled'},
                                true: {'src': 'enabled.png', 'alt': 'Enabled'},
                            };
                    return '<img src="' + ASSET_URL+'admin/images/'+status[row.manage_users].src + '" class="is_block" border="0" alt="'+status[row.data_entry].src +'">';
                    }
                },
                {data: 'last_visit', name:'last_visit',
                    "render": function ( data, type, row, meta ) {
                        return (row.last_visit) ? row.last_visit : '0000-00-00 00:00:00';
                    }
                },
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
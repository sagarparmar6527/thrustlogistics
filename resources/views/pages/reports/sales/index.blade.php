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
        <form action="{{ $generate }}" method="POST" id="filter-form" target="_Blank">
            @csrf
           <div class="col-12 mb-3">
              <div class="row align-items-center">
                <div class="col-lg-10 col-md-10 col-12">
                    <div class="form-group row mb-1">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group row">
                                <label for="from_date" class="col-lg-3 col-md-3 col-3 require">Invoice Date From:</label>
                                <div class="col-9">
                                    <input type="date" class="form-control" id="from_date" name="from_date" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group row">
                                <label for="to_date" class="col-lg-3 col-md-3 col-3 require">Invoice Date To:</label>
                                <div class="col-9">
                                    <input type="date" class="form-control" id="to_date" name="to_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group row">
                                <label for="ref_number" class="col-lg-3 col-md-3 col-3">Customer:</label>
                                <div class="col-9">
                                    <select name="customer_id" class="form-control">
                                        <option value="">--- Select a Customer ---</option>
                                            @foreach ($customer as $value)
                                                <option value="{{ $value->id }}">{{ $value->company }}</option>        
                                            @endforeach
                                     </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-3">
                        </div>
                        <div class="col-lg-2 col-md-2 col-2">
                            <div class="d-flex align-items-center mb-4">
                                <div class="btns">
                                   <button type="submit">Generate Report</button>
                                </div>
                            </div>
                         </div>
                    </div>
                 </div>
              </div>
           </div>
        </form>
     <hr class="main-hr-table">
    </div>
 </div>
@endsection

@extends('layouts.master') 

@section('content')
<div class="content-wrapper">
   <div class="container-fluid">
      <div class="row backg-white">
         <div class="col-md-6 grid-margin">
            <div class="dashboard-left">
               <div>
                  <h3 class="font-weight-bold">
                     Welcome {{ Auth::user()->name }}
                  </h3>
                  <h6 class="font-weight-normal mb-0">
                     <span
                        class="text-danger font-weight-bold"
                        style="font-weight: bold"
                        >ACS Order Processing System</span
                        >
                     is a web-based application that provides complete
                     set of functions to support Logistics &
                     Transportation business.
                  </h6>
                  <p class="ulhead">Key functions:</p>
                  <ul class="ullist">
                     <li>
                        Role-based user access control - depending on
                        assigned role(s) users could have access to
                        different parts of the system: data entering,
                        invoicing, reporting;
                     </li>
                     <li>
                        Authorized customers could place orders and
                        track orders status;
                     </li>
                     <li>
                        Address book support - pickup and delivery
                        addresses could be stored in customer's address
                        book for later reuse;
                     </li>
                     <li>
                        Automatic Fuel and GST calculation based on
                        customer profile;
                     </li>
                     <li>Supported currencies: USD and CAD;</li>
                     <li>
                        Provided reports: Outstanding receivables,
                        Outstanding payables, Sales, Expense.
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-md-6 grid-margin transparent dashboard-right">
            <div class="row form-control-panel">
               @if(Auth::user()->isEmployee())
                  <div class="col-md-4 mb-4 stretch-card transparent">
                     <div class="card card-light-blue">
                        <div class="card-body">
                           <p class="mb-4">Draft Order</p>
                           <p class="fs-30 mb-2">{{ $draft }}</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 mb-4 stretch-card transparent">
                     <div class="card card-light-blue">
                        <div class="card-body">
                           <p class="mb-4">Submitted Orders</p>
                           <p class="fs-30 mb-2">{{ $submitted }}</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 mb-4 stretch-card transparent">
                     <div class="card card-light-blue">
                        <div class="card-body">
                           <p class="mb-4">Dispatched Orders</p>
                           <p class="fs-30 mb-2">{{ $dispatched }}</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 mb-4 stretch-card transparent">
                     <div class="card card-light-danger">
                        <div class="card-body">
                           <p class="mb-4">Delivered Orders</p>
                           <p class="fs-30 mb-2">{{ $delivered }}</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 mb-4 stretch-card transparent">
                     <div class="card card-light-danger">
                        <div class="card-body">
                           <p class="mb-4">Invoiced Orders</p>
                           <p class="fs-30 mb-2">{{ $invoiced }}</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 mb-4 stretch-card transparent">
                     <div class="card card-light-danger">
                        <div class="card-body">
                           <p class="mb-4">Canceled Orders</p>
                           <p class="fs-30 mb-2">{{ $canceled }}</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 mb-4 stretch-card transparent">
                     <div class="card card-dark-blue">
                        <div class="card-body">
                           <p class="mb-4">Total Orders</p>
                           <p class="fs-30 mb-2">{{ $total }}</p>
                        </div>
                     </div>
                  </div>
               @else
               <div class="row align-items-center form-control-panel form-filter">
                <form action="{{ url('orders') }}" method="POST" id="filter-form">
                    @csrf
                  <div class="col-12">
                      <h3>Control Panel</h3>
                  <h5 class="form-details">Order Search Form</h5>
                  </div>
                  <div class="col-lg-12 col-md-12 col-12">
                    <div class="form-group row mb-1">
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Date from:</p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-5">
                            <input type="date" class="form-control" name="start_date"/>
                        </div>
                        <div class="col-lg-2 col-md-2 col-2">
                            <p>To:</p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-5">
                            <input type="date" class="form-control" name="end_date"/>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-lg-4 col-md-4 col-12">
                           <select name="filter_by">
                              <option value="">--- Select a field ---</option>
                              <option value="order_id">Order ID</option>
                              <option value="ref_number">Ref.No</option>
                           </select>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12">
                        <input class="col-12" type="text" name="filter"/>
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-8 col-md-8 col-12 my-3 ">
                      <div class="form-check-btns">
                        <div class="form-checkbox">
                            <div class="row">
                               <div class="col-lg-4 col-md-4 col-4">
                                     <div class="form-group d-flex align-items-center mb-0">
                                        <input type="checkbox" name="status_id[]" class="status_id" value="1" />
                                        <label class="mb-0 ms-2">Draft</label>
                                     </div>
                               </div>
                               <div class="col-lg-4 col-md-4 col-4">
                                     <div class="form-group d-flex align-items-center mb-0">
                                        <input type="checkbox" name="status_id[]" class="status_id" value="2"  />
                                        <label class="mb-0 ms-2">Submitted</label>
                                     </div>
                               </div>
                               <div class="col-lg-4 col-md-4 col-4">
                                     <div class="form-group d-flex align-items-center mb-0">
                                        <input type="checkbox" name="status_id[]" class="status_id" value="3"  />
                                        <label class="mb-0 ms-2">Dispatched</label>
                                     </div>
                               </div>
                               <div class="col-lg-4 col-md-4 col-4">
                                     <div class="form-group d-flex align-items-center mb-0">
                                        <input type="checkbox" name="status_id[]" class="status_id" value="4"  />
                                        <label class="mb-0 ms-2">Delivered</label>
                                     </div>
                               </div>
                               <div class="col-lg-4 col-md-4 col-4">
                                     <div class="form-group d-flex align-items-center mb-0">
                                        <input type="checkbox" name="status_id[]" class="status_id" value="5"  />
                                        <label class="mb-0 ms-2">Invoiced</label>
                                     </div>
                               </div>
                               <div class="col-lg-4 col-md-4 col-4">
                                     <div class="form-group d-flex align-items-center mb-0">
                                        <input type="checkbox" name="status_id[]" class="status_id" value="6" />
                                        <label class="mb-0 ms-2">Canceled</label>
                                     </div>
                               </div>
                            </div>
                         </div>
                          <div class="btns">
                            <button type="submit" id="search-filter">Search</button>
                            <button type="button" id="clear-filter" class="mt-3">Cancel</button>
                          </div>
                      </div>
                  </div>
                </form>
              </div> 
             @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

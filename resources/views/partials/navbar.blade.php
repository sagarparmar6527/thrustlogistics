<div class="horizontal-menu">
   <nav class="navbar top-navbar col-lg-12 col-12 p-0">
      <div class="container">
         <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="{{url('/dashboard')}}"><img src="{{asset('admin/images/logo.png')}}" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="{{url('/dashboard')}}"><img src="{{asset('admin/images/logo.png')}}" alt="logo"/></a>
         </div>
         <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav navbar-nav-right">
               <li class="nav-item nav-profile dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                  <img src="{{asset('admin/images/faces/face28.jpg')}}" alt="profile"/>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                     {{-- <a class="dropdown-item">
                     <i class="ti-settings text-primary"></i>
                     Settings
                     </a> --}}
                     <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                     <i class="ti-power-off text-primary"></i>
                     Logout
                     </a>
                     <form method="POST" id="logout-form" action="{{ route('logout') }}">
                       @csrf                     
                    </form>
                  </div>
               </li>
               <li class="nav-item nav-settings d-none d-lg-flex">
                  <a class="nav-link" href="#">
                  <i class="icon-ellipsis"></i>
                  </a>
               </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
            <span class="ti-menu"></span>
            </button>
         </div>
      </div>
   </nav>
   <nav class="bottom-navbar">
      <div class="container">
         <ul class="nav page-navigation">
            <li class="nav-item">
               <a class="nav-link" href="{{url('/dashboard')}}">
               <i class="fa-solid fa-house-chimney me-1"></i>
               <span class="menu-title">Home</span>
               </a>
            </li>
            <li class="nav-item">
               <a href="#" class="nav-link">
               <i class="fa-solid fa-cart-shopping me-1"></i>
               <span class="menu-title">Orders</span>
               <i class="menu-arrow"></i></a>
               <div class="submenu">
                  <ul class="submenu-item">
                     <li class="nav-item"><a class="nav-link" href="{{ url('orders') }}">Manage Orders</a></li>
                  </ul>
               </div>
            </li>
            @if(Auth::user()->isEmployee())
               @if(Auth::user()->dataEntry() || Auth::user()->invoicing() || Auth::user()->manageUsers())
                  <li class="nav-item">
                     <a href="#" class="nav-link">
                     <i class="fa-solid fa-database me-1"></i>
                     <span class="menu-title">Database</span>
                     <i class="menu-arrow"></i></a>
                     <div class="submenu">
                        <ul class="submenu-item">
                           <li class="nav-item-customers" id="navcustomers">
                              <a class="nav-linkk" href="#">Customers <i class="menu-arrow ms-2"></i></a></a>
                              <div class="submenu-customers" id="sub-customer">
                                 <ul class="submenu-item-customers">
                                    <li><a class="dropdown-item" href="{{ url('customers') }}">All customers</a></li>
                                    @if(Auth::user()->manageUsers())
                                       <li><a class="dropdown-item" href="{{ url('web-access') }}">Web Access</a></li>
                                    @endif
                                    @if(Auth::user()->dataEntry())
                                       <li><a class="dropdown-item" href="{{ url('addressbooks') }}">Address Book</a></li>
                                    @endif
                                 </ul>
                              </div>
                           </li>
                           @if(Auth::user()->invoicing())
                              <li class="nav-item-customers" id="navpayables">
                                 <a class="nav-linkk" href="#">Payables <i class="menu-arrow ms-2"></i></a></a>
                                 <div class="submenu-customers" id="sub-customer">
                                    <ul class="submenu-item-customers">
                                       <li><a class="dropdown-item" href="{{ url('payables') }}">All Payables</a></li>
                                       <li><a class="dropdown-item" href="{{ url('categories') }}">Categories</a></li>
                                    </ul>
                                 </div>
                              </li>
                           @endif
                           @if(Auth::user()->manageUsers())
                              <li class="nav-item"><a class="nav-link" href="{{ url('employees') }}">Employees</a></li>
                              <li class="nav-item"><a class="nav-link" href="{{ url('orders/trash') }}">Trash Managers</a></li>
                           @endif
                        </ul>
                     </div>
                  </li>
                  @if(Auth::user()->invoicing())
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fa-solid fa-bag-shopping me-1"></i>
                        <span class="menu-title">Receivables</span>
                        <i class="menu-arrow"></i></a>
                        <div class="submenu">
                           <ul class="submenu-item">
                              <li class="nav-item"><a class="nav-link" href="{{ url('orders/delivered') }}">Not Invoiced Orders</a></li>
                              <li class="nav-item"><a class="nav-link" href="{{ url('invoices') }}">Manage Invoiced</a></li>
                              <li class="nav-item"><a class="nav-link" href="{{ url('payments/receivable') }}">All Receivable Payments Invoiced</a></li>
                              <li class="nav-item"><a class="nav-link" href="{{ url('invoices/credits') }}">All Credit Notes</a></li>
                              <li class="nav-item"><a class="nav-link" href="{{ url('reports/outstanding') }}">Outstanding Report</a></li>
                           </ul>
                        </div>
                     </li>
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fa-solid fa-gift me-1"></i>
                        <span class="menu-title">Payables</span>
                        <i class="menu-arrow"></i></a>
                        <div class="submenu">
                           <ul class="submenu-item">
                              <li class="nav-item"><a class="nav-link" href="{{ url('payments/carriers') }}">Sub Contracted Carriers</a></li>
                              <li class="nav-item"><a class="nav-link" href="{{ url('payments') }}">Manage Payments</a></li>
                              <li class="nav-item"><a class="nav-link" target="_Blank" href="{{ url('reports/payable-outstanding') }}">Outstanding Report</a></li>
                           </ul>
                        </div>
                     </li>
                  @endif
               @endif
               @if(Auth::user()->invoicing() || Auth::user()->manageUsers())
                  <li class="nav-item">
                     <a href="#" class="nav-link">
                     <i class="fa-solid fa-file-invoice me-1"></i>
                     <span class="menu-title">Reports</span>
                     <i class="menu-arrow"></i></a>
                     <div class="submenu">
                        <ul class="submenu-item">
                           <li class="nav-item"><a class="nav-link" href="{{ url('reports/load-manifest') }}">Load Manifest</a></li>
                           @if(Auth::user()->manageUsers())
                              <li class="nav-item"><a class="nav-link" href="{{ url('reports/sales') }}">Sales Report</a></li>
                              <li class="nav-item"><a class="nav-link" href="{{ url('reports/expense') }}">Expense Report</a></li>
                              <li class="nav-item"><a class="nav-link" target="_Blank" href="{{ url('reports/receivable-aging') }}">Receivable Aging Report</a></li>
                           @endif
                        </ul>
                     </div>
                  </li>
               @endif
            @else
               <li class="nav-item">
                  <a href="#" class="nav-link">
                  <i class="fa-solid fa-address-book me-1"></i>
                  <span class="menu-title">Address Book</span>
                  <i class="menu-arrow"></i></a>
                  <div class="submenu">
                     <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link" href="{{ url('addressbooks') }}">Manage Addresses</a></li>
                     </ul>
                  </div>
               </li>
               @if(Auth::user()->invoicing())
               <li class="nav-item">
                  <a href="#" class="nav-link">
                  <i class="fa-solid fa-receipt me-1"></i>
                  <span class="menu-title">Invoices</span>
                  <i class="menu-arrow"></i></a>
                  <div class="submenu">
                     <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link" href="{{ url('invoices') }}">Manage Invoices</a></li>
                     </ul>
                  </div>
               </li>
               @endif
               @if(Auth::user()->manageUsers())
                  <li class="nav-item">
                     <a href="#" class="nav-link">
                     <i class="fa-solid fa-users me-1"></i>
                     <span class="menu-title">Users</span>
                     <i class="menu-arrow"></i></a>
                     <div class="submenu">
                        <ul class="submenu-item">
                           <li class="nav-item"><a class="nav-link" href="{{ url('web-access') }}">Manage Users</a></li>
                        </ul>
                     </div>
                  </li>
               @endif
            @endif
         </ul>
      </div>
   </nav>
</div>
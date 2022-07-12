<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Thrustlogistics</title>
      <!-- plugins:css -->
      <link rel="stylesheet" href="{{asset('admin/vendors/feather/feather.css')}}">
      <link rel="stylesheet" href="{{asset('admin/vendors/ti-icons/css/themify-icons.css')}}">
      <link rel="stylesheet" href="{{asset('admin/vendors/css/vendor.bundle.base.css')}}">
      <!-- endinject -->
      <!-- Plugin css for this page -->
      <link rel="stylesheet" href="{{asset('admin/vendors/ti-icons/css/themify-icons.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin/js/select.dataTables.min.css')}}">
      <link rel="stylesheet" href="{{asset('admin/vendors/jquery-toast-plugin/jquery.toast.min.css')}}">
      <!-- End plugin css for this page -->
      <!-- inject:css -->
      <link rel="stylesheet" href="{{asset('admin/css/horizontal-layout-light/style.css')}}">
      <link rel="stylesheet" href="{{asset('admin/css/stylelogindash.css')}}">
      <!-- endinject -->
      <link rel="shortcut icon" href="{{asset('admin/images/favicon-1.png')}}" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
      @yield('styles')
      <style>
         label.error {color: red;font-weight: bold;}
      </style>
   </head>
   <body>
      <div class="container-scroller">
         @include('partials.navbar')
         <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
               @yield('content')
               @include('partials.footer')
            </div>
         </div>
      </div>
      <script>
         var ASSET_URL = '{{ asset('/') }}';
      </script>
      <!-- plugins:js -->
      <script src="{{asset('admin/vendors/js/vendor.bundle.base.js')}}"></script>
      <!-- endinject -->
      <!-- Plugin js for this page -->
      <script src="{{asset('admin/vendors/chart.js/Chart.min.js')}}"></script>
      <script src="{{asset('admin/vendors/jquery-toast-plugin/jquery.toast.min.js')}}"></script>
      <!-- End plugin js for this page -->
      <!-- inject:js -->
      <script src="{{asset('admin/js/off-canvas.js')}}"></script>
      <script src="{{asset('admin/js/hoverable-collapse.js')}}"></script>
      <script src="{{asset('admin/js/template.js')}}"></script>
      <script src="{{asset('admin/js/settings.js')}}"></script>
      <script src="{{asset('admin/js/todolist.js')}}"></script>
      <!-- endinject -->
      <!-- Custom js for this page-->
      <script src="{{asset('admin/js/jquery.cookie.js')}}" type="text/javascript"></script>
      <script src="{{asset('admin/js/dashboard.js')}}"></script>
      <script src="{{asset('admin/js/todolist.js')}}"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
      <!-- End custom js for this page-->
      <!--New js files for datatable ---------------------------------->
      @yield('js')
      <script>
         // $("#navcustomers").click(function(){
         //    $("#sub-customer").toggleClass("showmenu");
         // });
      </script>
   </body>
</html>
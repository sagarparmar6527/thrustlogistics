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
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('admin/css/horizontal-layout-light/style.css')}}">
  <link rel="stylesheet" href="{{asset('admin/css/horizontal-layout-light/stylelogindash.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('admin/images/favico-01.png')}}" />
  <link rel="stylesheet" href="{{asset('admin/css/stylelogindash.css')}}">
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="main-panel">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                  <img src="{{asset('admin/images/logo.png')}}" alt="logo">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4 text-danger mt-3" :errors="$errors" />

                <form method="POST" class="mt-4" action="{{ route('login') }}">
                  @csrf

                  <!-- Username -->
                  <div>
                    <x-label for="username" :value="__('Username')" />

                    <x-input id="username" class="block mt-1 w-full form-control form-control-lg" type="text" name="username" :value="old('username')" required autofocus />
                  </div>

                  <!-- Password -->
                  <div class="mt-4">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" class="block mt-1 w-full form-control form-control-lg"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                  </div>

                  <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                            {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                              </a> --}}
                    @endif

                    <x-button class="ml-3 btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                      {{ __('Log in') }}
                    </x-button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{asset('admin/vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('admin/js/off-canvas.js')}}"></script>
  <script src="{{asset('admin/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('admin/js/template.js')}}"></script>
  <script src="{{asset('admin/js/settings.js')}}"></script>
  <script src="{{asset('admin/js/todolist.js')}}"></script>
  <!-- endinject -->
</body>

</html>

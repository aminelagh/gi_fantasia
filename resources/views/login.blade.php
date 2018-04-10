<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
  <title>Authentification</title>
  <!-- Bootstrap Core CSS -->
  <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="css/helper.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <!-- Toastr -->
  <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">

</head>

<body class="fix-header fix-sidebar">
  <!-- Preloader - style you can find in spinners.css -->
  <div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">

      <div class="unix-login">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-lg-4">
              <div class="login-content card">
                <div class="login-form">
                  <h4>Authentification</h4>
                  <form method="POST" action="{{ route('submitLogin') }}">
                    @csrf
                    <div class="form-group">
                      <label>Login</label>
                      <input type="text" class="form-control" placeholder="Login" value="{{ old('login') }}" name="login" required>
                    </div>
                    <div class="form-group">
                      <label>Mot de passe</label>
                      <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Se connecter</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>		-->
    <!-- slimscrollbar scrollbar JavaScript
    <script src="js/jquery.slimscroll.js"></script>		-->
    <!--Menu sidebar
    <script src="js/sidebarmenu.js"></script>		-->
    <!--stickey kit
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>		-->
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!--Toastr -->
    <script src="js/lib/toastr/toastr.min.js"></script>
    <script src="js/lib/toastr/toastr.init.js"></script>

    <script>
    var options = {
      "closeButton": true, "debug": false, "newestOnTop": true, "progressBar": true, "positionClass": "toast-top-center",
      "preventDuplicates": false, "showDuration": "0", "hideDuration": "1000", "timeOut": "0", "extendedTimeOut": "1000",
      "showEasing": "swing", "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut"
    };
    {{-- ********************************************************************** --}}
    {{-- alert info --}}
    @if(session('alert_info'))
    toastr.info("{!! session('alert_info') !!}",'', options );
    @elseif(isset($alert_info))
    toastr.info("{!! $alert_info !!}",'', options );
    @endif
    {{-- /.alert info --}}
    {{-- ********************************************************************** --}}
    {{-- alert success --}}
    @if(session('alert_success'))
    toastr.success("{!! session('alert_success') !!}",'', options );
    @elseif(isset($alert_success))
    toastr.success("{!! $alert_success !!}",'', options );
    @endif
    {{-- /.alert success --}}
    {{-- ********************************************************************** --}}
    {{-- alert warning --}}
    @if(session('alert_warning'))
    toastr.warning("{!! session('alert_warning') !!}",'', options );
    @elseif(isset($alert_warning))
    toastr.warning("{!! $alert_warning !!}",'', options );
    @endif
    {{-- /.alert warning --}}
    {{-- ********************************************************************** --}}
    {{-- alert danger --}}
    @if(session('alert_danger'))
    toastr.error("{!! session('alert_danger') !!}",'', options );
    @elseif(isset($alert_danger))
    toastr.error("{!! $alert_danger !!}",'', options );
    @endif
    {{-- /.alert danger --}}
    {{-- ********************************************************************** --}}
  </script>

  </body>

  </html>

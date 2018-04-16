<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <!--IE Compatibility modes-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--Mobile first-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Authentification</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="public/assets/lib/bootstrap/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <!-- Metis core stylesheet -->
  <link rel="stylesheet" href="public/assets/css/main.css">
  <!-- metisMenu stylesheet -->
  <link rel="stylesheet" href="public/assets/lib/metismenu/metisMenu.css">
  <!-- onoffcanvas stylesheet -->
  <link rel="stylesheet" href="public/assets/lib/onoffcanvas/onoffcanvas.css">
  <!-- animate.css stylesheet -->
  <link rel="stylesheet" href="public/assets/lib/animate.css/animate.css">
  <!-- Toastr -->
  <link href="public/css/lib/toastr/toastr.min.css" rel="stylesheet">
</head>

<body class="login">

  <div class="form-signin">
    <div class="text-center">
      <h2>Gestion d'inventaire</h2>
    </div>
    <hr>
    <div class="tab-content">
      <div id="login" class="tab-pane active">
        <form action="{{ route('submitLogin') }}" method="POST">
          @csrf
          <p class="text-muted text-center">
            Enter your username and password
          </p>
          <input type="text" name="login" placeholder="Login" class="form-control top" required>
          <input type="password" name="password" placeholder="Password" class="form-control bottom" required>
          <hr>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
      </div>


    </div>

  </div>

  <!--jQuery -->
  <script src="public/assets/lib/jquery/jquery.js"></script>
  <!--Bootstrap -->
  <script src="public/assets/lib/bootstrap/js/bootstrap.js"></script>
  <script src="public/js/lib/jquery/jquery.min.js"></script>
  <script src="public/js/custom.min.js"></script>
  <!--Toastr -->
  <script src="public/js/lib/toastr/toastr.min.js"></script>
  <script src="public/js/lib/toastr/toastr.init.js"></script>

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

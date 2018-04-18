<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <!--IE Compatibility modes-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--Mobile first-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>{{ $title or 'Inventaire' }}</title>

  <meta name="author" content="Amine Laghlabi">

  <meta name="msapplication-TileColor" content="#5bc0de" />
  <meta name="msapplication-TileImage" content="public/assets/img/metis-tile.png" />
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
  <!-- Switcher -->
  <link rel="stylesheet" href="public/assets/css/style-switcher.css">
  <link rel="stylesheet/less" type="text/css" href="public/assets/less/theme.less">
  <script src="public/assets/less/less.js"></script>
  <!-- Toastr -->
  <link href="public/css/lib/toastr/toastr.min.css" rel="stylesheet">
  <script src="public/assets/less/less.js"></script>
  <!-- Bootstrap-Select -->
  <link rel="stylesheet" href="public/bootstrap-select/bootstrap-select.min.css">
  @yield('styles')

  <!--For Development Only. Not required -->
  <script>
  less = {
    env: "development",
    relativeUrls: false,
    rootpath: "/assets/"
  };
  </script>
</head>

<body class="">
  <div class="bg-dark dk" id="wrap">

    <div id="top">

      <!-- .navbar -->
      <nav class="navbar navbar-inverse navbar-static-top">

        <!-- top menu -->
        <div class="container-fluid">

          <!-- Brand and toggle get grouped for better mobile display -->
          <header class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="{{ route('admin') }}" class="navbar-brand"><img src="public/assets/img/logo.png" alt="Admin"></a>
          </header>


          <!--  top right menu  -->
          @include('admin.layouts.top_right_menu')
          <!--  end top right menu -->

          <!--  top left menu  -->
          @include('admin.layouts.top_left_menu')
          <!--  end top left menu -->

        </div>
        <!-- end top menu -->
      </nav>
      <!-- /.navbar -->

      <!-- /.head -->

    </div>
    <!-- /#top -->

    <!--  menu left -->
    {{-- @include('admin.layouts.menu_2') --}}
    <!-- end menu left -->




    <!-- content -->
    <div id="content">
      <!-- outer -->
      <div class="outer">
        @yield('content-head')
        <!-- inner -->
        <div class="inner bg-light lter">

          @yield('content')

        </div>
        <!-- end inner -->
      </div>
      <!-- end outer -->
    </div>
    <!-- /#content -->





    <!--  right well menu -->
    <div id="right_well_menu" class="onoffcanvas is-right is-fixed bg-light" aria-expanded=false>
      <a class="onoffcanvas-toggler" href="#right" data-toggle=onoffcanvas aria-expanded=false></a>
      <br>
      <br>
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Warning!</strong> Best check yo self, you're not looking too good.
      </div>
      <!-- .well well-small -->
      <div class="well well-small dark">
        <ul class="list-unstyled">
          <li>Visitor <span class="inlinesparkline pull-right">1,4,4,7,5,9,10</span></li>
          <li>Online Visitor <span class="dynamicsparkline pull-right">Loading..</span></li>
          <li>Popularity <span class="dynamicbar pull-right">Loading..</span></li>
          <li>New Users <span class="inlinebar pull-right">1,3,4,5,3,5</span></li>
        </ul>
      </div>
    </div>
    <!-- /. right well menu -->

  </div>

  @yield('modals')

  <!-- /#footer -->
  <footer class="Footer bg-dark dker"><p>2018 &copy; <a href="mailto: amine.laghlabi@gmail.com">Amine Laghlabi</a> <i>version 1.0</i></p></footer>
  <!-- /#footer -->


  <!--jQuery -->
  <script src="public/assets/lib/jquery/jquery.js"></script>
  <!--Bootstrap -->
  <script src="public/assets/lib/bootstrap/js/bootstrap.js"></script>
  <!-- MetisMenu -->
  <script src="public/assets/lib/metismenu/metisMenu.js"></script>
  <!-- onoffcanvas -->
  <script src="public/assets/lib/onoffcanvas/onoffcanvas.js"></script>
  <!-- Screenfull -->
  <script src="public/assets/lib/screenfull/screenfull.js"></script>
  <!-- Metis core scripts -->
  <script src="public/assets/js/core.js"></script>
  <!-- Metis demo scripts -->
  <script src="public/assets/js/app.js"></script>
  <!-- switcher -->
  <script src="public/assets/js/style-switcher.js"></script>
  <!--Toastr -->
  <script src="public/js/lib/toastr/toastr.min.js"></script>
  <script src="public/js/lib/toastr/toastr.init.js"></script>
  <!-- Bootstrap-Select -->
  <script src="public/bootstrap-select/bootstrap-select.min.js"></script>

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

@yield('scripts')
</body>

</html>

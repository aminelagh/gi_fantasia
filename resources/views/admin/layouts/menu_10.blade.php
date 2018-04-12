<div class="header">

  <nav class="navbar top-navbar navbar-expand-md navbar-light">
    <!-- Logo -->
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('admin') }}"><b>Administrateur</b></a>
    </div>
    <!-- End Logo -->
    <div class="navbar-collapse">

      <!-- toggle and nav items -->
      <ul class="navbar-nav mr-auto mt-md-0">

        <!-- This is  -->
        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

        <!-- Search -->
        <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-search"></i></a>
          <form class="app-search">
            <input type="text" class="form-control" placeholder="Search here"> <a class="srh-btn"><i class="ti-close"></i></a>
          </form>
        </li>

        <!-- Language -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
          <div class="dropdown-menu animated zoomIn">
            <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-ca"></i> Canada</a>
            <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
            <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a>
            <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a>
          </div>
        </li>

        <!-- Messages -->
        <li class="nav-item dropdown mega-dropdown">
          <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-th-large"></i>
          </a>
          <div class="dropdown-menu animated zoomIn">
            <ul class="mega-dropdown-menu row">
              <li class="col-lg-3">
                <h4 class="m-b-20">Contacter l'adinistrateur</h4>
                <!-- Contact -->
                <form method="POST" action="">
                  <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputname1" placeholder="Votre nom">
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                  </div>
                  <button type="submit" class="btn btn-info">Submit</button>
                </form>
              </li>
            </ul>
          </div>
        </li>
        <!-- End Messages -->

      </ul>

      <!-- User profile and search -->
      <ul class="navbar-nav my-lg-0">

        <!-- Comment -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>
            <div class="notify"> <span class="heartbit"></span><span class="point"></span></div>
          </a>

          <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
            <ul>
              <li>
                <div class="drop-title">Notifications</div>
              </li>
              <li>
                <div class="message-center">
                  <!-- Message -->
                  <a href="#">
                    <div class="btn btn-info btn-circle m-r-10"><i class="ti-settings"></i></div>
                    <div class="mail-contnet">
                      <h5>This is title</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span>
                    </div>
                  </a>
                </div>
              </li>
              <li>
                <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
              </li>
            </ul>
          </div>
        </li>
        <!-- End Comment -->

        <!-- Messages -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted  " href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn" aria-labelledby="2">
            <ul>
              <li>
                <div class="drop-title">You have 4 new messages</div>
              </li>
              <li>
                <div class="message-center">
                  <!-- Message -->
                  <a href="#">
                    <div class="user-img"> <img src="images/users/5.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                    <div class="mail-contnet">
                      <h5>Michael Qin</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span>
                    </div>
                  </a>
                </div>
              </li>
              <li>
                <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
              </li>
            </ul>
          </div>
        </li>
        <!-- End Messages -->

        <!-- Profile -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/users/5.jpg" alt="user" class="profile-pic" /></a>
          <div class="dropdown-menu dropdown-menu-right animated zoomIn">
            <ul class="dropdown-user">
              <li><a href="#"><i class="ti-user"></i> Profile</a></li>
              <li><a href="#"><i class="ti-wallet"></i> Balance</a></li>
              <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#"><i class="ti-settings"></i> Setting</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
          </div>
        </li>
        <!-- End Profile -->

      </ul>

    </div>
  </nav>
</div>
<!-- End header header -->

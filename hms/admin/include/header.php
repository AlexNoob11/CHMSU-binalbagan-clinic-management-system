<header class="navbar navbar-default navbar-static-top" style="z-index: 1050;">
    <div class="navbar-header">
        <a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
            <i class="ti-align-justify"></i>
        </a>
        <a class="navbar-brand" href="dashboard.php">
            <h2 style="padding-top:10%; font-size:24px; font-weight:bold; margin:0;">MEDICAL STAFF</h2>
        </a>
        <a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
            <i class="ti-align-justify"></i>
        </a>
        <a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="ti-view-grid"></i>
        </a>
    </div>
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-right" style="display: flex; align-items: center; margin-right: 0; padding-right: 15px; height: 65px;">
            <li class="hidden-xs hidden-sm" style="display: inline-flex; align-items: center; margin-right: 25px;">
                <img src="include/CHMSUWeb.jpg" alt="Logo" style="height: 40px; margin-right: 10px; border-radius: 50%; object-fit: cover;">
                <div style="display: flex; flex-direction: column;">
                    <h2 style="margin: 0; font-size: 20px; font-weight: bold; color: #2c3e50; line-height: 1.2;">CHMSU Binalbagan Clinic Management System</h2>
                    <span style="color: #777; font-size: 12px; font-weight: 500;">Medical Staff Administration Panel</span>
                </div>
            </li>
            <li class="dropdown current-user" style="position: relative; z-index: 9999;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 15px 5px; display: flex; align-items: center; gap: 8px;">
                    <img src="assets/images/images.jpg" alt="User Image" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1;">
                    <span class="username" style="color: black; font-weight: 600; font-size: 14px;">Staff</span>
                    <i class="ti-angle-down" style="color: black; font-size: 10px;"></i>
                </a>
                <ul class="dropdown-menu dropdown-dark pull-right" style="background-color: #2c3e50; right: 0; left: auto; min-width: 160px;">
                    <li><a href="change-password.php" style="color: white; padding: 10px 20px; display: block;">Change Password</a></li>
                    <li class="divider" style="height: 1px; margin: 5px 0; background-color: #34495e;"></li>
                    <li><a href="logout.php" style="color: white; font-weight: bold; padding: 10px 20px; display: block;">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>
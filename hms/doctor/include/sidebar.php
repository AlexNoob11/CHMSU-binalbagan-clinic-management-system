<div class="sidebar app-aside" id="sidebar">
    <div class="sidebar-container perfect-scrollbar" style="background-color: #1e3a8a !important;">
        <nav>
            <!-- Start: MAIN NAVIGATION HEADER -->
            <div class="navbar-title" style="background: rgba(0,0,0,0.1); padding: 15px 20px;">
                <span style="color: #d9e8ff !important; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">Main Navigation</span>
            </div>
            
            <!-- Start: CORE NAV MENU ITEMS -->
            <ul class="main-navigation-menu">
                <!-- Dashboard -->
                <li>
                    <a href="dashboard.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-home"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Dashboard </span>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Medical Appointment History -->
                <li>
                    <a href="appointment-history.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-file"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Medical Appointment </span>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Patient Feedback Modules -->
                <li>
                    <a href="feedback.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-file"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Patient Feedback </span>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Patients Sub-menu Navigation -->
                <li>
                    <a href="javascript:void(0)">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-user"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Patients </span><i class="icon-arrow"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="manage-patient.php">
                                <span class="title"> Manage Patient </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Search Registries -->
                <li>
                    <a href="search.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-search"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Search </span>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- End: CORE NAV MENU ITEMS -->
        </nav>
    </div>
</div>

<!-- Custom Design Overrides Matching Master Sidebar Aesthetics -->
<style>
    .sidebar-container { 
        background-color: #1e3a8a !important; 
    }
    .main-navigation-menu li a { 
        color: #ffffff !important; 
        transition: background-color 0.25s ease;
    }
    .main-navigation-menu li a:hover { 
        background-color: #0056b3 !important; 
        text-decoration: none;
    }
    .sub-menu { 
        background-color: #162e70 !important; 
    }
    .sub-menu li a { 
        color: #e2e8f0 !important; 
    }
    .sub-menu li a:hover {
        background-color: #1d3b87 !important;
        color: #ffffff !important;
    }
</style>
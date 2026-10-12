<div class="sidebar app-aside" id="sidebar">
    <div class="sidebar-container perfect-scrollbar" style="background-color: #1e3a8a !important;">
        <nav>
            <div class="navbar-title" style="background: rgba(0,0,0,0.1); padding: 15px 20px;">
                <span style="color: #d9e8ff !important; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">Main Navigation</span>
            </div>
            <ul class="main-navigation-menu">
                <li>
                    <a href="dashboard.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Dashboard </span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="book-appointment.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Medical Assessment </span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="medical-history.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="fas fa-history"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Medical Assessment History </span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="referral.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Referral </span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="feedback.php">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="fas fa-notes-medical"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Feedback </span>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
            </nav>
    </div>
</div>

<style>
    /* Safe style overrides that do not block JS selection bindings */
    .sidebar-container { 
        background-color: #1e3a8a !important; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .main-navigation-menu li a { 
        color: #ffffff !important; 
        border-radius: 6px;
        transition: background 0.2s ease;
    }
    .main-navigation-menu li a:hover { 
        background-color: #0056b3 !important; 
        color: #d9e8ff !important;
    }
    .main-navigation-menu li.active > a {
        background-color: #007bff !important;
        font-weight: bold !important;
        color: #ffd700 !important;
    }
    
    /* Scrollbar overrides */
    .perfect-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #0056b3 #003f8a;
    }
    .perfect-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    .perfect-scrollbar::-webkit-scrollbar-track {
        background: #003f8a;
    }
    .perfect-scrollbar::-webkit-scrollbar-thumb {
        background-color: #0056b3;
        border-radius: 8px;
    }
</style>
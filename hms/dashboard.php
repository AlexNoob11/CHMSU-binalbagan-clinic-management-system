<?php
// Start the session
session_start();

// Include the database configuration
include("include/config.php");

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login-user.php");
    exit();
}

// Fetch safe real-time metrics for this specific user
$current_user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);

$user_appointments_query = mysqli_query($con, "SELECT id FROM appointments WHERE userId = '$current_user_id'");
$my_total_appointments = mysqli_num_rows($user_appointments_query);

$upcoming_query = mysqli_query($con, "SELECT check_up_date, check_up_time FROM appointments WHERE userId = '$current_user_id' AND check_up_date >= CURDATE() ORDER BY check_up_date ASC LIMIT 1");
$upcoming_row = mysqli_fetch_array($upcoming_query);
$next_schedule = ($upcoming_row) ? $upcoming_row['check_up_date'] . ' @ ' . $upcoming_row['check_up_time'] : 'No upcoming schedule';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Dashboard</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

    <style>
        body { font-family: 'Raleway', sans-serif; background-color: #f8fafc; }
        .mainTitle { font-weight: 700; color: #1e293b; }
        
        .main-content {
            padding-top: 15px;
        }

        /* Modernized Interactive Metric Display Cards */
        .analytics-card { 
            background: #ffffff; 
            border-radius: 12px; 
            padding: 30px 20px; 
            margin-bottom: 25px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
            border: 1px solid #e2e8f0; 
            transition: all 0.25s ease-in-out; 
        }
        
        .analytics-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 12px 20px -5px rgba(30, 58, 138, 0.15); 
            border-color: #1e3a8a;
        }

        .card-icon-box { 
            width: 54px; 
            height: 54px; 
            background-color: #f0f4ff; 
            color: #1e3a8a; 
            border-radius: 10px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 22px; 
            margin: 0 auto 15px;
            transition: all 0.2s;
        }
        
        .analytics-card:hover .card-icon-box {
            background-color: #1e3a8a;
            color: #ffffff;
        }

        .analytics-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .analytics-card p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 20px;
            min-height: 38px;
            line-height: 1.5;
        }

        .action-link-btn { 
            font-size: 12px; 
            font-weight: 600; 
            color: #1e3a8a; 
            text-decoration: none; 
            display: inline-block; 
            padding: 6px 16px; 
            background-color: #eff6ff; 
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .action-link-btn:hover {
            background-color: #1e3a8a;
            color: #ffffff;
            text-decoration: none;
        }

        /* Profile Insights Panel Box Layout */
        .summary-panel {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            margin-top: 5px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
        }
        .summary-header {
            font-size: 15px;
            font-weight: 700;
            color: #1e3a8a;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .log-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f8fafc;
            font-size: 13px;
        }
        .log-row span:first-child { color: #64748b; font-weight: 500; }
        .log-row span:last-child { color: #1e293b; font-weight: 600; }
    </style>
</head>
<body>
<div id="app">        
    <?php include('include/sidebar.php'); ?>
    <div class="app-content">
        <?php include('include/header.php'); ?>

        <div class="main-content">
            <div class="wrap-content container" id="container">
                
                <!-- start: PAGE TITLE -->
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Dashboard Overview</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>User</span></li>
                            <li class="active"><span>Dashboard</span></li>
                        </ol>
                    </div>
                </section>
                <!-- end: PAGE TITLE -->

                <!-- start: CARDS WRAPPER GRID -->
                <div class="container-fluid container-fullw p-0">
                    <div class="row">
                        
                        <!-- Profile Card -->
                        <div class="col-sm-4">
                            <div class="analytics-card text-center">
                                <div class="card-icon-box">
                                    <i class="fa fa-user-md"></i>
                                </div>
                                <h3>My Profile</h3>
                                <p>Manage your account settings, contact information, and personal configuration details safely.</p>
                                <a href="edit-profile.php" class="action-link-btn">
                                    Update Profile <i class="fa fa-arrow-right" style="margin-left: 5px; font-size: 10px;"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- History Log Card -->
                        <div class="col-sm-4">
                            <div class="analytics-card text-center">
                                <div class="card-icon-box">
                                    <i class="fa fa-calendar-check-o"></i>
                                </div>
                                <h3>My Appointments</h3>
                                <p>Track pending active slots, check status verifications, or view archived medical checks.</p>
                                <a href="medical-history.php" class="action-link-btn">
                                    View History <i class="fa fa-arrow-right" style="margin-left: 5px; font-size: 10px;"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Booking Operations Card -->
                        <div class="col-sm-4">
                            <div class="analytics-card text-center">
                                <div class="card-icon-box">
                                    <i class="fa fa-file-text-o"></i>
                                </div>
                                <h3>Book Appointment</h3>
                                <p>Fill up medical assessment documents and request a structural check-up appointment slot.</p>
                                <a href="book-appointment.php" class="action-link-btn">
                                    Book Now <i class="fa fa-arrow-right" style="margin-left: 5px; font-size: 10px;"></i>
                                </a>
                            </div>
                        </div>
                        
                    </div>

                    <!-- Personal Metrics Footprint Summary Logs -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="summary-panel">
                                <div class="summary-header"><i class="fa fa-id-card-o"></i> Personal Account Activity Summary</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="log-row"><span>Total Clinic Encounters Registered</span><span><?php echo $my_total_appointments; ?></span></div>
                                        <div class="log-row"><span>Account Access Validation</span><span>Verified</span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="log-row"><span>Next Slotted Evaluation Date</span><span><?php echo htmlspecialchars($next_schedule); ?></span></div>
                                        <div class="log-row"><span>Current Session Date</span><span><?php echo date('Y-m-d'); ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end: CARDS WRAPPER GRID -->
                
            </div>
        </div>
        <?php include('include/footer.php'); ?>
        <?php include('include/setting.php'); ?>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/autosize/autosize.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/form-elements.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
</body>
</html>
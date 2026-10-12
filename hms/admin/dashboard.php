<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Fetch metrics safely for advanced analytics tracking
$total_users = mysqli_num_rows(mysqli_query($con, "SELECT id FROM users"));
$total_doctors = mysqli_num_rows(mysqli_query($con, "SELECT id FROM doctors"));
$total_appointments = mysqli_num_rows(mysqli_query($con, "SELECT id FROM appointments"));

// Advanced analytical statuses splits
$total_pending = mysqli_num_rows(mysqli_query($con, "SELECT id FROM appointments WHERE status IS NULL OR status = '' OR status = 'Pending'"));
$total_completed = mysqli_num_rows(mysqli_query($con, "SELECT id FROM appointments WHERE status = 'Completed'"));
$total_schedules = mysqli_num_rows(mysqli_query($con, "SELECT id FROM appointments WHERE check_up_date IS NOT NULL AND check_up_date >= CURDATE()"));

// Safe ratio calculations to prevent division by zero anomalies
$max_scale = max($total_users, $total_doctors, $total_appointments, $total_pending, $total_completed, $total_schedules, 1);
$user_pct = round(($total_users / $max_scale) * 100);
$doc_pct = round(($total_doctors / $max_scale) * 100);
$app_pct = round(($total_appointments / $max_scale) * 100);
$pend_pct = round(($total_pending / $max_scale) * 100);
$comp_pct = round(($total_completed / $max_scale) * 100);
$sched_pct = round(($total_schedules / $max_scale) * 100);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medical Staff | Analytics Dashboard</title>
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
        
        /* Analytics Structural headers */
        .section-analytics-header {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            color: #475569;
            margin: 10px 0 20px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
        }
        .section-analytics-header i {
            margin-right: 8px;
            color: #1e3a8a;
        }
        
        /* Analytics Structure styling cards */
        .analytics-card { 
            background: #ffffff; 
            border-radius: 12px; 
            padding: 20px 16px; 
            margin-bottom: 25px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
            border: 1px solid #e2e8f0; 
            transition: all 0.25s ease-in-out; 
            text-align: left;
        }
        .analytics-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 12px 20px -5px rgba(30, 58, 138, 0.15); 
        }
        .card-header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .card-icon-box { 
            width: 42px; 
            height: 42px; 
            background-color: #f0f4ff; 
            color: #1e3a8a; 
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 18px; 
        }
        /* Status Theme Accent Overrides */
        .card-icon-pending { background-color: #fffbeb; color: #d97706; }
        .card-icon-completed { background-color: #f0fdf4; color: #16a34a; }
        .card-icon-scheduled { background-color: #fdf2f8; color: #db2777; }

        .analytics-card h3 { 
            font-size: 11px; 
            font-weight: 700; 
            color: #64748b; 
            margin: 0; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }
        .metric-number {
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
            margin: 4px 0;
        }
        .metric-trend {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Analytical components style mapping */
        .progress-dim {
            background-color: #f1f5f9;
            height: 5px;
            border-radius: 4px;
            margin-bottom: 12px;
            overflow: hidden;
        }
        .progress-bar-custom {
            background-color: #1e3a8a;
            height: 100%;
            border-radius: 4px;
        }
        .progress-bar-pending { background-color: #d97706; }
        .progress-bar-completed { background-color: #16a34a; }
        .progress-bar-scheduled { background-color: #db2777; }

        .action-link-btn { 
            font-size: 11px; 
            font-weight: 600; 
            color: #1e3a8a; 
            text-decoration: none; 
            display: inline-block; 
            padding: 4px 10px; 
            background-color: #eff6ff; 
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .action-link-btn:hover {
            background-color: #1e3a8a;
            color: #ffffff;
            text-decoration: none;
        }
        
        /* Secondary Analysis Logger styling */
        .summary-panel {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            margin-top: 5px;
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
                    <section id="page-title" style="padding: 15px 0;">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Staff Operations Command</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Workspace</span></li>
                                <li class="active"><span>Analytics Dashboard</span></li>
                            </ol>
                        </div>
                    </section>
                    
                    <div class="container-fluid container-fullw p-0">
                        
                        <!-- Core Master Directories Header -->
                        <div class="section-analytics-header"><i class="fa fa-folder-open"></i> Master Registries Overview</div>

                        <!-- Primary System Volume Cards -->
                        <div class="row">
                            <!-- Users Analytics Module -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Registered Patients</h3>
                                        <div class="card-icon-box"><i class="fa fa-user-circle-o"></i></div>
                                    </div>
                                    <div class="metric-number"><?php echo $total_users; ?></div>
                                    <div class="metric-trend">Active profiles verified within registry</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom" style="width: <?php echo $user_pct; ?>%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="manage-users.php" class="action-link-btn">View Registry <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Doctors Analytics Module -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Medical Consultants</h3>
                                        <div class="card-icon-box"><i class="fa fa-user-md"></i></div>
                                    </div>
                                    <div class="metric-number"><?php echo $total_doctors; ?></div>
                                    <div class="metric-trend">On-duty medical practitioners</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom" style="width: <?php echo $doc_pct; ?>%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="Manage-doctors.php" class="action-link-btn">Manage Staff <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Appointments Analytics Module -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Total Admissions</h3>
                                        <div class="card-icon-box"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="metric-number"><?php echo $total_appointments; ?></div>
                                    <div class="metric-trend">Total clinical check-up entries</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom" style="width: <?php echo $app_pct; ?>%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="appointment-history.php" class="action-link-btn">Open Ledger <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- NEW: Appointments Breakdown Analytics Card Header Section -->
                        <div class="section-analytics-header"><i class="fa fa-calendar-check-o"></i> Appointment Status Breakdown</div>

                        <!-- Operational Status Sub-Row Headers -->
                        <div class="row">
                            <!-- Pending Triage Card -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Pending Check-ups</h3>
                                        <div class="card-icon-box card-icon-pending"><i class="fa fa-clock-o"></i></div>
                                    </div>
                                    <div class="metric-number"><?php echo $total_pending; ?></div>
                                    <div class="metric-trend">Awaiting validation / scheduling</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom progress-bar-pending" style="width: <?php echo $pend_pct; ?>%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="appointment-history.php" class="action-link-btn" style="color:#d97706; background-color:#fffbeb;">Review Queue <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Completed Clinical Records Card -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Completed Profiles</h3>
                                        <div class="card-icon-box card-icon-completed"><i class="fa fa-check-square-o"></i></div>
                                    </div>
                                    <div class="metric-number"><?php echo $total_completed; ?></div>
                                    <div class="metric-trend">Medical histories successfully archived</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom progress-bar-completed" style="width: <?php echo $comp_pct; ?>%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="manage-patient.php" class="action-link-btn" style="color:#16a34a; background-color:#f0fdf4;">View Archive <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Calendar Events Card -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Scheduled Actions</h3>
                                        <div class="card-icon-box card-icon-scheduled"><i class="fa fa-calendar-check-o"></i></div>
                                    </div>
                                    <div class="metric-number"><?php echo $total_schedules; ?></div>
                                    <div class="metric-trend">Active timelines assigned for visits</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom progress-bar-scheduled" style="width: <?php echo $sched_pct; ?>%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="appointment-history.php" class="action-link-btn" style="color:#db2777; background-color:#fdf2f8;">View Calendar <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Footprint Breakdown Summary -->
                        <div class="row margin-top-10">
                            <div class="col-md-12">
                                <div class="summary-panel">
                                    <div class="summary-header"><i class="fa fa-bar-chart"></i> System Resource Performance Summary</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="log-row"><span>Clinic Operations Footprint</span><span>Active</span></div>
                                            <div class="log-row"><span>Data Verification Engine</span><span>Active / Stable</span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="log-row"><span>Consultant Allocation Distribution Ratio</span><span><?php echo $total_doctors . ' : ' . $total_users; ?></span></div>
                                            <div class="log-row"><span>Server Metric Timestamp</span><span><?php echo date('Y-m-d H:i'); ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php include('include/footer.php'); ?>
        <?php include('include/setting.php'); ?>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
        });
    </script>
</body>
</html>